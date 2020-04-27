<template>    
<section class="features" id="features">
<div class="container">
    <div class="section-heading text-center">
        <h2>{{ locales.heading }}</h2>
        <p class="text-muted">{{ locales.text }}</p>
        <hr>
    </div>
    <div class="row">
        <div class="col-lg-12 my-auto">
            <div class="container-fluid">
                <div class="row">
                <FeatureItem divClass="col-lg-4" iconClass="icon-screen-desktop" :heading="locales.heading1" :text="locales.text1"/>
                <FeatureItem divClass="col-lg-4" iconClass="icon-cloud-upload" :heading="locales.heading2" :text="locales.text2"/>
                <FeatureItem divClass="col-lg-4" iconClass="icon-clock" :heading="locales.heading3" :text="locales.text3"/>
                </div>
                <div class="row">
                <FeatureItem divClass="col-lg-4" iconClass="icon-star"  :heading="locales.heading4" :text="locales.text4"/>
                <FeatureItem divClass="col-lg-4" iconClass="icon-grid" :heading="locales.heading5" :text="locales.text5"/>
                <FeatureItem divClass="col-lg-4" iconClass="icon-globe" :heading="locales.heading6" :text="locales.text6"/>
                </div>
            </div>
        </div>
    </div>
</div>
</section>       
</template> 
<script>
import FeatureItem from './FeatureItem';
import { features as locales } from '../Managers/LocaleManager';
export default { 	 
	data(){
		return {
			locales: this.$global.getLocalizedStrings(locales)			
		};
	},   
	components:
	{
		FeatureItem
	}   
};
</script>