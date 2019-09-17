<?php

class Lb_Ajax {

  public function __construct() {
    if ( is_page( "daily-task" ) ) {
      add_action( "wp_ajax_update_daliy_task", [ $this, "update_daily_task" ] );
      add_action( "wp_ajax_nopriv_update_daliy_task", [ $this, "update_daily_task" ] );
    }
  }

  public function update_daily_task() {
    echo json_encode( [ "test" => 1, "test2" => 2 ] );
    exit;
  }
}
?>
