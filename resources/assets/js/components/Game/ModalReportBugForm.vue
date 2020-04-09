<template>
	<div class="form-group">
	<label for="reportBugTextArea">Popis chyby:</label>
	<textarea class="form-control" :rows="rowsLength" :maxlength="maxLength" id="reportBugTextArea" v-on:input="$emit('input', $event)"></textarea>
	</div>
</template>
<script>
export default {	
	props: {
		maxLength: Number,
		rowsLength: Number
	}
};
</script>