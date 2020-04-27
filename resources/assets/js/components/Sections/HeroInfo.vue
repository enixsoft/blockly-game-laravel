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
                <div class="row text-center">
                <div class="col-lg-6">
                    <img class="img-fluid" :src="$global.Url('img/character.png')">
                </div>
                <div class="col-lg-6">
                    <div class="row">
                        <HeroInfoItem divClass="col-lg-6" :heading="locales.heading1" imageFilename="thumbnail1.png" 
                                      :text="locales.text1"/>
                        <HeroInfoItem divClass="col-lg-6" :heading="locales.heading2" imageFilename="thumbnail2.png" 
                                      :text="locales.text2"/>
                    </div>
                    <div class="row">
                        <HeroInfoItem divClass="col-lg-6" :heading="locales.heading3" imageFilename="thumbnail3.png" 
                                      :text="locales.text3"/>
                        <HeroInfoItem divClass="col-lg-6" :heading="locales.heading4" imageFilename="thumbnail4.png" 
                                      :text="locales.text4"/>
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
import { heroInfo as locales } from '../Managers/LocaleManager';
export default { 
	data(){
		return {
			locales: this.$global.getLocalizedStrings(locales)
		};
	},        
	props: 
	{
		heading: String,
		text: String
	},     
	components:
	{
		HeroInfoItem
	}
};
</script>