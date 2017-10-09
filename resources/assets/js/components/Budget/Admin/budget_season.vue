<template xmlns:v-on="http://www.w3.org/1999/xhtml" xmlns:on-click="http://www.w3.org/1999/xhtml">
    <!--Inner body start-->
    <div class="medium-10 border-right-line inner-body-pad main-margin">
        <div class="grid-x padding-lr">
            <div class="medium-12">
                <div class="grid-x">
                    <nav aria-label="You are here:" role="navigation">
                        <ul class="breadcrumbs">
                            <li><router-link to="/budget">داشبورد</router-link></li>
                            <li>
                                <a class="disabled">مدیریت</a>
                            </li>
                            <li>
                                <span class="show-for-sr">Current: </span>سال مالی
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
                        <a class="my-button toolbox-btn small" @click="showInsertModal = true;">جدید</a>
                        <a class="my-button toolbox-btn small">گزارش</a>
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
                    <!--Tab 1 Start-->
                    <div class="columns padding-lr table-mrg-top">
                        <!--Header Start-->
                        <div class="grid-x table-header">
                            <div class="medium-4 table-border">
                                <strong>عنوان</strong>
                            </div>
                            <div class="medium-8 table-border">
                                <strong>شرح</strong>
                            </div>
                        </div>
                        <!--Header End-->
                        <div class="table-contain dynamic-height-level2">
                            <div class="grid-x" v-for="budgetSeason in budgetSeasons">
                                <div class="medium-4 table-contain-border cell-vertical-center">{{ budgetSeason.bsSubject }}</div>
                                <div class="medium-8 table-contain-border cell-vertical-center">
                                    <div class="grid-x">
                                        <div class="medium-11">
                                            {{ budgetSeason.bsDescription }}
                                        </div>
                                        <div class="medium-1 cell-vertical-center text-left">
                                            <a class="dropdown small sm-btn-align"  type="button" :data-toggle="'budgetSeason' + budgetSeason.id"><img width="15px" height="15px"  src="/IFAB_AdministratorSystem/public/pic/menu.svg"></a>
                                            <div class="dropdown-pane dropdown-pane-sm " data-close-on-click="true"  data-hover="true" data-hover-pane="true"  data-position="bottom" data-alignment="right" :id="'budgetSeason' + budgetSeason.id" data-dropdown data-auto-focus="true">
                                                <ul class="my-menu small-font text-right">
                                                    <li><a data-open="preloaderModal"><i class="fi-pencil size-16"></i>  ویرایش</a></li>
                                                    <li><a data-open="modalDelete"><i class="fi-trash size-16"></i>  حذف</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--Tab 1 End-->
                    <notifications group="budgetSeasonPm"
                                   position="bottom right"
                                   animation-type="velocity"
                                   :speed="700" />
            </div>
        </div>
        <!--modalDelete Start-->
        <modal-tiny v-if="showFyActiveModal" @close="showFyActiveModal = false">
            <div  slot="body">

            </div>
        </modal-tiny>
        <!--modalDelete end-->

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
                                    <input type="text" name="bsSubject" v-model="budgetSeasonInput.subject" v-validate="'required'" :class="{'input': true, 'error-border': errors.has('bsSubject')}">
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
                            <button name="Submit" type="submit" class="my-secondary button float-left btn-for-load"> <span>  ثبت</span></button>
                        </div>
                    </form>
                </div>
            </div>
        </modal-tiny>
        <!--ModalInsert End-->
    </div>
</template>
<script>
    export default {
        data(){
            return {
                budgetSeasons: [],
                budgetSeasonInput: {subject: '' , description: ''},
                showInsertModal: false,
            }
        },

        created: function () {
            this.fetchData();
        },

        updated: function () {
            $(this.$el).foundation(); //WORKS!
        },

        mounted: function () {
            console.log("mounted budget season component");
            res();
        },

        methods:{
            fetchData: function () {
                this.$root.start();
                axios.get('/budget/admin/credit_distribution_def/budget_season/fetchData')
                    .then((response) => {
                        this.budgetSeasons = response.data;
                        console.log(response);
                        this.$root.finish();
                    },(error) => {
                        console.log(error);
                        this.$root.fail();
                    });
            },

            createBudgetSeason: function () {
                this.$validator.validateAll().then((result) => {
                    if (result) {
                        this.$root.start();
                        axios.post('/budget/admin/credit_distribution_def/budget_season/register' , {
                            subject: this.budgetSeasonInput.subject,
                            description: this.budgetSeasonInput.description})
                            .then((response) => {
                                this.budgetSeasons = response.data;
                                this.showInsertModal = false;
                                this.displayNotif(response.status);
                                this.budgetSeasonInput = [];
                                console.log(response);
                                this.$root.finish();
                            },(error) => {
                                console.log(error);
                                this.errorMessage = 'فصل بودجه با این مشخصات قبلا ثبت شده است!';
                                this.$root.fail();
                            });
                    }
                });
            },

            displayNotif: function (httpStatusCode) {
                switch (httpStatusCode){
                    case 204:
                        this.$notify({group: 'budgetSeasonPm', title: 'پیام سیستم', text: 'با توجه به وابستگی رکورد ها، حذف رکورد امکان پذیر نیست.' , type: 'error'});
                        break;
                    case 200:
                        this.$notify({group: 'budgetSeasonPm', title: 'پیام سیستم', text: 'درخواست با موفقیت انجام شد.' , type: 'success'});
                        break;
                }
            }
        }
    }
</script>
