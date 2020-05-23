<template>
<div class="h-100 w-100 d-flex flex-column align-items-center justify-content-center">
    <div>
        <h1> {{ title }} <br> {{ subtitle }}  </h1> 
        <a href="#game" class="btn btn-outline btn-xl js-scroll-trigger mb-2" v-on:click.prevent="scrollTo('#game')">{{ buttonText }}</a>
    </div>  
    <img :src="this.$global.Url(`img/${imageFileName}`)" class="img-fluid" style="border-radius: 25px; width: 75vh;">
</div>
</template>

<script>
import HistoryManager from '../Managers/HistoryManager';
export default {
	props:{
		title: String,
		subtitle: String,
		imageFileName: String,
		buttonText: String
	},
	methods:{
		scrollTo(hash){
			HistoryManager.scrollToHash(hash);
			//HistoryManager.changeView('home', undefined, '', '/' + this.$global.Url(hash).split('/').slice(3).join('/'));
		}
	}
};
</script>
