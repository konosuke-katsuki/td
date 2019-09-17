<?php
$display_select_attribute = function( $is_completed, $value ) {
  if ( $is_completed && $value === "1" ) {
    return "selected";
  }

  if ( ! $is_completed && $value === "0" ) {
    return "";
  }
}
?>
