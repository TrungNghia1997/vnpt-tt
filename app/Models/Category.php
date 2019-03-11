<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $table = 'categories';

    protected $fillable = [
    	'id', 'category', 'created_at', 'updated_at', 'deleted_at',
    ];

    public function posts(){
    	return $this->hasMany('App\Models\Post', 'category_id','id');
    }
}
