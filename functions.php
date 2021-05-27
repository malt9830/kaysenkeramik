<?php
add_action( 'wp_enqueue_scripts', 'enqueue_important_files' );
function enqueue_important_files() {
/*hent parent stylesheet i parenttemaets mappe*/
wp_enqueue_style( 'parent-style', get_template_directory_uri().'/style.css' );
}
?>

<?php
add_action( 'wp_enqueue_scripts', 'my_theme_enqueue_styles' );
function my_theme_enqueue_styles() {
    wp_enqueue_style( 'child-style', get_stylesheet_uri() );
}
?>

<?php
function wpb_add_google_fonts() {
   wp_enqueue_style( 'wpb-google-fonts', 'https://fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css2?family=Archivo+Narrow:wght@400;500&family=Montserrat:wght@100;300;400;700&family=Raleway:wght@300;400;700&display=swap', false );
   }

   add_action( 'wp_enqueue_scripts', 'wpb_add_google_fonts' );
?>
