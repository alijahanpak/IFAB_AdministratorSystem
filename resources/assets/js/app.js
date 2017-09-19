
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
require('./foundation');

window.Vue = require('vue');

import Notifications from 'vue-notification'
import velocity      from 'velocity-animate'

window.Vue.use(Notifications , {velocity});
Vue.component('modal-tiny', {template: '#modal-tiny-template'});
Vue.component('modal-small', {template: '#modal-small-template'});
Vue.component('modal-large', {template: '#modal-large-template'});
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */


//Vue.component('example', require('./components/Example.vue'));

/*const app = new Vue({
    el: '#app',
    data:{
        message: 'alijahanpak'
    }
});*/
