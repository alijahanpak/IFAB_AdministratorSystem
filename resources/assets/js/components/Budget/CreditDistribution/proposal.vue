<template xmlns:v-on="http://www.w3.org/1999/xhtml" xmlns:v-bind="http://www.w3.org/1999/xhtml">
    <!--Inner body start-->
    <div class="medium-10 border-right-line inner-body-pad main-margin">
        <div class="grid-x padding-lr breadcrumbs-pos">
            <div class="medium-12">
                <div class="grid-x">
                    <nav aria-label="You are here:" role="navigation">
                        <ul class="breadcrumbs">
                            <li><router-link to="/budget">داشبورد</router-link></li>
                            <li>
                                <a class="disabled">توزیع اعتبار</a>
                            </li>
                            <li>
                                <a class="disabled">تملک دارایی های سرمایه ای</a>
                            </li>
                            <li>
                                <a class="disabled">استانی</a>
                            </li>
                            <li>
                                <span class="show-for-sr">Current: </span> پیشنهاد بودجه
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
                </div>
                <div  class="medium-12 column padding-lr table-mrg-top">
                    <div class="tbl-div-container">
                        <table class="tbl-head">
                            <colgroup>
                                <col width="100px"/>
                                <col width="150px"/>
                                <col width="150px"/>
                                <col width="150px"/>
                                <col width="100px"/>
                                <col width="200px"/>
                                <col width="12px"/>
                            </colgroup>
                            <tbody class="tbl-head-style">
                            <tr class="tbl-head-style-cell">
                                <th class="tbl-head-style-cell">شهرستان</th>
                                <th class="tbl-head-style-cell">طرح</th>
                                <th class="tbl-head-style-cell">کد پروژه</th>
                                <th class="tbl-head-style-cell">عنوان</th>
                                <th class="tbl-head-style-cell">اعتبار</th>
                                <th class="tbl-head-style-cell">شرح</th>
                                <th class="tbl-head-style-cell"></th>
                            </tr>
                            </tbody>
                        </table>

                        <div class="tbl_body_style dynamic-height-level2">
                            <table class="tbl-body-contain">
                                <colgroup>
                                    <col width="100px"/>
                                    <col width="150px"/>
                                    <col width="150px"/>
                                    <col width="150px"/>
                                    <col width="100px"/>
                                    <col width="200px"/>
                                </colgroup>
                                <tbody class="tbl-head-style-cell">
                                <template v-for="county in proposals">
                                    <tr class="tbl-head-style-cell">
                                        <td :rowspan="getPlanProposalCount(county.credit_distribution_plan_has_proposal)">{{ county.coName }}</td>
                                        <td :rowspan="county.credit_distribution_plan_has_proposal[0].proposal.length">{{ county.credit_distribution_plan_has_proposal[0].credit_distribution_title.cdtIdNumber + ' - ' + county.credit_distribution_plan_has_proposal[0].credit_distribution_title.cdtSubject }}</td>
                                        <td>{{ county.credit_distribution_plan_has_proposal[0].proposal[0].pbpCode  }}</td>
                                        <td>{{ county.credit_distribution_plan_has_proposal[0].proposal[0].pbpSubject }}</td>
                                        <td>{{ $parent.calcDispAmount(county.credit_distribution_plan_has_proposal[0].proposal[0].pbpAmount , false)  }}</td>
                                        <td>
                                            <div class="grid-x">
                                                <div class="medium-11 text-justify">
                                                    {{ county.credit_distribution_plan_has_proposal[0].proposal[0].pbpDescription }}
                                                </div>
                                                <div class="medium-1 cell-vertical-center text-left">
                                                    <a class="dropdown small sm-btn-align"  type="button" :data-toggle="'pProposal' + county.id"><i class="fa fa-ellipsis-v size-18"></i></a>
                                                    <div class="dropdown-pane dropdown-pane-sm " data-close-on-click="true"  data-hover="true" data-hover-pane="true"  data-position="bottom" data-alignment="right" :id="'pProposal' + county.id" data-dropdown data-auto-focus="true">
                                                        <ul class="my-menu small-font text-right">
                                                            <li><a v-on:click.prevent=""><i class="fa fa-pencil-square-o size-16"></i>  ویرایش</a></li>
                                                            <li><a v-on:click.prevent=""><i class="fa fa-trash-o size-16"></i>  حذف</a></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <template v-for="(plan , pIndex) in county.credit_distribution_plan_has_proposal">
                                        <tr class="tbl-head-style-cell" v-if="pIndex > 0">
                                            <td :rowspan="plan.proposal.length">{{ plan.credit_distribution_title.cdtIdNumber + ' - ' + plan.credit_distribution_title.cdtSubject }}</td>
                                            <td>{{ plan.proposal[0].pbpCode  }}</td>
                                            <td>{{ plan.proposal[0].pbpSubject }}</td>
                                            <td>{{ $parent.calcDispAmount(plan.proposal[0].pbpAmount , false)  }}</td>
                                            <td>
                                                <div class="grid-x">
                                                    <div class="medium-11 text-justify">
                                                        {{ plan.proposal[0].pbpDescription }}
                                                    </div>
                                                    <div class="medium-1 cell-vertical-center text-left">
                                                        <a class="dropdown small sm-btn-align"  type="button" :data-toggle="'ppProposal' + county.id + plan.id"><i class="fa fa-ellipsis-v size-18"></i></a>
                                                        <div class="dropdown-pane dropdown-pane-sm " data-close-on-click="true"  data-hover="true" data-hover-pane="true"  data-position="bottom" data-alignment="right" :id="'ppProposal' + county.id + plan.id" data-dropdown data-auto-focus="true">
                                                            <ul class="my-menu small-font text-right">
                                                                <li><a v-on:click.prevent=""><i class="fa fa-pencil-square-o size-16"></i>  ویرایش</a></li>
                                                                <li><a v-on:click.prevent=""><i class="fa fa-trash-o size-16"></i>  حذف</a></li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <template v-for="(proposal , ppIndex) in plan.proposal">
                                            <tr class="tbl-head-style-cell" v-if="ppIndex > 0">
                                                <td>{{ proposal.pbpCode  }}</td>
                                                <td>{{ proposal.pbpSubject }}</td>
                                                <td>{{ $parent.calcDispAmount(proposal.pbpAmount , false)  }}</td>
                                                <td>
                                                    <div class="grid-x">
                                                        <div class="medium-11 text-justify">
                                                            {{ proposal.pbpDescription }}
                                                        </div>
                                                        <div class="medium-1 cell-vertical-center text-left">
                                                            <a class="dropdown small sm-btn-align"  type="button" :data-toggle="'proposal' + county.id + plan.id + proposal.id"><i class="fa fa-ellipsis-v size-18"></i></a>
                                                            <div class="dropdown-pane dropdown-pane-sm " data-close-on-click="true"  data-hover="true" data-hover-pane="true"  data-position="bottom" data-alignment="right" :id="'proposal' + county.id + plan.id + proposal.id" data-dropdown data-auto-focus="true">
                                                                <ul class="my-menu small-font text-right">
                                                                    <li><a v-on:click.prevent=""><i class="fa fa-pencil-square-o size-16"></i>  ویرایش</a></li>
                                                                    <li><a v-on:click.prevent=""><i class="fa fa-trash-o size-16"></i>  حذف</a></li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        </template>
                                    </template>
                                </template>
                                </tbody>
                            </table>
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
                <!--Forms Start-->
                <!--Insert Modal Start-->
                <modal-small v-if="showModal" @close="showModal = false" xmlns:v-on="http://www.w3.org/1999/xhtml">
                    <div  slot="body">
                        <form v-on:submit.prevent="createCdpProposal">
                            <div class="grid-x" v-if="errorMessage">
                                <div class="medium-12 columns padding-lr">
                                    <div class="alert callout">
                                        <p class="BYekan login-alert"><i class="fi-alert"></i>{{ errorMessage }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="grid-x">
                                <div class="medium-4 cell padding-lr">
                                    <label>شهرستان
                                        <select class="form-element-margin-btm" name="pCounty" v-model="selectedCounty" @change="getCDPWithCoId" v-validate data-vv-rules="required" :class="{'input': true, 'select-error': errors.has('pCounty')}">
                                            <option value=""></option>
                                            <option v-for="county in counties" :value="county.id">{{ county.coName }}</option>
                                        </select>
                                        <span v-show="errors.has('pCounty')" class="error-font">شهرستان را انتخاب کنید!</span>
                                    </label>
                                </div>
                                <div class="medium-8 cell padding-lr">
                                    <label>طرح
                                        <select class="form-element-margin-btm" name="planCode" v-model="cdpProposalInput.cdpId" @change="getRemianingAmount" v-validate data-vv-rules="required" :class="{'input': true, 'select-error': errors.has('planCode')}">
                                            <option value=""></option>
                                            <option v-for="cdp in creditDistributionPlans" :value="cdp.id">{{ cdp.credit_distribution_title.cdtIdNumber + ' - ' + cdp.credit_distribution_title.cdtSubject + ' - ' + ' فصل ' + cdp.credit_distribution_title.budget_season.bsSubject + ' - ' + ' ردیف ' + cdp.credit_distribution_row.cdSubject + ' - ' + ' با اعتبار ' + $parent.calcDispAmount(cdp.cdpCredit) }}</option>
                                        </select>
                                    </label>
                                    <span v-show="errors.has('planCode')" class="error-font">کد طرح مورد نظر را انتخاب کنید!</span>
                                </div>
                            </div>
                            <div class="grid-x" style="margin-top: 10px;margin-bottom: 10px" v-show="cdpProposalInput.cdpId != null && cdpProposalInput.cdpId != ''">
                                <div class="medium-12 column padding-lr">
                                    <div class="grid-x my-callout-bg-color">
                                        <div class="medium-2">
                                            <p>اعتبار باقیمانده:</p>
                                        </div>
                                        <div class="medium-10 btn-red">
                                            <strong id="pbpPlanAmount" style="margin-bottom: 0;">{{ remainingAmount }} </strong><span>{{ '(' + $parent.getAmountBaseLabel() + ')' }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="grid-x">
                                <div class="medium-12 columns padding-lr">
                                    <label>عنوان پروژه
                                        <input class="form-element-margin-btm" type="text" name="projectTitle" v-model="cdpProposalInput.pSubject" v-validate data-vv-rules="required" :class="{'input': true, 'select-error': errors.has('projectTitle')}">
                                    </label>
                                    <span v-show="errors.has('projectTitle')" class="error-font">عنوان پروژه فراموش شده است!</span>
                                </div>
                            </div>
                            <div class="grid-x">
                                <div class="medium-6 columns padding-lr">
                                    <label>کد پروژه
                                        <input class="form-element-margin-btm" type="text" name="projectCode" v-model="cdpProposalInput.pCode" v-validate data-vv-rules="required" :class="{'input': true, 'select-error': errors.has('projectCode')}">
                                    </label>
                                    <span v-show="errors.has('projectCode')" class="error-font">کد پروژه فراموش شده است!</span>
                                </div>
                                <div class="medium-6 columns padding-lr">
                                    <label><span>مبلغ اعتبار</span><span style="color: #D9534F;"></span>
                                        <input class="form-element-margin-btm" type="text" name="pAmount" v-model="cdpProposalInput.pAmount" v-validate data-vv-rules="required" :class="{'input': true, 'select-error': errors.has('pAmount')}">
                                    </label>
                                    <span v-show="errors.has('pAmount')" class="error-font">مبلغ اعتبار فراموش شده است!</span>
                                </div>
                            </div>
                            <div class="grid-x">
                                <div class="small-12 columns padding-lr">
                                    <label>شرح
                                        <textarea name="pDescription" style="min-height: 150px;" v-model="cdpProposalInput.pDescription"></textarea>
                                    </label>
                                </div>
                            </div>
                            <div class="medium-6 columns padding-lr padding-bottom-modal">
                                <button name="Submit" class="my-button my-success float-left btn-for-load"> <span class="btn-txt-mrg">ثبت</span></button>
                            </div>
                        </form>
                    </div>
                </modal-small>
                <!--Insert Modal End-->
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
                proposals: [],
                cdpProposalInput: {},
                showModal: false,
                showModalUpdate: false,
                showModalDelete: false,
                creditDistributionPlans: {},
                counties: {},
                selectCounty: '',
                remainingAmount: 0,

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
            $(this.$el).foundation(); //WORKS!
        },

        updated: function () {
            $(this.$el).foundation(); //WORKS!
        },

        mounted: function () {
            console.log("mounted credit distribution plans component");
            this.$parent.myResize();
            $(this.$el).foundation(); //WORKS!
        },

        components:{
            'vue-pagination' : VuePagination
        },

        methods:{
            fetchData: function (page = 1) {
                axios.get('/budget/credit_distribution/capital_assets/provincial/proposal/fetchData?page=' + page)
                    .then((response) => {
                        this.proposals = response.data.data;
                        this.makePagination(response.data);
                        console.log(response);
                    },(error) => {
                        console.log(error);
                    });
            },

            getRemianingAmount: function () {
                if (this.cdpProposalInput.cdpId != '')
                {
                    axios.get('/budget/credit_distribution/capital_assets/provincial/plans/getPlanRemainingAmount' , {params:{cdpId: this.cdpProposalInput.cdpId}})
                        .then((response) => {
                            this.remainingAmount = response.data.remainingAmount;
                            console.log(response);
                        },(error) => {
                            console.log(error);
                        });
                }
                else
                    this.remainingAmount = 0;
            },

            getCDPWithCoId: function () {
                if (this.selectedCounty != '')
                {
                    axios.get('/budget/credit_distribution/capital_assets/provincial/plans/getAllWithCountyId' , {params:{coId: this.selectedCounty}})
                        .then((response) => {
                            this.creditDistributionPlans = response.data;
                            console.log(response);
                        },(error) => {
                            console.log(error);
                        });
                }
                else
                    this.creditDistributionPlans = [];
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

            getPlanProposalCount: function (plans) {
                var count = 0;
                plans.forEach(plan => {
                    count += plan.proposal.length;
                });
                return count;
            },

            openInsertModal: function (type) {
                this.getCounties();
                this.showModal = true;
            },

            createCdpProposal: function () {
                this.$validator.validateAll().then((result) => {
                    if (result) {
                        axios.post('/budget/credit_distribution/capital_assets/provincial/proposal/register' , {
                            cdpId: this.cdpProposalInput.cdpId,
                            pSubject: this.cdpProposalInput.pSubject,
                            pCode: this.cdpProposalInput.pCode,
                            pAmount: this.cdpProposalInput.pAmount,
                            pDescription: this.cdpProposalInput.pDescription
                        })
                            .then((response) => {
                                this.proposals = response.data.data;
                                this.makePagination(response.data);
                                this.showModal = false;
                                this.$parent.displayNotif(response.status);
                                console.log(response);
                            },(error) => {
                                console.log(error);
                                this.errorMessage = 'تخصیص با این مشخصات قبلا ثبت شده است!';
                            });
                    }
                });
            },

            registerOfCreditAllocationAssetsUpdateDialog: function (item) {
                this.registerOfCreditAllocationAssetsFill.rocaPlan = item.rocaPlan;
                this.registerOfCreditAllocationAssetsFill.rocaaProject = item.rocaaProject;
                this.registerOfCreditAllocationAssetsFill.rocaaRow = item.rocaaRow;
                this.registerOfCreditAllocationAssetsFill.roccaCost = item.roccaCost;
                this.registerOfCreditAllocationAssetsFill.rocaaNumber = item.rocaaNumber;
                this.registerOfCreditAllocationAssetsFill.rocaaDate = item.rocaaDate;

                this.errorMessage_update = '';
                this.showModalUpdate = true;
            },

            updateRegisterOfCreditAllocationAssets: function () {

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

            },

            openDeleteRegisterOfCreditAllocationAssetsConfirm: function (rocaa) {
                this.apIdDelete = rocaa;
                this.showModalDelete = true;
            },

            deleteRegisterOfCreditAllocationAssets: function () {
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
            },

            makePagination: function(data){
                this.pagination.current_page = data.current_page;
                this.pagination.to = data.to;
                this.pagination.last_page = data.last_page;
            },
        }
    }
</script>

