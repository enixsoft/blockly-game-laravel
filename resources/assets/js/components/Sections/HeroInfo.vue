<template>
<section class="features" id="features">
<div class="container">
    <div class="section-heading text-center">
        <h2>{{ heading }}</h2>
        <p class="text-muted">{{ text }}</p>
        <hr>
    </div>
    <div class="row">
        <div class="col-lg-12 my-auto">
            <div class="container-fluid">
                <div class="row text-center">
                <div class="col-lg-6">
                    <img class="img-fluid" src="img/character.png">
                </div>
                <div class="col-lg-6">
                    <div class="row">
                        <HeroInfoItem divClass="col-lg-6" heading="Preskočí prekážky" imageFilename="thumbnail1.png" 
                                      text="Keď je v ceste voda alebo nastražená pasca, hrdina ich často dokáže preskočiť a pokračovať ďalej."/>
                        <HeroInfoItem divClass="col-lg-6" heading="Zničí veci" imageFilename="thumbnail2.png" 
                                      text="V ruinách hradu sa nachádza veľa starých vecí ako sú krabice, sudy a vázy, ktoré hrdinov meč dokáže zničiť a uvoľniť cestu."/>
                    </div>
                    <div class="row">
                        <HeroInfoItem divClass="col-lg-6" heading="Otvára truhlice" imageFilename="thumbnail3.png" 
                                      text="Niekedy hrdina potrebuje prehľadať truhlice, aby našiel kľúč od zamknutých dverí."/>
                        <HeroInfoItem divClass="col-lg-6" heading="Používa páky" imageFilename="thumbnail4.png" 
                                      text="Keď treba otvoriť padacie dvere alebo zneškodniť pasce, hrdina použije páku."/>
                    </div>
                </div>
                </div>
            </div>
        </div>
    </div>
</div>
</section>
</template>
<script>
    import HeroInfoItem from './HeroInfoItem';
    export default {         
        props: 
        {           
            heading: String,
            text: String
        },     
        components:
        {
            HeroInfoItem
        }
    }
</script>