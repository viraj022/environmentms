@section('sidebar')

<!-- Sidebar user panel (optional) -->
<div class="user-panel mt-3 pb-3 mb-3 d-flex">
    <!--    <div class="image">
            <img src="/dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
        </div>-->
    <div class="info">
        <a href="#" class="d-block">Welcome, {{auth()->user()->first_name}}!</a>
    </div>
</div>

<!-- Sidebar Menu -->
<nav class="mt-2">
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <!-- Add icons to the links using the .nav-icon class
             with font-awesome or any other icon font library -->
        <li class="nav-item has-treeview">
            <a href="#" class="nav-link active">
                <i class="nav-icon fas fa-tachometer-alt"></i>
                <p>
                    Dashboard
                    <i class="right fas fa-angle-left"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="./index.html" class="nav-link active">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Dashboard v1</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="./index2.html" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Dashboard v2</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="./index3.html" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Dashboard v3</p>
                    </a>
                </li>
            </ul>
        </li>
        <li class="nav-item has-treeview menu-open">
            <a href="#" class="nav-link active">
                <i class="nav-icon fas fa-user-shield"></i>
                <p>
                    User Management
                    <i class="right fas fa-angle-left"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">
                @foreach((auth()->user()->privileges) as $indexKey=>$pre)
                @if($pre['id']===config('auth.privileges.userCreate'))
                <li class="nav-item">
                    <a href="{{ url('/users') }}" class="nav-link {{ Request::is('users') ? 'active' : '' }}">
                        <i class="fas fa-user-plus nav-icon"></i>
                        <p>User Create</p>
                    </a>
                </li>
                @endif
                @if($pre['id']===config('auth.privileges.userRole') && auth()->user()->roll->level->value == 1)
                <li class="nav-item">
                    <a href="{{ url('/rolls') }}" class="nav-link {{ Request::is('rolls') ? 'active' : '' }}">
                        <i class="fas fa-users-cog nav-icon"></i>
                        <p>ROll Create</p>
                    </a>
                </li>
                @endif
                @endforeach

            </ul>
        </li>
        <li class="nav-item has-treeview menu-open">
            <a href="#" class="nav-link active">
                <i class="nav-icon fas fa-pencil-ruler"></i>
                <p>
                    General Settings
                    <i class="right fas fa-angle-left"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">
                @foreach((auth()->user()->privileges) as $indexKey=>$pre)
                @if($pre['id']===config('auth.privileges.attachments'))
                <li class="nav-item">
                    <a href="{{ url('/attachments') }}" class="nav-link {{ Request::is('attachments') ? 'active' : '' }}">
                        <i class="fas fa-file-archive nav-icon"></i>
                        <p>Attachements</p>
                    </a>
                </li>
                @endif
                @if($pre['id']===config('auth.privileges.pradesheyasaba') && auth()->user()->roll->level->value == 1)
                <li class="nav-item">
                    <a href="{{ url('/pradesheyasaba') }}" class="nav-link {{ Request::is('pradesheyasaba') ? 'active' : '' }}">
                        <i class="fas fa-city nav-icon"></i>
                        <p>Pradesheya Saba</p>
                    </a>
                </li>
                @endif
                @if($pre['id']===config('auth.privileges.industry') && auth()->user()->roll->level->value == 1)
                <li class="nav-item">
                    <a href="{{ url('/industry_category') }}" class="nav-link {{ Request::is('industry_category') ? 'active' : '' }}">
                        <i class="fas fa-puzzle-piece nav-icon"></i>
                        <p>Industry Category</p>
                    </a>
                </li>
                @endif
                @if($pre['id']===config('auth.privileges.industry'))
                <li class="nav-item">
                    <a href="{{ url('/payment_type') }}" class="nav-link {{ Request::is('payment_type') ? 'active' : '' }}">
                        <i class="fas fa-puzzle-piece nav-icon"></i>
                        <p>Payment Categoty</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ url('/payments') }}" class="nav-link {{ Request::is('payments') ? 'active' : '' }}">
                        <i class="fas fa-puzzle-piece nav-icon"></i>
                        <p>Payments</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ url('/payment_range') }}" class="nav-link {{ Request::is('payment_range') ? 'active' : '' }}">
                        <i class="fas fa-puzzle-piece nav-icon"></i>
                        <p>Payment Range</p>
                    </a>
                </li>
                @endif
                @if($pre['id']===config('auth.privileges.zone'))
                <li class="nav-item">
                    <a href="{{ url('/zone') }}" class="nav-link {{ Request::is('zone') ? 'active' : '' }}">
                        <i class="fas fa-file-archive nav-icon"></i>
                        <p>Zone</p>
                    </a>
                </li>
                @endif
                @if($pre['id']===config('auth.privileges.assistantDirector'))
                <li class="nav-item">
                    <a href="{{ url('/assistant_director') }}" class="nav-link {{ Request::is('assistant_director') ? 'active' : '' }}">
                        <i class="fas fa-puzzle-piece nav-icon"></i>
                        <p>Assistant Directors</p>
                    </a>
                </li>
                @endif

                @if($pre['id']===config('auth.privileges.environmentOfficer'))
                <li class="nav-item">
                    <a href="{{ url('/environment_officer') }}" class="nav-link {{ Request::is('environment_officer') ? 'active' : '' }}">
                        <i class="fas fa-puzzle-piece nav-icon"></i>
                        <p>Environment Officer</p>
                    </a>
                </li>
                @endif

                @endforeach

            </ul>
        </li>
        <li class="nav-item has-treeview menu-open">
            <a href="#" class="nav-link active">
                <i class="nav-icon fas fa-user-shield"></i>
                <p>
                    Licenses
                    <i class="right fas fa-angle-left"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">
                @foreach((auth()->user()->privileges) as $indexKey=>$pre)
                @if($pre['id']===config('auth.privileges.clientSpace'))
                <li class="nav-item">
                    <a href="{{ url('/client_space') }}" class="nav-link {{ Request::is('client_space') ? 'active' : '' }}">
                        <i class="fas fa-puzzle-piece nav-icon"></i>
                        <p>Client Space</p>
                    </a>
                </li>
                @endif
                @if($pre['id']===config('auth.privileges.clientSpace'))
                <li class="nav-item">
                    <a href="{{ url('/all_clients') }}" class="nav-link {{ Request::is('all_clients') ? 'active' : '' }}">
                        <i class="fas fa-puzzle-piece nav-icon"></i>
                        <p>Clients</p>
                    </a>
                </li>
                @endif
                @endforeach

            </ul>
        </li>

    </ul>
</nav>
<!-- /.sidebar-menu -->

@endsection
