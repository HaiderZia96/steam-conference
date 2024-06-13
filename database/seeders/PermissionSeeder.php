<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
//            ---------------------- admin Permissions Start------------------------
            ['name' => 'admin_user-management_module-list', 'group_id' => 1, 'module_id' => 1],
            ['name' => 'admin_user-management_module-create', 'group_id' => 1, 'module_id' => 1],
            ['name' => 'admin_user-management_module-show', 'group_id' => 1, 'module_id' => 1],
            ['name' => 'admin_user-management_module-edit', 'group_id' => 1, 'module_id' => 1],
            ['name' => 'admin_user-management_module-delete', 'group_id' => 1, 'module_id' => 1],
            ['name' => 'admin_user-management_module-activity-log', 'group_id' => 1, 'module_id' => 1],
            ['name' => 'admin_user-management_module-activity-log-trash', 'group_id' => 1, 'module_id' => 1],
            ['name' => 'admin_user-management_permission-group-list', 'group_id' => 1, 'module_id' => 1],
            ['name' => 'admin_user-management_permission-group-create', 'group_id' => 1, 'module_id' => 1],
            ['name' => 'admin_user-management_permission-group-show', 'group_id' => 1, 'module_id' => 1],
            ['name' => 'admin_user-management_permission-group-edit', 'group_id' => 1, 'module_id' => 1],
            ['name' => 'admin_user-management_permission-group-activity-log', 'group_id' => 1, 'module_id' => 1],
            ['name' => 'admin_user-management_permission-group-activity-log-trash', 'group_id' => 1, 'module_id' => 1],
            ['name' => 'admin_user-management_permission-group-delete', 'group_id' => 1, 'module_id' => 1],
            ['name' => 'admin_user-management_permission-list', 'group_id' => 1, 'module_id' => 1],
            ['name' => 'admin_user-management_permission-create', 'group_id' => 1, 'module_id' => 1],
            ['name' => 'admin_user-management_permission-show', 'group_id' => 1, 'module_id' => 1],
            ['name' => 'admin_user-management_permission-edit', 'group_id' => 1, 'module_id' => 1],
            ['name' => 'admin_user-management_permission-delete', 'group_id' => 1, 'module_id' => 1],
            ['name' => 'admin_user-management_role-list', 'group_id' => 1, 'module_id' => 1],
            ['name' => 'admin_user-management_role-create', 'group_id' => 1, 'module_id' => 1],
            ['name' => 'admin_user-management_role-show', 'group_id' => 1, 'module_id' => 1],
            ['name' => 'admin_user-management_role-edit', 'group_id' => 1, 'module_id' => 1],
            ['name' => 'admin_user-management_role-delete', 'group_id' => 1, 'module_id' => 1],
            ['name' => 'admin_user-management_user-list', 'group_id' => 1, 'module_id' => 1],
            ['name' => 'admin_user-management_user-create', 'group_id' => 1, 'module_id' => 1],
            ['name' => 'admin_user-management_user-show', 'group_id' => 1, 'module_id' => 1],
            ['name' => 'admin_user-management_user-edit', 'group_id' => 1, 'module_id' => 1],
            ['name' => 'admin_user-management_user-activity-log', 'group_id' => 1, 'module_id' => 1],
            ['name' => 'admin_user-management_user-activity-log-trash', 'group_id' => 1, 'module_id' => 1],
            ['name' => 'admin_user-management_user-delete', 'group_id' => 1, 'module_id' => 1],
            ['name' => 'admin_user-management_backup-list', 'group_id' => 2, 'module_id' => 1],
            ['name' => 'admin_user-management_backup-create', 'group_id' => 2, 'module_id' => 1],
            ['name' => 'admin_user-management_backup-download', 'group_id' => 2, 'module_id' => 1],
            ['name' => 'admin_user-management_backup-delete', 'group_id' => 2, 'module_id' => 1],
            ['name' => 'admin_user-management_log-dashboard', 'group_id' => 2, 'module_id' => 1],
            ['name' => 'admin_user-management_log-list', 'group_id' => 2, 'module_id' => 1],
            ['name' => 'admin_user-management_log-show', 'group_id' => 2, 'module_id' => 1],
            ['name' => 'admin_user-management_log-download', 'group_id' => 2, 'module_id' => 1],
            ['name' => 'admin_user-management_log-delete', 'group_id' => 2, 'module_id' => 1],
//            ---------------------- admin Permissions End------------------------

//            ---------------------- Manager Permissions Start------------------------
//            conference-year permission
            ['name' => 'manager_master-data_conference-year-list', 'group_id' => 3, 'module_id' => 2],
            ['name' => 'manager_master-data_conference-year-edit', 'group_id' => 3, 'module_id' => 2],
            ['name' => 'manager_master-data_conference-year-status-update', 'group_id' => 3, 'module_id' => 2],
            ['name' => 'manager_master-data_conference-year-status-edit', 'group_id' => 3, 'module_id' => 2],
            ['name' => 'manager_master-data_conference-year-create', 'group_id' => 3, 'module_id' => 2],
            ['name' => 'manager_master-data_conference-year-show', 'group_id' => 3, 'module_id' => 2],
            ['name' => 'manager_master-data_conference-year-delete', 'group_id' => 3, 'module_id' => 2],
            ['name' => 'manager_master-data_conference-year-activity-log-trash', 'group_id' => 3, 'module_id' => 2],
            ['name' => 'manager_master-data_conference-year-activity-log', 'group_id' => 3, 'module_id' => 2],
//            registration-type permission
            ['name' => 'manager_master-data_registration-type-list', 'group_id' => 3, 'module_id' => 2],
            ['name' => 'manager_master-data_registration-type-edit', 'group_id' => 3, 'module_id' => 2],
            ['name' => 'manager_master-data_registration-type-show', 'group_id' => 3, 'module_id' => 2],
            ['name' => 'manager_master-data_registration-type-create', 'group_id' => 3, 'module_id' => 2],
            ['name' => 'manager_master-data_registration-type-delete', 'group_id' => 3, 'module_id' => 2],
            ['name' => 'manager_master-data_registration-type-activity-log-trash', 'group_id' => 3, 'module_id' => 2],
            ['name' => 'manager_master-data_registration-type-activity-log', 'group_id' => 3, 'module_id' => 2],
//            payment-type permission
            ['name' => 'manager_master-data_payment-type-list', 'group_id' => 3, 'module_id' => 2],
            ['name' => 'manager_master-data_payment-type-edit', 'group_id' => 3, 'module_id' => 2],
            ['name' => 'manager_master-data_payment-type-show', 'group_id' => 3, 'module_id' => 2],
            ['name' => 'manager_master-data_payment-type-create', 'group_id' => 3, 'module_id' => 2],
            ['name' => 'manager_master-data_payment-type-delete', 'group_id' => 3, 'module_id' => 2],
            ['name' => 'manager_master-data_payment-type-activity-log-trash', 'group_id' => 3, 'module_id' => 2],
            ['name' => 'manager_master-data_payment-type-activity-log', 'group_id' => 3, 'module_id' => 2],
//            status-type permission
            ['name' => 'manager_master-data_status-type-list', 'group_id' => 3, 'module_id' => 2],
            ['name' => 'manager_master-data_status-type-edit', 'group_id' => 3, 'module_id' => 2],
            ['name' => 'manager_master-data_status-type-status-edit', 'group_id' => 3, 'module_id' => 2],
            ['name' => 'manager_master-data_certificate-status-edit', 'group_id' => 3, 'module_id' => 2],
            ['name' => 'manager_master-data_status-type-show', 'group_id' => 3, 'module_id' => 2],
            ['name' => 'manager_master-data_status-type-create', 'group_id' => 3, 'module_id' => 2],
            ['name' => 'manager_master-data_status-type-delete', 'group_id' => 3, 'module_id' => 2],
            ['name' => 'manager_master-data_status-type-activity-log-trash', 'group_id' => 3, 'module_id' => 2],
            ['name' => 'manager_master-data_status-type-activity-log', 'group_id' => 3, 'module_id' => 2],
//            faculty permission
            ['name' => 'manager_master-data_faculty-list', 'group_id' => 3, 'module_id' => 2],
            ['name' => 'manager_master-data_faculty-edit', 'group_id' => 3, 'module_id' => 2],
            ['name' => 'manager_master-data_faculty-show', 'group_id' => 3, 'module_id' => 2],
            ['name' => 'manager_master-data_faculty-create', 'group_id' => 3, 'module_id' => 2],
            ['name' => 'manager_master-data_faculty-delete', 'group_id' => 3, 'module_id' => 2],
            ['name' => 'manager_master-data_faculty-activity-log-trash', 'group_id' => 3, 'module_id' => 2],
            ['name' => 'manager_master-data_faculty-activity-log', 'group_id' => 3, 'module_id' => 2],
//            department permission
            ['name' => 'manager_master-data_department-list', 'group_id' => 3, 'module_id' => 2],
            ['name' => 'manager_master-data_department-edit', 'group_id' => 3, 'module_id' => 2],
            ['name' => 'manager_master-data_department-show', 'group_id' => 3, 'module_id' => 2],
            ['name' => 'manager_master-data_department-create', 'group_id' => 3, 'module_id' => 2],
            ['name' => 'manager_master-data_department-delete', 'group_id' => 3, 'module_id' => 2],
            ['name' => 'manager_master-data_department-activity-log-trash', 'group_id' => 3, 'module_id' => 2],
            ['name' => 'manager_master-data_department-activity-log', 'group_id' => 3, 'module_id' => 2],
//            user-registration permission
            ['name' => 'manager_registration_user-registration-list', 'group_id' => 4, 'module_id' => 2],
            ['name' => 'manager_registration_user-registration-edit', 'group_id' => 4, 'module_id' => 2],
            ['name' => 'manager_registration_user-registration-show', 'group_id' => 4, 'module_id' => 2],
            ['name' => 'manager_registration_user-registration-create', 'group_id' => 4, 'module_id' => 2],
            ['name' => 'manager_registration_user-registration-delete', 'group_id' => 4, 'module_id' => 2],
            ['name' => 'manager_registration_user-registration-activity-log-trash', 'group_id' => 4, 'module_id' => 2],
            ['name' => 'manager_registration_user-registration-activity-log', 'group_id' => 4, 'module_id' => 2],
            ['name' => 'manager_registration_user-registration-voucher-download', 'group_id' => 4, 'module_id' => 2],
            ['name' => 'manager_registration_user-registration-voucher-upload', 'group_id' => 4, 'module_id' => 2],
            ['name' => 'manager_registration_user-registration-voucher-view', 'group_id' => 4, 'module_id' => 2],
            ['name' => 'manager_registration_user-registration-gate-pass-download', 'group_id' => 4, 'module_id' => 2],

//            paper-submission permission
            ['name' => 'manager_registration_paper-submission-list', 'group_id' => 4, 'module_id' => 2],
            ['name' => 'manager_registration_paper-submission-edit', 'group_id' => 4, 'module_id' => 2],
            ['name' => 'manager_registration_paper-submission-status-edit', 'group_id' => 3, 'module_id' => 2],
            ['name' => 'manager_registration_paper-submission-show', 'group_id' => 4, 'module_id' => 2],
            ['name' => 'manager_registration_paper-submission-create', 'group_id' => 4, 'module_id' => 2],
            ['name' => 'manager_registration_paper-submission-delete', 'group_id' => 4, 'module_id' => 2],
            ['name' => 'manager_registration_paper-submission-activity-log-trash', 'group_id' => 4, 'module_id' => 2],
            ['name' => 'manager_registration_paper-submission-activity-log', 'group_id' => 4, 'module_id' => 2],

//            publication-type permissions
            ['name' => 'manager_steam-publication_publication-type-list', 'group_id' => 5, 'module_id' => 2],
            ['name' => 'manager_steam-publication_publication-type-edit', 'group_id' => 5, 'module_id' => 2],
            ['name' => 'manager_steam-publication_publication-type-show', 'group_id' => 5, 'module_id' => 2],
            ['name' => 'manager_steam-publication_publication-type-create', 'group_id' => 5, 'module_id' => 2],
            ['name' => 'manager_steam-publication_publication-type-delete', 'group_id' => 5, 'module_id' => 2],
            ['name' => 'manager_steam-publication_publication-type-activity-log', 'group_id' => 5, 'module_id' => 2],
            ['name' => 'manager_steam-publication_publication-type-activity-log-trash', 'group_id' => 5, 'module_id' => 2],

//            publication permissions
            ['name' => 'manager_steam-publication_publication-list', 'group_id' => 5, 'module_id' => 2],
            ['name' => 'manager_steam-publication_publication-edit', 'group_id' => 5, 'module_id' => 2],
            ['name' => 'manager_steam-publication_publication-show', 'group_id' => 5, 'module_id' => 2],
            ['name' => 'manager_steam-publication_publication-download', 'group_id' => 5, 'module_id' => 2],
            ['name' => 'manager_steam-publication_publication-create', 'group_id' => 5, 'module_id' => 2],
            ['name' => 'manager_steam-publication_publication-delete', 'group_id' => 5, 'module_id' => 2],
            ['name' => 'manager_steam-publication_publication-activity-log', 'group_id' => 5, 'module_id' => 2],
            ['name' => 'manager_steam-publication_publication-activity-log-trash', 'group_id' => 5, 'module_id' => 2],

//            glimpse-category permissions
            ['name' => 'manager_glimpse_glimpse-category-list', 'group_id' => 6, 'module_id' => 2],
            ['name' => 'manager_glimpse_glimpse-category-edit', 'group_id' => 6, 'module_id' => 2],
            ['name' => 'manager_glimpse_glimpse-category-show', 'group_id' => 6, 'module_id' => 2],
            ['name' => 'manager_glimpse_glimpse-category-create', 'group_id' => 6, 'module_id' => 2],
            ['name' => 'manager_glimpse_glimpse-category-delete', 'group_id' => 6, 'module_id' => 2],
            ['name' => 'manager_glimpse_glimpse-category-activity-log', 'group_id' => 6, 'module_id' => 2],
            ['name' => 'manager_glimpse_glimpse-category-activity-log-trash', 'group_id' => 6, 'module_id' => 2],

//            glimpse-year permissions
            ['name' => 'manager_glimpse_glimpse-year-list', 'group_id' => 6, 'module_id' => 2],
            ['name' => 'manager_glimpse_glimpse-year-edit', 'group_id' => 6, 'module_id' => 2],
            ['name' => 'manager_glimpse_glimpse-year-show', 'group_id' => 6, 'module_id' => 2],
            ['name' => 'manager_glimpse_glimpse-year-create', 'group_id' => 6, 'module_id' => 2],
            ['name' => 'manager_glimpse_glimpse-year-delete', 'group_id' => 6, 'module_id' => 2],
            ['name' => 'manager_glimpse_glimpse-year-activity-log', 'group_id' => 6, 'module_id' => 2],
            ['name' => 'manager_glimpse_glimpse-year-activity-log-trash', 'group_id' => 6, 'module_id' => 2],

//            glimpse-day permissions
            ['name' => 'manager_glimpse_glimpse-day-list', 'group_id' => 6, 'module_id' => 2],
            ['name' => 'manager_glimpse_glimpse-day-edit', 'group_id' => 6, 'module_id' => 2],
            ['name' => 'manager_glimpse_glimpse-day-show', 'group_id' => 6, 'module_id' => 2],
            ['name' => 'manager_glimpse_glimpse-day-create', 'group_id' => 6, 'module_id' => 2],
            ['name' => 'manager_glimpse_glimpse-day-delete', 'group_id' => 6, 'module_id' => 2],
            ['name' => 'manager_glimpse_glimpse-day-activity-log', 'group_id' => 6, 'module_id' => 2],
            ['name' => 'manager_glimpse_glimpse-day-activity-log-trash', 'group_id' => 6, 'module_id' => 2],

//            glimpse permissions
            ['name' => 'manager_glimpse_glimpse-list', 'group_id' => 6, 'module_id' => 2],
            ['name' => 'manager_glimpse_glimpse-edit', 'group_id' => 6, 'module_id' => 2],
            ['name' => 'manager_glimpse_glimpse-show', 'group_id' => 6, 'module_id' => 2],
            ['name' => 'manager_glimpse_glimpse-download', 'group_id' => 6, 'module_id' => 2],
            ['name' => 'manager_glimpse_glimpse-create', 'group_id' => 6, 'module_id' => 2],
            ['name' => 'manager_glimpse_glimpse-delete', 'group_id' => 6, 'module_id' => 2],
            ['name' => 'manager_glimpse_glimpse-activity-log', 'group_id' => 6, 'module_id' => 2],
            ['name' => 'manager_glimpse_glimpse-activity-log-trash', 'group_id' => 6, 'module_id' => 2],
//            ---------------------- Manager Permissions End------------------------

            //            ---------------------- User Permissions Start------------------------
            ['name' => 'user_registration_user-registration-list', 'group_id' => 4, 'module_id' => 3],
            ['name' => 'user_registration_paper-submission-list', 'group_id' => 4, 'module_id' => 3],
            ['name' => 'user_registration_paper-submission-activity-log', 'group_id' => 4, 'module_id' => 3],
            ['name' => 'user_registration_paper-submission-create', 'group_id' => 4, 'module_id' => 3],
            ['name' => 'user_registration_paper-submission-show', 'group_id' => 4, 'module_id' => 3],
            ['name' => 'user_registration_paper-submission-edit', 'group_id' => 4, 'module_id' => 3],
            ['name' => 'user_registration_paper-submission-delete', 'group_id' => 4, 'module_id' => 3],
        ];

        foreach ($permissions as $permission) {
            Permission::create($permission);
        }
    }
}
