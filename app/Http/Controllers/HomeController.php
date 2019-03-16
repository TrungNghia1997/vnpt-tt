<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Category;
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
        $categories = Category::orderBy('id', 'desc')->get();

        foreach ($posts as $key => $post) {
            $post->user_id = $post->user->name;

            if(strlen($post->content) >= 500){
                $post->content = substr($post->content, 0, 500).'... <a href="'.route('post.detail',$post->slug).'" style="color:#007bff;">Xem thêm</a>';
            }
        }

        return view('home', ['posts' => $posts, 'categories' => $categories]);
    }
    
    public function search(Request $request){
        if($request->category_id == 'all'){
            $posts = Post::where('post','like','%'.$request->search_name.'%')->orWhere('content','like','%'.$request->search_name.'%')->orderBy('id', 'desc')->paginate(10);
        }else{
            $posts = Post::where('post','like','%'.$request->search_name.'%')->where('category_id', $request->category_id)->orWhere('content','like','%'.$request->search_name.'%')->orderBy('id', 'desc')->paginate(10);
        }
        foreach ($posts as $key => $post) {
            $post->user_id = $post->user->name;
        }

        return view('search', ['posts' => $posts, 'search_name'=>$request->search_name, 'number'=> $posts->count()]);
    }
}
