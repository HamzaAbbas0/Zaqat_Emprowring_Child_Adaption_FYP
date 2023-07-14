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
                    <h1>Dashboard</h1>
                </div>
            </div>
            <div class="col-md-4">
                <div class="breadcrumbs">
                    <ul>
                        <li><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li><i class="fas fa-chevron-right"></i></li>
                        <li>Home</li>
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
                    <div class="contentWhiteBGRight shadow p-5 h-100">
                        <!-- <p>
                            Welcome to the 2022 North Mason Giving Tree registration page.
                        </p>
                        <p>
                            We ask that everyone who wants to register with the NM Giving Tree program use ONLY one Christmastime program, to not put a strain on the resources available to the community.
                        </p>
                        <p>
                            The NM Giving Tree program is only available to those who live in the North Mason School District area. Please complete the forms with your physical address and a valid phone number.
                        </p>
                        <p>
                            We may need to contact you for clarification or for distribution day.
                        </p>
                        <p>
                            You may register your children from ages birth through 14.
                        </p>
                        <p>
                            If you have older teens, you may also register them, but you must have younger children in your family to register those 15-18 years of age.
                        </p>
                        <p>
                            If you only have 15-18 aged children, there is the All Teens Matter program available to you (see <a target="_blank" href="http://allteensmatter.com/">http://allteensmatter.com/</a>).
                        </p>
                        <p>
                            The NM Giving Tree is a program that was originally formed in the early 1980s by the North Mason Lions Club, and now is a much larger program that includes many NM service organizations and non-profits; including NM Coalition of Churches and Community, Hood Canal Salmon Enhancement Center, NM Boys and Girls Club, NM Food Bank, NM Kiwanis, NM Lions, NM Rotary Club and The HUB. All done with the support of the NM community.
                        </p> -->
                        <p>
                            In order to request services from the North Mason Lions Club, Please click "ADD NEW REQUEST"
                        </p>
                        <p>
                            In order to sign up for the Giving Tree Program, Please click "GIVING TREE SIGN UP"
                        </p>
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