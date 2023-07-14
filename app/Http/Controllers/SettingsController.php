<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Redirect;
use Mail;
use App\Mail\PasswordChangesMail;

class SettingsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        if ($request->isMethod('post')) {

            $validation = [
                'name' => ['required', 'string', 'max:255'],
                'password' => ['required', 'string', 'min:8', 'confirmed'],
                'address' => ['required', 'string', 'max:500'],
                'contact_no' => ['required', 'max:15']
            ];

            if (!$request->password) {
                unset($validation['password']);
            }

            $request->validate($validation);

            $user = User::where('id', Auth::id())->first();

            if ($request->hasFile('upload_picture')) {
                $user->clearMediaCollection('upload_picture');
                $user->addMediaFromRequest('upload_picture')->toMediaCollection('upload_picture');
            }

            if ($request->hasFile('residence_verification')) {
                $user->addMediaFromRequest('residence_verification')->toMediaCollection('residence_verification');
            }

            if ($request->password) {
                $user->password = Hash::make($request->password);
            }

            $user->name = $request->name;
            $user->address = $request->address;
            $user->contact_no = $request->contact_no;

            if ($user->save()) {
                
                if ($request->password) {
                    $body = [
                        'name' => $user->name
                    ];
            
                    Mail::to($user->email)->send(new PasswordChangesMail($body));
                }

                return Redirect::back()->with(['flash_success' => "Profile updated"]);
            }

            return Redirect::back()->with(['flash_error' => "Something went wrong!"]);
        }


        return view('settings.index');
    }
}
