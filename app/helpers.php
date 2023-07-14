<?php

use App\Enums\UserTypes;
use App\Enums\UserStatus;
use App\Enums\NotificationStatus;
use Carbon\Carbon;
use App\Models\Request as ServiceRequest;
use App\Models\Service;
use App\Models\ServiceField;
use Khsing\World\Models\Country;
use Khsing\World\Models\Division;
use App\Models\Notification;
use App\Models\ChMessage;
use App\Enums\ServiceTypes;

function getUserType($role_id){
    return UserTypes::LIST[$role_id];
}

function getUserStatus($status){
    return UserStatus::LIST[$status];
}

function getProfileImage($user) {
    if($user->getMedia('upload_picture')->first()) {
        return $user->getMedia('upload_picture')->last()->getUrl();
    }

    return asset('public/images/no-profile.jpeg');
}

function datetimetoDisplayFormat($value){
    return Carbon::parse($value)->diffForHumans();
}

function getChartData() {

    $query = Service::leftJoin(ServiceRequest::getTableName(), ServiceRequest::getTableName().'.service_id', Service::getTableName().'.id')
        ->selectRaw('services.name as name, count(requests.id) as service_count')
        ->groupBy([ServiceRequest::getTableName().'.service_id', Service::getTableName().'.name']);

    if (Auth::user() && in_array(Auth::user()->role_id, [UserTypes::Applicant])){
        $query = $query->where(ServiceRequest::getTableName().'.user_id', Auth::user()->id);
    }

    return $query->get()->toArray();
}

function generateFieldKey($e, $service_id) {
    $key = str_replace(" ","_", strtolower($e));

    $model = ServiceField::where('field_key', $key)->where('service_id', $service_id)->first();

    if($model) {
        $key = $key."_";
    }

    return $key;
}

function getProvinces($country = 'us') {
    $model = Country::getByCode($country);

    return $model->divisions()->get()->toArray();
}

function getProvinceCities($province) {
    $model = Division::getByCode($province);

    return $model->children();
}

function getCityById($state, $city) {
    $cities = getProvinceCities($state);
    return $cities->where('id', $city)->first();
}

function getStateByName($state) {
    return Division::getByCode($state);
}

function addNotification($model_type, $model, $model_id, $title, $body, $user_id = 0, $meta = ''){
    $notification = new Notification();

    $notification->user_id = $user_id;
    $notification->type = $model_type;
    $notification->model = $model;
    $notification->model_id = $model_id;
    $notification->title = $title;
    $notification->body = $body;
    $notification->meta = $meta;
    $notification->status = NotificationStatus::Active;

    $notification->save();

    return $notification;
}

function getNavbarNotifications() {
    $user_id = 0;

    if(in_array(Auth::user()->role_id, [UserTypes::Applicant, UserTypes::Donor])) {
        $user_id = Auth::user()->id;
    }

    $notifications = Notification::where('status', NotificationStatus::Active)
        ->where('user_id', $user_id);

    $data = [
        "count" => $notifications->count(),
        "notifications" => [],
    ];

    $lastNoti = $notifications->orderby('created_at', 'DESC')->first();

    if ($lastNoti) {
        $data['notifications'] = [$lastNoti];
    }

    return $data;
}

function getNavbarMessages() {
    
    $messages = ChMessage::where('to_id', Auth::user()->id)
        ->where('seen', 0);

    $data = [
        "count" => $messages->count(),
        "messages" => [],
    ];

    $lastMsg = $messages->orderby('created_at', 'DESC')->first();

    if ($lastMsg) {
        $data['messages'] = [$lastMsg];
    }

    return $data;
}

function getIfAdoptionIsActive(){
    $model = Service::where('id', ServiceTypes::Adoption)->first();

    if ($model == null) return false;

    return $model->status;
}