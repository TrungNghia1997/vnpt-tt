<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Department;
use App\Models\Role;
use App\Models\RoleUser;
use Validator;
use Entrust;
use Hash;

class UserController extends Controller
{
    public function __construct() {
      $this->middleware('auth')->except(['contactUser', 'getListContactUser']);
      $this->middleware('permission:view_user')->only(['index','store', 'show', 'update', 'destroy', 'getListUser']);
      $this->middleware('permission:view_role')->only(['addDelRole']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $department = Department::get();

        return view('user.index', ['department' => $department]);
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
            'name' => 'required',
            'email' => 'required|unique:tbl_users|email',
            'phone' => 'required',
        ];
        $messages = [
            'name.required' => 'Vui lòng nhập họ tên',
            'email.required' => 'Vui lòng nhập email',
            'email.unique' => 'Email đã tồn tại, vui lòng thử lại',
            'email.email' => 'Email chưa đúng định dạng, vui lòng thử lại',
            'phone.required' => 'Vui lòng nhập số điện thoại',
        ];

        $validator = \Validator::make($data, $rules, $messages);
        if ($validator->fails()) {
            return response()->json([
                'error' => true,
                'message' => $validator->errors()
            ], 200);
        }else{
            try {

                $data['password'] = Hash::make('123456');

                if(!empty($data['birthday'])){
                    $data['birthday'] = date('Y-m-d', strtotime(str_replace('/', '-', $data['birthday'])));
                }
                
                if(!empty($data['avatar'])){
                    $image_name = $request->file('avatar')->getClientOriginalName();
                    $dir = 'images/';
                    $filename =  date('d_m_Y'). '_' . $image_name;

                    if(!file_exists(url('images/'.$filename))){
                        $request->file('avatar')->move($dir, $filename);
                    }

                    $data['avatar'] = $filename;
                }

                User::create($data);

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
            $user = User::where('id', $id)->first();

            if(!empty($user['birthday'])){
                $user['birthday'] = date('d-m-Y', strtotime($user['birthday']));
            }

            if(!empty($user->departments->first())){
                $department_arr = [];
                foreach ($user->departments as $key => $val) {
                    $department_arr[] = $val->department;
                }
                $user->setAttribute('department', $department_arr);
            }else{
                $user->setAttribute('department', 'Chưa cập nhật');
            }

            return response()->json([
                'error' => false,
                'user' => $user,
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

        $rules = [
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
        ];
        $messages = [
            'name.required' => 'Vui lòng nhập họ tên',
            'email.required' => 'Vui lòng nhập email',
            'email.email' => 'Email chưa đúng định dạng, vui lòng thử lại',
            'phone.required' => 'Vui lòng nhập số điện thoại',
        ];

        $validator = \Validator::make($data, $rules, $messages);
        if ($validator->fails()) {
            return response()->json([
                'error' => true,
                'message' => $validator->errors()
            ], 200);
        }else{
            try {
                $user = User::where('id', $id)->first();

                if(!empty($data['birthday'])){
                    $data['birthday'] = date('Y-m-d', strtotime(str_replace('/', '-', $data['birthday'])));
                }else{
                    unset($data['birthday']);
                }
                
                if($user['avatar'] != $data['avatar']){
                    if(!empty($data['avatar'])){
                        $image_name = $request->file('avatar')->getClientOriginalName();
                        $dir = 'images/';
                        $filename =  date('d_m_Y'). '_' . $image_name;

                        if(!file_exists(url('images/'.$filename))){
                            $request->file('avatar')->move($dir, $filename);
                        }

                        $data['avatar'] = $filename;
                    }
                }

                $user->update($data);

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
            User::where('id', $id)->delete();

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

    public function getListUser(){
        $users = User::whereNull('deleted_at')->orderBy('id', 'desc')->get();

        return datatables()->of($users)
        ->addIndexColumn()
        ->editColumn('gender', function($user){
            if($user->gender == 0){
                return '<i class="mdi mdi-gender-female" data-tooltip="tooltip" title="Nữ"></i>';
            }else{
                return '<i class="mdi mdi-gender-male" data-tooltip="tooltip" title="Nam"></i>';
            }
        })
        ->editColumn('email', function($user){
            return '<a href="mailto:'.$user->email.'">'.$user->email.'</a>';
        })
        ->editColumn('phone', function($user){
            return '<a href="call:'.$user->phone.'">'.$user->phone.'</a>';
        })
        ->editColumn('department', function($user){
            if(!empty($user->department)){
                return $user->department->department;
            }else{
                return 'Chưa cập nhật';
            }
        })
        ->editColumn('job', function($user){
            if($user->job != ''){
                return $user->job;
            }else{
                return 'Chưa cập nhật';
            }
        })
        ->editColumn('address', function($user){
            if($user->address != ''){
                return $user->address;
            }else{
                return 'Chưa cập nhật';
            }
        })
        ->editColumn('created_at', function($user){
            return date('H:i | d-m-Y', strtotime($user->created_at));
        })
        ->addColumn('action', function($user){
            $string = '';

            if (Entrust::can(["view_role"])) {
            $string = $string.'<a type="button" onclick="showDetailRole('.$user->id.')"  class="btn btn-xs btn-primary" data-tooltip="tooltip" title="Vai trò">
            <i class="fas fa-lock"></i> 
            </a>';
            }
            
            $string = $string.'<a type="button" onclick="showDetailUser('.$user->id.')"  class="btn btn-xs btn-info" data-tooltip="tooltip" title="Chi tiết">
            <i class="fas fas fa-eye"></i> 
            </a>';
            
            $string = $string.'<a type="button" onclick="showEditUser('.$user->id.')"  class="btn btn-xs btn-warning" data-tooltip="tooltip" title="Chỉnh sửa">
            <i class="fas fa-edit"></i> 
            </a>';
            
            $string = $string.'<a type="button" data-id="'.$user->id.'" class="btn btn-xs btn-danger btn-delete" data-tooltip="tooltip" title="Xóa">
            <i class="fas fa-trash-alt"></i>  
            </a>';

            return $string;
        })
        ->rawColumns(['action', 'gender', 'email', 'phone'])
        ->toJson();
    }

    public function getListRoleUser(Request $request){
        $roles = Role::whereNull('deleted_at')->orderBy('id', 'desc')->get();

        foreach ($roles as $key => $val) {
            $val['user_id'] = $request->id;
        }

        return datatables()->of($roles)
        ->addIndexColumn()
        ->editColumn('created_at', function($role){
            return date('H:i | d-m-Y', strtotime($role->created_at));
        })
        ->addColumn('action', function($role){
            $string = '';
            $check = RoleUser::where('user_id', $role->user_id)->where('role_id', $role->id)->first();

            if(empty($check)){
                $string = $string.'<input type="checkbox" onclick="addRoleUser('.$role->user_id.', '.$role->id.', 0)" id="select'.$role->id.'" data-tooltip="tooltip" title="Chọn vai trò">';
            }else{
                $string = $string.'<input type="checkbox" onclick="addRoleUser('.$role->user_id.', '.$role->id.', 1)" checked id="select'.$role->id.'" data-tooltip="tooltip" title="Bỏ vai trò">';
            }

            return $string;
        })
        ->rawColumns(['action'])
        ->toJson();
    }

    public function addDelRole(Request $request){
        $data = $request->all();

        try {
            if($data['type'] == 1){
                RoleUser::create([
                    'role_id' => $data['role_id'],
                    'user_id' => $data['user_id'],
                ]);
            }else{
                RoleUser::where('role_id', $data['role_id'])->where('user_id', $data['user_id'])->delete();
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

    public function contactUser(){
        return view('user.contact');
    }

    public function getListContactUser(){
        $users = User::whereNull('deleted_at')->orderBy('id', 'desc')->get();

        return datatables()->of($users)
        ->addIndexColumn()
        ->editColumn('gender', function($user){
            if($user->gender == 0){
                return '<i class="mdi mdi-gender-female" data-tooltip="tooltip" title="Nữ"></i>';
            }else{
                return '<i class="mdi mdi-gender-male" data-tooltip="tooltip" title="Nam"></i>';
            }
        })
        ->editColumn('email', function($user){
            return '<a href="mailto:'.$user->email.'">'.$user->email.'</a>';
        })
        ->editColumn('phone', function($user){
            return '<a href="call:'.$user->phone.'">'.$user->phone.'</a>';
        })
        ->editColumn('department', function($user){
            if(!empty($user->department)){
                return $user->department->department;
            }else{
                return 'Chưa cập nhật';
            }
        })
        ->editColumn('job', function($user){
            if($user->job != ''){
                return $user->job;
            }else{
                return 'Chưa cập nhật';
            }
        })
        ->editColumn('address', function($user){
            if($user->address != ''){
                return $user->address;
            }else{
                return 'Chưa cập nhật';
            }
        })
        ->rawColumns(['gender', 'email', 'phone'])
        ->toJson();
    }
}
