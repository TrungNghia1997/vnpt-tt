<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use Carbon\Carbon;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $posts = Post::orderBy('id', 'desc')->paginate(10);

        foreach ($posts as $key => $post) {
            $post->user_id = $post->user->name;

            if(strlen($post->content) >= 500){
                $post->content = substr($post->content, 0, 500).'... <a href="" style="color:#007bff;">Xem thêm</a>';
            }
        }

        return view('home', ['posts' => $posts]);
    }
}
