<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class AuthenticationController extends Controller
{
    public function loginPage(Request $request){
        return Inertia::render('Login');
    }

    public function login(Request $request){
        $username = $request->username;
        $password = $request->password;

        $ldap = $this->ldapZimbraAuth($username, $password);

        if ($ldap) {
            foreach ($ldap['mail'] as $mail) {
                $user_name = explode('@', $mail)[0];
                $user = User::where('npk', $user_name)->first();
                if ($user) {
                    if($user->is_active){
                        Auth::login($user);
                        return redirect()->intended(RouteServiceProvider::HOME);
                    }
                }
            }
        }

        if (Auth::attempt(['npk' => $username, 'password' => $password, 'is_active' => 1]))
        {
            return redirect()->intended(RouteServiceProvider::HOME);
        } else {
            return redirect()->back()->withErrors([
                'msg' => 'Incorrect Username or Password !'
            ]);
        }
    }
    
    private function ldapZimbraAuth($username, $pass){
        $ldap['host'] = env('LDAP_HOST');
        $ldap['port'] = env('LDAP_PORT');
        $ldap['dn'] = env('LDAP_DN');
        $ldap['pass'] = env('LDAP_PASS');
        $ldap['tree'] = env('LDAP_TREE');

        $ldap['conn'] = ldap_connect($ldap['host'], $ldap['port']);
        ldap_set_option($ldap['conn'], LDAP_OPT_PROTOCOL_VERSION, 3);
        ldap_set_option($ldap['conn'], LDAP_OPT_REFERRALS, 0);

        $ldap['bind'] = @ldap_bind($ldap['conn'], $ldap['dn'], $ldap['pass']);
        if ($ldap['bind']) {
            $username = strpos($username, '@pupukkaltim.com') ? $username : $username.'@pupukkaltim.com';

            $search_filter = "(mail=" . $username . ")";
            $result = @ldap_search($ldap['conn'],  $ldap['tree'], $search_filter, array('displayname', 'mail', 'uid', 'ou', 'sn', 'givenname'));
            $first_entry = @ldap_first_entry($ldap['conn'], $result);

            if ($first_entry) {
                $user_dn = @ldap_get_dn($ldap['conn'], $first_entry);
                $user_attributes = @ldap_get_attributes($ldap['conn'], $first_entry);
                if ($user_dn) {
                    $bind_login_user = @ldap_bind($ldap['conn'], $user_dn, $pass);
                    if ($bind_login_user) {
                        return $user_attributes;
                    }
                }
            } else {
                return false;
            }
        }
        return false;
    }

    public function logout(Request $request){
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}
