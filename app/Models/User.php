<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Zizaco\Entrust\Traits\EntrustUserTrait;
use Auth;

class User extends Authenticatable
{
    use Notifiable, SoftDeletes, EntrustUserTrait {

        SoftDeletes::restore insteadof EntrustUserTrait;
        EntrustUserTrait::restore insteadof SoftDeletes;

    }
    
    protected $dates = ['deleted_at'];

    protected $table = 'tbl_users';

    protected $fillable = [
        'id', 'name', 'email', 'password', 'avatar', 'phone', 'address', 'birthday', 'gender', 'job', 'department_id', 'created_at', 'updated_at', 'deleted_at',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    public function posts(){
    	return $this->hasMany('App\Models\Post', 'id','user_id');
    }

    public function roles(){
    	return $this->belongsToMany('App\Models\Role', 'role_user', 'user_id', 'role_id');
    }

    public function departments(){
    	return $this->hasMany('App\Models\Department', 'id', 'department_id');
    }
}
