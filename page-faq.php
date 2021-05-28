<?php
/**
 * The template for displaying single posts and pages.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package WordPress
 * @subpackage Twenty_Twenty
 * @since Twenty Twenty 1.0
 */

get_header();
?>

<main id="site-content" role="main">

    <?php

	if ( have_posts() ) {

		while ( have_posts() ) {
			the_post();

			get_template_part( 'template-parts/content', get_post_type() );
		}
	}

	?>

</main><!-- #site-content -->
<script>
    document.addEventListener("DOMContentLoaded", () => {
        console.log("DOMContentLoaded");

        //Tilføjer en event listeners til alle FAQ-titlerne, der udfolder dem
        document.querySelectorAll(".faq-header").forEach(faqheader => {
            faqheader.addEventListener("click", expandFAQ);
        })

    })

    function expandFAQ() {
        console.log(`expandingFAQ`);


        //Definerer indholdet og ikoner til brug i nedenfor
        let content = this.parentElement.lastElementChild;
        let icon = this.firstElementChild.lastElementChild;

        //Ændrer plus til minus eller omvendt afhængigt af boolen
        if (content.classList.contains("faq-expanded")) {
            icon.setAttribute("src", "http://malthekusk.one/kea/kaysenkeramik/wordpress/wp-content/uploads/2021/05/Group-85-1.svg")
        } else {
            icon.setAttribute("src", "http://malthekusk.one/kea/kaysenkeramik/wordpress/wp-content/uploads/2021/05/Group-186.svg");
        }

        //Toggler klassen på indholdet, der skjuler og viser den
        content.classList.toggle("faq-expanded");
        content.offsetHeight;
    }

</script>
<?php get_template_part( 'template-parts/footer-menus-widgets' ); ?>

<?php get_footer(); ?>
