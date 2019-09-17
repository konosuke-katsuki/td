<?php
if ( ! is_user_logged_in() ) {
  wp_redirect( home_url() . "/wp-login.php" );
  exit;
}
?>

<?php get_header(); ?>

<main class="main">

<?php if ( have_posts() ): while ( have_posts() ) : the_post(); ?>

<?php
$slug = get_query_var( 'pagename' );
$path = get_template_directory() . '/templates/page/' . $slug . '.php';
include $path;
?>

<?php endwhile; endif; ?>

</main>

<?php get_footer(); ?>
