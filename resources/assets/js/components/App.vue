<template>
<div>
    <Navbar :brand="brand"/>
    <Carousel-Header/>
    <Features v-if="!$global.User" :heading="featuresHeading" :text="featuresText" />
    <HeroInfo v-else :heading="heroInfoHeading" :text="heroInfoText" />
    <UserAccessForms v-if="!$global.User" :errors="Array.isArray(errors) ? {} : errors" :oldInputs="Array.isArray(old) ? {} : old"/>
    <!-- Game Menu -->
    <!-- Footer -->
</div>
</template>

<script>
import CarouselHeader from './Headers/CarouselHeader';
import Navbar from './Navbar';
import Features from './Sections/Features';
import HeroInfo from './Sections/HeroInfo';
import UserAccessForms from './Sections/UserAccessForms';

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
    recaptchaKey: String
  },
  components: {
    CarouselHeader,
    Navbar,
    Features,
    HeroInfo,
    UserAccessForms
  },
  created () {    
    console.log("this.errors", this.errors);
    console.log("this.old", this.old);
    console.log("this.user", this.user);
    console.log("this.lang", this.lang);
    console.log("this.recaptchaKey", this.recaptchaKey);
    Vue.prototype.$global = {
      CsrfToken: document.head.querySelector('meta[name="csrf-token"]').content,
      User: this.user,
      Lang: this.lang,
      RecaptchaKey: this.recaptchaKey
    };
  }
}
</script>