<?php

class Lb_Custom_Post_Daily_Task_Item {

  private $type = "daily_task_item";

  /**
   * コンストラクタ
   *
   * @param -
   *
   * @return void
   */
  public function __construct() {
    add_action( "init",                       [ $this, "create_custom_post_type" ], 100, 1 );
    add_action( "save_post_" . $this -> type, [ $this, "update_post_title" ],       100, 2 );
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
      "all_items"          => "デイリータスク項目一覧",
      "add_new"            => "新規追加",
      "add_new_item"       => "新規のデイリータスク項目を追加",
      "edit_item"          => "デイリータスク項目を編集",
      "new_item"           => "新規デイリータスク項目",
      "view_item"          => "デイリータスク項目を表示",
      "search_items"       => "デイリータスク項目を検索",
      "not_found"          => "デイリータスク項目が見つかりませんでした。",
      "not_found_in_trash" => "ゴミ箱は空です。",
      "parent_item_colon"  => "親デイリータスク項目：",
    ];

    $args = [
      "label"         => "デイリータスク項目",
      "labels"        => $labels,
      "public"        => true,
      "menu_position" => 5,
      "hierarchical"  => false,
      "has_archive"   => false,
      "supports"      => [ "editor" ],
    ];

    register_post_type( $this -> type, $args );
  }

  /**
   * カスタム投稿のタイトル名を更新する。
   *
   * @param post_id 投稿ID
   * @param post    投稿オブジェクト
   *
   * @return void
   */
  public function update_post_title( $post_id, WP_Post $post ) {
    if ( mb_strlen( $post -> post_content ) > 30 ) {
      $post -> post_title = mb_substr( $post -> post_content, 0, 27 ) . "...";
    } else {
      $post -> post_title = $post -> post_content;
    }

    $this -> update_post( $post );

    return;
  }

  /**
   * カスタム投稿を更新する。
   *
   * @param post 投稿オブジェクト
   *
   * @return void
   */
  public function update_post( WP_Post $post ) {
    remove_action( "save_post_" . $this -> type, [ $this, "update_post_title" ], 100, 2 );

    wp_update_post( $post );

    add_action( "save_post_" . $this -> type, [ $this, "update_post_title" ], 100, 2 );

    return;
  }
}
