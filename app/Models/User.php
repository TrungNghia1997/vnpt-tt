<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Zizaco\Entrust\Traits\EntrustUserTrait;

class User extends Authenticatable
{
    use Notifiable, SoftDeletes, EntrustUserTrait {

        SoftDeletes::restore insteadof EntrustUserTrait;
        EntrustUserTrait::restore insteadof SoftDeletes;

    }
    
    protected $dates = ['deleted_at'];

    protected $table = 'users';

    protected $fillable = [
        'id', 'name', 'email', 'password', 'avatar', 'phone', 'address', 'birthday', 'gender', 'job', 'department_id', 'created_at', 'updated_at', 'deleted_at',
    ];

    protected $hidden = [
        'password',
    ];

    public function posts(){
    	return $this->hasMany('App\Models\Post','id');
    }

    public function roles(){
    	return $this->belongsToMany('App\Models\Role', 'role_user', 'user_id', 'role_id');
    }

    public function departments(){
    	return $this->hasMany('App\Models\Department', 'id', 'department_id');
    }
}
