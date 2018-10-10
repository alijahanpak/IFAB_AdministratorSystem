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
                            <col v-show="$can('BUDGET_ADMIN_FISCAL_YEARS_EDIT_PERMISSIONS')" width="100px"/>
                            <col v-show="$can('BUDGET_ADMIN_ACTIVE_FISCAL_YEARS')" width="100px"/>
                            <col width="12px"/>
                        </colgroup>
                        <tbody class="tbl-head-style">
                        <tr class="tbl-head-style-cell">
                            <th class="tbl-head-style-cell">سال مالی</th>
                            <th class="tbl-head-style-cell">شرح</th>
                            <th class="tbl-head-style-cell">وضعیت</th>
                            <th v-show="$can('BUDGET_ADMIN_FISCAL_YEARS_EDIT_PERMISSIONS')" class="tbl-head-style-cell">مجوزها</th>
                            <th v-show="$can('BUDGET_ADMIN_ACTIVE_FISCAL_YEARS')" class="tbl-head-style-cell">فعالسازی</th>
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
                                <col v-show="$can('BUDGET_ADMIN_FISCAL_YEARS_EDIT_PERMISSIONS')" width="100px"/>
                                <col v-show="$can('BUDGET_ADMIN_ACTIVE_FISCAL_YEARS')" width="100px"/>
                            </colgroup>
                            <tbody class="tbl-head-style-cell">
                                <tr v-for="fiscalYear in fiscalYears">
                                    <td>{{ fiscalYear.fyLabel }}</td>
                                    <td>{{ fiscalYear.fyDescription }}</td>
                                    <td class="text-center" v-if="fiscalYear.fyStatus != 2">{{ getFiscalYearStatus(fiscalYear.fyStatus) }}</td>
                                    <td v-else class="text-center btn-red">{{ getFiscalYearStatus(fiscalYear.fyStatus) }}</td>
                                    <td class="text-center" v-show="$can('BUDGET_ADMIN_FISCAL_YEARS_EDIT_PERMISSIONS')">
                                        <a v-show="fiscalYear.fyStatus == 1" @click="openChangePermissionDialog(fiscalYear.id)"><i class="fi-clipboard-pencil size-21 blue-color"></i></a>
                                    </td>
                                    <td v-show="$can('BUDGET_ADMIN_ACTIVE_FISCAL_YEARS')" class="text-center">
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
                        <div class="medium-12 column text-center">
                            <button v-on:click="sendFyActiveRequest" class="my-button my-success"><span class="btn-txt-mrg">   بله   </span></button>
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
                        <div style="margin-bottom: 20px;" class="grid-x column">
                            <div class="medium-12">
                                <div class="grid-x padding-lr">
                                    <div class="medium-1">
                                        <div class="switch tiny">
                                            <input class="switch-input" id="budgetPermissionAllId" type="checkbox" autocomplete="off" :checked="allSelected(fyPermission)"  @click="toggleSelect(fyPermission , fyPermission)">
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
                        <template v-for="(subSystem , index) in fyPermission">
                            <template v-for="subSystemPart in subSystem.sub_system_part">
                                <div v-for="(permission , index) in subSystemPart.permission" class="grid-x column">
                                    <div class="medium-12">
                                        <div class="grid-x padding-lr">
                                            <div class="medium-2">
                                                <div class="switch tiny">
                                                    <input class="switch-input" type="checkbox" v-model="permission.pFyLimiterState" :id="'permission' + permission.id" @change="changeBudgetItemPermissionState(permission)">
                                                    <label class="switch-paddle" :for="'permission' + permission.id">
                                                        <span class="switch-active" aria-hidden="true">بلی</span>
                                                        <span class="switch-inactive" aria-hidden="true">خیر</span>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="medium-10">
                                                <p>{{ permission.pSubject }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </template>
                        </template>
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
                fyPermission: [],
                showFyActiveModal: false,
                showChangePermissionDialog: false,
                allPermissionSelectedSection: {budget: ''},
                fyLabel: '',
                fyActiveId: '',
                updateDataThreadNowPlaying: null,
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
            this.setUpdateDataThread();
        },

        updated: function () {
            $(this.$el).foundation(); //WORKS!
        },

        mounted: function () {
            console.log("mounted fiscal year component");
            this.$parent.myResize();
        },

        beforeDestroy: function () {
            clearInterval(this.updateDataThreadNowPlaying);
            console.log('...................................... kill update data thread');
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
                this.getFyPermission();
                this.showChangePermissionDialog = true;
            },

            getFyPermission: function () {
                axios.get('/budget/admin/fiscal_year/getFyPermission')
                    .then((response) => {
                        this.fyPermission = response.data;
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
                            state: this.allSelected(this.fyPermission)
                        }).then((response) => {
                                this.fyPermission = response.data;
                                console.log(response.data);
                            },(error) => {
                                console.log(error);
                            });
                        break;
                }
            },

            changeBudgetItemPermissionState: function (permission) {
                axios.post('/budget/admin/fiscal_year/changePermissionState',{
                    pId: permission.id,
                    state: permission.pFyLimiterState
                }).then((response) => {
                    this.fyPermission = response.data;
                    console.log(response.data);
                },(error) => {
                    console.log(error);
                });
            },

            allSelected: function(permissions) {
/*                return permissions.every(function(perm){
                    return perm.pbStatus;
                });*/
            },

            toggleSelect: function(permissions , section) {
                if(permissions.find(perm => perm.pbStatus)){
                    permissions.forEach(perm => perm.pbStatus = false)
                } else {
                    permissions.forEach(perm => perm.pbStatus = true)
                }
                this.changeFySectionPermissionState(section);
                console.log(JSON.stringify(this.fyPermission));
            },

            setUpdateDataThread: function () {
                console.log("...................................................... set fiscal year update thread");
                if (this.updateDataThreadNowPlaying)
                    clearInterval(this.updateDataThreadNowPlaying);
                this.updateDataThreadNowPlaying = setInterval(this.updateDataThread, 120000);
            },

            updateDataThread: function () {
                console.log("...................................................... fiscal year update thread");
                this.fetchData();
            },

        }
    }
</script>
