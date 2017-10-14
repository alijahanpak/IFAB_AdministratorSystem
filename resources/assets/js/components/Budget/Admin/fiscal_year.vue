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
                                <span class="show-for-sr">Current: </span>سال مالی
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
        <div class="grid-x my-callout-box container-mrg-top dynamic-height-level1">
            <div class="medium-12 column">
                    <!--Tab 1 Start-->
                    <div class="columns padding-lr table-mrg-top">
                        <!--Header Start-->
                        <div class="grid-x table-header">
                            <div class="medium-2 table-border">
                                <strong>سال مالی</strong>
                            </div>
                            <div class="medium-4 table-border">
                                <strong>شرح</strong>
                            </div>
                            <div class="medium-2 table-border">
                                <strong>وضعیت</strong>
                            </div>
                            <div class="medium-2 table-border">
                                <strong>مجوزها</strong>
                            </div>
                            <div class="medium-2 table-border">
                                <strong>فعالسازی</strong>
                            </div>
                        </div>
                        <!--Header End-->
                        <div class="table-contain dynamic-height-level2">
                            <div class="grid-x" v-for="fiscalYear in fiscalYears">
                                <div class="medium-2 table-contain-border cell-vertical-center">{{ fiscalYear.fyLabel }}</div>
                                <div class="medium-4 table-contain-border cell-vertical-center">{{ fiscalYear.fyDescription }}</div>
                                <div class="medium-2 table-contain-border cell-vertical-center">{{ getFiscalYearStatus(fiscalYear.fyStatus) }}</div>
                                <div class="medium-2 table-contain-border cell-vertical-center text-center">
                                    <div v-show="fiscalYear.fyStatus != 0">
                                        <a @click="openChangePermissionDialog(fiscalYear.id)"><i class="fi-clipboard-pencil size-21 blue-color"></i> </a>
                                    </div>
                                </div>
                                <div class="medium-2 table-contain-border cell-vertical-center text-center">
                                    <div v-show="fiscalYear.fyStatus == 0">
                                        <a @click="openFyActiveRequestDialog(fiscalYear.fyLabel , fiscalYear.id)"><i class="fi-checkbox size-21 edit-pencil"></i></a>
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
                    <!--Tab 1 End-->
                    <notifications group="fiscalYearPm"
                                   position="bottom right"
                                   animation-type="velocity"
                                   :speed="700" />
            </div>
        </div>
        <!--modalFYActivate Start-->
        <modal-tiny v-if="showFyActiveModal" @close="showFyActiveModal = false">
            <div  slot="body">
                <div class="small-font" xmlns:v-on="http://www.w3.org/1999/xhtml">
                    <p>کاربر گرامی</p>
                    <p class="large-offset-1 modal-text">آیا مایل به فعال سازی سال مالی <span>{{ fyLabel}}</span>هستید؟</p>
                    <div class="grid-x">
                        <div class="medium-6 text-center">
                            <a @click="sendFyActiveRequest" class="my-button my-primary btn-large-w">بله</a>
                        </div>
                        <div class="medium-6 text-center">
                            <a @click="showFyActiveModal = false" class="my-button my-metal hollow btn-large-w">خیر</a>
                        </div>
                    </div>
                </div>
            </div>
        </modal-tiny>
        <!--modalFyActivate end-->

        <!--Modal Permission Start-->
        <modal-large v-if="showChangePermissionDialog" @close="showChangePermissionDialog = false">
            <div  slot="body">
            <div class="small-font">
                <div class="grid-x">
                    <div class="medium-12 column">
                        <ul class="accordion" data-accordion>
                            <li class="accordion-item is-active" data-accordion-item>
                                <a href="#" class="accordion-title">بودجه</a>
                                <div class="accordion-content" data-tab-content >
                                    <div style="margin-bottom: 20px;" class="grid-x column">
                                        <div class="medium-12">
                                            <div class="grid-x padding-lr">
                                                <div class="medium-1">
                                                    <div class="switch tiny">
                                                        <input class="switch-input" id="budgetPermissionAllId" type="checkbox" autocomplete="off"  v-model="allPermissionSelectedSection.budget" @change="changeFySectionPermissionState('budget')">
                                                        <label class="switch-paddle" for="budgetPermissionAllId">
                                                            <span class="switch-active" aria-hidden="true">بلی</span>
                                                            <span class="switch-inactive" aria-hidden="true">خیر</span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="medium-11">
                                                    <p>همه موارد</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div v-for="(fyPIB , index) in fyPermissionInBudget" class="grid-x column">
                                        <div class="medium-12">
                                            <div class="grid-x padding-lr">
                                                <div class="medium-2">
                                                    <div class="switch tiny">
                                                        <input class="switch-input" type="checkbox" v-model="budgetPermissionState[fyPIB.id]" :id="'budgetPermission' + fyPIB.id" @change="changeBudgetItemPermissionState(fyPIB.id)">
                                                        <label class="switch-paddle" :for="'budgetPermission' + fyPIB.id">
                                                            <span class="switch-active" aria-hidden="true">بلی</span>
                                                            <span class="switch-inactive" aria-hidden="true">خیر</span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="medium-10">
                                                    <p>{{ fyPIB.pbLabel }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            </div>
        </modal-large>
        <!--Modal Permission End-->
    </div>
</template>
<script>
    import VuePagination from '../../../public_component/pagination.vue';
    export default {
        data(){
            return {
                fiscalYears: [],
                fyPermissionInBudget: {},
                showFyActiveModal: false,
                showChangePermissionDialog: false,
                allPermissionSelectedSection: {budget: ''},
                fyLabel: '',
                fyActiveId: '',
                budgetPermissionState: {},
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
        },

        updated: function () {
            $(this.$el).foundation(); //WORKS!
        },

        mounted: function () {
            console.log("mounted fiscal year component");
            res();
        },

        components:{
            'vue-pagination' : VuePagination
        },

        methods:{
            fetchData: function (page = 1) {
                axios.get('/budget/admin/fiscal_year/fetchData?page=' + page)
                    .then((response) => {
                        this.fiscalYears = response.data.data;
                        this.makePagination(response.data);
                        console.log(response.data);
                    },(error) => {
                        console.log(error);
                    });
            },

            makePagination: function(data){
                this.pagination.current_page = data.current_page;
                this.pagination.to = data.to;
                this.pagination.last_page = data.last_page;
            },

            getFiscalYearStatus: function (status) {
                if (status == 0)
                {
                    return 'غیر فعال';
                }
                else if (status == 1)
                {
                    return 'فعال';
                }
                else if (status == 2)
                {
                    return 'بسته شده';
                }
            },

            openFyActiveRequestDialog: function (label , fyId) {
                this.fyLabel = label;
                this.fyActiveId = fyId;
                this.showFyActiveModal = true;
            },

            sendFyActiveRequest: function () {
                axios.post('/budget/admin/fiscal_year/activate',{
                    fyId: this.fyActiveId
                })
                    .then((response) => {
                        this.fiscalYears = response.data.data;
                        this.makePagination(response.data);
                        this.showFyActiveModal = false;
                        console.log(response.data);
                        this.displayNotif(response.status);
                    },(error) => {
                        console.log(error);
                    });
            },

            openChangePermissionDialog: function (fyId) {
                this.fyActiveId = fyId;
                this.getFyPermissionInBudget();
                this.showChangePermissionDialog = true;
            },

            getFyPermissionInBudget: function () {
                axios.get('/budget/admin/fiscal_year/getFyPermissionInBudget' , {params:{fyId: this.fyActiveId}})
                    .then((response) => {
                        var BPA_state = false;
                        this.fyPermissionInBudget = response.data;
                        this.fyPermissionInBudget.forEach(item => {
                            Vue.set(this.budgetPermissionState , item.id , item.pbStatus);
                            if (item.pbStatus == 0)
                            {
                                this.allPermissionSelectedSection.budget = false;
                                BPA_state = true;
                            }
                        });

                        if (BPA_state == false)
                        {
                            this.allPermissionSelectedSection.budget = true;
                        }
                        console.log(response.data);
                    },(error) => {
                        console.log(error);
                    });
            },

            changeFySectionPermissionState: function (section , fyId) {
                switch (section){
                    case "budget":
                        axios.post('/budget/admin/fiscal_year/changeSectionPermissionState',{
                            fyId: this.fyActiveId,
                            section: section,
                            state: this.allPermissionSelectedSection.budget
                        }).then((response) => {
                                this.fyPermissionInBudget = response.data;
                                console.log(response.data);
                                this.displayNotif(response.status);
                            },(error) => {
                                console.log(error);
                            });
                        break;
                }
            },

            changeBudgetItemPermissionState: function (pbId) {
                axios.post('/budget/admin/fiscal_year/changeBudgetItemPermissionState',{
                    pbId: pbId,
                    state: this.budgetPermissionState[pbId]
                }).then((response) => {
                    this.fyPermissionInBudget = response.data;
                    console.log(response.data);
                    this.displayNotif(response.status);
                },(error) => {
                    console.log(error);
                });
            },

            displayNotif: function (httpStatusCode) {
                switch (httpStatusCode){
                    case 204:
                        this.$notify({group: 'fiscalYearPm', title: 'پیام سیستم', text: 'با توجه به وابستگی رکورد ها، حذف رکورد امکان پذیر نیست.' , type: 'error'});
                        break;
                    case 200:
                        this.$notify({group: 'fiscalYearPm', title: 'پیام سیستم', text: 'درخواست با موفقیت انجام شد.' , type: 'success'});
                        break;
                }
            }
        }
    }
</script>
