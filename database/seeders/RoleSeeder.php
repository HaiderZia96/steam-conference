<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
//            ---------------------- admin Permissions Start------------------------
            ['admin_user-management_module-list'],
            ['admin_user-management_module-create'],
            ['admin_user-management_module-show'],
            ['admin_user-management_module-edit'],
            ['admin_user-management_module-delete'],
            ['admin_user-management_module-activity-log'],
            ['admin_user-management_module-activity-log-trash'],
            ['admin_user-management_permission-group-list'],
            ['admin_user-management_permission-group-create'],
            ['admin_user-management_permission-group-show'],
            ['admin_user-management_permission-group-edit'],
            ['admin_user-management_permission-group-activity-log'],
            ['admin_user-management_permission-group-activity-log-trash'],
            ['admin_user-management_permission-group-delete'],
            ['admin_user-management_permission-list'],
            ['admin_user-management_permission-create'],
            ['admin_user-management_permission-show'],
            ['admin_user-management_permission-edit'],
            ['admin_user-management_permission-delete'],
            ['admin_user-management_role-list'],
            ['admin_user-management_role-create'],
            ['admin_user-management_role-show'],
            ['admin_user-management_role-edit'],
            ['admin_user-management_role-delete'],
            ['admin_user-management_user-list'],
            ['admin_user-management_user-create'],
            ['admin_user-management_user-show'],
            ['admin_user-management_user-edit'],
            ['admin_user-management_user-activity-log'],
            ['admin_user-management_user-activity-log-trash'],
            ['admin_user-management_user-delete'],
            ['admin_user-management_backup-list'],
            ['admin_user-management_backup-create'],
            ['admin_user-management_backup-download'],
            ['admin_user-management_backup-delete'],
            ['admin_user-management_log-dashboard'],
            ['admin_user-management_log-list'],
            ['admin_user-management_log-show'],
            ['admin_user-management_log-download'],
            ['admin_user-management_log-delete'],
//            ---------------------- admin Permissions End------------------------

//            ---------------------- Manager Permissions Start------------------------
//            conference-year permission
            ['manager_master-data_conference-year-list'],
            ['manager_master-data_conference-year-edit'],
            ['manager_master-data_conference-year-status-edit'],
            ['manager_master-data_conference-year-status-update'],
            ['manager_master-data_conference-year-create'],
            ['manager_master-data_conference-year-show'],
            ['manager_master-data_conference-year-delete'],
            ['manager_master-data_conference-year-activity-log-trash'],
            ['manager_master-data_conference-year-activity-log'],
//            registration-type permission
            ['manager_master-data_registration-type-list'],
            ['manager_master-data_registration-type-edit'],
            ['manager_master-data_registration-type-show'],
            ['manager_master-data_registration-type-create'],
            ['manager_master-data_registration-type-delete'],
            ['manager_master-data_registration-type-activity-log-trash'],
            ['manager_master-data_registration-type-activity-log'],
//            payment-type permission
            ['manager_master-data_payment-type-list'],
            ['manager_master-data_payment-type-edit'],
            ['manager_master-data_payment-type-show'],
            ['manager_master-data_payment-type-create'],
            ['manager_master-data_payment-type-delete'],
            ['manager_master-data_payment-type-activity-log-trash'],
            ['manager_master-data_payment-type-activity-log'],
//           status-type permission
            ['manager_master-data_status-type-list'],
            ['manager_master-data_status-type-edit'],
            ['manager_master-data_status-type-status-edit'],
            ['manager_master-data_status-type-show'],
            ['manager_master-data_status-type-create'],
            ['manager_master-data_status-type-delete'],
            ['manager_master-data_status-type-activity-log-trash'],
            ['manager_master-data_status-type-activity-log'],
//            faculty permission
            ['manager_master-data_faculty-list'],
            ['manager_master-data_faculty-edit'],
            ['manager_master-data_faculty-show'],
            ['manager_master-data_faculty-create'],
            ['manager_master-data_faculty-delete'],
            ['manager_master-data_faculty-activity-log-trash'],
            ['manager_master-data_faculty-activity-log'],
//            department permission
            ['manager_master-data_department-list'],
            ['manager_master-data_department-edit'],
            ['manager_master-data_department-show'],
            ['manager_master-data_department-create'],
            ['manager_master-data_department-delete'],
            ['manager_master-data_department-activity-log-trash'],
            ['manager_master-data_department-activity-log'],
//            user-registration permission
            ['manager_registration_user-registration-list'],
            ['manager_registration_user-registration-edit'],
            ['manager_registration_user-registration-show'],
            ['manager_registration_user-registration-create'],
            ['manager_registration_user-registration-delete'],
            ['manager_registration_user-registration-activity-log-trash'],
            ['manager_registration_user-registration-activity-log'],
            ['manager_registration_user-registration-voucher-download'],
            ['manager_registration_user-registration-voucher-upload'],
            ['manager_registration_user-registration-voucher-view'],
            ['manager_registration_user-registration-gate-pass-download'],

//            paper-submission permission
            ['manager_registration_paper-submission-list'],
            ['manager_registration_paper-submission-edit'],
            ['manager_registration_paper-submission-status-edit'],
            ['manager_registration_paper-submission-show'],
            ['manager_registration_paper-submission-create'],
            ['manager_registration_paper-submission-delete'],
            ['manager_registration_paper-submission-activity-log-trash'],
            ['manager_registration_paper-submission-activity-log'],

//            publication-type permission
            ['manager_steam-publication_publication-type-list'],
            ['manager_steam-publication_publication-type-edit'],
            ['manager_steam-publication_publication-type-show'],
            ['manager_steam-publication_publication-type-create'],
            ['manager_steam-publication_publication-type-delete'],
            ['manager_steam-publication_publication-type-activity-log'],
            ['manager_steam-publication_publication-type-activity-log-trash'],

//            publication permission
            ['manager_steam-publication_publication-list'],
            ['manager_steam-publication_publication-edit'],
            ['manager_steam-publication_publication-show'],
            ['manager_steam-publication_publication-download'],
            ['manager_steam-publication_publication-create'],
            ['manager_steam-publication_publication-delete'],
            ['manager_steam-publication_publication-activity-log'],
            ['manager_steam-publication_publication-activity-log-trash'],

//            glimpse-category permission
            ['manager_glimpse_glimpse-category-list'],
            ['manager_glimpse_glimpse-category-edit'],
            ['manager_glimpse_glimpse-category-show'],
            ['manager_glimpse_glimpse-category-create'],
            ['manager_glimpse_glimpse-category-delete'],
            ['manager_glimpse_glimpse-category-activity-log'],
            ['manager_glimpse_glimpse-category-activity-log-trash'],

//            glimpse-year permission
            ['manager_glimpse_glimpse-year-list'],
            ['manager_glimpse_glimpse-year-edit'],
            ['manager_glimpse_glimpse-year-show'],
            ['manager_glimpse_glimpse-year-create'],
            ['manager_glimpse_glimpse-year-delete'],
            ['manager_glimpse_glimpse-year-activity-log'],
            ['manager_glimpse_glimpse-year-activity-log-trash'],

//            glimpse-day permission
            ['manager_glimpse_glimpse-day-list'],
            ['manager_glimpse_glimpse-day-edit'],
            ['manager_glimpse_glimpse-day-show'],
            ['manager_glimpse_glimpse-day-create'],
            ['manager_glimpse_glimpse-day-delete'],
            ['manager_glimpse_glimpse-day-activity-log'],
            ['manager_glimpse_glimpse-day-activity-log-trash'],

//            glimpse permission
            ['manager_glimpse_glimpse-list'],
            ['manager_glimpse_glimpse-edit'],
            ['manager_glimpse_glimpse-show'],
            ['manager_glimpse_glimpse-download'],
            ['manager_glimpse_glimpse-create'],
            ['manager_glimpse_glimpse-delete'],
            ['manager_glimpse_glimpse-activity-log'],
            ['manager_glimpse_glimpse-activity-log-trash'],
//            ---------------------- Manager Permissions End------------------------
        ];
        $admin_role = Role::create(['name' => 'super-admin']);
        $admin_role->givePermissionTo($permissions);

        $manager_permissions = [
//            ---------------------- Manager Permissions Start------------------------
//            conference-year permission
            ['manager_master-data_conference-year-list'],
            ['manager_master-data_conference-year-edit'],
            ['manager_master-data_conference-year-status-edit'],
            ['manager_master-data_conference-year-status-update'],
            ['manager_master-data_conference-year-create'],
            ['manager_master-data_conference-year-show'],
            ['manager_master-data_conference-year-delete'],
            ['manager_master-data_conference-year-activity-log-trash'],
            ['manager_master-data_conference-year-activity-log'],
//            registration-type permission
            ['manager_master-data_registration-type-list'],
            ['manager_master-data_registration-type-edit'],
            ['manager_master-data_registration-type-show'],
            ['manager_master-data_registration-type-create'],
            ['manager_master-data_registration-type-delete'],
            ['manager_master-data_registration-type-activity-log-trash'],
            ['manager_master-data_registration-type-activity-log'],
//            payment-type permission
            ['manager_master-data_payment-type-list'],
            ['manager_master-data_payment-type-edit'],
            ['manager_master-data_payment-type-show'],
            ['manager_master-data_payment-type-create'],
            ['manager_master-data_payment-type-delete'],
            ['manager_master-data_payment-type-activity-log-trash'],
            ['manager_master-data_payment-type-activity-log'],
//            status-type permission
            ['manager_master-data_status-type-list'],
            ['manager_master-data_status-type-edit'],
            ['manager_master-data_status-type-status-edit'],
            ['manager_master-data_certificate-status-edit'],
            ['manager_master-data_status-type-show'],
            ['manager_master-data_status-type-create'],
            ['manager_master-data_status-type-delete'],
            ['manager_master-data_status-type-activity-log-trash'],
            ['manager_master-data_status-type-activity-log'],
//            faculty permission
            ['manager_master-data_faculty-list'],
            ['manager_master-data_faculty-edit'],
            ['manager_master-data_faculty-show'],
            ['manager_master-data_faculty-create'],
            ['manager_master-data_faculty-delete'],
            ['manager_master-data_faculty-activity-log-trash'],
            ['manager_master-data_faculty-activity-log'],
//            department permission
            ['manager_master-data_department-list'],
            ['manager_master-data_department-edit'],
            ['manager_master-data_department-show'],
            ['manager_master-data_department-create'],
            ['manager_master-data_department-delete'],
            ['manager_master-data_department-activity-log-trash'],
            ['manager_master-data_department-activity-log'],
//            user-registration permission
            ['manager_registration_user-registration-list'],
            ['manager_registration_user-registration-edit'],
            ['manager_registration_user-registration-show'],
            ['manager_registration_user-registration-create'],
            ['manager_registration_user-registration-delete'],
            ['manager_registration_user-registration-activity-log-trash'],
            ['manager_registration_user-registration-activity-log'],
            ['manager_registration_user-registration-voucher-download'],
            ['manager_registration_user-registration-voucher-upload'],
            ['manager_registration_user-registration-voucher-view'],
            ['manager_registration_user-registration-gate-pass-download'],

//            paper-submission permission
            ['manager_registration_paper-submission-list'],
            ['manager_registration_paper-submission-edit'],
            ['manager_registration_paper-submission-status-edit'],
            ['manager_registration_paper-submission-show'],
            ['manager_registration_paper-submission-create'],
            ['manager_registration_paper-submission-delete'],
            ['manager_registration_paper-submission-activity-log-trash'],
            ['manager_registration_paper-submission-activity-log'],

//            publication-type permission
            ['manager_steam-publication_publication-type-list'],
            ['manager_steam-publication_publication-type-edit'],
            ['manager_steam-publication_publication-type-show'],
            ['manager_steam-publication_publication-type-create'],
            ['manager_steam-publication_publication-type-delete'],
            ['manager_steam-publication_publication-type-activity-log'],
            ['manager_steam-publication_publication-type-activity-log-trash'],

//            publication permission
            ['manager_steam-publication_publication-list'],
            ['manager_steam-publication_publication-edit'],
            ['manager_steam-publication_publication-show'],
            ['manager_steam-publication_publication-download'],
            ['manager_steam-publication_publication-create'],
            ['manager_steam-publication_publication-delete'],
            ['manager_steam-publication_publication-activity-log'],
            ['manager_steam-publication_publication-activity-log-trash'],

//            glimpse-category permission
            ['manager_glimpse_glimpse-category-list'],
            ['manager_glimpse_glimpse-category-edit'],
            ['manager_glimpse_glimpse-category-show'],
            ['manager_glimpse_glimpse-category-create'],
            ['manager_glimpse_glimpse-category-delete'],
            ['manager_glimpse_glimpse-category-activity-log'],
            ['manager_glimpse_glimpse-category-activity-log-trash'],

//            glimpse-year permission
            ['manager_glimpse_glimpse-year-list'],
            ['manager_glimpse_glimpse-year-edit'],
            ['manager_glimpse_glimpse-year-show'],
            ['manager_glimpse_glimpse-year-create'],
            ['manager_glimpse_glimpse-year-delete'],
            ['manager_glimpse_glimpse-year-activity-log'],
            ['manager_glimpse_glimpse-year-activity-log-trash'],

//            glimpse-day permission
            ['manager_glimpse_glimpse-day-list'],
            ['manager_glimpse_glimpse-day-edit'],
            ['manager_glimpse_glimpse-day-show'],
            ['manager_glimpse_glimpse-day-create'],
            ['manager_glimpse_glimpse-day-delete'],
            ['manager_glimpse_glimpse-day-activity-log'],
            ['manager_glimpse_glimpse-day-activity-log-trash'],

//            glimpse permission
            ['manager_glimpse_glimpse-list'],
            ['manager_glimpse_glimpse-edit'],
            ['manager_glimpse_glimpse-show'],
            ['manager_glimpse_glimpse-download'],
            ['manager_glimpse_glimpse-create'],
            ['manager_glimpse_glimpse-delete'],
            ['manager_glimpse_glimpse-activity-log'],
            ['manager_glimpse_glimpse-activity-log-trash'],
//            ---------------------- Manager Permissions End------------------------
        ];
        $manager_role = Role::create(['name' => 'manager']);
        $manager_role->givePermissionTo($manager_permissions);

        // User Permissions
        $user_permissions = [
            ['user_registration_user-registration-list'],
            ['user_registration_paper-submission-list'],
            ['user_registration_paper-submission-activity-log'],
            ['user_registration_paper-submission-create'],
            ['user_registration_paper-submission-show'],
            ['user_registration_paper-submission-edit'],
            ['user_registration_paper-submission-delete'],
        ];
        $user_role = Role::create(['name' => 'user']);
        $user_role->givePermissionTo($user_permissions);

    }
}
