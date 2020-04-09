<template>
 <div :class="divClass">
	<button type="button" id="modal-button" class="btn btn-success btn-lg" data-dismiss="modal" v-on:click="$emit('click', $event)">
		{{ text }}
	</button> 
	</div>
</template>
<script>
export default {
	props: {
		divClass: String,
		text: String
	}
};
</script>