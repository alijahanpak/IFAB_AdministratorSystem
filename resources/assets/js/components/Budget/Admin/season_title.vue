<template xmlns:v-on="http://www.w3.org/1999/xhtml">
    <!--Inner body start-->
    <div class="medium-10 border-right-line inner-body-pad main-margin">
        <div class="grid-x padding-lr breadcrumbs-pos">
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
                            <div class="clearfix tool-bar">
                                <div class="button-group float-right report-mrg">
                                    <a v-show="$can('BUDGET_ADMIN_SEASON_TITLE_INSERT')" class="my-button toolbox-btn small" @click="openInsertModal(0)">جدید</a>
                                    <button class="my-button toolbox-btn small dropdown small sm-btn-align"  type="button" data-toggle="assetsDropDown">تعداد نمایش<span> {{ itemInPage }} </span></button>
                                    <div  style="width: 113px;" class="dropdown-pane dropdown-pane-sm " data-close-on-click="true"  data-hover="true" data-hover-pane="true"  data-position="bottom" data-alignment="left" id="assetsDropDown" data-dropdown data-auto-focus="true">
                                        <ul class="my-menu small-font ltr-dir">
                                            <li><a  @click="changeItemInPage(2 , 0)">2<span v-show="itemInPage == 2" class="fi-check checked-color size-14"></span></a></li>
                                            <li><a  @click="changeItemInPage(4 , 0)">4<span v-show="itemInPage == 4" class="fi-check checked-color size-14"></span></a></li>
                                            <li><a  @click="changeItemInPage(8 , 0)">8<span v-show="itemInPage == 8" class="fi-check checked-color size-14"></span></a></li>
                                            <li><a  @click="changeItemInPage(10 , 0)">10<span v-show="itemInPage == 10" class="fi-check checked-color size-14"></span></a></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="float-left">
                                    <div class="input-group float-left">
                                        <div class="inner-addon right-addon">
                                            <i v-if="planSearchValue == ''" class="fa fa-search purple-color"  aria-hidden="true"></i>
                                            <i v-if="planSearchValue != ''" v-on:click.stop="removeFilter(0)" class="fa fa-close btn-red"  aria-hidden="true"></i>
                                            <input v-on:keyup.enter="search(0)" v-model="planSearchValue" class="search" type="text" placeholder="جستجو">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--Table Start-->
                            <!--Table Head Start-->
                            <div class="tbl-div-container">
                                <table class="tbl-head">
                                    <colgroup>
                                        <col width="150px"/>
                                        <col width="300px"/>
                                        <col width="500px"/>
                                        <col width="12px"/>

                                    </colgroup>
                                    <tbody class="tbl-head-style">
                                    <tr class="tbl-head-style-cell">
                                        <th class="tbl-head-style-cell">فصل</th>
                                        <th class="tbl-head-style-cell">عنوان فصل</th>
                                        <th class="tbl-head-style-cell">شرح</th>
                                        <th class="tbl-head-style-cell"></th>
                                    </tr>
                                    </tbody>
                                </table>
                                <!--Table Head End-->
                                <!--Table Body Start-->
                                <div class="tbl_body_style dynamic-height-level2">
                                    <table class="tbl-body-contain">
                                        <colgroup>
                                            <col width="150px"/>
                                            <col width="300px"/>
                                            <col width="500px"/>
                                        </colgroup>
                                        <tbody class="tbl-head-style-cell">
                                            <template v-for="season in seasonTitles">
                                                <tr>
                                                    <td class="text-center" :rowspan="season.capital_assets_season_title.length">{{season.sSubject}}</td>
                                                    <td>{{season.capital_assets_season_title[0].castSubject}}</td>
                                                    <td>
                                                        <div class="grid-x">
                                                            <div class="medium-11 text-justify">
                                                                {{season.capital_assets_season_title[0].castDescription}}
                                                            </div>
                                                            <div v-show="$can('BUDGET_ADMIN_SEASON_TITLE_EDIT') || $can('BUDGET_ADMIN_SEASON_TITLE_DELETE')" class="medium-1 cell-vertical-center text-left">
                                                                <a class="dropdown small sm-btn-align"  type="button" :data-toggle="'stSeasonTitle' + season.id"><i class="fa fa-ellipsis-v size-18"></i></a>
                                                                <div class="dropdown-pane dropdown-pane-sm " data-close-on-click="true"  data-hover="true" data-hover-pane="true"  data-position="bottom" data-alignment="right" :id="'stSeasonTitle' + season.id" data-dropdown data-auto-focus="true">
                                                                    <ul class="my-menu small-font text-right">
                                                                        <li v-show="$can('BUDGET_ADMIN_SEASON_TITLE_EDIT')"><a v-on:click.prevent="openUpdateModal(season.capital_assets_season_title[0] , 0)"><i class="fa fa-pencil-square-o size-16"></i>  ویرایش</a></li>
                                                                        <li v-show="$can('BUDGET_ADMIN_SEASON_TITLE_DELETE')"><a v-on:click.prevent="openDeleteModal(season.capital_assets_season_title[0].id , 0)"><i class="fa fa-trash-o size-16"></i>  حذف</a></li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <template v-for="(seasonTitle,sIndex) in season.capital_assets_season_title">
                                                    <tr v-if="sIndex > 0">
                                                        <td>{{seasonTitle.castSubject}}</td>
                                                        <td>
                                                            <div class="grid-x">
                                                                <div class="medium-11 text-justify">
                                                                    {{seasonTitle.castDescription}}
                                                                </div>
                                                                <div v-show="$can('BUDGET_ADMIN_SEASON_TITLE_EDIT') || $can('BUDGET_ADMIN_SEASON_TITLE_DELETE')" class="medium-1 cell-vertical-center text-left">
                                                                    <a class="dropdown small sm-btn-align"  type="button" :data-toggle="'stSeasonTitle' + season.id + seasonTitle.id"><i class="fa fa-ellipsis-v size-18"></i></a>
                                                                    <div class="dropdown-pane dropdown-pane-sm " data-close-on-click="true"  data-hover="true" data-hover-pane="true"  data-position="bottom" data-alignment="right" :id="'stSeasonTitle' + season.id + seasonTitle.id" data-dropdown data-auto-focus="true">
                                                                        <ul class="my-menu small-font text-right">
                                                                            <li v-show="$can('BUDGET_ADMIN_SEASON_TITLE_EDIT')"><a v-on:click.prevent="openUpdateModal(seasonTitle , 0)"><i class="fa fa-pencil-square-o size-16"></i>  ویرایش</a></li>
                                                                            <li v-show="$can('BUDGET_ADMIN_SEASON_TITLE_DELETE')"><a v-on:click.prevent="openDeleteModal(seasonTitle.id , 0)"><i class="fa fa-trash-o size-16"></i>  حذف</a></li>
                                                                        </ul>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                </template>
                                            </template>
                                        </tbody>
                                    </table>
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
                    <!--Tab 1-->
                    <!--Tab 2-->
                    <div class="tabs-panel table-mrg-btm" id="cost" xmlns:v-on="http://www.w3.org/1999/xhtml">
                        <div class="medium-12 bottom-mrg">
                            <div class="clearfix tool-bar">
                                <div class="button-group float-right report-mrg">
                                    <a v-show="$can('BUDGET_ADMIN_SEASON_TITLE_INSERT')" class="my-button toolbox-btn small" @click="openInsertModal(1)">جدید</a>
                                    <button class="my-button toolbox-btn small dropdown small sm-btn-align"  type="button" data-toggle="costDropDown">تعداد نمایش<span> {{ costItemInPage }} </span></button>
                                    <div style="width: 113px;" class="dropdown-pane dropdown-pane-sm " data-close-on-click="true"  data-hover="true" data-hover-pane="true"  data-position="bottom" data-alignment="left" id="costDropDown" data-dropdown data-auto-focus="true">
                                        <ul class="my-menu small-font ltr-dir">
                                            <li><a  @click="changeItemInPage(2 , 1)">2<span v-show="costItemInPage == 2" class="fi-check checked-color size-14"></span></a></li>
                                            <li><a  @click="changeItemInPage(4 , 1)">4<span v-show="costItemInPage == 4" class="fi-check checked-color size-14"></span></a></li>
                                            <li><a  @click="changeItemInPage(8 , 1)">8<span v-show="costItemInPage == 8" class="fi-check checked-color size-14"></span></a></li>
                                            <li><a  @click="changeItemInPage(10 , 1)">10<span v-show="costItemInPage == 10" class="fi-check checked-color size-14"></span></a></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="float-left">
                                    <div class="input-group float-left">
                                        <div class="inner-addon right-addon">
                                            <i v-if="costSearchValue == ''" class="fa fa-search purple-color"  aria-hidden="true"></i>
                                            <i v-if="costSearchValue != ''" v-on:click.stop="removeFilter(1)" class="fa fa-close btn-red"  aria-hidden="true"></i>
                                            <input v-on:keyup.enter="search(1)" v-model="costSearchValue" class="search" type="text" placeholder="جستجو">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--Table Start-->
                            <!--Table Head Start-->
                            <div class="tbl-div-container">
                                <table class="tbl-head">
                                    <colgroup>
                                        <col width="150px"/>
                                        <col width="300px"/>
                                        <col width="500px"/>
                                        <col width="12px"/>

                                    </colgroup>
                                    <tbody class="tbl-head-style">
                                    <tr class="tbl-head-style-cell">
                                        <th class="tbl-head-style-cell">فصل</th>
                                        <th class="tbl-head-style-cell">عنوان فصل</th>
                                        <th class="tbl-head-style-cell">شرح</th>
                                        <th class="tbl-head-style-cell"></th>
                                    </tr>
                                    </tbody>
                                </table>
                                <!--Table Head End-->
                                <!--Table Body Start-->
                                <div class="tbl_body_style dynamic-height-level2">
                                    <table class="tbl-body-contain">
                                        <colgroup>
                                            <col width="150px"/>
                                            <col width="300px"/>
                                            <col width="500px"/>
                                        </colgroup>
                                        <tbody class="tbl-head-style-cell">
                                        <template v-for="season in seasonTitleCosts">
                                            <tr>
                                                <td class="text-center" :rowspan="season.cost_season_title.length">{{season.sSubject}}</td>
                                                <td>{{season.cost_season_title[0].cstSubject}}</td>
                                                <td>
                                                    <div class="grid-x">
                                                        <div class="medium-11 text-justify">
                                                            {{season.cost_season_title[0].cstDescription}}
                                                        </div>
                                                        <div v-show="$can('BUDGET_ADMIN_SEASON_TITLE_EDIT') || $can('BUDGET_ADMIN_SEASON_TITLE_DELETE')" class="medium-1 cell-vertical-center text-left">
                                                            <a class="dropdown small sm-btn-align"  type="button" :data-toggle="'stSeasonTitle_cost' + season.id"><i class="fa fa-ellipsis-v size-18"></i></a>
                                                            <div class="dropdown-pane dropdown-pane-sm " data-close-on-click="true"  data-hover="true" data-hover-pane="true"  data-position="bottom" data-alignment="right" :id="'stSeasonTitle_cost' + season.id" data-dropdown data-auto-focus="true">
                                                                <ul class="my-menu small-font text-right">
                                                                    <li v-show="$can('BUDGET_ADMIN_SEASON_TITLE_EDIT')"><a v-on:click.prevent="openUpdateModal(season.cost_season_title[0] , 1)"><i class="fa fa-pencil-square-o size-16"></i>  ویرایش</a></li>
                                                                    <li v-show="$can('BUDGET_ADMIN_SEASON_TITLE_DELETE')"><a v-on:click.prevent="openDeleteModal(season.cost_season_title[0].id , 1)"><i class="fa fa-trash-o size-16"></i>  حذف</a></li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <template v-for="(seasonTitle,sIndex) in season.cost_season_title">
                                                <tr v-if="sIndex > 0">
                                                    <td>{{seasonTitle.cstSubject}}</td>
                                                    <td>
                                                        <div class="grid-x">
                                                            <div class="medium-11 text-justify">
                                                                {{seasonTitle.cstDescription}}
                                                            </div>
                                                            <div v-show="$can('BUDGET_ADMIN_SEASON_TITLE_EDIT') || $can('BUDGET_ADMIN_SEASON_TITLE_DELETE')" class="medium-1 cell-vertical-center text-left">
                                                                <a class="dropdown small sm-btn-align"  type="button" :data-toggle="'stSeasonTitle_cost' + season.id + seasonTitle.id"><i class="fa fa-ellipsis-v size-18"></i></a>
                                                                <div class="dropdown-pane dropdown-pane-sm " data-close-on-click="true"  data-hover="true" data-hover-pane="true"  data-position="bottom" data-alignment="right" :id="'stSeasonTitle_cost' + season.id + seasonTitle.id" data-dropdown data-auto-focus="true">
                                                                    <ul class="my-menu small-font text-right">
                                                                        <li v-show="$can('BUDGET_ADMIN_SEASON_TITLE_EDIT')"><a v-on:click.prevent="openUpdateModal(seasonTitle , 1)"><i class="fa fa-pencil-square-o size-16"></i>  ویرایش</a></li>
                                                                        <li v-show="$can('BUDGET_ADMIN_SEASON_TITLE_DELETE')"><a v-on:click.prevent="openDeleteModal(seasonTitle.id , 1)"><i class="fa fa-trash-o size-16"></i>  حذف</a></li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                            </template>
                                        </template>
                                        </tbody>
                                    </table>
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
                    <!--Tab 2-->
                </div>
                <!-- insert modal -->
                <modal-tiny v-if="showInsertModal" @close="showInsertModal = false">
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
                                <button type="submit" class="my-button my-success float-left btn-for-load"><span class="btn-txt-mrg">  ثبت</span></button>
                            </div>
                        </form>
                    </div>
                </modal-tiny>
                <!-- insert modal end -->
                <!-- update modal -->
                <modal-tiny v-if="showUpdateModal" @close="showUpdateModal = false">
                    <div  slot="body">
                        <form v-on:submit.prevent="updateSeasonTitle">
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
                                <button type="submit" class="my-button my-success float-left btn-for-load"><span class="btn-txt-mrg">  ثبت</span></button>
                            </div>
                        </form>
                    </div>
                </modal-tiny>
                <!-- delete modal -->
                <modal-tiny v-if="showDeleteModal" @close="showDeleteModal = false">
                    <div  slot="body">
                        <div class="small-font" xmlns:v-on="http://www.w3.org/1999/xhtml">
                            <p>کاربر گرامی</p>
                            <p class="large-offset-1 modal-text">برای حذف رکورد مورد نظر اطمینان دارید؟</p>
                            <div class="grid-x">
                                <div class="medium-12 column text-center">
                                    <button v-on:click="deleteSeasonTitle" class="my-button my-success"><span class="btn-txt-mrg">   بله   </span></button>
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
                seasonTitleInput: {},
                showInsertModal: false,
                showUpdateModal: false,
                showDeleteModal: false,
                planSearchValue:'',
                costSearchValue:'',
                itemInPage: 2,
                costItemInPage: 2,
                seasonTitleFill: {},
                stIdDelete: {},
                seasons: {},
                planOrCost: 0,
                updateDataThreadNowPlaying: null,
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
            this.setUpdateDataThread();
        },

        updated: function () {
            $(this.$el).foundation(); //WORKS!
        },

        mounted: function () {
            console.log("mounted season title component");
            this.$parent.myResize();
        },

        beforeDestroy: function () {
            clearInterval(this.updateDataThreadNowPlaying);
            console.log('...................................... kill update data thread');
        },

        components:{
            'vue-pagination' : VuePagination
        },

        methods: {
            fetchCapitalAssetsData: function (page = 1) {
                axios.get('/budget/admin/season_title/capital_assets/fetchData?page=' + page , {params:{
                        searchValue: this.planSearchValue,
                        itemInPage: this.itemInPage
                    }})
                    .then((response) => {
                        this.seasonTitles = response.data.data;
                        this.makePagination(response.data , "plan");
                        console.log(response.data);
                    },(error) => {
                        console.log(error);
                    });
            },

            fetchCostData: function (page = 1) {
                axios.get('/budget/admin/season_title/cost/fetchData?page=' + page , {params:{
                        searchValue: this.costSearchValue,
                        itemInPage: this.costItemInPage
                        }})
                    .then((response) => {
                        this.seasonTitleCosts = response.data.data;
                        this.makePagination(response.data , "cost");
                        console.log(response.data);
                    },(error) => {
                        console.log(error);
                    });
            },

            search: function (type) {
                if (type == 0)
                {
                    this.fetchCapitalAssetsData();
                }else{
                    this.fetchCostData();
                }
            },

            changeItemInPage: function (number , type) {
                if (type == 0)
                {
                    this.itemInPage = number;
                    this.fetchCapitalAssetsData();
                }else{
                    this.costItemInPage = number;
                    this.fetchCostData();
                }
            },

            removeFilter: function (type) {
                if (type == 0)
                {
                    this.planSearchValue = ''
                    this.fetchCapitalAssetsData();
                }else{
                    this.costSearchValue = '';
                    this.fetchCostData();
                }
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
                axios.get('/admin/get_all_seasons')
                    .then((response) => {
                        this.seasons = response.data;
                        console.log(response);
                    }, (error) => {
                        console.log(error);
                    });
            },

            openInsertModal: function (type) {
                this.seasonTitleInput = [];
                this.getSeasons();
                this.planOrCost = type;
                this.showInsertModal = true;
            },

            createSeasonTitle: function () {
                this.$validator.validateAll().then((result) => {
                    if (result) {
                        axios.post(this.planOrCost == 0 ? '/budget/admin/season_title/capital_assets/register' : '/budget/admin/season_title/cost/register' , {
                            sId: this.seasonTitleInput.stSeason,
                            subject: this.seasonTitleInput.stSubject,
                            description: this.seasonTitleInput.stDescription,
                            searchValue: this.planOrCost == 0 ? this.planSearchValue : this.costSearchValue,
                            itemInPage: this.planOrCost == 0 ? this.itemInPage : this.costItemInPage
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
                                this.showInsertModal = false;
                                this.$parent.displayNotif(response.status);
                                console.log(response);
                            }, (error) => {
                                console.log(error);
                                this.$parent.displayNotif(error.response.status);
                        });
                    }
                });
            },

            openUpdateModal: function (item, planOrCost) {
                this.getSeasons();
                if (planOrCost == 0)
                {
                    this.seasonTitleFill.stSId = item.castSId;
                    this.seasonTitleFill.stSubject = item.castSubject;
                    this.seasonTitleFill.stDescription = item.castDescription;
                }else {
                    this.seasonTitleFill.stSId = item.cstSId;
                    this.seasonTitleFill.stSubject = item.cstSubject;
                    this.seasonTitleFill.stDescription = item.cstDescription;
                }

                this.seasonTitleFill.id = item.id;
                this.planOrCost = planOrCost;
                this.showUpdateModal = true;
            },

            updateSeasonTitle: function () {
                this.$validator.validateAll().then((result) => {
                    if (result) {
                        axios.post(this.planOrCost == 0 ? '/budget/admin/season_title/capital_assets/update' : '/budget/admin/season_title/cost/update' , {
                            id: this.seasonTitleFill.id,
                            sId: this.seasonTitleFill.stSId,
                            subject: this.seasonTitleFill.stSubject,
                            description: this.seasonTitleFill.stDescription,
                            searchValue: this.planOrCost == 0 ? this.planSearchValue : this.costSearchValue,
                            itemInPage: this.planOrCost == 0 ? this.itemInPage : this.costItemInPage
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
                            this.showUpdateModal = false;
                            this.$parent.displayNotif(response.status);
                            console.log(response);
                        }, (error) => {
                                console.log(error);
                                this.$parent.displayNotif(error.response.status);
                            });
                        }
                });
            },

            openDeleteModal: function (st , type) {
                this.planOrCost = type;
                this.stIdDelete = st;
                this.showDeleteModal = true;
            },

            deleteSeasonTitle: function () {
                axios.post(this.planOrCost == 0 ? '/budget/admin/season_title/capital_assets/delete' : '/budget/admin/season_title/cost/delete', {
                    id: this.stIdDelete,
                    searchValue: this.planOrCost == 0 ? this.planSearchValue : this.costSearchValue,
                    itemInPage: this.planOrCost == 0 ? this.itemInPage : this.costItemInPage
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
                        this.showDeleteModal = false;
                        console.log(response);
                        this.$parent.displayNotif(response.status);
                    }, (error) => {
                        console.log(error);
                 });
            },

            setUpdateDataThread: function () {
                console.log("...................................................... set season title update thread");
                if (this.updateDataThreadNowPlaying)
                    clearInterval(this.updateDataThreadNowPlaying);
                this.updateDataThreadNowPlaying = setInterval(this.updateDataThread, 120000);
            },

            updateDataThread: function () {
                console.log("...................................................... season title update thread");
                this.fetchCostData();
                this.fetchCapitalAssetsData();
            },
        }
    }
</script>
