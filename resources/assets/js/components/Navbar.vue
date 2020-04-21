<template>
  <nav class="navbar navbar-expand-lg navbar-light fixed-top" id="mainNav">
         <div class="container">
            <a v-if="$global.GameInProgress" href="" class="navbar-brand" v-on:click.prevent="changeViewToHome()">{{ locales.brand }}</a>
            <a v-else class="navbar-brand js-scroll-trigger" href="#page-top" v-on:click.prevent="scrollTo('#page-top')">{{ locales.brand }}</a>            
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
                  <li v-if="isUserLoggedIn" class="nav-item dropdown">
                     <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                     <i class="fa fa-user-circle"></i> {{ userName }}
                     </a>        
                     <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="" v-on:click.prevent="logout()">{{ locales.logout }}</a>
                     </div>
                  </li>   
               </ul>
            </div>
        </div>
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
	mounted() {
		console.log('Navbar mounted.');
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
		async logout()
		{
			await sendRequest({method:'POST', url: this.$global.Url('logout')});
			this.$global.User = null;
			this.changeViewToHome();       
		},
		scrollTo(hash){
			HistoryManager.scrollToHash(hash);
			//HistoryManager.changeView('home', undefined, '', '/' + this.$global.Url(hash).split('/').slice(3).join('/'));
		}
	}
};
</script>
