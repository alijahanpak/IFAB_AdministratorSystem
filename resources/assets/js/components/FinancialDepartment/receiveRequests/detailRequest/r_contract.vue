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
                        <col width="150px"/>
                        <col width="120px"/>
                        <col width="300px"/>
                        <col width="120px"/>
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
                            <col width="150px"/>
                            <col width="120px"/>
                            <col width="300px"/>
                            <col width="120px"/>
                            <col v-if="$can('UNIT_OF_CONTRACT_DELETE_CONTRACT')" width="60px"/>
                        </colgroup>
                        <tbody class="tbl-head-style-cell">
                        <tr class="table-row" v-for="contract in contracts">
                            <td :data-toggle="'contract' + contract.id">{{contract.cSubject}}</td>
                            <td :data-toggle="'contract' + contract.id" class="text-center">{{$root.dispMoneyFormat(contract.cAmount)}}
                                <div class="clearfix tool-bar">
                                    <div  style="width: 600px;" class="dropdown-pane dropdown-pane-sm " data-close-on-click="true"  data-hover="true" data-hover-pane="true" data-h-offset="100px"  data-position="top" data-alignment="auto" :id="'contract' + contract.id" data-dropdown data-auto-focus="true">
                                        <ul class="my-menu small-font">
                                            <div class="grid-x">
                                                <!--Table Start-->
                                                <div class="tbl_body_style dynamic-height-level-modal3">
                                                    <table class="stack">
                                                        <tbody>
                                                        <tr>
                                                            <td width="150" class="black-color">عنوان  :</td>
                                                            <td></td>
                                                        </tr>
                                                        <tr>
                                                            <td width="150" class="black-color">مبلغ  :</td>
                                                            <td></td>
                                                        </tr>

                                                        </tbody>
                                                    </table>
                                                </div>
                                                <!--Table Body End-->
                                            </div>
                                        </ul>
                                    </div>
                                </div>
                            </td>
                            <td :data-toggle="'contract' + contract.id" class="text-center">{{contract.cLetterNumber}}</td>
                            <td :data-toggle="'contract' + contract.id" class="text-center">{{contract.cLetterDate}}</td>
                            <td :data-toggle="'contract' + contract.id" class="one-line">{{contract.cDescription}}</td>
                            <td :data-toggle="'contract' + contract.id" class="text-center" v-show="contract.cIsAccepted == 1"><span class="success-label">تایید شده</span></td>
                            <td :data-toggle="'contract' + contract.id" class="text-center" v-show="contract.cIsAccepted == 0"><span class="reserved-label">رزرو شده</span></td>
                            <td v-if="$can('UNIT_OF_CONTRACT_DELETE_CONTRACT')" class="text-center"><a @click=""><i class="far fa-trash-alt size-21 btn-red"></i></a></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <!--Table Body End-->
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
                            </div>
                        </div>
                        <div class="grid-x">
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
    </div>
</template>
<script>

    export default{
        props:['contracts','requestId'],
        data () {
            return {
            showInsertContractModal:false,
            contractInput:{},
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
            myResizeModal: function() {
                var x = $.w.outerHeight();
                $('.dynamic-height-level-modal1').css('height', (x-320) + 'px');
                $('.dynamic-height-level-modal2').css('height', (x-460) + 'px');
                $('.dynamic-height-level-modal3').css('height', (x-580) + 'px');
            },

            openInsertContractModal:function () {
              this.showInsertContractModal=true;
            },

            addNewContract:function () {
                this.$validator.validateAll().then((result) => {
                    if (result) {
                        axios.post('/financial/request/contract/insert', {
                            rId: this.requestId,
                            subject: this.contractInput.subject,
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
