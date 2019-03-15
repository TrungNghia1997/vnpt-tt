<?php

namespace App\Http\Controllers\Department;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Department;

class DepartmentController extends Controller
{
    public function __construct() {
      $this->middleware('auth');
      $this->middleware('permission:view_department');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('department.index');
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
            'department' => 'required',
        ];

        $messages = [
            'department.required' => 'Không được để trống',
        ];

        $validator = \Validator::make($data, $rules, $messages);
        if ($validator->fails()) {
            return response()->json([
                'error' => true,
                'message' => $validator->errors()
            ], 200);
        }else{
            try {

                Department::create($data);

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
            $department = Department::where('id', $id)->first();

            return response()->json([
                'error' => false,
                'department' => $department,
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
            'department' => 'required',
        ];

        $messages = [
            'department.required' => 'Không được để trống',
        ];

        $validator = \Validator::make($data, $rules, $messages);
        if ($validator->fails()) {
            return response()->json([
                'error' => true,
                'message' => $validator->errors()
            ], 200);
        }else{
            try {
                $department = Department::where('id', $id)->first();
                $check_duplicate = Department::where('department', $data['department'])->count();

                if($check_duplicate>=1 && $department['department'] != $data['department']){
                    return response()->json([
                        'error' => true,
                        'message' => 'Đã tồn tại nhóm bộ phận. Xin hãy thử lại',
                    ]); 
                }else{
                    $department->update($data);

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
            $check_group = Department::whereNull('deleted_at')->where('parent_id', $id)->first();

            if(!empty($check_group)){
                return response()->json([
                    'error' => true,
                    'message' => 'Vẫn tồn tại bộ phận trong nhóm',
                ]);
            }else{
                Department::where('id', $id)->delete();

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

    public function getListDepartmentGroup(){
        $departments = Department::whereNull('deleted_at')->whereNull('parent_id')->orderBy('id', 'desc')->get();

        return datatables()->of($departments)
        ->addIndexColumn()
        ->editColumn('created_at', function($department){
            return date('H:i | d-m-Y', strtotime($department->created_at));
        })
        ->addColumn('action', function($department){
            $string = '';

            $string = $string.'<a type="button" onclick="showDetailDepartmentGroup('.$department->id.')"  class="btn btn-xs btn-info" data-tooltip="tooltip" title="Chi tiết">
            <i class="fas fa-edit"></i> 
            </a>';
            
            $string = $string.'<a type="button" onclick="showEditDepartmentGroup('.$department->id.')"  class="btn btn-xs btn-warning" data-tooltip="tooltip" title="Chỉnh sửa">
            <i class="fas fa-edit"></i> 
            </a>';

            $string = $string.'<a type="button" data-id="'.$department->id.'" class="btn btn-xs btn-danger btn-delete" data-tooltip="tooltip" title="Xóa">
            <i class="fas fa-trash-alt"></i>  
            </a>';

            return $string;
        })
        ->rawColumns(['action'])
        ->toJson();
    }

    public function getListDepartment(Request $request){
        $departments = Department::whereNull('deleted_at')->whereNotNull('parent_id')->where('parent_id', $request->id)->orderBy('id', 'desc')->get();

        return datatables()->of($departments)
        ->addIndexColumn()
        ->editColumn('created_at', function($department){
            return date('H:i | d-m-Y', strtotime($department->created_at));
        })
        ->addColumn('action', function($department){
            $string = '';

            $string = $string.'<a type="button" onclick="showEditDepartment('.$department->id.')"  class="btn btn-xs btn-warning" data-tooltip="tooltip" title="Chỉnh sửa">
            <i class="fas fa-edit"></i> 
            </a>';
            
            $string = $string.'<a type="button" data-id="'.$department->id.'" class="btn btn-xs btn-danger btn-delete" data-tooltip="tooltip" title="Xóa">
            <i class="fas fa-trash-alt"></i>  
            </a>';

            return $string;
        })
        ->rawColumns(['action'])
        ->toJson();
    }
}
