<?php

class Lb_Custom_Post_Task {

  private $type = "task";

  /**
   * コンストラクタ
   *
   * @param -
   *
   * @return void
   */
  public function __construct() {
    add_action( "init",                            [ $this, "create_custom_post_type" ], 100, 1 );
    add_action( "add_meta_boxes_" . $this -> type, [ $this, "add_meta_boxes" ],          100, 1 );
    add_action( "save_post_" . $this -> type,      [ $this, "update_post_meta" ],        100, 2 );
    add_action( "template_redirect",               [ $this, "update_post_meta_from_front" ] );
    add_action( "template_redirect",               [ $this, "trash_post_meta_from_front" ] );
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
      "all_items"          => "タスク一覧",
      "add_new"            => "新規追加",
      "add_new_item"       => "新規のタスクを追加",
      "edit_item"          => "タスクを編集",
      "new_item"           => "新規タスク",
      "view_item"          => "タスクを表示",
      "search_items"       => "タスクを検索",
      "not_found"          => "タスクが見つかりませんでした。",
      "not_found_in_trash" => "ゴミ箱は空です。",
      "parent_item_colon"  => "親タスク：",
    ];

    $args = [
      "label"         => "タスク",
      "labels"        => $labels,
      "public"        => true,
      "menu_position" => 5,
      "hierarchical"  => false,
      "supports"      => false,
      "has_archive"   => false,
    ];

    register_post_type( $this -> type, $args );
  }

  /**
   * カスタム投稿編集ページにメタボックスを追加する。
   *
   * @param post 投稿オブジェクト
   *
   * @return void
   */
  public function add_meta_boxes ( WP_Post $post ) {
    add_meta_box( "task-entry-area", "タスク", [ $this, "display_meta_boxes" ], null, "normal", "high", [ $post ] );
  }

  /**
   * カスタム投稿編集ページにメタボックスを表示する。
   *
   * @param post 投稿オブジェクト
   *
   * @return void
   */
  public function display_meta_boxes( WP_Post $post ) {
    $content = get_post_meta( $post -> ID, "_lb_task_content", true );
    $status  = get_post_meta( $post -> ID, "_lb_task_status",  true );
    include get_template_directory() . "/class/lb-custom-post/lb-custom-post-task/template.php";
  }

  /**
   * カスタム投稿のメタデータを登録・更新する。
   *
   * @param post_id 投稿ID
   * @param post    投稿オブジェクト
   *
   * @return void
   */
  public function update_post_meta( $post_id, WP_Post $post ) {
    if ( ! $this -> validate( $post_id ) ) {
      return;
    }

    $error_message = "";

    if ( ! isset( $_POST[ "task" ][ "content" ] ) ) {
      $error_message .= "タスクの内容が入力されていません。";
    }

    if ( ! isset( $_POST[ "task" ][ "status" ] ) ) {
      $error_message .= "タスクの状態が入力されていません。";
    }

    if ( $error_message !== "" ) {
      $post -> post_status = "draft";
      $this -> update_post( $post );
      return;
    }

    if ( mb_strlen( $_POST[ "task" ][ "content" ] ) > 30 ) {
      $post -> post_title = mb_substr( $_POST[ "task" ][ "content" ], 0, 27 ) . "...";
    } else {
      $post -> post_title = $_POST[ "task" ][ "content" ];
    }

    update_post_meta( $post_id, "_lb_task_content", $_POST[ "task" ][ "content" ] );
    update_post_meta( $post_id, "_lb_task_status",  $_POST[ "task" ][ "status" ] );

    $this -> update_post( $post );

    return;
  }

  /**
   * バリデートする。
   *
   * @param post_id 投稿ID
   *
   * @return バリデートの結果
   */
  public function validate( $post_id ) {
    //投稿IDが正しく、トークンが送信されていることをチェックする。
    if (
      ! $post_id ||
      ! isset( $_POST[ "task-entry-nonce" ] )
    ) {
      return false;
    }

    //トークンが正規であることをチェックする。
    if ( ! wp_verify_nonce( $_POST[ "task-entry-nonce" ], "task-entry-action" ) ) {
      return false;
    }

    //オートセーブでないことをチェックする。
    if (
      defined( "DOING_AUTOSAVE" ) &&
      DOING_AUTOSAVE
    ) {
      return false;
    }

    //現在のユーザーがこの投稿の編集権限を持つことをチェックする。
    if ( ! current_user_can( "edit_post", $post_id ) ) {
      return false;
    }

    return true;
  }

  /**
   * カスタム投稿を更新する。
   *
   * @param post 投稿オブジェクト
   *
   * @return void
   */
  public function update_post( WP_Post $post ) {
    remove_action( "save_post_" . $this -> type, [ $this, "update_post_meta" ], 100, 2 );

    wp_update_post( $post );

    add_action( "save_post_" . $this -> type, [ $this, "update_post_meta" ], 100, 2 );

    return;
  }

  public function trash_post_meta_from_front() {
    if (
      ! is_page( "task-list" ) ||
      ! isset( $_POST[ "trash-button" ] ) ||
      ! isset( $_POST[ "post-id" ] )
    ) {
      return;
    }

    wp_trash_post( $_POST[ "post-id" ] );
  }

  public function update_post_meta_from_front() {
    if (
      ! is_page( "task-list" ) ||
      ! isset( $_POST[ "update-button" ] ) ||
      ! isset( $_POST[ "post-id" ] ) ||
      ! isset( $_POST[ "status" ] )
    ) {
      return;
    }

    update_post_meta( $_POST[ "post-id" ], "_lb_task_status",  $_POST[ "status" ] );
  }
}
