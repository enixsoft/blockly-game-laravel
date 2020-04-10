<template>
<div class="h-100 w-100 d-flex flex-column align-items-center justify-content-center">
    <div>
        <h1> {{ title }} <br> {{ subtitle }}  </h1> 
        <a href="#game" class="btn btn-outline btn-xl js-scroll-trigger mb-2">Začnite hrať!</a>
    </div>  
    <img :src="this.$global.Url(`img/${imageFileName}`)" class="img-fluid" style="border-radius: 25px; width: 75vh;">
</div>
</template>

<script>
export default {
	props:{
		title: String,
		subtitle: String,
		imageFileName: String
	}
};
</script>
