<?php

namespace App\Models;

use App\Notifications\AdminNotfication;
use App\Notifications\DealerRestPassword;
use Illuminate\Database\Eloquent\Model;


use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Dealer extends Authenticatable
{
    use Notifiable;

    protected $guard = 'dealer';

    protected $fillable = [
        'name', 'email', 'password',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];
    public function product(){
        return $this->hasMany(Product::class,'dealer_id');
    }
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new DealerRestPassword($token));
    }
}

