<?php
use App\Enums\UserTypes;
?>

@extends('layouts.app')

@section('content')

<style>
    .formLabel {
        text-transform: capitalize;
    }
</style>

<div class="bottomBar shadow">
    <div class="container-fluid">
        <div class="row justify-content-between">
            <div class="col-md-4">
                <div class="dashboardTitle">
                    <h1>Add New Request</h1>
                </div>
            </div>
            <div class="col-md-4">
                <div class="breadcrumbs">
                    <ul>
                        <li><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li><i class="fas fa-chevron-right"></i></li>
                        <li><a href="{{ route('requests.index') }}">Requests</a></li>
                        <li><i class="fas fa-chevron-right"></i></li>
                        <li>Add New Request</li>
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
                                <form name="requestForm" method="POST" action="" enctype="multipart/form-data">
                                    @csrf

                                    @if(session()->has('flash_error'))
                                    <div class="alert alert-danger">{{ session()->get('flash_error') }}</div>
                                    @endif

                                    @if(session()->has('flash_success'))
                                    <div class="alert alert-success">{{ session()->get('flash_success') }}</div>
                                    @endif

                                    <div class="row">
                                        @if(in_array(auth()->user()->role_id, [UserTypes::Admin, UserTypes::Moderator]))
                                        <div class="col-md-12">
                                            <div class="formLabel" for="user">User</div>
                                            <div class="formField">
                                                <select name="user" id="user" class="w-100 @error('user') is-invalid @enderror">
                                                    <option value="">Select User</option>
                                                    @foreach($applicants as $applicant)
                                                        <option value="{{ $applicant->id }}" {{ old('user') == $applicant->id ? 'selected' : '' }} >{{ ucfirst($applicant->name) }}</option>
                                                    @endforeach
                                                </select>
                                                @error('user')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>
                                        @endif

                                        <div class="col-md-6">
                                            <div class="formLabel" for="first_name">First Name</div>
                                            <div class="formField">
                                                <input type="text" value="{{ old('first_name') ?? auth()->user()->name }}" id="first_name" name="first_name" class="form-control @error('first_name') is-invalid @enderror" />
                                                @error('first_name')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="formLabel">Last Name</div>
                                            <div class="formField">
                                                <input type="text" value="{{ old('last_name') }}" id="last_name" name="last_name" class="form-control @error('last_name') is-invalid @enderror" />
                                                @error('last_name')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="formLabel">Address</div>
                                            <div class="formField">
                                                <input type="text" value="{{ old('address') ?? auth()->user()->address }}" id="address" name="address" class="form-control @error('address') is-invalid @enderror" />
                                                @error('address')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <label class="form-label" for="residence_verification" style="margin-left: 0px;">Verification of Residence</label>
                                            <div class="formField">
                                                <input type="file" name="residence_verification" id="residence_verification" class="form-control @error('residence_verification') is-invalid @enderror" />
                                                @error('residence_verification')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="formLabel">Contact No</div>
                                            <div class="formField">
                                                <input type="text" value="{{ old('contact_no') ?? auth()->user()->contact_no }}" id="contact_no" name="contact_no" class="form-control @error('contact_no') is-invalid @enderror" />
                                                @error('contact_no')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="formLabel">Alternate Contact No</div>
                                            <div class="formField">
                                                <input type="text" value="{{ old('alternate_no') }}" id="alternate_no" name="alternate_no" class="form-control @error('alternate_no') is-invalid @enderror" />
                                                @error('alternate_no')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="formLabel">Email</div>
                                            <div class="formField">
                                                <input type="text" value="{{ old('email') ?? auth()->user()->email }}" id="email" name="email" class="form-control @error('email') is-invalid @enderror" />
                                                @error('email')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="formLabel">Select Service</div>
                                            <div class="formField customSelectBox select-service">
                                                <select class="form-select @error('service_id') is-invalid @enderror" name="service_id">
                                                    <option value="">Select Service</option>
                                                    @foreach($services as $service)
                                                    <option value="{{ $service->id }}" {{ old('service_id') == $service->id ? "selected" : "" }}>{{ $service->name }}</option>
                                                    @endforeach
                                                </select>
                                                @error('service_id')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row" id="custom-fields-container"></div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="formLabel">Wants</div>
                                            <div class="formField">
                                                <textarea type="text" value="{{ old('wants') }}" name="wants" class="form-control @error('wants') is-invalid @enderror">{{ old('wants') }}</textarea>
                                                @error('wants')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="formLabel">Reason For Request</div>
                                            <div class="formField">
                                                <textarea type="text" value="{{ old('reason') }}" name="reason" class="form-control @error('reason') is-invalid @enderror">{{ old('reason') }}</textarea>
                                                @error('reason')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="formFieldBTN"><a href="javascript:document.requestForm.submit()">Submit Request</a></div>
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

@section('footer-scripts')
<script>
    const old_service_id = "{{ old('service_id') ?? '' }}";

    function getServicesQuestions(service_id) {
        const url = "{{ route('requests.get.services.fields') }}"
        var html = "";

        $.ajax({
            url,
            type: 'GET',
            data: {
                service_id: service_id
            },
            success: function(response) {
                response.map(row => {
                    const key = row.field_key + '_' + row.id + '@key';
                    const key_name = key + '@name';
                    const key_type = key + '@type';

                    html += `
                        <div class="col-md-6">
                            <div class="formLabel">${row.name}</div>
                            <div class="formField">
                                <input type="${row.type}" id="${key}" name="${key}" class="form-control" />
                                <input type="hidden" id="${key_name}" name="${key_name}" value="${row.name}" />
                                <input type="hidden" id="${key_type}" name="${key_type}" value="${row.type}" />
                            </div>
                        </div>
                    `
                })
                $('#custom-fields-container').html(html)
            }
        });
    }

    $(document).on("change", ".select-service", function(e) {
        const selectedService = e.target.value

        getServicesQuestions(selectedService);
    });

    //if service is selected 
    if (old_service_id) {
        getServicesQuestions(old_service_id);
    }
</script>
@endsection