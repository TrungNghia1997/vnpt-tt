<?php

namespace App\Http\Controllers\Post;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Category;

class PostController extends Controller
{
    public function __construct() {
      $this->middleware('auth');
      $this->middleware('permission:view_post')->only(['index','store', 'show', 'update', 'destroy', 'getListPost']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $category = Category::whereNull('deleted_at')->orderBy('id', 'desc')->get();

        return view('post.index', ['category' => $category]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();
        
        $rules = [
            'post' => 'required',
            'content' => 'required',
        ];
        $messages = [
            'post.required' => 'Vui lòng nhập tiêu đề bài viết',
            'content.required' => 'Vui lòng nhập nội dung bài viết',
        ];

        $validator = \Validator::make($data, $rules, $messages);
        if ($validator->fails()) {
            return response()->json([
                'error' => true,
                'message' => $validator->errors()
            ], 200);
        }else{
            try {
                // $data['user_id'] = Auth::id();
                $data['user_id'] = 1;
                
                if(!empty($data['files'])){
                    $file_name = $request->file('files')->getClientOriginalName();
                    $dir = 'files/';
                    $filename =  date('d_m_Y'). '_' . $file_name;

                    if(!file_exists(url('files/'.$filename))){
                        $request->file('files')->move($dir, $filename);
                    }

                    $data['files'] = $filename;
                }

                Post::create($data);

                return response()->json([
                    'error' => false,
                ]);

            } catch (Exception $e) {
                return response()->json([
                    'error' => true,
                    'message' => $e->getMessage(),
                ]); 
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $post = Post::where('id', $id)->first();

            return response()->json([
                'error' => false,
                'post' => $post,
            ]);
        } catch (Exception $e) {
            return response()->json([
                'error' => true,
                'message' => $e->getMessage(),
            ]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = $request->all();
        
        $rules = [
            'post' => 'required',
            'content' => 'required',
        ];
        $messages = [
            'post.required' => 'Vui lòng nhập tiêu đề bài viết',
            'content.required' => 'Vui lòng nhập nội dung bài viết',
        ];

        $validator = \Validator::make($data, $rules, $messages);
        if ($validator->fails()) {
            return response()->json([
                'error' => true,
                'message' => $validator->errors()
            ], 200);
        }else{
            try {
                
                if(!empty($data['files'])){
                    $file_name = $request->file('files')->getClientOriginalName();
                    $dir = 'files/';
                    $filename =  date('d_m_Y'). '_' . $file_name;

                    if(!file_exists(url('files/'.$filename))){
                        $request->file('files')->move($dir, $filename);
                    }

                    $data['files'] = $filename;
                }

                Post::where('id', $id)->update($data);

                return response()->json([
                    'error' => false,
                ]);

            } catch (Exception $e) {
                return response()->json([
                    'error' => true,
                    'message' => $e->getMessage(),
                ]); 
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            Post::where('id', $id)->delete();

            return response()->json([
                'error' => false,
            ]);
        } catch (Exception $e) {
            return response()->json([
                'error' => true,
                'message' => $e->getMessage(),
            ]);
        }
    }

    public function getListPost(){
      $posts = Post::join('tbl_categories', 'tbl_posts.category_id', '=', 'tbl_categories.id')
                    ->join('tbl_users', 'tbl_posts.user_id', '=', 'tbl_users.id')
                    ->select('tbl_posts.id as post_id', 'tbl_posts.post', 'tbl_posts.content', 'tbl_posts.category_id', 'tbl_posts.user_id', 'tbl_posts.status', 'tbl_posts.created_at', 'tbl_categories.id', 'tbl_categories.category', 'tbl_users.id', 'tbl_users.name')
                    ->whereNull('tbl_posts.deleted_at')
                    ->whereNull('tbl_categories.deleted_at')
                    ->whereNull('tbl_users.deleted_at')
                    ->orderBy('tbl_posts.id', 'desc')->get();

      return datatables()->of($posts)
      ->addIndexColumn()
      ->editColumn('content', function($post){
        if(strlen($post->content) >= 180){
          return substr($post->content, 0, 180).'... <a href="" style="color:#007bff;">Xem thêm</a>';
        }else{
          return $post->content;
        }
      })
      ->editColumn('created_at', function($post){
        return date('H:i | d-m-Y', strtotime($post->created_at));
      })
      ->addColumn('action', function($post){
        $string = '';

                // if (Entrust::can(["category-edit"])) {
        $string = $string.'<a type="button" onclick="showEditPost('.$post->post_id.')"  class="btn btn-xs btn-warning" data-tooltip="tooltip" title="Chỉnh sửa">
        <i class="fas fa-edit"></i> 
        </a>';
                // }
                // if (Entrust::can(["category-delete"])) {
        $string = $string.'<a type="button" data-id="'.$post->post_id.'" class="btn btn-xs btn-danger btn-delete" data-tooltip="tooltip" title="Xóa">
        <i class="fas fa-trash-alt"></i>  
        </a>';
                // }

        return $string;
      })
      ->rawColumns(['content', 'action'])
      ->toJson();
    }
}
