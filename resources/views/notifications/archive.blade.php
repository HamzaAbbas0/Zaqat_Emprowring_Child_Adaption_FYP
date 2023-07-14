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
                    <h1>Archive</h1>
                </div>
            </div>
            <div class="col-md-4">
                <div class="breadcrumbs">
                    <ul>
                        <li><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li><i class="fas fa-chevron-right"></i></li>
                        <li>Archive</li>
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
                    <div class="card shadow mb-4">
                        <div class="card-body">
                            <div class="mainNotifications">
                                @if(count($notifications) < 1) <h4>No records found</h4>
                                    @endif
                                    <ul class="notificationLists">
                                        @foreach($notifications as $notification)
                                        <li>
                                            <span class="notifyIcon">
                                                <img src="{{ asset('public/images/reviewed.png') }}" alt="{{ $notification->type }}" />
                                            </span>
                                            <span class="notifyMessage">
                                                {!! $notification->body !!}
                                                <br />
                                                <br />
                                                <a onclick="return confirm('are you sure, you want to move this request to archive')" href="{{ route('families.help.unarchive', $notification->id) }}">
                                                    &nbsp; Unarchive  &nbsp;
                                                </a>
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
            </div>
        </div>
    </div>
</div>
@endsection