<template xmlns:v-on="http://www.w3.org/1999/xhtml">
    <div class="grid-x">
        <div class="large-12 medium-12 small-12 small-top-m">
            <!--Table Start-->
            <!--Table Head Start-->
            <div class="tbl-div-container">
                <table class="tbl-head">
                    <colgroup>
                        <col width="50px"/>
                        <col width="200px"/>
                        <col width="200px"/>
                        <col width="200px"/>
                        <col width="200px"/>
                        <col width="200px"/>
                        <col width="150px"/>
                        <col width="12px"/>
                    </colgroup>
                    <tbody class="tbl-head-style ">
                    <tr class="tbl-head-style-cell">
                        <th class="tbl-head-style-cell"></th>
                        <th class="tbl-head-style-cell">درصد کل پیشرفت فیزیکی</th>
                        <th class="tbl-head-style-cell">درصد افزایش / کاهش</th>
                        <th class="tbl-head-style-cell">درصد پیشرفت ریالی</th>
                        <th class="tbl-head-style-cell">مبلغ</th>
                        <th class="tbl-head-style-cell">آخرین ارجاع</th>
                        <th class="tbl-head-style-cell">وضعیت</th>
                        <th class="tbl-head-style-cell"></th>
                    </tr>
                    </tbody>
                    <!--Table Head End-->
                    <!--Table Body Start-->
                </table>
                <div class="tbl_body_style dynamic-height-level-modal2">
                    <table class="tbl-body-contain">
                        <colgroup>
                            <col width="50px"/>
                            <col width="200px"/>
                            <col width="200px"/>
                            <col width="200px"/>
                            <col width="200px"/>
                            <col width="200px"/>
                            <col width="150px"/>
                        </colgroup>
                        <tbody class="tbl-head-style-cell">
                        <tr @click="openPdfModal(payRequest)" class="table-row" v-for="payRequest in payRequests">
                            <td v-show="payRequest.prLastRef.rhPrHasBeenSeen == 0" class="text-center icon-padding-btm"><i class="far fa-envelope size-21 purple-color"></i></td>
                            <td v-show="payRequest.prLastRef.rhPrHasBeenSeen == 1" class="text-center icon-padding-btm"><i class="far fa-envelope-open size-21 purple-color"></i></td>
                            <td class="text-center">{{'%' + payRequest.prPhysicalProgress}}</td>
                            <td class="text-center">{{payRequest.prIsFinal == true ? (payRequest.prPhysicalProgress - 100 > 0 ? (payRequest.prPhysicalProgress - 100) + '% افزایش' : ((payRequest.prPhysicalProgress - 100) * (-1)) + '% کاهش') : '--'}}</td>
                            <td class="text-center">{{'%' + payRequest.prAmountProgress}}</td>
                            <td class="text-center">{{$root.dispMoneyFormat(payRequest.prAmount)}}</td>
                            <td :data-toggle="'prLastRef' + payRequest.id">{{payRequest.prLastRef.source_user_info.name}} - {{payRequest.prLastRef.source_user_info.role.rSubject}}
                                <div class="clearfix tool-bar" v-if="payRequest.prLastRef.rhDescription !== null">
                                    <div  style="width: 300px;" class="dropdown-pane dropdown-pane-sm " data-close-on-click="true"  data-hover="true" data-hover-pane="true" data-h-offset="20px"  data-position="auto" data-alignment="auto" :id="'prLastRef' + payRequest.id" data-dropdown data-auto-focus="true">
                                        <ul class="my-menu small-font">
                                            <div class="grid-x">
                                                <div class="medium-12">
                                                    <p class="black-color">{{payRequest.prLastRef.source_user_info.name}} - {{payRequest.prLastRef.source_user_info.role.rSubject}}</p>
                                                    <p class="gray-colors text-justify" style="margin-top: -10px">{{ payRequest.prLastRef.rhDescription }}</p>
                                                    <p style="direction: ltr;margin-bottom: -10px;" class="gray-color small-font float-left"><i class="far fa-calendar-alt"></i><span> {{payRequest.prLastRef.rhShamsiDate}} </span> - <i class="far fa-clock"></i> <span>{{payRequest.prLastRef.rhShamsiTime}}</span></p>
                                                </div>
                                            </div>
                                        </ul>
                                    </div>
                                </div>
                            </td>
                            <td v-show="payRequest.pay_request_state.prsState == 'ACTIVE'" class="text-center"><span class="success-label">{{ payRequest.pay_request_state.prsSubject }}</span></td>
                            <td v-show="payRequest.pay_request_state.prsState == 'BLOCKED'" class="text-center"><span class="blocked-label">{{ payRequest.pay_request_state.prsSubject }}</span></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <!--Table Body End-->
        </div>
        <!-- pdf  modal -->
        <modal-small v-if="showPdfModal" @close="showPdfModal = false">
            <div style="height: 90vh;" slot="body">
                <div class="grid-x">
                    <div class="large-12 medium-12 small-12">
                        <div class="grid-x" :style="{ width: '100%' , height: !payRequestIsBlocked ? '85.5vh' : '91vh'}">
                            <div class="large-12">
                                <vue-element-loading style="width: 100%;" :active="showLoaderProgress" spinner="line-down" color="#716aca"/>
                                <embed style="width: 100%;height: 100%" :src="payRequestPdfPath" />
                            </div>
                        </div>
                        <div class="grid-x" v-if="!payRequestIsBlocked">
                            <div style="margin-bottom:-20px;margin-top: 5px;" class="large-12 medium-12 small-12">
                                <div class="stacked-for-small button-group float-right">
                                    <button @click="openRegisterAndNumberingModal()"  class="my-button my-success"><span class="btn-txt-mrg">   ثبت در دبیرخانه   </span></button>
                                    <button v-if="youArePayRequestVerifier" @click="accept()"  class="my-button my-success"><span class="btn-txt-mrg">   تایید و امضا   </span></button>
                                    <button @click="openReferralModal(payRequestId)"  class="my-button toolbox-btn float-left btn-for-load"><span class="btn-txt-mrg"> ارجاع </span></button>
                                    <button @click="openBlockModal()" class="my-button toolbox-btn"><span class="btn-txt-mrg">مسدود</span></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </modal-small>
        <!-- pdf Factor modal -->
    </div>
</template>
<script>
    import Suggestions from "v-suggestions/src/Suggestions";
    import VueElementLoading from 'vue-element-loading';
    export default{
        props:['payRequests','requestId'],
        components: {
            Suggestions,
            VueElementLoading,
        },
        data () {
            return {
                showInsertDraftModal:false,
                showAcceptConfirmModal: false,
                showDeleteConfirmModal: false,
                showAcceptMinuteConfirmModal: false,
                showRegisterAndNumberingModal:false,
                showPdfModal: false,
                showDialogModal: false,
                showGenerateChecksModal: false,
                showAcceptGeneratecheckConfirmModal: false,
                showBlockModal: false,
                dialogMessage: '',
                draftInput:{},
                blockInput:{},
                directorGeneralUsers:[],
                money: {
                    thousands: ',',
                    precision: 0,
                    masked: true
                },

                //for & PayTo input text
                forQuery: '',
                forItems: [],
                forList: [],
                payToList: [],
                selectedFor: null,
                forOptions: {},
                //for & PayTo input text
                draftBaseAmount:0,
                lastDrafts:0,
                initBaseAmount:0,
                requestBaseAmount:0,
                requestBaseAmountTemp:0,
                requestCAmount:0,
                verifierId: -1,
                payRequestId:'',
                youArePayRequestVerifier:false,
                isMinute: false,
                payRequestPdfPath:'',
                registerDate: '',
                letterNumber: '',
                moneyState:'none',
                percentageDecreases:[],
                percentDecInput:{},
                isAccepted: false,

                decreases:[],
                draftAmount:0,
                draftFor:'',
                finalIncAmount:0,
                checks:[],
                payRequestIsBlocked: true,
                showLoaderProgress:false,
                checkEdited: false,
                checkBaseDelivered: false,
            }
        },

        created: function () {
            $(this.$el).foundation(); //WORKS!
            this.getDirectorGeneralUsers();
        },
        updated: function () {
            $(this.$el).foundation(); //WORKS!
            this.myResizeDraft();
        },

        mounted: function () {

        },

        methods : {
            openPdfModal: function (payRequest){
              this.payRequestId=payRequest.id;
              this.youArePayRequestVerifier = payRequest.prYouAreVerifiers.length > 0 ? true : false;
              this.payRequestIsBlocked = payRequest.pay_request_state.prsState == 'BLOCKED' ? true : false;
              if (this.youArePayRequestVerifier)
                this.verifierId = payRequest.prYouAreVerifiers[0].id;
              this.openReportFile();
              this.payRequestPdfPath='';
              this.showPdfModal=true;
            },

            openReportFile: function () {
                this.showLoaderProgress = true;
                axios.post('/financial/report/payment_request' , {prId: this.payRequestId})
                    .then((response) => {
                        console.log(response.data);
                        this.showLoaderProgress = false;
                        this.payRequestPdfPath=response.data;
                    },(error) => {
                        console.log(error);
                        this.showLoaderProgress = false;
                    });
            },

            accept: function () {
                axios.post('/financial/payment_request/accept', {
                    rId: this.requestId,
                    prvId:this.verifierId
                }).then((response) => {
                    this.$emit('updateReceiveRequestData' , response.data , this.requestId);
                    this.$emit('closeModal');
                    this.$root.displayNotif(response.status);
                    console.log(response);
                }, (error) => {
                    console.log(error);
                    this.$root.displayNotif(error.response.status);
                });
            },

            openReferralModal:function () {
                this.$emit('openReferralsModal' , null , this.payRequestId);
            },
        }
    }
</script>
