<?php
$theme_directory = get_template_directory();

include $theme_directory . "/class/lb-theme.php";
// include $theme_directory . "/class/lb-ajax.php";
include $theme_directory . "/class/lb-script-manager.php";
include $theme_directory . "/class/lb-user-manager.php";
include $theme_directory . "/class/lb-custom-post/lb-custom-post-question/lb-custom-post-question.php";
include $theme_directory . "/class/lb-custom-post/lb-custom-post-task/lb-custom-post-task.php";
include $theme_directory . "/class/lb-custom-post/lb-custom-post-daily-task/lb-custom-post-daily-task.php";
include $theme_directory . "/class/lb-custom-post/lb-custom-post-daily-task-item/lb-custom-post-daily-task-item.php";
include $theme_directory . "/class/lb-custom-taxonomy/lb-custom-taxonomy-question-category/lb-custom-taxonomy-question-category.php";
include $theme_directory . "/class/lb-custom-taxonomy/lb-custom-taxonomy-daily-task-item-category/lb-custom-taxonomy-daily-task-item-category.php";

$lb_theme                             = new Lb_Theme();
// $lb_ajax                              = new Lb_Ajax();
$lb_script_manager                    = new Lb_Script_Manager();
$lb_user_manager                      = new Lb_User_Manager();
$lb_question                          = new Lb_Custom_Post_Question();
$lb_task                              = new Lb_Custom_Post_Task();
$lb_daily_task                        = new Lb_Custom_Post_Daily_Task();
$lb_daily_task_item                   = new Lb_Custom_Post_Daily_Task_Item();
$lb_question_category                 = new Lb_Custom_Taxonomy_Question_Category();
$lb_daily_task_item_category_category = new Lb_Custom_Taxonomy_Daily_Task_Item_Category();
