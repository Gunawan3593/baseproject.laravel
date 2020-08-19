<?php

namespace App\Http\Controllers;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Yajra\Datatables\Datatables;
use Illuminate\Http\Request;
use DB;
use Auth;

class RoleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:role show', ['only' => ['index', 'showAll']]);
        $this->middleware('permission:role create', ['only' => ['create','store']]);
        $this->middleware('permission:role edit', ['only' => ['edit','update']]);
        $this->middleware('permission:role delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $page = $this->getPage('roles');
        return view('permissions.role', ['page' => $page]);
    }

    public function showAll()
    {
        $roles = Role::orderBy('id', 'DESC');
        return Datatables::of($roles)
        ->editColumn('created_at', function ($roles){
            return $roles->created_at->diffForHumans();
        })
        ->addColumn('action', function ($roles){
            return '';
        })
        ->addColumn('accEdit', function (){
            return Auth::user()->can('role edit');
        })
        ->addColumn('accDelete', function (){
            return Auth::user()->can('role delete');
        })
        ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $page = $this->getPage('addrole');
        return view('permissions.formrole', ['page' => $page]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'permission' => 'required'
        ]);
        
        $response = [];
        $roleName = $request->name;
        try {
            $checkExists = Role::where('name', '=', $roleName)->count();
            if ($checkExists === 0) {
                $role = Role::create(['name' => $roleName]);
                $role->syncPermissions($request->permission);
                $response = [
                    'status' => true,
                    'data' => "berhasil input data"
                ];
            } else {
                $response = [
                    'status' => false,
                    'data' => 'data duplikat'
                ];
            }
        } catch (\Illuminate\Database\QueryException $e) {
            $this->sendMessageBot(basename(__FILE__), __FUNCTION__, $e->getMessage());
            $response = [
                'status' => false,
                'data' => "input data gagal"
            ];
        }
        return response()->json($response, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $role = Role::find($id);
        $permissions = DB::table("role_has_permissions")
        ->where("role_has_permissions.role_id",$id)
        ->pluck('role_has_permissions.permission_id')
        ->all();
        return response()->json([$role, $permissions], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $page = $this->getPage('editrole');
        return view('permissions.formrole', ['id' => $id, 'page' => $page]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $request->validate([
            'id' => 'required',
            'name' => 'required',
            'permission' => 'required'
        ]);
        $response = [];

        try {
            $role = Role::find($request->id);
            $role->name = $request->name;
            $role->save();
            $role->syncPermissions($request->permission);
            $response = [
                'status' => true,
                'data' => 'data berhasil diedit'
            ];
        } catch (\Illuminate\Database\QueryException $e) {
            $this->sendMessageBot(basename(__FILE__), __FUNCTION__, $e->getMessage());
            $response = [
                'status' => false,
                'data' => 'terjadi kesalahan saat edit data'
            ];
        }

        return response()->json($response, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = Role::find($id);
        $response = [];
        try {
            $data->delete();
            $response = [
                'status' => true,
                'data' => 'data berhasil dihapus'
            ];
            
        } catch (\Illuminate\Database\QueryException $e) {
            $this->sendMessageBot(basename(__FILE__), __FUNCTION__, $e->getMessage());
            $response = [
                'status' => false,
                'data' => 'data gagal dihapus'
            ];
        }

        return $response;
    }

    public function roleList()
    {
        $data= Role::pluck('name')->all();
        echo json_encode($data, 200);
    }
}
