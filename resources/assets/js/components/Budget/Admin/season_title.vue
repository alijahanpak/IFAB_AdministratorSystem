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
                                    <div class="grid-x" v-for="season in seasonTitles">
                                        <div class="medium-2 table-contain-border cell-vertical-center">
                                            {{ season.sSubject }}
                                        </div>
                                        <div class="medium-10">
                                            <div class="grid-x" v-for="seasonTitle in season.capital_assets_season_title">
                                                <div class="medium-8 table-contain-border cell-vertical-center">
                                                    {{ seasonTitle.castSubject }}
                                                </div>
                                                <div class="medium-4 table-contain-border cell-vertical-center">
                                                    <div class="grid-x">
                                                        <div class="medium-11">
                                                            {{ seasonTitle.castDescription }}
                                                        </div>
                                                        <div class="medium-1 cell-vertical-center text-left">
                                                            <a class="dropdown small sm-btn-align"  type="button" :data-toggle="'stSeasonTitle' + seasonTitle.id"><i class="fa fa-ellipsis-v size-18"></i></a>
                                                            <div class="dropdown-pane dropdown-pane-sm " data-close-on-click="true"  data-hover="true" data-hover-pane="true"  data-position="bottom" data-alignment="right" :id="'stSeasonTitle' + seasonTitle.id" data-dropdown data-auto-focus="true">
                                                                <ul class="my-menu small-font text-right">
                                                                    <li><a v-on:click.prevent="seasonTitleUpdateDialog(seasonTitle , 0)"><i class="fa fa-pencil-square-o size-16"></i>  ویرایش</a></li>
                                                                    <li><a v-on:click.prevent="openDeleteSeasonTitleConfirm(seasonTitle , 0)"><i class="fa fa-trash-o size-16"></i>  حذف</a></li>
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
                                    <div class="grid-x" v-for="season1 in seasonTitleCosts">
                                        <div class="medium-2 table-contain-border cell-vertical-center">
                                            {{ season1.sSubject }}
                                        </div>
                                        <div class="medium-10">
                                            <div class="grid-x" v-for="sTCost in season1.cost_season_title">
                                                <div class="medium-8 table-contain-border cell-vertical-center">
                                                    {{ sTCost.cstSubject }}
                                                </div>
                                                <div class="medium-4 table-contain-border cell-vertical-center">
                                                    <div class="grid-x">
                                                        <div class="medium-11">
                                                            {{ sTCost.cstDescription }}
                                                        </div>
                                                        <div class="medium-1 cell-vertical-center text-left">
                                                            <a class="dropdown small sm-btn-align"  type="button" :data-toggle="'stSeasonTitle_cost' + sTCost.id"><i class="fa fa-ellipsis-v size-18"></i></a>
                                                            <div class="dropdown-pane dropdown-pane-sm " data-close-on-click="true"  data-hover="true" data-hover-pane="true"  data-position="bottom" data-alignment="right" :id="'stSeasonTitle_cost' + sTCost.id" data-dropdown data-auto-focus="true">
                                                                <ul class="my-menu small-font text-right">
                                                                    <li><a v-on:click.prevent="seasonTitleUpdateDialog(sTCost , 1)"><i class="fa fa-pencil-square-o size-16"></i>  ویرایش</a></li>
                                                                    <li><a v-on:click.prevent="openDeleteSeasonTitleConfirm(sTCost , 1)"><i class="fa fa-trash-o size-16"></i>  حذف</a></li>
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
                    <!--Tab 2-->
                    <notifications group="seasonTitlePm"
                                   position="bottom right"
                                   animation-type="velocity"
                                   :speed="700" />
                </div>
                <modal-tiny v-if="showModal" @close="showModal = false">
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
                                            <option v-for="season in seasons" :value="season.id">{{ season.sSubject }}</option>
                                        </select>
                                        <span v-show="errors.has('sId')" class="error-font">لطفا فصل را انتخاب کنید!</span>
                                    </label>
                                </div>
                            </div>
                            <div class="grid-x">
                                <div class="medium-12 cell padding-lr">
                                    <label>
                                        <label>عنوان فصل
                                            <input class="form-element-margin-btm" type="text" name="tsSubject" v-model="seasonTitleInput.stSubject" v-validate="'required'" :class="{'input': true, 'error-border': errors.has('tsSubject')}">
                                        </label>
                                        <span v-show="errors.has('tsSubject')" class="error-font">لطفا عنوان فصل انتخاب کنید!</span>
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
                <!-- update modal -->
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
                                        <select class="form-element-margin-btm" v-model="seasonTitleFill.stSId" name="sId" v-validate data-vv-rules="required" :class="{'input': true, 'select-error': errors.has('sId')}">
                                            <option value=""></option>
                                            <option v-for="season in seasons" :value="season.id">{{ season.sSubject }}</option>
                                        </select>
                                        <span v-show="errors.has('sId')" class="error-font">لطفا فصل را انتخاب کنید!</span>
                                    </label>
                                </div>
                            </div>
                            <div class="grid-x">
                                <div class="medium-12 cell padding-lr">
                                    <label>
                                        <label>عنوان فصل
                                            <input class="form-element-margin-btm" type="text" name="tsSubject" v-model="seasonTitleFill.stSubject" v-validate="'required'" :class="{'input': true, 'error-border': errors.has('tsSubject')}">
                                        </label>
                                        <span v-show="errors.has('tsSubject')" class="error-font">لطفا عنوان فصل انتخاب کنید!</span>
                                    </label>
                                </div>
                            </div>
                            <div class="grid-x">
                                <div class="small-12 columns padding-lr">
                                    <label>شرح
                                        <textarea name="tsDescription" style="min-height: 150px;" v-model="seasonTitleFill.stDescription"></textarea>
                                    </label>
                                </div>
                            </div>
                            <div class="medium-6 columns padding-lr padding-bottom-modal">
                                <button name="Submit" class="my-secondary button float-left btn-for-load"> <span class="btn-txt-mrg">ثبت</span></button>
                            </div>
                        </form>
                    </div>
                </modal-tiny>
                <!-- delete modal -->
                <modal-tiny v-if="showModalDelete" @close="showModalDelete = false">
                    <div  slot="body">
                        <div class="small-font" xmlns:v-on="http://www.w3.org/1999/xhtml">
                            <p>کاربر گرامی</p>
                            <p class="large-offset-1 modal-text">برای حذف رکورد مورد نظر اطمینان دارید؟</p>
                            <div class="grid-x">
                                <div class="medium-12 column text-center">
                                    <button  class="button primary btn-large-w" v-on:click="deleteSeasonTitle">بله</button>
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
                errorMessage: '',
                errorMessage_update: '',
                seasonTitles: [],
                seasonTitleCosts: [],
                seasonTitleInput: {stSeason: '' , stSubject: '' , stDescription: ''},
                showModal: false,
                showModalUpdate: false,
                showModalDelete: false,
                seasonTitleFill: {stSId: '' , stSubject: '' , stDescription: '' , id: ''},
                stIdDelete: {},
                seasons: {},
                planOrCost: 0,
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

        methods: {
            fetchCapitalAssetsData: function (page = 1) {
                this.$root.start();
                axios.get('/budget/admin/season_title/capital_assets/fetchData?page=' + page)
                    .then((response) => {
                        this.seasonTitles = response.data.data;
                        this.makePagination(response.data , "plan");
                        console.log(response.data);
                        this.$root.finish();
                    },(error) => {
                        console.log(error);
                        this.$root.fail();
                    });
            },

            fetchCostData: function (page = 1) {
                this.$root.start();
                axios.get('/budget/admin/season_title/cost/fetchData?page=' + page)
                    .then((response) => {
                        this.seasonTitleCosts = response.data.data;
                        this.makePagination(response.data , "cost");
                        console.log(response.data);
                        this.$root.finish();
                    },(error) => {
                        console.log(error);
                        this.$root.fail();
                    });
            },

            makePagination: function (data, type) {
                if (type == "cost") {
                    this.cost_pagination.current_page = data.current_page;
                    this.cost_pagination.to = data.to;
                    this.cost_pagination.last_page = data.last_page;
                } else if (type == "plan") {
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
                    }, (error) => {
                        console.log(error);
                        this.$root.fail();
                    });
            },

            createSeasonTitle: function () {
                this.$validator.validateAll().then((result) => {
                    if (result) {
                        this.$root.start();
                        axios.post(this.planOrCost == 0 ? '/budget/admin/season_title/capital_assets/register' : '/budget/admin/season_title/cost/register' , {
                            sId: this.seasonTitleInput.stSeason,
                            subject: this.seasonTitleInput.stSubject,
                            description: this.seasonTitleInput.stDescription
                        }).then((response) => {
                                if (this.planOrCost == 1)
                                {
                                    this.seasonTitleCosts = response.data.data;
                                    this.makePagination(response.data , "cost");
                                }
                                else
                                {
                                    this.seasonTitles = response.data.data;
                                    this.makePagination(response.data , "plan");
                                }
                                this.showModal = false;
                                this.displayNotif(response.status);
                                this.seasonTitleInput = [];
                                console.log(response);
                                this.$root.finish();
                            }, (error) => {
                                console.log(error);
                                this.errorMessage = 'عنوان فصل با این مشخصات قبلا ثبت شده است!';
                                this.$root.fail();
                        });
                    }
                });
            },

            seasonTitleUpdateDialog: function (item, planOrCost) {
                if (planOrCost == 0)
                {
                    this.seasonTitleFill.stSId = item.castSId;
                    this.seasonTitleFill.stSubject = item.castSubject;
                    this.seasonTitleFill.stDescription = item.castDescription;

                }
                else if (planOrCost == 1)
                {
                    this.seasonTitleFill.stSId = item.cstSId;
                    this.seasonTitleFill.stSubject = item.cstSubject;
                    this.seasonTitleFill.stDescription = item.cstDescription;
                }
                this.seasonTitleFill.id = item.id;
                this.planOrCost = planOrCost;
                this.errorMessage_update = '';
                this.showModalUpdate = true;
            },

            updateSeasonTitle: function () {
                this.$validator.validateAll().then((result) => {
                    if (result) {
                        this.$root.start();
                        axios.post(this.planOrCost == 0 ? '/budget/admin/season_title/capital_assets/update' : '/budget/admin/season_title/cost/update' , {
                            id: this.seasonTitleFill.id,
                            sId: this.seasonTitleFill.stSId,
                            subject: this.seasonTitleFill.stSubject,
                            description: this.seasonTitleFill.stDescription
                        }).then((response) => {
                            if (this.planOrCost == 1)
                        {
                            this.seasonTitleCosts = response.data.data;
                            this.makePagination(response.data , "cost");
                        }
                        else
                        {
                            this.seasonTitles = response.data.data;
                            this.makePagination(response.data , "plan");
                        }
                        this.showModalUpdate = false;
                        this.displayNotif(response.status);
                        console.log(response);
                        this.$root.finish();
                    }, (error) => {
                            console.log(error);
                            this.errorMessage = 'عنوان فصل با این مشخصات قبلا ثبت شده است!';
                            this.$root.fail();
                        });
                    }
                });
            },

            openDeleteSeasonTitleConfirm: function (st , type) {
                this.planOrCost = type;
                this.stIdDelete = st;
                this.showModalDelete = true;
            },

            deleteSeasonTitle: function () {
                this.$root.start();
                axios.post(this.planOrCost == 0 ? '/budget/admin/season_title/capital_assets/delete' : '/budget/admin/season_title/cost/delete', {
                    id: this.stIdDelete.id,
                    subject: this.planOrCost == 0 ? this.stIdDelete.castSubject : this.stIdDelete.cstSubject
                }).then((response) => {
                        if (response.status != 204) //http status code for error in delete (no content)
                        {
                            if (this.planOrCost == 1)
                            {
                                this.seasonTitleCosts = response.data.data;
                                this.makePagination(response.data , "cost");
                            }
                            else
                            {
                                this.seasonTitles = response.data.data;
                                this.makePagination(response.data , "plan");
                            }
                        }
                        this.showModalDelete = false;
                        console.log(response);
                        this.$root.finish();
                        this.displayNotif(response.status);
                    }, (error) => {
                        console.log(error);
                        this.$root.fail();
                    });
            },

            displayNotif: function (httpStatusCode) {
                switch (httpStatusCode) {
                    case 204:
                        this.$notify({
                            group: 'seasonTitlePm',
                            title: 'پیام سیستم',
                            text: 'با توجه به وابستگی رکورد ها، حذف رکورد امکان پذیر نیست.',
                            type: 'error'
                        });
                        break;
                    case 200:
                        this.$notify({
                            group: 'seasonTitlePm',
                            title: 'پیام سیستم',
                            text: 'درخواست با موفقیت انجام شد.',
                            type: 'success'
                        });
                        break;
                }
            },
        }
    }
</script>
