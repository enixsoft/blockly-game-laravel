<template>    
<section class="features" id="features">
<div class="container">
    <div class="section-heading text-center">
        <h2>{{ getLocalizedString(locales.heading) }}</h2>
        <p class="text-muted">{{ getLocalizedString(locales.text) }}</p>
        <hr>
    </div>
    <div class="row">
        <div class="col-lg-12 my-auto">
            <div class="container-fluid">
                <div class="row">
                <FeatureItem divClass="col-lg-4" iconClass="icon-screen-desktop" :heading="getLocalizedString(locales.heading1)" :text="getLocalizedString(locales.text1)"/>
                <FeatureItem divClass="col-lg-4" iconClass="icon-cloud-upload" :heading="getLocalizedString(locales.heading2)" :text="getLocalizedString(locales.text2)"/>
                <FeatureItem divClass="col-lg-4" iconClass="icon-clock" :heading="getLocalizedString(locales.heading3)" :text="getLocalizedString(locales.text3)"/>
                </div>
                <div class="row">
                <FeatureItem divClass="col-lg-4" iconClass="icon-star"  :heading="getLocalizedString(locales.heading4)" :text="getLocalizedString(locales.text4)"/>
                <FeatureItem divClass="col-lg-4" iconClass="icon-grid" :heading="getLocalizedString(locales.heading5)" :text="getLocalizedString(locales.text5)"/>
                <FeatureItem divClass="col-lg-4" iconClass="icon-globe" :heading="getLocalizedString(locales.heading6)" :text="getLocalizedString(locales.text6)"/>
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
			locales,
			getLocalizedString: this.$global.getLocalizedString
		};
	},   
	components:
	{
		FeatureItem
	}   
};
</script>