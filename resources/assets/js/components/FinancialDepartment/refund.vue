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
                                <col width="300px"/>
                                <col width="150px"/>
                                <col width="150px"/>
                                <col width="150px"/>
                                <col width="250px"/>
                                <col width="12px"/>
                            </colgroup>
                            <tbody class="tbl-head-style">
                            <tr class="tbl-head-style-cell">
                                <th class="tbl-head-style-cell">عنوان</th>
                                <th class="tbl-head-style-cell">مبلغ <span class="btn-red small-font">(ریال)</span></th>
                                <th class="tbl-head-style-cell">شماره</th>
                                <th class="tbl-head-style-cell">تاریخ</th>
                                <th class="tbl-head-style-cell">فاکتورهای بررسی نشده</th>
                                <th class="tbl-head-style-cell"></th>
                            </tr>
                            </tbody>
                        </table>
                        <!--Table Head End-->
                        <!--Table Body Start-->
                        <div class="tbl_body_style dynamic-height-level2">
                            <table class="tbl-body-contain">
                                <colgroup>
                                    <col width="300px"/>
                                    <col width="150px"/>
                                    <col width="150px"/>
                                    <col width="150px"/>
                                    <col width="250px"/>
                                </colgroup>
                                <tbody class="tbl-head-style-cell">
                                <tr class="table-row" @click="" v-for="refund in refunds">
                                    <td>{{refund.rSubject}}</td>
                                    <td>{{refund.rAcceptedAmount}}</td>
                                    <td>{{refund.rLetterNumber}}</td>
                                    <td>{{refund.rLetterDate}}</td>
                                </tr>
                                </tbody>
                            </table>
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


    export default {
        components: {
            Suggestions,
            "vue-select": require("vue-select"),
            datePicker: VuePersianDatetimePicker,
        },

        data () {
            return {
                refunds:[],
                showRequestDetailModal:false,
                showPrintCheckModal:false,
                baseURL:window.hostname+'/',
                updateDataThreadNowPlaying:null,

                allActiveCheckFormat:[],
                allCheckVerifiers:[],
                inputCheck:{},

            }
        },

        created: function(){
            this.fetchAllRefund();
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

            fetchAllRefund: function () {
                axios.get('/financial/refund/fetch_all_refund')
                    .then((response) => {
                        this.refunds = response.data;
                        console.log(response);
                    }, (error) => {
                        console.log(error);
                    });
            },


    }
}
</script>
