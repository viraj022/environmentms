@section('sidebar')
    <!-- Sidebar user panel (optional) -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <!--    <div class="image">
                                <img src="/dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
                            </div>-->
        <div class="info">
            <a href="#" class="d-block">Welcome, {{ auth()->user()->first_name }}!</a>
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
                        <a href="{{ url('/dashboard2') }}" class="nav-link active">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Summery</p>
                        </a>
                    </li>
                    <!--                <li class="nav-item">
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
                                    </li>-->
                </ul>
            </li>
            <li
                class="nav-item has-treeview {{ Request::is('attachments','attachment_map','pradesheyasaba','industry_category','payment_type','payments','payment_range','zone','assistant_director','environment_officer','committee_pool')? 'menu-open': '' }}">
                <a href="#" class="nav-link active">
                    <i class="nav-icon fas fa-pencil-ruler"></i>
                    <p>
                        General Settings
                        <i class="right fas fa-angle-left"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    @foreach (auth()->user()->privileges as $indexKey => $pre)
                        @if ($pre['id'] === config('auth.privileges.attachments'))
                            <li class="nav-item">
                                <a href="{{ url('/attachments') }}"
                                    class="nav-link {{ Request::is('attachments') ? 'active' : '' }}">
                                    <i class="fas fa-file-archive nav-icon"></i>
                                    <p>Attachements</p>
                                </a>
                            </li>
                        @endif
                        @if ($pre['id'] === config('auth.privileges.attachments'))
                            <li class="nav-item">
                                <a href="{{ url('/attachment_map') }}"
                                    class="nav-link {{ Request::is('attachment_map') ? 'active' : '' }}">
                                    <i class="fas fa-paperclip nav-icon"></i>
                                    <p>Attachements Map</p>
                                </a>
                            </li>
                        @endif
                        @if ($pre['id'] === config('auth.privileges.pradesheyasaba'))
                            <li class="nav-item">
                                <a href="{{ url('/pradesheyasaba') }}"
                                    class="nav-link {{ Request::is('pradesheyasaba') ? 'active' : '' }}">
                                    <i class="fas fa-city nav-icon"></i>
                                    <p>Pradeshiya sabha</p>
                                </a>
                            </li>
                        @endif
                        @if ($pre['id'] === config('auth.privileges.industry'))
                            <li class="nav-item">
                                <a href="{{ url('/industry_category') }}"
                                    class="nav-link {{ Request::is('industry_category') ? 'active' : '' }}">
                                    <i class="fas fa-industry nav-icon"></i>
                                    <p>Industry Category</p>
                                </a>
                            </li>
                        @endif
                        @if ($pre['id'] === config('auth.privileges.industry'))
                            <li class="nav-item">
                                <a href="{{ url('/payment_type') }}"
                                    class="nav-link {{ Request::is('payment_type') ? 'active' : '' }}">
                                    <i class="fas fa-money-check-alt nav-icon"></i>
                                    <p>Payment Category</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ url('/payments') }}"
                                    class="nav-link {{ Request::is('payments') ? 'active' : '' }}">
                                    <i class="fas fa-money-bill nav-icon"></i>
                                    <p>Payments</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ url('/payment_range') }}"
                                    class="nav-link {{ Request::is('payment_range') ? 'active' : '' }}">
                                    <i class="fas fa-file-invoice-dollar nav-icon"></i>
                                    <p>Payment Range</p>
                                </a>
                            </li>
                        @endif
                        @if ($pre['id'] === config('auth.privileges.zone'))
                            <li class="nav-item">
                                <a href="{{ url('/zone') }}"
                                    class="nav-link {{ Request::is('zone') ? 'active' : '' }}">
                                    <i class="fas fa-file-archive nav-icon"></i>
                                    <p>Zone</p>
                                </a>
                            </li>
                        @endif
                        @if ($pre['id'] === config('auth.privileges.assistantDirector'))
                            <li class="nav-item">
                                <a href="{{ url('/assistant_director') }}"
                                    class="nav-link {{ Request::is('assistant_director') ? 'active' : '' }}">
                                    <i class="fas fa-user-tag nav-icon"></i>
                                    <p>Assistant Directors</p>
                                </a>
                            </li>
                        @endif

                        @if ($pre['id'] === config('auth.privileges.environmentOfficer'))
                            <li class="nav-item">
                                <a href="{{ url('/environment_officer') }}"
                                    class="nav-link {{ Request::is('environment_officer') ? 'active' : '' }}">
                                    <i class="far fa-user nav-icon"></i>
                                    <p>Environment Officer</p>
                                </a>
                            </li>
                        @endif
                        @if ($pre['id'] === config('auth.privileges.committeePool'))
                            <li class="nav-item">
                                <a href="{{ url('/committee_pool') }}"
                                    class="nav-link {{ Request::is('committee_pool') ? 'active' : '' }}">
                                    <i class="far fa-address-card nav-icon"></i>
                                    <p>Committee Pool</p>
                                </a>
                            </li>
                        @endif
                    @endforeach
                    <li class="nav-item">
                        <a href="{{ url('/letter_template') }}"
                            class="nav-link {{ Request::is('letter_template') ? 'active' : '' }}">
                            <i class="fas fa-file-archive nav-icon"></i>
                            <p>Letter Template</p>
                        </a>
                    </li>

                </ul>
            </li>
            <li
                class="nav-item has-treeview {{ Request::is('client_space', 'industry_files', 'epl_assign', 'old_file_list', 'env_officer', 'search_files')? 'menu-open': '' }}">
                <a href="#" class="nav-link active">
                    <i class="nav-icon fas fa-user-shield"></i>
                    <p>
                        Licenses
                        <i class="right fas fa-angle-left"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    @foreach (auth()->user()->privileges as $indexKey => $pre)
                        @if ($pre['id'] === config('auth.privileges.clientSpace'))
                            <li class="nav-item">
                                <a href="{{ url('/client_space') }}"
                                    class="nav-link {{ Request::is('client_space') ? 'active' : '' }}">
                                    <i class="fas fa-id-card-alt nav-icon"></i>
                                    <p>Industry Registration</p>
                                </a>
                            </li>
                        @endif
                        @if ($pre['id'] === config('auth.privileges.searchFiles'))
                            <li class="nav-item">
                                <a href="{{ url('/search_files') }}"
                                    class="nav-link {{ Request::is('search_files') ? 'active' : '' }}">
                                    <i class="fas fa-id-card-alt nav-icon"></i>
                                    <p>Search Files</p>
                                </a>
                            </li>
                        @endif
                        @if ($pre['id'] === config('auth.privileges.industryFile') && auth()->user()->roll->level->value < 4)
                            <li class="nav-item">
                            <li class="nav-item">
                                <a href="{{ url('/industry_files') }}"
                                    class="nav-link {{ Request::is('industry_files') ? 'active' : '' }}">
                                    <i class="far fa-file-alt nav-icon"></i>
                                    <p>Industry Files</p>
                                </a>
                            </li>
                        @endif
                        @if ($pre['id'] === config('auth.privileges.clientSpace'))
                            <li class="nav-item">
                                <a href="{{ url('/old_file_list') }}"
                                    class="nav-link {{ Request::is('old_file_list') ? 'active' : '' }}">
                                    <i class="fas fa-file-contract nav-icon"></i>
                                    <p>Old Files</p>
                                </a>
                            </li>
                        @endif
                        {{-- @if ($pre['id'] === config('auth.privileges.clientSpace'))
                    <li class="nav-item">
                     <a href="{{ url('/env_officer') }}" class="nav-link {{ Request::is('env_officer') ? 'active' : '' }}">
                    <i class="fas fa-user-clock nav-icon"></i>
                    <p>Pending EPL</p>
                    </a>
        </li>
        @endif --}}
                    @endforeach

                </ul>
            </li>
            <li class="nav-item has-treeview {{ Request::is('application_payment') ? 'menu-open' : '' }}">
                <a href="#" class="nav-link active">
                    <i class="nav-icon fas fa-address-card"></i>
                    <p>Application <i class="right fas fa-angle-left"></i></p>
                </a>
                <ul class="nav nav-treeview">
                    @foreach (auth()->user()->privileges as $indexKey => $pre)
                        @if ($pre['id'] === config('auth.privileges.clientSpace'))
                            <li class="nav-item">
                                <a href="{{ url('/application_payment') }}"
                                    class="nav-link {{ Request::is('application_payment') ? 'active' : '' }}">
                                    <i class="fas fa-file-signature nav-icon"></i>
                                    <p>Issue Applications</p>
                                </a>
                            </li>
                        @endif
                    @endforeach
                </ul>
            </li>
            <li class="nav-item has-treeview {{ Request::is('pending_certificates') ? 'menu-open' : '' }}">
                <a href="#" class="nav-link active">
                    <i class="nav-icon fas fa-certificate"></i>
                    <p>Certificate <i class="right fas fa-angle-left"></i></p>
                </a>
                <ul class="nav nav-treeview">
                    @foreach (auth()->user()->privileges as $indexKey => $pre)
                        @if ($pre['id'] === config('auth.privileges.clientSpace'))
                            <li class="nav-item">
                                <a href="{{ url('/pending_certificates') }}"
                                    class="nav-link {{ Request::is('pending_certificates') ? 'active' : '' }}">
                                    <i class="fas fa-certificate nav-icon"></i>
                                    <p>Pending Certificate</p>
                                </a>
                            </li>
                        @endif
                    @endforeach
                </ul>
            </li>
            <li class="nav-item has-treeview {{ Request::is('industry_files', 'schedule') ? 'menu-open' : '' }}">
                <a href="#" class="nav-link active">
                    <i class="nav-icon fas fa-chalkboard-teacher"></i>
                    <p>Environment Officer <i class="right fas fa-angle-left"></i></p>
                </a>
                <ul class="nav nav-treeview">
                    @foreach (auth()->user()->privileges as $indexKey => $pre)
                        @if ($pre['id'] === config('auth.privileges.assistantDirector'))
                            <li class="nav-item">
                                <a href="{{ url('/industry_files') }}"
                                    class="nav-link {{ Request::is('industry_files') ? 'active' : '' }}">
                                    <i class="fas fa-clock nav-icon"></i>
                                    <p>ENV Pending List</p>
                                </a>
                            </li>
                        @endif
                        @if ($pre['id'] === config('auth.privileges.clientSpace'))
                            <li class="nav-item">
                                <a href="{{ url('/schedule') }}"
                                    class="nav-link {{ Request::is('schedule') ? 'active' : '' }}">
                                    <i class="fas fa-clock nav-icon"></i>
                                    <p>Schedule</p>
                                </a>
                            </li>
                        @endif
                        @if ($pre['id'] === config('auth.privileges.industryFile') && auth()->user()->roll->level->value < 4)
                            <li class="nav-item">
                            <li class="nav-item">
                                <a href="{{ url('/industry_files') }}"
                                    class="nav-link {{ Request::is('industry_files') ? 'active' : '' }}">
                                    <i class="far fa-file-alt nav-icon"></i>
                                    <p>Industry Files</p>
                                </a>
                            </li>
                        @endif
                    @endforeach
                </ul>
            </li>
            <li class="nav-item has-treeview {{ Request::is('ad_pending_list', 'schedule', 'epl_assign') ? 'menu-open' : '' }}">
                <a href="#" class="nav-link active">
                    <i class="nav-icon fas fa-chalkboard-teacher"></i>
                    <p>Assistant Director <i class="right fas fa-angle-left"></i></p>
                </a>
                <ul class="nav nav-treeview">
                    @foreach (auth()->user()->privileges as $indexKey => $pre)
                        @if ($pre['id'] === config('auth.privileges.assistantDirector'))
                            <li class="nav-item">
                                <a href="{{ url('/ad_pending_list') }}"
                                    class="nav-link {{ Request::is('ad_pending_list') ? 'active' : '' }}">
                                    <i class="fas fa-clock nav-icon"></i>
                                    <p>AD Pending List</p>
                                </a>
                            </li>
                        @endif
                        @if ($pre['id'] === config('auth.privileges.clientSpace'))
                            <li class="nav-item">
                                <a href="{{ url('/schedule') }}"
                                    class="nav-link {{ Request::is('schedule') ? 'active' : '' }}">
                                    <i class="fas fa-clock nav-icon"></i>
                                    <p>Schedule</p>
                                </a>
                            </li>
                        @endif
                        @if ($pre['id'] === config('auth.privileges.fileAssign'))
                            <li class="nav-item">
                                <a href="{{ url('/epl_assign') }}"
                                    class="nav-link {{ Request::is('epl_assign') ? 'active' : '' }}">
                                    <i class="far fa-id-badge nav-icon"></i>
                                    <p>File Assign</p>
                                </a>
                            </li>
                        @endif
                    @endforeach
                </ul>
            </li>
            <li class="nav-item has-treeview {{ Request::is('director_pending_list', 'director_approved_list') ? 'menu-open' : '' }}">
                <a href="#" class="nav-link active">
                    <i class="nav-icon fas fa-user-tie"></i>
                    <p>Director <i class="right fas fa-angle-left"></i></p>
                </a>
                <ul class="nav nav-treeview">
                    @foreach (auth()->user()->privileges as $indexKey => $pre)
                        @if ($pre['id'] === config('auth.privileges.clientSpace'))
                            <li class="nav-item">
                                <a href="{{ url('/director_pending_list') }}"
                                    class="nav-link {{ Request::is('director_pending_list') ? 'active' : '' }}">
                                    <i class="fas fa-clock nav-icon"></i>
                                    <p>Director Pending List</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ url('/director_approved_list') }}"
                                    class="nav-link {{ Request::is('director_approved_list') ? 'active' : '' }}">
                                    <i class="fas fa-clock nav-icon"></i>
                                    <p>Director Approved List</p>
                                </a>
                            </li>
                        @endif
                    @endforeach
                </ul>
            </li>
            <li class="nav-item has-treeview {{ Request::is('eo_locations') ? 'menu-open' : '' }}">
                <a href="#" class="nav-link active">
                    <i class="nav-icon fas fa-user-tie"></i>
                    <p>Location <i class="right fas fa-angle-left"></i></p>
                </a>
                <ul class="nav nav-treeview">
                    @foreach (auth()->user()->privileges as $indexKey => $pre)
                        @if ($pre['id'] === config('auth.privileges.fileLocations'))
                            <li class="nav-item">
                                <a href="{{ url('/eo_locations') }}"
                                    class="nav-link {{ Request::is('eo_locations') ? 'active' : '' }}">
                                    <i class="fas fa-clock nav-icon"></i>
                                    <p>EO Locations</p>
                                </a>
                            </li>
                        @endif
                    @endforeach
                </ul>
            </li>
            <li
                class="nav-item has-treeview {{ Request::is('expired_certificates', 'pending_expired_cert', 'expired_epl', 'act_status/id/1','report_dashboard', 'old_data_summary', 'confirmed_files', 'reverse_confirm', 'eo_report', 'file_progress_report', 'warning_letters', 'pending_site_clear_report', 'pending_epl_report') ? 'menu-open' : '' }}">
                <a href="#" class="nav-link active">
                    <i class="nav-icon fas fa-user-tie"></i>
                    <p>Report <i class="right fas fa-angle-left"></i></p>
                </a>
                <ul class="nav nav-treeview">
                    @foreach (auth()->user()->privileges as $indexKey => $pre)
                        @if ($pre['id'] === config('auth.privileges.clientSpace'))
                            <li class="nav-item">
                                <a href="{{ url('/expired_certificates') }}"
                                    class="nav-link {{ Request::is('expired_certificates') ? 'active' : '' }}">
                                    <i class="fas fa-clock nav-icon"></i>
                                    <p>Expired certificates</p>
                                </a>
                            </li>
                        @endif
                        @if ($pre['id'] === config('auth.privileges.clientSpace'))
                            <li class="nav-item">
                                <a href="{{ url('/expired_epl') }}"
                                    class="nav-link {{ Request::is('expired_epl') ? 'active' : '' }}">
                                    <i class="fas fa-clock nav-icon"></i>
                                    <p>Expired EPL</p>
                                </a>
                            </li>
                        @endif
                        @if ($pre['id'] === config('auth.privileges.clientSpace'))
                            <li class="nav-item">
                                <a href="{{ url('/pending_expired_cert') }}"
                                    class="nav-link {{ Request::is('pending_expired_cert') ? 'active' : '' }}">
                                    <i class="fas fa-clock nav-icon"></i>
                                    <p>Pending expired list</p>
                                </a>
                            </li>
                        @endif
                        @if ($pre['id'] === config('auth.privileges.clientSpace'))
                            <li class="nav-item">
                                <a href="{{ url('/act_status/id/1') }}"
                                    class="nav-link {{ Request::is('act_status/id/1') ? 'active' : '' }}">
                                    <i class="fas fa-clock nav-icon"></i>
                                    <p>Activity Status</p>
                                </a>
                            </li>
                        @endif
                        @if ($pre['id'] === config('auth.privileges.clientSpace'))
                            <li class="nav-item">
                                <a href="{{ url('/report_dashboard') }}"
                                    class="nav-link {{ Request::is('report_dashboard') ? 'active' : '' }}">
                                    <i class="fas fa-clock nav-icon"></i>
                                    <p>Report Dashboard</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ url('/old_data_summary') }}"
                                    class="nav-link {{ Request::is('old_data_summary') ? 'active' : '' }}">
                                    <i class="fas fa-clock nav-icon"></i>
                                    <p>Old Data Summary</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ url('/confirmed_files') }}"
                                    class="nav-link {{ Request::is('confirmed_files') ? 'active' : '' }}">
                                    <i class="fas fa-clock nav-icon"></i>
                                    <p>Confirmed Files</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ url('/reverse_confirm') }}"
                                    class="nav-link {{ Request::is('reverse_confirm') ? 'active' : '' }}">
                                    <i class="fas fa-clock nav-icon"></i>
                                    <p>Revert Confirm</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ url('/eo_report') }}"
                                    class="nav-link {{ Request::is('eo_report') ? 'active' : '' }}">
                                    <i class="fas fa-clock nav-icon"></i>
                                    <p>EO Report</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ url('/file_progress_report') }}"
                                    class="nav-link {{ Request::is('file_progress_report') ? 'active' : '' }}">
                                    <i class="fas fa-clock nav-icon"></i>
                                    <p>File Progress Report</p>
                                </a>
                            </li>
                        @endif
                        @if ($pre['id'] === config('auth.privileges.clientSpace'))
                            <li class="nav-item">
                                <a href="{{ url('/warning_letters') }}"
                                    class="nav-link {{ Request::is('warning_letters') ? 'active' : '' }}">
                                    <i class="fas fa-file-archive nav-icon"></i>
                                    <p>Issue Warning Letters</p>
                                </a>
                            </li>
                        @endif
                        @if ($pre['id'] === config('auth.privileges.clientSpace'))
                            <li class="nav-item">
                                <a href="{{ url('/warning_letter_log') }}"
                                    class="nav-link {{ Request::is('warning_letter_log') ? 'active' : '' }}">
                                    <i class="fas fa-file-archive nav-icon"></i>
                                    <p>Warning Letter Log Report</p>
                                </a>
                            </li>
                        @endif
                        @if ($pre['id'] === config('auth.privileges.clientSpace'))
                            <li class="nav-item">
                                <a href="{{ url('/pending_site_clear_report') }}"
                                    class="nav-link {{ Request::is('pending_site_clear_report') ? 'active' : '' }}">
                                    <i class="fas fa-file-archive nav-icon"></i>
                                    <p>Pending Site Clearence Report</p>
                                </a>
                            </li>
                        @endif
                        @if ($pre['id'] === config('auth.privileges.clientSpace'))
                        <li class="nav-item">
                            <a href="{{ url('/pending_epl_report') }}"
                                class="nav-link {{ Request::is('pending_epl_report') ? 'active' : '' }}">
                                <i class="fas fa-file-archive nav-icon"></i>
                                <p>Pending EPL Report</p>
                            </a>
                        </li>
                        @endif
                        @if ($pre['id'] === config('auth.privileges.clientSpace'))
                        <li class="nav-item">
                            <a href="{{ url('/status_mismatch_report') }}"
                                class="nav-link {{ Request::is('status_mismatch_report') ? 'active' : '' }}">
                                <i class="fas fa-file-archive nav-icon"></i>
                                <p>Status Mismatch Report</p>
                            </a>
                        </li>
                        @endif
                        @if ($pre['id'] === config('auth.privileges.clientSpace'))
                        <li class="nav-item">
                            <a href="{{ url('/cert_missing_report') }}"
                                class="nav-link {{ Request::is('cert_missing_report') ? 'active' : '' }}">
                                <i class="fas fa-file-archive nav-icon"></i>
                                <p>Missing Certificate Report</p>
                            </a>
                        </li>
                        @endif
                    @endforeach
                </ul>
            </li>
            <li class="nav-item has-treeview {{ Request::is('users', 'rolls') ? 'menu-open' : '' }}">
                <a href="#" class="nav-link active">
                    <i class="nav-icon fas fa-user-shield"></i>
                    <p>
                        User Management
                        <i class="right fas fa-angle-left"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    @foreach (auth()->user()->privileges as $indexKey => $pre)
                        @if ($pre['id'] === config('auth.privileges.userCreate'))
                            <li class="nav-item">
                                <a href="{{ url('/users') }}"
                                    class="nav-link {{ Request::is('users') ? 'active' : '' }}">
                                    <i class="fas fa-user-plus nav-icon"></i>
                                    <p>User Create</p>
                                </a>
                            </li>
                        @endif
                        @if ($pre['id'] === config('auth.privileges.userRole'))
                            <li class="nav-item">
                                <a href="{{ url('/rolls') }}"
                                    class="nav-link {{ Request::is('rolls') ? 'active' : '' }}">
                                    <i class="fas fa-users-cog nav-icon"></i>
                                    <p>Roll Create</p>
                                </a>
                            </li>
                        @endif
                        @if ($pre['id'] === 19)
                            <li class="nav-item">
                                <a href="{{ url('/reset_count') }}"
                                    class="nav-link {{ Request::is('reset_count') ? 'active' : '' }}">
                                    <i class="fa fa-redo-alt nav-icon"></i>
                                    <p>Reset Count</p>
                                </a>
                            </li>
                        @endif
                    @endforeach
                </ul>
            </li>
            <li class="nav-item has-treeview {{ Request::is('complains') ? 'menu-open' : '' }}">
                <a href="#" class="nav-link active">
                    <i class="nav-icon fas fa-user-shield"></i>
                    <p>
                        Complains
                        <i class="right fas fa-angle-left"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="{{ url('/complains') }}"
                            class="nav-link {{ Request::is('complains') ? 'active' : '' }}">
                            <i class="fas fa-user-plus nav-icon"></i>
                            <p>Complains</p>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="nav-item has-treeview {{ Request::is('online-requests') ? 'menu-open' : '' }}">
                <a href="#" class="nav-link active">
                    <i class="nav-icon fas fa-user-shield"></i>
                    <p>
                        Online-Requests
                        <i class="right fas fa-angle-left"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="{{ url('/online-requests') }}"
                            class="nav-link {{ Request::is('online-requests') ? 'active' : '' }}">
                            <i class="fas fa-user-plus nav-icon"></i>
                            <p>List all Online Requests</p>
                        </a>
                    </li>
                </ul>
            </li>
        </ul>
    </nav>
    <!-- /.sidebar-menu -->
@endsection
