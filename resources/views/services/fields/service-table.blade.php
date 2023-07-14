@extends('layouts.app')

@section('content')
<div class="bottomBar shadow">
    <div class="container-fluid">
        <div class="row justify-content-between">
            <div class="col-md-4">
                <div class="dashboardTitle">
                    <h1>{{ $service->name }}</h1>
                </div>
            </div>
            <div class="col-md-4">
                <div class="breadcrumbs">
                    <ul>
                        <li><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li><i class="fas fa-chevron-right"></i></li>
                        <li>{{ $service->name }}</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="contentPageWhiteBG mb-5">
    <div class="row justify-content-center mx-3">
        <div class="col-lg-12 col-md-12">

            <div class="formFieldBTN d-flex flex-row-reverse mb-3">
                <a href="{{ route('services.fields.create', $service->id) }}" style="padding: 8px 15px;">Add Question</a>
                <div class="custom-control custom-switch pr-10" style="padding-right: 40px; padding-top: 10px;">
                    <input type="checkbox" class="custom-control-input service-active-toggle" id="service_status" {{ $service->status == 1 ? "checked" : '' }} />
                    <label class="custom-control-label" for="service_status">{{ $service->status == 1 ? 'Activated' : 'Disabled' }}</label>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12 col-md-12">
                    
                    @if(session()->has('flash_error'))
                        <div class="alert alert-danger">{{ session()->get('flash_error') }}</div>
                    @endif

                    @if(session()->has('flash_success'))
                        <div class="alert alert-success">{{ session()->get('flash_success') }}</div>
                    @endif

                    <div class="card shadow mb-4">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered customTableUI" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th style="width: 60px">S.No</th>
                                            <th style="width: 60px">Sort</th>
                                            <th>Question</th>
                                            <th style="width: 150px">Answer Type</th>
                                            <th style="width: 100px">Status</th>
                                            <th style="width: 80px">...</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($fields as $key => $field)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $field->sort }}</td>
                                            <td>{{ $field->name }}</td>
                                            <td style="text-transform: capitalize;">{{ $field->type }}</td>
                                            <td>
                                                @if($field->status == 1)
                                                    <span class="badge badge-success">Active</span>
                                                @else
                                                    <span class="badge badge-secondary">Inactive</span>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ route('services.fields.view', $field->id) }}">Edit</a>
                                                <a class="text-danger" style="padding-left: 7px" href="{{ route('services.fields.delete', $field->id) }}">Delete</a>
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


@section('footer-scripts')
<script>
    const statusUpdateURL = "{{ route('services.status.toggle', $service->id) }}";
    $(document).on("change", ".service-active-toggle", function() {
        window.location = statusUpdateURL
    });
</script>
@endsection