<?php

namespace App\Http\Controllers\Post;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Category;
use App\Models\Department;
use Auth;
use Session;

class PostController extends Controller
{
    public function __construct() {
      $this->middleware('auth')->except(['postDetail']);
      $this->middleware('permission:view_post')->only(['index','store', 'show', 'update', 'destroy', 'getListPost']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $parent_id = Auth::user()->departments[0]->parent_id;
        $category=null;

        if($parent_id == 2) {
          $category = Category::whereNull('deleted_at')->whereIn('id', [1,2,4,5])->get();
        } elseif($parent_id == 1 || $parent_id == 16) {
          $category = Category::whereNull('deleted_at')->whereIn('id', [1,3,4])->get();
        } elseif($parent_id == 17) {
          $category = Category::whereNull('deleted_at')->whereIn('id', [7])->get();
        }

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

                $data['slug'] = $this->createSlug($data['post']);
                
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
                $data['slug'] = $this->createSlug($data['post']);
                
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
                    ->select('tbl_posts.id as post_id', 'tbl_posts.post', 'tbl_posts.slug', 'tbl_posts.content', 'tbl_posts.category_id', 'tbl_posts.user_id', 'tbl_posts.status', 'tbl_posts.created_at', 'tbl_categories.id', 'tbl_categories.category', 'tbl_users.id', 'tbl_users.name')
                    ->whereNull('tbl_posts.deleted_at')
                    ->whereNull('tbl_categories.deleted_at')
                    ->whereNull('tbl_users.deleted_at')
                    ->orderBy('tbl_posts.id', 'desc')->get();

      return datatables()->of($posts)
      ->addIndexColumn()
      ->editColumn('post', function($post){
        return '<a href="'.route('post.detail',$post->slug).'">'.$post->post.'</a>';
      })
      ->editColumn('content', function($post){
        $string = '';
        if(strlen($post->content) >= 180){
          $string = substr($post->content, 0, 180).'... <a href="'.route('post.detail',$post->slug).'" style="color:#007bff;">Xem thêm</a>';
        }else{
          $string = $post->content;
        }

        $string = mb_convert_encoding($string, 'UTF-8', 'UTF-8');

        return $string;
      })
      ->editColumn('created_at', function($post){
        return date('H:i | d-m-Y', strtotime($post->created_at));
      })
      ->addColumn('action', function($post){
        $string = '';

        if($post->user_id == Auth::id()){
          $string = $string.'<a type="button" onclick="showEditPost('.$post->post_id.')"  class="btn btn-xs btn-warning" data-tooltip="tooltip" title="Chỉnh sửa">
          <i class="fas fa-edit"></i> 
          </a>';

          $string = $string.'<a type="button" data-id="'.$post->post_id.'" class="btn btn-xs btn-danger btn-delete" data-tooltip="tooltip" title="Xóa">
          <i class="fas fa-trash-alt"></i>  
          </a>';
        }else{
          $string = 'Không có quyền sửa';
        }

        return $string;
      })
      ->rawColumns(['post','content', 'action'])
      ->toJson();
    }

    public function postDetail($slug){
      $post = Post::where('slug', $slug)->first();

      if($post->status == 1 && empty(Auth::user())){
          Session::flash('message', 'Đây là thông báo riêng, bạn phải đăng nhập để tiếp tục');

          return redirect()->route('login');
      }

      $post->user_id = $post->user->name;

      return view('post.detail', ['post'=>$post]);
    }

    public function createSlug ($str){

        $unicode = array(

            'a'=>'á|à|ả|ã|ạ|ă|ắ|ặ|ằ|ẳ|ẵ|â|ấ|ầ|ẩ|ẫ|ậ',

            'd'=>'đ',

            'e'=>'é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ',

            'i'=>'í|ì|ỉ|ĩ|ị',

            'o'=>'ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ',

            'u'=>'ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự',

            'y'=>'ý|ỳ|ỷ|ỹ|ỵ',

            'A'=>'Á|À|Ả|Ã|Ạ|Ă|Ắ|Ặ|Ằ|Ẳ|Ẵ|Â|Ấ|Ầ|Ẩ|Ẫ|Ậ',

            'D'=>'Đ',

            'E'=>'É|È|Ẻ|Ẽ|Ẹ|Ê|Ế|Ề|Ể|Ễ|Ệ',

            'I'=>'Í|Ì|Ỉ|Ĩ|Ị',

            'O'=>'Ó|Ò|Ỏ|Õ|Ọ|Ô|Ố|Ồ|Ổ|Ỗ|Ộ|Ơ|Ớ|Ờ|Ở|Ỡ|Ợ',

            'U'=>'Ú|Ù|Ủ|Ũ|Ụ|Ư|Ứ|Ừ|Ử|Ữ|Ự',

            'Y'=>'Ý|Ỳ|Ỷ|Ỹ|Ỵ',

        );
        $str = str_replace(' - ','-',$str);

        foreach($unicode as $nonUnicode=>$uni){

            $str = preg_replace("/($uni)/i", $nonUnicode, $str);

        }
        $str = str_replace(' ','-',$str);
        $str = str_replace('%','',$str);
        $str = strtolower($str);
        $str = $str.'-'.rand(10000,99999);

        return $str;

    }

    public function fileDownload($file_name)
    {
        $file_path = public_path('files/'.$file_name);

        return response()->download($file_path);
    }

}
