<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Role extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $table = 'roles';

    protected $fillable = [
    	'id', 'name', 'display_name', 'description', 'created_at', 'updated_at', 'deleted_at',
    ];

    public function users(){
    	return $this->belongsToMany('App\Models\User', 'role_user', 'role_id', 'user_id');
    }

    public function permissions(){
    	return $this->belongsToMany('App\Models\Permission', 'permission_role', 'role_id', 'permission_id');
    }
}
