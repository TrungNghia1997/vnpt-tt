<?php

namespace App\Models;

use Zizaco\Entrust\EntrustRole;
use Illuminate\Database\Eloquent\SoftDeletes;

class Role extends EntrustRole
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $table = 'tbl_roles';

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
