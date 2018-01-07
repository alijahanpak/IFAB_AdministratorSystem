/**
 * Created by ammorteza on 9/21/17.
 */
import VueRouter from 'vue-router'
import Acl from 'vue-acl'
import Vuex from 'vuex'
window.Vue.use(VueRouter);
window.Vue.use(Vuex);
///////////////////////////// router ///////////////////////////////////
import accessDenied from './public_component/AccessDenied.vue'
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

////////////////////////////////////////////////////////////////////////////
import fdDashboard from './components/FinancialDepartment/Dashboard.vue'

//export router instance
const routes = [
    { path: '/accessDenied', component: accessDenied , meta:{permission: 'public'}},
    { path: '/budget', component: dashboard , meta:{permission: 'BUDGET_DASHBOARD_DISPLAY'}},
    { path: '/budget/admin/season/tiny_seasons', component: tiny_seasons , meta:{permission: 'BUDGET_ADMIN_TINY_SEASON_DISPLAY'}},
    { path: '/budget/admin/fiscal_year', component: fiscal_year , meta:{permission: 'BUDGET_ADMIN_FISCAL_YEARS_DISPLAY'} },
    { path: '/budget/admin/deprived_area', component: deprived_area ,meta:{permission: 'BUDGET_ADMIN_DEPRIVED_AREA_DISPLAY'}},
    { path: '/budget/admin/credit_distribution_def/budget_season', component: budget_season ,meta:{permission: 'BUDGET_ADMIN_BUDGET_SEASON_DISPLAY'}},
    { path: '/budget/admin/season/season_title', component: season_title , meta:{permission: 'BUDGET_ADMIN_SEASON_TITLE_DISPLAY'}},
    { path: '/budget/approved/capital_assets/approved/plan', component: approved_plan , meta:{permission: 'BUDGET_CAPITAL_ASSETS_APPROVED_PLAN_DISPLAY'}},
    { path: '/budget/approved/capital_assets/approved/program', component: approved_cost_program , meta:{permission: 'BUDGET_COST_APPROVED_PROG_DISPLAY'}},
    { path: '/budget/approved/capital_assets/approved/project', component: approved_project , meta:{permission: 'BUDGET_CAPITAL_ASSETS_APPROVED_PROJECT_DISPLAY'}},
    { path: '/budget/admin/credit_distribution_def/row', component: credit_distribution_row , meta:{permission: 'BUDGET_ADMIN_CREDIT_DISTRIBUTION_ROW_DISPLAY'}},
    { path: '/budget/Allocation/capital_assets', component: capital_assets_allocation , meta:{permission: 'BUDGET_CAPITAL_ASSETS_ALLOCATION_DISPLAY'}},
    { path: '/budget/Allocation/cost', component: cost_allocation , meta:{permission: 'BUDGET_COST_ALLOCATION_DISPLAY'}},
    { path: '/budget/admin/credit_distribution_def/plan_cost_title', component: plan_cost_title , meta:{permission: 'BUDGET_ADMIN_PLAN_RO_COST_TITLE_DISPLAY'}},
    { path: '/budget/admin/credit_distribution/plan', component: credit_distribution_plan , meta:{permission: 'BUDGET_CREDIT_DISTRIBUTION_PLAN_DISPLAY'}},
    { path: '/budget/admin/credit_distribution/proposal', component: budget_proposal , meta:{permission: 'BUDGET_CREDIT_DISTRIBUTION_PROPOSAL_DISPLAY'}},
    /////////////////////// financial department //////////////////////////
    { path: '/financial_department', component: fdDashboard , meta:{permission: 'public'}},
]

const router = new VueRouter({
    routes
});
///////////////////////////////////////////////////////////////////////
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
    config.headers = JSON.parse(sessionStorage.getItem("ifab_token_info")); //set headers to config axios request
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
        isLoggedIn: !!sessionStorage.getItem("ifab_token_info"),
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
                sessionStorage.setItem('ifab_token_info' , JSON.stringify(creds));
                commit(LOGIN_SUCCESS);
                resolve();
            });
        },

        logout({ commit }) {
            sessionStorage.removeItem("ifab_token_info");
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
////////////////////////////////////////////////////////////////////////////////
window.Vue.use( Acl, { router: router, init: 'public' , save: true , fail: '/accessDenied'} );
///////////////////////////////// main app page /////////////////////////////////
import myUpload from 'vue-image-crop-upload';
var app = new Vue({
    router,
    store,
    components: {
        'my-upload': myUpload
    },
    el: '#container',
    data:{
        show: true,
        allAmountBase: {},
        amountBase: {},
        publicParams: {},
        fiscalYears: {},
        rolePermission:{},
        changePassInput:{},
        currentAabLabel:'',
        nPassword:'',
        reNPassword:'',
        userInfo: {name: '...' , role:{rSubject: '...'} , avatarPath: null},
        showModalLogin: false,
        showModalUserSetting: false,
        authInfo: {email: '' , password: ''},
        tokenInfo: {"Authorization": '' , "Accept": 'application/json; charset=utf-8' , "Content-type" : 'application/json; charset=utf-8'},
        axiosRequestList: [],
        prevNowPlaying: null,
        showUploadFile: false,
        params: {
        },

        headers: {Authorization:'' , Accept: 'application/json'},
        imgDataUrl: window.hostname + '/pic/avatars/avatar.jpg', // the datebase64 url of created image
        uploadUrl: window.hostname + '/admin/user/uploadAvatar'
    },

    updated: function () {
        $(this.$el).foundation(); //WORKS!
        this.fixedLoginFrame();
        this.fixedAccessDeniedFrame();
        console.log('user permission in acl = ' + this.access);
    },

    created: function () {
        this.setExpireTokenThread();
        var tokenInfo = JSON.parse(sessionStorage.getItem("ifab_token_info"));
        this.headers.Authorization = tokenInfo.Authorization;
    },

    mounted: function () {
        $.w = $(window);
        $.w.on('resize', function () {
            var tabHeight = $('.tabs').height();
            var toolBarHeight = $('.tool-bar').height();
            var paginationHeight = $('.pagination').height();
            var notifHeight = 25;
            if (toolBarHeight === undefined)
            {
                toolBarHeight = -8;
            }

            if (tabHeight===undefined) {
                if (toolBarHeight > 0)
                    tabHeight = -5;
                else
                    tabHeight = 0;
            }

            if ($('.vertical-tab').length > 0)
            {
                tabHeight = 10;
            }

            if (paginationHeight === undefined)
            {
                if (tabHeight === undefined)
                    paginationHeight = -50;
                else
                    paginationHeight = -5;
            }

            $('.dynamic-height-level1').css('height', ($.w.outerHeight() - 180) + 'px');
            var x = $(".dynamic-height-level1").height();
            $('.dynamic-height-level2').css('height', (x - 90 - (tabHeight  + toolBarHeight + paginationHeight)) + 'px');
        });
        this.myResize();
        if (!store.getters.isLoggedIn)
        {
            this.showModalLogin = true;
        }
        else{
            this.getFiscalYear();
            this.getPublicParams();
            this.getAmountBase();
            this.getAllAmountBase();
        }
        console.log("mounted router js");
    },

    methods:{
        login: function () {
            axios.post('/api/login' , this.authInfo)
                .then((response) => {
                    //console.log(response.data.refresh_token);
                    this.registerTokenInfo(response.data);
                    axios.get('/admin/user/getRoleAndPermissions')
                        .then((response) => {
                            this.rolePermission = response.data;
                            var accessPermissions = '';
                            this.rolePermission.role_permission.forEach((roleP) => {
                                console.log('..................' + roleP.permission.pPermission);
                                accessPermissions += roleP.permission.pPermission + '&';
                            });
                            this.access = accessPermissions;
                            this.showModalLogin = false;
                            if (this.rolePermission.rRole == sessionStorage.getItem("ifab_lastUserRole"))
                            {
                                sessionStorage.setItem('ifab_lastUserRole' , this.rolePermission.rRole);
                                window.location.href = window.hostname + '#' + this.$router.currentRoute.path;
                            }
                            else if (this.rolePermission.rRole == 'BUDGET_ADMIN' || this.rolePermission.rRole == 'BUDGET_EXPERT')
                            {
                                sessionStorage.setItem('ifab_lastUserRole' , this.rolePermission.rRole);
                                window.location.href = window.hostname + '#/budget';
                            }
                            else if (this.rolePermission.rRole == 'FINANCIAL_DEPARTMENT_ADMIN' || this.rolePermission.rRole == 'FINANCIAL_DEPARTMENT_EXPERT')
                            {
                                sessionStorage.setItem('ifab_lastUserRole' , this.rolePermission.rRole);
                                window.location.href = window.hostname + '#/financial_department';
                            }
                        },(error) => {
                            console.log(error);
                            this.displayNotif(error.response.status);
                     });
                },(error) => {
                    console.log(error);
                    this.displayNotif(error.response.status);
                });
        },

        openModalUserSetting: function () {
            this.showModalUserSetting=true;
        },

        getUserRole: function () {
            return sessionStorage.getItem("ifab_lastUserRole");
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

        getUserInfo: function () {
            axios.get('/api/getAuthUserInfo')
                .then((response) => {
                    console.log(response);
                    this.userInfo = response.data;
                    this.fiscalYears.forEach(fy => {
                        if (this.currentFyId() == fy.id)
                            this.currentFyLabel = fy.fyLabel;
                    })
                    if(this.userInfo.avatarPath !=null){
                        this.imgDataUrl= this.userInfo.avatarPath;
                    }
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
        getAllAmountBase: function () {
            axios.get('/admin/getAllAmountBase')
                .then((response) => {
                    console.log(response.data);
                    this.allAmountBase = response.data;
                },(error) => {
                    console.log(error);
                });
        },

        calcDispAmount: function (amount , withAmountBase = true , withFormattedMoney = true) {
            return (withFormattedMoney == true ? (amount / this.amountBase.disp_amount_unit.auAmount).toLocaleString('en' , {maximumFractionDigits : 20}) : (amount / this.amountBase.disp_amount_unit.auAmount)) + (withAmountBase == true ? ' ' + this.amountBase.disp_amount_unit.auSubject : '');
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

        getFiscalYear: function () {
            axios.get('/budget/admin/fiscal_year/fetchAllFiscalYears')
                .then((response) => {
                    this.fiscalYears = response.data;
                    this.getUserInfo();
                },(error) => {
                    console.log(error);
                });
        },

        changeFiscalYear: function (fyId) {
            axios.post('/budget/admin/fiscal_year/changeFiscalYear' , {fyId: fyId})
                .then((response) => {
                    location.reload();
                },(error) => {
                    console.log(error);
                });
        },

        changeAllAmountBase: function (auId) {
            axios.post('/admin/user/changeAmountBase' , {auId: auId})
                .then((response) => {
                    location.reload();
                },(error) => {
                    console.log(error);
                });
        },

        changePassword: function () {
                this.$validator.validateAll().then((result) => {
                    if (result) {
                        axios.post('/api/resetPassword', {
                            password: this.changePassInput.password,
                            newPassword: this.changePassInput.newPassword
                        })
                        .then((response) => {
                            this.logout();
                            //this.$parent.displayNotif(response.status);
                        }, (error) => {
                            console.log(error);
                        });
                    }

                });
        },

        toggleShow() {
            this.showUploadFile = !this.showUploadFile;
            console.log('......................... toggle upload avatar');
        },

        cropSuccess(imgDataUrl, field){
            console.log('-------- crop success --------' + imgDataUrl);
            this.imgDataUrl = imgDataUrl;
        },
        /**
         * upload success
         *
         * [param] jsonData  server api return data, already json encode
         * [param] field
         */
        cropUploadSuccess(jsonData, field){
            console.log('-------- upload success --------');
            console.log(jsonData);
            console.log('field: ' + field);
        },
        /**
         * upload fail
         *
         * [param] status    server api return error status, like 500
         * [param] field
         */
        cropUploadFail(status, field){
            console.log('-------- upload fail --------');
            console.log(status);
            console.log('field: ' + field);
        },

        displayNotif: function (httpStatusCode) {
            switch (httpStatusCode){
                case 10:
                    this.$notify({title: 'پیام سیستم', text: 'تکرار رمز عبور جدید اشتباه است!' , type: 'error'});
                    this.$refs.errorAlarm.play();
                    break;
                case 204:
                    this.$notify({title: 'پیام سیستم', text: 'با توجه به وابستگی رکورد ها، حذف رکورد امکان پذیر نیست.' , type: 'error'});
                    this.$refs.errorAlarm.play();
                    break;
                case 200:
                    this.$notify({title: 'پیام سیستم', text: 'درخواست با موفقیت انجام شد.' , type: 'success'});
                    this.$refs.successAlarm.play();
                    break;
                case 409:
                    this.$notify({title: 'پیام سیستم', text: 'رکورد تکراری است!' , type: 'error'});
                    this.$refs.successAlarm.play();
                    break;
                case 401:
                    this.$notify({title: 'پیام سیستم', text: 'نام کاربر یا کلمه عبور اشتباه است!' , type: 'error'});
                    this.$refs.errorAlarm.play();
                    break;
                case 800: //doesn`t select records
                    this.$notify({title: 'پیام سیستم', text: 'لطفا رکوردهای مورد نظر انتخاب کنید!' , type: 'error'});
                    this.$refs.errorAlarm.play();
                case 500: //doesn`t select records
                    this.$notify({title: 'پیام سیستم', text: 'خطای داخلی رخ داده است، با مدیر سیستم تماس بگیرید!' , type: 'error'});
                    this.$refs.errorAlarm.play();
            }
        },

        myResize: function() {
            console.log("......................res..........................");
            var tabHeight = $('.tabs').height();
            var toolBarHeight = $('.tool-bar').height();
            var paginationHeight = $('.pagination').height();
            var notifHeight=25;
            if (toolBarHeight === undefined)
            {
                toolBarHeight = -8;
            }

            if (tabHeight===undefined) {
                if (toolBarHeight > 0)
                    tabHeight = -5;
                else
                    tabHeight = 0;
            }

            if ($('.vertical-tab').length > 0)
            {
                tabHeight = 10;
            }

            if (paginationHeight === undefined)
            {
                if (tabHeight === undefined)
                    paginationHeight = -50;
                else
                    paginationHeight = -5;
            }

            console.log('...........' + paginationHeight);

            $('.dynamic-height-level1').css('height', ($.w.outerHeight() - 180) + 'px');
            var x = $(".dynamic-height-level1").height();
            $('.dynamic-height-level2').css('height', (x - 90 - (tabHeight  + toolBarHeight + paginationHeight)) + 'px');
        },

        fixedLoginFrame: function() {
            if (this.showModalLogin == true)
            {
                var loginFrame = $('.login-frame').height();

                var x = $.w.innerHeight();
                var temp = (x - loginFrame) / 2;
                $('.login-frame').css('margin-top', temp + 'px');
            }
        },

        fixedAccessDeniedFrame: function() {
            var accessDeniedFrame = $('.accessDenied-frame').height();
            var x = $.w.innerHeight();
            var temp = (x - accessDeniedFrame) / 2;
            $('.accessDenied-frame').css('margin-top', temp + 'px');

        },

        logout: function () {
            this.$store.dispatch("logout");
            this.$router.go(this.$router.currentRoute.path);
        },

        setExpireTokenThread: function () {
            if (this.prevNowPlaying)
                clearInterval(this.prevNowPlaying);
            this.prevNowPlaying = setInterval(this.expireTokenThread, 600000);
        },

        currentFyId: function () {
            return this.userInfo.seFiscalYear;
        },

        currentUserName: function () {
            return this.userInfo.name;
        },

        userIsActive: function () {
            store.dispatch("userActive");
        },
        currentAllAmountBase: function () {
            return this.amountBase.id;
        },


        expireTokenThread: function () {
            console.log("......................................................" + store.getters.userIsActive);
            if (store.getters.userIsActive)
            {
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


