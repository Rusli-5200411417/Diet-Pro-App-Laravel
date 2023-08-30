<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Laporan;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function index(Request $request, $id){ 
        $laporan = Laporan::where('id_user', $id)->get();

    return $this->success($laporan);;
    }

    public function store(Request $request,$id)
    {
        // Validasi data yang diterima dari request
        $validatedData = $request->validate([
            'id_makanan' => 'required',
            'jenis' => 'required',
        ]);

        // Tambahkan ID pengguna ke dalam data yang akan disimpan
        $validatedData['id_user'] = $id;

        // Buat laporan baru dengan menggunakan data yang divalidasi
        $laporan = Laporan::create($validatedData);

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
