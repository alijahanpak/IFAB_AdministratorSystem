
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
require('./foundation');

window.Vue = require('vue');

import Notifications from 'vue-notification'
import velocity      from 'velocity-animate'
import VeeValidate from 'vee-validate'
import VueProgressBar from 'vue-progressbar'

window.Vue.use(VeeValidate);
window.Vue.use(Notifications , {velocity});
window.Vue.use(VueProgressBar, {
    color: 'rgb(113, 106, 202)',
    failedColor: 'red',
    height: '8px'
});

Vue.component(
    'passport-clients',
    require('./components/passport/Clients.vue')
);

Vue.component(
    'passport-authorized-clients',
    require('./components/passport/AuthorizedClients.vue')
);

Vue.component(
    'passport-personal-access-tokens',
    require('./components/passport/PersonalAccessTokens.vue')
);

Vue.component('modal-tiny', {template: '#modal-tiny-template'});
Vue.component('modal-small', {template: '#modal-small-template'});
Vue.component('modal-large', {template: '#modal-large-template'});
Vue.component('modal-full-screen', {template: '#modal-full-screen-template'});
Vue.component('modal-login', {template: '#modal-login-template'});
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
require('./router');
/*const app = new Vue({
    el: '#app',
});*/
