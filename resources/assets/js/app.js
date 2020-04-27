import Vue from 'vue';
import App from './components/App';

Vue.config.devtools = true;

export const bus = new Vue();

new Vue({
	el: '#app',
	components: {  
		App
	}   
});
