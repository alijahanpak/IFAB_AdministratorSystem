<template xmlns:v-on="http://www.w3.org/1999/xhtml">
    <div class="grid-x">
        <div v-show="$can('REGISTER_FACTOR_IN_REFUND')" class="large-12 medium-12 small-12">
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
                        <col width="12px"/>
                    </colgroup>
                    <tbody class="tbl-head-style ">
                    <tr class="tbl-head-style-cell">
                        <th class="tbl-head-style-cell">عنوان</th>
                        <th class="tbl-head-style-cell">مبلغ</th>
                        <th class="tbl-head-style-cell">شرح</th>
                        <th class="tbl-head-style-cell">وضعیت</th>
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
                            <col width="300px"/>
                            <col width="150px"/>
                        </colgroup>
                        <tbody class="tbl-head-style-cell">
                        <tr v-for="factor in request.factor">
                            <td>{{factor.fSubject}}</td>
                            <td class="text-center">{{$root.dispMoneyFormat(factor.fAmount)}}</td>
                            <td class="text-center">{{factor.fDescription}}</td>
                            <td class="text-center">
                                <div class="grid-x">
                                    <div class="medium-11">
                                        <span v-show="factor.factor_state.fsState == 'PENDING_REVIEW'" class="reserved-label">{{ factor.factor_state.fsSubject }}</span>
                                        <span v-show="factor.factor_state.fsState == 'NOT_ACCEPTED'" class="blocked-label">{{ factor.factor_state.fsSubject }}</span>
                                        <span v-show="factor.factor_state.fsState == 'ACCEPTED'" class="success-label">{{ factor.factor_state.fsSubject }}</span>
                                        <span v-show="factor.factor_state.fsState == 'TEMPORARY'" class="danger-label">{{ factor.factor_state.fsSubject }}</span>
                                    </div>
                                    <div class="medium-1 cell-vertical-center text-left" v-show="($can('SUPPLIER_DELETE_FACTOR') || $can('SUPPLIER_UPDATE_FACTOR')) && factor.factor_state.fsState == 'TEMPORARY'">
                                        <a class="dropdown small sm-btn-align" :data-toggle="'factorMenu' + factor.id"><i class="fa fa-ellipsis-v size-18"></i></a>
                                        <div class="dropdown-pane dropdown-pane-sm " data-close-on-click="true"  data-hover="true" data-hover-pane="true"  data-position="bottom" data-alignment="left" :id="'factorMenu' + factor.id" data-dropdown data-auto-focus="true">
                                            <ul class="my-menu small-font text-right">
                                                <li v-show="$can('SUPPLIER_UPDATE_FACTOR')"><a v-on:click.prevent="openUpdateFactorModal(factor)"><i class="fa fa-pencil-square-o size-16"></i>  ویرایش</a></li>
                                                <li v-show="$can('SUPPLIER_DELETE_FACTOR')"><a @click="openConfirmDeleteFactor(factor.id)"><i class="fa fa-trash-o size-16"></i>  حذف</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr v-for="refundFactor in request.refund_factor">
                            <td>{{refundFactor.factor.fSubject + ' - '}}<span class="btn-red">درخواست خرید کالا</span></td>
                            <td class="text-center">{{$root.dispMoneyFormat(refundFactor.factor.fAmount)}}</td>
                            <td class="text-center">{{refundFactor.factor.fDescription}}</td>
                            <td class="text-center">
                                <div class="grid-x">
                                    <div class="medium-11">
                                        <span v-show="refundFactor.factor.factor_state.fsState == 'PENDING_REVIEW'" class="reserved-label">{{ refundFactor.factor.factor_state.fsSubject }}</span>
                                        <span v-show="refundFactor.factor.factor_state.fsState == 'NOT_ACCEPTED'" class="blocked-label">{{ refundFactor.factor.factor_state.fsSubject }}</span>
                                        <span v-show="refundFactor.factor.factor_state.fsState == 'ACCEPTED'" class="success-label">{{ refundFactor.factor.factor_state.fsSubject }}</span>
                                        <span v-show="refundFactor.factor.factor_state.fsState == 'TEMPORARY'" class="danger-label">{{ refundFactor.factor.factor_state.fsSubject }}</span>
                                    </div>
                                    <div class="medium-1 cell-vertical-center text-left"></div>
                                </div>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <!--Table Body End-->
            <div class="large-12 medium-12 small-12" v-show='$can("SUPPLIER_ACCEPT_FACTOR")'>
                <div class="stacked-for-small button-group float-left">
                    <button @click="checkAcceptFactor()"  class="my-button my-success float-left"><span class="btn-txt-mrg">درخواست بررسی</span></button>
                </div>
            </div>
        </div>

        <!--Insert Factor Start-->
        <modal-small v-if="showInsertFactorModal" @close="showInsertFactorModal = false">
            <div  slot="body">
                <form v-on:submit.prevent="addNewFactor" >
                    <div class="small-font">
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
                                <label>فروشنده
                                    <suggestions style="margin-bottom: -18px;" autocomplete="off" name="sellerTitle" v-validate :class="{'input': true, 'select-error': errors.has('sellerTitle')}"
                                                 v-model="factorInput.seller"
                                                 :options="sellerList"
                                                 :onInputChange="onSellerInputChange">
                                        <div slot="item" slot-scope="props" class="single-item">
                                            <strong>{{props.item}}</strong>
                                        </div>
                                    </suggestions>
                                </label>
                            </div>
                            <div class="large-6 medium-6 small-12 padding-lr">
                                <label>مبلغ<span class="btn-red">(ریال)</span>
                                    <money v-if="moneyState== 'none'" @keyup.native="calculateRemainingAmount(factorInput.amount)" v-model="factorInput.amount"  v-bind="money" class="form-input input-lg text-margin-btm"  v-validate="'required'" :class="{'input': true, 'error-border': errors.has('factorAmount')}"></money>
                                    <money v-if="moneyState== 'block'" @keyup.native="calculateRemainingAmount(factorInput.amount)" v-model="factorInput.amount"  v-bind="money" class="form-input input-lg text-margin-btm select-error"  v-validate="'required'" :class="{'input': true, 'error-border': errors.has('factorAmount')}"></money>
                                </label>
                                <p style="margin-top: 10px;" v-show="moneyState== 'block'" class="btn-red">مبلغ فاکتور فراموش شده / نامعتبر است!</p>
                            </div>
                        </div>
                        <div class="grid-x">
                            <div class="large-12 medium-12 small-12 padding-lr">
                                <div class="grid-x panel-separator">
                                    <div class="medium-12 ">
                                        <span class="btn-red">مبلغ تنخواه:</span><span>{{ ' ' + $root.dispMoneyFormat(request.rAcceptedAmount) + 'ریال'}}</span>
                                    </div>
                                    <div class="medium-12">
                                        <span class="btn-red">مجموع فاکتور های ثبت شده:</span><span>{{ ' ' + $root.dispMoneyFormat(factorInput.sumOfFactorAmount) + ' ریال'}}</span>
                                    </div>
                                    <div class="medium-12">
                                        <span class="btn-red">باقیمانده (با در نظر گرفتن مبلغ این فاکتور):</span><span>{{ ' ' + $root.dispMoneyFormat(refundRemainingAmount) + ' ریال'}}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div style="margin-top: 16px;" class="grid-x">
                            <div class="large-12 medium-12 small-12 padding-lr">
                                <label>شرح
                                    <textarea style="min-height: 150px;" name="factorDescription" v-model="factorInput.description" v-validate="'required'" :class="{'input': true, 'error-border': errors.has('factorDescription')}"></textarea>
                                    <p v-show="errors.has('factorDescription')" class="error-font">لطفا شرح کامل فاکتور را وارد کنید!</p>
                                </label>
                            </div>
                        </div>
                        <div class="grid-x">
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
        <!--update Factor Start-->
        <modal-small v-if="showUpdateFactorModal" @close="showUpdateFactorModal = false">
            <div  slot="body">
                <form v-on:submit.prevent="updateFactor" >
                    <div class="small-font">
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
                                <label>فروشنده
                                    <suggestions autocomplete="off" style="margin-bottom: -18px;" name="sellerTitle" v-validate :class="{'input': true, 'select-error': errors.has('sellerTitle')}"
                                                 v-model="factorInput.seller"
                                                 :options="sellerList"
                                                 :onInputChange="onSellerInputChange">
                                        <div slot="item" slot-scope="props" class="single-item">
                                            <strong>{{props.item}}</strong>
                                        </div>
                                    </suggestions>
                                </label>
                            </div>
                            <div class="large-6 medium-6 small-12 padding-lr">
                                <label>مبلغ<span class="btn-red">(ریال)</span>
                                    <money v-if="moneyState== 'none'" @keyup.native="calculateRemainingAmount(factorInput.amount , factorInput.baseAmount)" v-model="factorInput.amount"  v-bind="money" class="form-input input-lg text-margin-btm"  v-validate="'required'" :class="{'input': true, 'error-border': errors.has('factorAmount')}"></money>
                                    <money v-if="moneyState== 'block'" @keyup.native="calculateRemainingAmount(factorInput.amount , factorInput.baseAmount)" v-model="factorInput.amount"  v-bind="money" class="form-input input-lg text-margin-btm select-error"  v-validate="'required'" :class="{'input': true, 'error-border': errors.has('factorAmount')}"></money>
                                </label>
                                <p style="margin-top: 10px;" v-show="moneyState== 'block'" class="btn-red">مبلغ فاکتور فراموش شده / نامعتبر است!</p>
                            </div>
                        </div>
                        <div class="grid-x">
                            <div class="large-12 medium-12 small-12 padding-lr">
                                <div class="grid-x panel-separator">
                                    <div class="medium-12 ">
                                        <span class="btn-red">مبلغ تنخواه:</span><span>{{ ' ' + $root.dispMoneyFormat(request.rAcceptedAmount) + 'ریال'}}</span>
                                    </div>
                                    <div class="medium-12">
                                        <span class="btn-red">مجموع فاکتور های ثبت شده (به استثنای فاکتور انتخاب شده):</span><span>{{ ' ' + $root.dispMoneyFormat(factorInput.sumOfFactorAmount) + ' ریال'}}</span>
                                    </div>
                                    <div class="medium-12">
                                        <span class="btn-red">باقیمانده:</span><span>{{ ' ' + $root.dispMoneyFormat(refundRemainingAmount) + ' ریال'}}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div style="margin-top: 16px;" class="grid-x">
                            <div class="large-12 medium-12 small-12 padding-lr">
                                <label>شرح
                                    <textarea style="min-height: 150px;" name="factorDescription" v-model="factorInput.description" v-validate="'required'" :class="{'input': true, 'error-border': errors.has('factorDescription')}"></textarea>
                                    <p v-show="errors.has('factorDescription')" class="error-font">لطفا شرح کامل فاکتور را وارد کنید!</p>
                                </label>
                            </div>
                        </div>
                        <div class="grid-x">
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
        <!--update Factor End-->
        <messageDialog v-show="showDialogModal" @close="showDialogModal =false">
            {{dialogMessage}}
        </messageDialog>

        <!-- Accept Factor modal -->
        <modal-tiny v-if="showAcceptConfirmModal" @close="showAcceptConfirmModal = false">
            <div slot="body">
                <div class="small-font" xmlns:v-on="http://www.w3.org/1999/xhtml">
                    <p class="black-color text-justify" style="font-size: 1rem">کاربر گرامی:</p>
                    <p class="large-offset-1 modal-text">آیا برای ارسال درخواست بررسی اطمینان دارید؟</p>
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
                    <p style="font-size: 1rem">کاربر گرامی:</p>
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
        props:['factors','refundFactor','requestId','request' , 'searchValue'],
        components: {
            Suggestions,
        },
        data () {
            return {
                showInsertFactorModal:false,
                showUpdateFactorModal:false,
                showAcceptConfirmModal: false,
                showDeleteConfirmModal: false,
                showDialogModal: false,
                selectedFactorId: 0,
                dialogMessage: '',
                factorInput:{},
                refundId:'',
                money: {
                    thousands: ',',
                    precision: 0,
                    masked: true
                },
                //contract input text
                sellerItems:[],
                seller: '',
                sellerList: [],
                selectedSeller: null,
                //contract input text

                sumOfFactors:0,
                moneyState:'none',
                refundRemainingAmount: 0,

            }

        },

        created: function () {
            $(this.$el).foundation(); //WORKS!
            //this.getFactorDetail();
        },
        updated: function () {
            $(this.$el).foundation(); //WORKS!
            this.myResizeModal();
        },

        mounted: function () {

        },

/*        watch: {
            // whenever question changes, this function will run
            request: function (newQuestion, oldQuestion) {
                this.getFactorDetail();
            }
        },*/

        methods : {

            /*-----------------------------------------------------------------------------
           ------------------ Seller Executor Start ------------------------------
           -----------------------------------------------------------------------------*/
            getAllSeller: function () {
                axios.get('/financial/seller/fetchData')
                    .then((response) => {
                        this.sellerItems = response.data;
                        this.sellerList= [];
                        this.sellerItems.forEach(item=> {
                            this.sellerList.push(item.sSubject)
                        });
                        console.log(response);
                    }, (error) => {
                        console.log(error);
                    });
            },

            onSellerInputChange(sellerInput) {
                if (sellerInput.trim().length === 0) {
                    return null
                }
                // return the matching countries as an array
                return this.sellerList.filter((sellers) => {
                    return sellers.toLowerCase().includes(sellerInput.toLowerCase())
                })
            },

            onSellerSelected(item) {
                this.selectedSeller = item
            },

            onSearchItemSelected(item) {
                this.selectedSearchItem = item
            },

            /*-----------------------------------------------------------------------------
            ------------------ Seller Executor End ------------------------------
            -----------------------------------------------------------------------------*/
/*            getFactorDetail: function(){
                this.request.refund_factor.forEach(item => {
                    Vue.set(item.factor,"refundFactor",true);
                    Vue.set(item.factor,"factor_state","REFUNDFACTOR");
                    this.request.factor.push(item.factor);
                });
                console.log(JSON.stringify(this.request.factor));
            },*/

            checkAcceptFactor: function(){
                var existNotAccepted = false;
                this.request.factor.forEach(item => {
                    if (item.factor_state.fsState == 'TEMPORARY')
                        existNotAccepted = true;
                });

                if (existNotAccepted)
                {
                    this.showAcceptConfirmModal = true;
                }else{
                    this.dialogMessage = 'فاکتور تایید نشده ای موجود نیست! لطفا قبل از تایید اطلاعات فاکتور نسبت به ثبت فاکتور جدید اقدام کنید.';
                    this.showDialogModal = true;
                }
            },

            openConfirmDeleteFactor: function(cId){
                this.selectedFactorId = cId;
                this.showDeleteConfirmModal = true;
            },

            acceptFactor: function(){
                axios.post('/financial/refund/factor/check_request', {
                    rId: this.requestId,
                    searchValue: this.searchValue,
                    resultType: 'POSTED'
                }).then((response) => {
                    this.$emit('updateSubmissionData' , response.data);
                    this.$emit('closeModal');
                    this.showAcceptConfirmModal=false;
                    this.$root.displayNotif(response.status);
                    console.log(response);
                }, (error) => {
                    console.log(error);
                    this.$root.displayNotif(error.response.status);
                });
            },

            deleteFactor: function() {
                axios.post('/financial/refund/factor/delete', {
                    fId: this.selectedFactorId,
                    searchValue: this.searchValue
                }).then((response) => {
                    if (response.status == 200)
                        this.$emit('updateSubmissionData' , response.data);
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

            getSumOfAllFactorAmount: function(){
                var sumTemp=0;
                this.sumOfFactors=0;
                this.request.factor.forEach(item => {
                    if(item.factor_state.fsState != 'NOT_ACCEPTED')
                        sumTemp += item.fAmount;
                });

                this.request.refund_factor.forEach(item => {
                    if(item.factor.factor_state.fsState != 'NOT_ACCEPTED')
                        sumTemp += item.factor.fAmount;
                });

                this.sumOfFactors = sumTemp;
            },

            openInsertFactorModal:function () {
                this.getSumOfAllFactorAmount();
                if(this.sumOfFactors > this.request.rAcceptedAmount){
                    this.dialogMessage = 'مبلغ فاکتور نمیتواند از مبلغ تنخواه بیشتر باشد!';
                    this.showDialogModal = true;
                }
                else{
                    this.getAllSeller();
                    this.moneyState = 'none';
                    this.factorInput={};
                    this.factorInput.amount = '0';
                    this.calculateRemainingAmount(this.factorInput.amount);
                    this.factorInput.sumOfFactorAmount = this.sumOfFactors;
                    this.showInsertFactorModal=true;
                }
            },

            addNewFactor:function () {
                this.$validator.validateAll().then((result) => {
                    if (result) {
                        if ((parseInt(this.factorInput.amount.split(',').join(''),10) <= 0) || (this.refundRemainingAmount < 0))
                        {
                            this.moneyState = 'block';
                        }else {
                            this.moneyState = 'none';
                            axios.post('/financial/refund/factor/new', {
                                rId: this.requestId,
                                searchValue: this.searchValue,
                                subject: this.factorInput.subject,
                                seller: this.factorInput.seller,
                                amount: parseInt(this.factorInput.amount.split(',').join(''), 10),
                                description: this.factorInput.description,
                                resultType: 'POSTED'
                            }).then((response) => {
                                this.$emit('updateSubmissionData', response.data);
                                this.showInsertFactorModal = false;
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

            calculateRemainingAmount: function (inputValue = 0 , baseAmount = 0) {
                inputValue += ''; //for cast to string
                this.refundRemainingAmount = ((this.request.rAcceptedAmount - this.sumOfFactors) - parseInt(inputValue.split(',').join(''),10)) + baseAmount;
                if (this.refundRemainingAmount < 0)
                    this.moneyState = 'block';
                else
                    this.moneyState = 'none';
            },

            openUpdateFactorModal: function(factor){
                this.getAllSeller();
                this.getSumOfAllFactorAmount();
                this.moneyState = 'none';
                this.selectedFactorId = factor.id;
                this.factorInput.amount = factor.fAmount;
                this.factorInput.baseAmount = factor.fAmount;

                this.calculateRemainingAmount(factor.fAmount , factor.fAmount);
                this.factorInput.seller = factor.seller.sSubject;
                this.factorInput.subject = factor.fSubject;
                this.factorInput.description = factor.fDescription;
                this.factorInput.sumOfFactorAmount = this.sumOfFactors - parseInt(this.factorInput.amount,10);
                this.showUpdateFactorModal = true;
            },

            updateFactor: function () {
                this.$validator.validateAll().then((result) => {
                    if (result) {
                        if ((parseInt(this.factorInput.amount.split(',').join(''),10) <= 0) || (this.refundRemainingAmount < 0))
                        {
                            this.moneyState = 'block';
                        }else{
                            this.moneyState = 'none';
                            axios.post('/financial/request/factor/update', {
                                id: this.selectedFactorId,
                                searchValue: this.searchValue,
                                refundId: '',
                                subject: this.factorInput.subject,
                                seller: this.factorInput.seller,
                                amount: parseInt(this.factorInput.amount.split(',').join(''),10),
                                description: this.factorInput.description,
                                resultType: 'POSTED'
                            }).then((response) => {
                                this.$emit('updateSubmissionData' , response.data);
                                this.showUpdateFactorModal = false;
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
