<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeders extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'id'=> 1,
            'nama'=> 'admin',
            'username'=> 'admin',
            'password'=> Hash::make("admin"),
            'role'=> "admin"
        ]);
        User::create([
            'id'=> 2,
            'nama'=> 'user',
            'username'=> 'user',
            'password'=> Hash::make("user"),
            'role'=>"user" 
        ]);
    }
}
