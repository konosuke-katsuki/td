<?php get_header(); ?>

<?php
$file_name = $_SERVER['DOCUMENT_ROOT'] . "/log/log.txt";
echo $file_name;
file_put_contents( $file_name, "test2" );
?>

<?php get_footer(); ?>
