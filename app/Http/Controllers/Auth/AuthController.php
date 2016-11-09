<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;

// use App\Session;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    public function postLogin(Request $request)
    {    

        // if( $user =='admin') //test if is first login ..
        // {
        //     $this->redirectPath = '/admin/myHalls';
        // } else
        // {
        //     $this->redirectPath = '/myHalls';
        // }

        $email = $request->get('email'); 
        $password=$request->get('password');
        
        // temporary check
        if( $email == 'admin@admin.com' )
        {            
            $user = DB::table('users')->where('email', $email)->value('name');
            //Set session in AuthenticateUsers.php
            $request->session()->put('user', $user);
            $request->session()->put('email', $email);
            
            $this->redirectPath = '/admin/myHalls';
            // return redirect()->action('AdminController@myHalls'); 

        }
        else
        {
            $user = str_replace("@nitt.edu", "", $email);
            $shellcmd = "python2 nitt_imap_login.py ".$user." ".$password;
            $imap = shell_exec($shellcmd);
            if($imap == 1)
            {   
                // dd($user." ".$imap);
                $request->session()->put('user', $user);
                $request->session()->put('email', $email);

                return redirect()->action('MyHallsController@myHalls'); 
                // $this->redirectPath = '/myHalls';
            }
            else
            {
               // $this->redirectPath = '/';
                    return view('auth/login');

                // return redirect()->route('/', ['message' => '<font color="red">Incorrect username or password</font>']);
            }
        }

        // protected $redirectTo = '/';
        
        //then you call the orinal login method 
        return $this->login($request);
    }

    
    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => ['logout', 'getLogout']]);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
    }
}
