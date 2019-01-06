<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'vpn_username',
        'vpn_password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'email',
        'email_verified_at',
        'vpn_username',
        'vpn_password',
        'locale',
        'created_at',
        'updated_at',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($query) {
            $query->text_id = Str::uuid()->toString();
        });
    }

    public function access() {
        return $this->belongsToMany('App\Access', 'user_access', 'user_id', 'access_id')->withPivot('end_at');
    }

    public function roles() {
        return $this->belongsToMany('App\Role', 'user_roles', 'user_id', 'role_id');
    }

    public function hasActiveAccess() {
        $accessList = $this->access;

        foreach ($accessList as $access) {
            if ($access->pivot->end_at > time()) {
                return true;
            }
        }

        return false;
    }

    public function hasRole($name) {
        $rolesList = $this->roles;

        foreach ($rolesList as $role) {
            if ($role->name == $name) {
                return true;
            }
        }

        return false;
    }
}
