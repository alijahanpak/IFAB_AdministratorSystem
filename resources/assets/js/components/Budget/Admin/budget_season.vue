<template xmlns:v-on="http://www.w3.org/1999/xhtml" xmlns:on-click="http://www.w3.org/1999/xhtml">
    <!--Inner body start-->
    <div class="medium-10 border-right-line inner-body-pad">
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
                                <span class="show-for-sr">Current: </span>فصل بودجه
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
        <div class="grid-x my-callout-box container-mrg-top dynamic-height-level1">
            <div class="medium-12 padding-lr" style="margin-top: 15px;">
                <div v-show="$can('BUDGET_ADMIN_BUDGET_SEASON_INSERT')" class="clearfix tool-bar">
                    <div style="margin-bottom: 0;" class="button-group float-right">
                        <a class="my-button toolbox-btn small" @click="openInsertModal">جدید</a>
                    </div>
                </div>
            </div>
            <div class="medium-12 column padding-lr">
                <div class="tbl-div-container">
                    <table class="tbl-head">
                        <colgroup>
                            <col width="250px"/>
                            <col width="590px"/>
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
                                <col width="250px"/>
                                <col width="590px"/>
                            </colgroup>
                            <tbody class="tbl-head-style-cell">
                                <tr v-for="budgetSeason in budgetSeasons">
                                    <td>{{ budgetSeason.bsSubject }}</td>
                                    <td>
                                        <div class="grid-x">
                                            <div class="medium-11">
                                                {{ budgetSeason.bsDescription }}
                                            </div>
                                            <div v-show="$can('BUDGET_ADMIN_BUDGET_SEASON_EDIT') || $can('BUDGET_ADMIN_BUDGET_SEASON_DELETE')" class="medium-1 cell-vertical-center text-left">
                                                <a class="dropdown small sm-btn-align" :data-toggle="'budgetSeason' + budgetSeason.id"><i class="fa fa-ellipsis-v size-18"></i></a>
                                                <div class="dropdown-pane dropdown-pane-sm " data-close-on-click="true"  data-hover="true" data-hover-pane="true"  data-position="bottom" data-alignment="right" :id="'budgetSeason' + budgetSeason.id" data-dropdown data-auto-focus="true">
                                                    <ul class="my-menu small-font text-right">
                                                        <li v-show="$can('BUDGET_ADMIN_BUDGET_SEASON_EDIT')"><a @click="openUpdateModal(budgetSeason)"><i class="fi-pencil size-16"></i>  ویرایش</a></li>
                                                        <li v-show="$can('BUDGET_ADMIN_BUDGET_SEASON_DELETE')"><a @click="openDeleteModal(budgetSeason.id)"><i class="fi-trash size-16"></i>  حذف</a></li>
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
        <!--ModalInsert Start-->
        <modal-tiny v-if="showInsertModal" @close="showInsertModal = false">
            <div  slot="body">
                <div class="padding-lr">
                    <form v-on:submit.prevent="createBudgetSeason">
                        <div class="grid-x" style="display: none">
                            <div class="medium-12 columns">
                                <div class="alert callout">
                                    <p class="BYekan login-alert"><i class="fi-alert"></i>این عنوان فصل بودجه قبلا ثبت شده است!</p>
                                </div>
                            </div>
                        </div>
                        <div class="grid-x">
                            <div class="small-12 columns">
                                <label>عنوان فصل بودجه
                                    <input class="form-element-margin-btm" type="text" name="bsSubject" v-model="budgetSeasonInput.subject" v-validate="'required'" :class="{'input': true, 'error-border': errors.has('bsSubject')}">
                                </label>
                                <span v-show="errors.has('bsSubject')" class="error-font">لطفا عنوان فصل بودجه را وارد نمایید!</span>
                            </div>
                        </div>
                        <div class="grid-x">
                            <div class="small-12 columns">
                                <label>شرح
                                    <textarea name="bsDescription" v-model="budgetSeasonInput.description" style="min-height: 150px;"></textarea>
                                </label>
                            </div>
                        </div>
                        <div class="medium-6 columns">
                            <button name="daFormSubmit" type="submit" class="my-button my-success float-left btn-for-load"><span class="btn-txt-mrg">  ثبت</span></button>
                        </div>
                    </form>
                </div>
            </div>
        </modal-tiny>
        <!--ModalInsert End-->
        <!--ModalUpdate Start-->
        <modal-tiny v-if="showUpdateModal" @close="showUpdateModal = false">
            <div  slot="body">
                <div class="padding-lr">
                    <form v-on:submit.prevent="updateBudgetSeason">
                        <div class="grid-x" style="display: none">
                            <div class="medium-12 columns">
                                <div class="alert callout">
                                    <p class="BYekan login-alert"><i class="fi-alert"></i>این عنوان فصل بودجه قبلا ثبت شده است!</p>
                                </div>
                            </div>
                        </div>
                        <div class="grid-x">
                            <div class="small-12 columns">
                                <label>عنوان فصل بودجه
                                    <input class="form-element-margin-btm" type="text" name="bsSubject" v-model="budgetSeasonFill.subject" v-validate="'required'" :class="{'input': true, 'error-border': errors.has('bsSubject')}">
                                </label>
                                <span v-show="errors.has('bsSubject')" class="error-font">لطفا عنوان فصل بودجه را وارد نمایید!</span>
                            </div>
                        </div>
                        <div class="grid-x">
                            <div class="small-12 columns">
                                <label>شرح
                                    <textarea name="bsDescription" v-model="budgetSeasonFill.description" style="min-height: 150px;"></textarea>
                                </label>
                            </div>
                        </div>
                        <div class="medium-6 columns">
                            <button name="daFormSubmit" type="submit" class="my-button my-success float-left btn-for-load"><span class="btn-txt-mrg">  ثبت</span></button>
                        </div>
                    </form>
                </div>
            </div>
        </modal-tiny>
        <!--ModalUpdate End-->
        <!-- Delete Modal Start -->
        <modal-tiny v-if="showDeleteModal" @close="showDeleteModal = false">
            <div  slot="body">
                <div class="small-font">
                    <p>کاربر گرامی</p>
                    <p class="large-offset-1 modal-text">آیا برای حذف این رکورد اطمینان دارید؟</p>
                    <div class="grid-x">
                        <div class="medium-12 column text-center">
                            <button v-on:click="deleteBudgetSeason" class="my-button my-success"><span class="btn-txt-mrg">   بله   </span></button>
                        </div>
                    </div>
                </div>
            </div>
        </modal-tiny>
        <!-- Delete Modal End -->
    </div>
</template>
<script>
    export default {
        data(){
            return {
                budgetSeasons: [],
                budgetSeasonInput: {subject: '' , description: ''},
                budgetSeasonFill: {},
                bsIdForDelete: '',
                updateDataThreadNowPlaying: null,
                showInsertModal: false,
                showUpdateModal: false,
                showDeleteModal: false,
            }
        },

        created: function () {
            this.fetchData();
            this.setUpdateDataThread();
        },

        updated: function () {
            $(this.$el).foundation(); //WORKS!
        },

        mounted: function () {
            console.log("mounted budget season component");
            this.$parent.myResize();
        },

        beforeDestroy: function () {
            clearInterval(this.updateDataThreadNowPlaying);
            console.log('...................................... kill update data thread');
        },

        methods:{
            fetchData: function () {
                axios.get('/budget/admin/credit_distribution_def/budget_season/fetchData')
                    .then((response) => {
                        this.budgetSeasons = response.data;
                        console.log(response);
                    },(error) => {
                        console.log(error);
                    });
            },

            openInsertModal: function () {
                this.budgetSeasonInput = [];
                this.showInsertModal = true;
            },

            createBudgetSeason: function () {
                this.$validator.validateAll().then((result) => {
                    if (result) {
                        axios.post('/budget/admin/credit_distribution_def/budget_season/register' , {
                            subject: this.budgetSeasonInput.subject,
                            description: this.budgetSeasonInput.description})
                            .then((response) => {
                                this.budgetSeasons = response.data;
                                this.showInsertModal = false;
                                this.$parent.displayNotif(response.status);
                                console.log(response);
                            },(error) => {
                                console.log(error);
                                this.$parent.displayNotif(error.response.status);
                            });
                    }
                });
            },

            openUpdateModal: function (bs) {
                this.budgetSeasonFill.id = bs.id;
                this.budgetSeasonFill.subject = bs.bsSubject;
                this.budgetSeasonFill.description = bs.bsDescription;
                this.showUpdateModal = true;
            },

            updateBudgetSeason: function () {
                this.$validator.validateAll().then((result) => {
                    if (result) {
                        axios.post('/budget/admin/credit_distribution_def/budget_season/update' , {
                            id: this.budgetSeasonFill.id,
                            subject: this.budgetSeasonFill.subject,
                            description: this.budgetSeasonFill.description})
                            .then((response) => {
                                this.budgetSeasons = response.data;
                                this.showUpdateModal = false;
                                this.$parent.displayNotif(response.status);
                                console.log(response);
                            },(error) => {
                                console.log(error);
                                this.$parent.displayNotif(error.response.status);
                            });
                    }
                });
            },

            openDeleteModal: function (bsId) {
                this.bsIdForDelete = bsId;
                this.showDeleteModal = true;
            },

            deleteBudgetSeason: function () {
                axios.post('/budget/admin/credit_distribution_def/budget_season/delete' , {id: this.bsIdForDelete})
                    .then((response) => {
                        if (response.status != 204)
                            this.budgetSeasons = response.data;
                        this.showDeleteModal = false;
                        this.$parent.displayNotif(response.status);
                        console.log(response);
                    },(error) => {
                        console.log(error);
                        this.showDeleteModal = false;
                });
            },

            setUpdateDataThread: function () {
                console.log("...................................................... set budget season update thread");
                if (this.updateDataThreadNowPlaying)
                    clearInterval(this.updateDataThreadNowPlaying);
                this.updateDataThreadNowPlaying = setInterval(this.updateDataThread, 120000);
            },

            updateDataThread: function () {
                console.log("...................................................... budget season update thread");
                this.fetchData();
            },
        }
    }
</script>
