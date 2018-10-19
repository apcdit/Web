<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens,Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'uniNameCN', 'uniNameEN', 'region', 'nameEn', 'nameCn', 'address', 'password', 'email', 'contactNumber'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token'
    ];

    public function uniDetails(){
        return $this->hasOne('App\uniDetails','uniNameCN','uniNameCN');
    }

    public function setPasswordAttribute($value)
    {
        if( \Hash::needsRehash($value) ) {
            $value = \Hash::make($value);
        }
        $this->attributes['password'] = $value;
    }

    public function isAdmin(){
        if($this->admin)
            return true;
        else
            return false;
    }
}
