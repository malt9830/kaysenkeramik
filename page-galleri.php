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

        document.querySelectorAll(".filter-clay").forEach(clayFilter => {
            clayFilter.addEventListener("click", filterClay)
        })

        loadJSON();
    })

    //Her defineres variable til senere i brug ifm. fetch af data
    let keramiktype;
    let keramiktyper;

    //Her defineres variable til filtre til senere brug
    let clayFilterAll = true;
    let clayFilterLight = "";
    let clayFilterDark = "";
    let clayFilterPorcelain = "";
    let clayFilterRecycle = "";

    //Her defineres konstanten med url'et, hvorfra json hentes
    const url = "https://malthekusk.one/kea/kaysenkeramik/wordpress/wp-json/wp/v2/keramiktype?per_page=100"

    //Her indhentes json fra rest API og sendes videre til funktionen showkeramiktyper
    async function loadJSON() {
        const JSONData = await fetch(url);
        keramiktyper = await JSONData.json();
        showKeramiktyper();
    }

    function filterClay() {
        console.log(this.dataset.materiale);


        if (this.dataset.materiale == "Lys stentøjsler" && this.classList.contains("filter-clay-active")) {
            console.log("lightFilterOff");
            clayFilterLight = "";
        } else if (this.dataset.materiale == "Lys stentøjsler") {
            console.log("lightFilterOn");
            clayFilterLight = this.dataset.materiale;
        }

        if (this.dataset.materiale == "Mørk stentøjsler" && this.classList.contains("filter-clay-active")) {
            console.log("darkFilterOff");
            clayFilterDark = "";
        } else if (this.dataset.materiale == "Mørk stentøjsler") {
            console.log("darkFilterOn");
            clayFilterDark = this.dataset.materiale;
        }

        if (this.dataset.materiale == "Porcelænsler" && this.classList.contains("filter-clay-active")) {
            console.log("porcelainFilterOn");
            clayFilterPorcelain = "";
        } else if (this.dataset.materiale == "Porcelænsler") {
            console.log("porcelainFilterOn");
            clayFilterPorcelain = this.dataset.materiale;
        }

        if (this.dataset.materiale == "Genbrugsler" && this.classList.contains("filter-clay-active")) {
            console.log("recycleFilterOn");
            clayFilterRecycle = "";
        } else if (this.dataset.materiale == "Genbrugsler") {
            console.log("recycleFilterOn");
            clayFilterRecycle = this.dataset.materiale;
        }

        this.classList.toggle("filter-clay-active");

        if (clayFilterLight == "" && clayFilterDark == "" && clayFilterPorcelain == "" && clayFilterRecycle == "") {
            clayFilterAll = true;
        } else {
            clayFilterAll = false;
        }

        showKeramiktyper();
    }

    function showKeramiktyper() {
        console.log(`clayFilterLight: ${clayFilterLight}`);
        console.log(`clayFilterDark: ${clayFilterDark}`);
        console.log(`ClayFilterAll: ${clayFilterAll}`);

        //Her defineres konstanter til brug i kloningen af template
        const template = document.querySelector("template");
        const container = document.querySelector(".container");

        container.textContent = " ";

        //Loopet for kloningen af json-dataen
        keramiktyper.forEach(keramiktype => {
            if (clayFilterAll == true || clayFilterLight == keramiktype.materiale || clayFilterDark == keramiktype.materiale || clayFilterPorcelain == keramiktype.materiale || clayFilterRecycle == keramiktype.materiale) {
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
            }
        })
    }

</script>
<?php get_template_part( 'template-parts/footer-menus-widgets' ); ?>

<?php get_footer(); ?>
