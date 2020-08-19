<?php

namespace App\Http\Controllers;
use DB;
use Illuminate\Http\Request;
use \Carbon\Carbon as Carbon;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $page = $this->getPage('dashboard');
        return view('home', ['page' => $page]);
    }
}
