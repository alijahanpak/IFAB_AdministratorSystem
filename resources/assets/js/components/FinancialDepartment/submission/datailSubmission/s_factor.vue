<template xmlns:v-on="http://www.w3.org/1999/xhtml">
    <div class="grid-x">
        <div v-show="$can('SUPPLIER_DELETE_FACTOR')" class="large-12 medium-12 small-12">
            <div class="clearfix tool-bar">
                <div class="button-group float-right report-mrg">
                    <a class="my-button toolbox-btn small" @click="openInsertFactorModal()">جدید</a>
                </div>
            </div>
        </div>
        <div class="large-12 medium-12 small-12 small-top-m">
            <!--Table Start-->
            <!--Table Head Start-->
            <div style="height: 43vh;" class="tbl-div-container inner-vh-unsize">
                <table class="tbl-head">
                    <colgroup>
                        <col width="300px"/>
                        <col width="150px"/>
                        <col width="300px"/>
                        <col width="150px"/>
                        <col v-show="$can('SUPPLIER_DELETE_FACTOR')" width="60px"/>
                        <col width="12px"/>
                    </colgroup>
                    <tbody class="tbl-head-style ">
                    <tr class="tbl-head-style-cell">
                        <th class="tbl-head-style-cell">عنوان</th>
                        <th class="tbl-head-style-cell">مبلغ</th>
                        <th class="tbl-head-style-cell">شرح</th>
                        <th class="tbl-head-style-cell">وضعیت</th>
                        <th v-show="$can('SUPPLIER_DELETE_FACTOR')" class="tbl-head-style-cell">عملیات</th>
                        <th class="tbl-head-style-cell"></th>
                    </tr>
                    </tbody>
                    <!--Table Head End-->
                    <!--Table Body Start-->
                </table>
                <div class="tbl_body_style inner-vh-2">
                    <table class="tbl-body-contain">
                        <colgroup>
                            <col width="300px"/>
                            <col width="150px"/>
                            <col width="300px"/>
                            <col width="150px"/>
                            <col v-show="$can('SUPPLIER_DELETE_FACTOR')" width="60px"/>
                        </colgroup>
                        <tbody class="tbl-head-style-cell">
                        <tr class="table-row" v-for="factor in data.factor">
                            <td>{{factor.fSubject}}</td>
                            <td class="text-center">{{$root.dispMoneyFormat(factor.fAmount)}}</td>
                            <td class="text-center">{{factor.fDescription}}</td>
                            <td class="text-center" v-show="factor.factor_state.fsState == 'TEMPORARY'"><span class="danger-label">{{ factor.factor_state.fsSubject }}</span></td>
                            <td class="text-center" v-show="factor.factor_state.fsState == 'PENDING_REVIEW'"><span class="reserved-label">{{ factor.factor_state.fsSubject }}</span></td>
                            <td class="text-center" v-show="factor.factor_state.fsState == 'NOT_ACCEPTED'"><span class="blocked-label">{{ factor.factor_state.fsSubject }}</span></td>
                            <td class="text-center" v-show="factor.factor_state.fsState == 'ACCEPTED'"><span class="success-label">{{ factor.factor_state.fsSubject }}</span></td>
                            <td class="text-center" v-show="factor.factor_state == 'REFUNDFACTOR'"><span class="success-label">درخواست خرید کالا</span></td>
                            <td v-show="$can('SUPPLIER_DELETE_FACTOR')" class="text-center"><a @click="openConfirmDeleteContract(factor.id)"><i class="far fa-trash-alt size-21 btn-red"></i></a></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <!--Table Body End-->
            <div class="large-12 medium-12 small-12" v-show='$can("SUPPLIER_ACCEPT_FACTOR")'>
                <div class="stacked-for-small button-group float-left">
                    <button @click="checkAcceptFactor()"  class="my-button my-success float-left"><span class="btn-txt-mrg">تایید اطلاعات فاکتور</span></button>
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
                            <div class="large-12 medium-12 small-12 padding-lr">
                                <label>فروشنده
                                    <suggestions style="margin-bottom: -18px;" name="sellerTitle" v-validate :class="{'input': true, 'select-error': errors.has('sellerTitle')}"
                                                 v-model="factorInput.seller"
                                                 :options="sellerOptions"
                                                 :onInputChange="onSellerInputChange">
                                        <div slot="item" slot-scope="props" class="single-item">
                                            <strong>{{props.item}}</strong>
                                        </div>
                                    </suggestions>
                                </label>
                            </div>
                        </div>
                        <div style="margin-top:15px;" class="grid-x">
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
        props:['factors','refundFactor','requestId','data'],
        components: {
            Suggestions,
        },
        data () {
            return {
                showInsertFactorModal:false,
                showAcceptConfirmModal: false,
                showDeleteConfirmModal: false,
                showDialogModal: false,
                fIdForDelete: 0,
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
                sellerOptions: {},
                //contract input text

            }

        },

        created: function () {
            $(this.$el).foundation(); //WORKS!
            this.getFactorDetail();
        },
        updated: function () {
            $(this.$el).foundation(); //WORKS!
            this.myResizeModal();
        },

        mounted: function () {

        },

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
            getFactorDetail: function(){
                this.data.refund_factor.forEach(item => {
                    Vue.set(item.factor,"refundFactor",true);
                    Vue.set(item.factor,"factor_state","REFUNDFACTOR");
                    this.data.factor.push(item.factor);
                });
                console.log(JSON.stringify(this.data.factor));

            },
            checkAcceptFactor: function(){
                var existNotAccepted = false;
                this.factors.forEach(item => {
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

            openConfirmDeleteContract: function(cId){
                this.fIdForDelete = cId;
                this.showDeleteConfirmModal = true;
            },

            acceptFactor: function(){
                axios.post('/financial/request/factor/accept', {
                    rId: this.requestId,
                }).then((response) => {
                    this.$emit('updateSubmissionData' , response.data);
                    this.$emit('closeModal');
                    this.$root.displayNotif(response.status);
                    console.log(response);
                }, (error) => {
                    console.log(error);
                    this.$root.displayNotif(error.response.status);
                });
            },

            deleteFactor: function() {
                axios.post('/financial/refund/factor/delete', {
                    fId: this.fIdForDelete,
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

            openInsertFactorModal:function () {
                this.getAllSeller();
                this.factorInput={};
                this.showInsertFactorModal=true;
            },

            addNewFactor:function () {
                this.$validator.validateAll().then((result) => {
                    if (result) {
                        axios.post('/financial/refund/factor/new', {
                            rId: this.requestId,
                            subject: this.factorInput.subject,
                            seller: this.factorInput.seller,
                            amount: parseInt(this.factorInput.amount.split(',').join(''),10),
                            description: this.factorInput.description,
                        }).then((response) => {
                            this.$emit('updateSubmissionData' , response.data);
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
