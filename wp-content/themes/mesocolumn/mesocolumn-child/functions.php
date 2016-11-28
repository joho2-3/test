<?php
function meso_load_child_style() {
global $theme_version;
wp_enqueue_style( 'meso-child-css', get_stylesheet_directory_uri() . '/style.css', array(), $theme_version );
}
add_action( 'wp_enqueue_scripts', 'meso_load_child_style',99 );
?>