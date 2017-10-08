<template xmlns:v-on="http://www.w3.org/1999/xhtml">
    <!--Inner body start-->
    <div class="medium-10 border-right-line inner-body-pad main-margin">
        <div style="padding-top: 15px;" class="grid-x padding-lr">
            <div class="medium-12">
                <div class="grid-x">
                    <nav aria-label="You are here:" role="navigation">
                        <ul class="breadcrumbs">
                            <li><router-link to="/budget">داشبورد</router-link></li>
                            <li>
                                <a class="disabled">مدیریت</a>
                            </li>
                            <li>
                                <span class="show-for-sr">Current: </span>عنوان فصل
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
        <div class="grid-x my-callout-box container-mrg-top dynamic-height-level1">
            <div class="medium-12 column">
                <ul class="tabs tab-color my-tab-style" data-responsive-accordion-tabs="tabs medium-accordion large-tabs" id="season_title_tab_view">
                    <li class="tabs-title is-active"><a href="#capital_assets" aria-selected="true">تملک دارایی سرمایه ای</a></li>
                    <li class="tabs-title"><a href="#cost">هزینه ای</a></li>
                </ul>
                <div class="tabs-content" data-tabs-content="season_title_tab_view">
                    <!--Tab 1-->
                    <div class="tabs-panel is-active table-mrg-btm" id="capital_assets"
                         xmlns:v-on="http://www.w3.org/1999/xhtml">
                        <div class="medium-12 bottom-mrg">
                            <div class="clearfix border-btm-line bottom-mrg tool-bar">
                                <div style="margin-top: 2px;" class="button-group float-right report-mrg">
                                    <a class="my-button toolbox-btn small" @click="planOrCost = 0; showModal = true; errorMessage = ''">جدید</a>
                                    <a class="my-button toolbox-btn small">گزارش</a>
                                    <button class="my-button toolbox-btn small dropdown small sm-btn-align"  type="button" data-toggle="assetsDropDown">تعداد نمایش<span> 20 </span></button>
                                    <div  style="width: 113px;" class="dropdown-pane dropdown-pane-sm " data-close-on-click="true"  data-hover="true" data-hover-pane="true"  data-position="bottom" data-alignment="left" id="assetsDropDown" data-dropdown data-auto-focus="true">
                                        <ul class="my-menu small-font ltr-dir">
                                            <li><a  href="#">10</a></li>
                                            <li><a  href="#">20<span class="fi-check checked-color size-14"></span></a></li>
                                            <li><a  href="#">30</a></li>
                                            <li><a  href="#">50</a></li>
                                            <li><a  href="#">100</a></li>
                                            <li><a  href="#">200</a></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="float-left">
                                    <div class="input-group float-left">
                                        <input class="input-group-field small-font" type="text">
                                        <div class="input-group-button">
                                            <button type="button" class="my-button my-brand"><i class="fi-magnifying-glass"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--Table Start-->
                            <div class="columns">
                                <!--Header Start-->
                                <div class="grid-x table-header">
                                    <div class="medium-2 table-border">
                                        <strong>فصل</strong>
                                    </div>
                                    <div class="medium-10">
                                        <div class="grid-x">
                                            <div class="medium-8 table-border">
                                                <strong>عنوان فصل</strong>
                                            </div>
                                            <div class="medium-4  table-border">
                                                <strong>شرح</strong>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--Header End-->
                                <div class="table-contain dynamic-height-level2">
                                    <div class="grid-x" v-for="">
                                        <div class="medium-2 table-contain-border cell-vertical-center">

                                        </div>
                                        <div class="medium-10">
                                            <div class="grid-x" v-for="">
                                                <div class="medium-8 table-contain-border cell-vertical-center">

                                                </div>
                                                <div class="medium-4 table-contain-border cell-vertical-center">
                                                    <div class="grid-x">
                                                        <div class="medium-11">

                                                        </div>
                                                        <div class="medium-1 cell-vertical-center text-left">
                                                            <a class="dropdown small sm-btn-align"  type="button" :data-toggle="'stSeasonTitle'"><i class="fa fa-ellipsis-v size-18"></i></a>
                                                            <div class="dropdown-pane dropdown-pane-sm " data-close-on-click="true"  data-hover="true" data-hover-pane="true"  data-position="bottom" data-alignment="right" :id="'stSeasonTitle'" data-dropdown data-auto-focus="true">
                                                                <ul class="my-menu small-font text-right">
                                                                    <li><a v-on:click.prevent="seasonTitleUpdateDialog(capitalAssetsSeasonTitle , 0)"><i class="fa fa-pencil-square-o size-16"></i>  ویرایش</a></li>
                                                                    <li><a v-on:click.prevent="openDeleteSeasonTitleConfirm(capitalAssetsSeasonTitle)"><i class="fa fa-trash-o size-16"></i>  حذف</a></li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="grid-x">
                                    <div class="medium-12">
                                        <vue-pagination  v-bind:pagination="plan_pagination"
                                                         v-on:click.native="fetchCapitalAssetsData(plan_pagination.current_page)"
                                                         :offset="4">
                                        </vue-pagination>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--Tab 1-->
                    <!--Tab 2-->
                    <div class="tabs-panel table-mrg-btm" id="cost" xmlns:v-on="http://www.w3.org/1999/xhtml">
                        <div class="">
                            <div class="medium-12 bottom-mrg">
                                <div class="clearfix border-btm-line bottom-mrg">
                                    <div style="margin-top: 2px;" class="button-group float-right report-mrg">
                                        <a class="my-button toolbox-btn small" @click="planOrCost = 1; showModal = true; errorMessage = ''">جدید</a>
                                        <a class="my-button toolbox-btn small">گزارش</a>
                                        <button class="my-button toolbox-btn small dropdown small sm-btn-align"  type="button" data-toggle="costDropDown">تعداد نمایش<span> 20 </span></button>
                                        <div style="width: 113px;" class="dropdown-pane dropdown-pane-sm " data-close-on-click="true"  data-hover="true" data-hover-pane="true"  data-position="bottom" data-alignment="left" id="costDropDown" data-dropdown data-auto-focus="true">
                                            <ul class="my-menu small-font ltr-dir">
                                                <li><a  href="#">10</a></li>
                                                <li><a  href="#">20<span class="fi-check checked-color size-14"></span></a></li>
                                                <li><a  href="#">30</a></li>
                                                <li><a  href="#">50</a></li>
                                                <li><a  href="#">100</a></li>
                                                <li><a  href="#">200</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="float-left">
                                        <div class="input-group float-left">
                                            <input class="input-group-field small-font" type="text">
                                            <div class="input-group-button">
                                                <button type="button" class="my-button my-brand"><i class="fi-magnifying-glass"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--Table Start-->
                                <div class="columns">
                                    <!--Header Start-->
                                    <div class="grid-x table-header">
                                        <div class="medium-2 table-border">
                                            <strong>فصل</strong>
                                        </div>
                                        <div class="medium-10">
                                            <div class="grid-x">
                                                <div class="medium-8 table-border">
                                                    <strong>عنوان فصل</strong>
                                                </div>
                                                <div class="medium-4  table-border">
                                                    <strong>شرح</strong>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!--Header End-->
                                    <div class="table-contain dynamic-height-level2">
                                        <div class="grid-x" v-for="">
                                            <div class="medium-2 table-contain-border cell-vertical-center">

                                            </div>
                                            <div class="medium-10">
                                                <div class="grid-x" v-for="">
                                                    <div class="medium-8 table-contain-border cell-vertical-center">

                                                    </div>
                                                    <div class="medium-4 table-contain-border cell-vertical-center">
                                                        <div class="grid-x">
                                                            <div class="medium-11">

                                                            </div>
                                                            <div class="medium-1 cell-vertical-center text-left">
                                                                <a class="dropdown small sm-btn-align"  type="button" :data-toggle="'stSeasonTitle'"><i class="fa fa-ellipsis-v size-18"></i></a>
                                                                <div class="dropdown-pane dropdown-pane-sm " data-close-on-click="true"  data-hover="true" data-hover-pane="true"  data-position="bottom" data-alignment="right" :id="'stSeasonTitle'" data-dropdown data-auto-focus="true">
                                                                    <ul class="my-menu small-font text-right">
                                                                        <li><a v-on:click.prevent="seasonTitleUpdateDialog(capitalAssetsSeasonTitle , 0)"><i class="fa fa-pencil-square-o size-16"></i>  ویرایش</a></li>
                                                                        <li><a v-on:click.prevent="openDeleteSeasonTitleConfirm(capitalAssetsSeasonTitle)"><i class="fa fa-trash-o size-16"></i>  حذف</a></li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="grid-x">
                                        <div class="medium-12">
                                            <vue-pagination  v-bind:pagination="cost_pagination"
                                                             v-on:click.native="fetchCostData(cost_pagination.current_page)"
                                                             :offset="4">
                                            </vue-pagination>
                                        </div>
                                    </div>
                                </div>
                           </div>
                        </div>
                    </div>
                    <!--Tab 2-->
                    <notifications group="seasonTitlePm"
                                   position="bottom right"
                                   animation-type="velocity"
                                   :speed="700" />
                </div>
                <!--<modal-tiny v-if="showModal" @close="showModal = false">
                    <div  slot="body">
                        <form v-on:submit.prevent="createSeasonTitle">
                            <div class="grid-x" v-if="errorMessage">
                                <div class="medium-12 columns padding-lr">
                                    <div class="alert callout">
                                        <p class="BYekan login-alert"><i class="fi-alert"></i>{{ errorMessage }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="grid-x">
                                <div class="medium-12 cell padding-lr">
                                    <label>فصل
                                        <select class="form-element-margin-btm" v-model="seasonTitleInput.stSeason" name="sId" v-validate data-vv-rules="required" :class="{'input': true, 'select-error': errors.has('sId')}">
                                            <option value=""></option>
                                            <option v-for="season in seasons" :value="season.id">{{ season.stSeason }}</option>
                                        </select>
                                        <span v-show="errors.has('sId')" class="error-font">لطفا فصل را انتخاب کنید!</span>
                                    </label>
                                </div>
                            </div>
                            <div class="grid-x">
                                <div class="medium-12 cell padding-lr">
                                    <label>عنوان فصل
                                        <select class="form-element-margin-btm" v-model="seasonTitleInput.stSubject" name="sSubject" v-validate data-vv-rules="required" :class="{'input': true, 'select-error': errors.has('sSubject')}">
                                            <option value=""></option>
                                            <option v-for="season in seasons" :value="season.id">{{ season.stSubject }}</option>
                                        </select>
                                        <span v-show="errors.has('sSubject')" class="error-font">لطفا عنوان فصل انتخاب کنید!</span>
                                    </label>
                                </div>
                            </div>

                            <div class="grid-x">
                                <div class="small-12 columns padding-lr">
                                    <label>شرح
                                        <textarea name="tsDescription" style="min-height: 150px;" v-model="seasonTitleInput.stDescription"></textarea>
                                    </label>
                                </div>
                            </div>
                            <div class="medium-6 columns padding-lr padding-bottom-modal">
                                <button name="Submit" class="my-button my-success float-left btn-for-load"> <span class="btn-txt-mrg">ثبت</span></button>
                            </div>
                        </form>
                    </div>
                </modal-tiny>
                &lt;!&ndash; update modal &ndash;&gt;
                <modal-tiny v-if="showModalUpdate" @close="showModalUpdate = false">
                    <div  slot="body">
                        <form v-on:submit.prevent="updateSeasonTitle">
                            <div class="grid-x" v-if="errorMessage_update">
                                <div class="medium-12 columns padding-lr">
                                    <div class="alert callout">
                                        <p class="BYekan login-alert"><i class="fi-alert"></i>{{ errorMessage_update }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="grid-x">
                                <div class="medium-12 cell padding-lr">
                                    <label>فصل
                                        <select class="form-element-margin-btm" v-model="seasonTitleInput.stSeason" name="sId" v-validate data-vv-rules="required" :class="{'input': true, 'select-error': errors.has('sId')}">
                                            <option value=""></option>
                                            <option v-for="season in seasons" :value="season.id">{{ season.stSeason }}</option>
                                        </select>
                                        <span v-show="errors.has('sId')" class="error-font">لطفا فصل را انتخاب کنید!</span>
                                    </label>
                                </div>
                            </div>
                            <div class="grid-x">
                                <div class="medium-12 cell padding-lr">
                                    <label>عنوان فصل
                                        <select class="form-element-margin-btm" v-model="seasonTitleInput.stSubject" name="sSubject" v-validate data-vv-rules="required" :class="{'input': true, 'select-error': errors.has('sSubject')}">
                                            <option value=""></option>
                                            <option v-for="season in seasons" :value="season.id">{{ season.stSubject }}</option>
                                        </select>
                                        <span v-show="errors.has('sSubject')" class="error-font">لطفا عنوان فصل انتخاب کنید!</span>
                                    </label>
                                </div>
                            </div>

                            <div class="grid-x">
                                <div class="small-12 columns padding-lr">
                                    <label>شرح
                                        <textarea name="tsDescription" style="min-height: 150px;" v-model="seasonTitleInput.stDescription"></textarea>
                                    </label>
                                </div>
                            </div>
                            <div class="grid-x">
                                <div class="small-12 columns padding-lr">
                                    <label>شرح
                                        <textarea name="tsDescription" style="min-height: 150px;" v-model="tinySeasonsFill.tsDescription"></textarea>
                                    </label>
                                </div>
                            </div>
                            <div class="medium-6 columns padding-lr padding-bottom-modal">
                                <button name="Submit" class="my-secondary button float-left btn-for-load"> <span class="btn-txt-mrg">ثبت</span></button>
                            </div>
                        </form>
                    </div>
                </modal-tiny>
                &lt;!&ndash; delete modal &ndash;&gt;-->
                <modal-tiny v-if="showModalDelete" @close="showModalDelete = false">
                    <div  slot="body">
                        <div class="small-font" xmlns:v-on="http://www.w3.org/1999/xhtml">
                            <p>کاربر گرامی</p>
                            <p class="large-offset-1 modal-text">برای حذف رکورد مورد نظر اطمینان دارید؟</p>
                            <div class="grid-x">
                                <div class="medium-12 column text-center">
                                    <button  class="button primary btn-large-w" v-on:click="deleteTinySeason">بله</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </modal-tiny>
            </div>
        </div>
    </div>
</template>
<script>
    import VuePagination from '../../../public_component/pagination.vue';
    export default {
        data(){
            return {
                planOrCost: 0,
                errorMessage: '',
                errorMessage_update: '',
                season_title: [],
                seasonTitleCost: [],
                seasonTitleInput: {stSeason: '' , stSubject: '' , stDescription: '' , planOrCost: ''},
                showModal: false,
                showModalUpdate: false,
                showModalDelete: false,
                seasonTitleFill: {stSeason: '' , stSubject: '' , stDescription: '' , planOrCost: '' , id: ''},
                stIdDelete: {},
                seasons: {},
                cost_pagination: {
                    total: 0,
                    to: 0,
                    current_page: 1,
                    last_page: ''
                },

                plan_pagination: {
                    total: 0,
                    to: 0,
                    current_page: 1,
                    last_page: ''
                },
            }
        },

        created: function () {
            this.fetchCostData();
            this.fetchCapitalAssetsData();
            this.getSeasons();
        },

        updated: function () {
            $(this.$el).foundation(); //WORKS!
        },

        mounted: function () {
            console.log("mounted season title component");
            res();
        },

        components:{
            'vue-pagination' : VuePagination
        },

        methods:{
            /*fetchCapitalAssetsData: function (page = 1) {
                this.$root.start();
                axios.get('/budget/admin/sub_seasons/capital_assets/fetchData?page=' + page)
                    .then((response) => {
                        this.tinySeasons = response.data.data;
                        this.makePagination(response.data , "plan");
                        console.log(response.data);
                        this.$root.finish();
                    },(error) => {
                        console.log(error);
                        this.$root.fail();
                    });*/
            },

            fetchCostData: function (page = 1) {
                /*this.$root.start();
                axios.get('/budget/admin/sub_seasons/cost/fetchData?page=' + page)
                    .then((response) => {
                        this.tinySeasonsCost = response.data.data;
                        this.makePagination(response.data , "cost");
                        console.log(response.data);
                        this.$root.finish();
                    },(error) => {
                        console.log(error);
                        this.$root.fail();
                    });*/
            },

            makePagination: function(data , type){
                if (type == "cost")
                {
                    this.cost_pagination.current_page = data.current_page;
                    this.cost_pagination.to = data.to;
                    this.cost_pagination.last_page = data.last_page;
                }else if (type == "plan")
                {
                    this.plan_pagination.current_page = data.current_page;
                    this.plan_pagination.to = data.to;
                    this.plan_pagination.last_page = data.last_page;
                }
            },

            getSeasons: function () {
                this.$root.start();
                axios.get('/admin/get_all_seasons')
                    .then((response) => {
                        this.seasons = response.data;
                        console.log(response);
                        this.$root.finish();
                    },(error) => {
                        console.log(error);
                        this.$root.fail();
                    });
            },

            createSeasonTitle: function () {
                this.$validator.validateAll().then((result) => {
                    if (result) {
                        this.$root.start();
                        axios.post('/budget/admin/sub_seasons/register' , {
                            stSeason: this.seasonTitleInput.stSeason ,
                            stSubject: this.seasonTitleInput.stSubject ,
                            stDescription: this.seasonTitleInput.stDescription ,
                            planOrCost: this.planOrCost})
                            .then((response) => {
                                if(this.planOrCost == 1)
                                    this.seasonTitleCost = response.data.data;
                                else
                                    this.seasonTitle = response.data.data;
                                this.showModal = false;
                                this.displayNotif(response.status);
                                this.seasonTitleInput = [];
                                console.log(response);
                                this.$root.finish();
                            },(error) => {
                                console.log(error);
                                this.errorMessage = 'عنوان فصل با این مشخصات قبلا ثبت شده است!';
                                this.$root.fail();
                            });
                    }
                });
            },

            tinySeasonUpdateDialog: function (item , planOrCost) {
                this.seasonTitleFill.stSeason = item.stSeason;
                this.seasonTitleFill.stSubject = item.stSubject;
                this.seasonTitleFill.stDescription = item.stDescription;
                this.seasonTitleFill.id = item.id;
                this.seasonTitleFill.planOrCost = planOrCost;
                this.planOrCost = planOrCost;
                this.errorMessage_update = '';
                this.showModalUpdate = true;
            },

            updateSeasonTitle: function () {
                this.$validator.validateAll().then((result) => {
                    if (result) {
                        this.$root.start();
                        axios.post('/budget/admin/sub_seasons/update' , this.seasonTitleFill)
                            .then((response) => {
                                if(this.planOrCost == 1)
                                    this.seasonTitleCost = response.data.data;
                                else
                                    this.seasonTitle = response.data.data;
                                this.showModalUpdate = false;
                                this.displayNotif(response.status);
                                console.log(response);
                                this.$root.finish();
                            },(error) => {
                                console.log(error);
                                this.errorMessage_update = 'عنوان فصل با این مشخصات قبلا ثبت شده است!';
                                this.$root.fail();
                            });
                        }
                });
            },

            openDeleteSeasonTitleConfirm: function (st) {
                this.stIdDelete = st;
                this.showModalDelete = true;
            },

            deleteSeasonTitle: function () {
                this.$root.start();
                axios.post('/budget/admin/season_title/delete' , this.stIdDelete)
                    .then((response) => {
                        if (response.status != 204) //http status code for error in delete (no content)
                        {
                            if(response.data.tsPlanOrCost == 1)
                                this.seasonTitleCost = response.data.data;
                            else
                                this.seasonTitle = response.data.data;

                        }
                        this.showModalDelete = false;
                        console.log(response);
                        this.$root.finish();
                        this.displayNotif(response.status);
                    },(error) => {
                        console.log(error);
                        this.$root.fail();
                    });
            },

            displayNotif: function (httpStatusCode) {
                switch (httpStatusCode){
                    case 204:
                        this.$notify({group: 'seasonTitlePm', title: 'پیام سیستم', text: 'با توجه به وابستگی رکورد ها، حذف رکورد امکان پذیر نیست.' , type: 'error'});
                        break;
                    case 200:
                        this.$notify({group: 'seasonTitlePm', title: 'پیام سیستم', text: 'درخواست با موفقیت انجام شد.' , type: 'success'});
                        break;
                }
            },
    }
</script>
