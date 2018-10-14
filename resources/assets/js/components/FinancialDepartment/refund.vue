<template>
<!--Body system-->
    <div class="medium-10 border-right-line inner-body-pad">
        <div class="grid-x padding-lr breadcrumbs-pos">
            <div class="medium-12">
                <div class="grid-x">
                    <nav aria-label="You are here:" role="navigation">
                        <ul class="breadcrumbs">
                            <li><router-link to="/budget">داشبورد</router-link></li>
                            <li>
                                <span class="show-for-sr">Current: </span>تنخواه گردان کارپردازی
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
        <div class="grid-x my-callout-box container-mrg-top dynamic-height-level1">
            <div class="medium-12 padding-lr" style="margin-top: 15px;">
                <div class="medium-12 column">
                    <div class="tbl-div-container">
                        <table class="tbl-head">
                            <colgroup>
                                <col width="150px"/>
                                <col width="150px"/>
                                <col width="150px"/>
                                <col width="300px"/>
                                <col width="150px"/>
                                <col width="250px"/>
                                <col width="150px"/>
                                <col width="12px"/>
                            </colgroup>
                            <tbody class="tbl-head-style">
                            <tr class="tbl-head-style-cell">
                                <th class="tbl-head-style-cell">شماره چک</th>
                                <th class="tbl-head-style-cell">تاریخ چک</th>
                                <th class="tbl-head-style-cell">مبلغ <span class="btn-red small-font">(ریال)</span></th>
                                <th class="tbl-head-style-cell">بابت</th>
                                <th class="tbl-head-style-cell">در وجه</th>
                                <th class="tbl-head-style-cell">تاریخ تحویل</th>
                                <th class="tbl-head-style-cell">وضعیت</th>
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
                                    <col width="150px"/>
                                    <col width="150px"/>
                                    <col width="300px"/>
                                    <col width="150px"/>
                                    <col width="250px"/>
                                    <col width="150px"/>
                                </colgroup>
                                <tbody class="tbl-head-style-cell">
                                <tr class="table-row" @click="getRequestDetail(allCheck)" v-for="allCheck in allChecks">
                                    <td class="text-center">{{allCheck.cIdNumber}}</td>
                                    <td class="text-center">{{allCheck.cDate}}</td>
                                    <td class="text-center">{{$parent.dispMoneyFormat(allCheck.cAmount)}}</td>
                                    <td>{{allCheck.cPdId != null ? allCheck.percentage_decrease.pdSubject + ' - ' + allCheck.draft.dFor : allCheck.draft.dFor}}</td>
                                    <td class="text-center">{{allCheck.draft.dPayTo}}</td>
                                    <td class="text-center">{{ allCheck.cDeliveryShamsiDate != '' ? allCheck.cDeliveryShamsiTime + ' - ' + allCheck.cDeliveryShamsiDate : '' }}</td>
                                    <td v-show="allCheck.check_state.csState == 'WAITING_FOR_PRINT'" class="text-center"><span class="danger-label">{{ allCheck.check_state.csSubject }}</span></td>
                                    <td v-show="allCheck.check_state.csState == 'WAITING_FOR_DELIVERY'" class="text-center"><span class="reserved-label">{{ allCheck.check_state.csSubject }}</span></td>
                                    <td v-show="allCheck.check_state.csState == 'DELIVERED'" class="text-center"><span class="success-label">{{ allCheck.check_state.csSubject }}</span></td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="grid-x">
                        <div class="medium-12">
                            <vue-pagination  v-bind:pagination="result_pagination"
                                             v-on:click.native="fetchData(result_pagination.current_page)"
                                             :offset="4">
                            </vue-pagination>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Show Check Print modal -->
        <modal-small v-if="showPrintCheckModal" @close="showPrintCheckModal = false">
            <div slot="body">
                <div class="small-font">
                    <div class="grid-x">
                        <div class="large-12 medium-12 small-12 container-vh">
                            <ul class="tabs tab-color my-tab-style" data-responsive-accordion-tabs="tabs medium-accordion large-tabs" id="request_print_check_tab_view">
                                <li class="tabs-title is-active"><a href="#checkTab" aria-selected="true">چک</a></li>
                                <li class="tabs-title"><a href="#historyCheckTab">تاریخچه پرینت </a></li>
                            </ul>
                            <div class="tabs-content inner-vh" data-tabs-content="request_print_check_tab_view">
                                <!--Tab 1-->
                                <div style="height: 58vh;" class="tabs-panel is-active table-mrg-btm inner-vh-unsize" id="checkTab">
                                    <div class="grid-x">
                                        <div class="large-6 medium-6 small-12 padding-lr">
                                            <label>شماره چک
                                                <input type="text" name="idNumber" v-model="inputCheck.idNumber" v-validate="'required'" :class="{'input': true, 'error-border': errors.has('idNumber')}">
                                            </label>
                                            <p v-show="errors.has('checkSubject')" class="error-font">لطفا شماره چک مورد نظر را وارد نمایید!</p>
                                        </div>
                                        <div class="large-6 medium-6 small-12 padding-lr">
                                            <label>تاریخ پایان
                                                <input
                                                        type="text"
                                                        class="form-control form-control-lg"
                                                        v-model="inputCheck.date"
                                                        id="inputCheck-Date"
                                                        placeholder="انتخاب تاریخ">

                                                <date-picker
                                                        v-model="inputCheck.date"
                                                        :color="'#5c6bc0'"
                                                        element="inputCheck-Date">
                                                </date-picker>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="grid-x">
                                        <div class="large-12 medium-12 small-12 padding-lr">
                                            <label>امضا کننده
                                                <select name="verifierUser" v-validate data-vv-rules="required"  v-model="inputCheck.verifierId" :class="{'input': true, 'select-error': errors.has('verifierUser')}">
                                                    <option value=""></option>
                                                    <option v-for="cvUser in allCheckVerifiers" :value="cvUser.user.id">{{cvUser.user.name}} - {{cvUser.user.role.rSubject}}</option>
                                                </select>
                                                <p v-show="errors.has('verifierUser')" class="error-font">لطفا امضا کننده را انتخاب کنید!</p>
                                            </label>
                                        </div>
                                    </div>

                                    <div class="grid-x">
                                        <div class="large-12 medium-12 small-12 padding-lr">
                                            <label>قالب چک
                                                <select name="verifierUser" v-validate data-vv-rules="required"  v-model="inputCheck.verifierId" :class="{'input': true, 'select-error': errors.has('verifierUser')}">
                                                    <option value=""></option>
                                                    <option v-for="activeCheckFormat in allActiveCheckFormat" :value="activeCheckFormat.id">{{activeCheckFormat.cfSubject}}</option>
                                                </select>
                                                <p v-show="errors.has('verifierUser')" class="error-font">لطفا امضا کننده را انتخاب کنید!</p>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="grid-x small-top-m">
                                        <div class="large-12 medium-12 small-12 padding-lr">
                                            <div class="stacked-for-small button-group float-left">
                                                <button class="my-button my-success float-left"><span class="btn-txt-mrg">  تحویل </span></button>
                                                <button onclick="printJS({ printable: 'printJS-form', type: 'html',targetStyles:['direction','font-family']})" class="my-button my-success float-left"><span class="btn-txt-mrg">  پیش نمایش چک </span></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--Tab 1-->
                                <!--Tab 2-->
                                <div style="height: 58vh;" class="tabs-panel table-mrg-btm inner-vh-unsize" id="historyCheckTab">
                                    <div class="grid-x">
                                    </div>
                                </div>
                                <!--Tab 2-->
                            </div>
                        </div>
                    </div>
                </div>
                <!--<div class="grid-x small-top-m">
                    <div class="large-12 medium-12 small-12 padding-lr">
                        <div class="stacked-for-small button-group float-left">
                            <button onclick="printJS({ printable: 'printJS-form', type: 'html',targetStyles:['direction','font-family']})" class="my-button my-success float-left"><span class="btn-txt-mrg">  چاپ </span></button>
                        </div>
                    </div>
                </div>-->
            </div>
        </modal-small>
        <!-- Show Check Print modal -->
    </div>
</template>
<style>
    .printJSClass{
        direction: rtl;
        font-family: BZar;
    }
</style>
<script>
    import Suggestions from "v-suggestions/src/Suggestions";
    import VuePersianDatetimePicker from 'vue-persian-datetime-picker';
    import VuePagination from '../../public_component/pagination.vue';
    import printJS from 'print-js';

    export default {
        components: {
            Suggestions,
            "vue-select": require("vue-select"),
            datePicker: VuePersianDatetimePicker,
            'vue-pagination' : VuePagination,
        },

        data () {
            return {
                allChecks:[],
                requestSearchValue:'',
                showRequestDetailModal:false,
                showPrintCheckModal:false,
                baseURL:window.hostname+'/',
                updateDataThreadNowPlaying:null,
                result_pagination: {
                    total: 0,
                    to: 0,
                    current_page: 1,
                    last_page: ''
                },
                allActiveCheckFormat:[],
                allCheckVerifiers:[],
                inputCheck:{},

            }
        },

        created: function(){
            this.fetchData();
            this.setUpdateDataThread();
        },

        updated: function () {
            $(this.$el).foundation(); //WORKS!
        },

        mounted: function () {
            this.$parent.myResize();
        },

        beforeDestroy: function () {
            clearInterval(this.updateDataThreadNowPlaying);
            console.log('...................................... kill update data thread');
        },

        methods: {
            makePagination: function(data){
                this.result_pagination.current_page = data.current_page;
                this.result_pagination.to = data.to;
                this.result_pagination.last_page = data.last_page;
            },

            setUpdateDataThread: function () {
                console.log("...................................................... set search part update thread");
                if (this.updateDataThreadNowPlaying)
                    clearInterval(this.updateDataThreadNowPlaying);
                this.updateDataThreadNowPlaying = setInterval(this.updateDataThread, 60000);
            },

            updateDataThread: function () {
                console.log("...................................................... search part update thread");
                this.fetchData();
            },

            fetchData: function (page=1) {
                axios.get('financial/check/list/get_all_data?page=' + page , {params:{searchValue:this.requestSearchValue}})
                    .then((response) => {
                        this.allChecks = response.data.data;
                        this.makePagination(response.data);
                        console.log(response);
                    }, (error) => {
                        console.log(error);
                    });
            },

            fetchAllActiveCheckFormat: function () {
                axios.get('/financial/admin/check/format/fetch_active_format')
                .then((response) => {
                    this.allActiveCheckFormat = response.data;
                    console.log(response);
                }, (error) => {
                    console.log(error);
                });
            },

            getAllCheckVerifiers: function () {
                axios.get('/financial/check/get_check_verifier')
                    .then((response) => {
                        this.allCheckVerifiers = response.data;
                        console.log(response);
                    }, (error) => {
                        console.log(error);
                    });
            },

            getRequestDetail:function(check){
                this.getAllCheckVerifiers();
                this.fetchAllActiveCheckFormat();
                this.showPrintCheckModal=true;
            },

            removeFilter: function () {
                this.requestSearchValue = '';
                this.fetchData();
            },

            search: function () {
                this.fetchData();
            },

    }
}
</script>
