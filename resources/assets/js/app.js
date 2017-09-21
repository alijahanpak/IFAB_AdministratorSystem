
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
require('./foundation');

window.Vue = require('vue');

import Notifications from 'vue-notification'
import velocity      from 'velocity-animate'
import VueRouter from 'vue-router'
import VeeValidate from 'vee-validate'


window.Vue.use(VeeValidate);
window.Vue.use(Notifications , {velocity});
window.Vue.use(VueRouter);

Vue.component('modal-tiny', {template: '#modal-tiny-template'});
Vue.component('modal-small', {template: '#modal-small-template'});
Vue.component('modal-large', {template: '#modal-large-template'});
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('example', require('./components/Example.vue'));

const routes = [
    {path: '/', component: levi },
    {path: '/product', component: product },
    {path:'/price', component: price }
];


//export router instance

export default new Router({

    mode: 'history',
    routes,
    linkActiveClass:'is-active'
});

const app = new Vue({
    el: '#app',
    router,
});
