<?php
$get_daily_task = function() {
  $today = new DateTime( "now", new DateTimeZone( "Asia/Tokyo" ) );

  $args = [
    "author"     => wp_get_current_user() -> ID,
    "post_type"  => "daily_task",
    "date_query" => [
      [
        "year"  => $today -> format( "Y" ),
        "month" => $today -> format( "n" ),
        "day"   => $today -> format( "j" ),
      ],
    ],
  ];

  $query = new WP_Query( $args );

  if ( $query -> post_count !== 1 ) {
    $post = [
      "post_title"  => $today -> format( "Y-m-d" ),
      "post_status" => "publish",
      "post_author" => wp_get_current_user() -> ID,
      "post_type"   => "daily_task",
    ];
    $daily_task = get_post( wp_insert_post( $post, true ) );
  } else {
    $daily_task = $query -> posts[ 0 ];
  }

  return $daily_task;
}
?>
