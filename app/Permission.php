<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Permission extends \Spatie\Permission\Models\Permission
{
    protected static $logName = "permissions_log";
    public static function defaultPermissions()
    {
        return [
            "view_users",
            "create_users",
            "edit_users",
            "delete_users",

            "view_roles",
            "create_roles",
            "edit_roles",
            "delete_roles",

            "view_global_dictionary",
            "create_global_dictionary",
            "edit_global_dictionary",
            "delete_global_dictionary",

            "view_sectors",
            "create_sectors",
            "edit_sectors",
            "delete_sectors",

            "view_departments",
            "create_departments",
            "edit_departments",
            "delete_departments",

            "view_sites",
            "create_sites",
            "edit_sites",
            "delete_sites",

            "view_events",
            "create_events",
            "edit_events",
            "delete_events",

            "view_alerts",
            "create_alerts",
            "edit_alerts",
            "delete_alerts",

            "view_organization_url",
            "create_organization_url",
            "edit_organization_url",
            "delete_organization_url",

            "view_institution_report",
            "create_institution_report",
            "edit_institution_report",
            "delete_institution_report",

            "view_tasks",
            "create_tasks",
            "edit_tasks",
            "delete_tasks",

            "view_fully_manual",
            "create_fully_manual",
            "edit_fully_manual",
            "delete_fully_manual",

            "view_semi_automatic",
            "create_semi_automatic",
            "edit_semi_automatic",
            "delete_semi_automatic",

            "view_fully_manual_gallery",
            "create_fully_manual_gallery",
            "edit_fully_manual_gallery",
            "delete_fully_manual_gallery",

            "view_semi_automatic_gallery",
            "create_semi_automatic_gallery",
            "edit_semi_automatic_gallery",
            "delete_semi_automatic_gallery",

            "view_freeform_reports",
            "create_freeform_reports",
            "edit_freeform_reports",
            "delete_freeform_reports",

            "view_alert_gallery",
            "create_alert_gallery",
            "edit_alert_gallery",
            "delete_alert_gallery",

            "view_external_reports",
            "create_external_reports",
            "edit_external_reports",
            "delete_external_reports",
            
            "view_video_reports",
            "create_video_reports",
            "edit_video_reports",
            "delete_video_reports",

            "view_report_template",
            "edit_report_template",

            "view_manager",
            "view_analyst",
        ];
    }
}
