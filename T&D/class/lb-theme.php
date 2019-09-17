<?php

class Lb_Theme {

  public function __construct() {
    add_action( "pre_get_posts", [ $this, "restrict_browse" ] );

    add_filter( "query_vars",     [ $this, "add_query_vars" ] );
    // add_filter( "replace_editor", [ $this, "restrict_edit" ], 100, 2 );
  }

  /**
   * パブリッククエリ変数に新しい変数を追加する。
   *
   * @param array query_vars パブリッククエリ変数の配列
   *
   * @return array パブリッククエリ変数の配列
   */
  public function add_query_vars( $query_vars ) {
    $query_vars[] = "term_id";
    $query_vars[] = "user_control_action";
    return $query_vars;
  }

  /**
   * 投稿の作成者だけがその投稿を編集できるように制限する。
   *
   * @param boolean is_false エディターの置き換えを許可するかどうか
   * @param object  post     投稿オブジェクト
   *
   * @return boolean
   */
  public function restrict_edit( $is_false, WP_Post $post ) {
    if ( wp_get_current_user() -> ID != $post -> post_author ) {
      wp_die( __( 'Sorry, you are not allowed to edit this item.' ), 400 );
    }

    return false;
  }

  /**
   * 投稿リストにログインユーザーが作成した投稿だけを表示する。
   *
   * @param query
   */
  public function restrict_browse( $query ) {
    global $pagenow;

    if (
      ! is_admin() ||
      ! $query -> is_main_query() ||
      ! $pagenow === "edit.php"
    ) {
      return;
    }

    $query -> set( "author", wp_get_current_user() -> ID );
  }
}
