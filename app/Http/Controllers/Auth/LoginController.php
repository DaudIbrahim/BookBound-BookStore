<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;

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
     */
    protected function redirectTo()
    {
        if (!Auth::user()->is_admin) {
            return ('/home');
        }

        if (Auth::user()->is_admin) {
            return ('/administrator/home');
        }
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


    /**
     * Show the application's login form.
     * Overridden method from AuthenticatesUsers
     *
     * @return \Illuminate\Http\Response
     */
    public function showLoginForm()
    {
        return view('customer.pages.login');
    }
}
