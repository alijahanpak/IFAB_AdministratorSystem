/**
 * Created by ammorteza on 9/21/17.
 */
import VueRouter from 'vue-router'
window.Vue.use(VueRouter);

import example from './components/Example.vue'
import dashboard from './components/Budget/Dashboard.vue'
import tiny_seasons from './components/Budget/Admin/tiny_seasons.vue'
//Vue.component('example',example);
//window.Vue.component('example',require('./components/Example.vue'));

//application routes

//export router instance
const routes = [
    { path: '/budget', component: dashboard },
    { path: '/budget/tiny_seasons', component: tiny_seasons }
]

const router = new VueRouter({
    mode: 'history',
    routes
});

new Vue({
    router,
    el: '#container',
    updated: function () {
        $(this.$el).foundation(); //WORKS!
    },
});
