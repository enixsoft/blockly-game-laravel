<template>
<div :class="divClass">
    <h3>{{ heading }}</h3>
    <img :src="$global.Url('img/' + imageFilename)" class="img-thumbnail">
    <p class="text-muted">{{ text }}</p>
</div>
</template>
<script>
export default {
	props:
	{
		divClass: String,
		heading: String,
		imageFilename: String,
		text: String
	}    
};
</script>