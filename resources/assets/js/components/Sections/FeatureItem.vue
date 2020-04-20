<template>
<div :class="divClass">
    <div class="feature-item">
        <i class="text-primary" :class="iconClass"></i>
        <h3>{{ heading }} </h3>
        <p class="text-muted">{{ text }}</p>
    </div>
</div>
</template>
<script>
export default {
	props: {
		divClass: String,
		iconClass: String,
		heading: String,
		text: String
	},
};
</script>
