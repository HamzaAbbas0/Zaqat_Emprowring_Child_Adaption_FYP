<?php

use App\Enums\RequestTypes;
use App\Enums\UserTypes;

?>

@extends('layouts.app')

@section('content')

<style>
    .formFieldBTN {
        text-align: left;
    }

    .formFieldBTN a {
        padding: 5px 30px;
    }

    .formField {
        margin-bottom: 18px;
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
            <div class="modal-body">Press "Send Request" to request more documents from user about this application.</div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                <form action="{{ route('requests.request.new.document') }}" method="POST">
                    @csrf
                    <input type="hidden" name="request_id" value="{{ $request->id }}" />

                    <button class="btn btn-primary" href="#" type="submit">Send Request</button>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="uploadMoreDocument" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form action="{{ route('requests.upload.new.document') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Upload More Documents</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="form-label" for="residence_verification">Documents</label>
                            <input type="file" name="residence_verification" id="residence_verification" class="form-control" required/>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                        <input type="hidden" name="request_id" value="{{ $request->id }}" />
                        <button class="btn btn-primary" href="#" type="submit">Upload</button>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="bottomBar shadow">
    <div class="container-fluid">
        <div class="row justify-content-between">
            <div class="col-md-4">
                <div class="dashboardTitle">
                    <h1>Status: <span class="{{ RequestTypes::CSS_BREADCRUMB_CLASSES[$request->status] }}">{{ RequestTypes::LIST[$request->status] }} Request</span></h1>
                </div>
            </div>
            <div class="col-md-4">
                <div class="breadcrumbs">
                    <ul>
                        <li><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li><i class="fas fa-chevron-right"></i></li>
                        <li><a>Requests</a></li>
                        <li><i class="fas fa-chevron-right"></i></li>
                        <li>{{ RequestTypes::LIST[$request->status] }} Request</li>
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
                            <div class="donationRequestForm {{ RequestTypes::CSS_FORM_CLASSES[$request->status] }}">
                                <div class="row">
                                    @if(in_array(auth()->user()->role_id, [UserTypes::Admin, UserTypes::Moderator]))
                                    <div class="col-md-12">
                                        <div class="formLabel">Applicant</div>
                                        <div class="formField">
                                            <input type="text" value="{{ $request->user->name }}" disabled />
                                        </div>
                                    </div>
                                    @endif
                                    <div class="col-md-4">
                                        <div class="formLabel">Name</div>
                                        <div class="formField">
                                            <input type="text" value="{{ $request->getFullName() }}" disabled />
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="formLabel">Email Address</div>
                                        <div class="formField">
                                            <input type="text" value="{{ $request->email }}" disabled />
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="formLabel">Contact No</div>
                                        <div class="formField">
                                            <input type="text" value="{{ $request->contact_no }}" disabled />
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="formLabel">Requested Service</div>
                                        <div class="formField">
                                            <input type="text" value="{{ $request->service->name }}" disabled />
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="formLabel">Requested Date</div>
                                        <div class="formField">
                                            <input type="text" value="{{ $request->created_at }}" disabled />
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="formLabel">Alternate No</div>
                                        <div class="formField">
                                            <input type="text" value="{{ $request->alternate_no }}" disabled />
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="formLabel">Address</div>
                                        <div class="formField">
                                            <input type="text" value="{{ $request->address }}" disabled />
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="formLabel">Reason</div>
                                        <div class="formField">
                                            <textarea type="text" disabled>{{ $request->reason }}</textarea>
                                        </div>
                                    </div>
                                    <div class="formFieldBTN">
                                        @if(in_array(auth()->user()->role_id, [UserTypes::Donor]))
                                            <a href="{{ route('requests.want.to.help', $request->id) }}" style="margin-right: 20px">Want to help?</a>
                                        @else
                                            <a href="{{ url()->previous() }}" style="margin-right: 20px">Back</a>
                                        @endif
                                        
                                        @if(RequestTypes::In_Review == $request->status)
                                            @if(in_array(auth()->user()->role_id, [UserTypes::Admin, UserTypes::Moderator]))
                                                <a href="{{ route('requests.approve', $request->id) }}" class="bg-success">Approve</a>
                                                <a href="{{ route('requests.reject', $request->id) }}" class="bg-danger">Reject</a>
                                            @endif
                                        @endif

                                        @if(RequestTypes::Approved == $request->status)
                                            @if(in_array(auth()->user()->role_id, [UserTypes::Admin, UserTypes::Moderator]))
                                                <a href="{{ route('requests.complete', $request->id) }}" class="bg-success">Mark Completed</a>
                                            @endif
                                        @endif
                                    </div>
                                </div>
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
                                        <h2 class="card-title text-white mb-0">Verification of Residence</h2>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body customChartBody p-4">
                                @if(in_array(auth()->user()->role_id, [UserTypes::Admin, UserTypes::Moderator]))
                                <ul>
                                    <li>
                                        <a href="#" data-toggle="modal" data-target="#requestDocument">Request new documents</a>
                                    </li>
                                </ul>
                                <br />
                                @endif

                                @if(in_array(auth()->user()->role_id, [UserTypes::Applicant]))
                                <ul>
                                    <li>
                                        <a href="#" data-toggle="modal" data-target="#uploadMoreDocument">Upload more documents</a>
                                    </li>
                                </ul>
                                <br />
                                @endif
                                
                                <ul>
                                    <b>Documents history</b>
                                    @foreach($request->getMedia('residence_verification')->all() as $media)
                                    <li>
                                        {{ datetimetoDisplayFormat($media->created_at) }}:
                                        <a target="_blank" href="{{ $media->getUrl() }}">{{ $media->name }}</a>
                                    </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>

                    @if($request->metas->count() > 0)
                    <div class="contentWhiteBGLeft shadow mb-2">
                        <div class="card card-raised customChart h-100">
                            <div class="card-header customChartHeader text-white px-4">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="me-4">
                                        <h2 class="card-title text-white mb-0">Additional Questions</h2>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body customChartBody p-4">
                                <dl>
                                    @foreach($request->metas->all() as $meta)
                                    <dt>{{ $meta->name }}</dt>
                                    <dd>{{ $meta->value }}</dd>
                                    @endforeach
                                </dl>
                            </div>
                        </div>
                    </div>
                    @endif

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
                                    @foreach($request->notes->all() as $note)
                                    <dt>
                                        {{ $note->user->name }}
                                        <small>{{ $note->created_at }}</small>
                                    </dt>
                                    <dd>{{ $note->note }}</dd>
                                    @endforeach
                                </dl>

                                <div>
                                    <form method="POST" action="{{ route('requests.notes.add.note') }}">
                                        @csrf
                                        <input type="hidden" name="request_id" value="{{ $request->id }}" />
                                        <div class="form-group">
                                            <label for="note" class="form-label">Write a note</label>
                                            <textarea type="text" id="note" name="note" class="form-control" required></textarea>
                                        </div>
                                        <div class="form-group">
                                            <button class="btn btn-primary">Save</button>
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