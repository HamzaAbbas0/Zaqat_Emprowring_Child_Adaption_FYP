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
                    <h1>Adoption Request</h1>
                </div>
            </div>
            <div class="col-md-4">
                <div class="breadcrumbs">
                    <ul>
                        <li><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li><i class="fas fa-chevron-right"></i></li>
                        <li>Adoption Request</li>
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
                                            <th style="width: 100px">Date time</th>
                                            <th>Name</th>
                                            <th>Age</th>
                                            <th>Gender</th>
                                            <th>Shirt</th>
                                            <th>Pent</th>
                                            <th>Jacket</th>
                                            <th>Underwear</th>
                                            <th>Diaper</th>
                                            <th>Pajamas</th>
                                            <th>Shoes</th>
                                            <th>School</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($childrens as $key => $child)
                                        <tr>
                                            <td>{{ $child->created_at }}</td>
                                            <td>{{ $child->name }}</td>
                                            <td>{{ $child->age }}</td>
                                            <td>{{ $child->gender }}</td>
                                            <td>{{ $child->shirt_size }}</td>
                                            <td>{{ $child->pent_size }}</td>
                                            <td>{{ $child->jacket_size }}</td>
                                            <td>{{ $child->underwear_size }}</td>
                                            <td>{{ $child->diaper_size }}</td>
                                            <td>{{ $child->pajamas_size }}</td>
                                            <td>{{ $child->shoes_size }}</td>
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
@endsection