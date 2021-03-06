
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
import PDatePicker from 'vue2-persian-datepicker'
import vSelectPage from 'v-selectpage'
import money from 'v-money';
import VuePersianDatetimePicker from 'vue-persian-datetime-picker';
import messageDialog from './public_component/message_dialog.vue';

import VueApexCharts from 'vue-apexcharts';

Vue.use(VueApexCharts);


Vue.use(vSelectPage, {
    // server side data loader
    dataLoad: function(vue, data, params){
        return new Promise((resolve, reject)=>{
            axios.post(url, params).then(resp=>resolve(resp)).then(resp=>reject(resp));
        });
    }
});

window.Vue.use(money, {precision: 4});

window.Vue.use(VeeValidate);
//Vue.use(VeeValidate, { inject: false });

window.Vue.use(Notifications , {velocity});
window.Vue.use(VueProgressBar, {
    color: '#77B6FF',
    failedColor: 'red',
    height: '50',

});

Vue.use(vSelectPage, {
    // server side data loader
    dataLoad: function(vue, data, params){
        return new Promise((resolve, reject)=>{
            axios.post(url, params).then(resp=>resolve(resp)).then(resp=>reject(resp));
        });
    }
});


Vue.component('pdatepicker', PDatePicker);


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

Vue.component('date-picker', VuePersianDatetimePicker);

Vue.component('modal-tiny', {template: '#modal-tiny-template'});
Vue.component('modal-small', {template: '#modal-small-template'});
Vue.component('modal-large', {template: '#modal-large-template'});
Vue.component('modal-full-screen', {template: '#modal-full-screen-template'});
Vue.component('modal-login', {template: '#modal-login-template'});
Vue.component('modal-access-denied', {template: '#modal-access-denied-template'});

Vue.component('messageDialog', messageDialog);
Vue.component('messageDialog', messageDialog);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
require('./router');
/*const app = new Vue({
    el: '#app',
});*/
