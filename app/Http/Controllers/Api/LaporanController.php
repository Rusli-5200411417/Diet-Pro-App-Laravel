<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Laporan;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function index(){
        $laporan = Laporan::all();

        // var_dump($laporan);
        return $this->success($laporan);
    }

    public function success($data, $message = "success") {
        return  response()->json([
          'code'  =>  200,
          'message' =>  $message,
          'data'  => $data
        ]);
      }
    
      public function error($message) {
        return  response()->json([
          'ok'  => false,
          'error_code'  =>  400,
          'description' =>  $message
        ],  400);
      }
}
