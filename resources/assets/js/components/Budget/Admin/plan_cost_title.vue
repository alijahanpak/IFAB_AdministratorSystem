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
                <div class="clearfix tool-bar">
                    <div style="margin-top: 2px;" class="button-group float-right report-mrg">
                        <a class="my-button toolbox-btn small" @click="openInsertModal">جدید</a>
                        <div v-if="!selectColumn" class="input-group-button toggle-icon-change">
                            <button type="button" class="my-button my-icon-brand tiny" @click="showSelectColumn(planOrCosts)"><i class="fa fa-check-square-o size-14" aria-hidden="true"></i></button>
                        </div>
                        <div v-if="selectColumn" class="input-group-button toggle-icon-change">
                            <button type="button" class="my-button my-icon-danger tiny" @click="showSelectColumn(planOrCosts)"><i class="fa fa-times size-14" aria-hidden="true"></i></button>
                        </div>
                        <button class="my-button toolbox-btn small dropdown small sm-btn-align"  type="button" data-toggle="reportDropDown1">گزارش</button>
                        <div  style="width: 113px;" class="dropdown-pane dropdown-pane-sm " data-close-on-click="true"  data-hover="true" data-hover-pane="true"  data-position="bottom" data-alignment="left" id="reportDropDown1" data-dropdown data-auto-focus="true">
                            <ul class="my-menu small-font ltr-dir">
                                <li><a @click="openReportModal('pdf')"><i class="fa fa-file-pdf-o icon-margin-dropdown" aria-hidden="true"></i>PDF</a></li>
                                <li><a @click="openReportModal('excel')"><i class="fa fa-file-excel-o icon-margin-dropdown" aria-hidden="true"></i>Excel</a></li>
                            </ul>
                        </div>
                        <button class="my-button toolbox-btn small dropdown small sm-btn-align"  type="button" data-toggle="costDropDown">تعداد نمایش<span> {{ itemInPage }} </span></button>
                        <div style="width: 113px;" class="dropdown-pane dropdown-pane-sm " data-close-on-click="true"  data-hover="true" data-hover-pane="true"  data-position="bottom" data-alignment="left" id="costDropDown" data-dropdown data-auto-focus="true">
                            <ul class="my-menu small-font ltr-dir">
                                <li><a  @click="changeItemInPage(5)">5<span v-show="itemInPage == 5" class="fi-check checked-color size-14"></span></a></li>
                                <li><a  @click="changeItemInPage(10)">10<span v-show="itemInPage == 10" class="fi-check checked-color size-14"></span></a></li>
                                <li><a  @click="changeItemInPage(15)">15<span v-show="itemInPage == 15" class="fi-check checked-color size-14"></span></a></li>
                                <li><a  @click="changeItemInPage(20)">20<span v-show="itemInPage == 20" class="fi-check checked-color size-14"></span></a></li>
                                <li><a  @click="changeItemInPage(30)">30<span v-show="itemInPage == 30" class="fi-check checked-color size-14"></span></a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="float-left">
                        <div class="input-group float-left">
                            <div class="inner-addon right-addon">
                                <i v-if="searchValue == ''" class="fa fa-search purple-color"  aria-hidden="true"></i>
                                <i v-if="searchValue != ''" v-on:click.stop="removeFilter()" class="fa fa-close btn-red"  aria-hidden="true"></i>
                                <input v-model="searchValue" v-on:keyup.enter="search()" class="search" type="text" placeholder="جستجو">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="medium-12 column padding-lr">
                <div class="tbl-div-container">
                    <table class="tbl-head">
                        <colgroup>
                            <col width="150px"/>
                            <col width="250px"/>
                            <col width="150px"/>
                            <col width="150px"/>
                            <col width="235px"/>
                            <col v-show="selectColumn" width="15px"/>
                            <col width="12px"/>
                        </colgroup>
                        <tbody class="tbl-head-style">
                        <tr class="tbl-head-style-cell">
                            <th class="tbl-head-style-cell">شماره</th>
                            <th class="tbl-head-style-cell">عنوان</th>
                            <th class="tbl-head-style-cell">فصل بودجه</th>
                            <th class="tbl-head-style-cell">سطح شهرستان</th>
                            <th class="tbl-head-style-cell">شرح</th>
                            <th class="tbl-head-style-checkbox" v-show="selectColumn"><input type="checkbox" @click="toggleSelect(planOrCosts)" :checked="allSelected(planOrCosts)"></th>
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
                                <col width="250px"/>
                                <col width="150px"/>
                                <col width="150px"/>
                                <col width="250px"/>
                                <col v-show="selectColumn" width="15px"/>
                            </colgroup>
                            <tbody class="tbl-head-style-cell">
                            <template v-for="planOrCost in planOrCosts">
                                <tr>
                                    <td class="text-center">{{ planOrCost.cdtIdNumber }}</td>
                                    <td>{{ planOrCost.cdtSubject }}</td>
                                    <td class="text-center">{{ planOrCost.budget_season.bsSubject }}</td>
                                    <td class="text-center">
                                        <a class="" v-if="planOrCost.c_d_t_in_county.length != 0" @click="displayCountyInfo == planOrCost.id ? displayCountyInfo = '' : displayCountyInfo = planOrCost.id">جزئیات</a>
                                        <span class="comlpleted-badage" v-if="planOrCost.c_d_t_in_county.length == 0">تعریف نشده</span>
                                    </td>
                                    <td>
                                        <div class="grid-x">
                                            <div class="medium-11 text-justify">
                                                {{ planOrCost.cdtDescription }}
                                            </div>
                                            <div class="medium-1 cell-vertical-center text-left">
                                                <a class="dropdown small sm-btn-align"  type="button" :data-toggle="'planOrCostTitles' + planOrCost.id"><i class="fa fa-ellipsis-v size-18"></i></a>
                                                <div class="dropdown-pane dropdown-pane-sm " data-close-on-click="true"  data-hover="true" data-hover-pane="true"  data-position="bottom" data-alignment="right" :id="'planOrCostTitles' + planOrCost.id" data-dropdown data-auto-focus="true">
                                                    <ul class="my-menu small-font text-right">
                                                        <li><a v-on:click.prevent="openUpdateModal(planOrCost)"><i class="fi-pencil size-16"></i>  ویرایش</a></li>
                                                        <li><a v-on:click.prevent="openDeleteModal(planOrCost.id)"><i class="fi-trash size-16"></i>  حذف</a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td  v-show="selectColumn">
                                        <input class="auto-margin" v-model="planOrCost.checked" type="checkbox">
                                    </td>
                                </tr>
                                <tr v-show="displayCountyInfo == planOrCost.id">
                                    <td colspan="6">
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
                                    </td>
                                </tr>
                            </template>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="grid-x">
                    <div class="medium-8">
                        <vue-pagination  v-bind:pagination="pagination"
                                         v-on:click.native="fetchData(pagination.current_page)"
                                         :offset="4">
                        </vue-pagination>
                    </div>
                    <div style="color: #575962;" v-show="selectColumn" class="medium-4 small-font">
                        <div class="float-left">
                            <p> تعداد رکورد های انتخاب شده :<span class="selected-row-style">{{ selectedLength(planOrCosts) }}</span></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
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
                                <ul class="accordion form-element-margin-btm" data-accordion data-allow-all-closed="true">
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
                                                                    <input class="input-group-field text-left" type="text" name="cdptCounty" v-model="planOrCostInput['county' + county.id]" autocomplete="off">
                                                                    <span class="input-group-label" style="padding-right: 4px;padding-left: 4px">{{ provincePlanLabel }}</span>
                                                                    <span class="input-group-label" style="padding-right: 2px;padding-left: 2px">{{ (planOrCostInput.code == null || planOrCostInput.code == '') ? '--' : planOrCostInput.code }}</span>
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
                        <div class="grid-x" v-show="CDPT_duplicateError">
                            <div class="small-12 columns padding-lr">
                                <span class="error-font">لطفا در وارد کردن کد طرح دقت کنید - کد تکراری!</span>
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
                            <button type="submit" class="my-button my-success float-left btn-for-load"><span class="btn-txt-mrg">ثبت</span></button>
                        </div>
                    </form>
                </div>
            </div>
        </modal-small>
        <!--ModalInsert End-->
        <!--ModalUpdate Start-->
        <modal-small v-if="showUpdateModal" @close="showUpdateModal = false">
            <div  slot="body">
                <div class="padding-lr">
                    <form v-on:submit.prevent="updatePlanOrCostTitle">
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
                                    <select class="form-element-margin-btm" v-model="planOrCostFill['bsId']" name="bsId" v-validate data-vv-rules="required" :class="{'input': true, 'select-error': errors.has('bsId')}">
                                        <option value=""></option>
                                        <option v-for="bSeason in bSeasons" :value="bSeason.id">{{ bSeason.bsSubject }}</option>
                                    </select>
                                    <span v-show="errors.has('bsId')" class="error-font">فصل بودجه را انتخاب کنید!</span>
                                </label>
                            </div>
                            <div class="small-6 columns padding-lr">
                                <label>کد طرح / برنامه
                                    <input class="form-element-margin-btm" type="text" name="pCode" v-model="planCodeTemp" v-validate="'required'" :class="{'input': true, 'error-border': errors.has('pCode')}">
                                </label>
                                <span v-show="errors.has('pCode')" class="error-font">لطفا کد طرح مورد نظر را وارد نمایید!</span>
                            </div>
                        </div>
                        <div class="grid-x">
                            <div class="small-12 columns padding-lr">
                                <label>عنوان طرح / برنامه
                                    <input class="form-element-margin-btm" type="text" name="pcSubject" v-model="planOrCostFill['subject']" v-validate="'required'" :class="{'input': true, 'error-border': errors.has('pcSubject')}">
                                    <span v-show="errors.has('pcSubject')" class="error-font">لطفا عنوان طرح مورد نظر را وارد نمایید!</span>
                                </label>
                            </div>
                        </div>
                        <div class="grid-x" style="margin-top: 20px">
                            <div class="medium-12 column padding-lr">
                                <ul class="accordion form-element-margin-btm" data-accordion data-allow-all-closed="true">
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
                                                                    <input class="input-group-field text-left" type="text" name="cdptCounty" v-model="planOrCostFill['county' + county.id]" autocomplete="off">
                                                                    <span class="input-group-label" style="padding-right: 4px;padding-left: 4px">{{ provincePlanLabel }}</span>
                                                                    <span class="input-group-label" style="padding-right: 2px;padding-left: 2px">{{ (planCodeTemp == null || planCodeTemp == '') ? '--' : planCodeTemp }}</span>
                                                                </div>
                                                            </label>
                                                        </div>
                                                        <div class="medium-8 padding-lr">
                                                            <label>شرح
                                                                <input type="text" name="cdptCountyDesc" v-model="planOrCostFill['countyDesc' + county.id]">
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
                        <div class="grid-x" v-show="CDPT_duplicateError">
                            <div class="small-12 columns padding-lr">
                                <span class="error-font">لطفا در وارد کردن کد طرح دقت کنید - کد تکراری!</span>
                            </div>
                        </div>
                        <div class="grid-x">
                            <div class="small-12 columns padding-lr">
                                <label>شرح
                                    <textarea name="bsDescription" v-model="planOrCostFill['description']" style="min-height: 150px;"></textarea>
                                </label>
                            </div>
                        </div>
                        <div class="medium-6 columns padding-lr">
                            <button type="submit" class="my-button my-success float-left btn-for-load"><span class="btn-txt-mrg">ثبت</span></button>
                        </div>
                    </form>
                </div>
            </div>
        </modal-small>
        <!--ModalUpdate End-->
        <!-- Delete Modal Start -->
        <modal-tiny v-if="showDeleteModal" @close="showDeleteModal = false">
            <div  slot="body">
                <div class="small-font">
                    <p>کاربر گرامی</p>
                    <p class="large-offset-1 modal-text">آیا برای حذف این رکورد اطمینان دارید؟</p>
                    <div class="grid-x">
                        <div class="medium-12 column text-center">
                            <button v-on:click="deletePlanOrCostTitle" class="my-button my-success"><span class="btn-txt-mrg">   بله   </span></button>
                        </div>
                    </div>
                </div>
            </div>
        </modal-tiny>
        <!-- Delete Modal End -->
        <!--Report Modal Start-->
        <modal-tiny v-if="showModalReport" @close="showModalReport= false">
            <div  slot="body">
                <div class="small-font">
                    <form v-on:submit.prevent="openReportFile">
                        <div class="grid-x padding-lr">
                            <div class="medium-12">
                                <label>عنوان
                                    <input type="text" v-model="reportOptions.title">
                                </label>
                            </div>
                        </div>
                        <div v-show="reportType == 'pdf'">
                            <div style="margin-top: 10px;" class="grid-x padding-lr">
                                <div class="medium-2">
                                    <div class="switch tiny">
                                        <input checked="true" class="switch-input" id="yes-no-1" v-model="reportOptions.withReporterName" type="checkbox">
                                        <label class="switch-paddle" for="yes-no-1">
                                            <span class="switch-active" aria-hidden="true">بلی</span>
                                            <span class="switch-inactive" aria-hidden="true">خیر</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="medium-10">
                                    <p>درج نام کاربر تهیه کننده گزارش</p>
                                </div>
                            </div>
                            <div class="grid-x padding-lr">
                                <div class="medium-2">
                                    <div class="switch tiny">
                                        <input checked="true" class="switch-input" id="yes-no-2" type="checkbox" v-model="reportOptions.withFiscalYear">
                                        <label class="switch-paddle" for="yes-no-2">
                                            <span class="switch-active" aria-hidden="true">بلی</span>
                                            <span class="switch-inactive" aria-hidden="true">خیر</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="medium-10">
                                    <p>درج سال مالی</p>
                                </div>
                            </div>
                            <div class="grid-x padding-lr">
                                <div class="medium-2">
                                    <div class="switch tiny">
                                        <input checked="true" class="switch-input" id="yes-no3" type="checkbox" v-model="reportOptions.withReportDate">
                                        <label class="switch-paddle" for="yes-no3">
                                            <span class="switch-active" aria-hidden="true">بلی</span>
                                            <span class="switch-inactive" aria-hidden="true">خیر</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="medium-10">
                                    <p>درج تاریخ گزارش</p>
                                </div>
                            </div>
                            <div class="grid-x padding-lr">
                                <div class="medium-2">
                                    <div class="switch tiny">
                                        <input checked="true" class="switch-input" id="yes-no4" type="checkbox" v-model="reportOptions.orientation">
                                        <label class="switch-paddle" for="yes-no4">
                                            <span class="switch-active" aria-hidden="true">افقی</span>
                                            <span class="switch-inactive" aria-hidden="true">عمودی</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="medium-10">
                                    <p>جهت کاغذ</p>
                                </div>
                            </div>
                        </div>
                        <div class="medium-12 columns padding-lr padding-bottom-modal input-margin-top">
                            <button name="Submit" class="my-button my-success float-left"> <span class="btn-txt-mrg">مشاهده</span></button>
                        </div>
                    </form>
                </div>
            </div>
        </modal-tiny>
        <!--Report Modal End-->
    </div>
</template>
<script>
    import VuePagination from '../../../public_component/pagination.vue';
    export default {
        data(){
            return {
                planOrCosts: [],
                planOrCostInput: {},
                planOrCostFill: {},
                planCodeTemp: '',
                searchValue:'',
                showInsertModal: false,
                showUpdateModal: false,
                showDeleteModal: false,
                showModalReport:false,
                selectColumn:false,
                bSeasons: [],
                counties: [],
                itemInPage: 5,
                selectedPcIdForDelete: '',
                displayCountyInfo: '',
                provincePlanLabel: '',
                CDPT_duplicateError: false,
                selectedItems: [],
                selectedCount: 0,
                reportOptions: {title:'' , withReporterName: true , withFiscalYear: true , withReportDate: true , orientation: true , costLabel:false},
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
            this.getProvincePlanLabel();
        },

        updated: function () {
            $(this.$el).foundation(); //WORKS!
            this.$parent.userIsActive();
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
                axios.get('/budget/admin/credit_distribution_def/plan_cost_title/fetchData?page=' + page , {params:{
                            searchValue: this.searchValue,
                            itemInPage: this.itemInPage
                        }})
                    .then((response) => {
                        this.planOrCosts = response.data.data;
                        this.makePagination(response.data);
                        console.log(response.status);
                    },(error) => {
                        console.log(error);
                });
            },

            search: function () {
                this.fetchData();
            },

            changeItemInPage: function (number) {
                this.itemInPage = number;
                this.fetchData();
            },

            removeFilter: function () {
                this.searchValue = '';
                this.fetchData();
            },

            openReportModal: function (type) {
                this.reportType = type;
                this.selectedItems = [];
                    if (this.selectedLength(this.planOrCosts) != 0)
                    {
                        this.showModalReport = true;
                        this.planOrCosts.forEach(plan => {
                            if (plan.checked == true)
                                this.selectedItems.push(plan);
                        });
                        this.reportOptions.title = 'عنوان طرح / برنامه';
                    }
                    else{
                        this.$parent.displayNotif(800);
                    }
                console.log(JSON.stringify(this.selectedItems));
            },

            openReportFile: function () {
                axios.post('budget/admin/credit_distribution_def/report' , {type: this.reportType ,options: this.reportOptions , selectedItems: this.selectedItems})
                    .then((response) => {
                        console.log(response.data);
                        window.open(response.data);
                    },(error) => {
                        console.log(error);
                    });
            },

            showSelectColumn: function (planOrCost) {
                this.selectAll(planOrCost);
                if (this.selectColumn)
                {
                    this.selectColumn=false;
                }
                else {
                    this.selectColumn = true;
                }
            },
            toggleSelect: function(planOrCost) {
                if(planOrCost.find(plan => plan.checked)){
                    planOrCost.forEach(plan => plan.checked = false)
                } else {
                    planOrCost.forEach(plan => plan.checked = true)
                }
            },

            allSelected: function(planOrCost) {
                return planOrCost.every(function(plan){
                    return plan.checked;
                });
            },

            selectAll: function (planOrCost) {
                planOrCost.forEach(plan => {
                    this.$set(plan , 'checked' , true);
                });
            },

            selectedLength: function (planOrCost) {
                return planOrCost.filter(function (value) {
                    return value.checked === true;
                }).length;
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

            getProvincePlanLabel: function () {
                axios.get('/admin/get_province_plan_label')
                    .then((response) => {
                        this.provincePlanLabel = response.data;
                        console.log(response);
                    },(error) => {
                        console.log(error);
                    });
            },

            openInsertModal: function () {
                this.planOrCostInput = [];
                this.getBudgetSeason();
                this.getCounties();
                this.getProvincePlanLabel();
                this.CDPT_duplicateError = false;
                this.showInsertModal = true;
            },

            openUpdateModal: function (planOrCost) {
                this.planOrCostFill = [];
                this.getBudgetSeason();
                this.planOrCostFill.id = planOrCost.id;
                this.planOrCostFill.bsId = planOrCost.cdtBsId;
                this.planCodeTemp = planOrCost.cdtIdNumber;
                this.planOrCostFill.subject = planOrCost.cdtSubject;
                this.planOrCostFill.description = planOrCost.cdtDescription;
                this.getCounties();
                planOrCost.c_d_t_in_county.forEach(county => {
                    this.planOrCostFill['county' + county.cdtCoId] = county.cdtIdNumber.split(this.provincePlanLabel)[0];
                    this.planOrCostFill['countyDesc' + county.cdtCoId] = county.cdtDescription;
                });
                this.CDPT_duplicateError = false;
                this.showUpdateModal = true;
            },

            openDeleteModal: function (pcId) {
                this.selectedPcIdForDelete = pcId;
                this.showDeleteModal = true;
            },

            createPlanOrCostTitle: function () {
                this.$validator.validateAll().then((result) => {
                    if (result) {
                        if (!this.duplicateCountyCode(this.planOrCostInput))
                        {
                            var jsonString = '{';
                            jsonString += '"searchValue":"' + this.searchValue + '",';
                            jsonString += '"itemInPage":"' + this.itemInPage + '",';
                            jsonString += '"bsId":"' + this.planOrCostInput.bsId + '",';
                            jsonString += '"code":"' + this.planOrCostInput.code + '",';
                            jsonString += '"subject":"' + this.planOrCostInput.subject + '",';
                            jsonString += '"description":"' + this.planOrCostInput.description + '",';
                            this.counties.forEach(county => {
                                if (this.planOrCostInput['county' + county.id])
                                    jsonString += '"county' + county.id + '":"' + this.planOrCostInput['county' + county.id] + '",';
                                if (this.planOrCostInput['countyDesc' + county.id])
                                    jsonString += '"countyDesc' + county.id + '":"' + this.planOrCostInput['countyDesc' + county.id] + '",';
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
                                    this.$parent.displayNotif(error.response.status);
                            });
                        }
                        else{
                            this.CDPT_duplicateError = true;
                        }
                    }
                });
            },

            updatePlanOrCostTitle: function () {
                this.$validator.validateAll().then((result) => {
                    if (result) {
                        if (!this.duplicateCountyCode(this.planOrCostFill))
                        {
                            var jsonString = '{';
                            jsonString += '"searchValue":"' + this.searchValue + '",';
                            jsonString += '"itemInPage":"' + this.itemInPage + '",';
                            jsonString += '"id":"' + this.planOrCostFill.id + '",';
                            jsonString += '"bsId":"' + this.planOrCostFill.bsId + '",';
                            jsonString += '"code":"' + this.planCodeTemp + '",';
                            jsonString += '"subject":"' + this.planOrCostFill.subject + '",';
                            jsonString += '"description":"' + this.planOrCostFill.description + '",';
                            this.counties.forEach(county => {
                                if (this.planOrCostFill['county' + county.id])
                                {
                                    jsonString += '"county' + county.id + '":"' + this.planOrCostFill['county' + county.id] + '",';
                                    if (this.planOrCostFill['countyDesc' + county.id])
                                        jsonString += '"countyDesc' + county.id + '":"' + this.planOrCostFill['countyDesc' + county.id] + '",';
                                }
                            });
                            jsonString += '"":""}';
                            axios.post('/budget/admin/credit_distribution_def/plan_cost_title/update' , JSON.parse(jsonString))
                                .then((response) => {
                                    this.planOrCosts = response.data.data;
                                    this.makePagination(response.data);
                                    this.showUpdateModal = false;
                                    this.$parent.displayNotif(response.status);
                                    this.planOrCostFill = [];
                                    console.log(response);
                                },(error) => {
                                    console.log(error);
                                    this.$parent.displayNotif(error.response.status);
                                });
                        }
                        else{
                            this.CDPT_duplicateError = true;
                        }
                    }
                });
            },

            deletePlanOrCostTitle: function () {
                axios.post('/budget/admin/credit_distribution_def/plan_cost_title/delete' , {
                        id: this.selectedPcIdForDelete,
                        searchValue: this.searchValue,
                        itemInPage: this.itemInPage
                    })
                    .then((response) => {
                        if (response.status != 204)
                            this.planOrCosts = response.data.data;
                        this.showDeleteModal = false;
                        this.$parent.displayNotif(response.status);
                        console.log(response);
                    },(error) => {
                        console.log(error);
                        this.showDeleteModal = false;
                    });
            },

            duplicateCountyCode: function (plan) {
                var temp = [];
                this.counties.forEach(county => {
                    if (plan['county' + county.id])
                        temp.push(plan['county' + county.id]);
                });
                return temp.some((val,i)=>{
                    return temp.indexOf(val)!=i;
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
