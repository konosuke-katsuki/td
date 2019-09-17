<?php
$get_daily_task_items = function( $when ) {
  $args = [
    "author"    => wp_get_current_user() -> ID,
    "post_type" => "daily_task_item",
    "tax_query" => [
      [
        "taxonomy" => "daily_task_item_category",
        "field" => "slug",
        "terms" => $when,
      ],
    ],
  ];

  $query = new WP_Query( $args );

  return $query -> posts;
}
?>
