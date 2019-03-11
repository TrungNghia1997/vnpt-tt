<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $table = 'posts';

    protected $fillable = [
    	'id', 'post', 'content', 'user_id', 'category_id', 'status', 'file', 'created_at', 'updated_at', 'deleted_at',
    ];

    public function user(){
    	return $this->belongsTo('App\Models\User', 'id','user_id');
    }

    public function category(){
    	return $this->belongsTo('App\Models\Category', 'id','category_id');
    }
}
