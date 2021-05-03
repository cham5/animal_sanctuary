<?php

namespace App\Http\Controllers;

use Gate;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // if the user has admin rights, take them to the staff home page
        // if not, take them to the public user home page
        if(Gate::allows('admin-check')) {
            return redirect('/home/staff');
        } else {
            return redirect('/home/public');
        }
    }
}
