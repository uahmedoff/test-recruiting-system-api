<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Api\V1\User;
use App\Models\Api\V1\Position;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder{
    
    public function run(){

        $admin = User::create([
            'email' => 'admin@example.com',
            'password' => Hash::make('111111'),
            'role' => User::ROLE_ADMIN
        ]);

        $hirer = User::create([
            'email' => 'hirer@example.com',
            'password' => Hash::make('222222'),
            'role' => User::ROLE_HIRER
        ]);

        $job_seeker = User::create([
            'email' => 'job_seeker@example.com',
            'password' => Hash::make('333333'),
            'role' => User::ROLE_JOB_SEEKER
        ]);

        $hirer->positions()->create([
            'name' => 'Frontend developer'
        ]);

        $hirer->positions()->create([
            'name' => 'Backend developer'
        ]);

        $hirer->positions()->create([
            'name' => 'Mobile developer'
        ]);

        $hirer->positions()->create([
            'name' => 'DevOPS engineer'
        ]);

        $hirer->positions()->create([
            'name' => 'UI/UX designer'
        ]);

    }

}
