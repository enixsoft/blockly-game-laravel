<template>
	<div class="form-group">
	<label for="modal-textarea">{{ label }}</label>
	<textarea class="form-control" :rows="rowsLength" :maxlength="maxLength" ref="textarea" id="modal-textarea" v-on:input="$emit('input', $event)"></textarea>
	</div>
</template>
<script>
export default {	
	props: {
		label: String,
		maxLength: Number,
		rowsLength: Number
	},
	methods: {
		clear()
		{
			this.$refs.textarea.value = '';
		}
	}
};
</script>