<template>
<footer>
<div class="container">
   <div class="row">
      <div class="col-lg-4 col-md-6">
         <h3>{{ locales.headingLinks }}</h3>
         <ul class="list-group list-group-flush">
            <li class="list-group-item"><a href="https://github.com/enixsoft/blockly-game-netcore"><i class="icon-social-github"></i> {{ locales.links0 }}</a></li>
            <li class="list-group-item"><a href="https://playcanvas.com"><i class="icon-game-controller"></i> {{ locales.links1 }}</a></li>
            <li class="list-group-item"><a href="https://developers.google.com/blockly"><i class="icon-social-google"></i> {{ locales.links2 }}</a></li>
            <li class="list-group-item"><a href="https://azure.microsoft.com"><i class="icon-cloud-download"></i> {{ locales.links3 }}</a></li>
         </ul>
      </div>
      <div class="col-lg-4 col-md-6">
         <h3>{{ locales.headingLatestUpdates }}</h3>
         <div class="list-group">
            <div class="list-group-item flex-column align-items-start">
               <div class="d-flex w-100 justify-content-between">
                  <h5 class="mb-1">{{ locales.title0 }}</h5>
                  <small>{{ locales.date0 }}</small>
               </div>
               <p class="mb-1">{{ locales.text0 }}</p>
            </div>
            <div class="list-group-item flex-column align-items-start">
               <div class="d-flex w-100 justify-content-between">
                  <h5 class="mb-1">{{ locales.title1 }}</h5>
                  <small>{{ locales.date1 }}</small>
               </div>
               <p class="mb-1">{{ locales.text1 }}</p>
            </div>
            <div class="list-group-item flex-column align-items-start">
               <div class="d-flex w-100 justify-content-between">
                  <h5 class="mb-1">{{ locales.title2 }}</h5>
                  <small>{{ locales.date2 }}</small>
               </div>
               <p class="mb-1">{{ locales.text2 }}</p>
            </div>
         </div>
      </div>
      <div class="col-lg-4">
         <h3>{{ locales.headingTechnologies }}</h3>
         <img class="img-fluid mb-3" :src="this.$global.Url('img/logo_built_on_playcanvas.png')" alt="" />
         <img class="img-fluid mb-3" :src="this.$global.Url('img/logo_built_on_dark.png')" alt="" />
         <img class="img-fluid mb-3" :src="this.$global.Url('img/logo_built_on_laravel.png')" alt="" />
      </div>
   </div>
</div>
<div class="copyright text-center">
    &copy; 2019-2020 <span>Martin Vančo</span>
</div>
</footer>
</template>
<script>
import { footer as locales } from './Managers/LocaleManager';
export default {
	data(){
		return {
			locales: this.$global.getLocalizedStrings(locales)
		};
    }
};
</script>