import * as $ from 'jquery';
import {convertCodeForModal, convertDateToTime, convertRatingToStars} from './Common';

let modalRef = undefined;
let modalData = undefined;
const modalDataQueue = [];
let modalImageUrl = undefined;
let availableModal = true;

function enableModals(ref, data, url){
	modalRef = ref;
	modalData = data;
	modalImageUrl = url;

	$(modalRef).on('hidden.bs.modal', modalHiddenEvent);
}

function modalHiddenEvent()
{
	availableModal = true;
	show();
}

function getModalImageLink(location, image)
{
	return modalImageUrl + '/' + location + '/' + image + '.png';
}

function setModalParameters(heading, text, imageUrl, buttons, reportBug = undefined)
{
	return {
		heading,
		text,
		imageUrl,
		buttons,
		reportBug
	};
}

function showDynamicModal(type, modalStructure)
{
	modalDataQueue.push(createDynamicModal(type, modalStructure));
	
	if(availableModal)
	{
		show(); 
	}
}

function show()
{
	if(modalDataQueue.length)
	{
		Object.assign(modalData, modalDataQueue.shift());
		availableModal = false;
		$(modalRef).modal('show'); 
	}
}

function createDynamicModal(type, modalStructure)
{
	switch(type)
	{
	case 'levelIntroduced':
	case 'mainTaskIntroduced':
	case 'mainTaskShowed':
		return setModalParameters(modalStructure.data.title, modalStructure.data.text, getModalImageLink(modalStructure.imageLocation, modalStructure.data.image), [{onclick: modalStructure.onclick, text: 'Pokračovať'}]);

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

		return setModalParameters(modalStructure.data.title, modalStructure.data.text, getModalImageLink(modalStructure.imageLocation, modalStructure.data.image), [{onclick: modalStructure.onclick, text: 'Pokračovať'}]);
	}

	case 'mainTaskFailed':	
		return setModalParameters(modalStructure.data.title, modalStructure.data.text, getModalImageLink(modalStructure.imageLocation, modalStructure.data.image), [{onclick: modalStructure.onclick, text: 'Skúsiť znova'}]);	

	case 'ajaxError':	
		return setModalParameters(modalStructure.data.title, modalStructure.data.text, getModalImageLink(modalStructure.imageLocation, modalStructure.data.image), [{onclick: modalStructure.onclick, text: 'Reštartovať hru'}]);	

	case 'allMainTasksFinished':	
		return setModalParameters(modalStructure.data.title, modalStructure.data.text, getModalImageLink(modalStructure.imageLocation, modalStructure.data.image), [{onclick: modalStructure.onclick, text: 'Ďalšia úroveň'}]);
	
	case 'reportBug':
		return setModalParameters('Nahlásiť chybu', 'Môžete napísať 1000 znakov.', '', [{onclick: modalStructure.onclick, text: 'Odoslať chybu'}, {onclick: () => {}, text: 'Zavrieť okno'}], {maxLength: 1000, rowsLength: 10});
	}
}

export default { enableModals, showDynamicModal };