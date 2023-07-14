<?php

use App\Enums\UserTypes;

?>
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
                    <h1>Family</h1>
                </div>
            </div>
            <div class="col-md-4">
                <div class="breadcrumbs">
                    <ul>
                        <li><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li><i class="fas fa-chevron-right"></i></li>
                        <li><a href="{{ route('families.index') }}">Families</a></li>
                        <li><i class="fas fa-chevron-right"></i></li>
                        <li>Family</li>
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
                    @if(session()->has('flash_error'))
                    <div class="alert alert-danger">{{ session()->get('flash_error') }}</div>
                    @endif

                    @if(session()->has('flash_success'))
                    <div class="alert alert-success">{{ session()->get('flash_success') }}</div>
                    @endif

                    <div class="card shadow mb-4">
                        <div class="card-body">
                            <div class="donationRequestForm">
                                <div class="row">
                                    <h5>Family Details: </h5>
                                </div>
                                <div class="row">
                                    @if(in_array(auth()->user()->role_id, [UserTypes::Admin, UserTypes::Moderator]))
                                    <div class="col-md-4">
                                        <div class="formLabel">Name</div>
                                        <div class="formField">
                                            <input type="text" value="{{ $family->name }}" disabled />
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="formLabel">Email</div>
                                        <div class="formField">
                                            <input type="text" value="{{ $family->email }}" disabled />
                                        </div>
                                    </div>
                                    @endif
                                    <div class="col-md-4">
                                        <div class="formLabel">People in Household</div>
                                        <div class="formField">
                                            <input type="text" value="{{ $family->people_in_household }}" disabled />
                                        </div>
                                    </div>
                                    @if(in_array(auth()->user()->role_id, [UserTypes::Admin, UserTypes::Moderator]))
                                    <div class="col-md-12">
                                        <div class="formLabel">Address</div>
                                        <div class="formField">
                                            <input type="text" value="{{ $family->address }}" disabled />
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="formLabel">City</div>
                                        <div class="formField">
                                            <input type="text" value="{{ $family->getCityName() }}" disabled />
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="formLabel">State</div>
                                        <div class="formField">
                                            <input type="text" value="{{ $family->getStateName() }}" disabled />
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="formLabel">ZIP</div>
                                        <div class="formField">
                                            <input type="text" value="{{ $family->zip }}" disabled />
                                        </div>
                                    </div>
                                    @endif
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
                                                <th>..</th>
                                                <th>Name</th>
                                                <th>Age</th>
                                                <th>Gender</th>
                                                <th>Color</th>
                                                <th>Shirt</th>
                                                <th>Pent</th>
                                                <th>Jacket</th>
                                                <th>Socks</th>
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
                                                <td>
                                                    <input type="checkbox" class="select_child" data-child-id="{{ $child->id }}" />
                                                </td>
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

                                <!-- <br />

                                <div class="row">
                                    <p for="whole_family"><input id="whole_family" type="checkbox" value="1" /> &nbsp; I want to support whole family</p>
                                </div> -->

                                <br />
                                @if(in_array(auth()->user()->role_id, [UserTypes::Donor, UserTypes::Applicant]))
                                <form name="wantToHelpForm" action="{{ route('families.want.to.help', $family->id) }}" method="POST">
                                    @csrf
                                    <input type="hidden" value="{{ $family->id }}" name="family_id" />

                                    <div class="row">
                                        <div class="formFieldBTN">
                                            <a href="javascript:document.wantToHelpForm.submit()" style="margin-right: 20px">Want to help?</a>
                                        </div>
                                    </div>
                                </form>
                                @endif
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
    $(document).ready(function() {
        $('table input.select_child').change(function() {
            var childId = $(this).data('child-id');
            
            if ($(this).prop('checked')) {
                $(".formFieldBTN").append(`
                    <input type="hidden" name="childrens[]" id="child_${childId}" value="${childId}" />
                `);
            } else {
                $("#child_" + childId).remove();
            }

        });

        $('#whole_family').change(function() {
            if (this.checked) {
                $('table input.select_child').prop('checked', true);
                $('table input.select_child').attr('disabled', true);

                $(".formFieldBTN").append(`
                    <input type="hidden" name="childrens[]" id="child_all" value="*" />
                `);
            } else {
                $('table input.select_child').prop('checked', false);
                $('table input.select_child').attr('disabled', false);
            }
        });
    });
</script>
@endsection