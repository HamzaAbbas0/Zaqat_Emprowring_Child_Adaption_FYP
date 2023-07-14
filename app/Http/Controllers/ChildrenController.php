<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ServiceField;
use App\Enums\ServiceTypes;
use App\Models\Family;
use App\Models\Service;
use App\Models\Children;
use App\Models\Notification;
use Redirect;
use Auth;
use Validator;
use App\Enums\NotificationModelTypes;
use App\Enums\NotificationType;
use App\Enums\NotificationTitle;
use App\Enums\NotificationStatus;
use Mail;
use App\Mail\ServiceRequestMail;

class ChildrenController extends Controller
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
        $adoptedChildIds = [];
        $models = Notification::where('type', NotificationType::REQUEST_TO_HELP_CHILDRENS_RECEIVED)->get();

        foreach ($models as $key => $model) {
            $meta = json_decode($model->meta);
            if ($meta) {
                foreach ($meta as $m) {
                    array_push($adoptedChildIds, $m);
                }
            }
        }

        $childrens = Children::where('status', 1)
            ->whereNotIn('id', $adoptedChildIds)
            ->get();

        return view('childrens.index', [
            'childrens' => $childrens
        ]);
    }

    public function help(Request $request)
    {
        //send email
        $body = [
            'name' => Auth::user()->name,
            'email' => Auth::user()->email,
            'service' => "Adoption"
        ];

        Mail::to(Auth::user()->email)->send(new ServiceRequestMail($body));

        $meta = json_encode($request->childrens);
        //User Notification
        addNotification(
            NotificationType::REQUEST_TO_HELP_CHILDRENS,
            NotificationModelTypes::CHILDRENS,
            0,
            NotificationTitle::TITLE['REQUEST_TO_HELP_CHILDRENS'],
            NotificationTitle::BODY['REQUEST_TO_HELP_CHILDRENS'],
            Auth::user()->id,
            $meta
        );

        //User Notification
        addNotification(
            NotificationType::REQUEST_TO_HELP_CHILDRENS_RECEIVED,
            NotificationModelTypes::CHILDRENS,
            0,
            str_replace(['{{name}}'], [Auth::user()->name], NotificationTitle::TITLE['REQUEST_TO_HELP_CHILDRENS_RECEIVED']),
            str_replace(
                ['{{name}}'],
                ["<a href='users/" . Auth::user()->id . "'>" . Auth::user()->name . "</a>"],
                NotificationTitle::BODY['REQUEST_TO_HELP_CHILDRENS_RECEIVED']
            ),
            0,
            $meta
        );

        return Redirect::back()->with(['flash_success' => "Your request to adopt has been submitted"]);
    }

    public function helpView($id)
    {

        $notification = Notification::where('id', $id)->first();

        if (!$notification) return null;

        $meta = json_decode($notification->meta);

        $childrens = Children::where('status', 1)->whereIn('id', $meta)->get();

        return view('childrens.view', [
            'childrens' => $childrens
        ]);
    }

    public function helpDelete($id)
    {
        $notification = Notification::where('id', $id)->first();

        if (!$notification) return Redirect::back();

        $notification->delete();

        return Redirect::back();
    }

    public function helpArchive($id)
    {
        $notification = Notification::where('id', $id)->first();

        if (!$notification) return Redirect::back();

        $notification->status = NotificationStatus::Archived; //archive
        $notification->save();

        return Redirect::back()->with(['flash_success' => "Request has been archived"]);
    }

    public function helpUnArchive($id)
    {
        $notification = Notification::where('id', $id)->first();

        if (!$notification) return Redirect::back();

        $notification->status = NotificationStatus::Active; //unarchive
        $notification->save();

        return Redirect::back()->with(['flash_success' => "Request has been archived"]);
    }
}
