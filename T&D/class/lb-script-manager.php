<?php

class Lb_Script_Manager {

  private $theme_path;
  private $theme_url;
  private $version;

  public function __construct() {
    $this -> theme_path = get_template_directory();
    $this -> theme_url  = get_template_directory_uri();
    $this -> version    = date( "U" );

    add_action( "wp_enqueue_scripts",    [ $this, "front_enqueue_script" ] );
    add_action( "admin_enqueue_scripts", [ $this, "admin_enqueue_script" ] );
  }

  /**
   * フロントエンドページ用のcssファイル・jsファイルをロードする。
   *
   * @param  -
   * @return void
   */
  public function front_enqueue_script() {
    $reset_css_path  = $this -> theme_path . "/css/reset.css";
    $reset_css_url   = $this -> theme_url  . "/css/reset.css";
    $common_css_path = $this -> theme_path . "/css/my-common.css";
    $common_css_url  = $this -> theme_url  . "/css/my-common.css";
    $header_css_path = $this -> theme_path . "/css/header.css";
    $header_css_url  = $this -> theme_url  . "/css/header.css";

    wp_enqueue_script( "jquery" );

    $this -> enqueue_style( $reset_css_path,  "reset",     $reset_css_url,  [], $this -> version, "all" );
    $this -> enqueue_style( $common_css_path, "my-common", $common_css_url, [], $this -> version, "all" );
    $this -> enqueue_style( $header_css_path, "header",    $header_css_url, [], $this -> version, "all" );

    //フロントページ用のcssファイル・jsファイルをロードする。
    if ( is_front_page() ) {
      $css_path = $this -> theme_path . "/css/page/top.css";
      $css_url  = $this -> theme_url  . "/css/page/top.css";
      $js_path  = $this -> theme_path . "/js/page/top.js";
      $js_url   = $this -> theme_url  . "/js/page/top.js";

      $this -> enqueue_style( $css_path, "front-page", $css_url, [], $this -> version, "all" );

      $this -> enqueue_script( $js_path, "front-page", $js_url, [], $this -> version, true  );

      return;
    }

    //固定ページ用css・jsをロードする。
    if ( is_page() ) {
      $slug     = get_query_var( "pagename" );
      $css_path = $this -> theme_path . "/css/page/" . $slug . ".css";
      $css_url  = $this -> theme_url  . "/css/page/" . $slug . ".css";
      $js_path  = $this -> theme_path . "/js/page/"  . $slug . ".js";
      $js_url   = $this -> theme_url  . "/js/page/"  . $slug . ".js";

      $this -> enqueue_style( $css_path, $slug, $css_url, [], $this -> version, "all" );

      $this -> enqueue_script( $js_path, $slug, $js_url, [], $this -> version, true  );

      //デイリータスクページ
      if ( $slug === "daily-task" ) {
        $configs = [
          "url"    => admin_url( "admin-ajax.php" ),
          "action" => "update_daily_task",
          "nonce"  => wp_create_nonce( "unique_key" ),
        ];
        wp_localize_script( $slug, "configs", $configs );
      }

      return;
    }

    return;
  }

  /**
   * 管理画面用のcssファイル・jsファイルをロードする。
   *
   * @param  -
   * @return void
   */
  public function admin_enqueue_script() {
    global $post_type, $pagenow;

    //投稿編集画面
    if ( $pagenow === "post.php" || $pagenow === "post-new.php" ) {
      $css_path = $this -> theme_path . "/css/admin/post/" . $post_type . ".css";
      $css_url  = $this -> theme_url  . "/css/admin/post/" . $post_type . ".css";

      $this -> enqueue_style( $css_path, "qwerty", $css_url, [], $this -> version, "all" );

      return;
    }

    return;
  }

  /**
   * jsファイルをキューイングする。
   *
   * @param  path      jsファイルのpath
   * @param  handle    jsファイルのハンドル名
   * @param  src       jsファイルのURL
   * @param  deps      jsファイルが依存する他のjsファイルのハンドル配列
   * @param  var       jsファイルのバージョン
   * @param  in_footer jsファイルをロードするlinkタグをbodyタグ終了前に置くかどうか
   * @return void
   */
  public function enqueue_script( $path, $handle, $src, $deps, $ver, $in_footer ) {
    if ( file_exists( $path ) ) {
      wp_enqueue_script( $handle, $src, $deps, $var, $in_footer );
    }

    return;
  }

  /**
   * cssファイルをキューイングする。
   *
   * @param  path   cssファイルのpath
   * @param  handle cssファイルのハンドル名
   * @param  src    cssファイルのURL
   * @param  deps   cssファイルが依存する他のcssファイルのハンドル配列
   * @param  var    cssファイルのバージョン
   * @param  media  cssファイルのメディア
   * @return void
   */
  public function enqueue_style( $path, $handle, $src, $deps, $ver, $media ) {
    if ( file_exists( $path ) ) {
      wp_enqueue_style( $handle, $src, $deps, $ver, $media );
    }

    return;
  }
}
