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
            </li>        <li class="nav-item has-treeview menu-open">
                <a href="#" class="nav-link active">
                    <i class="nav-icon fas fa-edit"></i>
                    <p>
                        General Settings
                        <i class="right fas fa-angle-left"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    @foreach((auth()->user()->privileges) as $indexKey=>$pre)
                        @if($pre['id']===config('auth.privileges.userCreate') && auth()->user()->roll->level->value < 3)
                            <li class="nav-item">
                                <a href="{{ url('/localAuthority') }}" class="nav-link {{ Request::is('localAuthority') ? 'active' : '' }}">
                                    <i class="fas fa-map-marker-alt nav-icon"></i>
                                    <p>Local Authority Registration</p>
                                </a>
                            </li>
                        @endif
                        @if($pre['id']===config('auth.privileges.suboffice') && auth()->user()->roll->level->value == 3)
                            <li class="nav-item">
                                <a href="{{ url('/suboffice') }}" class="nav-link {{ Request::is('suboffice') ? 'active' : '' }}">
                                    <i class="fas fa-map-marked-alt nav-icon"></i>
                                    <p>Suboffice Registration</p>
                                </a>
                            </li>
                        @endif
                        {{-- @if($pre['id']===config('auth.privileges.userCreate'))
                            <li class="nav-item">
                                <a href="{{ url('/survey') }}" class="nav-link {{ Request::is('survey') ? 'active' : '' }}">
                                    <i class="fas fa-list-alt nav-icon"></i>
                                    <p>Survey Setup</p>
                                </a>
                            </li>
                        @endif --}}
                        {{-- @if($pre['id']===config('auth.privileges.userCreate'))
                            <li class="nav-item">
                                <a href="{{ url('/survey_view') }}" class="nav-link {{ Request::is('survey_view') ? 'active' : '' }}">
                                    <i class="fas fa-th-list nav-icon"></i>
                                    <p>Survey</p>
                                </a>
                            </li>
                        @endif --}}
                        @if($pre['id']===config('auth.privileges.plant'))
                            <li class="nav-item">
                                <a href="{{ url('/plant') }}" class="nav-link {{ Request::is('plant') ? 'active' : '' }}">
                                    <i class="fas fa-tree nav-icon"></i>
                                    <p>Plant</p>
                                </a>
                            </li>
                        @endif
                        @if($pre['id']===config('auth.privileges.transferStation'))
                            <li class="nav-item">
                                <a href="{{ url('/transfer_station') }}" class="nav-link {{ Request::is('transfer_station') ? 'active' : '' }}">
                                    <i class="fas fa-map-signs nav-icon"></i>
                                    <p>Transfer Stations</p>
                                </a>
                            </li>
                        @endif
                        @if($pre['id']===config('auth.privileges.dumpsite'))
                            <li class="nav-item">
                                <a href="{{ url('/dumpsite') }}" class="nav-link {{ Request::is('dumpsite') ? 'active' : '' }}">
                                    <i class="fas fa-trash-alt nav-icon"></i>
                                    <p>Dump Sites</p>
                                </a>
                            </li>
                        @endif
                        @if($pre['id']===config('auth.privileges.sampath'))
                            <li class="nav-item">
                                <a href="{{ url('/sampath') }}" class="nav-link {{ Request::is('sampath') ? 'active' : '' }}">
                                    <i class="fas fa-database nav-icon"></i>
                                    <p>Sampath Kendraya</p>
                                </a>
                            </li>
                        @endif
                        @if($pre['id']===config('auth.privileges.ward'))
                            <li class="nav-item">
                                <a href="/ward" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Wards</p>
                                </a>
                            </li>
                        @endif
                        @if($pre['id']===config('auth.privileges.vehicle'))
                            <li class="nav-item">
                                <a href="/vehicle" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Vehicles</p>
                                </a>
                            </li>
                        @endif
                    @endforeach

                </ul>
            </li>
                  <li class="nav-item has-treeview menu-open">
                <a href="#" class="nav-link active">
                    <i class="nav-icon fas fa-edit"></i>
                    <p>
                        Survey
                        <i class="right fas fa-angle-left"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    @foreach((auth()->user()->privileges) as $indexKey=>$pre)


                        @if($pre['id']===config('auth.privileges.userCreate') && auth()->user()->roll->level->value == 1)
                            <li class="nav-item">
                                <a href="{{ url('/survey') }}" class="nav-link {{ Request::is('survey') ? 'active' : '' }}">
                                    <i class="far fa-chart-bar nav-icon"></i>
                                    <p>Survey Setup</p>
                                </a>
                            </li>
                        @endif
                        @if($pre['id']===config('auth.privileges.userCreate') && auth()->user()->roll->level->value == 1)
                            <li class="nav-item">
                                <a href="{{ url('/survey_session') }}" class="nav-link {{ Request::is('survey_session') ? 'active' : '' }}">
                                    <i class="far fa-chart-bar nav-icon"></i>
                                    <p>Survey Session</p>
                                </a>
                            </li>
                        @endif
                          @if($pre['id']===config('auth.privileges.userCreate') && auth()->user()->roll->level->value == 3)
  @foreach((auth()->user()->surveys()) as $indexKey=>$s)
                            <li class="nav-item">
                                <a href="/survey_view/id/{{$s['id']}}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>{{$s['name']}}</p>
                                </a>
                            </li>
   @endforeach
    @endif
                    @endforeach

                </ul>
            </li>
            {{--                <li class="nav-item">--}}
            {{--                    <a href="pages/widgets.html" class="nav-link">--}}
            {{--                        <i class="nav-icon fas fa-th"></i>--}}
            {{--                        <p>--}}
            {{--                            Widgets--}}
            {{--                            <span class="right badge badge-danger">New</span>--}}
            {{--                        </p>--}}
            {{--                    </a>--}}
            {{--                </li>--}}
            {{--                <li class="nav-item has-treeview">--}}
            {{--                    <a href="#" class="nav-link">--}}
            {{--                        <i class="nav-icon fas fa-copy"></i>--}}
            {{--                        <p>--}}
            {{--                            Layout Options--}}
            {{--                            <i class="fas fa-angle-left right"></i>--}}
            {{--                            <span class="badge badge-info right">6</span>--}}
            {{--                        </p>--}}
            {{--                    </a>--}}
            {{--                    <ul class="nav nav-treeview">--}}
            {{--                        <li class="nav-item">--}}
            {{--                            <a href="pages/layout/top-nav.html" class="nav-link">--}}
            {{--                                <i class="far fa-circle nav-icon"></i>--}}
            {{--                                <p>Top Navigation</p>--}}
            {{--                            </a>--}}
            {{--                        </li>--}}
            {{--                        <li class="nav-item">--}}
            {{--                            <a href="pages/layout/boxed.html" class="nav-link">--}}
            {{--                                <i class="far fa-circle nav-icon"></i>--}}
            {{--                                <p>Boxed</p>--}}
            {{--                            </a>--}}
            {{--                        </li>--}}
            {{--                        <li class="nav-item">--}}
            {{--                            <a href="pages/layout/fixed-sidebar.html" class="nav-link">--}}
            {{--                                <i class="far fa-circle nav-icon"></i>--}}
            {{--                                <p>Fixed Sidebar</p>--}}
            {{--                            </a>--}}
            {{--                        </li>--}}
            {{--                        <li class="nav-item">--}}
            {{--                            <a href="pages/layout/fixed-topnav.html" class="nav-link">--}}
            {{--                                <i class="far fa-circle nav-icon"></i>--}}
            {{--                                <p>Fixed Navbar</p>--}}
            {{--                            </a>--}}
            {{--                        </li>--}}
            {{--                        <li class="nav-item">--}}
            {{--                            <a href="pages/layout/fixed-footer.html" class="nav-link">--}}
            {{--                                <i class="far fa-circle nav-icon"></i>--}}
            {{--                                <p>Fixed Footer</p>--}}
            {{--                            </a>--}}
            {{--                        </li>--}}
            {{--                        <li class="nav-item">--}}
            {{--                            <a href="pages/layout/collapsed-sidebar.html" class="nav-link">--}}
            {{--                                <i class="far fa-circle nav-icon"></i>--}}
            {{--                                <p>Collapsed Sidebar</p>--}}
            {{--                            </a>--}}
            {{--                        </li>--}}
            {{--                    </ul>--}}
            {{--                </li>--}}
            {{--                <li class="nav-item has-treeview">--}}
            {{--                    <a href="#" class="nav-link">--}}
            {{--                        <i class="nav-icon fas fa-chart-pie"></i>--}}
            {{--                        <p>--}}
            {{--                            Charts--}}
            {{--                            <i class="right fas fa-angle-left"></i>--}}
            {{--                        </p>--}}
            {{--                    </a>--}}
            {{--                    <ul class="nav nav-treeview">--}}
            {{--                        <li class="nav-item">--}}
            {{--                            <a href="pages/charts/chartjs.html" class="nav-link">--}}
            {{--                                <i class="far fa-circle nav-icon"></i>--}}
            {{--                                <p>ChartJS</p>--}}
            {{--                            </a>--}}
            {{--                        </li>--}}
            {{--                        <li class="nav-item">--}}
            {{--                            <a href="pages/charts/flot.html" class="nav-link">--}}
            {{--                                <i class="far fa-circle nav-icon"></i>--}}
            {{--                                <p>Flot</p>--}}
            {{--                            </a>--}}
            {{--                        </li>--}}
            {{--                        <li class="nav-item">--}}
            {{--                            <a href="pages/charts/inline.html" class="nav-link">--}}
            {{--                                <i class="far fa-circle nav-icon"></i>--}}
            {{--                                <p>Inline</p>--}}
            {{--                            </a>--}}
            {{--                        </li>--}}
            {{--                    </ul>--}}
            {{--                </li>--}}
            {{--                <li class="nav-item has-treeview">--}}
            {{--                    <a href="#" class="nav-link">--}}
            {{--                        <i class="nav-icon fas fa-tree"></i>--}}
            {{--                        <p>--}}
            {{--                            UI Elements--}}
            {{--                            <i class="fas fa-angle-left right"></i>--}}
            {{--                        </p>--}}
            {{--                    </a>--}}
            {{--                    <ul class="nav nav-treeview">--}}
            {{--                        <li class="nav-item">--}}
            {{--                            <a href="pages/UI/general.html" class="nav-link">--}}
            {{--                                <i class="far fa-circle nav-icon"></i>--}}
            {{--                                <p>General</p>--}}
            {{--                            </a>--}}
            {{--                        </li>--}}
            {{--                        <li class="nav-item">--}}
            {{--                            <a href="pages/UI/icons.html" class="nav-link">--}}
            {{--                                <i class="far fa-circle nav-icon"></i>--}}
            {{--                                <p>Icons</p>--}}
            {{--                            </a>--}}
            {{--                        </li>--}}
            {{--                        <li class="nav-item">--}}
            {{--                            <a href="pages/UI/buttons.html" class="nav-link">--}}
            {{--                                <i class="far fa-circle nav-icon"></i>--}}
            {{--                                <p>Buttons</p>--}}
            {{--                            </a>--}}
            {{--                        </li>--}}
            {{--                        <li class="nav-item">--}}
            {{--                            <a href="pages/UI/sliders.html" class="nav-link">--}}
            {{--                                <i class="far fa-circle nav-icon"></i>--}}
            {{--                                <p>Sliders</p>--}}
            {{--                            </a>--}}
            {{--                        </li>--}}
            {{--                        <li class="nav-item">--}}
            {{--                            <a href="pages/UI/modals.html" class="nav-link">--}}
            {{--                                <i class="far fa-circle nav-icon"></i>--}}
            {{--                                <p>Modals & Alerts</p>--}}
            {{--                            </a>--}}
            {{--                        </li>--}}
            {{--                        <li class="nav-item">--}}
            {{--                            <a href="pages/UI/navbar.html" class="nav-link">--}}
            {{--                                <i class="far fa-circle nav-icon"></i>--}}
            {{--                                <p>Navbar & Tabs</p>--}}
            {{--                            </a>--}}
            {{--                        </li>--}}
            {{--                        <li class="nav-item">--}}
            {{--                            <a href="pages/UI/timeline.html" class="nav-link">--}}
            {{--                                <i class="far fa-circle nav-icon"></i>--}}
            {{--                                <p>Timeline</p>--}}
            {{--                            </a>--}}
            {{--                        </li>--}}
            {{--                        <li class="nav-item">--}}
            {{--                            <a href="pages/UI/ribbons.html" class="nav-link">--}}
            {{--                                <i class="far fa-circle nav-icon"></i>--}}
            {{--                                <p>Ribbons</p>--}}
            {{--                            </a>--}}
            {{--                        </li>--}}
            {{--                    </ul>--}}
            {{--                </li>--}}
            {{--                <li class="nav-item has-treeview">--}}
            {{--                    <a href="#" class="nav-link">--}}
            {{--                        <i class="nav-icon fas fa-edit"></i>--}}
            {{--                        <p>--}}
            {{--                            Forms--}}
            {{--                            <i class="fas fa-angle-left right"></i>--}}
            {{--                        </p>--}}
            {{--                    </a>--}}
            {{--                    <ul class="nav nav-treeview">--}}
            {{--                        <li class="nav-item">--}}
            {{--                            <a href="pages/forms/general.html" class="nav-link">--}}
            {{--                                <i class="far fa-circle nav-icon"></i>--}}
            {{--                                <p>General Elements</p>--}}
            {{--                            </a>--}}
            {{--                        </li>--}}
            {{--                        <li class="nav-item">--}}
            {{--                            <a href="pages/forms/advanced.html" class="nav-link">--}}
            {{--                                <i class="far fa-circle nav-icon"></i>--}}
            {{--                                <p>Advanced Elements</p>--}}
            {{--                            </a>--}}
            {{--                        </li>--}}
            {{--                        <li class="nav-item">--}}
            {{--                            <a href="pages/forms/editors.html" class="nav-link">--}}
            {{--                                <i class="far fa-circle nav-icon"></i>--}}
            {{--                                <p>Editors</p>--}}
            {{--                            </a>--}}
            {{--                        </li>--}}
            {{--                    </ul>--}}
            {{--                </li>--}}
            {{--                <li class="nav-item has-treeview">--}}
            {{--                    <a href="#" class="nav-link">--}}
            {{--                        <i class="nav-icon fas fa-table"></i>--}}
            {{--                        <p>--}}
            {{--                            Tables--}}
            {{--                            <i class="fas fa-angle-left right"></i>--}}
            {{--                        </p>--}}
            {{--                    </a>--}}
            {{--                    <ul class="nav nav-treeview">--}}
            {{--                        <li class="nav-item">--}}
            {{--                            <a href="pages/tables/simple.html" class="nav-link">--}}
            {{--                                <i class="far fa-circle nav-icon"></i>--}}
            {{--                                <p>Simple Tables</p>--}}
            {{--                            </a>--}}
            {{--                        </li>--}}
            {{--                        <li class="nav-item">--}}
            {{--                            <a href="pages/tables/data.html" class="nav-link">--}}
            {{--                                <i class="far fa-circle nav-icon"></i>--}}
            {{--                                <p>DataTables</p>--}}
            {{--                            </a>--}}
            {{--                        </li>--}}
            {{--                        <li class="nav-item">--}}
            {{--                            <a href="pages/tables/jsgrid.html" class="nav-link">--}}
            {{--                                <i class="far fa-circle nav-icon"></i>--}}
            {{--                                <p>jsGrid</p>--}}
            {{--                            </a>--}}
            {{--                        </li>--}}
            {{--                    </ul>--}}
            {{--                </li>--}}
            {{--                <li class="nav-header">EXAMPLES</li>--}}
            {{--                <li class="nav-item">--}}
            {{--                    <a href="pages/calendar.html" class="nav-link">--}}
            {{--                        <i class="nav-icon far fa-calendar-alt"></i>--}}
            {{--                        <p>--}}
            {{--                            Calendar--}}
            {{--                            <span class="badge badge-info right">2</span>--}}
            {{--                        </p>--}}
            {{--                    </a>--}}
            {{--                </li>--}}
            {{--                <li class="nav-item">--}}
            {{--                    <a href="pages/gallery.html" class="nav-link">--}}
            {{--                        <i class="nav-icon far fa-image"></i>--}}
            {{--                        <p>--}}
            {{--                            Gallery--}}
            {{--                        </p>--}}
            {{--                    </a>--}}
            {{--                </li>--}}
            {{--                <li class="nav-item has-treeview">--}}
            {{--                    <a href="#" class="nav-link">--}}
            {{--                        <i class="nav-icon far fa-envelope"></i>--}}
            {{--                        <p>--}}
            {{--                            Mailbox--}}
            {{--                            <i class="fas fa-angle-left right"></i>--}}
            {{--                        </p>--}}
            {{--                    </a>--}}
            {{--                    <ul class="nav nav-treeview">--}}
            {{--                        <li class="nav-item">--}}
            {{--                            <a href="pages/mailbox/mailbox.html" class="nav-link">--}}
            {{--                                <i class="far fa-circle nav-icon"></i>--}}
            {{--                                <p>Inbox</p>--}}
            {{--                            </a>--}}
            {{--                        </li>--}}
            {{--                        <li class="nav-item">--}}
            {{--                            <a href="pages/mailbox/compose.html" class="nav-link">--}}
            {{--                                <i class="far fa-circle nav-icon"></i>--}}
            {{--                                <p>Compose</p>--}}
            {{--                            </a>--}}
            {{--                        </li>--}}
            {{--                        <li class="nav-item">--}}
            {{--                            <a href="pages/mailbox/read-mail.html" class="nav-link">--}}
            {{--                                <i class="far fa-circle nav-icon"></i>--}}
            {{--                                <p>Read</p>--}}
            {{--                            </a>--}}
            {{--                        </li>--}}
            {{--                    </ul>--}}
            {{--                </li>--}}
            {{--                <li class="nav-item has-treeview">--}}
            {{--                    <a href="#" class="nav-link">--}}
            {{--                        <i class="nav-icon fas fa-book"></i>--}}
            {{--                        <p>--}}
            {{--                            Pages--}}
            {{--                            <i class="fas fa-angle-left right"></i>--}}
            {{--                        </p>--}}
            {{--                    </a>--}}
            {{--                    <ul class="nav nav-treeview">--}}
            {{--                        <li class="nav-item">--}}
            {{--                            <a href="pages/examples/invoice.html" class="nav-link">--}}
            {{--                                <i class="far fa-circle nav-icon"></i>--}}
            {{--                                <p>Invoice</p>--}}
            {{--                            </a>--}}
            {{--                        </li>--}}
            {{--                        <li class="nav-item">--}}
            {{--                            <a href="pages/examples/profile.html" class="nav-link">--}}
            {{--                                <i class="far fa-circle nav-icon"></i>--}}
            {{--                                <p>Profile</p>--}}
            {{--                            </a>--}}
            {{--                        </li>--}}
            {{--                        <li class="nav-item">--}}
            {{--                            <a href="pages/examples/e_commerce.html" class="nav-link">--}}
            {{--                                <i class="far fa-circle nav-icon"></i>--}}
            {{--                                <p>E-commerce</p>--}}
            {{--                            </a>--}}
            {{--                        </li>--}}
            {{--                        <li class="nav-item">--}}
            {{--                            <a href="pages/examples/projects.html" class="nav-link">--}}
            {{--                                <i class="far fa-circle nav-icon"></i>--}}
            {{--                                <p>Projects</p>--}}
            {{--                            </a>--}}
            {{--                        </li>--}}
            {{--                        <li class="nav-item">--}}
            {{--                            <a href="pages/examples/project_add.html" class="nav-link">--}}
            {{--                                <i class="far fa-circle nav-icon"></i>--}}
            {{--                                <p>Project Add</p>--}}
            {{--                            </a>--}}
            {{--                        </li>--}}
            {{--                        <li class="nav-item">--}}
            {{--                            <a href="pages/examples/project_edit.html" class="nav-link">--}}
            {{--                                <i class="far fa-circle nav-icon"></i>--}}
            {{--                                <p>Project Edit</p>--}}
            {{--                            </a>--}}
            {{--                        </li>--}}
            {{--                        <li class="nav-item">--}}
            {{--                            <a href="pages/examples/project_detail.html" class="nav-link">--}}
            {{--                                <i class="far fa-circle nav-icon"></i>--}}
            {{--                                <p>Project Detail</p>--}}
            {{--                            </a>--}}
            {{--                        </li>--}}
            {{--                        <li class="nav-item">--}}
            {{--                            <a href="pages/examples/contacts.html" class="nav-link">--}}
            {{--                                <i class="far fa-circle nav-icon"></i>--}}
            {{--                                <p>Contacts</p>--}}
            {{--                            </a>--}}
            {{--                        </li>--}}
            {{--                    </ul>--}}
            {{--                </li>--}}
            {{--                <li class="nav-item has-treeview">--}}
            {{--                    <a href="#" class="nav-link">--}}
            {{--                        <i class="nav-icon far fa-plus-square"></i>--}}
            {{--                        <p>--}}
            {{--                            Extras--}}
            {{--                            <i class="fas fa-angle-left right"></i>--}}
            {{--                        </p>--}}
            {{--                    </a>--}}
            {{--                    <ul class="nav nav-treeview">--}}
            {{--                        <li class="nav-item">--}}
            {{--                            <a href="pages/examples/login.html" class="nav-link">--}}
            {{--                                <i class="far fa-circle nav-icon"></i>--}}
            {{--                                <p>Login</p>--}}
            {{--                            </a>--}}
            {{--                        </li>--}}
            {{--                        <li class="nav-item">--}}
            {{--                            <a href="pages/examples/register.html" class="nav-link">--}}
            {{--                                <i class="far fa-circle nav-icon"></i>--}}
            {{--                                <p>Register</p>--}}
            {{--                            </a>--}}
            {{--                        </li>--}}
            {{--                        <li class="nav-item">--}}
            {{--                            <a href="pages/examples/forgot-password.html" class="nav-link">--}}
            {{--                                <i class="far fa-circle nav-icon"></i>--}}
            {{--                                <p>Forgot Password</p>--}}
            {{--                            </a>--}}
            {{--                        </li>--}}
            {{--                        <li class="nav-item">--}}
            {{--                            <a href="pages/examples/recover-password.html" class="nav-link">--}}
            {{--                                <i class="far fa-circle nav-icon"></i>--}}
            {{--                                <p>Recover Password</p>--}}
            {{--                            </a>--}}
            {{--                        </li>--}}
            {{--                        <li class="nav-item">--}}
            {{--                            <a href="pages/examples/lockscreen.html" class="nav-link">--}}
            {{--                                <i class="far fa-circle nav-icon"></i>--}}
            {{--                                <p>Lockscreen</p>--}}
            {{--                            </a>--}}
            {{--                        </li>--}}
            {{--                        <li class="nav-item">--}}
            {{--                            <a href="pages/examples/legacy-user-menu.html" class="nav-link">--}}
            {{--                                <i class="far fa-circle nav-icon"></i>--}}
            {{--                                <p>Legacy User Menu</p>--}}
            {{--                            </a>--}}
            {{--                        </li>--}}
            {{--                        <li class="nav-item">--}}
            {{--                            <a href="pages/examples/language-menu.html" class="nav-link">--}}
            {{--                                <i class="far fa-circle nav-icon"></i>--}}
            {{--                                <p>Language Menu</p>--}}
            {{--                            </a>--}}
            {{--                        </li>--}}
            {{--                        <li class="nav-item">--}}
            {{--                            <a href="pages/examples/404.html" class="nav-link">--}}
            {{--                                <i class="far fa-circle nav-icon"></i>--}}
            {{--                                <p>Error 404</p>--}}
            {{--                            </a>--}}
            {{--                        </li>--}}
            {{--                        <li class="nav-item">--}}
            {{--                            <a href="pages/examples/500.html" class="nav-link">--}}
            {{--                                <i class="far fa-circle nav-icon"></i>--}}
            {{--                                <p>Error 500</p>--}}
            {{--                            </a>--}}
            {{--                        </li>--}}
            {{--                        <li class="nav-item">--}}
            {{--                            <a href="pages/examples/pace.html" class="nav-link">--}}
            {{--                                <i class="far fa-circle nav-icon"></i>--}}
            {{--                                <p>Pace</p>--}}
            {{--                            </a>--}}
            {{--                        </li>--}}
            {{--                        <li class="nav-item">--}}
            {{--                            <a href="pages/examples/blank.html" class="nav-link">--}}
            {{--                                <i class="far fa-circle nav-icon"></i>--}}
            {{--                                <p>Blank Page</p>--}}
            {{--                            </a>--}}
            {{--                        </li>--}}
            {{--                        <li class="nav-item">--}}
            {{--                            <a href="starter.html" class="nav-link">--}}
            {{--                                <i class="far fa-circle nav-icon"></i>--}}
            {{--                                <p>Starter Page</p>--}}
            {{--                            </a>--}}
            {{--                        </li>--}}
            {{--                    </ul>--}}
            {{--                </li>--}}
            {{--                <li class="nav-header">MISCELLANEOUS</li>--}}
            {{--                <li class="nav-item">--}}
            {{--                    <a href="https://adminlte.io/docs/3.0" class="nav-link">--}}
            {{--                        <i class="nav-icon fas fa-file"></i>--}}
            {{--                        <p>Documentation</p>--}}
            {{--                    </a>--}}
            {{--                </li>--}}
            {{--                <li class="nav-header">MULTI LEVEL EXAMPLE</li>--}}
            {{--                <li class="nav-item">--}}
            {{--                    <a href="#" class="nav-link">--}}
            {{--                        <i class="fas fa-circle nav-icon"></i>--}}
            {{--                        <p>Level 1</p>--}}
            {{--                    </a>--}}
            {{--                </li>--}}
            {{--                <li class="nav-item has-treeview">--}}
            {{--                    <a href="#" class="nav-link">--}}
            {{--                        <i class="nav-icon fas fa-circle"></i>--}}
            {{--                        <p>--}}
            {{--                            Level 1--}}
            {{--                            <i class="right fas fa-angle-left"></i>--}}
            {{--                        </p>--}}
            {{--                    </a>--}}
            {{--                    <ul class="nav nav-treeview">--}}
            {{--                        <li class="nav-item">--}}
            {{--                            <a href="#" class="nav-link">--}}
            {{--                                <i class="far fa-circle nav-icon"></i>--}}
            {{--                                <p>Level 2</p>--}}
            {{--                            </a>--}}
            {{--                        </li>--}}
            {{--                        <li class="nav-item has-treeview">--}}
            {{--                            <a href="#" class="nav-link">--}}
            {{--                                <i class="far fa-circle nav-icon"></i>--}}
            {{--                                <p>--}}
            {{--                                    Level 2--}}
            {{--                                    <i class="right fas fa-angle-left"></i>--}}
            {{--                                </p>--}}
            {{--                            </a>--}}
            {{--                            <ul class="nav nav-treeview">--}}
            {{--                                <li class="nav-item">--}}
            {{--                                    <a href="#" class="nav-link">--}}
            {{--                                        <i class="far fa-dot-circle nav-icon"></i>--}}
            {{--                                        <p>Level 3</p>--}}
            {{--                                    </a>--}}
            {{--                                </li>--}}
            {{--                                <li class="nav-item">--}}
            {{--                                    <a href="#" class="nav-link">--}}
            {{--                                        <i class="far fa-dot-circle nav-icon"></i>--}}
            {{--                                        <p>Level 3</p>--}}
            {{--                                    </a>--}}
            {{--                                </li>--}}
            {{--                                <li class="nav-item">--}}
            {{--                                    <a href="#" class="nav-link">--}}
            {{--                                        <i class="far fa-dot-circle nav-icon"></i>--}}
            {{--                                        <p>Level 3</p>--}}
            {{--                                    </a>--}}
            {{--                                </li>--}}
            {{--                            </ul>--}}
            {{--                        </li>--}}
            {{--                        <li class="nav-item">--}}
            {{--                            <a href="#" class="nav-link">--}}
            {{--                                <i class="far fa-circle nav-icon"></i>--}}
            {{--                                <p>Level 2</p>--}}
            {{--                            </a>--}}
            {{--                        </li>--}}
            {{--                    </ul>--}}
            {{--                </li>--}}
            {{--                <li class="nav-item">--}}
            {{--                    <a href="#" class="nav-link">--}}
            {{--                        <i class="fas fa-circle nav-icon"></i>--}}
            {{--                        <p>Level 1</p>--}}
            {{--                    </a>--}}
            {{--                </li>--}}
            {{--                <li class="nav-header">LABELS</li>--}}
            {{--                <li class="nav-item">--}}
            {{--                    <a href="#" class="nav-link">--}}
            {{--                        <i class="nav-icon far fa-circle text-danger"></i>--}}
            {{--                        <p class="text">Important</p>--}}
            {{--                    </a>--}}
            {{--                </li>--}}
            {{--                <li class="nav-item">--}}
            {{--                    <a href="#" class="nav-link">--}}
            {{--                        <i class="nav-icon far fa-circle text-warning"></i>--}}
            {{--                        <p>Warning</p>--}}
            {{--                    </a>--}}
            {{--                </li>--}}
            {{--                <li class="nav-item">--}}
            {{--                    <a href="#" class="nav-link">--}}
            {{--                        <i class="nav-icon far fa-circle text-info"></i>--}}
            {{--                        <p>Informational</p>--}}
            {{--                    </a>--}}
            {{--                </li>--}}
        </ul>
    </nav>
    <!-- /.sidebar-menu -->

@endsection
