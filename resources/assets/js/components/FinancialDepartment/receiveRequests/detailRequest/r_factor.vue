<template xmlns:v-on="http://www.w3.org/1999/xhtml">
    <div class="grid-x">
        <div v-if="$can('SUPPLIER_DELETE_FACTOR')" class="large-12 medium-12 small-12">
            <div class="clearfix tool-bar">
                <div class="button-group float-right report-mrg">
                    <a class="my-button toolbox-btn small" @click="openInsertFactorModal()">جدید</a>
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
                        <col v-if="$can('SUPPLIER_DELETE_FACTOR')" width="60px"/>
                        <col width="12px"/>
                    </colgroup>
                    <tbody class="tbl-head-style ">
                    <tr class="tbl-head-style-cell">
                        <th class="tbl-head-style-cell">عنوان</th>
                        <th class="tbl-head-style-cell">مبلغ</th>
                        <th class="tbl-head-style-cell">شرح</th>
                        <th class="tbl-head-style-cell">وضعیت</th>
                        <th v-if="$can('SUPPLIER_DELETE_FACTOR')" class="tbl-head-style-cell">عملیات</th>
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
                            <col v-if="$can('SUPPLIER_DELETE_FACTOR')" width="60px"/>
                        </colgroup>
                        <tbody class="tbl-head-style-cell">
                        <tr class="table-row" v-for="factor in factors">
                            <td>{{factor.fSubject}}</td>
                            <td class="text-center">{{$root.dispMoneyFormat(factor.fAmount)}}</td>
                            <td class="text-center">{{factor.fDescription}}</td>
                            <td class="text-center" v-show="factor.fIsAccepted == 1"><span class="success-label">تایید شده</span></td>
                            <td class="text-center" v-show="factor.fIsAccepted == 0"><span class="reserved-label">تایید نشده</span></td>
                            <td v-if="$can('SUPPLIER_DELETE_FACTOR')" class="text-center"><a @click="openConfirmDeleteContract(factor.id)"><i class="far fa-trash-alt size-21 btn-red"></i></a></td>
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
        <modal-small v-if="showInsertFactorModal" @close="showInsertFactorModal = false">
            <div  slot="body">
                <form v-on:submit.prevent="createFactor" >
                    <div class="small-font">
                        <div v-if="isFromRefundCosts == true" class="grid-x">
                            <div class="large-6 medium-6 small-12 padding-lr">
                                <label>تنخواه گردان
                                    <select class="form-element-margin-btm" v-model="refundId" name="selectRefunds" v-validate data-vv-rules="required" :class="{'input': true, 'select-error': errors.has('selectRefunds')}">
                                        <option value=""></option>
                                        <option v-for="refund in refunds" :value="refund.id">{{refund.rSubject}} - {{$root.dispMoneyFormat(refund.rCostEstimation)}} ریال</option>
                                    </select>
                                    <span v-show="errors.has('selectRefunds')" class="error-font">لطفا تنخواه گردان مورد نظر را انتخاب کنید!</span>
                                </label>
                            </div>
                        </div>
                        <div class="grid-x">
                            <div class="large-12 medium-12 small-12 padding-lr">
                                <label>عنوان
                                    <input type="text" name="factorSubject" v-model="factorInput.subject" v-validate="'required'" :class="{'input': true, 'error-border': errors.has('factorSubject')}">
                                </label>
                                <p v-show="errors.has('factorSubject')" class="error-font">لطفا عنوان را برای فاکتور مورد نظر را وارد نمایید!</p>
                            </div>
                        </div>
                        <div class="grid-x">
                            <div class="large-6 medium-6 small-12 padding-lr">
                                <label>مبلغ <span class="btn-red">(ریال)</span>
                                    <money v-model="factorInput.amount" name="factorAmount" v-bind="money" class="form-input input-lg text-margin-btm"  v-validate="'required'" :class="{'input': true, 'error-border': errors.has('factorAmount')}"></money>
                                </label>
                                <p v-show="errors.has('factorAmount')" class="error-font">لطفا مبلغ را برای فاکتور مورد نظر را وارد نمایید!</p>
                            </div>
                        </div>
                        <div style="margin-top: 16px;" class="grid-x">
                            <div class="large-12 medium-12 small-12 padding-lr">
                                <label>شرح
                                    <textarea style="min-height: 150px;" name="factorDescription" v-model="factorInput.description"   :class="{'input': true, 'error-border': errors.has('factorDescription')}"></textarea>
                                    <p v-show="errors.has('factorDescription')" class="error-font">لطفا شرح کامل فاکتور را وارد کنید!</p>
                                </label>
                            </div>
                        </div>
                        <div class="grid-x">
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

        <!-- accept Financing modal -->
        <modal-tiny v-if="showAcceptConfirmModal" @close="showAcceptConfirmModal = false">
            <div slot="body">
                <div class="small-font" xmlns:v-on="http://www.w3.org/1999/xhtml">
                    <p style="font-size: 1rem">کاربر گرامی:</p>
                    <p class="large-offset-1 modal-text">تایید اطلاعات قرارداد به منزله ایجاد تعهد در محل های تامین اعتبار است، آیا صحت اطلاعات را تایید می کنید؟</p>
                    <div class="grid-x">
                        <div class="medium-12 column text-center">
                            <button v-on:click="acceptFactor"   class="my-button my-success"><span class="btn-txt-mrg">   بله   </span></button>
                        </div>
                    </div>
                </div>
            </div>
        </modal-tiny>
        <!-- accept Financing modal -->

        <!-- accept Financing modal -->
        <modal-tiny v-if="showDeleteConfirmModal" @close="showDeleteConfirmModal = false">
            <div slot="body">
                <div class="small-font" xmlns:v-on="http://www.w3.org/1999/xhtml">
                    <p class="large-offset-1 modal-text">آیا مایل هستید قرارداد را حذف کنید؟</p>
                    <div class="grid-x">
                        <div class="medium-12 column text-center">
                            <button v-on:click="deleteFactor"   class="my-button my-success"><span class="btn-txt-mrg">   بله   </span></button>
                        </div>
                    </div>
                </div>
            </div>
        </modal-tiny>
        <!-- accept Financing modal -->
    </div>
</template>
<script>

    export default{
        props:['factors','requestId' , 'rCreditIsAccepted' , 'rCreditIsExist','isFromRefundCosts'],
        data () {
            return {
                showInsertFactorModal:false,
                showAcceptConfirmModal: false,
                showDeleteConfirmModal: false,
                showDialogModal: false,
                fIdForDelete: 0,
                dialogMessage: '',
                factorInput:{},
                refunds:[],
                refundId:'',
                money: {
                    thousands: ',',
                    precision: 0,
                    masked: true
                },
            }

        },

        created: function () {
            $(this.$el).foundation(); //WORKS!
        },
        updated: function () {
            $(this.$el).foundation(); //WORKS!
            this.myResizeModal();
        },

        mounted: function () {

        },

        methods : {
            getRefund: function () {
                axios.get('/financial/request/get_all_refund')
                    .then((response) => {
                        this.refunds = response.data;
                        console.log(response);
                    }, (error) => {
                        console.log(error);
                    });
            },
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
                this.cIdForDelete = cId;
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
                    cId: this.fIdForDelete,
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

            openInsertFactorModal:function () {
                if (this.rCreditIsExist == true)
                {
                    if (this.rCreditIsAccepted == false)
                    {
                        this.dialogMessage = 'تامین اعتبار تایید نهایی نشده است!';
                        this.showDialogModal = true;
                    }else{
                        this.getRefund();
                        this.showInsertFactorModal=true;
                    }

                }else{
                    this.dialogMessage = 'امکان ثبت فاکتور وجود ندارد. منابع تامین اعتبار برای این درخواست تعیین نشده است!';
                    this.showDialogModal = true;
                }

            },

            addNewFactor:function () {
                this.$validator.validateAll().then((result) => {
                    if (result) {
                        axios.post('/financial/request/factor/insert', {
                            refundCostsId: this.refundId,
                            rId: this.requestId,
                            subject: this.factorInput.subject,
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
