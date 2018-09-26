<template xmlns:v-on="http://www.w3.org/1999/xhtml">
    <div class="grid-x">
        <div class="large-12 medium-12 small-12" v-if="$can('FINANCIAL_ADD_NEW_DRAFT')">
            <div class="clearfix tool-bar">
                <div class="button-group float-right report-mrg">
                    <a class="my-button toolbox-btn small" @click="openInsertDraftModal()">جدید</a>
                </div>
            </div>
        </div>
        <div class="large-12 medium-12 small-12 small-top-m">
            <!--Table Start-->
            <!--Table Head Start-->
            <div class="tbl-div-container">
                <table class="tbl-head">
                    <colgroup>
                        <col width="450px"/>
                        <col width="200px"/>
                        <col width="150px"/>
                        <col width="150px"/>
                        <col width="100px"/>
                        <col width="12px"/>
                    </colgroup>
                    <tbody class="tbl-head-style ">
                    <tr class="tbl-head-style-cell">
                        <th class="tbl-head-style-cell">بابت</th>
                        <th class="tbl-head-style-cell">در وجه</th>
                        <th class="tbl-head-style-cell">مبلغ صورت وضعیت</th>
                        <th class="tbl-head-style-cell">مبلغ حواله</th>
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
                            <col width="450px"/>
                            <col width="200px"/>
                            <col width="150px"/>
                            <col width="150px"/>
                            <col width="100px"/>
                        </colgroup>
                        <tbody class="tbl-head-style-cell">
                        <tr @click="openPdfModal(draft)" class="table-row" v-for="draft in drafts">
                            <template v-for="draftState in draft.verifier">
                                <td>{{draft.dFor}}</td>
                                <td>{{draft.dPayTo}}</td>
                                <td class="text-center">{{$root.dispMoneyFormat(draft.dBaseAmount)}}</td>
                                <td class="text-center">{{$root.dispMoneyFormat(draft.dAmount)}}</td>
                                <td v-show="draftState.dvSId != null"><span class="success-label">امضا شده</span></td>
                                <td v-show="draftState.dvSId == null"><span class="reserved-label">امضا نشده</span></td>
                            </template>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <!--Table Body End-->
        </div>

        <!--Insert Factor Start-->
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
                                                <suggestions autocomplete="off" style="margin-bottom: -18px;" name="forTitle" v-validate :class="{'input': true, 'select-error': errors.has('forTitle')}"
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
                                                <suggestions autocomplete="off" style="margin-bottom: -18px;" name="payToTitle" v-validate :class="{'input': true, 'select-error': errors.has('payToTitle')}"
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
                                            <label>مبلغ صورت وضعیت<span class="btn-red">(ریال)</span>
                                                <money v-if="moneyState== 'none'" @change.native="calculateDraftAmount()" v-model="draftInput.baseAmount"  v-bind="money" class="form-input input-lg text-margin-btm"  v-validate="'required'" :class="{'input': true, 'error-border': errors.has('baseAmount')}"></money>
                                                <money v-if="moneyState== 'block'" @change.native="calculateDraftAmount()" v-model="draftInput.baseAmount"  v-bind="money" class="form-input input-lg text-margin-btm select-error"  v-validate="'required'" :class="{'input': true, 'error-border': errors.has('baseAmount')}"></money>
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
        <!--Insert Factor End-->
        <messageDialog v-show="showDialogModal" @close="showDialogModal =false">
            {{dialogMessage}}
        </messageDialog>

        <!-- Accept Factor modal -->
        <modal-tiny v-if="showAcceptConfirmModal" @close="showAcceptConfirmModal = false">
            <div slot="body">
                <div class="small-font" xmlns:v-on="http://www.w3.org/1999/xhtml">
                    <p class="black-color text-justify" style="font-size: 1rem">کاربر گرامی:</p>
                    <p class="large-offset-1 modal-text">تایید اطلاعات فاکتور به منزله ایجاد تعهد در محل های تامین اعتبار است، آیا صحت اطلاعات را تایید می کنید؟</p>
                    <div class="grid-x">
                        <div class="medium-12 column text-center">
                            <button v-on:click="acceptFactor"   class="my-button my-success"><span class="btn-txt-mrg">   بله   </span></button>
                        </div>
                    </div>
                </div>
            </div>
        </modal-tiny>
        <!-- Accept Factor modal -->

        <!-- Delete Factor modal -->
        <modal-tiny v-if="showDeleteConfirmModal" @close="showDeleteConfirmModal = false">
            <div slot="body">
                <div class="small-font" xmlns:v-on="http://www.w3.org/1999/xhtml">
                    <p class="large-offset-1 modal-text">آیا مایل هستید فاکتور را حذف کنید؟</p>
                    <div class="grid-x">
                        <div class="medium-12 column text-center">
                            <button v-on:click="deleteFactor"   class="my-button my-success"><span class="btn-txt-mrg">   بله   </span></button>
                        </div>
                    </div>
                </div>
            </div>
        </modal-tiny>
        <!-- Delete Factor modal -->

        <!-- pdf  modal -->
        <modal-small v-if="showPdfModal" @close="showPdfModal = false">
            <div style="height: 90vh;" slot="body">
                <div class="grid-x">
                    <div class="large-12">
                        <embed style="width: 100%;height: 80vh;" :src="draftPdfPath" />
                    </div>
                </div>
                <div class="grid-x">
                    <div style="padding: 0 17px 0 17px;" class="large-12 medium-12 small-12 small-top-m">
                        <div class="stacked-for-small button-group float-left">
                            <button v-if="$can('FINANCIAL_REGISTER_AND_NUMBERING_DRAFT')" @click="openRegisterAndNumberingModal()"  class="my-button my-success"><span class="btn-txt-mrg">   ثبت در دبیرخانه   </span></button>
                            <button v-if="$can('FINANCIAL_ACCEPT_DRAFT') && drafts.dYouAreVerifier" @click="acceptDraft()"  class="my-button my-success"><span class="btn-txt-mrg">   تایید و امضا   </span></button>
                            <button v-if="$can('FINANCIAL_ACCEPT_MINUTE_DRAFT')" @click="acceptDraftMinute()"  class="my-button my-success"><span class="btn-txt-mrg">   تایید پیشنویس   </span></button>
                        </div>
                    </div>
                </div>
            </div>
        </modal-small>
        <!-- pdf Factor modal -->

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
                            <button @click="registerAndNumberingDraft()"  class="my-button my-success btn-for-load"><span class="btn-txt-mrg">  ثبت</span></button>
                        </div>
                    </div>
                </div>
            </div>
        </modal-tiny>
        <!-- Register And Numbering Draft End -->


    </div>
</template>
<script>
    import Suggestions from "v-suggestions/src/Suggestions";
    export default{
        props:['drafts','requestId','rAcceptedAmount','rCommitmentAmount','contracts','requestType'],
        components: {
            Suggestions,
        },
        data () {
            return {
                showInsertDraftModal:false,
                showAcceptConfirmModal: false,
                showDeleteConfirmModal: false,
                showRegisterAndNumberingModal:false,
                showPdfModal: false,
                showDialogModal: false,
                dialogMessage: '',
                draftInput:{},
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
                draftId:'',
                draftPdfPath:'',
                registerDate: '',
                letterNumber: '',
                moneyState:'none',

            }

        },

        created: function () {
            $(this.$el).foundation(); //WORKS!
            this.getDirectorGeneralUsers();
        },
        updated: function () {
            $(this.$el).foundation(); //WORKS!
            this.myResizeModal();
        },

        mounted: function () {

        },

        methods : {

            openPdfModal: function (draft){
              this.draftId=draft.id;
              this.openReportFile();
              this.draftPdfPath='';
              this.showPdfModal=true;
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

                this.contracts.forEach(item =>{
                    item.increase_amount.forEach(percent =>{
                        sumOfPrcents += (baseAmount * (percent.percentage_increase.piPercent /100));
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
                this.drafts.forEach(item =>{
                    lastDraftTemp += item.dAmount;
                });
                this.lastDrafts=lastDraftTemp;
            },

            setInitBaseAmount: function (){
                this.getSumOfLastDrafts();
                this.getBaseAmount();
                this.draftInput.baseAmount= this.$root.dispMoneyFormat(this.requestBaseAmount);
                this.calculateDraftAmount();

            },

            getBaseAmount: function(){
                if(this.requestType == 'BUY_SERVICES'){
                    this.contracts.forEach(item =>{
                        this.requestBaseAmount += item.cBaseAmount;
                        this.requestCAmount += item.cAmount;
                    });
                }
                if(this.requestType == 'BUY_COMMODITY'){

                }
                if(this.requestType == 'FUND'){

                }
            },

            openReportFile: function () {
                axios.post('/financial/report/draft' , {dId: this.draftId})
                    .then((response) => {
                        console.log(response.data);
                        this.draftPdfPath=response.data;
                    },(error) => {
                        console.log(error);
                    });
            },

            checkAcceptDraft: function(){
                var existNotAccepted = false;
                this.factors.forEach(item => {
                    if (item.fIsAccepted == false)
                        existNotAccepted = true;
                });

                if (existNotAccepted)
                {
                    this.showAcceptConfirmModal = true;
                }else{
                    this.dialogMessage = 'حواله تایید نشده ای موجود نیست! لطفا قبل از تایید اطلاعات حواله نسبت به ثبت حواله جدید اقدام کنید.';
                    this.showDialogModal = true;
                }
            },

            openConfirmDeleteContract: function(cId){
                this.fIdForDelete = cId;
                this.showDeleteConfirmModal = true;
            },

            acceptDraft: function(){
                axios.post('/financial/draft/accept', {
                    rId: this.requestId,
                    dId:this.draftId
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

            deleteFactor: function() {
                axios.post('/financial/request/factor/delete', {
                    rId: this.requestId,
                    fId: this.fIdForDelete,
                }).then((response) => {
                    if (response.status == 200)
                        this.$emit('updateReceiveRequestData' , response.data , this.requestId);
                    this.showDeleteConfirmModal = false;
                    this.$root.displayNotif(response.status);
                    console.log(response);
                }, (error) => {
                    console.log(error);
                    this.$root.displayNotif(error.response.status);
                });
            },

            myResizeModal: function() {
                var x = $.w.outerHeight();
                $('.dynamic-height-level-modal1').css('height', (x-320) + 'px');
                $('.dynamic-height-level-modal2').css('height', (x-460) + 'px');
                $('.dynamic-height-level-modal3').css('height', (x-580) + 'px');
            },

            openInsertDraftModal:function () {
                if(this.rCommitmentAmount != this.rAcceptedAmount){
                    this.dialogMessage = 'تامین اعتبار به درستی انجام نشده است!';
                    this.showDialogModal = true;
                }
                else{
                    this.draftBaseAmount=0,
                    this.lastDrafts=0,
                    this.initBaseAmount=0,
                    this.requestBaseAmount=0,
                    this.requestCAmount=0,
                    this.forItems=[];
                    this.getAllFor();
                    this.draftInput = {};
                    this.setInitBaseAmount();
                    this.showInsertDraftModal = true;
                }
            },

            addNewDraft:function () {
                this.$validator.validateAll().then((result) => {
                    if (result) {
                        if(((this.draftBaseAmount + this.lastDrafts) > this.requestCAmount) || (this.draftBaseAmount < 0)){
                            this.dialogMessage = 'مبلغ  صورت وضعیت نامعتبر است!';
                            this.showDialogModal = true;
                        }
                        else{
                            axios.post('financial/draft/register', {
                                rId: this.requestId,
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

            openRegisterAndNumberingModal:function(){
                this.showRegisterAndNumberingModal=true;
            },

            registerAndNumberingDraft:function () {
                axios.post('/financial/draft/numbering', {
                    rId: this.requestId,
                    dId:this.draftId,
                    letterDate: this.registerDate,
                    letterNumber: this.letterNumber
                }).then((response) => {
                    this.$emit('updateReceiveRequestData' , response.data , this.requestId);
                    this.$emit('closeModal');
                    this.showRegisterAndNumberingModal = false;
                    this.$root.displayNotif(error.response.status);
                    console.log(response);
                }, (error) => {
                    console.log(error);
                    this.$root.displayNotif(error.response.status);
                });
            },

        }
    }
</script>
