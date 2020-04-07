import * as $ from 'jquery';
import {getModalImageLink,convertCodeForModal,convertDateToTime,convertRatingToStars} from '../Game/Common';

let modals = undefined;
let ajaxError = false;
let availableModal = 1;

function enableModals(modalsObj){
	modals = modalsObj;
	ajaxError = false;
	availableModal = 1;
}

function setAjaxError(){
	ajaxError = true;
}

function setModalParameters(modal, title, text, image, buttonOnclick, buttonText){
	modal.find('#modal-heading').html(title).end();
	modal.find('#modal-text').html(text).end();
	modal.find('#modal-image').attr('src', image).end(); 
	modal.find('#modal-button').attr('onclick', buttonOnclick).end();
	modal.find('#modal-button').html(buttonText).end();   
}

function showDynamicModal(type, modalStructure)
{
	setTimeout(() => {
		const modal = createDynamicModal(type, modalStructure);
		modal.modal('show'); 
	},500);  
}

function createDynamicModal(type, modalStructure)
{
	let modal = '';
	let html = '';

	if(availableModal==1)
	{
		availableModal=2;
		modal = $('#centeredModal1').modal();
	}
	else
	{
		availableModal=1;
		modal = $('#centeredModal2').modal();
	}

	if(ajaxError)
	{
		type = 'ajaxError';
		modalStructure.title = modals['ajaxerror'].modal.title;  
		modalStructure.text = modals['ajaxerror'].modal.text;  
		modalStructure.image = getModalImageLink(modals['ajaxerror'].modal.image, 'common');  
	}    

	switch(type)
	{

	case 'levelIntroduced':
	{
		setModalParameters(modal, modalStructure.title, modalStructure.text, modalStructure.image, `mainTaskIntroduced('${modalStructure.task}')`,'Pokračovať');
		break;
	}

	case 'mainTaskIntroduced':
	{
		setModalParameters(modal, modalStructure.title, modalStructure.text, modalStructure.image, 'continueGame()','Pokračovať');
		break;
	}

	case 'mainTaskShowed':
	{
		setModalParameters(modal, modalStructure.title, modalStructure.text, modalStructure.image, '', 'Pokračovať');
		break;
	}

	case 'mainTaskCompleted':
	{
		html = modalStructure.text;

		let task_elapsed_time = this.task_end - this.task_start; 
		task_elapsed_time = convertDateToTime(task_elapsed_time);

		html += '<br><br> <h4><i class="fas fa-stopwatch"></i> Čas:</h4>'+ task_elapsed_time;
		html += '<br><br> <h4><a data-toggle="collapse" href="#collapseCode"><i class="fas fa-code"></i> Kód:</a></h4>';
		html += '<div class="collapse" id="collapseCode">';
		html += '<div><code>';
		html += convertCodeForModal();
		html += '</div></code>';
		html += '</div>';
		html += '<br><br> <h4><i class="fas fa-star-half-alt"></i> Hodnotenie:</h4>' + convertRatingToStars();

		setModalParameters(modal, modalStructure.title, html, modalStructure.image, 'continueGame()', 'Pokračovať');
		break;
	}


	case 'mainTaskFailed':
	{
		setModalParameters(modal, modalStructure.title, modalStructure.text, modalStructure.image, 'loadGame()', 'Skúsiť znova');
		break;
	}

	case 'ajaxError':
	{
		// TO DO CHANGE VIEW TO HOME
		// html = 'window.location.href=\''; 
		// html += '{{ url('/')}}' + '\';'; 

		setModalParameters(modal, modalStructure.title, modalStructure.text, modalStructure.image, html, 'Ukončiť hru');
		break;
	}


	case 'allMainTasksFinished':
	{
		// TO DO FIX
		// html = 'window.location.href=\''; 
		// html += '{{ url('/')}}' + '/start/' + this.category + '/' + (this.level+1) + '\';';    
 
		setModalParameters(modal, modalStructure.title, modalStructure.text, modalStructure.image, html, 'Ďalšia úroveň');
		break;
	}

	}  

	return modal;

	//modal.modal('show'); 
}

export default { enableModals, setAjaxError, showDynamicModal };