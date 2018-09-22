<template xmlns:v-on="http://www.w3.org/1999/xhtml">
    <div class="grid-x">
        <div v-if="$can('UNIT_OF_CONTRACT_ADD_NEW_CONTRACT')" class="large-12 medium-12 small-12">
            <div class="clearfix tool-bar">
                <div class="button-group float-right report-mrg">
                    <a class="my-button toolbox-btn small" @click="openInsertContractModal()">جدید</a>
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
                        <col width="120px"/>
                        <col width="110px"/>
                        <col width="110px"/>
                        <col width="300px"/>
                        <col width="150px"/>
                        <col v-if="$can('UNIT_OF_CONTRACT_DELETE_CONTRACT')" width="60px"/>
                        <col width="12px"/>
                    </colgroup>
                    <tbody class="tbl-head-style ">
                    <tr class="tbl-head-style-cell">
                        <th class="tbl-head-style-cell">عنوان</th>
                        <th class="tbl-head-style-cell">مبلغ</th>
                        <th class="tbl-head-style-cell">شماره نامه</th>
                        <th class="tbl-head-style-cell">تاریخ نامه</th>
                        <th class="tbl-head-style-cell">شرح</th>
                        <th class="tbl-head-style-cell">وضعیت</th>
                        <th v-if="$can('UNIT_OF_CONTRACT_DELETE_CONTRACT')" class="tbl-head-style-cell">عملیات</th>
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
                            <col width="120px"/>
                            <col width="110px"/>
                            <col width="110px"/>
                            <col width="300px"/>
                            <col width="150px"/>
                            <col v-if="$can('UNIT_OF_CONTRACT_DELETE_CONTRACT')" width="60px"/>
                        </colgroup>
                        <tbody class="tbl-head-style-cell">
                        <tr class="table-row" v-for="contract in contracts">
                            <td :data-toggle="'contract' + contract.id">{{contract.cSubject}}</td>
                            <td :data-toggle="'contract' + contract.id" class="text-center">{{$root.dispMoneyFormat(contract.cAmount)}}
                                <div class="clearfix tool-bar">
                                    <div  style="width: 500px;" class="dropdown-pane dropdown-pane-sm " data-close-on-click="true"  data-hover="true" data-hover-pane="true" data-h-offset="100px"  data-position="top" data-alignment="auto" :id="'contract' + contract.id" data-dropdown data-auto-focus="true">
                                        <ul class="my-menu small-font">
                                            <div class="grid-x">
                                                <div class="large-12">
                                                <!--Table Start-->
                                                <div class="tbl_body_style dynamic-height-level-modal3">
                                                    <table class="stack text-right">
                                                        <tbody>
                                                        <tr class="align-right">
                                                            <td width="150" class="black-color">عنوان  :</td>
                                                            <td>{{contract.cSubject}}</td>
                                                        </tr>
                                                        <tr class="align-right">
                                                            <td width="150" class="black-color">مجری  :</td>
                                                            <td>{{contract.executor.eSubject}}</td>
                                                        </tr>
                                                        <tr>
                                                            <td width="150" class="black-color">مبلغ  :</td>
                                                            <td>{{$root.dispMoneyFormat(contract.cAmount)}} ریال</td>
                                                        </tr>
                                                        <tr>
                                                            <td width="150" class="black-color">درصد افزایش و یا کاهش  :</td>
                                                            <td>{{contract.cPercentInAndDec}}</td>
                                                        </tr>
                                                        <tr>
                                                            <td width="150" class="black-color">شماره قرارداد  :</td>
                                                            <td>{{contract.cLetterNumber}}</td>
                                                        </tr>
                                                        <tr>
                                                            <td width="150" class="black-color">تاریخ قرارداد  :</td>
                                                            <td>{{contract.cLetterDate}}</td>
                                                        </tr>
                                                        <tr>
                                                            <td width="150" class="black-color">تاریخ شروع  :</td>
                                                            <td>{{contract.cStartDate}}</td>
                                                        </tr>
                                                        <tr>
                                                            <td width="150" class="black-color">تاریخ پایان  :</td>
                                                            <td>{{contract.cEndDate}}</td>
                                                        </tr>
                                                        <tr>
                                                            <td width="150" class="black-color">شرح  :</td>
                                                            <td>{{contract.cDescription}}</td>
                                                        </tr>

                                                        </tbody>
                                                    </table>
                                                </div>
                                                <!--Table Body End-->
                                                </div>
                                            </div>
                                        </ul>
                                    </div>
                                </div>
                            </td>
                            <td :data-toggle="'contract' + contract.id" class="text-center">{{contract.cLetterNumber}}</td>
                            <td :data-toggle="'contract' + contract.id" class="text-center">{{contract.cLetterDate}}</td>
                            <td :data-toggle="'contract' + contract.id" class="one-line">{{contract.cDescription}}</td>
                            <td :data-toggle="'contract' + contract.id" class="text-center" v-show="contract.cIsAccepted == 1"><span class="success-label">تایید شده</span></td>
                            <td :data-toggle="'contract' + contract.id" class="text-center" v-show="contract.cIsAccepted == 0"><span class="reserved-label">تایید نشده</span></td>
                            <td v-if="$can('UNIT_OF_CONTRACT_DELETE_CONTRACT')" class="text-center"><a @click="openConfirmDeleteContract(contract.id)"><i class="far fa-trash-alt size-21 btn-red"></i></a></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <!--Table Body End-->
            <div class="large-12 medium-12 small-12" v-if='$can("UNIT_OF_CONTRACT_ACCEPT_CONTRACT")'>
                <div class="stacked-for-small button-group float-left">
                    <button @click="checkAcceptContract()"  class="my-button my-success float-left"><span class="btn-txt-mrg">تایید اطلاعات قرارداد</span></button>
                </div>
            </div>
        </div>

        <!--Insert Contract Start-->
        <modal-small v-if="showInsertContractModal" @close="showInsertContractModal = false">
            <div  slot="body">
                <form v-on:submit.prevent="createContract" >
                    <div class="small-font">
                        <div class="grid-x">
                            <div class="large-12 medium-12 small-12 padding-lr">
                                <label>عنوان
                                    <input type="text" name="contractSubject" v-model="contractInput.subject" v-validate="'required'" :class="{'input': true, 'error-border': errors.has('contractSubject')}">
                                </label>
                                <p v-show="errors.has('contractSubject')" class="error-font">لطفا عنوان را برای قرارداد مورد نظر را وارد نمایید!</p>
                                <p v-show="errors.has('contractSubject')" class="error-font">لطفا عنوان را برای قرارداد مورد نظر را وارد نمایید!</p>
                            </div>
                        </div>
                        <div class="grid-x">
                            <div class="large-12 medium-12 small-12 padding-lr">
                                <label>مجری
                                    <suggestions style="margin-bottom: -18px;" name="executorTitle" v-validate :class="{'input': true, 'select-error': errors.has('executorTitle')}"
                                                 v-model="contractInput.executor"
                                                 :options="executorOptions"
                                                 :onInputChange="onExecutorInputChange">
                                        <div slot="item" slot-scope="props" class="single-item">
                                            <strong>{{props.item}}</strong>
                                        </div>
                                    </suggestions>
                                </label>
                            </div>
                        </div>
                        <div style="margin-top:15px;"  class="grid-x">
                            <div class="large-6 medium-6 small-12 padding-lr">
                                <label>مبلغ <span class="btn-red">(ریال)</span>
                                    <money v-model="contractInput.amount"  v-bind="money" class="form-input input-lg text-margin-btm"  v-validate="'required'" :class="{'input': true, 'error-border': errors.has('contractAmount')}"></money>
                                </label>
                                <p v-show="errors.has('contractAmount')" class="error-font">لطفا مبلغ را برای قرارداد مورد نظر را وارد نمایید!</p>
                            </div>
                            <div class="large-6 medium-6 small-12 padding-lr">
                                <label>درصد افزایش و یا کاهش
                                    <input type="text" name="contractPercent" v-model="contractInput.percentIncAndDec" v-validate="'required','min_value:0','max_value:100'" :class="{'input': true, 'error-border': errors.has('contractPercent')}">
                                </label>
                                <p v-show="errors.has('contractPercent')" class="error-font">مقدار نا معتبر است!</p>
                            </div>
                        </div>
                        <div class="grid-x">
                            <div class="large-6 medium-6 small-12 padding-lr">
                                <label>شماره قرارداد
                                    <input type="text" name="letterNumber" v-model="contractInput.letterNumber" v-validate="'required'" :class="{'input': true, 'error-border': errors.has('letterNumber')}">
                                </label>
                                <p v-show="errors.has('letterNumber')" class="error-font">لطفا شماره قرارداد مورد نظر را وارد نمایید!</p>
                            </div>
                            <div class="large-6 medium-6 small-12 padding-lr">
                                <label>تاریخ قرارداد
                                    <input
                                            type="text"
                                            name="letterDate"
                                            class="form-control form-control-lg"
                                            v-model="contractInput.letterDate"
                                            id="contract-letterDate"
                                            placeholder="انتخاب تاریخ">

                                    <date-picker
                                            v-model="contractInput.letterDate"
                                            :color="'#5c6bc0'"
                                            element="contract-letterDate">
                                    </date-picker>
                                </label>
                                <p v-show="errors.has('letterDate')" class="error-font">لطفا تاریخ قرارداد مورد نظر را وارد نمایید!</p>
                            </div>
                        </div>
                        <div class="grid-x">
                            <div class="large-6 medium-6 small-12 padding-lr">
                                <label>تاریخ شروع
                                    <input
                                            type="text"
                                            class="form-control form-control-lg"
                                            v-model="contractInput.startDate"
                                            id="contract-startDate"
                                            placeholder="انتخاب تاریخ">

                                    <date-picker
                                            v-model="contractInput.startDate"
                                            :color="'#5c6bc0'"
                                            element="contract-startDate">
                                    </date-picker>
                                </label>
                            </div>
                            <div class="large-6 medium-6 small-12 padding-lr">
                                <label>تاریخ پایان
                                    <input
                                            type="text"
                                            class="form-control form-control-lg"
                                            v-model="contractInput.endDate"
                                            id="contract-endDate"
                                            placeholder="انتخاب تاریخ">

                                    <date-picker
                                            v-model="contractInput.endDate"
                                            :color="'#5c6bc0'"
                                            element="contract-endDate">
                                    </date-picker>
                                </label>
                            </div>
                        </div>
                        <div class="grid-x">
                            <div class="large-12 medium-12 small-12 padding-lr">
                                <label>شرح کامل خدمات
                                    <textarea style="min-height: 150px;" name="contractDescription" v-model="contractInput.description"   :class="{'input': true, 'error-border': errors.has('contractDescription')}"></textarea>
                                    <p v-show="errors.has('contractDescription')" class="error-font">لطفا شرح کامل خدمات را وارد کنید!</p>
                                </label>
                            </div>
                        </div>
                        <div class="grid-x">
                            <div class="large-12 medium-12 small-12 padding-lr">
                                <div class="stacked-for-small button-group float-left">
                                    <button @click="addNewContract" class="my-button my-success float-left"><span class="btn-txt-mrg">  ثبت </span></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </modal-small>
        <!--Insert Contract End-->
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
                            <button v-on:click="acceptContract"   class="my-button my-success"><span class="btn-txt-mrg">   بله   </span></button>
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
                            <button v-on:click="deleteContract"   class="my-button my-success"><span class="btn-txt-mrg">   بله   </span></button>
                        </div>
                    </div>
                </div>
            </div>
        </modal-tiny>
        <!-- accept Financing modal -->
    </div>
</template>
<script>
    import Suggestions from "v-suggestions/src/Suggestions";
    export default{
        props:['contracts','requestId' , 'rCreditIsAccepted' , 'rCreditIsExist'],
        components: {
            Suggestions,
        },
        data () {
            return {
                showInsertContractModal:false,
                showAcceptConfirmModal: false,
                showDeleteConfirmModal: false,
                showDialogModal: false,
                cIdForDelete: 0,
                dialogMessage: '',
                contractInput:{},
                money: {
                    thousands: ',',
                    precision: 0,
                    masked: true
                },
                //contract input text
                executorItems:[],
                executor: '',
                executorList: [],
                selectedExecutor: null,
                executorOptions: {},
                //contract input text
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

            /*-----------------------------------------------------------------------------
           ------------------ Contract Executor Start ------------------------------
           -----------------------------------------------------------------------------*/
            getAllExecutors: function () {
                axios.get('/financial/executor/fetchData')
                    .then((response) => {
                        this.executorItems = response.data;
                        this.executorList= [];
                        this.executorItems.forEach(item=> {
                            this.executorList.push(item.eSubject)
                        });
                        console.log(response);
                    }, (error) => {
                        console.log(error);
                    });
            },

            onExecutorInputChange(executorInput) {
                if (executorInput.trim().length === 0) {
                    return null
                }
                // return the matching countries as an array
                return this.executorList.filter((executors) => {
                    return executors.toLowerCase().includes(executorInput.toLowerCase())
                })
            },
            onCommoditySelected(item) {
                this.selectedExecutor = item
            },
            onSearchItemSelected(item) {
                this.selectedSearchItem = item
            },

            /*-----------------------------------------------------------------------------
            ------------------ Contract Executor End ------------------------------
            -----------------------------------------------------------------------------*/

            checkAcceptContract: function(){
                var existNotAccepted = false;
                this.contracts.forEach(item => {
                    if (item.cIsAccepted == false)
                        existNotAccepted = true;
                });

                if (existNotAccepted)
                {
                    this.showAcceptConfirmModal = true;
                }else{
                    this.dialogMessage = 'قرارداد تایید نشده ای موجود نیست! لطفا قبل از تایید اطلاعات قرارداد نسبت به ثبت قرارداد جدید اقدام کنید.';
                    this.showDialogModal = true;
                }
            },

            openConfirmDeleteContract: function(cId){
                this.cIdForDelete = cId;
                this.showDeleteConfirmModal = true;
            },

            acceptContract: function(){
                axios.post('/financial/request/contract/accept', {
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

            deleteContract: function() {
                axios.post('/financial/request/contract/delete', {
                    rId: this.requestId,
                    cId: this.cIdForDelete,
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

            openInsertContractModal:function () {
                if (this.rCreditIsExist == true)
                {
                    if (this.rCreditIsAccepted == false)
                    {
                        this.dialogMessage = 'تامین اعتبار تایید نهایی نشده است!';
                        this.showDialogModal = true;
                    }else{
                        this.contractInput={};
                        this.getAllExecutors();
                        this.showInsertContractModal=true;
                    }
                }else{
                    this.dialogMessage = 'امکان ثبت قرارداد وجود ندارد. منابع تامین اعتبار برای این درخواست تعیین نشده است!';
                    this.showDialogModal = true;
                }

            },

            addNewContract:function () {
                this.$validator.validateAll().then((result) => {
                    if (result) {
                        axios.post('/financial/request/contract/insert', {
                            rId: this.requestId,
                            subject: this.contractInput.subject,
                            executor: this.contractInput.executor,
                            amount: parseInt(this.contractInput.amount.split(',').join(''),10),
                            percentIncAndDec: this.contractInput.percentIncAndDec,
                            letterNumber: this.contractInput.letterNumber,
                            letterDate: this.contractInput.letterDate,
                            startDate: this.contractInput.startDate,
                            endDate: this.contractInput.endDate,
                            description: this.contractInput.description,
                        }).then((response) => {
                            this.$emit('updateReceiveRequestData' , response.data , this.requestId);
                            this.showInsertContractModal = false;
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
