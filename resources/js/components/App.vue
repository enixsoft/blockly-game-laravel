<template>
<div>
    <Navbar/>
    <template v-if="ViewName === 'game'">
		<GameHeader
		:game-data="ViewData"	
		v-on:UPDATE_PROGRESS="updateProgress"			
		/>
    </template>    
    <template v-else-if="ViewName === 'home'">    
		<Carousel-Header />
		<Features v-if="!$global.User" />
		<HeroInfo v-else />
		<UserAccessForms v-if="!$global.User"
						:errors="Array.isArray(errors) ? {} : errors" 
						:oldInputs="Array.isArray(old) ? {} : old"/>
		<GameLevels v-else :in-game-progress="Progress" :levelsPerCategory="5" />
		<Footer/>
    </template>
</div>
</template>

<script>
import Vue from 'vue';
import CarouselHeader from './Sections/CarouselHeader';
import GameHeader from './Game/GameHeader';
import Navbar from './Navbar';
import Features from './Sections/Features';
import HeroInfo from './Sections/HeroInfo';
import UserAccessForms from './Sections/UserAccessForms';
import GameLevels from './Sections/GameLevels';
import * as $ from 'jquery';
import 'bootstrap';
import 'jquery.easing';
import HistoryManager from './Managers/HistoryManager';
import Footer from './Footer';
import 'cookieconsent';

export default { 
	data(){
		return {
			ViewName: this.viewName,
			ViewData: !Array.isArray(this.viewData) ? this.viewData : undefined,
			User: this.user,
			Url: (path = undefined) => path ? this.baseUrl + path : this.baseUrl,
			getLocalizedString: (string) => this.lang[string] || 'ERROR_LANG_STRING_NOT_FOUND',
			getLocalizedStrings: (locales) => Object.keys(locales).reduce((acc, key) => { acc[key] = this.lang[locales[key]] || 'ERROR_LANG_STRING_NOT_FOUND'; return acc; }, {}),			
			Progress: this.user ? [...this.user.formatted_progress] : [],
			Mobile: (/Mobi|Android/i.test(navigator.userAgent)),
			CsrfToken: document.head.querySelector('meta[name="csrf-token"]').content,			
			RecaptchaKey: this.recaptchaKey,	
		};
	},
	props: {
		viewName: String,
		viewData: [Object, Array],
		user: Object,
		lang: [Object],		
		errors: [Object, Array],
		old: [Object, Array],		
		recaptchaKey: String,
		baseUrl: String
	},
	components: {
		CarouselHeader,
		Navbar,
		Features,
		HeroInfo,
		UserAccessForms,
		GameLevels,
		GameHeader,
		Footer		
	},
	created() {
		Vue.prototype.$global = this.$data;
		
		$.ajaxSetup({
			beforeSend: (xhr) => {
				xhr.setRequestHeader('X-CSRF-TOKEN', this.CsrfToken);
			}
		});

		HistoryManager.enableHistory(this, window.location.href, this.ViewName, this.ViewData);

		window.cookieconsent.initialise({
			'palette': {
				'popup': {
					'background': '#242c34'
				},
				'button': {
					'background': '#d4282a'
				}
			},
			'theme': 'classic',
			'content': {
				'message': this.getLocalizedString('cookies.msg'),
				'dismiss':  this.getLocalizedString('cookies.dismiss'),
				'link':  this.getLocalizedString('cookies.link')
			}
		});
	},
	mounted(){
		if(this.errors['name'] || this.errors['password'])
		{
			$('html, body').animate({
				scrollTop: $('#game').offset().top
			}, 'slow');     
			HistoryManager.changeView('home', undefined, '', '');  
		}
		else if (this.errors['register-username'] || this.errors['register-password'] || this.errors['register-email'] || this.errors['g-recaptcha-response']) {
			$('#loginDiv').collapse('hide');
			$('#registerDiv').collapse('show');         
			$('html, body').animate({
				scrollTop: $('#game').offset().top
			}, 'slow');
			HistoryManager.changeView('home', undefined, '', '');  
		} else if(this.$global.User && this.$global.ViewName === 'home')
		{
			$('html, body').animate({
				scrollTop: $('#features').offset().top
			}, 'slow');			
			HistoryManager.changeView('home', undefined, '', '');  
		}		

		// Closes responsive menu when a scroll trigger link is clicked
		$('.js-scroll-trigger').click(function() {
			$('.navbar-collapse').collapse('hide');
		});

		// Activate scrollspy to add active class to navbar items on scroll
		$('body').scrollspy({
			target: '#mainNav',
			offset: 54
		});

		// Collapse Navbar
		var navbarCollapse = function() {
			if ($('#mainNav').offset().top > 100) {
				$('#mainNav').addClass('navbar-shrink');
			} else {
				$('#mainNav').removeClass('navbar-shrink');
			}
		};
		// Collapse now if page is not at top
		navbarCollapse();
		// Collapse the navbar when page is scrolled
		$(window).scroll(navbarCollapse);
	},
	methods:{
		updateProgress(obj)
		{
			const actualProgress = this.Progress[((obj.category -1) * 5)+(obj.level-1)];
			const newProgress = Number(obj.progress);
			if(actualProgress === undefined || actualProgress < newProgress)
			{
				this.Progress[((obj.category -1) * 5)+(obj.level-1)] = newProgress;
			}
		}
	}  
};
</script>