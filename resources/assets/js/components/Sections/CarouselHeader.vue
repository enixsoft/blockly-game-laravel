<template>
<header class="masthead">
        <div class="container-fluid h-100">
        <div class="row h-100">
        <div id="carousel"  class="carousel slide h-100 w-100" data-ride="carousel" data-interval="6000" data-pause="hover">
            <ul class="carousel-indicators">
                <li data-target="#carousel" data-slide-to="0" class="active"></li>
                <li data-target="#carousel" data-slide-to="1"></li>
                <li data-target="#carousel" data-slide-to="2"></li>
            </ul>
            <div class="carousel-inner h-100" style="text-align: center;"> 
                <div class="carousel-item h-100 active">
                <CarouselItem :title="getLocalizedString(locales.title1)" :subtitle="getLocalizedString(locales.subtitle1)" :button-text="getLocalizedString(locales.buttonText)"  imageFileName="carousel-1.png" />
                </div>
                <div class="carousel-item h-100" >
                <CarouselItem :title="getLocalizedString(locales.title2)" :subtitle="getLocalizedString(locales.subtitle2)" :button-text="getLocalizedString(locales.buttonText)"  imageFileName="carousel-2.png" />
                </div>
                <div class="carousel-item h-100" >
                <CarouselItem :title="getLocalizedString(locales.title3)" :subtitle="getLocalizedString(locales.subtitle3)" :button-text="getLocalizedString(locales.buttonText)"  imageFileName="carousel-3.png" />
                 </div>
            </div>
            <a class="carousel-control-prev" href="#carousel" data-slide="prev">
            <span class="carousel-control-prev-icon"></span>
            </a>
            <a class="carousel-control-next" href="#carousel" data-slide="next">
            <span class="carousel-control-next-icon"></span>
            </a>
        </div>
    </div>
    </div>
</header>
</template>

<script>
import CarouselItem from './CarouselItem';
import { carousel as locales } from '../Managers/LocaleManager';
export default {
	data(){
		return {
			locales,
			getLocalizedString: this.$global.getLocalizedString
		};
	},
	components: {
		CarouselItem
	}        
};
</script>
