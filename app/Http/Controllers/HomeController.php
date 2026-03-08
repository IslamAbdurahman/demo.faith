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
        $this->middleware('auth')->except(['welcome']);
    }

    public function welcome()
    {
        if (Auth::user()) {
            if (Auth::user()->role == 1) {
                return redirect()->route('dashboard.index');
            } elseif (Auth::user()->role == 4) {
                return redirect()->route('groups.index');
            } else {
                return view('welcome');
            }
        } else {
            return redirect()->route('login');
        }
    }

    public function dashboard()
    {
        return view('index');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
//        dd(Auth::user()->role);
        return view('home');
    }
}
