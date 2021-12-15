<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        $user=Auth::user();
        if($user->hasRole('end_user'))
        {
            return view('website.dashboard');
        }
       $data = [
        'category_name' => '',
        'page_name' => 'dashboard',
        'has_scrollspy' => 0,
        'scrollspy_offset' => '',
    ];

      return view('dashboard2')->with($data);
       
    }
}
