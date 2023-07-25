<?php

namespace App\Models;

use App\Models\Level;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Contracts\Auth\CanResetPassword;
use Illuminate\Auth\Passwords\CanResetPassword as CanResetPasswordTrait;

class User extends Model implements Authenticatable, CanResetPassword
{
    use HasFactory, HasApiTokens, Notifiable, CanResetPasswordTrait;

    protected $table = 'users';
    protected $primaryKey = 'id_user';
    protected $guarded = [];

    public function level()
    {
        return $this->belongsTo(Level::class, 'id_level');
    }

    public function getAuthIdentifierName()
    {
        return 'id_user'; // Nama kolom yang digunakan sebagai primary key
    }

    public function getAuthIdentifier()
    {
        return $this->getKey(); // Nilai unik primary key untuk pengguna
    }

    public function getAuthPassword()
    {
        return $this->password; // Kolom yang berisi password hash
    }

    public function getRememberToken()
    {
        return $this->remember_token; // Kolom yang berisi remember token
    }

    public function setRememberToken($value)
    {
        $this->remember_token = $value; // Menetapkan remember token
    }

    public function getRememberTokenName()
    {
        return 'remember_token'; // Nama kolom yang digunakan untuk remember token
    }

    public function getEmailForPasswordReset()
    {
        return $this->username; // Return the email address for password reset
    }

    public function sendPasswordResetNotification($token)
    {
        // Implement your password reset notification logic here
    }
}