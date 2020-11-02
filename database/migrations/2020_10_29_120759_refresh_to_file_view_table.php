<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RefreshToFileViewTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        $sql1 = "DROP VIEW IF EXISTS file_view";
        $sql2 = 'select `clients`.*, `business_scales`.`name` as `business_scale_name`, `pradesheeyasabas`.`name` as `pradesheeyasaba_name`, `industry_categories`.`name` as `category_name`, `zones`.`name` as `zone_name`, `e_p_l_s`.`id` as `epl_id`, `e_p_l_s`.`code` as `epl_code`, `e_p_l_s`.`issue_date` as `epl_issue_date`, `e_p_l_s`.`expire_date` as `epl_expire_date`, `e_p_l_s`.`submitted_date` as `epl_submitted_date`, `e_p_l_s`.`certificate_no` as `epl_certificate_no`, `e_p_l_s`.`count` as `epl_count`, `e_p_l_s`.`status` as `epl_status`, `e_p_l_s`.`rejected_date` as `epl_rejected_date`, `e_p_l_s`.`deleted_at` as `epl_deleted_at`, `site_clearence_sessions`.`code` as `site_code`, `site_clearence_sessions`.`site_clearance_type` as `site_site_clearance_type`, `site_clearence_sessions`.`processing_status` as `site_processing_status`, `site_clearence_sessions`.`licence_no` as `site_licence_no`, `site_clearence_sessions`.`deleted_at` as `site_session_deleted_at`, `site_clearances`.`submit_date` as `site_submit_date`, `site_clearances`.`issue_date` as `site_issue_date`, `site_clearances`.`expire_date` as `site_expire_date`, `site_clearances`.`rejected_date` as `site_rejected_date`, `site_clearances`.`status` as `site_status`, `site_clearances`.`count` as `site_count`, `site_clearances`.`deleted_at` as `site_deleted_at`, `as_users`.`first_name` as `assistance_first_name`, `as_users`.`last_name` as `assistance_last_name`, `eo_users`.`first_name` as `officer_first_name`, `eo_users`.`last_name` as `officer_last_name` from `clients` inner join `industry_categories` on `clients`.`industry_category_id` = `industry_categories`.`id` inner join `business_scales` on `clients`.`business_scale_id` = `business_scales`.`id` inner join `pradesheeyasabas` on `clients`.`pradesheeyasaba_id` = `pradesheeyasabas`.`id` left join `environment_officers` on `clients`.`environment_officer_id` = `environment_officers`.`id` left join `users` as `eo_users` on `environment_officers`.`user_id` = `eo_users`.`id` inner join `zones` on `pradesheeyasabas`.`zone_id` = `zones`.`id` inner join `assistant_directors` on `zones`.`id` = `assistant_directors`.`zone_id` inner join `users` as `as_users` on `assistant_directors`.`user_id` = `as_users`.`id` left join `e_p_l_s` on `clients`.`id` = `e_p_l_s`.`client_id` left join `site_clearence_sessions` on `clients`.`id` = `site_clearence_sessions`.`client_id` left join `site_clearances` on `site_clearence_sessions`.`id` = `site_clearances`.`site_clearence_session_id` where `environment_officers`.`active_status` = 1 and `assistant_directors`.`active_status` = 1 and `clients`.`deleted_at` is null';

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
        Schema::table('file_view', function (Blueprint $table) {
            //
        });
    }
}
