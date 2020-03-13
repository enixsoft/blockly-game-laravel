<template>
<div>
    <Navbar :brand="brand"/>
    <Carousel-Header/>
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
            <p class="mt-3">&copy; 2019 - 2020<br>Martin Vančo<br>Naposledy aktualizované: 13.3.2020
            </p>
         </div>
    </footer>
</div>
</template>

<script>
import CarouselHeader from './Headers/CarouselHeader';
import Navbar from './Navbar';
import Features from './Sections/Features';
import HeroInfo from './Sections/HeroInfo';
import UserAccessForms from './Sections/UserAccessForms';
import GameLevels from './Sections/GameLevels';

export default { 
  data(){
    return {
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
    inGameProgress: Array
  },
  components: {
    CarouselHeader,
    Navbar,
    Features,
    HeroInfo,
    UserAccessForms,
    GameLevels
  },
  created () {    
    console.log("this.errors", this.errors);
    console.log("this.old", this.old);
    console.log("this.user", this.user);
    console.log("this.lang", this.lang);
    console.log("this.recaptchaKey", this.recaptchaKey);
    console.log("this.inGameProgress", this.inGameProgress);
    Vue.prototype.$global = {
      CsrfToken: document.head.querySelector('meta[name="csrf-token"]').content,
      User: this.user,
      Lang: this.lang,
      RecaptchaKey: this.recaptchaKey
    };
  }
}
</script>