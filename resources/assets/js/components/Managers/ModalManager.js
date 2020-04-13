import * as $ from 'jquery';
import {convertCodeForModal, convertDateToTime, convertRatingToStars} from './Common';

let modalsArray = undefined; //TO DO maybe one modal object and modal DOM element ref is enough?
let modalsImageUrl = undefined;
let modalError = undefined;
let isError = false;
let availableModal = 1;

function enableModals(modalsArr, modalsUrl, errorModalData, reportBugModalFunction){
	modalsArray = modalsArr;
	modalsImageUrl = modalsUrl;
	modalsArray.push(createGameplayModal('centeredModal0'), createGameplayModal('centeredModal1'), createReportBugModal('reportBugModal', reportBugModalFunction));
	modalError = errorModalData;
	availableModal = 1;
}

function createGameplayModal(id){
	return {
		id,
		heading: '',
		text: '',
		imageUrl: '',
		buttons:[{
			onclick: () => {},
			text: ''
		}]
	};
}

function createReportBugModal(id, reportBugModalFunction){
	return {
		id,
		heading: 'Nahlásiť chybu',
		text: 'Môžete napísať 1000 znakov.',
		imageUrl: '',
		reportBug: {
			maxLength: 1000,
			rowsLength: 10
		},
		buttons:[{
			onclick: reportBugModalFunction,
			text: 'Odoslať chybu'
		},{
			onclick: () => {},
			text: 'Zavrieť okno'
		}]
	};
}

function showReportBugModal()
{
	const modal = $('#reportBugModal').modal();
	modal.show();
}

function setAjaxError()
{
	isError = true;
}

function getModalImageLink(location, image)
{
	return modalsImageUrl + '/' + location + '/' + image + '.png';
}

function setModalParameters(modal, title, text, image, buttonOnclick, buttonText)
{
	modal.heading = title;
	modal.text = text; 
	modal.imageUrl = image; 
	modal.buttons[0].onclick = buttonOnclick;
	modal.buttons[0].text = buttonText;
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
	availableModal = availableModal ? 1 : 0;
	let modal = modalsArray[availableModal];	

	if(isError)
	{
		type = 'ajaxError';
		modalStructure.data = modalError;
		modalStructure.imageLocation = 'common';
	}

	switch(type)
	{
	case 'levelIntroduced':
	case 'mainTaskIntroduced':
	case 'mainTaskShowed':
	{
		setModalParameters(modal, modalStructure.data.title, modalStructure.data.text, getModalImageLink(modalStructure.imageLocation, modalStructure.data.image), modalStructure.onclick, 'Pokračovať');
		break;
	}

	case 'mainTaskCompleted':
	{
		modalStructure.data.text += '<br><br> <h4><i class="fas fa-stopwatch"></i> Čas:</h4>' + convertDateToTime(modalStructure.task_elapsed_time);
		modalStructure.data.text += '<br><br> <h4><a data-toggle="collapse" href="#collapseCode"><i class="fas fa-code"></i> Kód:</a></h4>';
		modalStructure.data.text += '<div class="collapse" id="collapseCode">';
		modalStructure.data.text += '<div><code>';
		modalStructure.data.text += convertCodeForModal(modalStructure.code);
		modalStructure.data.text += '</div></code>';
		modalStructure.data.text += '</div>';
		modalStructure.data.text += '<br><br> <h4><i class="fas fa-star-half-alt"></i> Hodnotenie:</h4>' + convertRatingToStars(modalStructure.rating);

		setModalParameters(modal, modalStructure.data.title, modalStructure.data.text, getModalImageLink(modalStructure.imageLocation, modalStructure.data.image), modalStructure.onclick, 'Pokračovať');
		break;
	}

	case 'mainTaskFailed':
	{
		setModalParameters(modal, modalStructure.data.title, modalStructure.data.text, getModalImageLink(modalStructure.imageLocation, modalStructure.data.image), modalStructure.onclick, 'Skúsiť znova');
		break;
	}

	case 'ajaxError':
	{
		setModalParameters(modal, modalStructure.data.title, modalStructure.data.text, getModalImageLink(modalStructure.imageLocation, modalStructure.data.image), () => window.location.reload(), 'Reštartovať hru');
		break;
	}

	case 'allMainTasksFinished':
	{
		setModalParameters(modal, modalStructure.data.title, modalStructure.data.text, modalStructure.image, modalStructure.onclick, 'Ďalšia úroveň');
		break;
	}

	}  

	return $(`#centeredModal${availableModal}`).modal();
}

export default { enableModals, showDynamicModal, setAjaxError, showReportBugModal };