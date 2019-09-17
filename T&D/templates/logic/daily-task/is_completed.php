<?php
$is_completed = function( $daily_task_id, $daily_task_item_id ) {
  $metadata = get_post_meta( $daily_task_id, "_daily_task_item_" . $daily_task_item_id . "_status", true );

  if ( $metadata === "0" || $metadata === "" ) {
    return false;
  } else {
    return true;
  }
}
?>
