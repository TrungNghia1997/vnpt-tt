<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Department extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $table = 'tbl_departments';

    protected $fillable = [
    	'id', 'department', 'parent_id', 'created_at', 'updated_at', 'deleted_at',
    ];

    public function user(){
    	return $this->belongsTo('App\Models\User', 'department_id','id');
    }
}
