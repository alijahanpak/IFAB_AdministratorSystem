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
                <div style="height: 49.2vh;" class="tbl_body_style inner-vh-unsize">
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
            <div style="height: 88vh;" slot="body">
                <div class="grid-x">
                    <div class="large-12 medium-12 small-12">
                        <div class="grid-x" :style="{ width: '100%' , height: !payRequestIsBlocked ? '82vh' : '91vh'}">
                            <div class="large-12">
                                <vue-element-loading style="width: 100%;" :active="showLoaderProgress" spinner="line-down" color="#716aca"/>
                                <embed style="width: 100%;height: 100%" :src="payRequestPdfPath + '#page=1&zoom=50'" />
                            </div>
                        </div>
                        <div class="grid-x" v-if="!payRequestIsBlocked" style="margin-top: 0.5rem">
                            <div style="margin-bottom:-20px;margin-top: 5px;" class="large-12 medium-12 small-12">
                                <div class="stacked-for-small button-group float-right">
                                    <button v-show="$can('FINANCIAL_REGISTER_AND_NUMBERING_PAY_REQUEST') && prLetterNumber == null && prLetterDate == null" @click="openRegisterAndNumberingModal()"  class="my-button my-success"><span class="btn-txt-mrg">   ثبت در دبیرخانه   </span></button>
                                    <button v-if="youArePayRequestVerifier" @click="checkAccept()"  class="my-button my-success"><span class="btn-txt-mrg">   تایید و امضا   </span></button>
                                    <button v-show="$can('FINANCIAL_ADD_NEW_DRAFT')" @click="openInsertDraftModal()"  class="my-button toolbox-btn"><span class="btn-txt-mrg">   تهیه پیشنویس حواله  </span></button>
                                    <button @click="openReferralModal(payRequestId)"  class="my-button toolbox-btn float-left btn-for-load"><span class="btn-txt-mrg"> ارجاع </span></button>
                                    <button @click="openResponseRequestModal(payRequestId)" v-show="canResponse == true"  class="my-button toolbox-btn float-left btn-for-load"><span class="btn-txt-mrg"> پاسخ </span></button>
                                    <button v-show="$can('PAY_REQUEST_BLOCK')" @click="openBlockModal()" class="my-button toolbox-btn"><span class="btn-txt-mrg">مسدود</span></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </modal-small>
        <!-- pdf Factor modal -->
        <!-- Submit Request modal -->
        <modal-tiny v-if="showSubmitRequestModal" @close="showSubmitRequestModal = false">
            <div  slot="body">
                <div class="small-font" xmlns:v-on="http://www.w3.org/1999/xhtml">
                    <div class="grid-x">
                        <template v-if="!existRemainingVerifiers">
                            <div class="large-12 medium-12 small-12 padding-lr">
                                <p class="black-color size-14">آیا برای تایید درخواست اطمینان دارید؟ </p>
                            </div>
                            <div class="large-12 medium-12 small-12 padding-lr">
                                <p class="btn-red size-14">تایید شما به منزله امضا درخواست می باشد.</p>
                            </div>
                            <div class="large-12 medium-12 small-12 padding-lr small-top-m text-center">
                                <button @click="accept()"  class="my-button my-success btn-for-load"><span class="btn-txt-mrg">  تایید</span></button>
                            </div>
                        </template>
                        <template v-else>
                            <div class="large-12 medium-12 small-12 padding-lr text-center">
                                <p class="black-color text-justify" style="font-size: 1rem">کاربر گرامی:</p>
                                <p class="large-offset-1 modal-text">باتوجه به در نظر گرفتن اولویت برای امضاء کنندگان درخواست. در حال حاضر شما امکان تایید درخواست را ندارید. </p>
                            </div>
                            <div class="large-12 medium-12 small-12 padding-lr small-top-m text-center">
                                <button @click="hideSubmitRequestModal()" class="my-button my-success btn-for-load"><span class="btn-txt-mrg">  بله</span></button>
                            </div>
                        </template>
                    </div>
                </div>
            </div>
        </modal-tiny>
        <!-- Submit Request modal -->
        <!-- block Detail Modal Start-->
        <modal-tiny v-if="showBlockModal" @close="showBlockModal = false">
            <div  slot="body">
                <form v-on:submit.prevent="requestBlock">
                    <div class="small-font">
                        <div class="grid-x">
                            <div class="large-12 medium-12 small-12 padding-lr">
                                <p class="black-color text-justify" style="font-size: 1rem">کاربر گرامی:</p>
                                <p class="large-offset-1 modal-text text-justify">توجه داشته باشید که در صورت مسدود کردن درخواست دیگر امکان بازگشت آن به حالت فعال وجود ندارد، با مسدود شدن درخواست مبلغ درخواست در محاسبات در نظر گرفته نخواهد شد.</p>
                                <label>شرح
                                    <textarea v-model="blockInput.description"  class="form-element-margin-btm"  style="min-height: 150px;" name="blockDescription"  v-validate="'required'" :class="{'input': true, 'error-border': errors.has('blockDescription')}"></textarea>
                                    <span v-show="errors.has('blockDescription')" class="error-font">لطفا دلیل مسدود کردن درخواست را وارد کنید!</span>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="large-12 medium-12 small-12 padding-lr small-top-m text-center">
                        <button type="submit"  class="my-button my-success"><span class="btn-txt-mrg">  مسدود</span></button>
                    </div>
                </form>
            </div>
        </modal-tiny>
        <!-- block Detail Modal End-->
        <!-- Register And Numbering Draft Start -->
        <modal-tiny v-if="showRegisterAndNumberingModal" @close="showRegisterAndNumberingModal = false">
            <div  slot="body">
                <div class="small-font" xmlns:v-on="http://www.w3.org/1999/xhtml">
                    <div class="grid-x">
                        <div class="large-12 medium-12 small-12 padding-lr">
                            <label>تاریخ
                                <input
                                        type="text"
                                        class="form-control form-control-lg"
                                        v-model="registerDate"
                                        id="my-custom-input"
                                        placeholder="انتخاب تاریخ">

                                <date-picker
                                        v-model="registerDate"
                                        :color="'#5c6bc0'"
                                        element="my-custom-input">
                                </date-picker>
                            </label>
                        </div>
                        <div class="large-12 medium-12 small-12 padding-lr">
                            <label> شماره
                                <input class="form-element-margin-btm" type="text" name="letterNumber" v-model="letterNumber" v-validate="'required'" data-vv-as="field" :class="{'input': true, 'error-border': errors.has('letterNumber')}">
                                <span v-show="errors.has('letterNumber')" class="error-font"></span>
                            </label>
                        </div>
                        <div class="large-12 medium-12 small-12 padding-lr small-top-m text-center">
                            <button @click="registerAndNumberingPayRequest()"  class="my-button my-success btn-for-load"><span class="btn-txt-mrg">  ثبت</span></button>
                        </div>
                    </div>
                </div>
            </div>
        </modal-tiny>
        <!-- Register And Numbering Draft End -->

        <!--Insert Draft Start-->
        <modal-small v-if="showInsertDraftModal" @close="showInsertDraftModal = false">
            <div  slot="body">
                <form v-on:submit.prevent="addNewDraft" >
                    <div class="small-font">
                        <div class="large-12 medium-12 small-12">
                            <ul class="tabs tab-color my-tab-style" data-responsive-accordion-tabs="tabs medium-accordion large-tabs" id="draft_tab_view">
                                <li class="tabs-title is-active"><a href="#verTab" aria-selected="true">امضا کننده</a></li>
                                <li class="tabs-title"><a href="#drafTab">حواله </a></li>
                            </ul>
                            <div class="tabs-content" data-tabs-content="draft_tab_view">
                                <!--Tab 1-->
                                <div class="tabs-panel is-active table-mrg-btm" id="verTab">
                                    <div class="grid-x">
                                        <div class="large-8 medium-8 small-12">
                                            <label>امضا کننده
                                                <select name="verifierUser" v-validate data-vv-rules="required"  v-model="draftInput.verifierId" :class="{'input': true, 'select-error': errors.has('verifierUser')}">
                                                    <option value=""></option>
                                                    <option v-for="user in directorGeneralUsers" :value="user.id">{{user.name}} - {{user.role.rSubject}}</option>
                                                </select>
                                                <p v-show="errors.has('verifierUser')" class="error-font">لطفا امضا کننده را انتخاب کنید!</p>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <!--Tab 1-->
                                <!--Tab 2-->
                                <div class="tabs-panel table-mrg-btm" id="drafTab">
                                    <div class="grid-x">
                                        <div class="large-12 medium-12 small-12 padding-lr">
                                            <label>بابت
                                                <suggestions autocomplete="off" style="margin-bottom: -18px;" name="forTitle" v-validate="'required'" :class="{'input': true, 'select-error': errors.has('forTitle')}"
                                                             v-model="draftInput.for"
                                                             :options="forOptions"
                                                             :onInputChange="onForInputChange">
                                                    <div slot="item" slot-scope="props" class="single-item">
                                                        <strong>{{props.item}}</strong>
                                                    </div>
                                                </suggestions>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="grid-x input-margin-top">
                                        <div class="large-12 medium-12 small-12 padding-lr">
                                            <label>در وجه
                                                <suggestions autocomplete="off" style="margin-bottom: -18px;" name="payToTitle" v-v-validate="'required'" :class="{'input': true, 'select-error': errors.has('payToTitle')}"
                                                             v-model="draftInput.payTo"
                                                             :options="payToOptions"
                                                             :onInputChange="onPayToInputChange">
                                                    <div slot="item" slot-scope="props" class="single-item">
                                                        <strong>{{props.item}}</strong>
                                                    </div>
                                                </suggestions>
                                            </label>
                                        </div>
                                    </div>
                                    <div style="margin-top:15px;"  class="grid-x">
                                        <div class="large-6 medium-6 small-12 padding-lr">
                                            <label>مبلغ<span class="btn-red">(ریال)</span>
                                                <money v-if="moneyState== 'none'" readonly @change.native="calculateDraftAmount()" v-model="draftInput.baseAmount"  v-bind="money" class="form-input input-lg text-margin-btm"  v-validate="'required'" :class="{'input': true, 'error-border': errors.has('baseAmount')}"></money>
                                                <money v-if="moneyState== 'block'" readonly @change.native="calculateDraftAmount()" v-model="draftInput.baseAmount"  v-bind="money" class="form-input input-lg text-margin-btm select-error"  v-validate="'required'" :class="{'input': true, 'error-border': errors.has('baseAmount')}"></money>
                                            </label>
                                            <p v-show="errors.has('baseAmount')" class="error-font"> مبلغ صورت وضعیت مورد نظر نامعتبر است!</p>
                                            <p style="margin-top: 10px;" v-show="moneyState== 'block'" class="btn-red">مبلغ صورت وضعیت مورد نظر نامعتبر است!</p>
                                        </div>
                                    </div>
                                    <div style="margin-top: 10px;" class="grid-x padding-lr">
                                        <div class="large-12 medium-12 small-12 panel-separator">
                                            <div class="grid-x">
                                                <div class="large-9 medium-9  small-12">
                                                    <div class="grid-x">
                                                        <div class="large-12 medium-12 small-12">
                                                            <p>مبلغ تعهد شده : </p>
                                                            <p>مبلغ حواله های ثبت شده تا کنون : </p>
                                                            <p>مبلغ نهایی حواله : </p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="large-3 medium-3 small-12">
                                                    <p class="btn-red">{{$root.dispMoneyFormat(rCommitmentAmount)}} ریال</p>
                                                    <p class="btn-red">{{$root.dispMoneyFormat(lastDrafts)}} ریال</p>
                                                    <p class="btn-red">{{$root.dispMoneyFormat(draftBaseAmount)}} ریال</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <!--Tab 2-->
                            </div>
                        </div>
                        <div class="grid-x medium-top-m padding-lr">
                            <div class="large-12 medium-12 small-12 padding-lr">
                                <div class="stacked-for-small button-group float-left">
                                    <button type="submit" class="my-button my-success float-left"><span class="btn-txt-mrg">  ثبت </span></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </modal-small>
        <!--Insert Draft End-->

        <messageDialog v-show="showDialogModal" @close="showDialogModal =false">
            {{dialogMessage}}
        </messageDialog>
    </div>
</template>
<script>
    import Suggestions from "v-suggestions/src/Suggestions";
    import VueElementLoading from 'vue-element-loading';
    export default{
        props:['payRequests','requestId' , 'lastRefPrId','drafts','rAcceptedAmount','rCommitmentAmount','contracts','factors','requestType' , 'sumOfDraftAmount'],
        components: {
            Suggestions,
            VueElementLoading,
        },
        data () {
            return {
                showSubmitRequestModal: false,
                showRegisterAndNumberingModal:false,
                showPdfModal: false,
                showDialogModal: false,
                showBlockModal: false,
                showInsertDraftModal:false,
                dialogMessage: '',
                blockInput:{},
                prDrafts:[],
                prLetterNumber: '',
                prLetterDate: '',
                //for & PayTo input text,
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
                requestCAmount:0,
                verifierId: -1,
                payRequestId:'',
                youArePayRequestVerifier:false,
                existRemainingVerifiers: true,
                canResponse:'',
                payRequestPdfPath:'',
                registerDate: '',
                letterNumber: '',
                moneyState:'none',

                payRequestIsBlocked: true,
                showLoaderProgress:false,

                draftInput:{},
                directorGeneralUsers:[],
                //Draft

                money: {
                    thousands: ',',
                    precision: 0,
                    masked: true
                },
                payAmount:0,

            }
        },

        created: function () {
            $(this.$el).foundation(); //WORKS!
            this.getDirectorGeneralUsers();
        },
        updated: function () {
            $(this.$el).foundation(); //WORKS!showInsertDraftModal
        },

        mounted: function () {
            this.checkOpenLastRef();
        },

        methods : {
            checkOpenLastRef: function() {
                this.payRequests.forEach(payment => {
                    if (payment.prLastRef.rhPrId == this.lastRefPrId) {
                        this.openPdfModal(payment);
                        return;
                    }
                });
            },

            getDirectorGeneralUsers: function () {
                axios.get('/admin/user/getDirectorGeneralUsers')
                    .then((response) => {
                        this.directorGeneralUsers = response.data;
                        console.log(response);
                    }, (error) => {
                        console.log(error);
                    });
            },

            openPdfModal: function (payRequest){
                  this.payAmount=payRequest.prAmount;
                  this.payRequestId=payRequest.id;
                  this.youArePayRequestVerifier = payRequest.prYouAreVerifiers.length > 0 ? true : false;
                  this.payRequestIsBlocked = payRequest.pay_request_state.prsState == 'BLOCKED' ? true : false;
                  this.canResponse = payRequest.prLastRef.rhIsReferral;
                  this.existRemainingVerifiers = payRequest.prRemainingVerifiers.length > 0 ? true : false;
                  this.prDrafts = payRequest.draft;
                  this.prLetterDate = payRequest.prLetterDate;
                  this.prLetterNumber = payRequest.prLetterNumber;
                  if (this.youArePayRequestVerifier)
                    this.verifierId = payRequest.prYouAreVerifiers[0].id;
                  this.openReportFile();
                  this.payRequestPdfPath='';
                  this.showPdfModal=true;
                if(payRequest.prLastRef.rhPrHasBeenSeen == false) {
                    axios.post('/financial/payment_request/was_seen', {
                        rhId: payRequest.prLastRef.id
                    }).then((response) => {
                        this.$emit('updateReceiveRequestData' , response.data , this.requestId);
                        console.log(response);
                    }, (error) => {
                        console.log(error);
                    });
                }
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

            checkAccept: function(){
                this.showSubmitRequestModal = true;
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

            openResponseRequestModal:function () {
                this.$emit('openResponseRequestModal' , null , this.payRequestId);
            },

            hideSubmitRequestModal: function () {
                this.showSubmitRequestModal = false;
            },

            openBlockModal: function () {
                this.blockInput = {};
                if (this.prDrafts.length == 0)
                    this.showBlockModal = true;
                else
                {
                    this.dialogMessage = 'برای این درخواست حواله صادر شده است! امکان مسدود کردن درخواست وجود ندارد.';
                    this.showDialogModal = true;
                }
            },

            requestBlock: function () {
                this.$validator.validateAll().then((result) => {
                    if (result) {
                        axios.post('/financial/payment_request/block' , {
                            prId: this.payRequestId,
                            lastRefPrId: this.lastRefPrId,
                            description: this.blockInput.description
                        })
                            .then((response) => {
                                this.$emit('updateReceiveRequestData' , response.data , this.requestId);
                                if (this.payRequestId == this.lastRefPrId)
                                    this.$emit('closeModal');
                                else{
                                    this.payRequestIsBlocked = true;
                                    this.showBlockModal = false;
                                }
                                this.$root.displayNotif(response.status);
                            },(error) => {
                                console.log(error);
                                this.$root.displayNotif(error.response.status);
                            });
                    }
                });
            },

            openRegisterAndNumberingModal:function(){
                if (!this.existRemainingVerifiers)
                    this.showRegisterAndNumberingModal=true;
                else
                {
                    this.dialogMessage = 'درخواست باید توسط کلیه تایید کنندگان امضاء شده باشد!';
                    this.showDialogModal = true;
                }
            },

            registerAndNumberingPayRequest: function () {
                axios.post('/financial/payment_request/numbering', {
                    rId: this.requestId,
                    prId:this.payRequestId,
                    letterDate: this.registerDate,
                    letterNumber: this.letterNumber
                }).then((response) => {
                    this.$emit('updateReceiveRequestData' , response.data , this.requestId);
                    this.$emit('closeModal');
                    this.showRegisterAndNumberingModal = false;
                    this.$root.displayNotif(response.status);
                    console.log(response);
                }, (error) => {
                    console.log(error);
                    this.$root.displayNotif(error.response.status);
                });
            },

            /*-----------------------------------------------------------------------------
        ------------------ For Draft Start ------------------------------
        -----------------------------------------------------------------------------*/
            getAllFor: function () {
                this.forItems = this.contracts;
                this.forList= [];
                this.payToList= [];
                this.forItems.forEach(item=> {
                    this.forList.push(item.cSubject +' - ' + item.cLetterNumber + ' - ' + item.cLetterDate);
                    this.payToList.push(item.executor.eSubject);
                });
            },

            onForInputChange(forInput) {
                if (forInput.trim().length === 0) {
                    return null
                }
                // return the matching countries as an array
                return this.forList.filter((fors) => {
                    return fors.toLowerCase().includes(forInput.toLowerCase())
                })
            },
            onForSelected(item) {
                this.selectedFor = item
            },
            onSearchItemSelected(item) {
                this.selectedSearchItem = item
            },

            onPayToInputChange(PayToInput) {
                if (PayToInput.trim().length === 0) {
                    return null
                }
                // return the matching countries as an array
                return this.payToList.filter((payTOes) => {
                    return payTOes.toLowerCase().includes(PayToInput.toLowerCase())
                })
            },
            onForPayTOSelected(item) {
                this.selectedPayTo = item
            },
            onSearchItemSelected(item) {
                this.selectedSearchItem = item
            },

            /*-----------------------------------------------------------------------------
            ------------------ For Draft End ------------------------------
            -----------------------------------------------------------------------------*/

            calculateDraftAmount: function(){
                var baseAmount=0;
                var sumOfPrcents=0;
                var draftBaseAmountTemp=0;

                baseAmount=parseInt(this.draftInput.baseAmount.split(',').join(''),10);
                this.contracts.forEach(item => {
                    item.increase_amount.forEach(percent => {
                        sumOfPrcents += Math.round((baseAmount * percent.percentage_increase.piPercent) / 100);
                    });
                });
                draftBaseAmountTemp = baseAmount + sumOfPrcents;

                this.getSumOfLastDrafts();
                this.draftBaseAmount = draftBaseAmountTemp - this.lastDrafts;
                Math.round(this.draftBaseAmount);
                if(((this.draftBaseAmount + this.lastDrafts) > this.requestCAmount) || (this.draftBaseAmount < 0))
                    this.moneyState='block';
                else
                    this.moneyState='none';
            },

            getSumOfLastDrafts: function (){
                var lastDraftTemp=0;
                if(this.drafts != null){
                    this.drafts.forEach(item =>{
                        if (item.draft_state.dsState != 'BLOCKED')
                            lastDraftTemp += item.dAmount;
                    });
                }
                this.lastDrafts = lastDraftTemp;
            },

            setInitBaseAmount: function (){
                this.getSumOfLastDrafts();
                this.getBaseAmount();
                this.draftInput.baseAmount= this.$root.dispMoneyFormat(this.payAmount);
                this.calculateDraftAmount();

            },

            getBaseAmount: function(){
                this.contracts.forEach(item =>{
                    this.requestBaseAmount += item.cBaseAmount;
                    this.requestCAmount += item.cAmount;
                });
            },

            openInsertDraftModal:function () {
                if(this.rCommitmentAmount != this.rAcceptedAmount){
                    this.dialogMessage = 'تامین اعتبار به درستی انجام نشده است!';
                    this.showDialogModal = true;
                }
                else{
                    if (this.prDrafts.length == 0)
                    {
                        this.getDirectorGeneralUsers();
                        this.draftBaseAmount = 0;
                        this.lastDrafts = 0;
                        this.initBaseAmount = 0;
                        this.requestBaseAmount = 0;
                        this.requestCAmount = 0;
                        this.forItems = [];
                        this.getAllFor();
                        this.draftInput = {};
                        this.setInitBaseAmount();
                        this.showInsertDraftModal = true;
                    }else {
                        this.dialogMessage = 'امکان تهیه پیشنویس حواله وجود ندارد، برای این درخواست، قبلا حواله ثبت شده است.';
                        this.showDialogModal = true;
                    }
                }
            },

            addNewDraft:function () {
                this.$validator.validateAll().then((result) => {
                    if (result) {
                        if(((this.draftBaseAmount + this.lastDrafts) > this.requestCAmount) || (this.draftBaseAmount < 0)) {
                            this.dialogMessage = 'مبلغ  صورت وضعیت نامعتبر است!';
                            this.showDialogModal = true;
                        }

                        else{
                            axios.post('financial/draft/register', {
                                rId: this.requestId,
                                prId: this.payRequestId,
                                for: this.draftInput.for,
                                payTo: this.draftInput.payTo,
                                baseAmount: parseInt(this.draftInput.baseAmount.split(',').join(''),10),
                                amount: this.draftBaseAmount,
                                verifierId: this.draftInput.verifierId
                            }).then((response) => {
                                this.$emit('updateReceiveRequestData' , response.data , this.requestId);
                                this.$emit('closeModal');
                                this.showInsertDraftModal = false;
                                this.$root.displayNotif(response.status);
                                console.log(response);
                            }, (error) => {
                                console.log(error);
                                this.$root.displayNotif(error.response.status);
                            });
                        }
                    }
                });
            },

        }
    }
</script>
