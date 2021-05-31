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

        loadJSON();
    })

    //Her defineres variable til senere i brug ifm. fetch af data
    let keramiktype;
    let keramiktyper;

    //Her defineres konstanten med url'et, hvorfra json hentes
    const url = "http://malthekusk.one/kea/kaysenkeramik/wordpress/wp-json/wp/v2/keramiktype?per_page=100"

    //Her indhentes json fra rest API og sendes videre til funktionen showkeramiktyper
    async function loadJSON() {
        const JSONData = await fetch(url);
        keramiktyper = await JSONData.json();
        showKeramiktyper();
    }

    function showKeramiktyper() {
        console.log("showingkeramiktyper");
        console.log(keramiktyper);

        //Her defineres konstanter til brug i kloningen af template
        const template = document.querySelector("template");
        const container = document.querySelector(".container");

        //Loopet for kloningen af json-dataen
        keramiktyper.forEach(keramiktype => {
            console.log("looping");

            //Her defineres, klones og udfyldes templaten med json-data
            let clone = template.cloneNode(true).content;

            clone.querySelector("img").src = keramiktype.billede.guid;
            clone.querySelector("img").alt = keramiktype.kort;
            clone.querySelector("h3").textContent = keramiktype.navn;
            clone.querySelector("p").textContent = keramiktype.kort;
            clone.querySelector("article").addEventListener("click", () => {
                location.href = keramiktype.link;
            });

            //Her indsættes den klonen i DOM
            container.appendChild(clone);
        })
    }

</script>
<?php get_template_part( 'template-parts/footer-menus-widgets' ); ?>

<?php get_footer(); ?>
