<?php

class Lb_Custom_Post_Question {

  private $type = "question";

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
      "all_items"          => "練習問題一覧",
      "add_new"            => "新規追加",
      "add_new_item"       => "新規の練習問題を追加",
      "edit_item"          => "練習問題を編集",
      "new_item"           => "新規練習問題",
      "view_item"          => "練習問題を表示",
      "search_items"       => "練習問題を検索",
      "not_found"          => "練習問題が見つかりませんでした。",
      "not_found_in_trash" => "ゴミ箱は空です。",
      "parent_item_colon"  => "親練習問題：",
    ];

    $args = [
      "label"         => "練習問題",
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
    add_meta_box( "question-entry-area", "練習問題", [ $this, "display_meta_boxes" ], null, "normal", "high", [ $post ] );
  }

  /**
   * カスタム投稿編集ページにメタボックスを表示する。
   *
   * @param post 投稿オブジェクト
   *
   * @return void
   */
  public function display_meta_boxes( WP_Post $post ) {
    $content = get_post_meta( $post -> ID, "_lb_question_content", true );
    $answer  = get_post_meta( $post -> ID, "_lb_question_answer",  true );
    include get_template_directory() . "/class/lb-custom-post/lb-custom-post-question/template.php";
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

    if ( ! isset( $_POST[ "question" ][ "content" ] ) ) {
      $error_message .= "問題内容が入力されていません。";
    }

    if ( ! isset( $_POST[ "question" ][ "answer" ] ) ) {
      $error_message .= "解答が入力されていません。";
    }

    if ( $error_message !== "" ) {
      $post -> post_status = "draft";
      $this -> update_post( $post );
      return;
    }

    if ( mb_strlen( $_POST[ "question" ][ "content" ] ) > 30 ) {
      $post -> post_title = mb_substr( $_POST[ "question" ][ "content" ], 0, 27 ) . "...";
    } else {
      $post -> post_title = $_POST[ "question" ][ "content" ];
    }

    update_post_meta( $post_id, "_lb_question_content", $_POST[ "question" ][ "content" ] );
    update_post_meta( $post_id, "_lb_question_answer",  $_POST[ "question" ][ "answer" ] );

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
      ! isset( $_POST[ "question-entry-nonce" ] )
    ) {
      return false;
    }

    //トークンが正規であることをチェックする。
    if ( ! wp_verify_nonce( $_POST[ "question-entry-nonce" ], "question-entry-action" ) ) {
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
}
