<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller {
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
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('guest')->except('logout');
    }

    public function webLoginPost(Request $request) {
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required',
        ]);


        $remember_me = $request->has('remember_me') ? true : false;


        if (auth()->attempt(['email' => $request->input('email'), 'password' => $request->input('password')], $remember_me)) {
            $user = auth()->user();
            dd($user);
        } else {
            return back()->with('error', 'your username and password are wrong.');
        }
    }

    public function redirectTo() {
        if (Auth::user()->isadmin == 1) {
            return '/admin';
        } else if (Auth::user()->isadmin == 2) {
            return '/admin/settings';
        } else {
            return '/home/mypage';
        }
    }

}
