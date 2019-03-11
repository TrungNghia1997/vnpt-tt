<?php

namespace App\Http\Controllers\Permission;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Permission;
use App\Models\RolePermission;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('permission.index');
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
            'name' => 'required|unique:permissions',
        ];

        $messages = [
            'name.required' => 'Vui lòng nhập tên quyền hạn',
            'name.unique' => 'Quyền hạn này đã tồn tại, vui lòng thử lại',
        ];

        $validator = \Validator::make($data, $rules, $messages);
        if ($validator->fails()) {
            return response()->json([
                'error' => true,
                'message' => $validator->errors()
            ], 200);
        }else{
            try {

                Permission::create($data);

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
            $permission = Permission::where('id', $id)->first();

            return response()->json([
                'error' => false,
                'permission' => $permission,
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
            'name' => 'required',
        ];

        $messages = [
            'name.required' => 'Vui lòng nhập tên quyền hạn',
        ];

        $validator = \Validator::make($data, $rules, $messages);
        if ($validator->fails()) {
            return response()->json([
                'error' => true,
                'message' => $validator->errors()
            ], 200);
        }else{
            try {
                $permission = Permission::where('id', $id)->first();
                $check_duplicate = Permission::where('name', $data['name'])->count();

                if($check_duplicate>=1 && $permission['name'] != $data['name']){
                    return response()->json([
                        'error' => true,
                        'message' => 'Quyền hạn này đã tồn tại, vui lòng thử lại',
                    ]); 
                }else{
                    $permission->update($data);

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
            RolePermission::where('permission_id', $id)->delete();
            Permission::where('id', $id)->delete();

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

    public function getListPermission(Request $request){
        $permissions = Permission::whereNull('deleted_at')->orderBy('id', 'desc')->get();

        return datatables()->of($permissions)
        ->addIndexColumn()
        ->editColumn('created_at', function($permission){
            return date('H:i | d-m-Y', strtotime($permission->created_at));
        })
        ->addColumn('action', function($permission){
            $string = '';

                // if (Entrust::can(["user-edit"])) {
            $string = $string.'<a type="button" onclick="showEditPermission('.$permission->id.')"  class="btn btn-xs btn-warning" data-tooltip="tooltip" title="Chỉnh sửa">
            <i class="fas fa-edit"></i> 
            </a>';
                // }
                // if (Entrust::can(["user-delete"])) {
            $string = $string.'<a type="button" data-id="'.$permission->id.'" class="btn btn-xs btn-danger btn-delete" data-tooltip="tooltip" title="Xóa">
            <i class="fas fa-trash-alt"></i>  
            </a>';
                // }

            return $string;
        })
        ->rawColumns(['action'])
        ->toJson();
    }
}
