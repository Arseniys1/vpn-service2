<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserApplication extends Model
{
    protected $table = 'user_applications';

    public function user() {
        return $this->hasOne('App\User', 'id', 'user_id');
    }
}
