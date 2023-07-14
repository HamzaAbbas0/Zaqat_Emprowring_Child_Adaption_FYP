<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notification;
use App\Enums\NotificationStatus;
use App\Enums\UserTypes;
use App\Models\Children;
use App\Models\Family;
use App\Enums\NotificationType;
use Redirect;
use Auth;

class NotificationsController extends Controller
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
        $notifications = Notification::where('status', NotificationStatus::Active);

        // clasifify notifications
        if (in_array(Auth::user()->role_id, [UserTypes::Admin, UserTypes::Moderator])) {
            $notifications = $notifications->where('user_id', 0);
        } else {
            $notifications = $notifications->where('user_id', Auth::user()->id);
        }

        return view('notifications.index', [
            "notifications" => $notifications->orderBy('created_at', 'desc')->get()
        ]);
    }

    public function archive()
    {
        $notifications = Notification::where('status', NotificationStatus::Archived);

        return view('notifications.archive', [
            "notifications" => $notifications->orderBy('created_at', 'desc')->get()
        ]);
    }

    public function view($id)
    {
        $notification = Notification::find($id);

        if (!$notification) return Redirect::back()->with(['flash_error' => 'Notification not found']);

        switch ($notification->model) {

            case 'family':
                $data = Family::find($notification->model_id);

                if (in_array(Auth::user()->role_id, [UserTypes::Admin, UserTypes::Moderator])) {
                    if ($notification->meta) {
                        $data->children = Children::whereIn('id', json_decode($notification->meta))->get();
                    }
                }
                break;
        }

        return view('family.view', [
            'family' => $data
        ]);
    }

    public function downloadGivingTreeSignups()
    {
        $fileName = 'giving-tree-signups.csv';
        $notifications = Notification::where('type', NotificationType::REQUEST_TO_HELP_CHILDRENS)->get();

        $headers = array(
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        );

        $columns = [
            'Requested date time',
            'Requested by', 'Child name',
            'Age', 'Gender', 'Fav Color', 'Shirt', 'Pent',
            'Jacket', 'Underwear', 'Diaper',
            'Pajamas', 'Shoes', 'School',
            'Additional needs',
            'Wants'
        ];

        $callback = function () use ($notifications, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($notifications as $notification) {
                $meta = json_decode($notification->meta);

                if ($meta == null) continue;

                foreach ($meta as $childId) {
                    $child = Children::where('id', $childId)->first();

                    if ($child == null) continue;

                    if ($notification->user == null) continue;

                    $row['Requested date time'] = $notification->getFormattedDate();
                    $row['Requested by'] = $notification->user->name . " (" . $notification->user->email . ")";
                    $row['Child name'] = $child->name;
                    $row['Age'] = $child->age;
                    $row['Gender'] = $child->gender;
                    $row['Fav Color'] = $child->color;
                    $row['Shirt'] = $child->shirt_size;
                    $row['Pent'] = $child->pent_size;
                    $row['Jacket'] = $child->jacket_size;
                    $row['Underwear'] = $child->underwear_size;
                    $row['Diaper'] = $child->diaper_size;
                    $row['Pajamas'] = $child->pajamas_size;
                    $row['Shoes']  = $child->shoes_size;
                    $row['School'] = $child->school_name;
                    $row['Additional needs']  = $child->additional_need;
                    $row['Wants'] = $child->wants;

                    fputcsv($file, array(
                        $row['Requested date time'],
                        $row['Requested by'],
                        $row['Child name'],
                        $row['Age'],
                        $row['Gender'],
                        $row['Fav Color'],
                        $row['Shirt'],
                        $row['Pent'],
                        $row['Jacket'],
                        $row['Underwear'],
                        $row['Diaper'],
                        $row['Pajamas'],
                        $row['Shoes'],
                        $row['School'],
                        $row['Additional needs'],
                        $row['Wants']
                    ));
                }

                fputcsv($file, []);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
