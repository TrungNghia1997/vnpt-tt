<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Category;
use App\Models\Link;
use Carbon\Carbon;
use Session;

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
        $links = Link::get();

        foreach ($posts as $key => $post) {
            $post->user_id = $post->user->name;

            if(strlen($post->content) >= 290){
                $post->content = trim(substr($post->content, 0, 290)).'<span>...</span>';
            }
        }

        return view('home', ['posts' => $posts, 'categories' => $categories, 'links' => $links]);
    }
    
    public function search(Request $request){
        if($request->category_id == 'all'){
            $posts = Post::where('post','like','%'.$request->search_name.'%')->orWhere('content','like','%'.$request->search_name.'%')->orderBy('id', 'desc')->paginate(10);
            $category['category'] = '';
        }else{
            if ($request->search_name == '') {
                $posts = Post::where('category_id', $request->category_id)
                            ->orderBy('id', 'desc')->paginate(10);
            } else {
                $posts = Post::where('post','like','%'.$request->search_name.'%')
                            ->where('category_id', $request->category_id)
                            ->orWhere('content','like','%'.$request->search_name.'%')
                            ->orderBy('id', 'desc')->paginate(10);
            }

            $category = Category::where('id', $request->category_id)->first();
            
        }

        foreach ($posts as $key => $post) {
            $post->user_id = $post->user->name;

            if(strlen($post->content) >= 290){
                $post->content = trim(substr($post->content, 0, 290)).'<span>...</span>';
            }
        }

        return view('search', ['posts' => $posts, 'search_name'=>$request->search_name, 'number'=> $posts->count(), 'category_name' => $category['category'] ]);
    }
}
