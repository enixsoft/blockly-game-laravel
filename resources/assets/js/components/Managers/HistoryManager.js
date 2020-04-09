import * as $ from 'jquery';
import 'jquery.easing';

let currentView = null;
let appRef = null;

function changeView(view, data, title, location)
{
	console.log('CHANGE VIEW', currentView, view, data, title, location);

	if(currentView === null || currentView === view)
	{
		// replaceState logic		
		window.history.replaceState({ view, data }, title, location);
		changeData(data, view);
		return;
	}
	// pushState logic
	window.history.pushState({ view, data }, title, location);
	changeData(data, view);	
	
	if(location.includes('#'))
	{
		setTimeout(() => { scrollToHash('#' + location.split('#')[1]); }, 100);
	}
}

function changeData(data, view = 'home') 
{	
	switch(view)
	{
	case 'game':				         
		appRef.GameInProgress = data;			
		break;
	case 'home':
		appRef.GameInProgress = data;
		break;
	}
	currentView = view;
}

function scrollToHash(hash) 
{	
	console.log(hash);
	var target = $(hash);
	console.log(target);
	target = target.length ? target : $('[name=' + hash.slice(1) + ']');
	if (target.length) {
		$('html, body').animate({
			scrollTop: (target.offset().top - 48)
		}, 1000, 'easeInOutExpo');
	}
}


function enableHistory(app)
{
	appRef = app;
	window.addEventListener('popstate', (event) => {
		console.log('event', event);
		console.log('state', event.state);
		console.log('view', event.state && event.state.view);
		console.log('hash', event.target.location.hash);

		if(event.state && event.state.view)
		{
			changeData(event.state.data, event.state.view);
		}		
		else
		{
			changeData(undefined);
		}

		if(event.target.location.hash)
		{
			scrollToHash(event.target.location.hash);
		}
	}); 
}

export default { changeView, enableHistory };