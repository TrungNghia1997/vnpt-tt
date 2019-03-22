<?php

namespace App\Http\Controllers\Link;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Link;

class LinkController extends Controller
{
    public function __construct() {
      $this->middleware('auth');
      $this->middleware('permission:view_post')->only(['index','store', 'show', 'update', 'destroy', 'getListLink']);
    }

    public function index(){
    	
    	return view('link.index');
    }

    public function store(Request $request)
    {
        $data = $request->all();
        
        $rules = [
            'name' => 'required',
            'links' => 'required',
            'img' => 'required',
        ];
        $messages = [
            'name.required' => 'Vui lòng nhập tên chương trình',
            'links.required' => 'Vui lòng nhập link chương trình',
            'img.required' => 'Vui lòng nhập ảnh đại diện',
        ];

        $validator = \Validator::make($data, $rules, $messages);
        if ($validator->fails()) {
            return response()->json([
                'error' => true,
                'message' => $validator->errors()
            ], 200);
        }else{
            try {
                $check = Link::where('name', $data['name'])->first();

                if (!empty($check)) {

                    return response()->json([
                        'error' => true,
                        'message' => 'Tên chương trình đã tồn tại. Mời bạn thử lại!',
                    ]);
                }
                
                if(!empty($data['img'])){
                    $file_name = $request->file('img')->getClientOriginalName();
                    $dir = 'images/';
                    $filename =  date('d_m_Y'). '_' . $file_name;

                    if(!file_exists(url('images/'.$filename))){
                        $request->file('img')->move($dir, $filename);
                    }

                    $data['img'] = $filename;
                }

                Link::create($data);

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

    public function show($id)
    {
        try {
            $link = Link::where('id', $id)->first();

            return response()->json([
                'error' => false,
                'link' => $link,
            ]);
        } catch (Exception $e) {
            return response()->json([
                'error' => true,
                'message' => $e->getMessage(),
            ]);
        }
    }

    public function update(Request $request, $id)
    {
        $data = $request->all();
        
        $rules = [
            'name' => 'required',
            'links' => 'required',
            'img' => 'required',
        ];
        $messages = [
            'name.required' => 'Vui lòng nhập tên chương trình',
            'links.required' => 'Vui lòng nhập link chương trình',
            'img.required' => 'Vui lòng nhập ảnh đại diện',
        ];

        $validator = \Validator::make($data, $rules, $messages);
        if ($validator->fails()) {
            return response()->json([
                'error' => true,
                'message' => $validator->errors()
            ], 200);
        }else{
            try {
                $link = Link::where('id', $id)->first();
                $check = Link::where('name', $data['name'])->count();

                if ($check > 1 && $link['name'] != $data['name']) {

                    return response()->json([
                        'error' => true,
                        'message' => 'Tên chương trình đã tồn tại. Mời bạn thử lại!',
                    ]);
                }
                
                if($link['img'] != $data['img']){
                    if(!empty($data['img'])){
                        $file_name = $request->file('img')->getClientOriginalName();
                        $dir = 'images/';
                        $filename =  date('d_m_Y'). '_' . $file_name;

                        if(!file_exists(url('images/'.$filename))){
                            $request->file('img')->move($dir, $filename);
                        }

                        $data['img'] = $filename;
                    }
                }

                $link->update($data);

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

    public function destroy($id)
    {
        try {
            Link::where('id', $id)->delete();

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
      $links = Link::orderBy('id', 'desc')->get();

      return datatables()->of($links)
      ->addIndexColumn()
      ->editColumn('img', function($link){
        return '<img src="'.asset('images/'.$link->img).'" width="100px">';
      })
      ->editColumn('links', function($link){
        if ($link->links != '') {
            return '<a href="'.$link->links.'">'.$link->links.'</a>';
        }
      })
      ->addColumn('action', function($link){
        $string = '';

        $string = $string.'<a type="button" onclick="showEditLink('.$link->id.')"  class="btn btn-xs btn-warning" data-tooltip="tooltip" title="Chỉnh sửa">
        <i class="fas fa-edit"></i> 
        </a>';

        $string = $string.'<a type="button" data-id="'.$link->id.'" class="btn btn-xs btn-danger btn-delete" data-tooltip="tooltip" title="Xóa">
        <i class="fas fa-trash-alt"></i>  
        </a>';

        return $string;
      })
      ->rawColumns(['img', 'links','action'])
      ->toJson();
    }
}
