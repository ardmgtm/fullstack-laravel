<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class UserLogApi extends Controller
{
    public function getLogFileList(Request $request){
        $directoryPath = storage_path('/logs');
        $files = File::files($directoryPath);

        $fileList = [];

        foreach ($files as $file) {
            $fileList[] = $file->getFilename();
        }

        return response()->json([
            'status' => true,
            'msg' => 'Berhasil mengambil list log file',
            'data' => [
                'log_file_list' => $fileList,
            ]
        ]);
    }
    public function getLogFileDetail(Request $request, $fileName){
        $filePath = storage_path('/logs').'/'.$fileName;
        if (File::exists($filePath)) {
            $fileContents = File::get($filePath);

            $logEntries = explode("\n", trim($fileContents));
            $collection = collect();

            foreach ($logEntries as $logEntry) {
                if (preg_match('/^\[(.*?)\]\s(.*?):\s(.*?)$/', $logEntry, $matches)) {
                    $timestamp = $matches[1];
                    $logStatus = $matches[2];
                    $logData = json_decode($matches[3], true);

                    if ($logData) {
                        $logData['timestamp'] = $timestamp;
                        $logData['log_status'] = $logStatus;

                        $collection->push($logData);
                    }
                }
            }

            return response()->json([
                'status' => true,
                'msg' => 'Berhasil mengambil list log file',
                'data' => [
                    'log_detail' => $collection,
                ]
            ]);
        } else {
            return response()->json([
                'status' => false,
                'msg' => 'File log tidak ditemukan',
                'data' => []
            ]);
        }
    }
}
