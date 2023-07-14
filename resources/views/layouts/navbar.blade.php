<?php
use App\Enums\UserTypes;

?>

<nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top">
    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
        <i class="fa fa-bars"></i>
    </button>

    <ul class="navbar-nav ml-auto">
        <li class="nav-item dropdown no-arrow d-sm-none">
            <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-search fa-fw"></i>
            </a>
            <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in" aria-labelledby="searchDropdown">
                <form class="form-inline mr-auto w-100 navbar-search">
                    <div class="input-group">
                        <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
                        <div class="input-group-append">
                            <button class="btn btn-primary" type="button">
                                <i class="fas fa-search fa-sm"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </li>

        <?php
            $notificationsStats = getNavbarNotifications();
        ?>
        <li class="nav-item dropdown no-arrow mx-1">
            <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-bell fa-fw"></i>
                @if($notificationsStats['count'] > 0)
                    <span class="badge badge-danger badge-counter">{{ $notificationsStats['count'] }}</span>
                @endif
            </a>
            <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="alertsDropdown">
                <h6 class="dropdown-header">
                    Notification
                </h6>
                @foreach($notificationsStats['notifications'] as $noti)
                <a class="dropdown-item d-flex align-items-center" href="{{ route('notifications.index') }}">
                    <div class="mr-3">
                        <div class="icon-circle bg-primary">
                            <i class="fas fa-file-alt text-white"></i>
                        </div>
                    </div>
                    <div>
                        <span>{{ $noti->title }}</span>
                        <div class="small text-gray-500">{{ $noti->getFormattedTime() }} {{ $noti->getFormattedDate() }}</div>
                    </div>
                </a>
                @endforeach
                <a class="dropdown-item text-center small text-gray-500" href="{{ route('notifications.index') }}">Show All Alerts</a>
            </div>
        </li>

        @if(in_array(auth()->user()->role_id, [UserTypes::Admin, UserTypes::Moderator]))
        <?php
            $messagesStats = getNavbarMessages();
        ?>
        <li class="nav-item dropdown no-arrow mx-1">
            <a class="nav-link dropdown-toggle" href="#" id="messagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-envelope fa-fw"></i>
                @if($messagesStats['count'] > 0)
                <span class="badge badge-danger badge-counter">{{ $messagesStats['count'] }}</span>
                @endif
            </a>
            <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="messagesDropdown">
                <h6 class="dropdown-header">
                    Messages
                </h6>
                @foreach($messagesStats['messages'] as $msg)
                <a class="dropdown-item d-flex align-items-center" href="{{ url('/chat') }}/{{ $msg->from_id }}">
                    <div class="dropdown-list-image mr-3">
                        <img class="rounded-circle" src="{{ getProfileImage($msg->from) }}" alt="...">
                        <div class="status-indicator bg-success"></div>
                    </div>
                    <div class="font-weight-bold">
                        <div class="text-truncate">{{ $msg->body }}</div>
                    </div>
                </a>
                @endforeach

                <a class="dropdown-item text-center small text-gray-500" href="{{ url('/chat') }}">Read More Messages</a>
            </div>
        </li>
        @endif

        <div class="topbar-divider d-none d-sm-block"></div>
        <li class="nav-item dropdown no-arrow">
            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <img class="img-profile rounded-circle" src="{{ getProfileImage(auth()->user()) }}">
                <span class="ml-2 d-none d-lg-inline text-gray-600 small">{{ auth()->user()->name }}</span>
            </a>
            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                <a class="dropdown-item" href="{{ route('settings.index') }}">
                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i> Profile
                </a>
                <!-- <a class="dropdown-item" href="{{ route('settings.index') }}">
                    <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i> Settings
                </a> -->
                <a class="dropdown-item" href="{{ route('history.index') }}">
                    <i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i> Activity Log
                </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i> Logout
                </a>
            </div>
        </li>

    </ul>
</nav>