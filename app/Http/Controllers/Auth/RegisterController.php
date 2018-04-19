<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Mail;
use App\Mail\emailVerification;
use Session;

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
    protected $redirectTo = '/register';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
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
            'username' => 'required|max:255|unique:users'
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
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'username' => $data['username'],
            'verification' => 0,
            'token_verification'=> Str::random(40),
            'is_penghuni' => 0,
            'is_pengelola' => 0,
            'is_sekretariat' => 0,
            'is_pimpinan' => 0,
            'is_admin' => 0,

        ]);
        $thisUser = User::findOrFail($user->id);
        $this->sendEmail($thisUser);
        return $user;
    }

    public function sendEmail($thisUser){
        Mail::to($thisUser['email'])->send(new emailVerification($thisUser));
    }

    public function VerificationEmail()
    {
        return view('email.verificationEmail');
    }

    public function sendEmailDone($email,$token_verification)
    {
        $user = User::where(['email'=>$email,'token_verification'=>$token_verification])->first();
        if($user){
            User::where(['email'=>$email,'token_verification'=>$token_verification])->update(['verification'=>'1','token_verification'=>NULL]);
            $message = 'Akun dengan email '.$email.' berhasil diverifikasi. Anda sudah dapat melakukan login dan melanjutkan ke aplikasi selanjutnya.';
            return view('email.verificationSuccess',['email'=>$email,'message'=>$message]);
        } else{
            $message = 'Akun dengan email '.$email.' sudah teraktivasi. Silahkan login untuk melihat aplikasi selanjutnya.';
            return view('email.verificationSuccess',['email'=>$email,'message'=>$message]);
        }
    }
}
