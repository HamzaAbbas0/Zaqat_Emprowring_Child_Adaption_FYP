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

class FamilyController extends Controller
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

        $families = Family::where('status', 1)->get();

        return view('family.index', [
            'families' => $families
        ]);
    }

    public function view($id)
    {
        $family = Family::where('id', $id)->first();

        if ($family == null) return Redirect::back();

        return view('family.view', [
            'family' => $family
        ]);
    }

    public function wantToHelp(Request $request)
    {
        if ($request->isMethod('post')) {
            $data = $request->only('family_id', 'childrens');

            $validator = Validator::make($data, [
                'family_id' => 'required|exists:families,id',
                'childrens' => [
                    'required',
                    'array',
                    function ($attribute, $value, $fail) {
                        if (!in_array('*', $value) && !Children::wherein('id', $value)->exists()) {
                            $fail('Selected ' . $attribute . ' is invalid.');
                        }
                    },
                ],
            ]);

            if ($validator->fails()) {
                return Redirect::back()->with(['flash_error' => $validator->errors()->first()]);
            } else {
                $family = Family::find($request->family_id);

                if (!$family) return Redirect::back();

                $meta = json_encode($request->childrens);
                //User Notification
                addNotification(
                    NotificationType::REQUEST_TO_HELP_FAMILY,
                    NotificationModelTypes::FAMILY,
                    $family->id,
                    NotificationTitle::TITLE['REQUEST_TO_HELP_FAMILY'],
                    NotificationTitle::BODY['REQUEST_TO_HELP_FAMILY'],
                    Auth::user()->id,
                    $meta
                );

                //User Notification
                addNotification(
                    NotificationType::REQUEST_TO_HELP_FAMILY_RECEIVED,
                    NotificationModelTypes::FAMILY,
                    $family->id,
                    str_replace(['{{name}}'], [Auth::user()->name], NotificationTitle::TITLE['REQUEST_TO_HELP_FAMILY_RECEIVED']),
                    str_replace(
                        ['{{name}}'],
                        ["<a href='/users/" . Auth::user()->id . "'>" . Auth::user()->name . "</a>"],
                        NotificationTitle::BODY['REQUEST_TO_HELP_FAMILY_RECEIVED']
                    ),
                    0,
                    $meta
                );

                return Redirect::back()->with(['flash_success' => "Your Request to help has been submitted"]);
            }
        }
    }

    public function requestedToHelp()
    {
        $families = Family::join("notifications", "notifications.model_id", "families.id")
            ->where('type', 'request_to_help_family')
            ->where('notifications.user_id', Auth::user()->id)
            ->select([
                'families.id as id',
                'families.people_in_household as people_in_household',
                'notifications.id as notification_id',
                'notifications.created_at as created_at'
            ])
            ->get();

        return view('family.requested-to-help', [
            'families' => $families
        ]);
    }

    public function requestedToHelpView($id, $notification_id)
    {
        $family = Family::where('id', $id)->first();

        if ($family == null) return Redirect::back();

        $notification = Notification::where('id', $notification_id)->first();

        if ($notification == null) return Redirect::back();

        if ($notification->meta) {
            $family->children = Children::whereIn('id', json_decode($notification->meta))->get();
        }

        return view('family.requested-to-help-view', [
            'family' => $family
        ]);
    }

    public function deleteFamily($notification_id){

        $notification = Notification::where('id', $notification_id)->first();
        $family = Family::where('id', $notification->model_id)->first();

        if ($notification == null) return Redirect::back();

        if ($family == null) return Redirect::back();

        Children::where('family_id', $family->id)->delete();
        $family->delete();
        $notification->delete();

        return Redirect::back()->with(['flash_success' => "Family has been removed"]);
    }
}
