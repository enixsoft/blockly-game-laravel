<template>
<div class="modal fade" :id="id" tabindex="-1" role="dialog"  data-backdrop="static" data-keyboard="false" aria-labelledby="centeredModalLabel" aria-hidden="true">
  <div class="vertical-alignment-helper">
  <div class="modal-dialog vertical-align-center" role="document">
    <div class="modal-content">
      <div class="modal-header" style="border-bottom: none;"></div>     
      <div class="modal-body">
         <div class="container">          
          <div class="row">
            <div :class="reportBug ? 'col-lg-12' : 'col-lg-6'">
              <br>
              <h1 id="modal-heading">{{ heading }}</h1> 
              <ModalReportBugForm v-if="reportBug"
					:max-length="reportBug.maxLength"
					:rows-length="reportBug.rowsLength"
					v-on:input="reportBugInput = $event.target.value"
					/>
					<p id="modal-text" v-html="modalText"></p>
            </div>  
            <div v-if="imageUrl" class="col-lg-6">
              <img class="img-fluid" :src="imageUrl" id="modal-image">
            </div>
          </div>            
          <br>
          <div class="row text-center">
				<ModalButton v-for="(button, index) in buttons"
				:div-class="`col-lg-${12/buttons.length} mx-auto`"
				:onclick="button.onclick"
				:text="button.text"
				:key="index" />
          </div>        
        </div>
      </div>
     <div class="modal-footer" style="border-top: none;"></div>     
    </div>
  </div>
</div>
</div>
</template>
<script>
import ModalReportBugForm from './ModalReportBugForm';
import ModalButton from './ModalButton';
export default {
	data(){
		return {
			reportBugInput: '',
			reportBugText: ''
		};
	},
	props:{
		id: String,
		heading: String,
		text: String,
		imageUrl: String,
		buttons: Array,
		reportBug: Object
	},
	components:{
		ModalReportBugForm,
		ModalButton
	},
	mounted() {
		console.log('Modal mounted.');
	},
	watch: {
		reportBugInput(){
			if(this.reportBugInput.length >= this.reportBug.maxLength)
			{        
				this.reportBugText = 'Dosiahli ste maximum povolených znakov.';
				return;
			}      	
			this.reportBugText = `Ešte môžete napísať ${( + this.reportBug.maxLength - this.reportBugInput.length)} znakov.`;
		}
	},
	computed: { 
		modalText()
		{
			if(this.reportBugText.length)
			{
				return this.reportBugText;
			}			
			return this.text;
		}
	}
};
</script>