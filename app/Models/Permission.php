<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Zizaco\Entrust\EntrustPermission;

class Permission extends EntrustPermission
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $table = 'tbl_permissions';

    protected $fillable = [
    	'id', 'name', 'display_name', 'description', 'created_at', 'updated_at', 'deleted_at',
    ];

    public function roles(){
    	return $this->belongsToMany('App\Models\Role', 'permission_role', 'permission_id', 'role_id');
    }
}
