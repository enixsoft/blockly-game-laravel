<template>
<div>
    <Navbar :brand="brand"/>
    <template v-if="$global.GameInProgress">
      <GameHeader />
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
    <GameLevels v-else :in-game-progress="inGameProgress" />
    <footer>
         <div class="container">
            <a href="https://developers.google.com/blockly"><img class="img-fluid" src="img/logo_built_on_dark.png"></a>
            <br>
            <p class="mt-3">&copy; 2019 - 2020<br>Martin Vančo<br>Naposledy aktualizované: 20.3.2020
            </p>
         </div>
    </footer>
    </template>
</div>
</template>

<script>
import CarouselHeader from './Headers/CarouselHeader';
import GameHeader from './Headers/GameHeader';
import Navbar from './Navbar';
import Features from './Sections/Features';
import HeroInfo from './Sections/HeroInfo';
import UserAccessForms from './Sections/UserAccessForms';
import GameLevels from './Sections/GameLevels';
import * as $ from 'jquery';
import 'bootstrap';
import 'jquery.easing';


export default { 
  data(){
    return {
        CsrfToken: document.head.querySelector('meta[name="csrf-token"]').content,
        User: this.user,
        Lang: this.lang,
        RecaptchaKey: this.recaptchaKey,
        GameData: this.gameData,
        GameInProgress: this.gameData.length ? true : false,

        login: false,
        brand: "BLOCKLY HRA VUE",
        featuresHeading: "Hra ovládaná programovaním",
        featuresText: "Google Blockly prináša vizuálny editor blokov, ktoré sa premieňajú na kód. Po odoslaní do hry z neho vznikajú príkazy vykonávané hrdinom.",
        heroInfoHeading: "Vitajte v Blockly hre!",
        heroInfoText: "Pomocou spájania programovacích blokov v nej budete ovládať hrdinu bojovníka. Ten prišiel na výpravu do starého hradu a aby ho prešiel celý, musí prekonať množstvo prekážok a splniť mnoho úloh. Prezrite si hrdinu a popis jeho schopností, ktoré postupne získa a budete používať.",
    }
  },
  props: {
    user: Object,
    errors: [Object, Array],
    old: [Object, Array],
    lang: [Object],
    recaptchaKey: String,
    inGameProgress: Array,
    gameData: [Object, Array]
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
  created () {    
    // Vue.prototype.$global = {
    //   CsrfToken: document.head.querySelector('meta[name="csrf-token"]').content,
    //   User: this.user,
    //   Lang: this.lang,
    //   RecaptchaKey: this.recaptchaKey,
    //   GameData: this.gameData,
    //   GameInProgress: this.gameData.length ? true : false
    // };
    Vue.prototype.$global = this.$data;
    console.log("GLOBAL", this.$global);
  },
  mounted(){
  if(this.errors['username'] || this.errors['password'])
  {
    $('html, body').animate({
    scrollTop: $('#game').offset().top
    }, 'slow');     
  }
  else if (this.errors['register-username'] || this.errors['register-password'] || this.errors['register-email'] || this.errors['g-recaptcha-response']) {
    $('#loginDiv').collapse("hide");
    $('#registerDiv').collapse("show");         
    $('html, body').animate({
        scrollTop: $('#game').offset().top
    }, 'slow');
  } else if(this.$global.User && !this.$global.GameInProgress)
  {
    $('html, body').animate({
    scrollTop: $('#features').offset().top
    }, 'slow');  
  }

  // Smooth scrolling using jQuery easing
  $('a.js-scroll-trigger[href*="#"]:not([href="#"])').click(function() {
    if (location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '') && location.hostname == this.hostname) {
      var target = $(this.hash);
      target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
      if (target.length) {
        $('html, body').animate({
          scrollTop: (target.offset().top - 48)
        }, 1000, "easeInOutExpo");
        return false;
      }
    }
  });

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
    if ($("#mainNav").offset().top > 100) {
      $("#mainNav").addClass("navbar-shrink");
    } else {
      $("#mainNav").removeClass("navbar-shrink");
    }
  };
  // Collapse now if page is not at top
  navbarCollapse();
  // Collapse the navbar when page is scrolled
  $(window).scroll(navbarCollapse);
}  
}
</script>