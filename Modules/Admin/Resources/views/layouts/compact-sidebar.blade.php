<style>
    .logo{
        font-size: 30px; 
        font-family: sans-serif; 
        font-weight: 700;
        padding: 0px !important;
        }
    .color{
        color: #008755;
    }
    .sidebar-dark-purple .sidebar-left {
        background-color: #008755;
        background: linear-gradient(-154deg,#008755,#005844);
    }
    .nav-text{
        display: block !important;
        margin-top: 4px;
        font-size: 14px;
    }
</style>
<?php
$navigation_list = array(
    'dashboard' => 'dashboard',
    'users' => 'users',
    'roles' => 'users',
    'auth_logs' => 'users',
    'report_logs' => 'users',
    'global_dictionary' => 'data',
    'sectors' => 'data',
    'departments' => 'data',
    'sites' => 'data',
    'events' => 'data',
    'organization_url' => 'data',
    'report_template' => 'data',
    'dataset' => 'data',
    'alert' => 'reports',
    'institution_report' => 'reports',
    'external_report' => 'reports',
    'video_report' => 'reports',
    'freeform_report' => 'reports',
    'semi_automatic' => 'reports',
    'tasks' => 'reports',
    'fully_manual' => 'reports',
    'product' => 'reports',
);

$group_nav = '';
$active_nav = '';
foreach($navigation_list as $key => $value){
    if(strpos(Route::currentRouteName(), $key) === 0){
        $group_nav = $value;
        $active_nav = $key;
        break;
    }
}
//print_r(Route::current()->parameters());
//echo $group_nav.'<br />';
//echo $active_nav.'<br />';

?>
<div class="side-content-wrap">
    <div class="sidebar-left open rtl-ps-none" data-perfect-scrollbar data-suppress-scroll-x="true">
        <ul class="navigation-left">
            @role('Manager|Analyst|Supervisor')
            <li class="nav-item {{ ($group_nav == 'dashboard') ? 'active' : '' }}" data-item="dashboard">
                <a class="nav-item-hold" href="#">
                    <em class="nav-icon fa fa-chalkboard"></em>
                    <span class="nav-text">Dashboard</span>
                </a>
                <div class="triangle"></div>
            </li>
            @endrole
            
            @can('view_users')
            <li class="nav-item {{ ($group_nav == 'users') ? 'active' : '' }}" data-item="users">
                <a class="nav-item-hold" href="#">
                    <em class="nav-icon fa fa-users"></em>
                    <span class="nav-text">Users</span>
                </a>
                <div class="triangle"></div>
            </li>
            @endcan 
            
            @can('view_tasks')
            <li class="nav-item {{ ($group_nav == 'data') ? 'active' : '' }}" data-item="data">
                <a class="nav-item-hold" href="#">
                <em class="nav-icon fas fa-server"></em>
                    <span class="nav-text">Data</span>
                </a>
                <div class="triangle"></div>
            </li>
            @endcan

            @can('view_institution_report')
            <li class="nav-item {{ ($group_nav == 'reports') ? 'active' : '' }}" data-item="reports">
                <a class="nav-item-hold" href="#">
                <em class="nav-icon fas fa-file-contract"></em>
                    <span class="nav-text">Reports</span>
                </a>
                <div class="triangle"></div>
            </li>
            @endcan
        </ul>
    </div>

    <!--secondary -->
    <div class="sidebar-left-secondary rtl-ps-none" data-perfect-scrollbar data-suppress-scroll-x="true">
        <em class="sidebar-close i-Close" (click)="toggelSidebar()"></em>
        <header>
            <div class="logo">
                <span class="color">SF</span>CA
            </div>
        </header>
        <!-- Submenu Dashboards -->
        @role('Manager|Analyst|Supervisor')
        <div class="submenu-area" data-parent="dashboard" style ="{{ ($group_nav == 'dashboard') ? 'display:block' : '' }}">
            <header>
                <h6>Dashboards</h6>
                <p>Main Dashboard Page</p>
            </header>
            <ul class="childNav" data-parent="dashboard">
                
                <li class="nav-item ">
                    <a class="{{ ($active_nav == 'dashboard') ? 'open' : '' }}" href="{{ route('dashboard.index') }}">
                        <em class="nav-icon fas fa-chalkboard"></em>
                        <span class="item-name">Dashboard</span>
                    </a>
                </li>
                
    
                <li class="nav-item ">
                    <a target="_blank" class="{{ ($active_nav == 'strategic_foresight') ? 'open' : '' }}" href="{{ url('/') }}/master">
                        <em class="nav-icon fas fa-dice-d20"></em>
                        <span class="item-name">Strategic Foresight</span>
                    </a>
                </li>

                <li class="nav-item ">
                    <a target="_blank" href="{{ route('all') }}">
                        <em class="nav-icon fas fa-book"></em>
                        <span class="item-name">Library</span>
                    </a>
                </li>

                <li class="nav-item ">
                    <a target="_blank" href="{{ route('report-overview') }}">
                        <em class="nav-icon fas fa-book"></em>
                        <span class="item-name">Report Overview</span>
                    </a>
                </li>
                
            </ul>
        </div>
        @endrole
        <div class="submenu-area" data-parent="users" style ="{{  ($group_nav == 'users') ? 'display:block' : '' }}">
            <header>
                <h6>Users </h6>
                <p>Manage User Dashboard</p>
            </header>
            <ul class="childNav" data-parent="users">
                @can('view_users')
                <li class="nav-item {{Route::currentRouteName()}}">
                    <a class="{{  ($active_nav == 'users' && Route::currentRouteName() == 'users.index') ? 'open' : '' }}" href="{{ route('users.index') }}">
                        <em class="nav-icon fa fa-user-plus"></em>
                        <span class="item-name">Users</span>
                    </a>
                </li>
                @endcan
                @can('view_roles')
                <li class="nav-item">
                    <a class="{{  ($active_nav == 'roles') ? 'open' : '' }}" href="{{ route('roles.index') }}">
                        <em class="nav-icon fas fa-user-cog"></em>
                        <span class="item-name">User Roles</span>
                    </a>
                </li>
                @endcan
                @can('view_users')
                <li class="nav-item">
                    <a class="{{ Route::currentRouteName() == 'users.deleted_users' ? 'open' : '' }}" href="{{ route('users.deleted_users') }}">
                        <em class="nav-icon fa fa-user-times"></em>
                        <span class="item-name">Deactive Users</span>
                    </a>
                </li>
                @endcan
                @role('Admin')
                <li class="nav-item">
                    <a class="{{ Route::currentRouteName() == 'auth_logs' ? 'open' : '' }}" href="{{ route('auth_logs') }}">
                        <em class="nav-icon fa fa-address-book" aria-hidden="true"></em>
                        <span class="item-name">Auth logs</span>
                    </a>
                </li>
                @endrole
                @role('Admin')
                <li class="nav-item">
                    <a class="{{ Route::currentRouteName() == 'report_logs' ? 'open' : '' }}" href="{{ route('report_logs') }}">
                        <em class="nav-icon fa fa-address-book" aria-hidden="true"></em>
                        <span class="item-name">Report logs</span>
                    </a>
                </li>
                @endrole
            </ul>
        </div>
        <div class="submenu-area" data-parent="data" style ="{{  ($group_nav == 'data') ? 'display:block' : '' }}">
            <header>
                <h6>Data</h6>
                <p>Manage Data</p>
            </header>
            <ul class="childNav" data-parent="data">
                @can('view_global_dictionary')
                <li class="nav-item">
                    <a class="{{ ($active_nav == 'global_dictionary') ? 'open' : '' }}" href="{{ route('global_dictionary.index') }}">
                        <em class="nav-icon fas fa-book"></em>
                        <span class="item-name">Global Dictionary</span>
                    </a>
                </li>
                @endcan
                @can('view_sectors')
                <li class="nav-item">
                    <a class="{{ ($active_nav == 'sectors') ? 'open' : '' }}" href="{{ route('sectors.index') }}">
                        <em class="nav-icon fas fa-columns"></em>
                        <span class="item-name">Manage Sectors</span>
                    </a>
                </li>
                @endcan
                @can('view_departments')
                <li class="nav-item">
                    <a class="{{ ($active_nav == 'departments') ? 'open' : '' }}" href="{{ route('departments.index') }}">
                        <em class="nav-icon fas fa-sliders-h"></em>
                        <span class="item-name">Manage Categories</span>
                    </a>
                </li>
                @endcan
                @can('view_sites')
                <li class="nav-item">
                    <a class="{{  (strpos(Route::currentRouteName(), 'sites') === 0) ? 'open' : '' }}" href="{{ route('sites.index') }}">
                        <em class="nav-icon fas fa-desktop"></em>
                        <span class="item-name">Manage Sites</span>
                    </a>
                </li>
                @endcan
                @can('view_events')
                <li class="nav-item">
                    <a class="{{  (strpos(Route::currentRouteName(), 'events') === 0) ? 'open' : '' }}" href="{{ route('events.index') }}">
                        <em class="nav-icon fas fa-calendar-alt"></em>
                        <span class="item-name">Manage Events</span>
                    </a>
                </li>
                @endcan
                @can('view_organization_url')
                <li class="nav-item">
                    <a class="{{  (strpos(Route::currentRouteName(), 'organization_url') === 0) ? 'open' : '' }}" href="{{ route('organization_url.index') }}">
                        <em class="nav-icon fas fa-external-link-alt"></em>
                        <span class="item-name">Manage Organization</span>
                    </a>
                </li>
                @endcan
                @can('view_report_template')
                <li class="nav-item">
                    <a class="{{  (strpos(Route::currentRouteName(), 'report_template') === 0) ? 'open' : '' }}" href="{{ route('report_template.index') }}">
                        <em class="nav-icon fas fa-file-code"></em>
                        <span class="item-name">Report Templates</span>
                    </a>
                </li>
                @endcan
            
                <x-admin::datanav :datasets="$datasets"/>
            
            </ul>
        </div>
        <div class="submenu-area" data-parent="reports" style ="{{ ($group_nav == 'reports') ? 'display:block' : '' }}">
            <header>
                <h6>Reports</h6>
                <p>Manage Reports</p>
            </header>
            <ul class="childNav" data-parent="reports">
                @can('view_alerts')
                <li class="nav-item ">
                    <a class="{{ ($active_nav == 'alert') ? 'open' : '' }}" href="{{ route('alerts.index') }}">
                        <em class="nav-icon fas fa-file-contract"></em>
                        <span class="item-name">System Alerts</span>
                    </a>
                </li>
                @endcan
                @can('view_institution_report')
                <li class="nav-item ">
                    <a class="{{ ($active_nav == 'institution_report') ? 'open' : '' }}" href="{{ route('institution_report.index') }}">
                        <em class="nav-icon fas fa-file-contract"></em>
                        <span class="item-name">Institutional Reports</span>
                    </a>
                </li>
                @endcan
                @can('view_freeform_reports')
                <li class="nav-item ">
                    <a class="{{ ($active_nav == 'freeform_report') ? 'open' : '' }}" href="{{ route('freeform_report.index') }}">
                        <em class="nav-icon fas fa-file-contract"></em>
                        <span class="item-name">Free Form Reports</span>
                    </a>
                </li>
                @endcan
                @can('view_external_reports')
                <li class="nav-item ">
                    <a class="{{ ($active_nav == 'external_report') ? 'open' : '' }}" href="{{ route('external_report.index') }}">
                        <em class="nav-icon fas fa-file-contract"></em>
                        <span class="item-name">External Reports</span>
                    </a>
                </li>
                @endcan
                @can('view_video_reports')
                <li class="nav-item ">
                    <a class="{{ ($active_nav == 'video_report') ? 'open' : '' }}" href="{{ route('video_report.index') }}">
                        <em class="nav-icon fas fa-file-contract"></em>
                        <span class="item-name">Video Reports</span>
                    </a>
                </li>
                @endcan
                @can('view_tasks')
                <li class="nav-item">
                    <a class="{{  (strpos(Route::currentRouteName(), 'tasks') === 0 or strpos(Route::currentRouteName(), 'semi_automatic' ) === 0  or strpos(Route::currentRouteName(), 'fully_manual' ) === 0 or strpos(Route::currentRouteName(), 'product' ) === 0) ? 'open' : '' }}" href="{{ route('tasks.index') }}">
                        <em class="nav-icon fas fa-external-link-alt"></em>
                        <span class="item-name">
                            @role('Manager|Admin|Supervisor')
                                Task Audit
                            @endrole
                            @role('Analyst')
                                Manage Tasks
                            @endrole
                        </span>
                    </a>
                </li>
                @endcan
            </ul>
        </div>
        
    </div>
    <div class="sidebar-overlay"></div>
</div>
<!--=============== Left side End ================-->