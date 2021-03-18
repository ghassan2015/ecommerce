<?php

namespace App\Http\Controllers\Dealer\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\DelaerLogin;
use App\Providers\RouteServiceProvider;
use http\Env\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

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
    protected $redirectTo = RouteServiceProvider::DEALER;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest:dealer')->except('logout');

    }

    public function login()
    {

        return view('dealers.auth.login');
    }


    public function postLogin(\Illuminate\Http\Request $request)
    {
        $this->validate($request, [
            'email'           => 'required|max:255|email',
            'password'           => 'required|',
        ]);
        try {

            $remember_me = $request->has('remember_me') ? true : false;

            if (auth()->guard('dealer')->attempt(['email' => $request->input("email"), 'password' => $request->input("password")], $remember_me)) {
                return redirect()->route('dealer.dashboard');
            }
            return view('dealers.auth.login');

        } catch (\Exception $ex) {
            return $ex;
        }


    }
    public function logout()
    {

        $gaurd = $this->getGaurd();
        $gaurd->logout();

        return redirect()->route('dealer.login');
    }
    private function getGaurd()
    {
        return auth('dealer');
    }
}
