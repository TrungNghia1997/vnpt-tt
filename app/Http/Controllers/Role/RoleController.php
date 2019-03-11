<?php

namespace App\Http\Controllers\Role;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\Permission;
use App\Models\RolePermission;
use App\Models\RoleUser;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('role.index');
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
            'name' => 'required|unique:roles',
        ];

        $messages = [
            'name.required' => 'Vui lòng nhập tên vai trò',
            'name.unique' => 'Vai trò này đã tồn tại, vui lòng thử lại',
        ];

        $validator = \Validator::make($data, $rules, $messages);
        if ($validator->fails()) {
            return response()->json([
                'error' => true,
                'message' => $validator->errors()
            ], 200);
        }else{
            try {

                Role::create($data);

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
            $role = Role::where('id', $id)->first();

            return response()->json([
                'error' => false,
                'role' => $role,
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
            'name.required' => 'Vui lòng nhập tên vai trò',
        ];

        $validator = \Validator::make($data, $rules, $messages);
        if ($validator->fails()) {
            return response()->json([
                'error' => true,
                'message' => $validator->errors()
            ], 200);
        }else{
            try {
                $role = Role::where('id', $id)->first();
                $check_duplicate = Role::where('name', $data['name'])->count();

                if($check_duplicate>=1 && $role['name'] != $data['name']){
                    return response()->json([
                        'error' => true,
                        'message' => 'Vai trò này đã tồn tại, vui lòng thử lại',
                    ]); 
                }else{
                    $role->update($data);

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
            $role = Role::where('id', $id)->first();
            
            if(!empty($role->permissions->first())){
                return response()->json([
                    'error' => true,
                    'message' => 'Vẫn tồn tại quyền hạn trong vai trò, vui lòng thử lại',
                ]);
            }else{
                $role->delete();
                RoleUser::where('role_id', $id)->delete();

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

    public function getListRole(){
        $roles = Role::whereNull('deleted_at')->orderBy('id', 'desc')->get();

        return datatables()->of($roles)
        ->addIndexColumn()
        ->editColumn('created_at', function($role){
            return date('H:i | d-m-Y', strtotime($role->created_at));
        })
        ->addColumn('action', function($role){
            $string = '';

            // if (Entrust::can(["user-edit"])) {
            $string = $string.'<a type="button" onclick="showDetailRole('.$role->id.')"  class="btn btn-xs btn-primary" data-tooltip="tooltip" title="Quyền hạn">
            <i class="fas fa-hand-paper"></i> 
            </a>';
                // }
                // if (Entrust::can(["user-edit"])) {
            $string = $string.'<a type="button" onclick="showEditRole('.$role->id.')"  class="btn btn-xs btn-warning" data-tooltip="tooltip" title="Chỉnh sửa">
            <i class="fas fa-edit"></i> 
            </a>';
                // }
                // if (Entrust::can(["user-delete"])) {
            $string = $string.'<a type="button" data-id="'.$role->id.'" class="btn btn-xs btn-danger btn-delete" data-tooltip="tooltip" title="Xóa">
            <i class="fas fa-trash-alt"></i>  
            </a>';
                // }

            return $string;
        })
        ->rawColumns(['action'])
        ->toJson();
    }

    public function getListRolePermission(Request $request){
        $permissions = Permission::whereNull('deleted_at')->orderBy('id', 'desc')->get();

        foreach ($permissions as $key => $val) {
            $val['role_id'] = $request->id;
        }

        return datatables()->of($permissions)
        ->addIndexColumn()
        ->editColumn('created_at', function($permission){
            return date('H:i | d-m-Y', strtotime($permission->created_at));
        })
        ->addColumn('action', function($permission){
            $string = '';
            $check = RolePermission::where('role_id', $permission->role_id)->where('permission_id', $permission->id)->first();

            // if (Entrust::can(["user-edit"])) {
            if(empty($check)){
                $string = $string.'<input type="checkbox" onclick="addRolePermission('.$permission->role_id.', '.$permission->id.', 0)" id="select'.$permission->id.'" data-tooltip="tooltip" title="Chọn quyền hạn">';
            }else{
                $string = $string.'<input type="checkbox" onclick="addRolePermission('.$permission->role_id.', '.$permission->id.', 1)" checked id="select'.$permission->id.'" data-tooltip="tooltip" title="Bỏ quyền hạn">';
            }
                // }

            return $string;
        })
        ->rawColumns(['action'])
        ->toJson();
    }

    public function addDelPermission(Request $request){
        $data = $request->all();

        try {
            if($data['type'] == 1){
                RolePermission::create([
                    'role_id' => $data['role_id'],
                    'permission_id' => $data['permission_id'],
                ]);
            }else{
                RolePermission::where('role_id', $data['role_id'])->where('permission_id', $data['permission_id'])->delete();
            }

            return response()->json([
                'error' => false,
                'type' => $data['type'],
            ]);
        } catch (Exception $e) {
            return response()->json([
                'error' => true,
                'message' => $e->getMessage(),
            ]);
        }
    }
}
