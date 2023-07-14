<?php
use App\Enums\UserTypes;

?>

@extends('layouts.app')

@section('content')
<div class="bottomBar shadow">
    <div class="container-fluid">
        <div class="row justify-content-between">
            <div class="col-md-4">
                <div class="dashboardTitle">
                    <h1>Adoption History</h1>
                </div>
            </div>
            <div class="col-md-4">
                <div class="breadcrumbs">
                    <ul>
                        <li><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li><i class="fas fa-chevron-right"></i></li>
                        <li>Adoption History</li>
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
                                            <th>Type</th>
                                            <th style="width: 180px">Child Count</th>
                                            <th style="width: 100px">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($notifications as $notification)
                                        <tr>
                                            <td>{{ $notification->created_at }}</td>
                                            <td>Request to adopt child(s)</td>
                                            <td>
                                                <?php
                                                    $meta = json_decode($notification->meta);
                                                ?>
                                                {{ count($meta) }}
                                            </td>
                                            <td>
                                                <a href="{{ route('families.help.view', $notification->id) }}">View</a>
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