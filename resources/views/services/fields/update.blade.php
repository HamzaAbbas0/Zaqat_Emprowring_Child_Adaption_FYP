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
                    <h1>Update</h1>
                </div>
            </div>
            <div class="col-md-4">
                <div class="breadcrumbs">
                    <ul>
                        <li><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li><i class="fas fa-chevron-right"></i></li>
                        <li><a href="{{ $service_url }}">{{ $service_name }}</a></li>
                        <li><i class="fas fa-chevron-right"></i></li>
                        <li>Update</li>
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
                            <h4>Create New Field</h4>
                            <div class="donationRequestForm newRequestForm">
                                <form name="fieldsForm" action="" method="POST">
                                    @csrf

                                    @if(session()->has('flash_error'))
                                        <div class="alert alert-danger">{{ session()->get('flash_error') }}</div>
                                    @endif

                                    @if(session()->has('flash_success'))
                                        <div class="alert alert-success">{{ session()->get('flash_success') }}</div>
                                    @endif
                                    
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="formLabel">Field Name</div>
                                            <div class="formField">
                                                <input type="text" name="field_name" value="{{ $field->name }}" class="form-control @error('field_name') is-invalid @enderror" />
                                                @error('field_name')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="formLabel">Field Type</div>
                                            <div class="formField customSelectBox">
                                                <select class="form-select" name="field_type">
                                                    <option value="text" {{ $field->type == "text"  ? 'selected' : ''}}>Text</option>
                                                    <option value="number" {{ $field->type == "number"  ? 'selected' : ''}}>Number</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="formLabel">Sort</div>
                                            <div class="formField">
                                                <input type="number" name="sort" value="{{ $field->sort }}" class="form-control @error('sort') is-invalid @enderror" />
                                                @error('sort')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="formLabel">Status</div>
                                            <div class="formField customSelectBox">
                                                <select class="form-select" name="status">
                                                    <option value="1" {{ $field->status == "1"  ? 'selected' : ''}}>Active</option>
                                                    <option value="0" {{ $field->status == "0"  ? 'selected' : ''}}>Inactive</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="formFieldBTN d-flex flex-row mb-3">
                                            <a href="javascript:document.fieldsForm.submit()" style="padding: 8px 15px;">Save</a>
                                        </div>
                                    </div>
                                </form>
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