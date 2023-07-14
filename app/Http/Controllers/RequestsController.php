<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Service;
use App\Models\Request as ServiceRequest;
use App\Models\RequestMeta;
use App\Enums\RequestTypes;
use App\Enums\UserTypes;
use App\Models\ServiceField;
use App\Models\RequestNote;
use App\Enums\NotificationTitle;
use App\Enums\NotificationModelTypes;
use App\Enums\NotificationType;
use App\Models\User;
use Auth;
use Redirect;
use Mail;
use App\Mail\ServiceRequestMail;

class RequestsController extends Controller
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
        $requests = ServiceRequest::orderByDesc('created_at');

        if (Auth::user()->role_id == UserTypes::Donor) {
            $requests = $requests->where('status', RequestTypes::Approved);
        }

        return view('requests.index', [
            "requests" => $requests->get()
        ]);
    }

    public function create(Request $request)
    {
        if ($request->isMethod('post')) {

            $request->validate([
                'user' => ['nullable', 'exists:users,id'],
                'first_name' => ['required', 'string', 'max:255'],
                'last_name' => ['required', 'string', 'max:255'],
                'address' => ['required', 'string', 'max:500'],
                'residence_verification' => ['required'],
                'contact_no' => ['required', 'max:15'],
                'alternate_no' => ['required', 'max:15'],
                'email' => ['required', 'string', 'email', 'max:255'],
                'service_id' => ['required'],
                'wants' => ['required', 'string', 'max:1000'],
                'reason' => ['required', 'string', 'max:1000'],
            ], [
                'residence_verification.required' => 'Please attach Verification of Residence.',
                'service_id.required' => 'Please select any service.',
            ]);

            $user_id = Auth::id();
            if (in_array(auth()->user()->role_id, [UserTypes::Admin, UserTypes::Moderator])) {

                if (isset($request->user)) {
                    $user_id = $request->user;
                } else {
                    return Redirect::back()->with(['flash_error' => 'User is Required!']);
                }
            }

            $model = new ServiceRequest();
            $model->user_id = $user_id;
            $model->first_name = $request->first_name;
            $model->last_name = $request->last_name;
            $model->email = $request->email;
            $model->contact_no = $request->contact_no;
            $model->alternate_no = $request->alternate_no;
            $model->address = $request->address;
            $model->service_id = $request->service_id;
            $model->wants = $request->wants;
            $model->reason = $request->reason;
            $model->status = RequestTypes::In_Review;

            if ($request->hasFile('residence_verification')) {
                $model->addMediaFromRequest('residence_verification')->toMediaCollection('residence_verification');
            }

            if ($model->save()) {

                foreach ($request->all() as $key => $field) {
                    if (str_contains($key, '@key') && !str_contains($key, '@key@')) {

                        $requestMeta = new RequestMeta();
                        $requestMeta->field_key = str_replace("@key", "", $key);
                        $requestMeta->name = $request[$key . '@name'];
                        $requestMeta->value = $request[$key];
                        $requestMeta->type = $request[$key . '@type'];
                        $requestMeta->request_id = $model->id;
                        $requestMeta->save();
                    }
                }

                //Notification
                addNotification(
                    NotificationType::NEW_REQUEST,
                    NotificationModelTypes::REQUEST,
                    $model->id,
                    str_replace(['{{name}}'], [Auth::user()->name], NotificationTitle::TITLE['NEW_REQUEST']),
                    str_replace(['{{name}}'], [Auth::user()->name], NotificationTitle::BODY['NEW_REQUEST']),
                    0
                );

                //send email notification
                $selectedService = Service::where('id', $request->service_id)->first();

                if ($selectedService) {
                    $body = [
                        'name' => $request->first_name ." ". $request->last_name,
                        'email' => $request->email,
                        'service' => $selectedService->name
                    ];

                    Mail::to(Auth::user()->email)->send(new ServiceRequestMail($body));
                }

                return Redirect::to($request->path())->with(['flash_success' => "Congratulations!, Your request has been posted."]);
            }

            return Redirect::to($request->path())->with(['flash_error' => "Something went wrong!"]);
        }

        $services = Service::where('status', 1)->where('value', '!=', 'giving-tree')->where('value', '!=', 'adoption')->get();

        if (in_array(auth()->user()->role_id, [UserTypes::Admin, UserTypes::Moderator])) {
            $applicants = User::where(['role_id' => UserTypes::Applicant, 'status' => 1])->get();

            return view('requests.create', [
                "services" => $services,
                "applicants" => $applicants
            ]);
        } else {
            return view('requests.create', [
                "services" => $services,
            ]);
        }
    }

    public function view($id)
    {
        $request = ServiceRequest::where('id', $id)->first();

        if ($request == null) return Redirect::back();

        return view('requests.view', [
            "request" => $request
        ]);
    }

    public function approve($id)
    {
        $request = ServiceRequest::where('id', $id)->first();

        if ($request == null) return Redirect::back();

        $request->status = RequestTypes::Approved;
        $request->save();

        //Notification
        addNotification(
            NotificationType::REQUEST_APPROVED,
            NotificationModelTypes::REQUEST,
            $request->id,
            NotificationTitle::TITLE['REQUEST_APPROVED'],
            NotificationTitle::BODY['REQUEST_APPROVED'],
            $request->user_id
        );

        return Redirect::back()->with(['flash_success' => "Request has been updated."]);
    }

    public function reject($id)
    {
        $request = ServiceRequest::where('id', $id)->first();

        if ($request == null) return Redirect::back();

        $request->status = RequestTypes::Rejected;
        $request->save();

        //Notification
        addNotification(
            NotificationType::REQUEST_REJECTED,
            NotificationModelTypes::REQUEST,
            $request->id,
            NotificationTitle::TITLE['REQUEST_REJECTED'],
            NotificationTitle::BODY['REQUEST_REJECTED'],
            $request->user_id
        );

        return Redirect::back()->with(['flash_success' => "Request has been updated."]);
    }

    public function complete($id)
    {
        $request = ServiceRequest::where('id', $id)->first();

        if ($request == null) return Redirect::back();

        $request->status = RequestTypes::Completed;
        $request->save();

        //Notification
        addNotification(
            NotificationType::REQUEST_COMPLETED,
            NotificationModelTypes::REQUEST,
            $request->id,
            NotificationTitle::TITLE['REQUEST_COMPLETED'],
            NotificationTitle::BODY['REQUEST_COMPLETED'],
            $request->user_id
        );

        return Redirect::back()->with(['flash_success' => "Request has been updated."]);
    }

    public function getServicesFields(Request $request)
    {
        $service_id = $request->service_id;

        $data = ServiceField::where('service_id', $service_id)
            ->where('status', 1)
            ->orderby('sort')
            ->get(['id', 'field_key', 'name', 'type']);

        return $data;
    }

    public function requestNewDocument(Request $request)
    {
        if ($request->isMethod('post')) {

            $model = ServiceRequest::where('id', $request->request_id)->first();

            if ($model == null) return Redirect::back();

            //Notification
            addNotification(
                NotificationType::REQUEST_DOCUMENTS,
                NotificationModelTypes::REQUEST,
                $model->id,
                NotificationTitle::TITLE['REQUEST_DOCUMENTS'],
                NotificationTitle::BODY['REQUEST_DOCUMENTS'],
                $model->user_id
            );

            return Redirect::back()->with(['flash_success' => "Request has been sent for new documents"]);
        }
    }

    public function uploadNewDocument(Request $request)
    {
        if ($request->isMethod('post')) {
            $model = ServiceRequest::where('id', $request->request_id)->first();

            if ($model == null) return Redirect::back();

            if ($request->hasFile('residence_verification')) {
                $model->addMediaFromRequest('residence_verification')->toMediaCollection('residence_verification');

                //Notification
                addNotification(
                    NotificationType::DOCUMENT_UPLOADED,
                    NotificationModelTypes::REQUEST,
                    $model->id,
                    str_replace(['{{name}}'], [Auth::user()->name], NotificationTitle::TITLE['DOCUMENT_UPLOADED']),
                    str_replace(['{{name}}'], [Auth::user()->name], NotificationTitle::BODY['DOCUMENT_UPLOADED']),
                    0
                );
            }

            return Redirect::back()->with(['flash_success' => "Document uploaded."]);
        }
    }

    public function requestToHelp($id)
    {

        $model = ServiceRequest::where('id', $id)->first();

        if ($model == null) return Redirect::back();

        //User Notification
        addNotification(
            NotificationType::REQUEST_TO_HELP,
            NotificationModelTypes::REQUEST,
            $model->id,
            NotificationTitle::TITLE['REQUEST_TO_HELP'],
            NotificationTitle::BODY['REQUEST_TO_HELP'],
            Auth::user()->id
        );

        //Admin Notification
        addNotification(
            NotificationType::REQUEST_TO_HELP_RECEIVED,
            NotificationModelTypes::REQUEST,
            $model->id,
            str_replace(['{{name}}'], [Auth::user()->name], NotificationTitle::TITLE['REQUEST_TO_HELP_RECEIVED']),
            str_replace(
                ['{{name}}'],
                ["<a href='users/" . Auth::user()->id . "'>" . Auth::user()->name . "</a>"],
                NotificationTitle::BODY['REQUEST_TO_HELP_RECEIVED']
            ),
            0
        );

        return Redirect::back()->with(['flash_success' => "Request to help has been submitted"]);
    }

    public function addNote(Request $request)
    {
        if ($request->isMethod('post')) {

            $model = ServiceRequest::where('id', $request->request_id)->first();

            if ($model == null) return Redirect::back();

            $note = new RequestNote();

            $note->note = $request->note;
            $note->user_id = Auth::user()->id;
            $note->request_id = $request->request_id;
            $note->save();

            return Redirect::back()->with(['flash_success' => "Note added"]);
        }
    }
}
