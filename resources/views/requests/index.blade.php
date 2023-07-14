<?php
use App\Enums\RequestTypes;
use App\Enums\UserTypes;

?>

@extends('layouts.app')

@section('content')
<div class="bottomBar shadow">
    <div class="container-fluid">
        <div class="row justify-content-between">
            <div class="col-md-4">
                <div class="dashboardTitle">
                    <h1>Requests</h1>
                </div>
            </div>
            <div class="col-md-4">
                <div class="breadcrumbs">
                    <ul>
                        <li><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li><i class="fas fa-chevron-right"></i></li>
                        <li>Requests</li>
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
                            <div class="table-responsive">
                                <table class="table table-bordered customTableUI" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th style="width: 150px">Date time</th>
                                            <th>Name</th>
                                            <th style="width: 180px">Requested Service</th>
                                            @if(UserTypes::Donor != auth()->user()->role_id)
                                            <th style="width: 100px">Status</th>
                                            @endif
                                            <th style="width: 50px">...</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($requests as $request)
                                            <tr>
                                                <td>{{ $request->created_at }}</td>
                                                <td>{{ $request->getFullName() }}</td>
                                                <td>{{ $request->service->name }}</td>
                                                @if(UserTypes::Donor != auth()->user()->role_id)
                                                <td>
                                                    <a href="{{ route('requests.view', $request->id) }}" class="{{ RequestTypes::CSS_CLASSES[$request->status] }}">{{ RequestTypes::LIST[$request->status] }}</a>
                                                </td>
                                                @endif
                                                <td>
                                                    <a href="{{ route('requests.view', $request->id) }}">View</a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                
                @if(in_array(auth()->user()->role_id, [UserTypes::Admin, UserTypes::Moderator]))
                @include('shared.graph-column')
                @endif

            </div>
        </div>
    </div>
</div>
@endsection