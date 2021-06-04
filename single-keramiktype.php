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


    <section class="single-page">
        <div class="container-single">
            <div class="single-image">
                <div class="single-image-main">
                    <div class="single-image-container">
                        <img class="single-image-primary">
                    </div>
                </div>
                <div class="single-image-other">
                    <div class="single-image-container"><img class="single-image1"></div>
                    <div class="single-image-container"><img class="single-image2"></div>
                    <div class="single-image-container"><img class="single-image3"></div>
                    <div class="single-image-container"><img class="single-image4"></div>
                </div>
            </div>
            <div class="single-text">
                <div class="single-text-top">
                    <h2 class="single-text-title"></h2>
                    <p class="single-text-desc"></p>
                </div>
                <div class="single-text-box">
                    <p><b>Produktdetaljer</b></p>
                    <hr>
                    <p class="single-text-material"></p>
                    <p class="single-text-content"></p>
                    <p class="single-text-height"></p>
                    <p class="single-text-diameter"></p>
                    <p class="single-text-details"></p>
                    <div class="cup-sizes">
                        <img class="model1" src="https://malthekusk.one/kea/kaysenkeramik/wordpress/wp-content/uploads/2021/05/model1-3.svg" alt="keramik krus ikon af model 1">
                        <img class="model2" src="https://malthekusk.one/kea/kaysenkeramik/wordpress/wp-content/uploads/2021/05/model2.svg" alt="keramik krus ikon af model 2">
                        <img class="model3" src="https://malthekusk.one/kea/kaysenkeramik/wordpress/wp-content/uploads/2021/05/model3.svg" alt="keramik krus ikon af model 3">
                        <img class="model4" src="https://malthekusk.one/kea/kaysenkeramik/wordpress/wp-content/uploads/2021/05/model4.svg" alt="keramik krus ikon af model 4">
                    </div>
                </div>
            </div>
        </div>
        <div class="pink-divider"></div>
        <div class="container-other">
            <h2>Måske kan du lide</h2>
            <div class="container"></div>
        </div>
    </section>
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
    //Her defineres variable til senere i brug ifm. fetch af data
    let singlekeramik;
    let keramiktype;
    let keramiktyper;
    let aktuelkeramik = <?php echo get_the_ID() ?>;

    //Definerer en variabel til at tælle hvor mange gange loopet er kørt
    let counter = 0;

    const url = "https://malthekusk.one/kea/kaysenkeramik/wordpress/wp-json/wp/v2/keramiktype/" + aktuelkeramik;
    const urlOther = "https://malthekusk.one/kea/kaysenkeramik/wordpress/wp-json/wp/v2/keramiktype?per_page=100"

    document.addEventListener("DOMContentLoaded", () => {
        console.log("DOMContentLoaded");

        loadJSON();
    })

    async function loadJSON() {
        const data = await fetch(url);
        singlekeramik = await data.json();

        const dataOther = await fetch(urlOther);
        otherkeramik = await dataOther.json();

        showSingle();
        showOther();
    }

    function showSingle() {
        console.log("showingSingle", singlekeramik);

        document.querySelector(".single-image-primary").src = singlekeramik.billede.guid;
        document.querySelector(".single-image-primary").alt = singlekeramik.kort;

        document.querySelector(".single-text-title").textContent = singlekeramik.navn;
        document.querySelector(".single-text-desc").textContent = singlekeramik.lang;

        //Vis eller gem krus-størrelser
        if (singlekeramik.model == 1) {
            document.querySelector(".model1").src = "https://malthekusk.one/kea/kaysenkeramik/wordpress/wp-content/uploads/2021/06/Group-287.svg";
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
            document.querySelector(".single-text-content").style.display = "none";
        } else {
            document.querySelector(".single-text-content").textContent = `Kan indholde: ${singlekeramik.deciliter}`;
        }

        //Vis længde/bredde for artmoney og højde/diameter for andet
        if (singlekeramik.ktype == "Artmoney") {
            document.querySelector(".single-text-height").textContent = `Længde: ${singlekeramik.height}`;
            document.querySelector(".single-text-diameter").textContent = `Bredde: ${singlekeramik.diameter}`;
        } else {
            document.querySelector(".single-text-height").textContent = `Højde: ${singlekeramik.height}`;
            document.querySelector(".single-text-diameter").textContent = `Diameter: ${singlekeramik.diameter}`;
        }

        //Vis detaljer
        if (singlekeramik.guld == "1") {
            document.querySelector(".single-text-details").textContent = `Keramikken tåler maskinopvask. Dog vil guldet med tiden uundgåeligt blive slidt. Da produktet er dekoreret med ægte guld, kan det derfor ikke komme i mikroovnen.`;
        } else {
            document.querySelector(".single-text-details").textContent = `Keramikken tåler både maskinopvask og mikroovn.`
        }

        //Viser billede 1
        document.querySelector(".single-image1").src = singlekeramik.billede.guid;
        document.querySelector(".single-image1").alt = singlekeramik.kort;
        document.querySelector(".single-image1").addEventListener("click", replaceImage);

        //Viser kun billede 2 hvis objektet har et
        if (singlekeramik.billede2 == false) {
            document.querySelector(".single-image2").parentElement.style.display = "none";
        } else {
            document.querySelector(".single-image2").src = singlekeramik.billede2.guid;
            document.querySelector(".single-image2").alt = singlekeramik.kort;
            document.querySelector(".single-image2").addEventListener("click", replaceImage);
        }

        //Viser kun billede 3 hvis objektet har et
        if (singlekeramik.billede3 == false) {
            document.querySelector(".single-image3").parentElement.style.display = "none";
        } else {
            document.querySelector(".single-image3").src = singlekeramik.billede3.guid;
            document.querySelector(".single-image3").alt = singlekeramik.kort;
            document.querySelector(".single-image3").addEventListener("click", replaceImage);
        }

        //Viser kun billede 4 hvis objektet har et
        if (singlekeramik.billede4 == false) {
            document.querySelector(".single-image4").parentElement.style.display = "none";
        } else {
            document.querySelector(".single-image4").src = singlekeramik.billede4.guid;
            document.querySelector(".single-image4").alt = singlekeramik.kort;
            document.querySelector(".single-image4").addEventListener("click", replaceImage);
        }
    }

    function replaceImage() {
        console.log(`replacing primary image with image${this.src}`);

        //Erstatter det primære billede
        document.querySelector(".single-image-primary").src = this.src;

    }

    function showOther() {
        console.log("showingOther", otherkeramik);

        //Her defineres konstanter til brug i kloningen af template
        const template = document.querySelector("template");
        const container = document.querySelector(".container");


        //Loopet for kloningen af json-dataen
        otherkeramik.forEach(keramiktype => {
            console.log("looping");

            //Fortsætter kun ved andet navn og samme type
            if (singlekeramik.ktype == keramiktype.ktype && singlekeramik.navn != keramiktype.navn) {

                //Tilføjer 1 counter
                counter++;
                console.log(`Counters: ${counter}`);

                //Fortsætter kun hvis færre end 3 viste
                if (counter <= 3) {
                    //Her defineres, klones og udfyldes templaten med json-data
                    let clone = template.cloneNode(true).content;

                    clone.querySelector("img").src = keramiktype.billede.guid;
                    clone.querySelector("img").alt = keramiktype.kort;
                    clone.querySelector("h3").textContent = keramiktype.navn;
                    clone.querySelector("p").textContent = keramiktype.kort;
                    clone.querySelector("a").setAttribute("href", `${keramiktype.link}`);
                    clone.querySelector("article").addEventListener("click", () => {
                        location.href = keramiktype.link;
                    });

                    //Her indsættes den klonen i DOM
                    container.appendChild(clone);
                }
            }
        })
    }

</script>
<?php get_template_part( 'template-parts/footer-menus-widgets' ); ?>

<?php get_footer(); ?>
