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
                    <h1>Requested to help</h1>
                </div>
            </div>
            <div class="col-md-4">
                <div class="breadcrumbs">
                    <ul>
                        <li><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li><i class="fas fa-chevron-right"></i></li>
                        <li>Requested to help</li>
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
                <div class="col-lg-12 col-md-12">
                    <div class="card shadow mb-4">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered customTableUI" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th style="width: 150px">Date time</th>
                                            <th style="width: 150px">Family Number</th>
                                            <th>People in Household</th>
                                            <th style="width: 50px">...</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($families as $family)
                                        <tr>
                                            <td>{{ $family->created_at }}</td>
                                            <td>{{ $family->id }}</td>
                                            <td>{{ $family->people_in_household }}</td>
                                            <td>
                                                <a href="requested-to-help/view/{{$family->id}}/{{$family->notification_id}}">View</a>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection