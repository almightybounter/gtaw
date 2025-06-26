<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    // Mass assignable attributes
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    // Hidden from serialization
    protected $hidden = [
        'password',
        'remember_token',
    ];

    // Attribute casting
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // User has many notes
    public function notes(): HasMany
    {
        return $this->hasMany(Note::class);
    }


} 