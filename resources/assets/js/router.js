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
import fiscal_year from './components/Budget/Admin/fiscal_year.vue'
import deprived_area from './components/Budget/Admin/deprived_area.vue'
import budget_season from './components/Budget/Admin/budget_season.vue'
import credit_distribution_row from './components/Budget/Admin/credit_distribution_row.vue'
import season_title from './components/Budget/Admin/season_title.vue'
import plan_cost_title from './components/Budget/Admin/plan_cost_title.vue'
import approved_project from './components/Budget/Aprroved/approved_project.vue'
import approved_plan from './components/Budget/Aprroved/approved_plan.vue'
import approved_cost_program from './components/Budget/Aprroved/approved_cost_program.vue'
import capital_assets_allocation from './components/Budget/Allocation/capital_assets.vue'
import cost_allocation from './components/Budget/Allocation/cost.vue'
import credit_distribution_plan from './components/Budget/CreditDistribution/plan.vue'
import budget_proposal from './components/Budget/CreditDistribution/proposal.vue'

//export router instance
const routes = [
    { path: '/budget', component: dashboard },
    { path: '/budget/admin/season/tiny_seasons', component: tiny_seasons },
    { path: '/budget/admin/fiscal_year', component: fiscal_year },
    { path: '/budget/admin/deprived_area', component: deprived_area },
    { path: '/budget/admin/credit_distribution_def/budget_season', component: budget_season },
    { path: '/budget/admin/season/season_title', component: season_title },
    { path: '/budget/approved/capital_assets/approved/plan', component: approved_plan },
    { path: '/budget/approved/capital_assets/approved/program', component: approved_cost_program },
    { path: '/budget/approved/capital_assets/approved/project', component: approved_project },
    { path: '/budget/admin/credit_distribution_def/row', component: credit_distribution_row },
    { path: '/budget/Allocation/capital_assets', component: capital_assets_allocation },
    { path: '/budget/Allocation/cost', component: cost_allocation },
    { path: '/budget/admin/credit_distribution_def/plan_cost_title', component: plan_cost_title },
    { path: '/budget/admin/credit_distribution/plan', component: credit_distribution_plan },
    { path: '/budget/admin/credit_distribution/proposal', component: budget_proposal },
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
    app.finish();
    return response;
},function (error) {
    console.log(error);
    if (error.response.status == 401)
    {
        app.showModalLogin = true;
    }
    app.fail();
    return Promise.reject(error);
});

axios.interceptors.request.use(function (config) {
    app.start();
    config.headers = JSON.parse(localStorage.getItem("ifab_token_info")); //set headers to config axios request
    return config;
}, function (error) {
    return Promise.reject(error);
});
////////////////////////////// vuex for user authentication manage /////////////////////////////////////
const LOGIN = "LOGIN";
const LOGIN_SUCCESS = "LOGIN_SUCCESS";
const LOGOUT = "LOGOUT";
const USER_IS_ACTIVE = "USER_IS_ACTIVE";
const USER_ISNOT_ACTIVE = "USER_ISNOT_ACTIVE";

const store = new Vuex.Store({
    state: {
        isLoggedIn: !!localStorage.getItem("ifab_token_info"),
        refreshTokenMode: false
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
        },
        [USER_IS_ACTIVE](state) {
            state.refreshTokenMode = true;
        },
        [USER_ISNOT_ACTIVE](state) {
            state.refreshTokenMode = false;
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
        },

        userActive({commit}){
            commit(USER_IS_ACTIVE);
        },

        userNotActive({commit}){
            commit(USER_ISNOT_ACTIVE);
        }
    },

    getters: {
        isLoggedIn: state => {
            return state.isLoggedIn;
        },

        userIsActive: state => {
            return state.refreshTokenMode;
        }
    }
});
///////////////////////////////// main app page /////////////////////////////////
var app = new Vue({
    router,
    store,
    el: '#container',
    data:{
        amountBase: {},
        publicParams: {},
        showModalLogin: false,
        authInfo: {email: '' , password: ''},
        tokenInfo: {"Authorization": '' , "Accept": 'application/json; charset=utf-8' , "Content-type" : 'application/json; charset=utf-8'},
        axiosRequestList: [],
        prevNowPlaying: null
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
            this.getPublicParams();
            this.getAmountBase();
        }
    },

    mounted: function () {
        $.w = $(window);
        $.w.on('resize', function () {
            console.log("......................res..........................");
            var tabHeight = $('.tabs').height();
            var toolBarHeight = $('.tool-bar').height();
            var paginationHeight = $('.pagination').height();
            var notifHeight=25;
            if (toolBarHeight === undefined)
            {
                toolBarHeight = -8;
            }

            if (paginationHeight === undefined)
            {
                paginationHeight = -8;
            }

            if (tabHeight===undefined) {
                if (toolBarHeight > 0)
                    tabHeight = -28;
                else
                    tabHeight = -8;
                notifHeight=0;
            }

            if ($('.vertical-tab').length > 0)
            {
                tabHeight = 10;
            }

            $('.dynamic-height-level1').css('height', ($.w.outerHeight() - 180) + 'px');

            var x = $(".dynamic-height-level1").height();
            $('.dynamic-height-level2').css('height', (x - 100 - (tabHeight  + toolBarHeight + paginationHeight)) + 'px');
        });
        this.myResize();
        this.setExpireTokenThread();
        console.log("mounted router js");
    },

    methods:{
        login: function () {
            axios.post('/api/login' , this.authInfo)
                .then((response) => {
                    //console.log(response.data.refresh_token);
                    this.registerTokenInfo(response.data);
                    this.showModalLogin = false;
                    this.$router.go(this.$router.currentRoute.path); //reload page data
                },(error) => {
                    console.log(error);
                });
        },

        registerTokenInfo: function (data) {
            this.tokenInfo.Authorization = 'Bearer ' + data.access_token;
            //this.tokenInfo.refreshToken = data.refresh_token;
            //localStorage.setItem('ifab_token_expires_in' , data.expires_in);
            this.setExpireTokenThread();
            this.$store.dispatch("login" , this.tokenInfo);
        },

        getPublicParams: function () {
            axios.get('/admin/getPublicParams')
                .then((response) => {
                    console.log(response);
                    this.publicParams = response.data;
                },(error) => {
                    console.log(error);
                });
        },

        getAmountBase: function () {
            axios.get('/admin/getAmountBase')
                .then((response) => {
                    console.log(response.data);
                    this.amountBase = response.data;
                },(error) => {
                    console.log(error);
                });
        },

        calcDispAmount: function (amount , withAmountBase = true) {
            return (amount / this.amountBase.disp_amount_unit.auAmount) + (withAmountBase == true ? ' ' + this.amountBase.disp_amount_unit.auSubject : '');
        },

        calcPrecent: function (y1 , y2) {
            if (y1 == 0 || y2 == 0 )
                return 0;
            else {
                return ((y2 * 100) / y1).toFixed(2) + '%';
            }
        },

        getAmountBaseLabel: function () {
            return this.amountBase.in_put_amount_unit.auSubject;
        },

        getDispAmountBaseLabel: function () {
            return this.amountBase.disp_amount_unit.auSubject;
        },

        displayNotif: function (httpStatusCode) {
            switch (httpStatusCode){
                case 204:
                    this.$notify({title: 'پیام سیستم', text: 'با توجه به وابستگی رکورد ها، حذف رکورد امکان پذیر نیست.' , type: 'error'});
                    break;
                case 200:
                    this.$notify({title: 'پیام سیستم', text: 'درخواست با موفقیت انجام شد.' , type: 'success'});
                    break;
                case 409:
                    this.$notify({title: 'پیام سیستم', text: 'رکورد تکراری است!' , type: 'error'});
                    break;
                case 800: //doesn`t select records
                    this.$notify({title: 'پیام سیستم', text: 'لطفا رکوردهای مورد نظر انتخاب کنید!' , type: 'error'})
            }
        },

        myResize: function() {
            console.log("......................res..........................");
            var tabHeight = $('.tabs').height();
            var toolBarHeight = $('.tool-bar').height();
            var paginationHeight = $('.pagination').height();
            var rowSelected=$('.row-select').height();
            var notifHeight=25;
            if (toolBarHeight === undefined)
            {
                toolBarHeight = -8;
            }

            if (paginationHeight === undefined)
            {
                paginationHeight = -8;
            }

            if (rowSelected === undefined)
            {
                rowSelected = -8;
            }

            if (tabHeight===undefined) {
                if (toolBarHeight > 0)
                    tabHeight = -5;
                else
                    tabHeight = -8;
                notifHeight=0;
            }

            if ($('.vertical-tab').length > 0)
            {
                tabHeight = 10;
            }

            $('.dynamic-height-level1').css('height', ($.w.outerHeight() - 180) + 'px');

            var x = $(".dynamic-height-level1").height();
            $('.dynamic-height-level2').css('height', (x - 100 - (tabHeight  + toolBarHeight + paginationHeight + rowSelected)) + 'px');
        },

        logout: function () {
            this.$store.dispatch("logout");
            this.$router.go(this.$router.currentRoute.path);
        },

        setExpireTokenThread: function () {
            //console.log("......................................................" + localStorage.getItem('ifab_token_expires_in'));
            if (this.prevNowPlaying)
                clearInterval(this.prevNowPlaying);
            this.prevNowPlaying = setInterval(this.expireTokenThread, 900000);
        },

        userIsActive: function () {
            store.dispatch("userActive");
        },

        expireTokenThread: function () {
            console.log("......................................................" + store.getters.userIsActive);
            if (store.getters.userIsActive)
            {
/*                axios.post('/api/refresh_token' , {
                    refresh_token: JSON.parse(localStorage.getItem("ifab_token_info")).refreshToken
                }).then((response) => {
                    store.dispatch("userNotActive");
                    this.registerTokenInfo(response.data);
                }, (error) => {
                    this.showModalLogin = true;
                    this.fail();
                });*/
                store.dispatch("userNotActive");
                this.setExpireTokenThread();
            }else{
                clearInterval(this.prevNowPlaying);
                this.$store.dispatch("logout");
                this.showModalLogin = true;
            }
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

