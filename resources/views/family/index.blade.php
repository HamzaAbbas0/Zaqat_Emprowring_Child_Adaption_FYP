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
                    <h1>Families</h1>
                </div>
            </div>
            <div class="col-md-4">
                <div class="breadcrumbs">
                    <ul>
                        <li><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li><i class="fas fa-chevron-right"></i></li>
                        <li>Families</li>
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
                                            @if(in_array(auth()->user()->role_id, [UserTypes::Donor]))
                                            <th style="width: 150px">Family Number</th>
                                            @else
                                            <th style="width: 150px">Name</th>
                                            @endif
                                            <th>People in Household</th>

                                            @if(in_array(auth()->user()->role_id, [UserTypes::Admin, UserTypes::Moderator]))
                                            <th>Address</th>
                                            <th style="width: 100px">City</th>
                                            <th style="width: 100px">State</th>
                                            <th style="width: 100px">ZIP</th>
                                            <th style="width: 100px">Contact No</th>
                                            @endif

                                            <th style="width: 50px">...</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($families as $family)
                                        <tr>
                                            <td>{{ $family->created_at }}</td>
                                            
                                            @if(in_array(auth()->user()->role_id, [UserTypes::Donor]))
                                            <td>{{ $family->id }}</td>
                                            @else
                                            <td>{{ $family->name }}</td>
                                            @endif

                                            <td>{{ $family->people_in_household }}</td>

                                            @if(in_array(auth()->user()->role_id, [UserTypes::Admin, UserTypes::Moderator]))
                                            <td>{{ $family->address }}</td>
                                            <td>{{ $family->getCityName() }}</td>
                                            <td>{{ $family->getStateName() }}</td>
                                            <td>{{ $family->zip }}</td>
                                            <td>{{ $family->contact_no }}</td>  
                                            @endif

                                            <td>
                                                <a href="{{ route('families.view', $family->id) }}">View</a>
                                                @if(in_array(auth()->user()->role_id, [UserTypes::Admin, UserTypes::Moderator]))
                                                    <a href="{{ route('giving-tree.edit', $family->id) }}">Edit</a>
                                                @endif
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