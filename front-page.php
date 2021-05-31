<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package WordPress
 * @subpackage Twenty_Twenty
 * @since Twenty Twenty 1.0
 */

get_header();
?>
<style>
    .entry-header {
        display: none;
    }

    .entry-content figure:first-of-type {
        margin-top: 0 !important;
    }

</style>
<main id="site-content" role="main">

    <?php

	if ( is_search() ) {
		global $wp_query;

		$archive_title = sprintf(
			'%1$s %2$s',
			'<span class="color-accent">' . __( 'Search:', 'twentytwenty' ) . '</span>',
			'&ldquo;' . get_search_query() . '&rdquo;'
		);

		if ( $wp_query->found_posts ) {
			$archive_subtitle = sprintf(
				/* translators: %s: Number of search results. */
				_n(
					'We found %s result for your search.',
					'We found %s results for your search.',
					$wp_query->found_posts,
					'twentytwenty'
				),
				number_format_i18n( $wp_query->found_posts )
			);
		} else {
			$archive_subtitle = __( 'We could not find any results for your search. You can give it another try through the search form below.', 'twentytwenty' );
		}
	} elseif ( is_archive() && ! have_posts() ) {
		$archive_title = __( 'Nothing Found', 'twentytwenty' );
	} elseif ( ! is_home() ) {
		$archive_title    = get_the_archive_title();
		$archive_subtitle = get_the_archive_description();
	}

	if ( have_posts() ) {

		$i = 0;

		while ( have_posts() ) {
			$i++;
			if ( $i > 1 ) {
				echo '<hr class="post-separator styled-separator is-style-wide section-inner" aria-hidden="true" />';
			}
			the_post();

			get_template_part( 'template-parts/content', get_post_type() );

		}
	} elseif ( is_search() ) {
		?>

    <div class="no-search-results-form section-inner thin">

        <?php
			get_search_form(
				array(
					'label' => __( 'search again', 'twentytwenty' ),
				)
			);
			?>

    </div><!-- .no-search-results -->

    <?php
	}
	?>

    <?php get_template_part( 'template-parts/pagination' ); ?>
    <template>
        <article class="article">
            <div class="top">
                <img class="image">
                <div class="text">
                    <h3></h3>
                    <p></p>
                </div>
            </div>
            <div class="bottom">
                <a class="button-dark">LÆS MERE</a>
            </div>
        </article>
    </template>
</main><!-- #site-content -->
<script>
    document.addEventListener("DOMContentLoaded", () => {
        console.log("DOMContentLoaded");

        loadJSON();
    })

    //Her defineres variable til senere i brug ifm. fetch af data
    let keramiktype;
    let keramiktyper;

    //Definerer en variabel til at tælle hvor mange gange loopet er kørt
    let counter = 0;

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

            //Tilføjer én counter og tjekker om loopet skal fortsættes eller stoppes, således kun 3 kloner indsættes i DOM
            counter++;
            console.log(counter);

            if (counter <= 3) {
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
            }
        })
    }

</script>
<?php get_template_part( 'template-parts/footer-menus-widgets' ); ?>

<?php
get_footer();
