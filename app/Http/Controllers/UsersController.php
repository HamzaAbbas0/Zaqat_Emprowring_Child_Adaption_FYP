<?php

namespace App\Http\Controllers;

use App\Enums\UserStatus;
use Auth;
use Illuminate\Http\Request;
use App\Models\User;
use Redirect;
use App\Enums\UserTypes;
use App\Models\UserNote;
use App\Models\UserRole;
use Illuminate\Support\Facades\Hash;
use App\Mail\RequestUserDocuments;
use Mail;

class UsersController extends Controller
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
    public function index()
    {
        $users = User::orderByDesc('created_at')->get()->except(Auth::id());

        return view('users.index', ['users' => $users]);
    }


    public function view($id)
    {
        $user = User::where('id', $id)->first();

        if (!$user) return Redirect::back();

        return view('users.view', [
            'user' => $user
        ]);
    }

    public function delete($id)
    {
        $user = User::where('id', $id)->first();

        if (!$user) return Redirect::back();

        $user->delete();

        return Redirect::back()->with(['flash_success' => "User has been removed"]);
    }

    public function update(Request $request)
    {

        $user = User::where('id', $request->user_id)->first();
        $user->status = $request->status;
        $user->role_id = $request->account_type;

        if (!$user->save()) return Redirect::back()->with(['flash_error' => "Something went wrong!"]);

        return Redirect::back()->with(['flash_success' => "User has been updated"]);
    }

    public function addUser(Request $request)
    {

        if ($request->isMethod('post')) {
            $request->validate([
                'role' => ['required', 'exists:user_roles,id'],
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'password' => ['required', 'string', 'min:8', 'confirmed'],
            ]);

            User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role_id' => $request->role,
                'status' => UserStatus::Active,
            ]);

            return Redirect::back()->with(['flash_success' => UserTypes::LIST[$request->role] . " has been added"]);
        }

        $roles = UserRole::query();
        if (auth()->user()->role_id == UserTypes::Moderator) {
            $roles = $roles->where('id', '!=', UserTypes::Admin);
        }

        return view('users.add-user', [
            'roles' => $roles->get()
        ]);
    }

    public function addNote(Request $request)
    {
        if ($request->isMethod('post')) {

            $model = User::find($request->user_id);

            if (!$model) return Redirect::back();

            $note = new UserNote();

            $note->note = $request->note;
            $note->by_user_id = Auth::user()->id;
            $note->to_user_id = $request->user_id;
            $note->save();

            return Redirect::back()->with(['flash_success' => "Note added"]);
        }
    }

    public function requestNewDocument(Request $request) {
        if ($request->isMethod('post')) {

            $user = User::where('id', $request->user_id)->first();

            $body = [
                'name' => $user->name,
                'email' => $user->email,
            ];
     
            Mail::to($user->email)->send(new RequestUserDocuments($body));

            return Redirect::back()->with(['flash_success' => "Request to submit document have been sent"]);
        }
    }
}
