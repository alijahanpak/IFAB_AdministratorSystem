<template xmlns:v-on="http://www.w3.org/1999/xhtml" xmlns:on-click="http://www.w3.org/1999/xhtml">
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
                                <span class="show-for-sr">Current: </span>عنوان طرح / برنامه
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
        <div class="grid-x my-callout-box container-mrg-top dynamic-height-level1">
            <div class="medium-12 padding-lr" style="margin-top: 15px;">
                <div class="clearfix border-btm-line tool-bar">
                    <div style="margin-top: 2px;" class="button-group float-right report-mrg">
                        <a class="my-button toolbox-btn small" @click="openInsertModal">جدید</a>
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
            </div>
            <div class="medium-12 column">
                    <div class="columns padding-lr table-mrg-top">
                        <!--Header Start-->
                        <div class="grid-x table-header">
                            <div class="medium-2 table-border">
                                <strong>شماره</strong>
                            </div>
                            <div class="medium-3 table-border">
                                <strong>عنوان</strong>
                            </div>
                            <div class="medium-2 table-border">
                                <strong>فصل بودجه</strong>
                            </div>
                            <div class="medium-2 table-border">
                                <strong>سطح شهرستان</strong>
                            </div>
                            <div class="medium-3 table-border">
                                <strong>شرح</strong>
                            </div>
                        </div>
                        <!--Header End-->
                        <div class="table-contain dynamic-height-level2">
                            <div class="grid-x" v-for="planOrCost in planOrCosts">
                                <div class="medium-2 table-contain-border cell-vertical-center">{{ planOrCost.cdtIdNumber }}</div>
                                <div class="medium-3 table-contain-border cell-vertical-center">{{ planOrCost.cdtSubject }}</div>
                                <div class="medium-2 table-contain-border cell-vertical-center">{{ planOrCost.budget_season.bsSubject }}</div>
                                <div class="medium-2 table-contain-border cell-vertical-center text-center">
                                    <a class="" v-if="planOrCost.c_d_t_in_county.length != 0" @click="displayCountyInfo == planOrCost.id ? displayCountyInfo = '' : displayCountyInfo = planOrCost.id">جزئیات</a>
                                    <span class="comlpleted-badage" v-if="planOrCost.c_d_t_in_county.length == 0">تعریف نشده</span>
                                </div>
                                <div class="medium-3 table-contain-border cell-vertical-center">
                                    <div class="grid-x">
                                        <div class="medium-11">
                                            {{ planOrCost.cdtDescription }}
                                        </div>
                                        <div class="medium-1 cell-vertical-center text-left">
                                            <a class="dropdown small sm-btn-align"  type="button" :data-toggle="'budgetSeason' + planOrCost.id"><img width="15px" height="15px"  src="/IFAB_AdministratorSystem/public/pic/menu.svg"></a>
                                            <div class="dropdown-pane dropdown-pane-sm " data-close-on-click="true"  data-hover="true" data-hover-pane="true"  data-position="bottom" data-alignment="right" :id="'budgetSeason' + planOrCost.id" data-dropdown data-auto-focus="true">
                                                <ul class="my-menu small-font text-right">
                                                    <li><a data-open="preloaderModal"><i class="fi-pencil size-16"></i>  ویرایش</a></li>
                                                    <li><a data-open="modalDelete"><i class="fi-trash size-16"></i>  حذف</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="medium-12">
                                <div class="grid-x" v-show="displayCountyInfo == planOrCost.id">
                                    <div class="medium-12 table-contain-border cell-vertical-center">
                                        <table class="unstriped tbl-secondary-mrg small-font">
                                            <thead class="my-thead">
                                                <tr style="background-color: #F1F1F1 !important;">
                                                    <th>شهرستان</th>
                                                    <th>کد</th>
                                                    <th>شرح</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr v-for="cdtInCounty in planOrCost.c_d_t_in_county">
                                                    <td>{{ cdtInCounty.county.coName }}</td>
                                                    <td>{{ cdtInCounty.cdtIdNumber }}</td>
                                                    <td>{{ cdtInCounty.cdtDescription }}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="grid-x">
                        <div class="medium-12">
                            <vue-pagination  v-bind:pagination="pagination"
                                             v-on:click.native="fetchData(pagination.current_page)"
                                             :offset="4">
                            </vue-pagination>
                        </div>
                    </div>
            </div>
        </div>
        <!--modalDelete Start-->
        <modal-tiny v-if="showFyActiveModal" @close="showFyActiveModal = false">
            <div  slot="body">

            </div>
        </modal-tiny>
        <!--modalDelete end-->

        <!--ModalInsert Start-->
        <modal-small v-if="showInsertModal" @close="showInsertModal = false">
            <div  slot="body">
                <div class="padding-lr">
                    <form v-on:submit.prevent="createPlanOrCostTitle">
                        <div class="grid-x" style="display: none">
                            <div class="medium-12 columns">
                                <div class="alert callout">
                                    <p class="BYekan login-alert"><i class="fi-alert"></i>این عنوان طرح / برنامه قبلا ثبت شده است!</p>
                                </div>
                            </div>
                        </div>
                        <div class="grid-x">
                            <div class="medium-6 cell padding-lr">
                                <label>فصل بودجه
                                    <select class="form-element-margin-btm" v-model="planOrCostInput['bsId']" name="bsId" v-validate data-vv-rules="required" :class="{'input': true, 'select-error': errors.has('bsId')}">
                                        <option value=""></option>
                                        <option v-for="bSeason in bSeasons" :value="bSeason.id">{{ bSeason.bsSubject }}</option>
                                    </select>
                                    <span v-show="errors.has('bsId')" class="error-font">فصل بودجه را انتخاب کنید!</span>
                                </label>
                            </div>
                            <div class="small-6 columns padding-lr">
                                <label>کد طرح / برنامه
                                    <input class="form-element-margin-btm" type="text" name="pCode" v-model="planOrCostInput['code']" v-validate="'required'" :class="{'input': true, 'error-border': errors.has('pCode')}">
                                    <span v-show="errors.has('pCode')" class="error-font">لطفا کد طرح مورد نظر را وارد نمایید!</span>
                                </label>
                            </div>
                        </div>
                        <div class="grid-x">
                            <div class="small-12 columns padding-lr">
                                <label>عنوان طرح / برنامه
                                    <input class="form-element-margin-btm" type="text" name="pcSubject" v-model="planOrCostInput['subject']" v-validate="'required'" :class="{'input': true, 'error-border': errors.has('pcSubject')}">
                                    <span v-show="errors.has('pcSubject')" class="error-font">لطفا عنوان طرح مورد نظر را وارد نمایید!</span>
                                </label>
                            </div>
                        </div>
                        <div class="grid-x" style="margin-top: 20px">
                            <div class="medium-12 column padding-lr">
                                <ul class="accordion" data-accordion data-allow-all-closed="true">
                                    <li class="accordion-item" data-accordion-item>
                                        <a href="#" class="accordion-title acurdion-focus">کد طرح در سطح شهرستان</a>
                                        <!-- Accordion tab content: it would start in the open state due to using the `is-active` state class. -->
                                        <div class="accordion-content" data-tab-content>
                                            <div class="grid-x">
                                                <div class="medium-12 column">
                                                    <div class="grid-x" v-for="county in counties">
                                                        <div class="medium-4 padding-lr">
                                                            <label>{{ county.coName }}
                                                                <div class="input-group">
                                                                    <input class="input-group-field text-left" type="text" name="cdptCounty" v-model="planOrCostInput['county' + county.id]" id="cdptCounty" autocomplete="off">
                                                                    <span class="input-group-label" style="padding-right: 4px;padding-left: 4px">{{ provincePlanLabel }}</span>
                                                                    <span class="input-group-label" style="padding-right: 2px;padding-left: 2px" id="cdptPlanCodeLabel">{{ (planOrCostInput.code == null || planOrCostInput.code == '') ? '--' : planOrCostInput.code }}</span>
                                                                </div>
                                                            </label>
                                                        </div>
                                                        <div class="medium-8 padding-lr">
                                                            <label>شرح
                                                                <input type="text" name="cdptCountyDesc" v-model="planOrCostInput['countyDesc' + county.id]" id="cdptCountyDesc">
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="grid-x">
                            <div class="small-12 columns padding-lr">
                                <span class="form-error font-wei" id="CDPT_duplicateErro">لطفا در وارد کردن کد طرح دقت کنید - کد تکراری!</span>
                            </div>
                        </div>
                        <div class="grid-x">
                            <div class="small-12 columns padding-lr">
                                <label>شرح
                                    <textarea name="bsDescription" v-model="planOrCostInput['description']" style="min-height: 150px;"></textarea>
                                </label>
                            </div>
                        </div>
                        <div class="medium-6 columns padding-lr">
                            <button name="Submit" type="submit" class="my-secondary button float-left btn-for-load"> <span>  ثبت</span></button>
                        </div>
                    </form>
                </div>
            </div>
        </modal-small>
        <!--ModalInsert End-->
    </div>
</template>
<script>
    import VuePagination from '../../../public_component/pagination.vue';
    export default {
        data(){
            return {
                planOrCosts: [],
                planOrCostInput: {},
                showInsertModal: false,
                bSeasons: [],
                counties: [],
                displayCountyInfo: '',
                provincePlanLabel: '',
                pagination: {
                    total: 0,
                    to: 0,
                    current_page: 1,
                    last_page: ''
                },
            }
        },

        created: function () {
            this.fetchData();
            this.getBudgetSeason();
        },

        updated: function () {
            $(this.$el).foundation(); //WORKS!
        },

        mounted: function () {
            console.log("mounted budget season component");
            this.$parent.myResize();
        },

        components:{
            'vue-pagination' : VuePagination
        },

        methods:{
            fetchData: function (page = 1) {
                axios.get('/budget/admin/credit_distribution_def/plan_cost_title/fetchData?page=' + page)
                    .then((response) => {
                        this.planOrCosts = response.data.data;
                        this.makePagination(response.data);
                        console.log(response.status);
                    },(error) => {
                        console.log(error);
                    });
            },

            getBudgetSeason: function () {
                axios.get('/budget/admin/credit_distribution_def/budget_season/fetchData')
                    .then((response) => {
                        this.bSeasons = response.data;
                        console.log(response);
                    },(error) => {
                        console.log(error);
                    });
            },

            getCounties: function () {
                axios.get('/admin/get_all_counties')
                    .then((response) => {
                        this.counties = response.data;
                        console.log(response);
                    },(error) => {
                        console.log(error);
                    });
            },

            getProvincePlaLabel: function () {
                axios.get('/admin/get_province_plan_label')
                    .then((response) => {
                        this.provincePlanLabel = response.data;
                        console.log(response);
                    },(error) => {
                        console.log(error);
                    });
            },

            openInsertModal: function () {
                this.getCounties();
                this.getProvincePlaLabel();
                this.showInsertModal = true;
            },

            createPlanOrCostTitle: function () {
                this.$validator.validateAll().then((result) => {
                    if (result) {
                        var jsonString = '{';
                        jsonString += '"bsId":"' + this.planOrCostInput.bsId + '",';
                        jsonString += '"code":"' + this.planOrCostInput.code + '",';
                        jsonString += '"subject":"' + this.planOrCostInput.subject + '",';
                        jsonString += '"description":"' + this.planOrCostInput.description + '",';
                        this.counties.forEach(county => {
                            if (this.planOrCostInput['county' + county.id])
                                jsonString += '"county' + county.id + '":"' + this.planOrCostInput['county' + county.id] + '",';
                            if (this.planOrCostInput['countyDesc' + county.id])
                                jsonString += '"countyDesc' + county.id + '":"' + this.planOrCostInput['countyDesc' + county.id] + '",'
                        });
                        jsonString += '"":""}';
                        axios.post('/budget/admin/credit_distribution_def/plan_cost_title/register' , JSON.parse(jsonString))
                            .then((response) => {
                                this.planOrCosts = response.data.data;
                                this.makePagination(response.data);
                                this.showInsertModal = false;
                                this.$parent.displayNotif(response.status);
                                this.planOrCostInput = [];
                                console.log(response);
                            },(error) => {
                                console.log(error);
                                this.errorMessage = 'عنوان طرح / برنامه با این مشخصات قبلا ثبت شده است!';
                            });
                    }
                });
            },

            makePagination: function(data){
                this.pagination.current_page = data.current_page;
                this.pagination.to = data.to;
                this.pagination.last_page = data.last_page;
            }
        }
    }
</script>
