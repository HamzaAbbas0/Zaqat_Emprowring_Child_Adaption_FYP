<?php

use App\Enums\NotificationModelTypes;
use App\Enums\NotificationType;
use App\Enums\UserTypes;

?>
@extends('layouts.app')

@section('content')

<style>
    ul.notificationLists li a {
        display: inline;
    }
</style>

<div class="bottomBar shadow">
    <div class="container-fluid">
        <div class="row justify-content-between">
            <div class="col-md-4">
                <div class="dashboardTitle">
                    <h1>Notifications</h1>
                </div>
            </div>
            <div class="col-md-4">
                <div class="breadcrumbs">
                    <ul>
                        <li><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li><i class="fas fa-chevron-right"></i></li>
                        <li>Notifications</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="contentPageWhiteBG mb-5">
    <div class="row justify-content-center mx-3">
        <div class="col-lg-12 col-md-12">
            <div class="row">
                <div class="col-lg-8 col-md-12">

                    @if(session()->has('flash_error'))
                    <div class="alert alert-danger">{{ session()->get('flash_error') }}</div>
                    @endif

                    @if(session()->has('flash_success'))
                    <div class="alert alert-success">{{ session()->get('flash_success') }}</div>
                    @endif

                    <div class="card shadow mb-4">
                        <div class="card-body">
                            <div class="mainNotifications">
                                @if(count($notifications) < 1) <h4>No records found</h4>
                                    @endif
                                    <ul class="notificationLists">
                                        @foreach($notifications as $notification)
                                        <li>
                                            <span class="notifyIcon">
                                                @if(in_array($notification->type, [
                                                NotificationType::REQUEST_DOCUMENTS,
                                                NotificationType::NEW_REQUEST,
                                                NotificationType::DOCUMENT_UPLOADED,
                                                NotificationType::REQUEST_TO_HELP,
                                                NotificationType::REQUEST_TO_HELP_RECEIVED,
                                                NotificationType::REQUEST_TO_HELP_FAMILY,
                                                NotificationType::REQUEST_TO_HELP_FAMILY_RECEIVED,
                                                NotificationType::REQUEST_TO_HELP_CHILDRENS,
                                                NotificationType::REQUEST_TO_HELP_CHILDRENS_RECEIVED,
                                                NotificationType::NEW_FAMILY_ADDED
                                                ]))
                                                <img src="{{ asset('public/images/reviewed.png') }}" alt="{{ $notification->type }}" />
                                                @endif

                                                @if(in_array($notification->type, [NotificationType::REQUEST_COMPLETED]))
                                                <img src="{{ asset('public/images/completed.png') }}" alt="{{ $notification->type }}" />
                                                @endif

                                                @if(in_array($notification->type, [NotificationType::REQUEST_APPROVED]))
                                                <img src="{{ asset('public/images/approved.png') }}" alt="{{ $notification->type }}" />
                                                @endif

                                                @if(in_array($notification->type, [NotificationType::REQUEST_REJECTED]))
                                                <img src="{{ asset('public/images/redejected.png') }}" alt="{{ $notification->type }}" />
                                                @endif
                                            </span>
                                            <span class="notifyMessage">
                                                {!! $notification->body !!}
                                                @if($notification->model == NotificationModelTypes::REQUEST)
                                                <br />
                                                <a href="{{ route('requests.view', $notification->model_id) }}">View application</a>
                                                @endif

                                                @if($notification->model == NotificationModelTypes::FAMILY)
                                                <br />

                                                @if(in_array(Auth::user()->role_id, [UserTypes::Admin, UserTypes::Moderator]))
                                                <a href="{{ route('notifications.view', $notification->id) }}">View family</a>
                                                <a onclick="return confirm('are you sure, you want to remove this family, Childrens along will be removed too?')" style="color: red; margin-left: 6px" href="{{ route('families.delete', $notification->id) }}">
                                                    Delete
                                                </a>
                                                @else
                                                <a href="{{ route('families.view', $notification->model_id) }}">View family</a>
                                                @endif
                                                @endif

                                                @if(in_array($notification->type, [NotificationType::REQUEST_TO_HELP_CHILDRENS_RECEIVED, NotificationType::REQUEST_TO_HELP_CHILDRENS]))
                                                    <br />
                                                    <br />
                                                    <a href="{{ route('families.help.view', $notification->id) }}">View</a>
                                                    @if(in_array(Auth::user()->role_id, [UserTypes::Admin, UserTypes::Moderator]))
                                                        <a onclick="return confirm('are you sure, you want to remove this request')" style="color: red" href="{{ route('families.help.delete', $notification->id) }}">
                                                            &nbsp; Delete
                                                        </a>
                                                        <a onclick="return confirm('are you sure, you want to move this request to archive')" href="{{ route('families.help.archive', $notification->id) }}">
                                                            &nbsp; Archive  &nbsp;
                                                        </a>
                                                    @endif
                                                @endif
                                            </span>
                                            <span class="notifyDateTime">
                                                <small>{{ $notification->getWeekDay() }}</small>
                                                <span>{{ $notification->getFormattedDate() }}</span>
                                                <small>{{ $notification->getFormattedTime() }}</small>
                                            </span>
                                        </li>
                                        @endforeach
                                    </ul>
                            </div>
                        </div>
                    </div>
                </div>


                @if(in_array(Auth::user()->role_id, [UserTypes::Admin, UserTypes::Moderator]))
                <div class="col-lg-4 col-md-12">
                    <div class="contentWhiteBGLeft shadow mb-2">
                        <div class="card card-raised customChart h-100">
                            <div class="card-header customChartHeader text-white px-4">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="me-4">
                                        <h2 class="card-title text-white mb-0">Download current giving tree signups</h2>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div>
                                    <a href="{{ route('notifications.download.giving.tree.signups') }}" class="btn btn-primary">Download</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="contentWhiteBGLeft shadow mb-2">
                        <div class="card card-raised customChart h-100">
                            <div class="card-header customChartHeader text-white px-4">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="me-4">
                                        <h2 class="card-title text-white mb-0">Archive requests</h2>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div>
                                    <a href="{{ route('notifications.archive') }}" class="btn btn-primary">View archive requests</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endif

            </div>
        </div>
    </div>
</div>
@endsection