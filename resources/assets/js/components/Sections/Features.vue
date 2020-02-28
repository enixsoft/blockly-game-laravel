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
                <div class="row">
                <FeatureItem divClass="col-lg-4" iconClass="icon-screen-desktop" heading="Optimalizované pre PC" text="Hra nie je náročná na výkon počítača."/>
                <FeatureItem divClass="col-lg-4" iconClass="icon-cloud-upload" heading="Účet hráča" text="Postup hráča v úrovniach sa automaticky ukladá do databázy."/>
                <FeatureItem divClass="col-lg-4" iconClass="icon-clock" heading="Meranie času" text="Dĺžka trvania riešenia úloh je zaznamenávaná."/>
                </div>
                <div class="row">
                <FeatureItem divClass="col-lg-4" iconClass="icon-star"  heading="Hodnotenie" text="Riešenia úrovní sú hodnotené a je nutné dodržiavať zadanie."/>
                <FeatureItem divClass="col-lg-4" iconClass="icon-grid" heading="PlayCanvas" text="Herná časť je postavená na webovom hernom engine PlayCanvas."/>
                <FeatureItem divClass="col-lg-4" iconClass="icon-globe" heading="Webová téma" text="Pre webovú stránku bola použitá téma New Age založená na Bootstrap 4."/>
                </div>
            </div>
        </div>
    </div>
</div>
</section>       
</template> 
<script>
    import FeatureItem from './FeatureItem';
    export default { 
        props: 
        {
            heading: String,
            text: String
        },     
        components:
        {
            FeatureItem
        }
    }
</script>