import * as $ from 'jquery';
import 'jquery.easing';

let currentView = null;
let appRef = null;

function changeView(view, data, title, location, forcePushState = false)
{
	console.log('CHANGE VIEW', currentView, view, data, title, location, forcePushState);
	
	if(currentView === view && !forcePushState)
	{
		// replaceState logic	
		console.log('replaceState logic');	
		window.history.replaceState({ view, data }, title, location);
		changeData(data, view);
		return;
	}
	// pushState logic
	console.log('pushState logic');
	changeData(data, view);	

	if(location.includes('#'))
	{
		setTimeout(() => { scrollToHash('#' + location.split('#')[1]); }, 100);
		window.history.pushState({view, data}, title, location.split('#')[0]);
		return;		
	}	
	window.history.pushState({view, data}, title, location);	
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
	var target = $(hash);
	target = target.length ? target : $('[name=' + hash.slice(1) + ']');
	if (target.length) {
		$('html, body').animate({
			scrollTop: (target.offset().top - 48)
		}, 1000, 'easeInOutExpo');
	}
}

function getLocationFromUrl(url)
{
	return '/' + url.split('/').slice(3).join('/');
}

function getViewFromUrl(baseUrl, url)
{
	let view = url.replace(baseUrl, '');
	view = view.split('/').filter(x => x)[0];
	switch(view)
	{
	default:
		return 'home';
	case 'game':
		return 'game';		
	}
}

function enableHistory(app, baseUrl, url, data)
{
	appRef = app;
	currentView = getViewFromUrl(baseUrl, url);

	window.history.replaceState({ view: currentView, data }, '', getLocationFromUrl(url));
	
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
			setTimeout(() => scrollToHash(event.target.location.hash), 100);
		}
	}); 
}

export default { changeView, enableHistory, scrollToHash, getLocationFromUrl, getViewFromUrl };