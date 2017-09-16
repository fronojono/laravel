<?php

namespace App\Http\Controllers\CustomerAuth;

use App\Customer;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Auth;

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
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/customer/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('customer.guest');
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
        'prenom'=>'required|max:255',
        'adresse'=>'required|max:255',
        'lng'=>'required|max:255',
        'lat'=>'required|max:255',
        'email' => 'required|email|max:255|unique:commercants',
        'telephone'=>'required|max:8',
        'password' => 'required|min:6|confirmed',
    ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return Customer
     */
    protected function create(array $data)
    {
      return Customer::create([
          'name' => $data['name'],
          'prenom' => $data['prenom'],
          'adresse' => $data['adresse'],
          'lng' => $data['lng'],
          'lat' => $data['lat'],
          'telephone' => $data['telephone'],
          'email' => $data['email'],

          'password' => bcrypt($data['password']),
      ]);
    }

    /**
     * Show the application registration form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showRegistrationForm()
    {
        return view('customer.auth.register');
    }

    /**
     * Get the guard to be used during registration.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard('customer');
    }
}