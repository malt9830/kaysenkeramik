<?php
add_action( 'wp_enqueue_scripts', 'enqueue_important_files' );
function enqueue_important_files() {
/*Hent parent themes style.css*/
wp_enqueue_style( 'parent-style', get_template_directory_uri().'/style.css' );
}
?>
