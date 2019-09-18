<?php

class Lb_User_Manager {

  public function __construct() {
    add_action( 'init',               [ $this, "add_rewrite_rule" ] );
    add_action( "after_switch_theme", [ $this, "flush_rewrite_rules" ] );
    add_action( "after_switch_theme", [ $this, "add_roles" ] );
    add_action( 'template_redirect',  [ $this, 'front_controller' ] );
    add_action( "lb_user_register",   [ $this, "register_user" ] );
    add_action( 'wp_enqueue_scripts', [ $this, "enqueue_scripts" ] );
  }

  public function front_controller() {
    $action = get_query_var( "user_control_action" );

    switch ( $action ) {
      case "register":
        do_action( "lb_user_register" );
        break;
    }
  }

  public function add_roles() {
    $capabilities = [
      "delete_others_posts"    => true,
      "delete_posts"           => true,
      "delete_private_posts"   => true,
      "delete_published_posts" => true,
      "edit_others_posts"      => true,
      "edit_posts"             => true,
      "edit_private_posts"     => true,
      "edit_published_posts"   => true,
      "manage_categories"      => true,
      "publish_posts"          => true,
      "read_private_posts"     => true,
      "read"                   => true
    ];
    add_role( "member", "メンバー", $capabilities );
  }

  public function add_rewrite_rule() {
    add_rewrite_rule( '^user/([^/]+)/?', 'index.php?user_control_action=$matches[1]', 'top' );
  }

  public function flush_rewrite_rules() {
    $this -> add_rewrite_rule();
    flush_rewrite_rules();
  }

  public function register_user() {
    if ( is_user_logged_in() ) {
      wp_redirect( home_url() );
      exit;
    }

    if ( $_SERVER['REQUEST_METHOD'] !== 'POST' ) {
      include get_template_directory() . "/views/register-user.php";
      return;
    }

    if ( $_SERVER['REQUEST_METHOD'] === 'POST' ) {
      $errors = [];

      if ( ! isset( $_POST[ "user-name" ] ) || empty( $_POST[ "user-name" ] ) ) {
        $errors[] = "ユーザー名が入力されていません。";
      }
      $user_name = $_POST[ "user-name" ];

      if ( ! isset( $_POST[ "password" ] ) || empty( $_POST[ "password" ] ) ) {
        $errors[] = "パスワードが入力されていません。";
      }
      $password = $_POST[ "password" ];

      if ( ! isset( $_POST[ "email" ] ) || empty( $_POST[ "email" ] ) ) {
        $errors[] = "Eメールが入力されていません。";
      }
      $email = $_POST[ "email" ];

      if ( ! empty( $errors ) ) {
        include get_template_directory() . "/views/register-user.php";
        return;
      }

      $sanitized_user_name = sanitize_user( $user_name );

      if ( empty( $sanitized_user_name ) || ! validate_username( $user_name ) || username_exists( $sanitized_user_name ) ) {
        $errors[] = "入力されたユーザー名が無効です。";
      }

      if ( ! is_email( $email ) || email_exists( $email ) ) {
        $errors[] = "入力されたEメールが無効です。";
      }

      if ( ! empty( $errors ) ) {
        include get_template_directory() . "/views/register-user.php";
        return;
      }

      $user_data = [
        "user_pass"  => $password,
        "user_login" => $sanitized_user_name,
        "user_email" => $email,
        "role"       => "member",
      ];

      $user_id = wp_insert_user( $user_data );

      if ( is_wp_error( $user_id ) ) {
        wp_die( __( 'ユーザー登録に失敗しました。' ), 400 );
      } else {
        $success_message = "ユーザー登録が完了しました。";
        include get_template_directory() . "/views/register-user.php";
        return;
      }
    }

    include get_template_directory() . "/views/register-user.php";
  }

  public function enqueue_scripts() {
    wp_enqueue_style( "register-user", get_template_directory_uri() . "/css/views/register-user.css" , [], "1.0", "all" );
  }
}
?>
