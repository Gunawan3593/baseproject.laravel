<?php

namespace App\Http\Controllers;
use App\User;
use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserUpdateRequest;
use Yajra\Datatables\Datatables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Image;
use DB;
use Auth;
class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:user show', ['only' => ['index', 'showAll']]);
        $this->middleware('permission:user create', ['only' => ['create','store']]);
        $this->middleware('permission:user edit', ['only' => ['edit','update']]);
        $this->middleware('permission:user delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        $page = $this->getPage('alluser');
        return view('users.index', ['page' => $page]);
    }

    public function showAll()
    {
        $users = User::orderBy('id', 'DESC');
        return Datatables::of($users)
        ->addColumn('action', function($users){
            return '';
        })
        ->addColumn('accEdit', function (){
            return Auth::user()->can('user edit');
        })
        ->addColumn('accDelete', function (){
            return Auth::user()->can('user delete');
        })->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $page = $this->getPage('createuser');
        return view('users.formuser', ['page' => $page]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserStoreRequest $request)
    {
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        if ($request->image) {
            $file = 'avatar_'.time().'.png';
            $path = public_path('img/avatar')."/{$file}";
            $img = Image::make(file_get_contents($request->image))->save($path);
            $user->avatar = $file;
        }
        $response = [];
        try {
            $user->save();
            $user->assignRole($request->role);
            $response = [
                'status' => true,
                'data' => "input data berhasil"
            ];
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
    public function show($id)
    {
        $user = User::find($id);
        $roles = $user->roles->pluck('name')->all();
        return response()->json([$user, $roles], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $page = $this->getPage('edituser');
        return view('users.formuser', ['id' => $id, 'page' => $page]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserUpdateRequest $request)
    {
        $id = $request->id;
        $user = User::find($id);
        $user->name = $request->name;
        $user->email = $request->email;
        if ($request->password) {
            $user->password = Hash::make($request->password);
        }
        if ($request->image) {
            $file = 'avatar_'.time().'.png';
            $path = public_path('img/avatar')."/{$file}";
            $img = Image::make(file_get_contents($request->image))->save($path);
            $user->avatar = $file;
        }
        $response = [];
        try {
            $user->save();
            DB::table('model_has_roles')->where('model_id', $id)->delete();
            $user->assignRole($request->role);
            $response = [
                'status' => true,
                'data' => "edit data berhasil"
            ];
        } catch (\Illuminate\Database\QueryException $e) {
            $this->sendMessageBot(basename(__FILE__), __FUNCTION__, $e->getMessage());
            $response = [
                'status' => false,
                'data' => 'gagal edit data'
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
        $data = User::find($id);
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
}
