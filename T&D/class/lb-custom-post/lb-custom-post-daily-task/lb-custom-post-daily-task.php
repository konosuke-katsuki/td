<?php

class Lb_Custom_Post_Daily_Task {

  private $type = "daily_task";

  /**
   * コンストラクタ
   *
   * @param -
   *
   * @return void
   */
  public function __construct() {
    add_action( "init", [ $this, "create_custom_post_type" ], 100, 1 );
  }

  /**
   * カスタム投稿を生成する。
   *
   * @param -
   *
   * @return void
   */
  public function create_custom_post_type() {
    $labels = [
      "all_items"          => "デイリータスク一覧",
      "add_new"            => "新規追加",
      "add_new_item"       => "新規のデイリータスクを追加",
      "edit_item"          => "デイリータスクを編集",
      "new_item"           => "新規デイリータスク",
      "view_item"          => "デイリータスクを表示",
      "search_items"       => "デイリータスクを検索",
      "not_found"          => "デイリータスクが見つかりませんでした。",
      "not_found_in_trash" => "ゴミ箱は空です。",
      "parent_item_colon"  => "親デイリータスク：",
    ];

    $args = [
      "label"         => "デイリータスク",
      "labels"        => $labels,
      "public"        => false,
      "menu_position" => 5,
      "hierarchical"  => false,
      "has_archive"   => false,
    ];

    register_post_type( $this -> type, $args );
  }
}
