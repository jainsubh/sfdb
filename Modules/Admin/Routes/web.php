<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::prefix('admin')->group(function () {
    Route::get('events/crawl_multiple_status', [ 'as' => 'events.crawl_multiple_status', 'uses' => 'EventsController@crawl_multiple_status']);

    //Product Report
    Route::resource('product', 'ProductController', ['names' => ['product' => 'product']] , ['as'=>'product']);
    Route::get('product/download/{filename}/{filetype?}', [ 'as' => 'product.download', 'uses' => 'ProductController@download']);
    Route::match(['put', 'patch'], 'product/complete/{id}', [ 'as' => 'product.complete', 'uses' => 'ProductController@complete']);
    Route::get('product/regenerate/{product_id}', [ 'as' => 'product.regenerate', 'uses' => 'ProductController@regenerate']);
    Route::PUT('product/unarchive/{id}', [ 'as' => 'product.unarchive', 'uses' => 'ProductController@unarchive']);
    Route::PUT('product/bulk_archive', [ 'as' => 'product.bulk_archive', 'uses' => 'ProductController@bulk_archive']);
    Route::PUT('product/bulk_delete', [ 'as' => 'product.bulk_delete', 'uses' => 'ProductController@bulk_delete']);
    Route::resource('product_gallery', 'ProductGalleryController', ['names' => ['product_gallery' => 'product_gallery']] , ['as'=>'product_gallery']);
});

Route::prefix('admin')->middleware(['auth', 'twofactor'])->group(function () {
    Route::get('/', ['as' => 'dashboard.index', 'uses' => 'DashboardController@index']);

    //Users
    Route::get('users/datatable', [ 'as' => 'users.datatable', 'uses' => 'UsersController@datatable']);
    Route::get('users/deleted_users', [ 'as' => 'users.deleted_users', 'uses' => 'UsersController@deleted_users']);
    Route::get('users/deleted_user_datatable', [ 'as' => 'users.deleted_user_datatable', 'uses' => 'UsersController@deleted_user_datatable']);
    Route::post('users/restore/{id}', [ 'as' => 'users.restore', 'uses' => 'UsersController@restore']);
    Route::resource('users', 'UsersController', ['names' => ['users' => 'users']] , ['as'=>'users']);
    Route::resource('roles', 'RoleController', ['names' => ['roles' => 'roles']] , ['as'=>'users']);

    //Data
    Route::get('global_dictionary/datatable', [ 'as' => 'global_dictionary.datatable', 'uses' => 'GlobalDictionaryController@datatable']);
    Route::resource('global_dictionary', 'GlobalDictionaryController', ['names' => ['global_dictionary' => 'global_dictionary']] , ['as'=>'data']);
    
    //Sectors
    Route::get('sectors/datatable', [ 'as' => 'sectors.datatable', 'uses' => 'SectorsController@datatable']);
    Route::get('sectors/hasData/{id}', [ 'as' => 'sectors.hasData', 'uses' => 'SectorsController@hasData']);
    Route::post('sectors/changeSector/{id}', [ 'as' => 'sectors.changeSector', 'uses' => 'SectorsController@changeSector']);
    Route::resource('sectors', 'SectorsController', ['names' => ['sectors' => 'sectors']] , ['as'=>'data']);
    

    //Departments
    Route::get('departments/datatable', [ 'as' => 'departments.datatable', 'uses' => 'DepartmentsController@datatable']);
    Route::get('departments/hasData/{id}', [ 'as' => 'departments.hasData', 'uses' => 'DepartmentsController@hasData']);
    Route::post('departments/changeDepartment/{id}', [ 'as' => 'departments.changeDepartment', 'uses' => 'DepartmentsController@changeDepartment']);
    Route::resource('departments', 'DepartmentsController', ['names' => ['departments' => 'departments']] , ['as'=>'departments']);

    //Sites
    Route::get('sites/datatable', [ 'as' => 'sites.datatable', 'uses' => 'SitesController@datatable']);
    Route::resource('sites', 'SitesController', ['names' => ['sites' => 'sites']] , ['as'=>'sites']);

    //Events
    Route::get('events/datatable', [ 'as' => 'events.datatable', 'uses' => 'EventsController@datatable']);
    Route::get('events/detail_event_info', [ 'as' => 'events.detail_event_info', 'uses' => 'EventsController@detail_event_info']);
    Route::resource('events', 'EventsController', ['names' => ['events' => 'events']] , ['as'=>'events']);
    Route::PUT('events/immediate_crawl/{id}', [ 'as' => 'events.immediate_crawl', 'uses' => 'EventsController@immediate_crawl']);
    Route::get('events/crawl_status/{id}', [ 'as' => 'events.crawl_status', 'uses' => 'EventsController@crawl_status']);

    //Organization Url
    Route::get('organization_url/datatable', [ 'as' => 'organization_url.datatable', 'uses' => 'OrganizationUrlController@datatable']);
    Route::resource('organization_url', 'OrganizationUrlController', ['names' => ['organization_url' => 'organization_url']] , ['as'=>'organization_url']);

    //Report Template
    Route::get('report_template/datatable', [ 'as' => 'report_template.datatable', 'uses' => 'ReportTemplateController@datatable']);
    Route::resource('report_template', 'ReportTemplateController', ['names' => ['report_template' => 'report_template']] , ['as'=>'report_template']);

    //Semi Automatic Report
    Route::match(['put', 'patch'], 'semi_automatic/complete/{id}', [ 'as' => 'semi_automatic.complete', 'uses' => 'SemiAutomaticController@complete']);
    Route::get('semi_automatic/create/task/{task_id}', [ 'as' => 'semi_automatic.create', 'uses' => 'SemiAutomaticController@create']);
    Route::get('semi_automatic/regenerate/{freeform_id}', [ 'as' => 'semi_automatic.regenerate', 'uses' => 'SemiAutomaticController@regenerate']);
    Route::get('semi_automatic/download/{filename}/{filetype?}', [ 'as' => 'semi_automatic.download', 'uses' => 'SemiAutomaticController@download']);
    Route::PUT('semi_automatic_report/unarchive/{id}', [ 'as' => 'semi_automatic_report.unarchive', 'uses' => 'SemiAutomaticController@unarchive']);
    Route::PUT('semi_automatic_report/bulk_archive', [ 'as' => 'semi_automatic_report.bulk_archive', 'uses' => 'SemiAutomaticController@bulk_archive']);
    Route::PUT('semi_automatic_report/bulk_delete', [ 'as' => 'semi_automatic_report.bulk_delete', 'uses' => 'SemiAutomaticController@bulk_delete']);
    Route::resource('semi_automatic', 'SemiAutomaticController', ['names' => ['semi_automatic' => 'semi_automatic']] , ['as'=>'semi_automatic']);
    Route::POST('semi_automatic/fileUpload', [ 'as' => 'semi_automatic.fileUpload', 'uses' => 'SemiAutomaticController@fileUpload']);
    Route::resource('semi_automatic_gallery', 'SemiAutomaticGalleryController', ['names' => ['semi_automatic_gallery' => 'semi_automatic_gallery']] , ['as'=>'fully_manual_gallery']);

    //Fully Manual Report
    Route::get('fully_manual/download/{filename}/{filetype?}', [ 'as' => 'fully_manual.download', 'uses' => 'FullyManualController@download']);
    Route::match(['put', 'patch'], 'fully_manual/complete/{id}', [ 'as' => 'fully_manual.complete', 'uses' => 'FullyManualController@complete']);
    Route::get('fully_manual/download/{filename}/{filetype?}', [ 'as' => 'fully_manual.download', 'uses' => 'FullyManualController@download']);
    Route::get('fully_manual/regenerate/{freeform_id}', [ 'as' => 'fully_manual.regenerate', 'uses' => 'FullyManualController@regenerate']);
    Route::PUT('fully_manual/unarchive/{id}', [ 'as' => 'fully_manual.unarchive', 'uses' => 'FullyManualController@unarchive']);
    Route::PUT('fully_manual/bulk_archive', [ 'as' => 'fully_manual.bulk_archive', 'uses' => 'FullyManualController@bulk_archive']);
    Route::PUT('fully_manual/bulk_delete', [ 'as' => 'fully_manual.bulk_delete', 'uses' => 'FullyManualController@bulk_delete']);
    Route::resource('fully_manual', 'FullyManualController', ['names' => ['fully_manual' => 'fully_manual']] , ['as'=>'fully_manual']);
    Route::resource('fully_manual_gallery', 'FullyManualGalleryController', ['names' => ['fully_manual_gallery' => 'fully_manual_gallery']] , ['as'=>'fully_manual_gallery']);


    //Institutional Report
    Route::get('institution_report/datatable', [ 'as' => 'institution_report.datatable', 'uses' => 'InstitutionReportController@datatable']);
    Route::get('institution_report/latest_institution_report', [ 'as' => 'institution_report.latest_institution_report', 'uses' => 'InstitutionReportController@latest_institution_report']);
    Route::get('institution_report/paginate_institution_report', [ 'as' => 'institution_report.paginate_institution_report', 'uses' => 'InstitutionReportController@paginate_institution_report']);
    Route::get('institution_report/download/{filename}/{filetype?}', [ 'as' => 'institution_report.download', 'uses' => 'InstitutionReportController@download']);
    Route::PUT('institution_report/move_to_library/{id}', [ 'as' => 'institution_report.move_to_library', 'uses' => 'InstitutionReportController@move_to_library']);
    Route::PUT('institution_report/archive/{id}', [ 'as' => 'institution_report.archive', 'uses' => 'InstitutionReportController@archive']);
    Route::PUT('institution_report/bulk_archive', [ 'as' => 'institution_report.bulk_archive', 'uses' => 'InstitutionReportController@bulk_archive']);
    Route::PUT('institution_report/bulk_delete', [ 'as' => 'institution_report.bulk_delete', 'uses' => 'InstitutionReportController@bulk_delete']);
    Route::PUT('institution_report/unarchive/{id}', [ 'as' => 'institution_report.unarchive', 'uses' => 'InstitutionReportController@unarchive']);
    Route::resource('institution_report', 'InstitutionReportController', ['names' => ['institution_report' => 'institution_report']] , ['as'=>'institution_report']);
  
    //External Reports
    Route::get('external_report/datatable', [ 'as' => 'external_report.datatable', 'uses' => 'ExternalReportController@datatable']);
    Route::PUT('external_report/bulk_archive', [ 'as' => 'external_report.bulk_archive', 'uses' => 'ExternalReportController@bulk_archive']);
    Route::PUT('external_report/bulk_delete', [ 'as' => 'external_report.bulk_delete', 'uses' => 'ExternalReportController@bulk_delete']);
    Route::PUT('external_report/unarchive/{id}', [ 'as' => 'external_report.unarchive', 'uses' => 'ExternalReportController@unarchive']);
    Route::get('external_report/download/{filename}/{filetype?}', [ 'as' => 'external_report.download', 'uses' => 'ExternalReportController@download']);
    Route::resource('external_report', 'ExternalReportController', ['names' => ['external_report' => 'external_report']] , ['as'=>'external_report']);

    //Scenario Report
    Route::PUT('scenario_report/bulk_archive', [ 'as' => 'scenario_report.bulk_archive', 'uses' => 'ExternalReportController@bulk_archive']);
    Route::PUT('scenario_report/bulk_delete', [ 'as' => 'scenario_report.bulk_delete', 'uses' => 'ExternalReportController@bulk_delete']);
    Route::PUT('scenario_report/unarchive/{id}', [ 'as' => 'scenario_report.unarchive', 'uses' => 'ExternalReportController@unarchive']);

    //Video Reports
    Route::get('video_report/datatable', [ 'as' => 'video_report.datatable', 'uses' => 'VideoReportController@datatable']);
    Route::PUT('video_report/bulk_archive', [ 'as' => 'video_report.bulk_archive', 'uses' => 'VideoReportController@bulk_archive']);
    Route::PUT('video_report/bulk_delete', [ 'as' => 'video_report.bulk_delete', 'uses' => 'VideoReportController@bulk_delete']);
    Route::PUT('video_report/unarchive/{id}', [ 'as' => 'video_report.unarchive', 'uses' => 'VideoReportController@unarchive']);
    Route::get('video_report/download/{filename}/{filetype?}', [ 'as' => 'video_report.download', 'uses' => 'VideoReportController@download']);
    Route::resource('video_report', 'VideoReportController', ['names' => ['video_report' => 'video_report']] , ['as'=>'video_rneport']);
  
    //FreeForm Report
    Route::match(['put', 'patch'], 'freeform_report/complete/{id}', [ 'as' => 'freeform_report.complete', 'uses' => 'FreeFormReportController@complete']);
    Route::get('freeform_report/datatable', [ 'as' => 'freeform_report.datatable', 'uses' => 'FreeFormReportController@datatable']);
    Route::get('freeform_report/report_create/{freeform_id}', [ 'as' => 'freeform_report.report_create', 'uses' => 'FreeFormReportController@report_create']);
    Route::get('freeform_report/report_preview/{freeform_id}', [ 'as' => 'freeform_report.report_preview', 'uses' => 'FreeFormReportController@report_preview']);
    Route::get('freeform_report/regenerate/{freeform_id}', [ 'as' => 'freeform_report.regenerate', 'uses' => 'FreeFormReportController@regenerate']);
    Route::get('freeform_report/download/{filename}/{filetype?}', [ 'as' => 'freeform_report.download', 'uses' => 'FreeFormReportController@download']);
    Route::get('freeform_report/view_document/{filename}/{filetype?}', [ 'as' => 'freeform_report.view_document', 'uses' => 'FreeFormReportController@view_document']);
    Route::PUT('freeform_report/move_to_library/{id}', [ 'as' => 'freeform_report.move_to_library', 'uses' => 'FreeFormReportController@move_to_library']);
    Route::PUT('freeform_report/archive/{id}', [ 'as' => 'freeform_report.archive', 'uses' => 'FreeFormReportController@archive']);
    Route::PUT('freeform_report/bulk_archive', [ 'as' => 'freeform_report.bulk_archive', 'uses' => 'FreeFormReportController@bulk_archive']);
    Route::PUT('freeform_report/bulk_delete', [ 'as' => 'freeform_report.bulk_delete', 'uses' => 'FreeFormReportController@bulk_delete']);
    Route::PUT('freeform_report/unarchive/{id}', [ 'as' => 'freeform_report.unarchive', 'uses' => 'FreeFormReportController@unarchive']);
    Route::POST('freeform_report/fileUpload', [ 'as' => 'freeform_report.fileUpload', 'uses' => 'FreeFormReportController@fileUpload']);
    Route::resource('freeform_report', 'FreeFormReportController', ['names' => ['freeform_report' => 'freeform_report']] , ['as'=>'freeform_report']);

    Route::match(['put', 'patch'], 'alerts/complete/{id}', [ 'as' => 'alerts.complete', 'uses' => 'AlertController@complete']);
    Route::get('alerts/datatable', [ 'as' => 'alerts.datatable', 'uses' => 'AlertController@datatable']);
    Route::get('alerts/show_alert_template/{alert_id}', [ 'as' => 'alerts.automatic_template', 'uses' => 'AlertController@automatic_template']);
    Route::resource('alerts', 'AlertController', ['names' => ['alerts' => 'alerts']], ['as' => 'alerts']);
    Route::resource('alert_gallery', 'AlertGalleryController', ['names' => ['alert_gallery' => 'alert_gallery']] , ['as'=>'alert_gallery']);
    
    //Task Controllers
    Route::match(['put', 'patch'], 'tasks/reopen/{id}', [ 'as' => 'tasks.reopen', 'uses' => 'TasksController@reopen']);
    Route::match(['put', 'patch'], 'tasks/complete/{id}', [ 'as' => 'tasks.complete', 'uses' => 'TasksController@complete']);

    //Activity Auth Logs
    Route::get('auth_logs', [ 'as' => 'auth_logs', 'uses' => 'ActivityController@auth_logs']);
    Route::get('report_logs', [ 'as' => 'report_logs', 'uses' => 'ActivityController@report_logs']);
    Route::get('report_log_datatable', [ 'as' => 'report_log_datatable', 'uses' => 'ActivityController@report_log_datatable']);
    Route::get('auth_log_datatable', [ 'as' => 'auth_log_datatable', 'uses' => 'ActivityController@auth_log_datatable']);

    Route::get('dataset/datatable/{id}', [ 'as' => 'dataset.datatable', 'uses' => 'DatasetController@datatable']);
    Route::resource('dataset', 'DatasetController', ['names' => ['dataset' => 'dataset']] , ['as'=>'dataset']);

    Route::get('data/datatable/{dataset_id}', [ 'as' => 'data.datatable', 'uses' => 'DataController@datatable']);
    Route::get('data/create', [ 'as' => 'data.create', 'uses' => 'DataController@create']);
    Route::resource('data', 'DataController', ['names' => ['data' => 'data']] , ['as'=>'data']);
});

Route::middleware(['auth', 'twofactor'])->group(function () {
    //Report Overview
    Route::get('report-overview/all', array('as' => 'report-overview', 'uses' => 'ReportOverviewController@all'));
    Route::get('report-overview/report_detail/{type?}/{id?}', array('as' => 'report-detail', 'uses' => 'ReportOverviewController@report_detail'));

    //library
    Route::get('library', array('as' => 'all', 'uses' => 'LibraryController@all'));
    Route::get('library/institution_report', array('as' => 'institution_report', 'uses' => 'LibraryController@institution_report'));
    Route::get('library/freeform_report', array('as' => 'freeform_report', 'uses' => 'LibraryController@freeform_report'));
    Route::get('library/external_report', array('as' => 'external_report', 'uses' => 'LibraryController@external_report'));
    Route::get('library/scenario_report', array('as' => 'scenario_report', 'uses' => 'LibraryController@scenario_report'));
    Route::get('library/video_report', array('as' => 'video_report', 'uses' => 'LibraryController@video_report'));
    Route::get('library/semi_automatic_report', array('as' => 'semi_automatic_report', 'uses' => 'LibraryController@semi_automatic_report'));
    Route::get('library/fully_manual', array('as' => 'fully_manual', 'uses' => 'LibraryController@fully_manual'));
    Route::get('library/alerts', array('as' => 'alerts', 'uses' => 'LibraryController@system_generated_report'));
    Route::get('library/archived', array('as' => 'archived', 'uses' => 'LibraryController@archived'));
    Route::PUT('library/all/bulk_archive', array('as' => 'all.bulk_archive', 'uses' => 'LibraryController@bulk_archive'));
    Route::PUT('library/bulk_unarchive', array('as' => 'library.bulk_unarchive', 'uses' => 'LibraryController@bulk_unarchive'));
    Route::PUT('library/all/bulk_delete', array('as' => 'all.bulk_delete', 'uses' => 'LibraryController@bulk_delete'));
    Route::get('library/all', array('as' => 'all', 'uses' => 'LibraryController@all'));
    Route::get('library/download_zip', [ 'as' => 'library.download_zip', 'uses' => 'LibraryController@download_zip']);
    Route::POST('library/bulk_download/{type?}', [ 'as' => 'library.bulk_download', 'uses' => 'LibraryController@bulk_download']);
    //manager
    Route::get('manager', 'ManagerController@index')->name('manager.index');
    Route::get('manager/assignTo', 'ManagerController@assignTo')->name('manager.assignTo');
    Route::post('manager/view_as_analyst', 'ManagerController@view_as_analyst')->name('manager.view_as_analyst');
    Route::get('manager/download/{filename}', 'ManagerController@download')->name('manager.download');

    Route::get('google_search', 'GoogleSearchController@index')->name('google_search.index');
    Route::get('google_search/search_result', 'GoogleSearchController@search_result')->name('google_search.search_result');

    //Translation Page
    Route::post('translation/translate', 'TranslationController@translate');
    Route::get('translation', 'TranslationController@index')->name('translate.index');

    //Event-Alert
    Route::get('alerts/knowledgeMap/{id}', [ 'as' => 'alerts.knowledgeMap', 'uses' => 'AlertController@knowledgeMap']);
    Route::post('alerts/comment', [ 'as' => 'alerts.comment', 'uses' => 'AlertController@comment']);
    Route::get('alerts/download/{filename}/{filetype?}', [ 'as' => 'alerts.download', 'uses' => 'AlertController@download']);
    Route::get('alerts/latest_alert', [ 'as' => 'alerts.latest_alert', 'uses' => 'AlertController@latest_alert']);
    Route::get('alerts/event_alert', [ 'as' => 'alerts.event_alert', 'uses' => 'AlertController@event_alert']);
    Route::get('alerts/paginate_alert', [ 'as' => 'alerts.paginate_alert', 'uses' => 'AlertController@paginate_alert']);
    Route::put('alerts/bulk_archive', [ 'as' => 'alerts.bulk_archive', 'uses' => 'AlertController@bulk_archive']);
    Route::put('alerts/bulk_delete', [ 'as' => 'alerts.bulk_delete', 'uses' => 'AlertController@bulk_delete']);
    Route::resource('alerts', 'AlertController', ['names' => ['alerts' => 'alerts']], ['as' => 'alerts']);
    Route::put('alerts/archive/{id}', [ 'as' => 'alerts.archive', 'uses' => 'AlertController@archive']);
    Route::get('alerts/countries/{id}', [ 'as' => 'alerts.countries', 'uses' => 'AlertController@countries']);
    Route::put('alerts/unarchive/{id}', [ 'as' => 'alerts.unarchive', 'uses' => 'AlertController@unarchive']);
    Route::get('alerts/comment', [ 'as' => 'alerts.comment', 'uses' => 'AlertController@archive']);

    //Latest Events
    Route::get('events/latest_events', [ 'as' => 'events.latest_events', 'uses' => 'EventsController@latest_events']);
  
    //analyst
    Route::get('analyst', 'AnalystController@index')->name('analyst.index');
    Route::get('analyst/download/{filename}', 'AnalystController@download')->name('analyst.download');

    //master
    Route::get('/master', 'MasterController@index');
    Route::get('/master/map', 'MasterController@get_mapvalues');
    Route::get('master/alert_keyword', 'MasterController@alert_keyword');

    //tasks
    Route::post('tasks/transfer', ['as' => 'tasks.transfer', 'uses' => 'TasksController@transfer']);
    Route::get('tasks/datatable', [ 'as' => 'tasks.datatable', 'uses' => 'TasksController@datatable']);
    Route::get('tasks/latest_inprogress', [ 'as' => 'tasks.latest_inprogress', 'uses' => 'TasksController@latest_inprogress']);
    Route::get('tasks/latest_transfer_request', [ 'as' => 'tasks.latest_transfer_request', 'uses' => 'TasksController@latest_transfer_request']);
    Route::get('tasks/latest_team_report', [ 'as' => 'tasks.latest_team_report', 'uses' => 'TasksController@latest_team_report']);
    Route::resource('tasks', 'TasksController', ['names' => ['tasks' => 'tasks']], ['as' => 'tasks']);
    
    Route::get('latest_activities', [ 'as' => 'latest_activities', 'uses' => 'ActivityController@latest_activities']);
    
});