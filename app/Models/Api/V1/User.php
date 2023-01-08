<?php

namespace App\Models\Api\V1;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable{
    
    use HasApiTokens, HasFactory, Notifiable;

    public const ROLE_ADMIN = 1;
    public const ROLE_HIRER = 2;
    public const ROLE_JOB_SEEKER = 3;

    protected $fillable = [
        'email',
        'password',
        'role'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public static function register($data){
        return static::create([
            'email' => $data->email,
            'password' => Hash::make($data->password),
            'role' => $data->role
        ]);
    }

    public function positions(){
        return $this->hasMany(Position::class,'created_by','id');
    }

    public function vacancies(){
        return $this->hasMany(Vacancy::class,'created_by','id');
    }

    public function cvs(){
        return $this->hasMany(Cv::class,'created_by','id');
    }
}