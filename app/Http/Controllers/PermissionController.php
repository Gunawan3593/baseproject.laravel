<?php

namespace App\Http\Controllers;

use Spatie\Permission\Models\Permission;
use Yajra\Datatables\Datatables;
use Illuminate\Http\Request;
use Auth;

class PermissionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:permission show', ['only' => ['index', 'showAll']]);
        $this->middleware('permission:permission create', ['only' => ['create','store']]);
        $this->middleware('permission:permission edit', ['only' => ['edit','update']]);
        $this->middleware('permission:permission delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $page = $this->getPage('permission');
        return view('permissions.permission', ['page' => $page]);
    }

    public function showAll()
    {
        $permissions = Permission::All();
        return Datatables::of($permissions)
        ->editColumn('created_at', function ($permissions){
            return $permissions->created_at->diffForHumans();
        })
        ->addColumn('action', function ($permissions){
            return '';
        })
        ->addColumn('accEdit', function (){
            return Auth::user()->can('permission edit');
        })
        ->addColumn('accDelete', function (){
            return Auth::user()->can('permission delete');
        })
        ->make(true);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required'
        ]);
        $permissions = explode(",", $request->name);
        $response = [];
        try {
            $failed = 0;
            $countData = 0;
            foreach ($permissions as $permission) {
                $permission = trim($permission);
                if (strlen($permission) > 0) {
                    $countData = $countData + 1;
                    $checkExists = Permission::where('name', '=', $permission)->count();
                    if ($checkExists > 0) {
                        $failed = $failed + 1;
                    } else {
                        Permission::create(['name' => $permission]);
                    }
                }
            }
            
            if ($failed === $countData) {
                $response = [
                    'status' => false,
                    'data' => 'data duplikat'
                ];
            } else {
                $success = $countData - $failed;
                $response = [
                    'status' => true,
                    'data' => "berhasil input {$success} dari {$countData} data"
                ];
            }
        } catch (\Illuminate\Database\QueryException $e) {
            $this->sendMessageBot(basename(__FILE__), __FUNCTION__, $e->getMessage());
            $response = [
                'status' => false,
                'data' => 'gagal tambah data'
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
    public function show()
    {
        $data = Permission::get();
        return json_encode($data, 200);
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $response = [];
        try {
            $data = Permission::find($id);
            $response = [
                'status' => true,
                'data' => $data
            ];
        } catch (\Illuminate\Database\QueryException $e) {
            $this->sendMessageBot(basename(__FILE__), __FUNCTION__, $e->getMessage());
            $response = [
                'status' => false,
                'data' => 'data tidak ditemukan'
            ];
        }
        return response()->json($response, 200);
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
        $validatedData = $request->validate([
            'id' => 'required|integer',
            'name' => 'required'
        ]);
        $response = [];
        $permission = trim($request->name);
        $checkExists = Permission::where('name', '=', $permission)->count();
        if ($checkExists) {
            $response = [
                'status' => true,
                'data' => 'tidak ada perubahan data'
            ];
        } else {
            try {
                $data = Permission::find($request->id);
                $data->name = $request->name;
                try {
                    $data->save();
                    $response = [
                        'status' => true,
                        'data' => 'data berhasil diedit'
                    ];
                } catch (\Illuminate\Database\QueryException $e) {
                    $this->sendMessageBot(basename(__FILE__), __FUNCTION__, $e->getMessage());
                    $response = [
                        'status' => false,
                        'data' => 'gagal edit data'
                    ];
                }
            } catch (Illuminate\Database\QueryException $e) {
                $this->sendMessageBot(basename(__FILE__), __FUNCTION__, $e->getMessage());
                $response = [
                    'status' => false,
                    'data' => 'data tidak ditemukan'
                ];
            }
        }

        return $response;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = Permission::find($id);
        $response = [];
        try {
            $data->delete();
            $response = $this->destroyTrue();
            
        } catch (\Illuminate\Database\QueryException $e) {
            $this->sendMessageBot(basename(__FILE__), __FUNCTION__, $e->getMessage());
            $response = $this->destroyFalse();
        }

        return $response;
    }
}
