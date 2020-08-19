<?php

namespace App\Http\Controllers;

use App\Page;
use Auth;
use Yajra\Datatables\Datatables;
use App\Http\Requests\PageStoreRequest;
use App\Http\Requests\PageUpdateRequest;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:page show', ['only' => ['index', 'showAll']]);
        $this->middleware('permission:page create', ['only' => ['create','store']]);
        $this->middleware('permission:page edit', ['only' => ['edit','update']]);
        $this->middleware('permission:page delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $page = $this->getPage('pages');
        return view('pages.index', ['page' => $page]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function showAll()
    {
        $data = Page::All();
        return Datatables::of($data)
        ->editColumn('created_at', function ($data){
            return $data->created_at->diffForHumans();
        })
        ->addColumn('action', function ($data){
            return '';
        })
        ->addColumn('accEdit', function (){
            return Auth::user()->can('page edit');
        })
        ->addColumn('accDelete', function (){
            return Auth::user()->can('page delete');
        })
        ->make(true);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PageStoreRequest $request)
    {
        $data = [
            'page_code' => $request->page_code,
            'page_title' => $request->page_title,
            'page_description' => $request->page_description,
            'insert_by' => Auth::id()
        ];

        $response = [];
        try {
            Page::create($data);
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
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $response = [];
        try {
            $data = Page::find($id);
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
    public function update(PageUpdateRequest $request)
    {
        $id = $request->id;
        $data = [
            'page_code' => $request->page_code,
            'page_title' => $request->page_title,
            'page_description' => $request->page_description,
            'insert_by' => Auth::id()
        ];

        $response = [];
        try {
            Page::find($id)->update($data);
            $response = [
                'status' => true,
                'data' => 'edit data berhasil'
            ];
        } catch (\Illuminate\Database\QueryException $e) {
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
        $data = Page::find($id);
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

        return response()->json($response, 200);
    }
}
