<?php

namespace App\Http\Controllers\Category;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Post;
use DataTable;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      return view('category.index');
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

      try {
        if($data['category'] == ''){
          return response()->json([
            'error' => true,
            'message' => 'Xin vui lòng nhập chuyên mục',
          ]);
        }else{

          Category::create($data);

          return response()->json([
            'error' => false,
          ]);
        }
      } catch (Exception $e) {
        return response()->json([
          'error' => true,
          'message' => $e->getMessage(),
        ]); 
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
        $category = Category::where('id', $id)->first();

        return response()->json([
          'error' => false,
          'category' => $category,
        ]);
      } catch (Exception $e) {
        return response()->json([
          'error' => true,
          'message' => $e->getMessage(),
        ]);
      }
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

      try {
        if($data['category'] == ''){
          return response()->json([
            'error' => true,
            'message' => 'Xin vui lòng nhập chuyên mục',
          ]);
        }else{

          Category::where('id', $id)->update(
            ['category' => $data['category'],
          ]);

          return response()->json([
            'error' => false,
          ]);
        }
      } catch (Exception $e) {
        return response()->json([
          'error' => true,
          'message' => $e->getMessage(),
        ]); 
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
        $category = Category::where('id', $id)->first();

        if(!empty($category->posts->first())){
          return response()->json([
            'error' => true,
            'message' => 'Vẫn tồn tại bài viết trong chuyên mục, vui lòng thử lại',
          ]);
        }else{
          $category->delete();

          return response()->json([
            'error' => false,
          ]);
        }
      } catch (Exception $e) {
        return response()->json([
          'error' => true,
          'message' => $e->getMessage(),
        ]);
      }
    }

    public function getListCategory(){
      $category = Category::whereNull('deleted_at')->orderBy('id', 'desc')->get();

      return datatables()->of($category)
      ->addIndexColumn()
      ->editColumn('created_at', function($category){
        return date('H:i | d-m-Y', strtotime($category->created_at));
      })
      ->addColumn('action', function($category){
        $string = '';

                // if (Entrust::can(["category-edit"])) {
        $string = $string.'<a type="button" onclick="showEditCategory('.$category->id.')"  class="btn btn-xs btn-warning" data-tooltip="tooltip" title="Chỉnh sửa">
        <i class="fas fa-edit"></i> 
        </a>';
                // }
                // if (Entrust::can(["category-delete"])) {
        $string = $string.'<a type="button" data-id="'.$category->id.'" class="btn btn-xs btn-danger btn-delete" data-tooltip="tooltip" title="Xóa">
        <i class="fas fa-trash-alt"></i>  
        </a>';
                // }

        return $string;
      })
      ->rawColumns(['action'])
      ->toJson();
    }
  }
