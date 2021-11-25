<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\Http\Controllers\Auth\Validator;
use Laravel\Socialite\Facades\Socialite;

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
    protected $redirectTo = '/index';

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
     * Handle a login request to the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function login(Request $request)
    {


        $input = $request->all();

        $this->validate($request, [
            'email' => 'required',
            'password' => 'required|min:8',
        ]);

        if(auth()->attempt(array('email' => $input['email'], 'password' => $input['password'])))
        {
            return response()->json(['success' => true]);
        }else{
            return response()->json(['success'=>false,'message'=>'Email or Password Are Incorrect.']);
        }
    }

    public function logout(Request $request)
    {

        $this->guard()->logout();
        $request->session()->flush();
        $request->session()->regenerate();
        return redirect('/index');

    }

    public function redirectToProvider()
    {
        return Socialite::driver('google')->redirect();
    }

    public function githubLogin()
    {
        return Socialite::driver('github')->redirect();
    }

    public function handleProviderCallBack(){
        $google_user = Socialite::driver('google')->setHttpClient(new \GuzzleHttp\Client(['verify' => false]))->stateless()->user();
//        dd($google_user);
        $user = User::create([
            'email'=>$google_user->getEmail(),
            'name'=>$google_user->getName(),
            'provider_id'=>$google_user->getId()
        ]);

        \Auth::login($user,true);

        return redirect($this->redirectTo);
    }

    public function githubLoginCallBack(){

        $google_user = Socialite::driver('github')->stateless()->user();
        $user = User::create([
            'email'=>$google_user->getEmail(),
            'name'=>$google_user->getNickname(),
            'provider_id'=>$google_user->getId()
        ]);

        \Auth::login($user,true);

        return redirect($this->redirectTo);

    }

}
