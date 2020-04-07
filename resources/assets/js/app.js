import Vue from 'vue';
import App from './components/App';

Vue.config.devtools = true;
const app = new Vue({
	el: '#app',
	components: {  
		App
	}   
});
