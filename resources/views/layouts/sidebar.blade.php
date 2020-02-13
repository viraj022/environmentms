@section('sidebar')

    <!-- Sidebar user panel (optional) -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
            <img src="/dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
            <a href="#" class="d-block">Welcome, {{auth()->user()->first_name}}!</a>
        </div>
    </div>

    <!-- Sidebar Menu -->
    <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <!-- Add icons to the links using the .nav-icon class
                 with font-awesome or any other icon font library -->
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
                    <i class="nav-icon fas fa-user-shield"></i>
                    <p>
                        General Settings
                        <i class="right fas fa-angle-left"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    @foreach((auth()->user()->privileges) as $indexKey=>$pre)
                        @if($pre['id']===config('auth.privileges.userCreate'))
                            <li class="nav-item">
                                <a href="{{ url('/attachments') }}" class="nav-link {{ Request::is('attachments') ? 'active' : '' }}">
                                    <i class="fas fa-user-plus nav-icon"></i>
                                    <p>Attachements</p>
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
            
        </ul>
    </nav>
    <!-- /.sidebar-menu -->

@endsection
