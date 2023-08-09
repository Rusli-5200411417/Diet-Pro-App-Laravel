<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller {
  public function login(Request $request)   {
    $validasi   = Validator::make($request->all(), [
      'email' => 'required_without:username',
      'username' => 'required_without:email',
      'password' => 'required|min:6',
    ]);

    if ($validasi->fails()) {
      return $this->error($validasi->errors()->first());
    }

    $user   =   $user = User::where(function ($query) use ($request) {
                $query->where('email', $request->input('email'))
               ->orWhere('username', $request->input('username'));
               })->first();
    
    if ($user) {

        if (password_verify($request->password, $user->password)) {
          return  $this->success($user);
        } else {
          return  $this->error("Password salah");
        }
        
    }
    return $this->error("User tidak ditemukan");
  }  

  public function register (Request $request) {
    $validasi   = Validator::make($request->all(), [
      'email' => 'required|unique:users',
      'username' => 'required|unique:users',
      'nama' => 'required',
      'usia' => 'required',
      'tinggi_badan' => 'required',
      'berat_badan' => 'required',
      'jenis_kelamin' => 'required',
      'aktivitas' => 'required',
      'password' => 'required|min:6',
    ]);

    if ($validasi->fails()) {
      return $this->error($validasi->errors()->first());
    }

    $kebutuhan_kalori = $this->calculateCalorieNeeds(
      $request->usia,
      $request->jenis_kelamin,
      $request->berat_badan,
      $request->tinggi_badan,
      $request->aktivitas
  );

  $user = User::create(array_merge($request->all(), [
      'password' => bcrypt($request->password),
      'kebutuhan_kalori' => $kebutuhan_kalori,
      'role' => 'user'
  ]));

    if  ($user)  {
      return $this->success($user, 'Selamat Datang  '. $user->nama);
    } else  {
      return $this->error("Terjadi Kesalahan");
    }

  }

  public function update(Request $request, $id) {
    $user = User::find($id);

    if (!$user) {
        return $this->error("Tidak ada user");
    }

    // Validasi username
    $usernameExists = User::where('username', $request->input('username'))
                           ->where('id', '!=', $id)
                           ->exists();

    if ($usernameExists) {
        return $this->error("Username sudah digunakan");
    }

    // Validasi email
    $emailExists = User::where('email', $request->input('email'))
                        ->where('id', '!=', $id)
                        ->exists();

    if ($emailExists) {
        return $this->error("Email sudah digunakan");
    }

    // Simpan data lama sebelum pembaruan
    $oldData = $user->toArray();

    // Lakukan pembaruan data
    $user->update($request->all());

    // Cek apakah atribut yang mempengaruhi kebutuhan_kalori berubah
    $attributesAffectingCalories = ['usia', 'jenis_kelamin', 'tinggi_badan', 'berat_badan', 'aktivitas'];
    $shouldUpdateCalories = false;

    foreach ($attributesAffectingCalories as $attribute) {
        if ($request->has($attribute) && $request->$attribute !== $oldData[$attribute]) {
            $shouldUpdateCalories = true;
            break;
        }
    }

    // Jika atribut berubah, hitung ulang dan perbarui kebutuhan_kalori
    if ($shouldUpdateCalories) {
        $newCalorieNeeds = $this->calculateCalorieNeeds(
            $user->usia,
            $user->jenis_kelamin,
            $user->berat_badan,
            $user->tinggi_badan,
            $user->aktivitas
        );

        $user->kebutuhan_kalori = $newCalorieNeeds;
        $user->save();
    }

    return $this->success($user);
}


  

  private function calculateCalorieNeeds($usia, $jenis_kelamin, $berat_badan, $tinggi_badan, $aktivitas) {
    // Define activity level multipliers
    $activityMultipliers = [
        'tidak aktif' => 1.2,
        'latihan ringan' => 1.375, //1-3 hari per minggu
        'latihan sedang' => 1.55, //3-5 hari per minggu
        'aktif' => 1.725, //6-7 hari per minggu
        'sangat aktif' => 1.9, //setiap hari perkerjaan fisik berat
    ];

    // Define gender-specific constants
    $genderConstants = [
        'laki-laki' => 66.5,
        'perempuan' => 655.1,
    ];

    // Calculate BMR based on gender
    $bmr = $genderConstants[$jenis_kelamin]
        + (13.75 * $berat_badan)
        + (5.003 * $tinggi_badan)
        - (6.755 * $usia);

    // Calculate calorie needs by multiplying BMR with activity multiplier
    $calorieNeeds = $bmr * $activityMultipliers[$aktivitas];

    $roundedCalorieNeeds = round($calorieNeeds);

    return $roundedCalorieNeeds;
}

  public function success($data, $message = "success") {
    return  response()->json([
      'code'  =>  200,
      'message' =>  $message,
      'data'  => $data
    ]);
  }

  public function error($message) {
    // return  response()->json([
    //   'code'  =>  400,
    //   'message' =>  $message
    // ],  400);
    return  response()->json([
      'ok'  => false,
      'error_code'  =>  400,
      'description' =>  $message
    ],  400);
  }

}
