@extends('layouts.app')

@section('content')
<style>
    .formField {
        margin-bottom: 18px;
    }

    input[type=checkbox] {
        transform: scale(1.5);
    }
</style>

<div class="bottomBar shadow">
    <div class="container-fluid">
        <div class="row justify-content-between">
            <div class="col-md-4">
                <div class="dashboardTitle">
                    <h1>View</h1>
                </div>
            </div>
            <div class="col-md-4">
                <div class="breadcrumbs">
                    <ul>
                        <li><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li><i class="fas fa-chevron-right"></i></li>
                        <li><a href="{{ route('families.requested.to.help') }}">Requested to help</a></li>
                        <li><i class="fas fa-chevron-right"></i></li>
                        <li>View</li>
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
                            <div class="donationRequestForm">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="formLabel">People in Household</div>
                                        <div class="formField">
                                            <input type="text" value="{{ $family->people_in_household }}" disabled />
                                        </div>
                                    </div>
                                </div>
                                <br />
                                <br />
                                <div class="row">
                                    <h5>Children Details: </h5>
                                    <p>Please select childrens you wish to help</p>
                                </div>
                                <div class="row">
                                    <table class="table table-bordered customTableUI no-footer">
                                        <thead>
                                            <tr>
                                                <th>Name</th>
                                                <th>Age</th>
                                                <th>Gender</th>
                                                <th>Color</th>
                                                <th>Shirt</th>
                                                <th>Pent</th>
                                                <th>Jacket</th>
                                                <th>Socket</th>
                                                <th>Underwear</th>
                                                <th>Diaper</th>
                                                <th>Pajamas</th>
                                                <th>Shoes</th>
                                                <th>Additional need</th>
                                                <th>Wants</th>
                                                <th>School name</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($family->children as $key => $child)
                                            <tr>
                                                <td>{{ $child->name }}</td>
                                                <td>{{ $child->age }}</td>
                                                <td>{{ $child->gender }}</td>
                                                <td>{{ $child->color }}</td>
                                                <td>{{ $child->shirt_size }}</td>
                                                <td>{{ $child->pent_size }}</td>
                                                <td>{{ $child->jacket_size }}</td>
                                                <td>{{ $child->socks_size }}</td>
                                                <td>{{ $child->underwear_size }}</td>
                                                <td>{{ $child->diaper_size }}</td>
                                                <td>{{ $child->pajamas_size }}</td>
                                                <td>{{ $child->shoes_size }}</td>
                                                <td>{{ $child->additional_need }}</td>
                                                <td>{{ $child->wants }}</td>
                                                <td>{{ $child->school_name }}</td>
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
</div>

@endsection