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

    <section class="container-single">
        <div class="single-image">
            <div class="single-image-main">
                <img>
            </div>
            <div class="single-image-other">
                <img class="single-image2">
                <img class="single-image3">
                <img class="single-image4">
            </div>
        </div>
        <div class="single-text">
            <h2 class="single-text-title"></h2>
            <p class="single-text-desc"></p>
            <p class="single-text-material"></p>
            <p class="single-text-content"></p>
            <p class="single-text-height"></p>
            <p class="single-text-diameter"></p>
            <div class="cup-sizes">
                <img class="model1" src="https://malthekusk.one/kea/kaysenkeramik/wordpress/wp-content/uploads/2021/05/model1-3.svg" alt="keramik krus ikon af model 1">
                <img class="model2" src="https://malthekusk.one/kea/kaysenkeramik/wordpress/wp-content/uploads/2021/05/model2.svg" alt="keramik krus ikon af model 2">
                <img class="model3" src="https://malthekusk.one/kea/kaysenkeramik/wordpress/wp-content/uploads/2021/05/model3.svg" alt="keramik krus ikon af model 3">
                <img class="model4" src="https://malthekusk.one/kea/kaysenkeramik/wordpress/wp-content/uploads/2021/05/model4.svg" alt="keramik krus ikon af model 4">
            </div>
        </div>
        <div class="pink-divider"></div>
    </section>
    <section>

    </section>

</main><!-- #site-content -->
<script>
    let singlekeramik;
    let keramiktyper;
    let aktuelkeramik = <?php echo get_the_ID() ?>;
    const url = "https://malthekusk.one/kea/kaysenkeramik/wordpress/wp-json/wp/v2/keramiktype/" + aktuelkeramik;

    document.addEventListener("DOMContentLoaded", () => {
        console.log("DOMContentLoaded");

        loadJSON();
    })

    async function loadJSON() {
        const data = await fetch(url);
        singlekeramik = await data.json();

        showSingle();
    }

    function showSingle() {
        console.log(singlekeramik);

        document.querySelector(".single-image-main img").src = singlekeramik.billede.guid;

        document.querySelector(".single-text-title").textContent = singlekeramik.navn;
        document.querySelector(".single-text-desc").textContent = singlekeramik.lang;

        //Markér den givne krus-størrelse for objektet eller skjul krusene hvis objektet ikke er et krus
        if (singlekeramik.model == 1) {
            document.querySelector(".model1").src = "https://malthekusk.one/kea/kaysenkeramik/wordpress/wp-content/uploads/2021/06/Group-287.svg"
        } else if (singlekeramik.model == 2) {
            document.querySelector(".model2").src = "https://malthekusk.one/kea/kaysenkeramik/wordpress/wp-content/uploads/2021/06/Group-250.svg"
        } else if (singlekeramik.model == 3) {
            document.querySelector(".model3").src = "https://malthekusk.one/kea/kaysenkeramik/wordpress/wp-content/uploads/2021/06/Group-303.svg"
        } else if (singlekeramik.model == 4) {
            document.querySelector(".model4").src = "https://malthekusk.one/kea/kaysenkeramik/wordpress/wp-content/uploads/2021/06/Group-259.svg"
        } else {
            console.log("Skjul krus-modeller")
            document.querySelector(".cup-sizes").classList.add("none");
        }

        //Vis materiale
        document.querySelector(".single-text-material").textContent = `Materiale: ${singlekeramik.materiale}`;

        //Viser kun indhold, hvis det er et objekt med fyld
        if (singlekeramik.deciliter == "") {
            document.querySelector(".single-text-content").setAttribute("display", "none")
        } else {
            document.querySelector(".single-text-content").textContent = `Kan indholde: ${singlekeramik.deciliter}`;
        }

        //Vis længde for artmoney og højde for andet
        if (singlekeramik.ktype == "Artmoney") {
            document.querySelector(".single-text-height").textContent = `Længde: ${singlekeramik.height}`;
        } else {
            document.querySelector(".single-text-height").textContent = `Højde: ${singlekeramik.height}`;
        }

        //Vis bredde for artmoney og diameter for andet
        if (singlekeramik.ktype == "Artmoney") {
            document.querySelector(".single-text-diameter").textContent = `Bredde: ${singlekeramik.diameter}`;
        } else {
            document.querySelector(".single-text-diameter").textContent = `Diameter: ${singlekeramik.diameter}`;
        }

        //Viser kun billede 2 hvis objektet har et
        if (singlekeramik.billede2 == false) {
            document.querySelector(".single-image2").setAttribute("display", "none");
        } else {
            document.querySelector(".single-image2").src = singlekeramik.billede2.guid;
        }

        //Viser kun billede 3 hvis objektet har et
        if (singlekeramik.billede3 == false) {
            document.querySelector(".single-image3").setAttribute("display", "none");
        } else {
            document.querySelector(".single-image3").src = singlekeramik.billede3.guid;
        }

        //Viser kun billede 4 hvis objektet har et
        if (singlekeramik.billede4 == false) {
            document.querySelector(".single-image4").setAttribute("display", "none");
        } else {
            document.querySelector(".single-image4").src = singlekeramik.billede4.guid;
        }

    }

</script>
<?php get_template_part( 'template-parts/footer-menus-widgets' ); ?>

<?php get_footer(); ?>
