<?php

use App\Enums\UserTypes;
use App\Enums\UserStatus;

?>

@extends('layouts.app')

@section('content')

<style>
    .user-documents {
        height: 75px;
        width: 75px;
        cursor: pointer;
    }
</style>


<div class="modal fade" id="requestDocument" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Request New Document</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">Press "Send Request" to request more documents from user about his membership.</div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                <form action="{{ route('users.request.new.document') }}" method="POST">
                    @csrf
                    <input type="hidden" name="user_id" value="{{ $user->id }}" />

                    <button class="btn btn-primary" href="#" type="submit">Send Request</button>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="bottomBar shadow">
    <div class="container-fluid">
        <div class="row justify-content-between align-items-center customCenter">
            <div class="col-md-4">
                <div class="dashboardTitle">
                    <h1>{{ $user->name }}</h1>
                </div>
            </div>
            <div class="col-md-4">
                <div class="breadcrumbs">
                    <ul>
                        <li><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li><i class="fas fa-chevron-right"></i></li>
                        <li><a href="{{ route('users.index') }}">Users</a></li>
                        <li><i class="fas fa-chevron-right"></i></li>
                        <li>{{ $user->name }}</li>
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
                            <div class="donationRequestForm newRequestForm">

                                @if(session()->has('flash_error'))
                                <div class="alert alert-danger">{{ session()->get('flash_error') }}</div>
                                @endif

                                @if(session()->has('flash_success'))
                                <div class="alert alert-success">{{ session()->get('flash_success') }}</div>
                                @endif

                                <form name="userForm" action="{{ route('users.update', $user->id) }}" method="POST">
                                    @csrf
                                    <input type="hidden" value="{{ $user->id }}" name="user_id" />

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="formLabel">Name</div>
                                            <div class="formField">
                                                <input type="text" value="{{ $user->name }}" disabled readonly />
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="formLabel">Email Address</div>
                                            <div class="formField">
                                                <input type="text" value="{{ $user->email }}" disabled readonly />
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="formLabel">Date Time</div>
                                            <div class="formField">
                                                <input type="text" value="{{ $user->created_at }}" disabled readonly />
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="formLabel">Contact No</div>
                                            <div class="formField">
                                                <input type="text" value="{{ $user->contact_no }}" disabled readonly />
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="formLabel">Account Type</div>
                                            <div class="formField customSelectBox">
                                                <select class="form-select" name="account_type">
                                                    @foreach(UserTypes::LIST as $key => $value)
                                                    @if($key != 0)
                                                    <option value="{{ $key }}" @if ($key==$user->role_id)
                                                        selected="selected"
                                                        @endif
                                                        >{{ $value }}</option>
                                                    @endif
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="formLabel">Status</div>
                                            <div class="formField customSelectBox">
                                                <select class="form-select" name="status">
                                                    @foreach(UserStatus::LIST as $key => $value)
                                                    <option value="{{ $key }}" @if ($key==$user->status)
                                                        selected="selected"
                                                        @endif
                                                        >{{ $value }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="formLabel">Address</div>
                                            <div class="formField">
                                                <input type="text" value="{{ $user->address }}" disabled readonly />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row justify-content-start">
                                        <div class="col-lg-9">
                                            <div class="childBTN">
                                                <a href="javascript:document.userForm.submit()" id="addChildBTN">Save</a>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-12">
                    <div class="contentWhiteBGLeft shadow mb-2">
                        <div class="card card-raised customChart h-100">
                            <div class="card-header customChartHeader text-white px-4">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="me-4">
                                        <h2 class="card-title text-white mb-0">Request New documents</h2>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body customChartBody p-4">
                                @if(in_array(auth()->user()->role_id, [UserTypes::Admin, UserTypes::Moderator]))
                                <ul>
                                    <li>
                                        <a href="#" data-toggle="modal" data-target="#requestDocument">Request new document from user</a>
                                    </li>
                                </ul>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="contentWhiteBGLeft shadow mb-2">
                        <div class="card card-raised customChart h-100">
                            <div class="card-header customChartHeader text-white px-4">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="me-4">
                                        <h2 class="card-title text-white mb-0">Documents</h2>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body customChartBody p-4">
                                <ul>
                                    Residence Verifications
                                    @foreach($user->getMedia('residence_verification')->all() as $media)
                                    <li>
                                        {{ datetimetoDisplayFormat($media->created_at) }}:
                                        <a target="_blank" href="{{ $media->getUrl() }}">{{ $media->name }}</a>
                                    </li>
                                    @endforeach
                                </ul>
                                <br />
                                <ul>
                                    Profile Pictures
                                    @foreach($user->getMedia('upload_picture')->all() as $media)
                                    <li>
                                        {{ datetimetoDisplayFormat($media->created_at) }}:
                                        <a target="_blank" href="{{ $media->getUrl() }}">{{ $media->name }}</a>
                                    </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>


                    @if(in_array(auth()->user()->role_id, [UserTypes::Admin, UserTypes::Moderator]))
                    <div class="contentWhiteBGLeft shadow">
                        <div class="card card-raised customChart h-100">
                            <div class="card-header customChartHeader text-white px-4">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="me-4">
                                        <h2 class="card-title text-white mb-0">Notes</h2>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body customChartBody p-4">
                                <dl>
                                    @foreach($user->notes->all() as $note)
                                    <dt>
                                        {{ $note->user->name }}
                                        <small>{{ $note->created_at }}</small>
                                    </dt>
                                    <dd>{{ $note->note }}</dd>
                                    @endforeach
                                </dl>

                                <div>
                                    <form method="POST" action="{{ route('users.notes.add.note') }}">
                                        @csrf
                                        <input type="hidden" name="user_id" value="{{ $user->id }}" />
                                        <div class="form-group">
                                            <label for="note" class="form-label">Write a note</label>
                                            <textarea type="text" id="note" name="note" class="form-control" required></textarea>
                                        </div>
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-primary">Save</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>

            </div>
        </div>
    </div>
</div>

@endsection