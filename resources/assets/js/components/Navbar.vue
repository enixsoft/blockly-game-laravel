<template>
  <nav class="navbar navbar-expand-lg navbar-light fixed-top" id="mainNav">
         <div class="container">
            <template v-if="$global.GameInProgress">
				<a v-if="$global.GameInProgress" href="" class="navbar-brand" v-on:click.prevent="changeViewToHome()">{{ locales.brand }}</a>
				<a v-if="$global.Mobile" href="" class="navbar-brand" v-on:click.prevent="toggleFullscreen()"><i class="fas fa-expand-arrows-alt"></i></a>
            </template>
				<template v-else>
				<a class="navbar-brand js-scroll-trigger" href="#page-top" v-on:click.prevent="scrollTo('#page-top')">{{ locales.brand }}</a>       
				</template>     
            <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
            <i class="fas fa-bars"></i>
            </button>
            <div class="collapse navbar-collapse" id="navbarResponsive">
               <ul class="navbar-nav ml-auto">
                  <li v-if="!$global.GameInProgress" class="nav-item">
                     <a class="nav-link js-scroll-trigger" href="#features" v-on:click.prevent="scrollTo('#features')">{{ locales.aboutGame }}</a>
                  </li>
                  <li v-if="!$global.GameInProgress" class="nav-item">
                     <a class="nav-link js-scroll-trigger" href="#game" v-on:click.prevent="scrollTo('#game')">{{ locales.runGame }}</a>
                  </li>    
						<li v-if="!$global.GameInProgress" class="nav-item dropdown">
                     <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown1" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                     <i class="fa fa-language"></i> {{ locales.languages }}
                     </a>        
                     <div class="dropdown-menu" aria-labelledby="navbarDropdown1">
								<a class="dropdown-item" href="" v-on:click.prevent="changeLanguage('en')">English</a>
                        <a class="dropdown-item" href="" v-on:click.prevent="changeLanguage('sk')">Slovenčina</a>
                     </div>
                  </li>                         
                  <li v-if="isUserLoggedIn" class="nav-item dropdown">
                     <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown2" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                     <i class="fa fa-user-circle"></i> {{ userName }}
                     </a>        
                     <div class="dropdown-menu" aria-labelledby="navbarDropdown2">
                        <a class="dropdown-item" href="" v-on:click.prevent="logout()">{{ locales.logout }}</a>
                     </div>
                  </li>   
               </ul>
            </div>
        </div>
		<form id="logout-form" ref="logoutForm" action="logout" method="POST" style="display: none;"><input type="hidden" name="_token" :value="$global.CsrfToken"></form>
    </nav> 
</template>

<script>
import HistoryManager from './Managers/HistoryManager';
import { sendRequest } from './Managers/Common';
import { navbar as locales } from './Managers/LocaleManager';
export default {
	data(){
		return {			
			locales: this.$global.getLocalizedStrings(locales),
		};
	},
	computed: {
		isUserLoggedIn()
		{
			return this.$global.User ? true : false;
		},
		userName()
		{             
			return this.$global.User ? this.$global.User.username : undefined;
		}
	},
	methods: {      
		changeViewToHome(){			
			HistoryManager.changeView('home', undefined, '', '/' + this.$global.Url('#game').split('/').slice(3).join('/'));			
		},
		logout()
		{     
			this.$refs.logoutForm.submit();
		},
		scrollTo(hash){
			HistoryManager.scrollToHash(hash);
			//HistoryManager.changeView('home', undefined, '', '/' + this.$global.Url(hash).split('/').slice(3).join('/'));
		},
		async changeLanguage(lang)
		{
			await sendRequest({method:'GET', url: this.$global.Url(`language/${lang}`)});
			window.location.reload();
		},
		toggleFullscreen(){
			const isInFullScreen = (document.fullscreenElement && document.fullscreenElement !== null) ||
        (document.webkitFullscreenElement && document.webkitFullscreenElement !== null) ||
        (document.mozFullScreenElement && document.mozFullScreenElement !== null) ||
        (document.msFullscreenElement && document.msFullscreenElement !== null);

			const docElm = document.documentElement;
			if (!isInFullScreen) {
				if (docElm.requestFullscreen) {
					docElm.requestFullscreen();
				} else if (docElm.mozRequestFullScreen) {
					docElm.mozRequestFullScreen();
				} else if (docElm.webkitRequestFullScreen) {
					docElm.webkitRequestFullScreen();
				} else if (docElm.msRequestFullscreen) {
					docElm.msRequestFullscreen();
				}
			} else {
				if (document.exitFullscreen) {
					document.exitFullscreen();
				} else if (document.webkitExitFullscreen) {
					document.webkitExitFullscreen();
				} else if (document.mozCancelFullScreen) {
					document.mozCancelFullScreen();
				} else if (document.msExitFullscreen) {
					document.msExitFullscreen();
				}
			}

		}
	}
};
</script>
