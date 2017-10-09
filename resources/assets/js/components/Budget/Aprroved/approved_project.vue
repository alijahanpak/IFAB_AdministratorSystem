<template xmlns:v-on="http://www.w3.org/1999/xhtml">
    <!--Inner body start-->
    <div class="medium-10 border-right-line inner-body-pad main-margin" xmlns:v-on="http://www.w3.org/1999/xhtml">
        <div class="grid-x padding-lr">
            <div class="medium-12">
                <div class="grid-x border-btm-line">
                    <nav aria-label="You are here:" role="navigation">
                        <ul class="breadcrumbs">
                            <li><a href="">داشبورد</a></li>
                            <li>
                                <a class="disabled">موافقتنامه</a>
                            </li>
                            <li>
                                <a class="disabled">تملک دارایی سرمایه ای</a>
                            </li>
                            <li>
                                <span class="show-for-sr">Current: </span>پروژه ها
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
        <div id="approvedProjects" class="grid-x dashboard-padding">
            @include('budget::pages.approved_projects.forms')
            <div  class="medium-12 column my-callout dynamic-height-level1">
                <div id="dynamicParentId1">
                    <div class="clearfix border-btm-line bottom-mrg">
                        <div class="button-group float-left report-mrg">
                            <a  class="clear button has-tip" id="show-modal" @click="showModal = true; errorMessage = ''" data-tooltip aria-haspopup="true" data-disable-hover="false" tabindex="1" title="جدید" data-position="top" data-alignment="center">
                                <i class="fi-plus size-30 secondry-color"></i>
                            </a>
                            <a  class="clear button has-tip" data-tooltip aria-haspopup="true" data-disable-hover="false" tabindex="1" title="گزارش" data-position="top" data-alignment="center">
                                <i class="fi-clipboard-notes size-30 secondry-color"></i>
                            </a>
                        </div>
                        <div class="float-right">
                            <div class="input-group float-left">
                                <input class="input-group-field small-font" type="text">
                                <div class="input-group-button">
                                    <button type="button" class="my-secondary button"><i class="fi-magnifying-glass"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--Table Start-->
                    <div class="columns">
                        <!--Header Start-->
                        <div class="grid-x table-header">
                            <div class="medium-2 table-border">
                                <strong>کد طرح</strong>
                            </div>
                            <div class="medium-10">
                                <div class="grid-x">
                                    <div class="medium-1 table-border">
                                        <strong>کد</strong>
                                    </div>
                                    <div class="medium-3 table-border">
                                        <strong>عنوان</strong>
                                    </div>
                                    <div class="medium-2 table-border">
                                        <strong>نحوه اجرا</strong>
                                    </div>
                                    <div class="medium-2 table-border">
                                        <strong>اعتبار</strong>
                                    </div>
                                    <div class="medium-4  table-border">
                                        <strong>شرح</strong>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--Header End-->
                        <div class="table-contain dynamic-height-level2">
                            <div class="grid-x" v-for="plans in approvedProjects">
                                <div class="medium-2 table-contain-border cell-vertical-center">
                                    @{{ plans.credit_distribution_title.cdtIdNumber }}
                                </div>
                                <div class="medium-10">
                                    <div class="grid-x selectAbleRow" v-for="projects in plans.capital_assets_project">
                                        <div class="medium-1 table-contain-border cell-vertical-center">
                                            @{{ projects.cpCode }}
                                        </div>
                                        <div class="medium-3 table-contain-border cell-vertical-center">
                                            @{{ projects.cpSubject }}
                                        </div>
                                        <div class="medium-2 table-contain-border cell-vertical-center">
                                            @{{ projects.how_to_run.htrSubject }}
                                        </div>
                                        <div class="medium-2 table-contain-border cell-vertical-center">
                                            @{{ getProjectAmount(projects.cdr_cp) }}
                                        </div>
                                        <div class="medium-4  table-contain-border cell-vertical-center">
                                            <div class="grid-x">
                                                <div class="medium-11">
                                                    @{{ projects.cpDescription }}
                                                </div>
                                                <div class="medium-1 cell-vertical-center text-left">
                                                    <a class="dropdown small sm-btn-align"  type="button" :data-toggle="'apApprovedProjects' + projects.id"><img width="15px" height="15px"></a>
                                                    <div class="dropdown-pane dropdown-pane-sm " data-close-on-click="true"  data-hover="true" data-hover-pane="true"  data-position="bottom" data-alignment="right" :id="'apApprovedProjects' + projects.id" data-dropdown data-auto-focus="true">
                                                        <ul class="my-menu small-font text-right">
                                                            <li><a v-on:click.prevent="approvedProjectsUpdateDialog(projects , plans.id)"><i class="fi-pencil size-16"></i>  ویرایش</a></li>
                                                            <li><a v-on:click.prevent="openDeleteApprovedProjectsConfirm(projects)"><i class="fi-trash size-16"></i>  حذف</a></li>
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
            </div>
            <notifications group="capital_assetsPm"
                           position="bottom right"
                           animation-type="velocity"
                           :speed="700" />
        </div>
    </div>
    <!--Form Start-->
    <!--Modal Insert End-->
    <!-- use the modal component, pass in the prop -->
    <modal-small v-if="showModal" @close="showModal = false" xmlns:v-on="http://www.w3.org/1999/xhtml">
        <div  slot="body">
            {!! Form::open(array('v-on:submit.prevent' => 'createApprovedProjects')) !!}
            {!! csrf_field() !!}
            <div class="grid-x" v-if="errorMessage">
                <div class="medium-12 columns padding-lr">
                    <div class="alert callout">
                        <p class="BYekan login-alert"><i class="fi-alert"></i>@{{ errorMessage }}</p>
                    </div>
                </div>
            </div>
            <div class="grid-x">
                <div class="medium-12 cell padding-lr">
                    <label>طرح
                        <select  class="form-element-margin-btm"  v-model="approvedProjectsInput.apPlan" name="plan" v-validate data-vv-rules="required" :class="{'input': true, 'select-error': errors.has('plan')}">
                            <option value=""></option>
                            <option v-for="approvedPlan in approvedPlans" :value="approvedPlan.id">@{{ approvedPlan.credit_distribution_title.cdtIdNumber + ' - ' + approvedPlan.credit_distribution_title.cdtSubject }}</option>
                        </select>
                        <span v-show="errors.has('plan')" class="error-font">لطفا طرح را انتخاب کنید!</span>
                    </label>
                </div>
            </div>
            <div class="grid-x">
                <div class="medium-8 cell padding-lr">
                    <label>عنوان پروژه
                        <input class="form-element-margin-btm" type="text" name="projectTitle" v-model="approvedProjectsInput.apProjectTitle" v-validate="'required'" :class="{'input': true, 'error-border': errors.has('projectTitle')}">
                    </label>
                    <span v-show="errors.has('projectTitle')" class="error-font">لطفا عنوان پروژه انتخاب کنید!</span>
                </div>
                <div class="medium-4 cell padding-lr">
                    <label>کد پروژه
                        <input class="form-element-margin-btm" type="text" name="projectCode" v-model="approvedProjectsInput.apProjectCode" v-validate="'required|numeric'" :class="{'input': true, 'error-border': errors.has('projectCode')}">
                    </label>
                    <span v-show="errors.has('projectTitle')" class="error-font">لطفا کد پروژه انتخاب کنید!</span>
                </div>
            </div>
            <div class="grid-x">
                <div class="medium-4 cell padding-lr">
                    <label>سال شروع
                        <input class="form-element-margin-btm" type="text" name="startYear" v-model="approvedProjectsInput.apStartYear" v-validate="'required'" :class="{'input': true, 'error-border': errors.has('startYear')}">
                    </label>
                    <span v-show="errors.has('startYear')" class="error-font">لطفا سال شروع پروژه را وارد کنید!</span>
                </div>
                <div class="medium-4 cell padding-lr">
                    <label>سال خاتمه
                        <input class="form-element-margin-btm" type="text" name="endYear" v-model="approvedProjectsInput.apEndYear" v-validate="'required|numeric'" :class="{'input': true, 'error-border': errors.has('endYear')}">
                    </label>
                    <span v-show="errors.has('endYear')" class="error-font">لطفا سال خاتمه پروژه را وارد کنید!</span>
                </div>
                <div class="medium-4 cell padding-lr">
                    <label>نحوه اجرا
                        <select class="form-element-margin-btm" v-model="approvedProjectsInput.apHowToRun" name="howToRun" v-validate data-vv-rules="required" :class="{'input': true, 'select-error': errors.has('howToRun')}">
                            <option value=""></option>
                            <option v-for="howToRun in howToRuns" :value="howToRun.id">@{{ howToRun.htrSubject }}</option>
                        </select>
                        <span v-show="errors.has('howToRun')" class="error-font">لطفا نحوه اجرا را انتخاب کنید!</span>
                    </label>
                </div>
                <div class="medium-4 cell padding-lr">
                    <label> پیشرفت فیزیکی<span class="btn-red small-font"> (درصد) </span>
                        <input  type="number" min="0" max="100" value="0" name="physicalProgress" v-model="approvedProjectsInput.apPhysicalProgress" v-validate="'required|numeric'" :class="{'input': true, 'error-border': errors.has('physicalProgress')}">
                        <div style="margin-top: -16px;height:2px;" class="alert progress form-element-margin-btm">
                            <div class="progress-meter" style="width: 75%"></div>
                        </div>
                    </label>
                    <span v-show="errors.has('physicalProgress')" class="error-font">لطفا پیشرفت فیزیکی را وارد کنید!</span>
                </div>
                <div class="medium-4 cell padding-lr">
                    <label>شهرستان
                        <select class="form-element-margin-btm" v-model="approvedProjectsInput.apCity" name="city" v-validate data-vv-rules="required" :class="{'input': true, 'select-error': errors.has('city')}">
                            <option value=""></option>
                            <option v-for="county in counties" :value="county.id">@{{ county.coName }}</option>
                        </select>
                        <span v-show="errors.has('city')" class="error-font">لطفا شهرستان را انتخاب کنید!</span>
                    </label>
                </div>
            </div>
            <div class="grid-x">
                <div class="medium-4 column padding-lr">
                    <label>فصل
                        <select class="form-element-margin-btm" v-model="selectedSeasons" v-on:change="getTinySeasons" name="season" v-validate data-vv-rules="required" :class="{'input': true, 'select-error': errors.has('season')}">
                            <option value=""></option>
                            <option v-for="season in seasons" :value="season.id">@{{ season.sSubject }}</option>
                        </select>
                        <span v-show="errors.has('season')" class="error-font">لطفا فصل را انتخاب کنید!</span>
                    </label>
                </div>
                <div class="medium-8 column padding-lr">
                    <label>ریز فصل
                        <select class="form-element-margin-btm" v-model="approvedProjectsInput.apSubSeason" name="subSeason" v-validate data-vv-rules="required" :class="{'input': true, 'select-error': errors.has('subSeason')}">
                            <option value=""></option>
                            <option v-for="tinySeason in tinySeasons" :value="tinySeason.id">@{{ tinySeason.tsSubject }}</option>
                        </select>
                        <span v-show="errors.has('subSeason')" class="error-font">لطفا ریز فصل را انتخاب کنید!</span>
                    </label>
                </div>
            </div>
            <div v-for="creditDistributionRow in creditDistributionRows" style="margin-top: 20px;" class="grid-x">
                <div class="medium-4 columns padding-lr">
                    <p style="margin-top:5px;">@{{ creditDistributionRow.cdSubject }}</p>
                </div>
                <div  class="medium-4 columns padding-lr">
                    <label>
                        <input class="form-element-margin-btm" type="text" :name="'apCdr' + creditDistributionRow.id" v-model="creditDistributionRowInput['apCdr' + creditDistributionRow.id]" v-validate="'required|numeric'" :class="{'input': true, 'error-border': errors.has('apCdr' + creditDistributionRow.id)}">
                    </label>
                    <span v-show="errors.has('apCdr' + creditDistributionRow.id)" class="error-font">لطفا مبلغ اعتبار را وارد کنید (حداقل ۰)!</span>
                </div>
            </div>
            <div class="grid-x">
                <div class="small-12 columns padding-lr">
                    <label>شرح
                        <textarea name="apDescription" style="min-height: 150px;" v-model="approvedProjectsInput.apDescription"></textarea>
                    </label>
                </div>
            </div>
            <div class="medium-6 columns padding-lr padding-bottom-modal">
                <button name="Submit" class="my-secondary button float-left btn-for-load"> <span class="btn-txt-mrg">ثبت</span>
                    <i id="registerSubmitActivityCircle">
                        <div class="la-line-spin-clockwise-fade-rotating la-sm float-left">
                            <div></div>
                            <div></div>
                            <div></div>
                            <div></div>
                            <div></div>
                            <div></div>
                            <div></div>
                            <div></div>
                        </div>
                    </i>
                </button>
            </div>
            {!! Form::close() !!}
        </div>
    </modal-small>
    <!-- update modal -->
    <modal-small v-if="showModalUpdate" @close="showModalUpdate = false" xmlns:v-on="http://www.w3.org/1999/xhtml">
        <div  slot="body">
            {!! Form::open(array('v-on:submit.prevent' => 'updateApprovedProjects')) !!}
            {!! csrf_field() !!}
            <div class="grid-x" v-if="errorMessage">
                <div class="medium-12 columns padding-lr">
                    <div class="alert callout">
                        <p class="BYekan login-alert"><i class="fi-alert"></i>@{{ errorMessage }}</p>
                    </div>
                </div>
            </div>
            <div class="grid-x">
                <div class="medium-12 cell padding-lr">
                    <label>طرح
                        <select class="form-element-margin-btm"  v-model="approvedProjectsFill.apPlan" name="plan" v-validate data-vv-rules="required" :class="{'input': true, 'select-error': errors.has('plan')}">
                            <option value=""></option>
                            <option v-for="approvedPlan in approvedPlans" :value="approvedPlan.id">@{{ approvedPlan.credit_distribution_title.cdtIdNumber + ' - ' + approvedPlan.credit_distribution_title.cdtSubject }}</option>
                        </select>
                        <span v-show="errors.has('plan')" class="error-font">لطفا طرح را انتخاب کنید!</span>
                    </label>
                </div>
            </div>
            <div class="grid-x">
                <div class="medium-8 cell padding-lr">
                    <label>عنوان پروژه
                        <input class="form-element-margin-btm" type="text" name="projectTitle" v-model="approvedProjectsFill.apProjectTitle" v-validate="'required'" :class="{'input': true, 'error-border': errors.has('projectTitle')}">
                    </label>
                    <span v-show="errors.has('projectTitle')" class="error-font">لطفا عنوان پروژه انتخاب کنید!</span>
                </div>
                <div class="medium-4 cell padding-lr">
                    <label>کد پروژه
                        <input class="form-element-margin-btm" type="text" name="projectCode" v-model="approvedProjectsFill.apProjectCode" v-validate="'required|numeric'" :class="{'input': true, 'error-border': errors.has('projectCode')}">
                    </label>
                    <span v-show="errors.has('projectTitle')" class="error-font">لطفا کد پروژه انتخاب کنید!</span>
                </div>
            </div>
            <div class="grid-x">
                <div class="medium-4 cell padding-lr">
                    <label>سال شروع
                        <input class="form-element-margin-btm" type="text" name="startYear" v-model="approvedProjectsFill.apStartYear" v-validate="'required'" :class="{'input': true, 'error-border': errors.has('startYear')}">
                    </label>
                    <span v-show="errors.has('startYear')" class="error-font">لطفا سال شروع پروژه را وارد کنید!</span>
                </div>
                <div class="medium-4 cell padding-lr">
                    <label>سال خاتمه
                        <input class="form-element-margin-btm" type="text" name="endYear" v-model="approvedProjectsFill.apEndYear" v-validate="'required|numeric'" :class="{'input': true, 'error-border': errors.has('endYear')}">
                    </label>
                    <span v-show="errors.has('endYear')" class="error-font">لطفا سال خاتمه پروژه را وارد کنید!</span>
                </div>
                <div class="medium-4 cell padding-lr">
                    <label>نحوه اجرا
                        <select class="form-element-margin-btm" v-model="approvedProjectsFill.apHowToRun" name="howToRun" v-validate data-vv-rules="required" :class="{'input': true, 'select-error': errors.has('howToRun')}">
                            <option value=""></option>
                            <option v-for="howToRun in howToRuns" :value="howToRun.id">@{{ howToRun.htrSubject }}</option>
                        </select>
                        <span v-show="errors.has('howToRun')" class="error-font">لطفا نحوه اجرا را انتخاب کنید!</span>
                    </label>
                </div>
                <div class="medium-4 cell padding-lr">
                    <label> پیشرفت فیزیکی<span class="btn-red small-font"> (درصد) </span>
                        <input  type="number" min="0" max="100" value="0"  name="physicalProgress" v-model="approvedProjectsFill.apPhysicalProgress" v-validate="'required|numeric'" :class="{'input': true, 'error-border': errors.has('physicalProgress')}">
                    </label>
                    <span v-show="errors.has('physicalProgress')" class="error-font">لطفا پیشرفت فیزیکی را وارد کنید!</span>
                </div>
                <div class="medium-4 cell padding-lr">
                    <label>شهرستان
                        <select class="form-element-margin-btm" v-model="approvedProjectsFill.apCity" name="city" v-validate data-vv-rules="required" :class="{'input': true, 'select-error': errors.has('city')}">
                            <option value=""></option>
                            <option v-for="county in counties" :value="county.id">@{{ county.coName }}</option>
                        </select>
                        <span v-show="errors.has('city')" class="error-font">لطفا شهرستان را انتخاب کنید!</span>
                    </label>
                </div>
            </div>
            <div class="grid-x">
                <div class="medium-4 column padding-lr">
                    <label>فصل
                        <select class="form-element-margin-btm" v-model="selectedSeasons" v-on:change="getTinySeasons" name="season" v-validate data-vv-rules="required" :class="{'input': true, 'select-error': errors.has('season')}">
                            <option value=""></option>
                            <option v-for="season in seasons" :value="season.id">@{{ season.sSubject }}</option>
                        </select>
                        <span v-show="errors.has('season')" class="error-font">لطفا فصل را انتخاب کنید!</span>
                    </label>
                </div>
                <div class="medium-8 column padding-lr">
                    <label>ریز فصل
                        <select class="form-element-margin-btm" v-model="approvedProjectsFill.apSubSeason" name="subSeason" v-validate data-vv-rules="required" :class="{'input': true, 'select-error': errors.has('subSeason')}">
                            <option value=""></option>
                            <option v-for="tinySeason in tinySeasons" :value="tinySeason.id">@{{ tinySeason.tsSubject }}</option>
                        </select>
                        <span v-show="errors.has('subSeason')" class="error-font">لطفا ریز فصل را انتخاب کنید!</span>
                    </label>
                </div>
            </div>
            <div v-for="creditDistributionRow in creditDistributionRows" style="margin-top: 20px;" class="grid-x">
                <div class="medium-4 columns padding-lr">
                    <p style="margin-top:5px;">@{{ creditDistributionRow.cdSubject }}</p>
                </div>
                <div  class="medium-4 columns padding-lr">
                    <label>
                        <input class="form-element-margin-btm" type="text" :name="'apCdr' + creditDistributionRow.id" v-model="creditDistributionRowInput['apCdr' + creditDistributionRow.id]" v-validate="'required|numeric'" :class="{'input': true, 'error-border': errors.has('apCdr' + creditDistributionRow.id)}">
                    </label>
                    <span v-show="errors.has('apCdr' + creditDistributionRow.id)" class="error-font">لطفا مبلغ اعتبار را وارد کنید (حداقل ۰)!</span>
                </div>
            </div>
            <div class="grid-x">
                <div class="small-12 columns padding-lr">
                    <label>شرح
                        <textarea name="apDescription" style="min-height: 150px;" v-model="approvedProjectsFill.apDescription"></textarea>
                    </label>
                </div>
            </div>
            <div class="medium-6 columns padding-lr padding-bottom-modal">
                <button name="Submit" class="my-secondary button float-left btn-for-load"> <span class="btn-txt-mrg">ثبت</span>
                    <i id="registerSubmitActivityCircle">
                        <div class="la-line-spin-clockwise-fade-rotating la-sm float-left">
                            <div></div>
                            <div></div>
                            <div></div>
                            <div></div>
                            <div></div>
                            <div></div>
                            <div></div>
                            <div></div>
                        </div>
                    </i>
                </button>
            </div>
            {!! Form::close() !!}
        </div>
    </modal-small>
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


    <!--Form End-->
</template>

<script>
    import VuePagination from '../../../public_component/pagination.vue';
    var approvedProjects = new Vue({
        el: '#approvedProjects',
        data: {
            errorMessage: '',
            errorMessage_update: '',
            approvedProjects: [],
            approvedProjectsInput: {apPlan: '' , apProjectTitle: '' , apProjectCode: '' , apStartYear: '', apEndYear: '',
                apHowToRun: '', apPhysicalProgress: '', apCity: '', apSubSeason: ''
                , apDescription: ''},
            showModal: false,
            showModalUpdate: false,
            showModalDelete: false,
            approvedProjectsFill: {apPlan: '' , apProjectTitle: '' , apProjectCode: '' , apStartYear: '', apEndYear: '',
                apHowToRun: '', apPhysicalProgress: '', aCity: '', apSubSeason: ''
                , apLocation: '', apDescription: '',apCredit:''},
            apIdDelete: {},
            approvedPlans: {},
            counties: {},
            seasons: {},
            tinySeasons: {},
            selectedSeasons: '',
            creditDistributionRows: {},
            creditDistributionRowInput: {}
        },

        created: function () {
            this.fetchData();
            this.getAllApprovedPlan(0); // 0 = provincial
            this.getHowToRun();
            this.getCounties();
            this.getSeasons();
            this.getCreditDistributionRow();
        },

        updated: function () {
            $(this.$el).foundation(); //WORKS!
        },

        methods:{
            fetchData: function () {
                axios.get('/budget/project/capital_assets/projects/fetchData' , {})
                    .then((response) => {
                        this.approvedProjects = response.data;
                        console.log(response);
                    },(error) => {
                        console.log(error);
                    });
            },

            getAllApprovedPlan: function (pOrN) {
                axios.get('/budget/plan/capital_assets/plans/getAllItems' , {params:{pOrN: 0}})
                    .then((response) => {
                        this.approvedPlans = response.data;
                        console.log(response);
                    },(error) => {
                        console.log(error);
                    });
            },

            getHowToRun: function () {
                axios.get('/budget/admin/how_to_run/getAllItems' , {params:{}})
                    .then((response) => {
                        this.howToRuns = response.data;
                        console.log(response);
                    },(error) => {
                        console.log(error);
                    });
            },

            getHowToRun: function () {
                axios.get('/budget/admin/how_to_run/getAllItems' , {params:{}})
                    .then((response) => {
                        this.howToRuns = response.data;
                        console.log(response);
                    },(error) => {
                        console.log(error);
                    });
            },

            getCounties: function () {
                axios.get('/admin/get_all_counties' , {params:{}})
                    .then((response) => {
                        this.counties = response.data;
                        console.log(response);
                    },(error) => {
                        console.log(error);
                    });
            },

            getSeasons: function () {
                axios.get('/admin/get_all_seasons' , {params:{}})
                    .then((response) => {
                        this.seasons = response.data;
                        console.log(response);
                    },(error) => {
                        console.log(error);
                    });
            },

            getTinySeasons: function () {
                axios.get('/budget/admin/sub_seasons/get_tiny_seasons_whit_season_id' , {params:{sId: this.selectedSeasons , planOrCost: 0}})
                    .then((response) => {
                        this.tinySeasons = response.data;
                        console.log(response);
                    },(error) => {
                        console.log(error);
                    });
            },

            getCreditDistributionRow: function () {
                axios.get('/budget/admin/credit_distribution_def/rows/getAllItems' , {params:{planOrCost: 0}})
                    .then((response) => {
                        this.creditDistributionRows = response.data;
                        console.log(response);
                    },(error) => {
                        console.log(error);
                    });
            },

            createApprovedProjects: function () {
                this.$validator.validateAll().then((result) => {
                    if (result) {
                        axios.post('/budget/project/capital_assets/projects/register' , {pInput: this.approvedProjectsInput , cdrInput: this.creditDistributionRowInput})
                            .then((response) => {
                                this.approvedProjects = response.data;
                                this.showModal = false;
                                this.$notify({group: 'capital_assetsPm', title: 'پیام سیستم', text: 'رکورد با موفقیت ثبت شد.' , type: 'success'});
                                console.log(response);
                            },(error) => {
                                console.log(error);
                                //this.errorMessage = 'ریز فصل با این مشخصات قبلا ثبت شده است!';
                            });
                    }
                });

                /*            this.creditDistributionRows.forEach(cdr => {
                                "use strict";
                                this.$set(this.creditDistributionRowInput , 'apCdr' + cdr.id);
                            });*/

            },

            getProjectAmount: function (cdrCp) {
                var sum = 0;
                cdrCp.forEach(cdr => {
                    "use strict";
                    sum += cdr.ccAmount;
                });
                return sum;
            },

            approvedProjectsUpdateDialog: function (item , planId) {
                this.selectedSeasons = item.tiny_season.tsSId;
                this.getTinySeasons();
                this.approvedProjectsFill.apSubSeason = item.cpTsId;
                this.approvedProjectsFill.apPlan = planId;
                this.approvedProjectsFill.apProjectTitle = item.cpSubject;
                this.approvedProjectsFill.apProjectCode = item.cpCode;
                this.approvedProjectsFill.apStartYear = item.cpStartYear;
                this.approvedProjectsFill.apEndYear = item.cpEndOfYear;
                this.approvedProjectsFill.apHowToRun = item.cpHtrId;
                this.approvedProjectsFill.apPhysicalProgress = item.cpPhysicalProgress;
                this.approvedProjectsFill.apCity = item.cpCoId;
                this.approvedProjectsFill.apDescription = item.cpDescription;
                this.creditDistributionRows.forEach(cdr => {
                    "use strict";
                    Vue.set(this.creditDistributionRowInput , 'apCdr' + cdr.id , cdr.id);
                });
                this.errorMessage_update = '';
                this.showModalUpdate = true;
            },

            updateApprovedProjects: function () {
                if (this.approvedProjectsFill.apPlan != '' && this.approvedProjectsFill.apProjectTitle != '' && this.approvedProjectsFill.apProjectCode != '' && this.approvedProjectsFill.apStartYear != '' && this.approvedProjectsFill.apEndYear != ''&& this.approvedProjectsFill.apHowToRun != ''&& this.approvedProjectsFill.apPhysicalProgress != ''&& this.approvedProjectsFill.apCity != ''&& this.approvedProjectsFill.apSeason!= ''&& this.approvedProjectsFill.apSubSeason != '')
                {
                    /*axios.post('/budget/admin/sub_seasons/update' , this.tinySeasonsFill)
                        .then((response) => {
                            if(this.planOrCost == 1)
                                this.tinySeasonsCost = response.data;
                            else
                                this.tinySeasons = response.data;
                            this.showModalUpdate = false;
                            this.$notify({group: 'tinySeasonPm', title: 'پیام سیستم', text: 'بروزرسانی با موفقیت انجام شد.' , type: 'success'});
                            console.log(response);
                        },(error) => {
                            console.log(error);
                            this.errorMessage_update = 'ریز فصل با این مشخصات قبلا ثبت شده است!';
                        });*/
                    alert('ویرایش انجام شد');
                }
                else {
                    this.errorMessage_update = ' لطفا در وارد کردن اطلاعات دقت کنید!';
                }
            },

            openDeleteApprovedProjectsConfirm: function (ap) {
                this.apIdDelete = ap;
                this.showModalDelete = true;
            },

            deleteApprovedProjects: function () {
                /*axios.post('/budget/admin/sub_seasons/delete' , this.tsIdDelete)
                    .then((response) => {
                        if(response.data.tsPlanOrCost == 1)
                            this.tinySeasonsCost = response.data;
                        else
                            this.tinySeasons = response.data;
                        this.showModalDelete = false;
                        this.$notify({group: 'tinySeasonPm', title: 'پیام سیستم', text: 'حذف رکورد با موفقیت انجام شد.' , type: 'success'});
                        console.log(response);
                    },(error) => {
                        console.log(error);
                        this.$notify({group: 'tinySeasonPm', title: 'پیام سیستم', text: 'با توجه به وابستگی رکورد ها، حذف رکورد امکان پذیر نیست.' , type: 'error'});
                    });*/
            }
        }
    });

</script>
