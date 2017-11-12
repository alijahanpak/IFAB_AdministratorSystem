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
                                <span class="show-for-sr">Current: </span>    ردیف توزیع اعتبار
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
                                    <a class="my-button toolbox-btn small" @click="openInsertModal">جدید</a>
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
                            <div class="tbl-div-container">
                                <table class="tbl-head">
                                    <colgroup>
                                        <col width="450px"/>
                                        <col width="390px"/>
                                        <col width="12px"/>
                                    </colgroup>
                                    <tbody class="tbl-head-style">
                                    <tr class="tbl-head-style-cell">
                                        <th class="tbl-head-style-cell">عنوان</th>
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
                                            <col width="450px"/>
                                            <col width="390px"/>
                                        </colgroup>
                                        <tbody class="tbl-head-style-cell">
                                        <tr v-for="plan in rowDistributionCredit">
                                            <td>{{ plan.cdSubject }}</td>
                                            <td>
                                                <div class="grid-x">
                                                    <div class="medium-11">
                                                        {{ plan.cdDescription }}
                                                    </div>
                                                    <div class="medium-1 cell-vertical-center text-left">
                                                        <a class="dropdown small sm-btn-align"  type="button" :data-toggle="'rdcRowDistributionCredit' + plan.id"><i class="fa fa-ellipsis-v size-18"></i></a>
                                                        <div class="dropdown-pane dropdown-pane-sm " data-close-on-click="true"  data-hover="true" data-hover-pane="true"  data-position="bottom" data-alignment="right" :id="'rdcRowDistributionCredit' + plan.id" data-dropdown data-auto-focus="true">
                                                            <ul class="my-menu small-font text-right">
                                                                <li><a v-on:click.prevent="rowDistributionCreditUpdateDialog(plan , 1)"><i class="fi-pencil size-16"></i>  ویرایش</a></li>
                                                                <li><a v-on:click.prevent="openDeleteRowDistributionCreditConfirm(plan)"><i class="fi-trash size-16"></i>  حذف</a></li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
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
                        <div class="">
                            <div class="medium-12 bottom-mrg">
                                <div class="clearfix border-btm-line bottom-mrg">
                                    <div style="margin-top: 2px;" class="button-group float-right report-mrg">
                                        <a class="my-button toolbox-btn small" @click="planOrCostRequestType = 1; showModal = true; errorMessage = ''">جدید</a>
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
                                <div class="tbl-div-container">
                                    <table class="tbl-head">
                                        <colgroup>
                                            <col width="450px"/>
                                            <col width="390px"/>
                                            <col width="12px"/>
                                        </colgroup>
                                        <tbody class="tbl-head-style">
                                        <tr class="tbl-head-style-cell">
                                            <th class="tbl-head-style-cell">عنوان</th>
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
                                                <col width="450px"/>
                                                <col width="390px"/>
                                            </colgroup>
                                            <tbody class="tbl-head-style-cell">
                                            <tr v-for="cost in rowDistributionCredit_cost">
                                                <td>{{ cost.cdSubject }}</td>
                                                <td>
                                                    <div class="grid-x">
                                                        <div class="medium-11">
                                                            {{ cost.cdDescription }}
                                                        </div>
                                                        <div class="medium-1 cell-vertical-center text-left">
                                                            <a class="dropdown small sm-btn-align"  type="button" :data-toggle="'rdcRowDistributionCredit_cost' + cost.id"><i class="fa fa-ellipsis-v size-18"></i></a>
                                                            <div class="dropdown-pane dropdown-pane-sm " data-close-on-click="true"  data-hover="true" data-hover-pane="true"  data-position="bottom" data-alignment="right" :id="'rdcRowDistributionCredit_cost' + cost.id" data-dropdown data-auto-focus="true">
                                                                <ul class="my-menu small-font text-right">
                                                                    <li><a v-on:click.prevent="rowDistributionCreditUpdateDialog(cost , 1)"><i class="fi-pencil size-16"></i>  ویرایش</a></li>
                                                                    <li><a v-on:click.prevent="openDeleteRowDistributionCreditConfirm(cost)"><i class="fi-trash size-16"></i>  حذف</a></li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
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
                        </div>
                    </div>
                    <!--Tab 2-->
                </div>
                <modal-tiny v-if="showInsertModal" @close="showInsertModal = false">
                    <div  slot="body">
                        <form v-on:submit.prevent="createRowDistributionCredit">
                            <div class="grid-x" v-if="errorMessage">
                                <div class="medium-12 columns padding-lr">
                                    <div class="alert callout">
                                        <p class="BYekan login-alert"><i class="fi-alert"></i>@{{ errorMessage }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="grid-x">
                                <div class="medium-12 columns padding-lr">
                                    <label>عنوان
                                        <input type="text" name="rdcSubject" v-model="rowDistributionCreditInput.rdcSubject">
                                    </label>
                                </div>
                            </div>
                            <div class="grid-x">
                                <div class="small-12 columns padding-lr">
                                    <label>شرح
                                        <textarea name="rdcDescription" style="min-height: 150px;" v-model="rowDistributionCreditInput.rdcDescription"></textarea>
                                    </label>
                                </div>
                            </div>
                            <div class="medium-6 columns padding-lr padding-bottom-modal">
                                <button name="Submit" class="my-secondary button float-left btn-for-load"> <span class="btn-txt-mrg">ثبت</span></button>
                            </div>
                        </form>
                    </div>
                </modal-tiny>
                <!-- update modal -->
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
                errorMessage: '',
                errorMessage_update: '',
                rowDistributionCredit: [],
                rowDistributionCredit_cost: [],
                rowDistributionCreditInput: {rdcSubject: '' , rdcDescription: ''},
                showInsertModal: false,
                showModalUpdate: false,
                showModalDelete: false,
                rowDistributionCreditFill: {rdcSubject: '' , rdcDescription: '', id: ''},
                rdcIdDelete: {},
                planOrCostRequestType: 0,
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
                axios.get('/budget/admin/credit_distribution_def/rows/fetchData?page=' + page , {params:{planOrCost: 0}})
                    .then((response) => {
                        this.rowDistributionCredit = response.data.data;
                        this.makePagination(response.data , "plan");
                        console.log(response.data);
                    },(error) => {
                        console.log(error);
                    });
            },

            fetchCostData: function (page = 1) {
                axios.get('/budget/admin/credit_distribution_def/rows/fetchData?page=' + page , {params:{planOrCost: 1}})
                    .then((response) => {
                        this.rowDistributionCredit_cost = response.data.data;
                        this.makePagination(response.data , "cost");
                        console.log(response.data);
                    },(error) => {
                        console.log(error);
                    });
            },

            createRowDistributionCredit: function () {
                axios.post('/budget/admin/credit_distribution_def/rows/register' , {
                    subject: this.rowDistributionCreditInput.rdcSubject,
                    description: this.rowDistributionCreditInput.rdcDescription,
                    planOrCost: this.planOrCostRequestType})
                    .then((response) => {
                    if (this.planOrCostRequestType == 0)
                    {
                        this.rowDistributionCredit = response.data.data;
                        this.makePagination(response.data , "plan");
                    }
                    else if(this.planOrCostRequestType == 1){
                        this.rowDistributionCredit_cost = response.data.data;
                        this.makePagination(response.data , "cost");
                    }

                    this.showInsertModal = false;
                    this.$parent.displayNotif(response.status);
                    this.rowDistributionCreditInput = [];
                    console.log(response.status);
                    },(error) => {
                        console.log(error);
                        this.errorMessage = 'ردیف توزیع اعتبار با این مشخصات قبلا ثبت شده است!';
                    });
            },

            rowDistributionCreditUpdateDialog: function (item , type) {
                this.rowDistributionCreditFill.rdcSubject = item.cdSubject;
                this.rowDistributionCreditFill.rdcDescription = item.cdDescription;
                this.rowDistributionCreditFill.id = item.id;
                this.rowDistributionCreditFill.planOrCost = type;
                this.errorMessage_update = '';
                this.showModalUpdate = true;
            },

            updateRowDistributionCredit: function () {
                if (this.rowDistributionCreditFill.rdcSubject != '')
                {
                    axios.post('/budget/admin/row_distribution_credit/update' , this.rowDistributionCreditFill)
                        .then((response) => {
                            this.rowDistributionCredit = response.data;
                            this.showModalUpdate = false;
                            this.$notify({group: 'rowDistributionCreditPm', title: 'پیام سیستم', text: 'بروزرسانی با موفقیت انجام شد.' , type: 'success'});
                            console.log(response);
                        },(error) => {
                            console.log(error);
                            this.errorMessage_update = 'ردیف توزیع اعتبار با این مشخصات قبلا ثبت شده است!';
                        });
                }
                else {
                    this.errorMessage_update = ' لطفا در وارد کردن اطلاعات دقت کنید!';
                }
            },

            openDeleteRowDistributionCreditConfirm: function (rdc) {
                this.rdcIdDelete = rdc;
                this.showModalDelete = true;
            },

            openInsertModal: function () {
                this.planOrCostRequestType = 0;
                this.showInsertModal = true;
                this.errorMessage = '';
            },

            deleteRowDistributionCredit: function () {
                axios.post('/budget/admin/row_distribution_credit/delete' , this.rdcIdDelete)
                    .then((response) => {
                        this.tinySeasons = response.data;
                        this.showModalDelete = false;
                        this.$notify({group: 'rowDistributionCreditPm', title: 'پیام سیستم', text: 'حذف رکورد با موفقیت انجام شد.' , type: 'success'});
                        console.log(response);
                    },(error) => {
                        console.log(error);
                        this.$notify({group: 'rowDistributionCreditPm', title: 'پیام سیستم', text: 'با توجه به وابستگی رکورد ها، حذف رکورد امکان پذیر نیست.' , type: 'error'});
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
        }
    }
</script>
