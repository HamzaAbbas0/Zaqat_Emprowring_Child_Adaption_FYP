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
                    <h1>Giving tree adoptions</h1>
                </div>
            </div>
            <div class="col-md-4">
                <div class="breadcrumbs">
                    <ul>
                        <li><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li><i class="fas fa-chevron-right"></i></li>
                        <li>Giving tree adoptions</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="contentPageWhiteBG mb-5">
    <div class="row justify-content-center mx-3">
        <div class="col-lg-12 col-md-12">
            @if(session()->has('flash_error'))
            <div class="alert alert-danger">{{ session()->get('flash_error') }}</div>
            @endif

            @if(session()->has('flash_success'))
            <div class="alert alert-success">{{ session()->get('flash_success') }}</div>
            @endif
            <div class="row">
                <div class="col-lg-12 col-md-12">
                    <div class="card shadow mb-4">
                        <div class="card-body">
                            <form action="{{ route('families.help') }}" method="POST" class="mt-3 adoptForm" name="adoptForm">
                                @csrf
                                <div class="form-group row">
                                    <div class="formFieldBTN" style="text-align:left;">
                                        <a href="javascript:void(0)" onclick="onAdoptFormSubmit(this)" style="padding: 15px 25px;">I would like to adopt the selected children</a>
                                    </div>
                                </div>
                            </form>
                            <div class="table-responsive">
                                <table class="table table-bordered customTableUI" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>..</th>
                                            <th style="width: 100px">Date time</th>
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
                                            <td>
                                                <input type="checkbox" class="select_child" data-child-id="{{ $child->id }}" />
                                            </td>
                                            <td>{{ $child->created_at }}</td>
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


@section('footer-scripts')
<script>
    $(document).ready(function() {
        $('table input.select_child').change(function() {
            var childId = $(this).data('child-id');

            if ($(this).prop('checked')) {
                $(".adoptForm").append(`
                    <input type="hidden" name="childrens[]" id="child_${childId}" value="${childId}" />
                `);
            } else {
                $("#child_" + childId).remove();
            }

        });

        // $('.select-bulk-actions').change(function() {
        //     if ($(this).val() != 'request_adoption') {
        //         return $(this).val('')
        //     }

        //     if (!$('.select_child').is(':checked')) {
        //         $(this).val('')
        //         return alert("Please select any child");
        //     }

        //     this.form.submit();
        // });

    });

    function onAdoptFormSubmit(e) {
        if (!$('.select_child').is(':checked')) {
            return alert("Please select any child");
        }

        document.adoptForm.submit();
    }
</script>
@endsection