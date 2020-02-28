<template>
<div>
    <Navbar :brand="brand"/>
    <Carousel-Header/>
    <Features v-if="login" :heading="featuresHeading" :text="featuresText" />
    <HeroInfo v-else :heading="heroInfoHeading" :text="heroInfoText" />
    <UserAccessForms :errors="Array.isArray(errors) ? {} : errors" :oldInputs="Array.isArray(old) ? {} : old"/>
</div>
</template>

<script>
import CarouselHeader from './Headers/CarouselHeader';
import Navbar from './Navbar';
import Features from './Sections/Features';
import HeroInfo from './Sections/HeroInfo';
import UserAccessForms from './Sections/UserAccessForms';

const user = this.user;

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
    old: [Object, Array]
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
    Vue.prototype.$globalCsrfToken = document.head.querySelector('meta[name="csrf-token"]').content;
    Vue.prototype.$globalUser = this.user;
  }
}
</script>