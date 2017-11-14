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
                                <div style="margin-top: 2px;" class="button-group float-right">
                                    <a class="my-button toolbox-btn small" @click="openInsertModal(0)">جدید</a>
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
                                                                <li><a v-on:click.prevent="openUpdateCreditDistributionRow(plan , 0)"><i class="fi-pencil size-16"></i>  ویرایش</a></li>
                                                                <li><a v-on:click.prevent="openDeleteRowDistributionCreditConfirm(plan.id , 0)"><i class="fi-trash size-16"></i>  حذف</a></li>
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
                        </div>
                    </div>
                    <!--Tab 1-->
                    <!--Tab 2-->
                    <div class="tabs-panel table-mrg-btm" id="cost" xmlns:v-on="http://www.w3.org/1999/xhtml">
                        <div class="">
                            <div class="medium-12 bottom-mrg">
                                <div class="clearfix border-btm-line bottom-mrg">
                                    <div style="margin-top: 2px;" class="button-group float-right">
                                        <a class="my-button toolbox-btn small" @click="openInsertModal(1)">جدید</a>
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
                                                                    <li><a v-on:click.prevent="openUpdateCreditDistributionRow(cost , 1)"><i class="fi-pencil size-16"></i>  ویرایش</a></li>
                                                                    <li><a v-on:click.prevent="openDeleteRowDistributionCreditConfirm(cost.id , 1)"><i class="fi-trash size-16"></i>  حذف</a></li>
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
                            </div>
                           </div>
                        </div>
                    </div>
                    <!--Tab 2-->
                </div>
                <!-- insert modal -->
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
                                        <input class="form-element-margin-btm" type="text" name="rdcSubject" v-model="rowDistributionCreditInput.rdcSubject" v-validate="'required'" :class="{'input': true, 'error-border': errors.has('rdcSubject')}">
                                    </label>
                                    <span v-show="errors.has('rdcSubject')" class="error-font">لطفا عنوان ردیف را وارد نمایید!</span>
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
                                <button type="submit" class="my-button my-success float-left btn-for-load"><span class="btn-txt-mrg">ثبت</span></button>
                            </div>
                        </form>
                    </div>
                </modal-tiny>
                <!-- insert modal -->
                <!-- update modal -->
                <modal-tiny v-if="showUpdateModal" @close="showUpdateModal = false">
                    <div  slot="body">
                        <form v-on:submit.prevent="updateCreditDistributionRow">
                            <div class="grid-x" v-if="errorMessage">
                                <div class="medium-12 columns padding-lr">
                                    <div class="alert callout">
                                        <p class="BYekan login-alert"><i class="fi-alert"></i>{{ errorMessage }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="grid-x">
                                <div class="medium-12 columns padding-lr">
                                    <label>عنوان
                                        <input class="form-element-margin-btm" type="text" name="rdcSubject" v-model="rowDistributionCreditFill.rdcSubject" v-validate="'required'" :class="{'input': true, 'error-border': errors.has('rdcSubject')}">
                                    </label>
                                    <span v-show="errors.has('rdcSubject')" class="error-font">لطفا عنوان ردیف را وارد نمایید!</span>
                                </div>
                            </div>
                            <div class="grid-x">
                                <div class="small-12 columns padding-lr">
                                    <label>شرح
                                        <textarea name="rdcDescription" style="min-height: 150px;" v-model="rowDistributionCreditFill.rdcDescription"></textarea>
                                    </label>
                                </div>
                            </div>
                            <div class="medium-6 columns padding-lr padding-bottom-modal">
                                <button type="submit" class="my-button my-success float-left btn-for-load"><span class="btn-txt-mrg">ثبت</span></button>
                            </div>
                        </form>
                    </div>
                </modal-tiny>
                <!-- update modal -->
                <!-- delete modal -->
                <modal-tiny v-if="showDeleteModal" @close="showDeleteModal = false">
                    <div  slot="body">
                        <div class="small-font" xmlns:v-on="http://www.w3.org/1999/xhtml">
                            <p>کاربر گرامی</p>
                            <p class="large-offset-1 modal-text">برای حذف رکورد مورد نظر اطمینان دارید؟</p>
                            <div class="grid-x">
                                <div class="medium-12 column text-center">
                                    <button v-on:click="deleteCreditDistributionRow" class="my-button my-success"><span class="btn-txt-mrg">بله</span></button>
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
                rowDistributionCredit: [],
                rowDistributionCredit_cost: [],
                rowDistributionCreditInput: {},
                showInsertModal: false,
                showUpdateModal: false,
                showDeleteModal: false,
                rowDistributionCreditFill: {},
                rdcIdDelete: {},
                planOrCostRequestType: 0,
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
                        this.rowDistributionCredit = response.data;
                        console.log(response.data);
                    },(error) => {
                        console.log(error);
                    });
            },

            fetchCostData: function (page = 1) {
                axios.get('/budget/admin/credit_distribution_def/rows/fetchData?page=' + page , {params:{planOrCost: 1}})
                    .then((response) => {
                        this.rowDistributionCredit_cost = response.data;
                        console.log(response.data);
                    },(error) => {
                        console.log(error);
                    });
            },

            createRowDistributionCredit: function () {
                this.$validator.validateAll().then((result) => {
                    if (result) {
                        axios.post('/budget/admin/credit_distribution_def/rows/register', {
                            subject: this.rowDistributionCreditInput.rdcSubject,
                            description: this.rowDistributionCreditInput.rdcDescription,
                            planOrCost: this.planOrCostRequestType
                        })
                            .then((response) => {
                                if (this.planOrCostRequestType == 0) {
                                    this.rowDistributionCredit = response.data;
                                }
                                else if (this.planOrCostRequestType == 1) {
                                    this.rowDistributionCredit_cost = response.data;
                                }

                                this.showInsertModal = false;
                                this.$parent.displayNotif(response.status);
                                this.rowDistributionCreditInput = [];
                                console.log(response.status);
                            }, (error) => {
                                console.log(error);
                                this.$parent.displayNotif(error.response.status);
                            });
                    }
                });
            },

            openUpdateCreditDistributionRow: function (item , type) {
                this.rowDistributionCreditFill.rdcSubject = item.cdSubject;
                this.rowDistributionCreditFill.rdcDescription = item.cdDescription;
                this.rowDistributionCreditFill.id = item.id;
                this.planOrCostRequestType = type;
                this.errorMessage = '';
                this.showUpdateModal = true;
            },

            updateCreditDistributionRow: function () {
                this.$validator.validateAll().then((result) => {
                    if (result) {
                        axios.post('/budget/admin/credit_distribution_def/rows/update', {
                            id: this.rowDistributionCreditFill.id,
                            subject: this.rowDistributionCreditFill.rdcSubject,
                            description: this.rowDistributionCreditFill.rdcDescription,
                            planOrCost: this.planOrCostRequestType
                        })
                            .then((response) => {
                                if (this.planOrCostRequestType == 0) {
                                    this.rowDistributionCredit = response.data;
                                }
                                else if (this.planOrCostRequestType == 1) {
                                    this.rowDistributionCredit_cost = response.data;
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

            openDeleteRowDistributionCreditConfirm: function (rdc , type) {
                this.rdcIdDelete = rdc;
                this.planOrCostRequestType = type;
                this.showDeleteModal = true;
            },

            openInsertModal: function (type) {
                this.planOrCostRequestType = type;
                this.showInsertModal = true;
                this.errorMessage = '';
            },

            deleteCreditDistributionRow: function () {
                axios.post('/budget/admin/credit_distribution_def/rows/delete' , {
                        crId: this.rdcIdDelete,
                        planOrCost: this.planOrCostRequestType
                    })
                    .then((response) => {
                        if (this.planOrCostRequestType == 0 && response.status != 204) {
                            this.rowDistributionCredit = response.data;
                        }
                        else if (this.planOrCostRequestType == 1 && response.status != 204) {
                            this.rowDistributionCredit_cost = response.data;
                        }
                        this.showDeleteModal = false;
                        this.$parent.displayNotif(response.status);
                        console.log(response);
                    },(error) => {
                        console.log(error);
                        this.showDeleteModal = false;
                    });
            },
        }
    }
</script>
