<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Enums\UserTypes;
use App\Enums\UserStatus;
use Illuminate\Validation\ValidationException;
use Mail;
use App\Mail\SignUpMail;

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
    protected $redirectTo = RouteServiceProvider::HOME;

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
            'name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'address' => ['required', 'string', 'max:500'],
            'contact_no' => ['required', 'max:20']
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            // 'role_id' => $data['user_type'] == 'donor' ? UserTypes::Donor : UserTypes::Applicant,
            'role_id' => UserTypes::Applicant,
            'status' => UserStatus::Active,
            'address' => $data['address'],
            'contact_no' => $data['contact_no']
        ]);
    }

    public function register(Request $request)
    {

        $this->validator($request->all())->validate();

        $user = $this->create($request->all());

        // if ($user->role_id == UserTypes::Applicant) {
        if ($request->hasFile('residence_verification')) {
            $user->addMediaFromRequest('residence_verification')->toMediaCollection('residence_verification');
        }

        if ($request->hasFile('upload_picture')) {
            $user->addMediaFromRequest('upload_picture')->toMediaCollection('upload_picture');
        }
        // }

        if ($user->status == UserStatus::Inactive && $user->role_id == UserTypes::Applicant) {
            throw ValidationException::withMessages([
                'inactive' => ["Congratulations, Your account has been created. Please wait for account apporval."],
            ]);
        }

        $body = [
            'name' => $user->name,
            'email' => $user->email,
        ];

        //Mail::to($user->email)->send(new SignUpMail($body));

        $this->guard()->login($user);

        return $request->wantsJson()
            ? new JsonResponse([], 201)
            : redirect($this->redirectPath());
    }
}
