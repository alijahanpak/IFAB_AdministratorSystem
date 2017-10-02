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
//export router instance
const routes = [
    { path: '/budget', component: dashboard },
    { path: '/budget/tiny_seasons', component: tiny_seasons }
]

const router = new VueRouter({
    routes
});

router.afterEach((to, from, next) => {
    if (!store.getters.isLoggedIn)
    {
        app.showModalLogin = true;
    }
    else{
        axios.post('/api/userIsAuthorize' , null ,{headers: JSON.parse(localStorage.getItem("ifab_token_info"))})
            .then((response) => {
                console.log(response);
                next();
            },(error) => {
                app.showModalLogin = true;
                console.log(error);
            });
    }
});
////////////////////////////// vuex /////////////////////////////////////
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
        tokenInfo: {Authorization: '' , Accept: 'application/json'}
    },
    updated: function () {
        $(this.$el).foundation(); //WORKS!

    },

    created: function () {
        if (!store.getters.isLoggedIn)
        {
            this.showModalLogin = true;
        }
        else{
            axios.post('/api/userIsAuthorize' , null ,{headers: JSON.parse(localStorage.getItem("ifab_token_info"))})
                .then((response) => {
                    console.log(response);
                },(error) => {
                    this.showModalLogin = true;
                    console.log(error);
                });
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
                },(error) => {
                    console.log(error);
                });
        },
    }
});

