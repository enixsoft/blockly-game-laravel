<template>
<div>
    <Navbar :brand="brand"/>
    <template v-if="GameInProgress !== undefined">
      <GameHeader :category="GameInProgress.category"
						:level="GameInProgress.level"
                  :game-data="GameInProgress"	
						v-on:UPDATE_PROGRESS="updateProgress"			
       />
    </template>    
    <template v-else>    
    <Carousel-Header />
    <Features v-if="!$global.User" 
              :heading="featuresHeading" 
              :text="featuresText" />
    <HeroInfo v-else :heading="heroInfoHeading" 
              :text="heroInfoText" />
    <UserAccessForms v-if="!$global.User" 
                    :errors="Array.isArray(errors) ? {} : errors" 
                    :oldInputs="Array.isArray(old) ? {} : old"/>
    <GameLevels v-else	:in-game-progress="Progress"
	 							:levelsPerCategory="5" />
    <footer>
         <div class="container">
            <a href="https://developers.google.com/blockly"><img class="img-fluid" :src="this.$global.Url('img/logo_built_on_dark.png')"></a>
            <br>
            <p class="mt-3">&copy; 2019 - 2020<br>Martin Vančo<br>Naposledy aktualizované: 6.4.2020
            </p>
         </div>
    </footer>
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

export default { 
	data(){
		return {
			CsrfToken: document.head.querySelector('meta[name="csrf-token"]').content,
			User: this.user,
			Lang: this.lang,
			RecaptchaKey: this.recaptchaKey,
			GameInProgress: !Array.isArray(this.gameData) ? this.gameData : undefined,
			Url: (path = undefined) => path ? this.baseUrl + path : this.baseUrl,
			Progress: [...this.inGameProgress],

			brand: 'BLOCKLY HRA VUE',
			featuresHeading: 'Hra ovládaná programovaním',
			featuresText: 'Google Blockly prináša vizuálny editor blokov, ktoré sa premieňajú na kód. Po odoslaní do hry z neho vznikajú príkazy vykonávané hrdinom.',
			heroInfoHeading: 'Vitajte v Blockly hre!',
			heroInfoText: 'Pomocou spájania programovacích blokov v nej budete ovládať hrdinu bojovníka. Ten prišiel na výpravu do starého hradu a aby ho prešiel celý, musí prekonať množstvo prekážok a splniť mnoho úloh. Prezrite si hrdinu a popis jeho schopností, ktoré postupne získa a budete používať.',
		};
	},
	props: {
		user: Object,
		errors: [Object, Array],
		old: [Object, Array],
		lang: [Object],
		recaptchaKey: String,
		inGameProgress: Array,
		gameData: [Object, Array],
		baseUrl: String
	},
	components: {
		CarouselHeader,
		Navbar,
		Features,
		HeroInfo,
		UserAccessForms,
		GameLevels,
		GameHeader
	},
	created() {		
		Vue.prototype.$global = this.$data;
		console.log('GLOBAL', this.$global);
		
		$.ajaxSetup({
			beforeSend: (xhr) => {
				xhr.setRequestHeader('X-CSRF-TOKEN', this.CsrfToken);
			}
		});
		
		HistoryManager.enableHistory(this); 
	},
	mounted(){
		if(this.errors['username'] || this.errors['password'])
		{
			$('html, body').animate({
				scrollTop: $('#game').offset().top
			}, 'slow');     
			HistoryManager.changeView('home', undefined, '', '#game');  
		}
		else if (this.errors['register-username'] || this.errors['register-password'] || this.errors['register-email'] || this.errors['g-recaptcha-response']) {
			$('#loginDiv').collapse('hide');
			$('#registerDiv').collapse('show');         
			$('html, body').animate({
				scrollTop: $('#game').offset().top
			}, 'slow');
			HistoryManager.changeView('home', undefined, '', '#game');  
		} else if(this.$global.User && !this.$global.GameInProgress)
		{
			$('html, body').animate({
				scrollTop: $('#features').offset().top
			}, 'slow');			
			HistoryManager.changeView('home', undefined, '', '#features');  
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
			this.Progress[((obj.category -1) * 5)+(obj.level-1)] = obj.progress;
		}
	}  
};
</script>