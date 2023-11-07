<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class Admin extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable;

    protected $fillable = [ 'name', 'email', 'password' ];

    protected $hidden = [ 'password', 'remember_token'];

    protected $cast = [ 'email_verified_at' => 'datetime'];

    public function getJWTIdentifier () {
        return $this->getKey();
    } 

    public function getJWTCustomClaims () {
        return ['role' => 'admin'];
    } 
}
