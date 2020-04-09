<template>
 <div :class="divClass">
	<button type="button" id="modal-button" class="btn btn-success btn-lg" data-dismiss="modal" v-on:click="onclick">
		{{ text }}
	</button> 
	</div>
</template>
<script>
export default {
	props: {
		divClass: String,
		onclick: Function,
		text: String
	}
};
</script>