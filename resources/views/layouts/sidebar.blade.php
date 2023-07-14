<?php

use App\Enums\UserTypes;
use App\Enums\ServiceTypes;

?>

<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion dashboardSidebar" id="accordionSidebar">
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('dashboard') }}">
        <div class="sidebar-brand-icon">
            <img src="{{ asset('public/images/logo-md.png') }}" class="img-fluid" alt="">
        </div>
    </a>

    <hr class="sidebar-divider my-0">

    <li class="nav-item active">
        <a class="nav-link" href="{{ route('dashboard') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span class="titleName">Dashboard</span></a>
    </li>

    <hr class="sidebar-divider">

    <li class="nav-item">
        <a class="nav-link collapsed" href="{{ route('dashboard') }}">
            <i class="fas fa-home"></i>
            <span>Home</span>
        </a>
    </li>

    @if(in_array(auth()->user()->role_id, [UserTypes::Admin, UserTypes::Moderator]))
    <li class="nav-item">
        <a class="nav-link collapsed" href="{{ route('users.index') }}">
            <i class="fas fa-users"></i>
            <span>Users</span>
        </a>
    </li>
    @endif

    @if(in_array(auth()->user()->role_id, [UserTypes::Admin]))
    <li class="nav-item">
        <a class="nav-link collapsed" href="#servicesCollapseMenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
            <i class="fas fa-file"></i>
            <span>Services</span>
        </a>
        <ul class="collapse navbar-nav" id="servicesCollapseMenu">
            <li class="nav-item">
                <a class="nav-link" href="{{ route('services.view', ServiceTypes::Eyeglasses_Recycling) }}">
                    <span>Eyeglasses Recycling</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('services.view', ServiceTypes::Adoption) }}">
                    <span>Adoption</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('services.view', ServiceTypes::Ramp_Building) }}">
                    <span>Ramp Building</span>
                </a>
            </li>
        </ul>
    </li>
    @endif

    @if(in_array(auth()->user()->role_id, [UserTypes::Applicant, UserTypes::Admin, UserTypes::Moderator]))
    <li class="nav-item">
        <a class="nav-link collapsed" href="{{ route('requests.create') }}">
            <i class="fas fa-user-plus"></i>
            <span>Add New Request</span>
        </a>
    </li>
    @endif

    @if(in_array(auth()->user()->role_id, [UserTypes::Admin, UserTypes::Moderator, UserTypes::Donor]))
    <li class="nav-item">
        <a class="nav-link collapsed" href="{{ route('requests.index') }}">
            <i class="fas fa-folder-open"></i>
            <span>Requests</span>
        </a>
    </li>
    @endif

    @if(in_array(auth()->user()->role_id, [UserTypes::Applicant]))
    <!-- <li class="nav-item">
        <a class="nav-link collapsed" href="{{ route('history.index') }}">
            <i class="fas fa-history"></i>
            <span>History</span>
        </a>
    </li> -->

    <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
            <i class="fas fa-history"></i>
            My Items
        </a>
        <div class="dropdown-menu">
            <a class="dropdown-item" href="{{ route('history.index') }}">Requests History</a>
            @if(getIfAdoptionIsActive())
            <a class="dropdown-item" href="{{ route('history.adoption') }}">Adoption History</a>
            @endif
        </div>
    </li>
    @endif

    <!-- <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
            <i class="fas fa-users"></i>
            Families
        </a>
        <div class="dropdown-menu">
            <a class="dropdown-item" href="{{ route('families.index') }}">Families</a>
            @if(in_array(auth()->user()->role_id, [UserTypes::Donor, UserTypes::Applicant]))
            <a class="dropdown-item" href="{{ route('families.requested.to.help') }}">Requested to Help</a>
            @endif
        </div>
    </li> -->

    @if(in_array(auth()->user()->role_id, [UserTypes::Admin]))
    <li class="nav-item">
        <a class="nav-link collapsed" href="{{ route('families.index') }}">
            <i class="fas fa-users"></i>
            <span>Families</span>
        </a>
    </li>
    @endif

    @if(getIfAdoptionIsActive() && in_array(auth()->user()->role_id, [UserTypes::Applicant]))
    <li class="nav-item">
        <a class="nav-link collapsed" href="{{ route('childrens.index') }}">
            <i class="fas fa-users"></i>
            <span>Giving tree adoptions</span>
        </a>
    </li>
    @endif



    <li class="nav-item">
        <a class="nav-link collapsed" href="{{ route('settings.index') }}">
            <i class="fas fa-cog"></i>
            <span>Settings</span>
        </a>
    </li>

    @if(in_array(auth()->user()->role_id, [UserTypes::Applicant, UserTypes::Donor]))
    <li class="nav-item">
        <a class="nav-link" href="{{ route('contact.index') }}">
            <i class="fas fa-address-book"></i>
            <span>Contact Us</span></a>
    </li>
    @endif

    @if(in_array(auth()->user()->role_id, [UserTypes::Applicant, UserTypes::Admin, UserTypes::Moderator]))
    <li class="nav-item">
        <a class="nav-link" href="{{ route('giving-tree.index') }}">
            <i class="fas fa-tree"></i>
            <span>Giving Tree Sign Up</span>
        </a>
    </li>
    @endif

    <hr class="sidebar-divider d-none d-md-block">

    <li class="nav-item">
        <a class="nav-link" href="#" data-toggle="modal" data-target="#logoutModal">
            <i class="fas fa-sign-out-alt"></i>
            <span>Log Out</span>
        </a>
    </li>

    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>
</ul>