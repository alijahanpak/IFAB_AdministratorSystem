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
                                <span class="show-for-sr">Current: </span>ریز فصول
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
        <div class="grid-x my-callout-box container-mrg-top dynamic-height-level1">
            <div class="medium-12 column">
                <ul class="tabs tab-color my-tab-style" data-responsive-accordion-tabs="tabs medium-accordion large-tabs" id="sub_season_tab_view">
                    <li class="tabs-title is-active"><a href="#capital_assets" aria-selected="true">تملک دارایی سرمایه ای</a></li>
                    <li class="tabs-title"><a href="#cost">هزینه ای</a></li>
                </ul>
                <div class="tabs-content" data-tabs-content="sub_season_tab_view">
                    <!--Tab 1-->
                    <div class="tabs-panel is-active table-mrg-btm" id="capital_assets"
                         xmlns:v-on="http://www.w3.org/1999/xhtml">
                        <div class="medium-12 bottom-mrg">
                            <div class="clearfix border-btm-line bottom-mrg tool-bar">
                                <div style="margin-top: 2px;" class="button-group float-right report-mrg">
                                    <a class="my-button toolbox-btn small" @click="openInsertModal(0)">جدید</a>
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
                                            <div class="medium-3 table-border">
                                                <strong>عنوان فصل</strong>
                                            </div>
                                            <div class="medium-9">
                                                <div class="grid-x">
                                                    <div class="medium-6 table-border">
                                                        <strong>ریز فصل</strong>
                                                    </div>
                                                    <div class="medium-6  table-border">
                                                        <strong>شرح</strong>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--Header End-->
                                <div class="table-contain dynamic-height-level2">
                                    <div class="grid-x" v-for="season in tinySeasons">
                                        <div class="medium-2 table-contain-border cell-vertical-center">
                                            {{ season.sSubject }}
                                        </div>
                                        <div class="medium-10">
                                            <div  class="grid-x" v-for="capitalAssetsSeasonTitle in season.capital_assets_season_title">
                                                <div class="medium-3 table-contain-border cell-vertical-center">
                                                    {{ capitalAssetsSeasonTitle.castSubject }}
                                                </div>
                                                <div class="medium-9">
                                                    <div class="grid-x" v-for="capitalAssetsTinySeason in capitalAssetsSeasonTitle.capital_assets_tiny_season">
                                                        <div class="medium-6 table-contain-border cell-vertical-center">
                                                            {{ capitalAssetsTinySeason.catsSubject }}
                                                        </div>
                                                        <div class="medium-6  table-contain-border cell-vertical-center">
                                                            <div class="grid-x">
                                                                <div class="medium-11">
                                                                    {{ capitalAssetsTinySeason.catsDescription }}
                                                                </div>
                                                                <div class="medium-1 cell-vertical-center text-left">
                                                                    <a class="dropdown small sm-btn-align"  type="button" :data-toggle="'tsTinySeason' + season.id + capitalAssetsSeasonTitle.id + capitalAssetsTinySeason.id"><img width="15px" height="15px" src="/IFAB_AdministratorSystem/public/pic/menu.svg"></a>
                                                                    <div class="dropdown-pane dropdown-pane-sm " data-close-on-click="true"  data-hover="true" data-hover-pane="true"  data-position="bottom" data-alignment="right" :id="'tsTinySeason' + season.id + capitalAssetsSeasonTitle.id + capitalAssetsTinySeason.id" data-dropdown data-auto-focus="true">
                                                                        <ul class="my-menu small-font text-right">
                                                                            <li><a v-on:click.prevent="tinySeasonUpdateDialog(season.id , capitalAssetsTinySeason , 0)"><i class="fi-pencil size-16"></i>  ویرایش</a></li>
                                                                            <li><a v-on:click.prevent="openDeleteTinySeasonConfirm(capitalAssetsTinySeason , 0)"><i class="fi-trash size-16"></i>  حذف</a></li>
                                                                        </ul>
                                                                    </div>
                                                                </div>
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
                                        <a class="my-button toolbox-btn small" @click="openInsertModal(1)">جدید</a>
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
                                                <div class="medium-2 table-border">
                                                    <strong>فصل</strong>
                                                </div>
                                                <div class="medium-10">
                                                    <div class="grid-x">
                                                        <div class="medium-4 table-border">
                                                            <strong>عنوان فصل</strong>
                                                        </div>
                                                        <div class="medium-4 table-border">
                                                            <strong>ریز فصل</strong>
                                                        </div>
                                                        <div class="medium-4  table-border">
                                                            <strong>شرح</strong>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!--Header End-->
                                    <div class="table-contain dynamic-height-level2">
                                        <div class="grid-x" v-for="season in tinySeasonsCost">
                                            <div class="medium-2 table-contain-border cell-vertical-center">
                                                {{ season.sSubject }}
                                            </div>
                                            <div class="medium-10">
                                                <div class="grid-x" v-for="costSeasonTitle in season.cost_season_title">
                                                    <div class="medium-3 table-contain-border cell-vertical-center">
                                                        {{ costSeasonTitle.cstSubject }}
                                                    </div>
                                                    <div class="medium-9">
                                                        <div class="grid-x" v-for="costTinySeason in costSeasonTitle.cost_tiny_season">
                                                            <div class="medium-6 table-contain-border cell-vertical-center">
                                                                {{ costTinySeason.ctsSubject }}
                                                            </div>
                                                            <div class="medium-6  table-contain-border cell-vertical-center">
                                                                <div class="grid-x">
                                                                    <div class="medium-11">
                                                                        {{ costTinySeason.ctsDescription }}
                                                                    </div>
                                                                    <div class="medium-1 cell-vertical-center text-left">
                                                                        <a class="dropdown small sm-btn-align"  type="button" :data-toggle="'ctsTinySeason' + season.id + costSeasonTitle.id + costTinySeason.id"><img width="15px" height="15px" src="/IFAB_AdministratorSystem/public/pic/menu.svg"></a>
                                                                        <div class="dropdown-pane dropdown-pane-sm " data-close-on-click="true"  data-hover="true" data-hover-pane="true"  data-position="bottom" data-alignment="right" :id="'ctsTinySeason' + season.id + costSeasonTitle.id + costTinySeason.id" data-dropdown data-auto-focus="true">
                                                                            <ul class="my-menu small-font text-right">
                                                                                <li><a v-on:click.prevent="tinySeasonUpdateDialog(season.id , costTinySeason , 1)"><i class="fi-pencil size-16"></i>  ویرایش</a></li>
                                                                                <li><a v-on:click.prevent="openDeleteTinySeasonConfirm(costTinySeason , 1)"><i class="fi-trash size-16"></i>  حذف</a></li>
                                                                            </ul>
                                                                        </div>
                                                                    </div>
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
                </div>
                <modal-tiny v-if="showModal" @close="showModal = false">
                    <div  slot="body">
                        <form v-on:submit.prevent="createTinySeason">
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
                                        <select class="form-element-margin-btm" v-model="selectedSeason" @change="getSeasonTitle" name="sId" v-validate data-vv-rules="required" :class="{'input': true, 'select-error': errors.has('sId')}">
                                            <option value=""></option>
                                            <option v-for="season in seasons" :value="season.id">{{ season.sSubject }}</option>
                                        </select>
                                        <span v-show="errors.has('sId')" class="error-font">لطفا فصل انتخاب کنید!</span>
                                    </label>
                                </div>
                            </div>
                            <div class="grid-x">
                                <div class="medium-12 cell padding-lr">
                                    <label>عنوان فصل
                                        <select class="form-element-margin-btm" v-model="tinySeasonsInput.tsStId" name="season_title" v-validate data-vv-rules="required" :class="{'input': true, 'select-error': errors.has('season_title')}">
                                            <option value=""></option>
                                            <option v-for="seasonTitle in seasonTitles" :value="seasonTitle.id">{{ planOrCost == 0 ? seasonTitle.castSubject :  seasonTitle.cstSubject }}</option>
                                        </select>
                                        <span v-show="errors.has('season_title')" class="error-font">لطفا فصل انتخاب کنید!</span>
                                    </label>
                                </div>
                            </div>
                            <div class="grid-x">
                                <div class="medium-12 columns padding-lr">
                                    <label>ریز فصل
                                        <input class="form-element-margin-btm" type="text" name="tsSubject" v-model="tinySeasonsInput.tsSubject" v-validate="'required'" :class="{'input': true, 'error-border': errors.has('tsSubject')}">
                                    </label>
                                    <span v-show="errors.has('tsSubject')" class="error-font">لطفا ریزفصل انتخاب کنید!</span>
                                </div>
                            </div>
                            <div class="grid-x">
                                <div class="small-12 columns padding-lr">
                                    <label>شرح
                                        <textarea name="tsDescription" style="min-height: 150px;" v-model="tinySeasonsInput.tsDescription"></textarea>
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
                        <form v-on:submit.prevent="updateTinySeason">
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
                                        <select class="form-element-margin-btm" v-model="selectedSeason" @change="getSeasonTitle" name="sId" v-validate data-vv-rules="required" :class="{'input': true, 'select-error': errors.has('sId')}">
                                            <option value=""></option>
                                            <option v-for="season in seasons" :value="season.id">{{ season.sSubject }}</option>
                                        </select>
                                        <span v-show="errors.has('sId')" class="error-font">لطفا فصل انتخاب کنید!</span>
                                    </label>
                                </div>
                            </div>
                            <div class="grid-x">
                                <div class="medium-12 cell padding-lr">
                                    <label>عنوان فصل
                                        <select class="form-element-margin-btm" v-model="tinySeasonsFill.tsStId" name="season_title" v-validate data-vv-rules="required" :class="{'input': true, 'select-error': errors.has('season_title')}">
                                            <option value=""></option>
                                            <option v-for="seasonTitle in seasonTitles" :value="seasonTitle.id">{{ planOrCost == 0 ? seasonTitle.castSubject :  seasonTitle.cstSubject }}</option>
                                        </select>
                                        <span v-show="errors.has('season_title')" class="error-font">لطفا فصل انتخاب کنید!</span>
                                    </label>
                                </div>
                            </div>
                            <div class="grid-x">
                                <div class="medium-12 columns padding-lr">
                                    <label>ریز فصل
                                        <input class="form-element-margin-btm" type="text" name="tsSubject" v-model="tinySeasonsFill.tsSubject" v-validate="'required'" :class="{'input': true, 'error-border': errors.has('tsSubject')}">
                                    </label>
                                    <span v-show="errors.has('tsSubject')" class="error-font">لطفا ریزفصل انتخاب کنید!</span>
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
                <!-- delete modal -->
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
                selectedSeason: '',
                tinySeasons: [],
                tinySeasonsCost: [],
                tinySeasonsInput: {tsStId: '' , tsSubject: '' , tsDescription: ''},
                showModal: false,
                showModalUpdate: false,
                showModalDelete: false,
                tinySeasonsFill: {tsStId: '' , tsSubject: '' , tsDescription: '' , id: ''},
                tsIdDelete: {},
                seasons: {},
                seasonTitles: {},
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
            console.log("mounted tiny season component");
            this.$parent.myResize();
        },

        components:{
            'vue-pagination' : VuePagination
        },

        methods:{
            fetchCapitalAssetsData: function (page = 1) {
                axios.get('/budget/admin/sub_seasons/capital_assets/fetchData?page=' + page)
                    .then((response) => {
                        this.tinySeasons = response.data.data;
                        this.makePagination(response.data , "plan");
                        console.log(response.data);
                    },(error) => {
                        console.log(error);
                    });
            },

            fetchCostData: function (page = 1) {
                axios.get('/budget/admin/sub_seasons/cost/fetchData?page=' + page)
                    .then((response) => {
                        this.tinySeasonsCost = response.data.data;
                        this.makePagination(response.data , "cost");
                        console.log(response.data);
                    },(error) => {
                        console.log(error);
                    });
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
                axios.get('/admin/get_all_seasons')
                    .then((response) => {
                        this.seasons = response.data;
                        console.log(response);
                    },(error) => {
                        console.log(error);
                    });
            },

            getSeasonTitle: function () {
                axios.get(this.planOrCost == 0 ? '/budget/admin/season_title/capital_assets/getWithSeasonId' : '/budget/admin/season_title/cost/getWithSeasonId' , {params:{sId: this.selectedSeason}})
                    .then((response) => {
                        this.seasonTitles = response.data;
                        console.log(response);
                    },(error) => {
                        console.log(error);
                    });
            },

            openInsertModal: function (pOrC) {
                this.selectedSeason = -1;
                this.tinySeasonsInput = [];
                this.planOrCost = pOrC;
                this.errorMessage = '';
                this.showModal = true;
            },

            createTinySeason: function () {
                this.$validator.validateAll().then((result) => {
                    if (result) {
                        axios.post(this.planOrCost == 0 ? '/budget/admin/sub_seasons/capital_assets/register' : '/budget/admin/sub_seasons/cost/register' , {
                            stId: this.tinySeasonsInput.tsStId ,
                            subject: this.tinySeasonsInput.tsSubject ,
                            description: this.tinySeasonsInput.tsDescription}).then((response) => {
                                if(this.planOrCost == 1)
                                {
                                    this.tinySeasonsCost = response.data.data;
                                    this.makePagination(response.data , "cost");
                                }
                                else
                                {
                                    this.tinySeasons = response.data.data;
                                    this.makePagination(response.data , "plan");
                                }
                                this.showModal = false;
                                this.$parent.displayNotif(response.status);
                                this.tinySeasonsInput = [];
                                console.log(response);
                            },(error) => {
                                console.log(error);
                                this.errorMessage = 'ریز فصل با این مشخصات قبلا ثبت شده است!';
                            });
                    }});
            },

            tinySeasonUpdateDialog: function (sId , item , planOrCost) {
                this.planOrCost = planOrCost;
                this.selectedSeason = sId;
                this.getSeasonTitle();
                if (this.planOrCost == 0)
                {
                    this.tinySeasonsFill.tsStId = item.catsCastId;
                    this.tinySeasonsFill.tsSubject = item.catsSubject;
                    this.tinySeasonsFill.tsDescription = item.catsDescription;
                    this.tinySeasonsFill.id = item.id;
                }
                else if (this.planOrCost == 1)
                {
                    this.tinySeasonsFill.tsStId = item.ctsCstId;
                    this.tinySeasonsFill.tsSubject = item.ctsSubject;
                    this.tinySeasonsFill.tsDescription = item.ctsDescription;
                    this.tinySeasonsFill.id = item.id;
                }
                this.errorMessage_update = '';
                this.showModalUpdate = true;
            },

            updateTinySeason: function () {
                this.$validator.validateAll().then((result) => {
                    if (result) {
                        axios.post(this.planOrCost == 0 ? '/budget/admin/sub_seasons/capital_assets/update' : '/budget/admin/sub_seasons/cost/update' , {
                            id: this.tinySeasonsFill.id,
                            stId: this.tinySeasonsFill.tsStId ,
                            subject: this.tinySeasonsFill.tsSubject ,
                            description: this.tinySeasonsFill.tsDescription}).then((response) => {
                            if(this.planOrCost == 1)
                                {
                                    this.tinySeasonsCost = response.data.data;
                                    this.makePagination(response.data , "cost");
                                }
                            else
                                {
                                    this.tinySeasons = response.data.data;
                                    this.makePagination(response.data , "plan");
                                }
                                this.showModalUpdate = false;
                                this.$parent.displayNotif(response.status);
                                console.log(response);
                            },(error) => {
                                console.log(error);
                                this.errorMessage_update = 'ریز فصل با این مشخصات قبلا ثبت شده است!';
                            });
                        }
                });
            },

            openDeleteTinySeasonConfirm: function (ts , type) {
                this.tsIdDelete = ts;
                this.planOrCost = type;
                this.showModalDelete = true;
            },

            deleteTinySeason: function () {
                axios.post(this.planOrCost == 0 ? '/budget/admin/sub_seasons/capital_assets/delete' : '/budget/admin/sub_seasons/cost/delete' , {
                    id: this.tsIdDelete.id,
                    subject: this.planOrCost == 0 ? this.tsIdDelete.catsSubject : this.tsIdDelete.ctsSubject,
                }).then((response) => {
                        if (response.status != 204) //http status code for error in delete (no content)
                        {
                            if(this.planOrCost == 1)
                                this.tinySeasonsCost = response.data.data;
                            else
                                this.tinySeasons = response.data.data;
                        }
                        this.showModalDelete = false;
                        console.log(response);
                        this.$parent.displayNotif(response.status);
                    },(error) => {
                        console.log(error);
                });
            }
        }
    }
</script>
