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
            <?php if(auth()->check() && auth()->user()->hasRole('Manager|Analyst|Supervisor')): ?>
            <li class="nav-item <?php echo e(($group_nav == 'dashboard') ? 'active' : ''); ?>" data-item="dashboard">
                <a class="nav-item-hold" href="#">
                    <em class="nav-icon fa fa-chalkboard"></em>
                    <span class="nav-text">Dashboard</span>
                </a>
                <div class="triangle"></div>
            </li>
            <?php endif; ?>
            
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view_users')): ?>
            <li class="nav-item <?php echo e(($group_nav == 'users') ? 'active' : ''); ?>" data-item="users">
                <a class="nav-item-hold" href="#">
                    <em class="nav-icon fa fa-users"></em>
                    <span class="nav-text">Users</span>
                </a>
                <div class="triangle"></div>
            </li>
            <?php endif; ?> 
            
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view_tasks')): ?>
            <li class="nav-item <?php echo e(($group_nav == 'data') ? 'active' : ''); ?>" data-item="data">
                <a class="nav-item-hold" href="#">
                <em class="nav-icon fas fa-server"></em>
                    <span class="nav-text">Data</span>
                </a>
                <div class="triangle"></div>
            </li>
            <?php endif; ?>

            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view_institution_report')): ?>
            <li class="nav-item <?php echo e(($group_nav == 'reports') ? 'active' : ''); ?>" data-item="reports">
                <a class="nav-item-hold" href="#">
                <em class="nav-icon fas fa-file-contract"></em>
                    <span class="nav-text">Reports</span>
                </a>
                <div class="triangle"></div>
            </li>
            <?php endif; ?>
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
        <?php if(auth()->check() && auth()->user()->hasRole('Manager|Analyst|Supervisor')): ?>
        <div class="submenu-area" data-parent="dashboard" style ="<?php echo e(($group_nav == 'dashboard') ? 'display:block' : ''); ?>">
            <header>
                <h6>Dashboards</h6>
                <p>Main Dashboard Page</p>
            </header>
            <ul class="childNav" data-parent="dashboard">
                
                <li class="nav-item ">
                    <a class="<?php echo e(($active_nav == 'dashboard') ? 'open' : ''); ?>" href="<?php echo e(route('dashboard.index')); ?>">
                        <em class="nav-icon fas fa-chalkboard"></em>
                        <span class="item-name">Dashboard</span>
                    </a>
                </li>
                
    
                <li class="nav-item ">
                    <a target="_blank" class="<?php echo e(($active_nav == 'strategic_foresight') ? 'open' : ''); ?>" href="<?php echo e(url('/')); ?>/master">
                        <em class="nav-icon fas fa-dice-d20"></em>
                        <span class="item-name">Strategic Foresight</span>
                    </a>
                </li>

                <li class="nav-item ">
                    <a target="_blank" href="<?php echo e(route('all')); ?>">
                        <em class="nav-icon fas fa-book"></em>
                        <span class="item-name">Library</span>
                    </a>
                </li>

                <li class="nav-item ">
                    <a target="_blank" href="<?php echo e(route('report-overview')); ?>">
                        <em class="nav-icon fas fa-book"></em>
                        <span class="item-name">Report Overview</span>
                    </a>
                </li>
                
            </ul>
        </div>
        <?php endif; ?>
        <div class="submenu-area" data-parent="users" style ="<?php echo e(($group_nav == 'users') ? 'display:block' : ''); ?>">
            <header>
                <h6>Users </h6>
                <p>Manage User Dashboard</p>
            </header>
            <ul class="childNav" data-parent="users">
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view_users')): ?>
                <li class="nav-item <?php echo e(Route::currentRouteName()); ?>">
                    <a class="<?php echo e(($active_nav == 'users' && Route::currentRouteName() == 'users.index') ? 'open' : ''); ?>" href="<?php echo e(route('users.index')); ?>">
                        <em class="nav-icon fa fa-user-plus"></em>
                        <span class="item-name">Users</span>
                    </a>
                </li>
                <?php endif; ?>
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view_roles')): ?>
                <li class="nav-item">
                    <a class="<?php echo e(($active_nav == 'roles') ? 'open' : ''); ?>" href="<?php echo e(route('roles.index')); ?>">
                        <em class="nav-icon fas fa-user-cog"></em>
                        <span class="item-name">User Roles</span>
                    </a>
                </li>
                <?php endif; ?>
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view_users')): ?>
                <li class="nav-item">
                    <a class="<?php echo e(Route::currentRouteName() == 'users.deleted_users' ? 'open' : ''); ?>" href="<?php echo e(route('users.deleted_users')); ?>">
                        <em class="nav-icon fa fa-user-times"></em>
                        <span class="item-name">Deactive Users</span>
                    </a>
                </li>
                <?php endif; ?>
                <?php if(auth()->check() && auth()->user()->hasRole('Admin')): ?>
                <li class="nav-item">
                    <a class="<?php echo e(Route::currentRouteName() == 'auth_logs' ? 'open' : ''); ?>" href="<?php echo e(route('auth_logs')); ?>">
                        <em class="nav-icon fa fa-address-book" aria-hidden="true"></em>
                        <span class="item-name">Auth logs</span>
                    </a>
                </li>
                <?php endif; ?>
                <?php if(auth()->check() && auth()->user()->hasRole('Admin')): ?>
                <li class="nav-item">
                    <a class="<?php echo e(Route::currentRouteName() == 'report_logs' ? 'open' : ''); ?>" href="<?php echo e(route('report_logs')); ?>">
                        <em class="nav-icon fa fa-address-book" aria-hidden="true"></em>
                        <span class="item-name">Report logs</span>
                    </a>
                </li>
                <?php endif; ?>
            </ul>
        </div>
        <div class="submenu-area" data-parent="data" style ="<?php echo e(($group_nav == 'data') ? 'display:block' : ''); ?>">
            <header>
                <h6>Data</h6>
                <p>Manage Data</p>
            </header>
            <ul class="childNav" data-parent="data">
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view_global_dictionary')): ?>
                <li class="nav-item">
                    <a class="<?php echo e(($active_nav == 'global_dictionary') ? 'open' : ''); ?>" href="<?php echo e(route('global_dictionary.index')); ?>">
                        <em class="nav-icon fas fa-book"></em>
                        <span class="item-name">Global Dictionary</span>
                    </a>
                </li>
                <?php endif; ?>
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view_sectors')): ?>
                <li class="nav-item">
                    <a class="<?php echo e(($active_nav == 'sectors') ? 'open' : ''); ?>" href="<?php echo e(route('sectors.index')); ?>">
                        <em class="nav-icon fas fa-columns"></em>
                        <span class="item-name">Manage Sectors</span>
                    </a>
                </li>
                <?php endif; ?>
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view_departments')): ?>
                <li class="nav-item">
                    <a class="<?php echo e(($active_nav == 'departments') ? 'open' : ''); ?>" href="<?php echo e(route('departments.index')); ?>">
                        <em class="nav-icon fas fa-sliders-h"></em>
                        <span class="item-name">Manage Categories</span>
                    </a>
                </li>
                <?php endif; ?>
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view_sites')): ?>
                <li class="nav-item">
                    <a class="<?php echo e((strpos(Route::currentRouteName(), 'sites') === 0) ? 'open' : ''); ?>" href="<?php echo e(route('sites.index')); ?>">
                        <em class="nav-icon fas fa-desktop"></em>
                        <span class="item-name">Manage Sites</span>
                    </a>
                </li>
                <?php endif; ?>
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view_events')): ?>
                <li class="nav-item">
                    <a class="<?php echo e((strpos(Route::currentRouteName(), 'events') === 0) ? 'open' : ''); ?>" href="<?php echo e(route('events.index')); ?>">
                        <em class="nav-icon fas fa-calendar-alt"></em>
                        <span class="item-name">Manage Events</span>
                    </a>
                </li>
                <?php endif; ?>
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view_organization_url')): ?>
                <li class="nav-item">
                    <a class="<?php echo e((strpos(Route::currentRouteName(), 'organization_url') === 0) ? 'open' : ''); ?>" href="<?php echo e(route('organization_url.index')); ?>">
                        <em class="nav-icon fas fa-external-link-alt"></em>
                        <span class="item-name">Manage Organization</span>
                    </a>
                </li>
                <?php endif; ?>
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view_report_template')): ?>
                <li class="nav-item">
                    <a class="<?php echo e((strpos(Route::currentRouteName(), 'report_template') === 0) ? 'open' : ''); ?>" href="<?php echo e(route('report_template.index')); ?>">
                        <em class="nav-icon fas fa-file-code"></em>
                        <span class="item-name">Report Templates</span>
                    </a>
                </li>
                <?php endif; ?>
            
                 <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'admin::components.datanav','data' => ['datasets' => $datasets]]); ?>
<?php $component->withName('admin::datanav'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['datasets' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($datasets)]); ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
            
            </ul>
        </div>
        <div class="submenu-area" data-parent="reports" style ="<?php echo e(($group_nav == 'reports') ? 'display:block' : ''); ?>">
            <header>
                <h6>Reports</h6>
                <p>Manage Reports</p>
            </header>
            <ul class="childNav" data-parent="reports">
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view_alerts')): ?>
                <li class="nav-item ">
                    <a class="<?php echo e(($active_nav == 'alert') ? 'open' : ''); ?>" href="<?php echo e(route('alerts.index')); ?>">
                        <em class="nav-icon fas fa-file-contract"></em>
                        <span class="item-name">System Alerts</span>
                    </a>
                </li>
                <?php endif; ?>
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view_institution_report')): ?>
                <li class="nav-item ">
                    <a class="<?php echo e(($active_nav == 'institution_report') ? 'open' : ''); ?>" href="<?php echo e(route('institution_report.index')); ?>">
                        <em class="nav-icon fas fa-file-contract"></em>
                        <span class="item-name">Institutional Reports</span>
                    </a>
                </li>
                <?php endif; ?>
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view_freeform_reports')): ?>
                <li class="nav-item ">
                    <a class="<?php echo e(($active_nav == 'freeform_report') ? 'open' : ''); ?>" href="<?php echo e(route('freeform_report.index')); ?>">
                        <em class="nav-icon fas fa-file-contract"></em>
                        <span class="item-name">Free Form Reports</span>
                    </a>
                </li>
                <?php endif; ?>
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view_external_reports')): ?>
                <li class="nav-item ">
                    <a class="<?php echo e(($active_nav == 'external_report') ? 'open' : ''); ?>" href="<?php echo e(route('external_report.index')); ?>">
                        <em class="nav-icon fas fa-file-contract"></em>
                        <span class="item-name">External Reports</span>
                    </a>
                </li>
                <?php endif; ?>
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view_video_reports')): ?>
                <li class="nav-item ">
                    <a class="<?php echo e(($active_nav == 'video_report') ? 'open' : ''); ?>" href="<?php echo e(route('video_report.index')); ?>">
                        <em class="nav-icon fas fa-file-contract"></em>
                        <span class="item-name">Video Reports</span>
                    </a>
                </li>
                <?php endif; ?>
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view_tasks')): ?>
                <li class="nav-item">
                    <a class="<?php echo e((strpos(Route::currentRouteName(), 'tasks') === 0 or strpos(Route::currentRouteName(), 'semi_automatic' ) === 0  or strpos(Route::currentRouteName(), 'fully_manual' ) === 0 or strpos(Route::currentRouteName(), 'product' ) === 0) ? 'open' : ''); ?>" href="<?php echo e(route('tasks.index')); ?>">
                        <em class="nav-icon fas fa-external-link-alt"></em>
                        <span class="item-name">
                            <?php if(auth()->check() && auth()->user()->hasRole('Manager|Admin|Supervisor')): ?>
                                Task Audit
                            <?php endif; ?>
                            <?php if(auth()->check() && auth()->user()->hasRole('Analyst')): ?>
                                Manage Tasks
                            <?php endif; ?>
                        </span>
                    </a>
                </li>
                <?php endif; ?>
            </ul>
        </div>
        
    </div>
    <div class="sidebar-overlay"></div>
</div>
<!--=============== Left side End ================--><?php /**PATH /Volumes/Data/sfdbd_new/Modules/Admin/Resources/views/layouts/compact-sidebar.blade.php ENDPATH**/ ?>