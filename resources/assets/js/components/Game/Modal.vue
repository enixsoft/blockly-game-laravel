<template>
<div class="modal fade" ref="centeredModal" tabindex="-1" role="dialog"  data-backdrop="static" data-keyboard="false" aria-labelledby="centeredModalLabel" aria-hidden="true">
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
              <ModalTextArea 				  
				  	v-if="reportBug"
					ref="modalTextArea"
				   :label="locales.textAreaLabel"
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
				:text="button.text"
				:key="index" 
				v-on:click="buttonOnClick(index)"				
				/>
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
import ModalTextArea from './ModalTextArea';
import ModalButton from './ModalButton';
import { modal as locales } from '../Managers/LocaleManager';
export default {
	data(){
		return {
			locales: this.$global.getLocalizedStrings(locales),
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
		ModalTextArea,
		ModalButton
	},
	watch: {
		reportBugInput(){
			if(this.reportBugInput.length >= this.reportBug.maxLength)
			{        
				this.reportBugText = this.locales.textAreaLimit;
				return;
			}      	
			this.reportBugText = `${this.locales.textAreaWarning} ${( + this.reportBug.maxLength - this.reportBugInput.length)} ${this.locales.textAreaCharacters}.`;
		}
	},
	computed: { 
		modalText()
		{
			if(this.reportBug && this.reportBugText.length)
			{
				return this.reportBugText;
			}			
			return this.text;
		}
	},
	methods: {
		buttonOnClick(index)
		{
			if(this.reportBug)
			{
				this.buttons[index].onclick(this.reportBugInput);			
				this.$refs.modalTextArea.clear();
				setTimeout(() => 
				{ this.reportBugInput = '';					
				}, 100);
				return;
			}
			this.buttons[index].onclick();
		}
	}
};
</script>