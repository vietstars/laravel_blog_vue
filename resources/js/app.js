/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

import VueRouter from 'vue-router';
import { routes } from './routes';

import Vuex from 'vuex';

import storeData from "./store/index";

Vue.use(Vuex);

const store = new Vuex.Store(
	storeData
)

import {filter} from './filter';

Vue.use( VueRouter );

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('admin-main', require('./components/admin/AdminMaster.vue').default);

import { Form, HasError, AlertError } from 'vform';
//vform
window.Form = Form;
Vue.component(HasError.name, HasError);
Vue.component(AlertError.name, AlertError);

// swal2
import swal from 'sweetalert2'
window.swal = swal;

const router = new VueRouter({ 
	routes , // shorten routes:routes
	mode: 'hash',
	// mode: 'history'
})

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
    router,
    store,
    data: {
    	page: 'not yet',
    },
  	mounted: function(){
	  	// this.$on('page', function () {
	   //  	this.page = this.$route.name;
	  	// })
	  	this.page = this.$route.name;
		document.querySelectorAll('.nav-item').forEach(menu => {			
			menu.addEventListener('click', function(ev) {
				document.querySelectorAll('.nav-item').forEach(el=>{
					if (el.classList.contains("active")) {
					    el.classList.remove("active");
				  	}
				})
				this.classList.add("active");
			});
		});
  	},
  	methods: {
  		toggleFullScreen() {
		    if ((document.fullScreenElement !== undefined && document.fullScreenElement === null) || (document.msFullscreenElement !== undefined && document.msFullscreenElement === null) || (document.mozFullScreen !== undefined && !document.mozFullScreen) || (document.webkitIsFullScreen !== undefined && !document.webkitIsFullScreen)) {
		      if (document.documentElement.requestFullScreen) {
		        document.documentElement.requestFullScreen();
		      } else if (document.documentElement.mozRequestFullScreen) {
		        document.documentElement.mozRequestFullScreen();
		      } else if (document.documentElement.webkitRequestFullScreen) {
		        document.documentElement.webkitRequestFullScreen(Element.ALLOW_KEYBOARD_INPUT);
		      } else if (document.documentElement.msRequestFullscreen) {
		        document.documentElement.msRequestFullscreen();
		      }
		    } else {
		      if (document.cancelFullScreen) {
		        document.cancelFullScreen();
		      } else if (document.mozCancelFullScreen) {
		        document.mozCancelFullScreen();
		      } else if (document.webkitCancelFullScreen) {
		        document.webkitCancelFullScreen();
		      } else if (document.msExitFullscreen) {
		        document.msExitFullscreen();
		      }
		    }
	  	}
  	}
});

