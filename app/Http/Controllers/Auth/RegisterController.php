<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Role;
use App\Lecturer;
use App\Supervisor;
use App\TO;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/dashboard';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('guest');
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
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'contact' => 'regex:/(0)[0-9]{9}/',
            'role' => 'required',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {

        $user=User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);

        $user->roles()->attach($data['role']);

        if($data['role'] == 1){
            TO::create([
                'id' => $user->id,
                'status' => $data['optradio'],
                'name' => $data['name'],
                'email' => $data['email'],
                'contact' => $data['contact'],
            ]);
        }
        
        if($data['role'] == 2){
            Lecturer::create([
                'id' => $user->id,
                'status' => $data['optradio'],
                'designation' => $data['designation'],
                'name' => $data['name'],
                'email' => $data['email'],
                'contact' => $data['contact'],
            ]);
        }

        if($data['role'] == 3){
            Supervisor::create([
                'id' => $user->id,
                'status' => $data['optradio'],
                'name' => $data['name'],
                'email' => $data['email'],
                'contact' => $data['contact'],
            ]);
        }

        return $user;
    }

    public function showRegistrationForm()
    {
        $roles = Role::orderBy('name','desc')->pluck('name','id');
        //return $roles;
        return view('auth.register')->with('roles',$roles);
    }
}
