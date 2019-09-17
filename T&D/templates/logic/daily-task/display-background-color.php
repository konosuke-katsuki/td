<?php
$display_background_color = function( $is_completed ) {
  if ( $is_completed ) {
    return " daily-task-item--bg-blue";
  } else {
    return " daily-task-item--bg-red";
  }
}
?>
