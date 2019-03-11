<?php

namespace App\Http\Controllers\Post;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Category;

class PostController extends Controller
{
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function getListPost(){
      $posts = Post::whereNull('deleted_at')->orderBy('id', 'desc')->get();

      return datatables()->of($posts)
      ->addIndexColumn()
      ->editColumn('created_at', function($post){
        return date('H:i | d-m-Y', strtotime($post->created_at));
      })
      ->addColumn('action', function($post){
        $string = '';

                // if (Entrust::can(["category-edit"])) {
        $string = $string.'<a type="button" onclick="showEditPost('.$post->id.')"  class="btn btn-xs btn-warning" data-tooltip="tooltip" title="Chỉnh sửa">
        <i class="fas fa-edit"></i> 
        </a>';
                // }
                // if (Entrust::can(["category-delete"])) {
        $string = $string.'<a type="button" data-id="'.$post->id.'" class="btn btn-xs btn-danger btn-delete" data-tooltip="tooltip" title="Xóa">
        <i class="fas fa-trash-alt"></i>  
        </a>';
                // }

        return $string;
      })
      ->rawColumns(['action'])
      ->toJson();
    }
}
