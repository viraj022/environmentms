@section('navbar')
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            <a href="/" class="nav-link btn btn-block bg-gradient-primary btn-xs text-white">Dashboard</a>
        </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
        @php
            $user = \Auth::user();
            $notifications = App\UserNotification::getSummary($user->id);
        @endphp

        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#" aria-expanded="false">
                <i class="far fa-bell"></i>
                @if ($notifications['count'] > 0)
                    <span class="badge badge-success text-white navbar-badge">{{ $notifications['count'] }}</span>
                @endif
            </a>

            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right" style="left: inherit; right: 0px;">


                @if ($notifications['count'] > 0)
                    <span class="dropdown-item dropdown-header">{{ $notifications['count'] }} Notifications</span>
                    <div class="dropdown-divider"></div>
                @endif

                @forelse ($notifications['notifications'] as $notification)
                    <a href="{{ route('userNotification.show', $notification) }}" class="dropdown-item"
                        style="white-space: normal;">
                        <i class="fas fa-envelope mr-2"></i>
                        {{ $notification->message }}
                        <span class="text-muted text-sm d-block">{{ $notification->created_at->diffForHumans() }}
                        </span>
                    </a>
                    <div class="dropdown-divider"></div>
                @empty
                    <span class="dropdown-item dropdown-header">No Notifications</span>
                @endforelse

                @if ($notifications['count'] > 0)
                    <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
                @endif

            </div>

        </li>

        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#">
                <i class="fas fa-user-cog"></i>

            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                <span class="dropdown-item dropdown-header">Settings</span>
                <div class="dropdown-divider"></div>
                <a href="/users/myProfile" class="dropdown-item">
                    <i class="fas fa-address-card mr-2"></i>My Profile

                </a>
                <div class="dropdown-divider"></div>
                <a href="/logout" class="dropdown-item">
                    <i class="fas fa-power-off mr-2"></i> Sign Out

                </a>
                {{-- <div class="dropdown-divider"            ></div> --}}
                {{-- <a href="#" class="dropdown-item"> --}}
                {{-- <i class="fas fa-file mr-2"></i> 3 new reports --}}
                {{-- <span class="float-right text-muted text-sm">2 days</span> --}}
                {{-- </        a> --}}

            </div>
        </li>

        {{-- <li class="nav-item">
            <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#">
                <i class="fas fa-th-large"></i>
            </a>
        </li> --}}
    </ul>

    <!-- /.navbar -->
@endsection
