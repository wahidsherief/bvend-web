<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class Vendor extends Authenticatable implements JWTSubject
{
    use HasFactory;
    use Notifiable;

    protected $hidden = [ 'password', 'remember_token'];

    protected $casts = [ 'email_verified_at' => 'datetime'];

    protected $primaryKey = 'id';

    protected $guarded = ['id'];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return ['role' => 'vendor'];
    }

    public function machines()
    {
        return $this->hasMany('App\Models\Machine', 'id', 'vendor_id');
    }
}
