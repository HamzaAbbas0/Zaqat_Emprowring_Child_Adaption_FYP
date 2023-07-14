<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Request as ServiceRequest;
use Auth;
use App\Models\Notification;
use App\Enums\NotificationType;

class HistoryController extends Controller
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
        $requests = ServiceRequest::where('user_id', Auth::id())
            ->orderbyDesc('created_at')->get();

        return view('history.index', [
            "requests" => $requests
        ]);
    }

    public function adoption()
    {
        $notifications = Notification::where('type', NotificationType::REQUEST_TO_HELP_CHILDRENS)
            ->where('user_id', Auth::user()->id)->orderbyDesc('created_at')->get();

        return view('history.adoption-history', [
            "notifications" => $notifications
        ]);
    }
}
