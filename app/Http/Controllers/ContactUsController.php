<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Mail;
use App\Mail\ConactMail;
use Auth;
use Redirect;

class ContactUsController extends Controller
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
            $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'email', 'max:255'],
                'subject' => ['required', 'string', 'max:300'],
                'message' => ['required']
            ]);


            $body = [
                'name' => $request->name,
                'email' => $request->email,
                'subject' => $request->subject,
                'message' => $request->message,
                'author' => [
                    'name' => Auth::user()->name,
                    'email' => Auth::user()->email,
                ]
            ];
     
            Mail::to(env('ADMIN_NOTIFICATION_EMAIL'))->send(new ConactMail($body));

            return Redirect::to($request->path())->with(['flash_success' => "Congratulations!, Your request has been posted."]);
        }
        
        return view('contact.index');
    }
}
