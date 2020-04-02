window.Vue = require('vue');
import App from './components/App';

const app = new Vue({
	el: '#app',
	components: {  
		App
	}   
});

Vue.config.devtools = true;

export { app } ;
