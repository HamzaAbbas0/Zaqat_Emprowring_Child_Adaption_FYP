@extends('layouts.app')

@section('content')

<div class="bottomBar shadow">
    <div class="container-fluid">
        <div class="row justify-content-between align-items-center customCenter">
            <div class="col-md-4">
                <div class="dashboardTitle">
                    <h1>Users</h1>
                </div>
            </div>
            <div class="col-md-4">
                <div class="breadcrumbs">
                    <ul>
                        <li><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li><i class="fas fa-chevron-right"></i></li>
                        <li>Users</li>
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
                <div class="d-flex flex-row-reverse">
                    <a href="{{ route('users.add') }}">
                        <button class="btn btn-primary">Add User</button>
                    </a>
                </div>
            </div>
            <br />
            <div class="row">
                <div class="col-lg-12 col-md-12">
                    <div class="card shadow mb-4">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered customTableUI" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th style="width: 100px">Date time</th>
                                            <th style="width: 150px">Name</th>
                                            <th>Email</th>
                                            <th style="width: 150px">Account Type</th>
                                            <th style="width: 100px">Status</th>
                                            <th style="width: 100px">...</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($users as $user)
                                            <tr>
                                                <td>{{ $user->created_at }}</td>
                                                <td>{{ $user->name }}</td>
                                                <td>{{ $user->email }}</td>
                                                <td>{{ getUserType($user->role_id) }}</td>
                                                <td>
                                                    @if($user->status == 1)
                                                        <span class="badge badge-success">{{ getUserStatus($user->status) }}</span>
                                                    @else
                                                        <span class="badge badge-secondary">{{ getUserStatus($user->status) }}</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <a href="{{ route('users.view', $user->id) }}">View</a>
                                                    <a style="color: red" onclick="return confirm('are you sure')" href="{{ route('users.delete', $user->id) }}"> &nbsp;Delete</a>
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