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
                                <span class="show-for-sr">Current: </span>چک
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
        <div class="grid-x my-callout-box container-mrg-top dynamic-height-level1">
            <div class="medium-12 padding-lr" style="margin-top: 15px;">
                <div class="clearfix tool-bar">
                    <div class="float-left">
                        <div class="input-group float-left">
                            <div class="inner-addon right-addon">
                                <i v-if="requestSearchValue == ''" class="fa fa-search purple-color"  aria-hidden="true"></i>
                                <i v-if="requestSearchValue != ''" v-on:click.stop="removeFilter()" class="fa fa-close btn-red"  aria-hidden="true"></i>
                                <input v-model="requestSearchValue" v-on:keyup.enter="search()" class="search" type="text" placeholder="جستجو">
                            </div>
                        </div>
                    </div>
                </div>
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
                                <tr class="table-row" @click="getRequestDetail(allRequest)" v-for="allCheck in allChecks">
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
    </div>
</template>

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
                baseURL:window.hostname+'/',
                updateDataThreadNowPlaying:null,
                result_pagination: {
                    total: 0,
                    to: 0,
                    current_page: 1,
                    last_page: ''
                },

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
