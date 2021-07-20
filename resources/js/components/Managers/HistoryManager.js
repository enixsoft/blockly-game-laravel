import * as $ from 'jquery';
import 'jquery.easing';

let appRef = null;

function changeView(view, data, title, location, forcePushState = false)
{	
	if(appRef.ViewName === view && !forcePushState)
	{
		// replaceState logic	
		changeData(data, view);
		if(location.includes('#'))
		{
			scrollToHash('#' + location.split('#')[1]);
		}
		window.history.replaceState({ view, data }, title, location.includes('#') ? location.split('#')[0] : location);
		return;
	}
	// pushState logic
	changeData(data, view);	

	if(location.includes('#'))
	{
		setTimeout(() => { scrollToHash('#' + location.split('#')[1]); }, 100);	
	}	
	window.history.pushState({view, data}, title, location.includes('#') ? location.split('#')[0] : location);	
}

function changeData(data, view = 'home') 
{
	appRef.ViewData = data;
	appRef.ViewName = view;
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

function enableHistory(app)
{	
	appRef = app;

	window.history.replaceState({ view: appRef.ViewName, data: appRef.ViewData }, '', getLocationFromUrl(window.location.href));
	
	window.addEventListener('popstate', (event) => {
		$('.modal').modal('hide');

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

export default { changeView, enableHistory, scrollToHash, getLocationFromUrl };