<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;

use Illuminate\Http\Request;
use App\ActivationService;

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
    protected $redirectTo = '/tasks';

    /**
     * Lets define a handle to our ActivationService
     *
     */
    protected $activationService;

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct(ActivationService $activationService)
    {
        $this->middleware($this->guestMiddleware(), ['except' => 'logout']);

        $this->activationService = $activationService;
    }

    /**
     * Override the default register method to add our own fields to the form
     */
    public function register(Request $request){
        
        $validator = $this->validator($request->all());

        if($validator->fails()){
            $this->throwValidationException($request, $validator);
        }

        $user = $this->create($request->all());

        $this->activationService->sendActivationMail($user);

        return redirect('/login')->with('status', 'We sent you an activation link in the email you have registered with, kindly click it and lets get started with these tasks :)' );
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
            'firstname' => 'max:255',
            'lastname'  => 'max:255',
            'email'     => 'required|email|max:255|unique:users',
            'password'  => 'required|min:6|confirmed',
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
            'firstname' => $data['firstname'],
            'lastname'  => $data['lastname'],
            'email'     => $data['email'],
            'password'  => bcrypt($data['password']),
        ]);
    }

    /**
     * Method will be called from the laravel trait AuthenticatesUser
     *
     * Blocks the user if not activated yet and if required, we resend the email with the activation link 
     *
     */
    public function authenticated(Request $request, $user){
        if(!$user->activated){
            $this->activationService->sendActivationMail($user);
            auth()->logout();

            return back()->with('warning', 'You need to confirm your accont. We have sent you an activation code, Please check your email.');
        }

        return redirect()->intended($this->redirectPath());
    }// end authenticated


    public function activateUser($token){
        if($user = $this->activationService->activateUser($token)){
            auth()->login($user);
            return redirect($this->redirectPath());
        }

        abort(404);
    }
}
