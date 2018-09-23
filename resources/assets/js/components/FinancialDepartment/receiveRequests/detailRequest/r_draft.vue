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
                        <col width="300px"/>
                        <col width="150px"/>
                        <col width="300px"/>
                        <col width="150px"/>
                        <col width="60px"/>
                        <col width="12px"/>
                    </colgroup>
                    <tbody class="tbl-head-style ">
                    <tr class="tbl-head-style-cell">
                        <th class="tbl-head-style-cell">عنوان</th>
                        <th class="tbl-head-style-cell">مبلغ</th>
                        <th class="tbl-head-style-cell">شرح</th>
                        <th class="tbl-head-style-cell">وضعیت</th>
                        <th class="tbl-head-style-cell">عملیات</th>
                        <th class="tbl-head-style-cell"></th>
                    </tr>
                    </tbody>
                    <!--Table Head End-->
                    <!--Table Body Start-->
                </table>
                <div class="tbl_body_style dynamic-height-level-modal2">
                    <table class="tbl-body-contain">
                        <colgroup>
                            <col width="300px"/>
                            <col width="150px"/>
                            <col width="300px"/>
                            <col width="150px"/>
                            <col width="60px"/>
                        </colgroup>
                        <tbody class="tbl-head-style-cell">
                        <tr class="table-row" v-for="factor in factors">
                            <td>{{factor.fSubject}}</td>
                            <td class="text-center">{{$root.dispMoneyFormat(factor.fAmount)}}</td>
                            <td class="text-center">{{factor.fDescription}}</td>
                            <td class="text-center" v-show="factor.fIsAccepted == 1"><span class="success-label">تایید شده</span></td>
                            <td class="text-center" v-show="factor.fIsAccepted == 0"><span class="reserved-label">تایید نشده</span></td>
                            <td class="text-center"><a @click="openConfirmDeleteContract(factor.id)"><i class="far fa-trash-alt size-21 btn-red"></i></a></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <!--Table Body End-->
            <div class="large-12 medium-12 small-12" v-if='$can("SUPPLIER_ACCEPT_FACTOR")'>
                <div class="stacked-for-small button-group float-left">
                    <button @click="checkAcceptFactor()"  class="my-button my-success float-left"><span class="btn-txt-mrg">تایید اطلاعات فاکتور</span></button>
                </div>
            </div>
        </div>

        <!--Insert Factor Start-->
        <modal-small v-if="showInsertDraftModal" @close="showInsertDraftModal = false">
            <div  slot="body">
                <form v-on:submit.prevent="createDraft" >
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
                                                <select name="verifierUser" v-validate data-vv-rules="required" :class="{'input': true, 'select-error': errors.has('verifierUser')}">
                                                    <option value=""></option>
                                                    <option v-for="user in directorGeneralUsers" :value="user.id">{{user.name}} - {{user.role.rSubject}}</option>
                                                </select>
                                                <p v-show="errors.has('verifierUser')" class="error-font">لطفا امضا کننده را انتخاب کنید!</p>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <!--Tab 1-->
                                <!--Tab 1-->
                                <div class="tabs-panel table-mrg-btm" id="drafTab">
                                    <div class="grid-x">
                                        <div class="large-12 medium-12 small-12 padding-lr">
                                            <label>بابت
                                                <suggestions style="margin-bottom: -18px;" name="forTitle" v-validate :class="{'input': true, 'select-error': errors.has('forTitle')}"
                                                             v-model="DraftInput.for"
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
                                                <suggestions style="margin-bottom: -18px;" name="payToTitle" v-validate :class="{'input': true, 'select-error': errors.has('payToTitle')}"
                                                             v-model="DraftInput.payTo"
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
                                                <money @change.native="calculteBaseAmount()" v-model="DraftInput.baseAmount"  v-bind="money" class="form-input input-lg text-margin-btm"  v-validate="'required'" :class="{'input': true, 'error-border': errors.has('baseAmount')}"></money>
                                            </label>
                                            <p v-show="errors.has('baseAmount')" class="error-font">لطفا مبلغ صورت وضعیت مورد نظر را وارد نمایید!</p>
                                        </div>
                                    </div>
                                </div>
                                <!--Tab 1-->
                            </div>
                        </div>
                        <div class="grid-x small-top-m">
                            <div class="large-12 medium-12 small-12 padding-lr">
                                <div class="stacked-for-small button-group float-left">
                                    <button @click="addNewFactor" class="my-button my-success float-left"><span class="btn-txt-mrg">  ثبت </span></button>
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
    </div>
</template>
<script>
    import Suggestions from "v-suggestions/src/Suggestions";
    export default{
        props:['drafts','requestId','rAcceptedAmount','rCommitmentAmount','contracts'],
        components: {
            Suggestions,
        },
        data () {
            return {
                showInsertDraftModal:false,
                showAcceptConfirmModal: false,
                showDeleteConfirmModal: false,
                showDialogModal: false,
                dialogMessage: '',
                DraftInput:{},
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
                commitmentAmount:0,
                draftBaseAmount:0,

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

            checkAcceptFactor: function(){
                var existNotAccepted = false;
                this.factors.forEach(item => {
                    if (item.fIsAccepted == false)
                        existNotAccepted = true;
                });

                if (existNotAccepted)
                {
                    this.showAcceptConfirmModal = true;
                }else{
                    this.dialogMessage = 'فاکتور تایید نشده ای موجود نیست! لطفا قبل از تایید اطلاعات قرارداد نسبت به ثبت فاکتور جدید اقدام کنید.';
                    this.showDialogModal = true;
                }
            },

            openConfirmDeleteContract: function(cId){
                this.fIdForDelete = cId;
                this.showDeleteConfirmModal = true;
            },

            acceptFactor: function(){
                axios.post('/financial/request/factor/accept', {
                    rId: this.requestId,
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
                    this.forItems=[];
                    this.getAllFor();
                    this.DraftInput = {};
                    this.showInsertDraftModal = true;
                }
            },

            addNewFactor:function () {
                this.$validator.validateAll().then((result) => {
                    if (result) {
                        axios.post('/financial/request/factor/insert', {
                            refundCostsId: this.refundId,
                            rId: this.requestId,
                            subject: this.factorInput.subject,
                            seller: this.factorInput.seller,
                            amount: parseInt(this.factorInput.amount.split(',').join(''),10),
                            description: this.factorInput.description,
                        }).then((response) => {
                            this.$emit('updateReceiveRequestData' , response.data , this.requestId);
                            this.showInsertFactorModal = false;
                            this.$root.displayNotif(response.status);
                            console.log(response);
                        }, (error) => {
                            console.log(error);
                            this.$root.displayNotif(error.response.status);
                        });
                    }
                });
            },
        }
    }
</script>
