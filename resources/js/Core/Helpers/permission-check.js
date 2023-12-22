import { usePage } from "@inertiajs/vue3";

export function can(permission){
    return usePage().props.auth.user_permissions.includes(permission);
}