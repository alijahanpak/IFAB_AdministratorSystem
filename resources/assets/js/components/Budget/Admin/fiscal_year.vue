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
            <div class="medium-12 column padding-lr table-mrg-top">
                <!--Table Head Start-->
                <div class="tbl-div-container">
                    <table class="tbl-head">
                        <colgroup>
                            <col width="100px"/>
                            <col width="300px"/>
                            <col width="100px"/>
                            <col width="100px"/>
                            <col width="100px"/>
                            <col width="12px"/>
                        </colgroup>
                        <tbody class="tbl-head-style">
                        <tr class="tbl-head-style-cell">
                            <th class="tbl-head-style-cell">سال مالی</th>
                            <th class="tbl-head-style-cell">شرح</th>
                            <th class="tbl-head-style-cell">وضعیت</th>
                            <th class="tbl-head-style-cell">مجوزها</th>
                            <th class="tbl-head-style-cell">فعالسازی</th>
                            <th class="tbl-head-style-cell"></th>
                        </tr>
                        </tbody>
                    </table>
                    <!--Table Head End-->
                    <!--Table Body Start-->
                    <div class="tbl_body_style dynamic-height-level2">
                        <table class="tbl-body-contain">
                            <colgroup>
                                <col width="100px"/>
                                <col width="300px"/>
                                <col width="100px"/>
                                <col width="100px"/>
                                <col width="100px"/>
                            </colgroup>
                            <tbody class="tbl-head-style-cell">
                                <tr v-for="fiscalYear in fiscalYears">
                                    <td>{{ fiscalYear.fyLabel }}</td>
                                    <td>{{ fiscalYear.fyDescription }}</td>
                                    <td class="text-center" v-show="fiscalYear.fyStatus != 2">{{ getFiscalYearStatus(fiscalYear.fyStatus) }}</td>
                                    <td class="text-center btn-red" v-show="fiscalYear.fyStatus == 2">{{ getFiscalYearStatus(fiscalYear.fyStatus) }}</td>
                                    <td class="text-center">
                                        <a v-show="fiscalYear.fyStatus == 1" @click="openChangePermissionDialog(fiscalYear.id)"><i class="fi-clipboard-pencil size-21 blue-color"></i></a>
                                    </td>
                                    <td class="text-center">
                                        <a v-show="fiscalYear.fyStatus == 0" @click="openFyActiveRequestDialog(fiscalYear.fyLabel , fiscalYear.id)"><i class="fi-checkbox size-21 edit-pencil"></i></a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <!--Table Body End-->
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
                                                        <input class="switch-input" id="budgetPermissionAllId" type="checkbox" autocomplete="off" :checked="allSelected(fyPermissionInBudget)"  @click="toggleSelect(fyPermissionInBudget , 'budget')">
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
                                                        <input class="switch-input" type="checkbox" v-model="fyPIB.pbStatus" :id="'budgetPermission' + fyPIB.id" @change="changeBudgetItemPermissionState(fyPIB)">
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
                fyPermissionInBudget: [],
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
            this.$parent.userIsActive();
        },

        mounted: function () {
            console.log("mounted fiscal year component");
            this.$parent.myResize();
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
                        //var BPA_state = false;
                        this.fyPermissionInBudget = response.data;
/*                        this.fyPermissionInBudget.forEach(item => {
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
                        }*/
                        console.log(response.data);
                    },(error) => {
                        console.log(error);
                    });
            },

            changeFySectionPermissionState: function (section) {
                switch (section){
                    case "budget":
                        axios.post('/budget/admin/fiscal_year/changeSectionPermissionState',{
                            fyId: this.fyActiveId,
                            section: section,
                            state: this.allSelected(this.fyPermissionInBudget)
                        }).then((response) => {
                                this.fyPermissionInBudget = response.data;
                                console.log(response.data);
                            },(error) => {
                                console.log(error);
                            });
                        break;
                }
            },

            changeBudgetItemPermissionState: function (pb) {
                axios.post('/budget/admin/fiscal_year/changeBudgetItemPermissionState',{
                    pbId: pb.id,
                    state: pb.pbStatus
                }).then((response) => {
                    this.fyPermissionInBudget = response.data;
                    console.log(response.data);
                },(error) => {
                    console.log(error);
                });
            },

            allSelected: function(permissions) {
                return permissions.every(function(perm){
                    return perm.pbStatus;
                });
            },

            toggleSelect: function(permissions , section) {
                if(permissions.find(perm => perm.pbStatus)){
                    permissions.forEach(perm => perm.pbStatus = false)
                } else {
                    permissions.forEach(perm => perm.pbStatus = true)
                }
                this.changeFySectionPermissionState(section);
                console.log(JSON.stringify(this.fyPermissionInBudget));
            },

        }
    }
</script>
