/**
 * Created by ammorteza on 9/21/17.
 */
import VueRouter from 'vue-router'
import Vuex from 'vuex'
window.Vue.use(VueRouter);
window.Vue.use(Vuex);
///////////////////////////// router ///////////////////////////////////
import dashboard from './components/Budget/Dashboard.vue'
import tiny_seasons from './components/Budget/Admin/tiny_seasons.vue'
import fiscal_year from './components/Budget/Admin/fiscalYear.vue'
//export router instance
const routes = [
    { path: '/budget', component: dashboard },
    { path: '/budget/admin/tiny_seasons', component: tiny_seasons },
    { path: '/budget/admin/fiscal_year', component: fiscal_year }
]

const router = new VueRouter({
    routes
});

router.afterEach((to, from, next) => {
    if (!store.getters.isLoggedIn)
    {
        app.showModalLogin = true;
    }
});
/////////////////////// config axios request /////////////////////////////////////
axios.interceptors.response.use(response => {
    return response;
},function (error) {
    console.log(error);
    if (error.response.status == 401)
    {
        app.showModalLogin = true;
    }
    return Promise.reject(error);
});

axios.interceptors.request.use(function (config) {
    config.headers = JSON.parse(localStorage.getItem("ifab_token_info")); //set headers to config axios request
    return config;
}, function (error) {
    return Promise.reject(error);
});
////////////////////////////// vuex for user authentication manage /////////////////////////////////////
const LOGIN = "LOGIN";
const LOGIN_SUCCESS = "LOGIN_SUCCESS";
const LOGOUT = "LOGOUT";

const store = new Vuex.Store({
    state: {
        isLoggedIn: !!localStorage.getItem("ifab_token_info")
    },
    mutations: {
        [LOGIN] (state) {
            state.pending = true;
        },
        [LOGIN_SUCCESS] (state) {
            state.isLoggedIn = true;
            state.pending = false;
        },
        [LOGOUT](state) {
            state.isLoggedIn = false;
        }
    },

    actions: {
        login({ commit }, creds) {
            commit(LOGIN); // show spinner
            return new Promise(resolve => {
                localStorage.setItem('ifab_token_info' , JSON.stringify(creds));
                commit(LOGIN_SUCCESS);
                resolve();
            });
        },

        logout({ commit }) {
            localStorage.removeItem("ifab_token_info");
            commit(LOGOUT);
        }
    },

    getters: {
        isLoggedIn: state => {
            return state.isLoggedIn
        }
    }
});
///////////////////////////////// main app page /////////////////////////////////
var app = new Vue({
    router,
    store,
    el: '#container',
    data:{
        showModalLogin: false,
        authInfo: {email: '' , password: ''},
        tokenInfo: {"Authorization": '' , "Accept": 'application/json; charset=utf-8' , "Content-type" : 'application/json; charset=utf-8'}
    },
    updated: function () {
        $(this.$el).foundation(); //WORKS!

    },

    created: function () {
        if (!store.getters.isLoggedIn)
        {
            this.showModalLogin = true;
        }
    },

    methods:{
        login: function () {
            axios.post('/api/login' , this.authInfo)
                .then((response) => {
                    console.log(response);
                    this.tokenInfo.Authorization = 'Bearer ' + response.data.access_token;
                    this.$store.dispatch("login" , this.tokenInfo);
                    this.showModalLogin = false;
                    this.$router.go(this.$router.currentRoute.path); //for reload page data
                },(error) => {
                    console.log(error);
                });
        },

        logout: function () {
            this.$store.dispatch("logout");
            this.$router.go(this.$router.currentRoute.path);
        },

        start () {
            this.$Progress.start()
        },
        set (num) {
            this.$Progress.set(num)
        },
        increase (num) {
            this.$Progress.increase(num)
        },
        decrease (num) {
            this.$Progress.decrease(num)
        },
        finish () {
            this.$Progress.finish()
        },
        fail () {
            this.$Progress.fail()
        },
    }
});

