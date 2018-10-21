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
                                <th class="tbl-head-style-cell">بررسی نشده</th>
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
                                <tr class="table-row" @click="getFactorDetail(refund)" v-for="(refund,index) in refunds">
                                    <td>{{refund.rSubject}}</td>
                                    <td class="text-center">{{$root.dispMoneyFormat(refund.rAcceptedAmount)}}</td>
                                    <td class="text-center">{{refund.rLetterNumber}}</td>
                                    <td class="text-center">{{refund.rLetterDate}}</td>
                                    <td v-show="pendingFactors[index] > 0" class="text-center"><span class="danger-label">{{pendingFactors[index]}}</span></td>
                                    <td v-show="pendingFactors[index] == 0" class="text-center"></td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Accept Factor modal -->
        <modal-large v-if="showAcceptFactorModal" @close="showAcceptFactorModal = false">
            <div slot="body">
                <div class="small-font" xmlns:v-on="http://www.w3.org/1999/xhtml">
                   <div class="grid-x">
                       <div class="large-12 medium-12 small-12 small-top-m">
                           <!--Table Start-->
                           <!--Table Head Start-->
                           <div class="tbl-div-container">
                               <table class="tbl-head">
                                   <colgroup>
                                       <col width="300px"/>
                                       <col width="150px"/>
                                       <col width="200px"/>
                                       <col width="300px"/>
                                       <col width="150px"/>
                                       <col width="70px"/>
                                       <col width="80px"/>
                                       <col width="120px"/>
                                       <col width="12px"/>
                                   </colgroup>
                                   <tbody class="tbl-head-style ">
                                   <tr class="tbl-head-style-cell">
                                       <th class="tbl-head-style-cell">عنوان</th>
                                       <th class="tbl-head-style-cell">مبلغ</th>
                                       <th class="tbl-head-style-cell">فروشنده</th>
                                       <th class="tbl-head-style-cell">شرح</th>
                                       <th class="tbl-head-style-cell">وضعیت</th>
                                       <th class="tbl-head-style-cell"></th>
                                       <th class="tbl-head-style-cell"> </th>
                                       <th class="tbl-head-style-cell"></th>
                                       <th class="tbl-head-style-cell"></th>
                                   </tr>
                                   </tbody>
                                   <!--Table Head End-->
                                   <!--Table Body Start-->
                               </table>
                               <div style="height: 43vh;" class="tbl_body_style inner-vh-unsize">
                                   <table class="tbl-body-contain">
                                       <colgroup>
                                           <col width="300px"/>
                                           <col width="150px"/>
                                           <col width="200px"/>
                                           <col width="300px"/>
                                           <col width="150px"/>
                                           <col width="80px"/>
                                           <col width="120px"/>
                                       </colgroup>
                                       <tbody class="tbl-head-style-cell">
                                       <tr v-for="factor in factorTemp">
                                           <td>{{factor.fSubject}}</td>
                                           <td class="text-center">{{$root.dispMoneyFormat(factor.fAmount)}}</td>
                                           <td class="text-center">{{factor.seller.sSubject}}</td>
                                           <td class="text-justify">{{factor.fDescription}}</td>
                                           <td class="text-center" v-show="factor.factor_state.fsState == 'PENDING_REVIEW'"><span class="reserved-label">{{ factor.factor_state.fsSubject }}</span></td>
                                           <td class="text-center" v-show="factor.factor_state.fsState == 'NOT_ACCEPTED'"><span class="blocked-label">{{ factor.factor_state.fsSubject }}</span></td>
                                           <td class="text-center" v-show="factor.factor_state.fsState == 'ACCEPTED'"><span class="success-label">{{ factor.factor_state.fsSubject }}</span></td>
                                           <td class="text-center">
                                               <a style="margin-bottom: 0px" class="my-button my-success small" @click="openConfirmFactor(factor.id)">تایید</a>
                                           </td>
                                           <td class="text-center">
                                               <a style="margin-bottom: 0px" class="my-button toolbox-btn small" @click="openRejectFactor(factor.id)">عدم تایید</a>
                                           </td>
                                       </tr>
                                       </tbody>
                                   </table>
                               </div>
                           </div>
                           <!--Table Body End-->
                       </div>
                   </div>
                </div>
            </div>
        </modal-large>
        <!-- Accept Factor modal -->

        <!-- Confirm Factor modal -->
        <modal-tiny v-if="showAcceptRefundFactor" @close="showAcceptRefundFactor = false">
            <div slot="body">
                <div class="small-font" xmlns:v-on="http://www.w3.org/1999/xhtml">
                    <p class="black-color text-justify" style="font-size: 1rem">کاربر گرامی:</p>
                    <p class="large-offset-1 modal-text">آیا برای تایید فاکتور اطمینان دارید؟</p>
                    <div class="grid-x">
                        <div class="medium-12 column text-center">
                            <button v-on:click="acceptRefundFactor"   class="my-button my-success"><span class="btn-txt-mrg">   بله   </span></button>
                        </div>
                    </div>
                </div>
            </div>
        </modal-tiny>
        <!-- Confirm Factor modal -->

        <!-- Reject Factor modal -->
        <modal-tiny v-if="showRejectRefundFactor" @close="showRejectRefundFactor = false">
            <div slot="body">
                <div class="small-font" xmlns:v-on="http://www.w3.org/1999/xhtml">
                    <p class="black-color text-justify" style="font-size: 1rem">کاربر گرامی:</p>
                    <p class="large-offset-1 modal-text">آیا برای عدم تایید فاکتور اطمینان دارید؟</p>
                    <div class="grid-x">
                        <div class="medium-12 column text-center">
                            <button v-on:click="rejectRefundFactor"   class="my-button my-success"><span class="btn-txt-mrg">   بله   </span></button>
                        </div>
                    </div>
                </div>
            </div>
        </modal-tiny>
        <!-- Reject Factor modal -->

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
                showAcceptFactorModal:false,
                showAcceptRefundFactor:false,
                showRejectRefundFactor:false,
                baseURL:window.hostname+'/',
                updateDataThreadNowPlaying:null,

                allActiveCheckFormat:[],
                allCheckVerifiers:[],
                inputCheck:{},
                pendingFactors:[],
                factorTemp:[],
                requestId:'',
                factorId:','

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
                //this.fetchData();
            },

            fetchAllRefund: function () {
                axios.get('/financial/refund/fetch_all_refund')
                    .then((response) => {
                        this.refunds = response.data;
                        var pendingFactorsTemps=0;
                        this.refunds.forEach(item => {
                            item.factor.forEach(fac => {
                                if(fac.factor_state.fsState =='PENDING_REVIEW')
                                    pendingFactorsTemps += 1;
                                });
                            this.pendingFactors.push(pendingFactorsTemps)
                        });
                        console.log(response);
                    }, (error) => {
                        console.log(error);
                    });
            },

            getFactorDetail : function (refund) {
                this.requestId=refund.id;
                this.factorTemp=refund.factor;

                //alert(this.factorTemp[0].factor_state.fsState);
                console.log(JSON.stringify(this.factorTemp));
                this.showAcceptFactorModal=true;
            },

            openConfirmFactor: function(fId){
                this.factorId=fId;
                this.showAcceptRefundFactor=true;
            },

            acceptRefundFactor: function(){
                axios.post('/financial/refund/factor/accept', {
                    fId:this.factorId,
                    rId: this.requestId
                }).then((response) => {
                    this.refunds=response.data;
                    this.$emit('closeModal');
                    this.showAcceptRefundFactor=false;
                    this.$root.displayNotif(response.status);
                    console.log(response);
                }, (error) => {
                    console.log(error);
                    this.$root.displayNotif(error.response.status);
                });
            },

            openRejectFactor: function(fId){
                this.factorId=fId;
                this.showRejectRefundFactor=true;
            },

            rejectRefundFactor: function(){
                axios.post('/financial/refund/factor/reject', {
                    fId:this.factorId,
                }).then((response) => {
                    this.refunds=response.data;
                    this.$emit('closeModal');
                    this.showRejectRefundFactor=false;
                    this.$root.displayNotif(response.status);
                    console.log(response);
                }, (error) => {
                    console.log(error);
                    this.$root.displayNotif(error.response.status);
                });
            },

    }
}
</script>
