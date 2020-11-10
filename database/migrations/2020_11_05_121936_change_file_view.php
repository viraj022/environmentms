<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeFileView extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $sql1 = "DROP VIEW IF EXISTS file_view";
        $sql2 = 'SELECT
    `clients`.*,
    `business_scales`.`name` AS `business_scale_name`,
    `pradesheeyasabas`.`name` AS `pradesheeyasaba_name`,
    `zones`.`name` AS `zone_name`,
    `e_p_l_s`.`id` AS `epl_id`,
    `e_p_l_s`.`code` AS `epl_code`,
    `e_p_l_s`.`issue_date` AS `epl_issue_date`,
    `e_p_l_s`.`expire_date` AS `epl_expire_date`,
    `e_p_l_s`.`submitted_date` AS `epl_submitted_date`,
    `e_p_l_s`.`certificate_no` AS `epl_certificate_no`,
    `e_p_l_s`.`count` AS `epl_count`,
    `e_p_l_s`.`status` AS `epl_status`,
    `e_p_l_s`.`rejected_date` AS `epl_rejected_date`,
    `e_p_l_s`.`deleted_at` AS `epl_deleted_at`,
    `site_clearence_sessions`.`code` AS `site_code`,
    `site_clearence_sessions`.`site_clearance_type` AS `site_site_clearance_type`,
    `site_clearence_sessions`.`processing_status` AS `site_processing_status`,
    `site_clearence_sessions`.`licence_no` AS `site_licence_no`,
    `site_clearence_sessions`.`deleted_at` AS `site_session_deleted_at`,
    `site_clearances`.`submit_date` AS `site_submit_date`,
    `site_clearances`.`issue_date` AS `site_issue_date`,
    `site_clearances`.`expire_date` AS `site_expire_date`,
    `site_clearances`.`rejected_date` AS `site_rejected_date`,
    `site_clearances`.`status` AS `site_status`,
    `site_clearances`.`count` AS `site_count`,
    `site_clearances`.`deleted_at` AS `site_deleted_at`,
    `as_users`.`first_name` AS `assistance_first_name`,
    `as_users`.`last_name` AS `assistance_last_name`,
    `eo_users`.`first_name` AS `officer_first_name`,
    `eo_users`.`last_name` AS `officer_last_name`
FROM
    `clients`
INNER JOIN `industry_categories` ON `clients`.`industry_category_id` = `industry_categories`.`id`
INNER JOIN `business_scales` ON `clients`.`business_scale_id` = `business_scales`.`id`
INNER JOIN `pradesheeyasabas` ON `clients`.`pradesheeyasaba_id` = `pradesheeyasabas`.`id`
LEFT JOIN `environment_officers` ON `clients`.`environment_officer_id` = `environment_officers`.`id`
LEFT JOIN `users` AS `eo_users`
ON
    `environment_officers`.`user_id` = `eo_users`.`id`
INNER JOIN `zones` ON `pradesheeyasabas`.`zone_id` = `zones`.`id`
Left JOIN    `assistant_directors` ON   `environment_officers`.`assistant_director_id` = `assistant_directors`.id
INNER JOIN `users` AS `as_users`
ON
    `assistant_directors`.`user_id` = `as_users`.`id`
LEFT JOIN `e_p_l_s` ON `clients`.`id` = `e_p_l_s`.`client_id`
LEFT JOIN `site_clearence_sessions` ON `clients`.`id` = `site_clearence_sessions`.`client_id`
LEFT JOIN `site_clearances` ON `site_clearence_sessions`.`id` = `site_clearances`.`site_clearence_session_id`
WHERE
    `environment_officers`.`active_status` = 1 AND `assistant_directors`.`active_status` = 1 AND `clients`.`deleted_at` IS NULL';

        \DB::statement($sql1);
        \DB::statement("
            CREATE VIEW file_view 
            AS " . $sql2);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
