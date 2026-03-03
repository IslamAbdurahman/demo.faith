<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
//    protected $redirectTo = RouteServiceProvider::HOME;

    public function redirectTo() {

        if (expire() < 0){
            Auth::logout();
            return route('login');
        }

//        $role_id = Auth::user()->role;
//        $role = DB::table('roles as r')
//            ->where('r.id','=',$role_id)
//            ->select('r.*')->first();

        return route('dashboard.index');

//        switch ($role_id) {
//            case 1:
//                return route('dashboard.index');
//                break;
//            case 4:
//                return route('students.index');
//                break;
//            default:
//                return '/admin/admin';
//                break;
//        }

    }



    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
}
