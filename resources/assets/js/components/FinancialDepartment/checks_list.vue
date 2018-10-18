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
                                <span class="show-for-sr">Current: </span>چک
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
        <div class="grid-x my-callout-box container-mrg-top dynamic-height-level1">
            <div class="medium-12 padding-lr" style="margin-top: 15px;">
                <div class="clearfix tool-bar">
                    <div class="float-left">
                        <div class="input-group float-left">
                            <div class="inner-addon right-addon">
                                <i v-if="requestSearchValue == ''" class="fa fa-search purple-color"  aria-hidden="true"></i>
                                <i v-if="requestSearchValue != ''" v-on:click.stop="removeFilter()" class="fa fa-close btn-red"  aria-hidden="true"></i>
                                <input v-model="requestSearchValue" v-on:keyup.enter="search()" class="search" type="text" placeholder="جستجو">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="medium-12 column">
                    <div class="tbl-div-container">
                        <table class="tbl-head">
                            <colgroup>
                                <col width="150px"/>
                                <col width="150px"/>
                                <col width="150px"/>
                                <col width="300px"/>
                                <col width="150px"/>
                                <col width="250px"/>
                                <col width="150px"/>
                                <col width="12px"/>
                            </colgroup>
                            <tbody class="tbl-head-style">
                            <tr class="tbl-head-style-cell">
                                <th class="tbl-head-style-cell">شماره چک</th>
                                <th class="tbl-head-style-cell">تاریخ چک</th>
                                <th class="tbl-head-style-cell">مبلغ <span class="btn-red small-font">(ریال)</span></th>
                                <th class="tbl-head-style-cell">بابت</th>
                                <th class="tbl-head-style-cell">در وجه</th>
                                <th class="tbl-head-style-cell">تاریخ تحویل</th>
                                <th class="tbl-head-style-cell">وضعیت</th>
                                <th class="tbl-head-style-cell"></th>
                            </tr>
                            </tbody>
                        </table>
                        <!--Table Head End-->
                        <!--Table Body Start-->
                        <div class="tbl_body_style dynamic-height-level2">
                            <table class="tbl-body-contain">
                                <colgroup>
                                    <col width="150px"/>
                                    <col width="150px"/>
                                    <col width="150px"/>
                                    <col width="300px"/>
                                    <col width="150px"/>
                                    <col width="250px"/>
                                    <col width="150px"/>
                                </colgroup>
                                <tbody class="tbl-head-style-cell">
                                <tr class="table-row" @click="getRequestDetail(allCheck)" v-for="allCheck in allChecks">
                                    <td class="text-center">{{allCheck.cIdNumber}}</td>
                                    <td class="text-center">{{allCheck.cDate}}</td>
                                    <td class="text-center">{{$parent.dispMoneyFormat(allCheck.cAmount)}}</td>
                                    <td>{{allCheck.cPdId != null ? allCheck.percentage_decrease.pdSubject + ' - ' + allCheck.draft.dFor : allCheck.draft.dFor}}</td>
                                    <td class="text-center">{{allCheck.draft.dPayTo}}</td>
                                    <td class="text-center">{{ allCheck.cDeliveryShamsiDate != '' ? allCheck.cDeliveryShamsiTime + ' - ' + allCheck.cDeliveryShamsiDate : '' }}</td>
                                    <td v-show="allCheck.check_state.csState == 'WAITING_FOR_PRINT'" class="text-center"><span class="danger-label">{{ allCheck.check_state.csSubject }}</span></td>
                                    <td v-show="allCheck.check_state.csState == 'WAITING_FOR_DELIVERY'" class="text-center"><span class="reserved-label">{{ allCheck.check_state.csSubject }}</span></td>
                                    <td v-show="allCheck.check_state.csState == 'DELIVERED'" class="text-center"><span class="success-label">{{ allCheck.check_state.csSubject }}</span></td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="grid-x">
                        <div class="medium-12">
                            <vue-pagination  v-bind:pagination="result_pagination"
                                             v-on:click.native="fetchData(result_pagination.current_page)"
                                             :offset="4">
                            </vue-pagination>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Show Check Print modal -->
        <modal-small v-if="showPrintCheckModal" @close="showPrintCheckModal = false">
            <div slot="body">
                <div class="small-font">
                    <div class="grid-x">
                        <div class="large-12 medium-12 small-12 container-vh-check-list">
                            <ul class="tabs tab-color my-tab-style" data-responsive-accordion-tabs="tabs medium-accordion large-tabs" id="request_print_check_tab_view">
                                <li class="tabs-title is-active"><a href="#checkTab" aria-selected="true">چک</a></li>
                                <li class="tabs-title"><a href="#historyCheckTab">تاریخچه پرینت </a></li>
                            </ul>
                            <div class="tabs-content inner-vh" data-tabs-content="request_print_check_tab_view">
                                <!--Tab 1-->
                                <div style="height: 53vh;" class="tabs-panel is-active table-mrg-btm inner-vh-unsize" id="checkTab">
                                    <div class="grid-x">
                                        <div class="large-6 medium-6 small-12 padding-lr">
                                            <label>شماره چک
                                                <input type="text" name="idNumber" v-model="inputCheck.idNumber" v-validate="'required','numeric'" :class="{'input': true, 'error-border': errors.has('idNumber')}">
                                            </label>
                                            <p v-show="errors.has('idNumber')" class="error-font">لطفا شماره چک مورد نظر را فقط عدد وارد نمایید!</p>
                                        </div>
                                        <div class="large-6 medium-6 small-12 padding-lr">
                                            <label>تاریخ چک
                                                <input
                                                        type="text"
                                                        class="form-control form-control-lg"
                                                        v-model="inputCheck.date"
                                                        id="inputCheck-Date"
                                                        placeholder="انتخاب تاریخ">
                                                <date-picker
                                                        v-model="inputCheck.date"
                                                        :color="'#5c6bc0'"
                                                        element="inputCheck-Date">
                                                </date-picker>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="grid-x">
                                        <div class="large-12 medium-12 small-12 padding-lr">
                                            <p class="input-bottom-margin">امضا</p>
                                            <div class="panel-separator padding-lr">
                                                <div  v-for="(cvUser,index) in allCheckVerifiers" class="grid-x">
                                                    <div class="large-9 medium-8  small-12">
                                                        <div class="grid-x">
                                                            <div class="large-2 medium-4  small-12">
                                                                <div class="switch tiny">
                                                                    <input :checked="inputCheck['verifierId' + cvUser.id] = cvUser.checked" class="switch-input" v-on:change="selectVerifiersSignature(cvUser,index,inputCheck['verifierId' + cvUser.id])" v-model="inputCheck['verifierId' + cvUser.id]" :id="'verifierId'+cvUser.id" type="checkbox">
                                                                    <label class="switch-paddle" :for="'verifierId'+cvUser.id">
                                                                        <span class="switch-active" aria-hidden="true">بلی</span>
                                                                        <span class="switch-inactive" aria-hidden="true">خیر</span>
                                                                    </label>
                                                                </div>
                                                            </div>
                                                            <div class="large-10 medium-9  small-12">
                                                                <p>{{cvUser.user.name}} - {{cvUser.user.role.rSubject}}</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="grid-x input-top-margin">
                                        <div class="large-12 medium-12 small-12 padding-lr">
                                            <label>قالب چک
                                                <select name="checkTemplate" v-validate data-vv-rules="required"  v-model="inputCheck.cId" :class="{'input': true, 'select-error': errors.has('checkTemplate')}">
                                                    <option value=""></option>
                                                    <option v-for="activeCheckFormat in allActiveCheckFormat" @click="selectCheckTemplate(activeCheckFormat)" :value="activeCheckFormat.id">{{activeCheckFormat.cfSubject}}</option>
                                                </select>
                                                <p v-show="errors.has('checkTemplate')" class="error-font">لطفا قالب چک را انتخاب کنید!</p>
                                                <p v-show="checkVerifierCountAlert" class="error-font">کاربر گرامی: با توجه به تعداد امضا کنندگان، شما نمی توانید قالب چک با دو امضا انتخاب کنید!</p>
                                            </label>
                                        </div>
                                    </div>

                                    <div class="grid-x small-top-m">
                                        <div class="large-12 medium-12 small-12 padding-lr">
                                            <div class="stacked-for-small button-group float-left">
                                                <button v-show="deliverBtn" @click="openCheckDeliverModal()" class="my-button my-success float-left"><span class="btn-txt-mrg">  تحویل </span></button>
                                                <button v-show="previewBtn" @click="showCheckPreview()" class="my-button my-success float-left"><span class="btn-txt-mrg">  پیش نمایش چک </span></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--Tab 1-->
                                <!--Tab 2-->
                                <div style="height: 53vh;" class="tabs-panel table-mrg-btm inner-vh-unsize" id="historyCheckTab">
                                    <div class="grid-x">
                                        <div class="tbl-div-container">
                                            <table class="tbl-head">
                                                <colgroup>
                                                    <col width="250px"/>
                                                    <col width="250px"/>
                                                    <col width="250px"/>
                                                    <col width="250px"/>
                                                    <col width="12px"/>
                                                </colgroup>
                                                <tbody class="tbl-head-style ">
                                                <tr class="tbl-head-style-cell">
                                                    <th class="tbl-head-style-cell">شماره چک</th>
                                                    <th class="tbl-head-style-cell">تاریخ چک</th>
                                                    <th class="tbl-head-style-cell">مبلغ <span class="btn-red">(ریال)</span></th>
                                                    <th class="tbl-head-style-cell">تاریخ پرینت</th>
                                                    <th class="tbl-head-style-cell"></th>
                                                </tr>
                                                </tbody>
                                                <!--Table Head End-->
                                                <!--Table Body Start-->
                                            </table>
                                            <div style="height: 40vh;" class="tbl_body_style inner-vh-unsize">
                                                <table class="tbl-body-contain">
                                                    <colgroup>
                                                        <col width="250px"/>
                                                        <col width="250px"/>
                                                        <col width="250px"/>
                                                        <col width="250px"/>
                                                        <col width="12px"/>
                                                    </colgroup>
                                                    <tbody class="tbl-head-style-cell">
                                                    <template v-for="checkSelect in checkSelectTemp">
                                                        <tr class="table-row" v-for="pHistory in checkSelect.print_history">
                                                            <td :data-toggle="'pHistory' + pHistory.id" class="text-center">{{pHistory.phIdNumber}}</td>
                                                            <td :data-toggle="'pHistory' + pHistory.id" >{{pHistory.phDate}}
                                                                <div style="width: 30vw;" class="dropdown-pane dropdown-pane-sm " data-close-on-click="true"  data-hover="true" data-hover-pane="true" data-h-offset="100px"  data-position="auto" data-alignment="auto" :id="'pHistory' + pHistory.id" data-dropdown data-auto-focus="true">
                                                                    <ul class="my-menu small-font">
                                                                        <div class="grid-x">
                                                                            <!--Table Start-->
                                                                            <div style="height: 25vh;" class="tbl_body_style">
                                                                                <table class="stack text-right">
                                                                                    <tbody>
                                                                                    <tr>
                                                                                        <td width="200" class="black-color">قالب چک :</td>
                                                                                        <td width="400">{{pHistory.phCheckFormat}}</td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td class="black-color">شماره چک :</td>
                                                                                        <td>{{pHistory.phIdNumber}}</td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td class="black-color">تاریخ چک:</td>
                                                                                        <td>{{pHistory.phDate}}</td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td class="black-color">مبلغ :</td>
                                                                                        <td>{{pHistory.phAmount}}</td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td class="black-color">امضا کننده :</td>
                                                                                        <td class="text-justify">{{pHistory.phVerifierName}}</td>
                                                                                    </tr>
                                                                                    <tr v-show="pHistory.phSecondVerifierName != null">
                                                                                        <td class="black-color">امضا کننده دوم :</td>
                                                                                        <td class="text-justify">{{pHistory.phSecondVerifierName}}</td>
                                                                                    </tr>
                                                                                    <tr v-show="pHistory.phDescription != null">
                                                                                        <td class="black-color">دلیل پرینت مجدد :</td>
                                                                                        <td class="text-justify">{{pHistory.phDescription}}</td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td class="black-color">تاریخ پرینت :</td>
                                                                                        <td class="text-justify"></td>
                                                                                    </tr>
                                                                                    </tbody>
                                                                                </table>
                                                                            </div>
                                                                            <!--Table Body End-->
                                                                        </div>
                                                                    </ul>
                                                                </div>
                                                            </td>
                                                            <td :data-toggle="'pHistory' + pHistory.id" class="text-center">{{$root.dispMoneyFormat(pHistory.phAmount)}}</td>
                                                            <td :data-toggle="'pHistory' + pHistory.id" class="text-center"></td>
                                                        </tr>
                                                    </template>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <!--Table Body End-->
                                    </div>
                                </div>
                                <!--Tab 2-->
                            </div>
                        </div>
                    </div>
                </div>
                <!--<div class="grid-x small-top-m">
                    <div class="large-12 medium-12 small-12 padding-lr">
                        <div class="stacked-for-small button-group float-left">
                            <button onclick="printJS({ printable: 'printJS-form', type: 'html',targetStyles:['direction','font-family']})" class="my-button my-success float-left"><span class="btn-txt-mrg">  چاپ </span></button>
                        </div>
                    </div>
                </div>-->
            </div>
        </modal-small>
        <!-- Show Check Print modal -->

        <!-- Show Check Template Preview modal -->
        <modal-large v-if="showGetCheckPreviewModal" @close="showGetCheckPreviewModal = false">
            <div slot="body">
                <div class="small-font">
                    <div class="grid-x">
                        <div class="large-12 medium-12 small-12 padding-lr text-center">
                            <p class="small-top-m"> قالب چک <span class="btn-red"> '{{ this.fillCheck.subject }}' </span> </p>
                            <div :style="{'width':fillCheck.height +'cm','height':fillCheck.width +'cm'}" style="border: solid 1px #D8DEE2;position: relative;margin:0 auto;" >
                                <p class="check-element text-left" :style="{'margin-top': fillCheck.dateTop +'cm','margin-right': fillCheck.dateRight +'cm','width': fillCheck.dateWidth +'cm'}">{{inputCheck.date}}</p>
                                <p class="check-element text-right" :style="{'margin-top': fillCheck.stringDateTop +'cm','margin-right': fillCheck.stringDateRight +'cm','width': fillCheck.stringDateWidth +'cm'}">{{letterDatePersian}}</p>
                                <p class="check-element text-right" :style="{'margin-top': fillCheck.forTop +'cm','margin-right': fillCheck.forRight +'cm','width': fillCheck.forWidth +'cm'}">{{dFor}}</p>
                                <p class="check-element text-right" :style="{'margin-top': fillCheck.payToTop +'cm','margin-right': fillCheck.payToRight +'cm','width': fillCheck.payToWidth +'cm'}">{{dPayTo}}</p>
                                <p class="check-element text-right" :style="{'margin-top': fillCheck.stringAmountTop +'cm','margin-right': fillCheck.stringAmountRight +'cm','width': fillCheck.stringAmountWidth +'cm'}">{{cAmount.toPersian()}}</p>
                                <p class="check-element text-left" :style="{'margin-top': fillCheck.amountTop +'cm','margin-right': fillCheck.amountRight +'cm','width': fillCheck.amountWidth +'cm'}">{{$root.dispMoneyFormat(cAmount)}}</p>
                                <p class="check-element" :style="{'margin-top': fillCheck.signatureTop +'cm','margin-right': fillCheck.signatureRight +'cm','width': fillCheck.signatureWidth +'cm'}">{{checkVerifierName[0]}}</p>
                                <p class="check-element" :style="{'margin-top': fillCheck.signatureTop +0.5+'cm','margin-right': fillCheck.signatureRight +'cm','width': fillCheck.signatureWidth +'cm'}">{{checkVerifierName[1]}}</p>
                                <p v-show="fillCheck.secondSignatureWidth != 0" class="check-element text-center" :style="{'margin-top': fillCheck.secondSignatureTop +'cm','margin-right': fillCheck.secondSignatureRight +'cm','width': fillCheck.secondSignatureWidth +'cm'}">{{checkVerifierName[2]}}</p>
                                <p v-show="fillCheck.secondSignatureWidth != 0" class="check-element text-center" :style="{'margin-top': fillCheck.secondSignatureTop +0.5+'cm','margin-right': fillCheck.secondSignatureRight +'cm','width': fillCheck.secondSignatureWidth +'cm'}"> {{checkVerifierName[3]}}</p>
                            </div>
                        </div>
                        <div style="display: none;">
                            <div id="printJS-form" class="large-12 medium-12 small-12 padding-lr text-center printJSClass">
                                <div :style="{'width':fillCheck.height +'cm','height':fillCheck.width +'cm'}" style="position: relative;margin:0 auto;" >
                                    <p class="check-element-print text-left" :style="{'margin-top': fillCheck.dateTop +'cm','margin-right': fillCheck.dateRight +'cm','width': fillCheck.dateWidth +'cm'}">{{inputCheck.date}}</p>
                                    <p class="check-element-print text-right" :style="{'margin-top': fillCheck.stringDateTop +'cm','margin-right': fillCheck.stringDateRight +'cm','width': fillCheck.stringDateWidth +'cm'}">{{letterDatePersian}}</p>
                                    <p class="check-element-print text-right" :style="{'margin-top': fillCheck.forTop +'cm','margin-right': fillCheck.forRight +'cm','width': fillCheck.forWidth +'cm'}">{{dFor}}</p>
                                    <p class="check-element-print text-right" :style="{'margin-top': fillCheck.payToTop +'cm','margin-right': fillCheck.payToRight +'cm','width': fillCheck.payToWidth +'cm'}">{{dPayTo}}</p>
                                    <p class="check-element-print text-right" :style="{'margin-top': fillCheck.stringAmountTop +'cm','margin-right': fillCheck.stringAmountRight +'cm','width': fillCheck.stringAmountWidth +'cm'}">{{cAmount.toPersian()}}</p>
                                    <p class="check-element-print text-center" :style="{'margin-top': fillCheck.amountTop +'cm','margin-right': fillCheck.amountRight +'cm','width': fillCheck.amountWidth +'cm'}">{{$root.dispMoneyFormat(cAmount)}}</p>
                                    <p class="check-element-print" :style="{'margin-top': fillCheck.signatureTop +'cm','margin-right': fillCheck.signatureRight +'cm','width': fillCheck.signatureWidth +'cm'}">{{checkVerifierName[0]}}</p>
                                    <p class="check-element-print" :style="{'margin-top': fillCheck.signatureTop +0.5+'cm','margin-right': fillCheck.signatureRight +'cm','width': fillCheck.signatureWidth +'cm'}">{{checkVerifierName[1]}}</p>
                                    <p v-show="fillCheck.secondSignatureWidth != 0" class="check-element-print text-center" :style="{'margin-top': fillCheck.secondSignatureTop +'cm','margin-right': fillCheck.secondSignatureRight +'cm','width': fillCheck.secondSignatureWidth +'cm'}">{{checkVerifierName[2]}}</p>
                                    <p v-show="fillCheck.secondSignatureWidth != 0" class="check-element-print text-center" :style="{'margin-top': fillCheck.secondSignatureTop +0.5+'cm','margin-right': fillCheck.secondSignatureRight +'cm','width': fillCheck.secondSignatureWidth +'cm'}"> {{checkVerifierName[3]}}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="grid-x small-top-m">
                        <div class="large-12 medium-12 small-12 padding-lr">
                            <div class="stacked-for-small button-group float-left">
                                <button @click="getReprintingCause()" class="my-button my-success float-left"><span class="btn-txt-mrg">  چاپ </span></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </modal-large>
        <!-- Show Check Template Preview modal -->

        <!-- Show Check Deliver modal -->
        <modal-tiny v-if="showCheckDeliverModal" @close="showCheckDeliverModal = false">
            <div slot="body">
                <form v-on:submit.prevent="checkDeliver" >
                    <div class="small-font">
                        <div class="grid-x">
                            <div class="large-12 medium-12 small-12 padding-lr">
                                <label>تاریخ تحویل
                                    <input
                                            type="text"
                                            class="form-control form-control-lg"
                                            v-model="checkDeliverTime"
                                            id="checkDeliver-Date"
                                            placeholder="انتخاب تاریخ">

                                    <date-picker
                                            type="datetime"
                                            v-model="checkDeliverTime"
                                            :color="'#5c6bc0'"
                                            element="checkDeliver-Date">
                                    </date-picker>
                                </label>
                            </div>
                        </div>
                        <div class="grid-x small-top-m">
                            <div class="large-12 medium-12 small-12 padding-lr">
                                <div class="stacked-for-small button-group float-left">
                                    <button @click="" class="my-button my-success float-left"><span class="btn-txt-mrg">  ثبت </span></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </modal-tiny>
        <!-- Show Check Deliver modal -->

        <!-- Show Reprinting cause modal -->
        <modal-tiny v-if="showReprintingCauseModal" @close="showReprintingCauseModal = false">
            <div slot="body">
                <div class="small-font">
                    <div class="grid-x">
                        <div class="large-12 medium-12 small-12 padding-lr">
                            <p class="btn-red">کاربر گرامی : شما قبلا این چک را تحویل داده اید! برای پرینت مجدد باید علت پرینت چک را وارد نمایید.</p>
                            <label>علت پرینت مجدد
                                <textarea v-model="inputCheck.description"  class="form-element-margin-btm"  style="min-height: 150px;" name="description"  v-validate="'required'" :class="{'input': true, 'error-border': errors.has('description')}"></textarea>
                                <span v-show="errors.has('description')" class="error-font">لطفا علت پرینت مجدد چک را وارد کنید!</span>
                            </label>
                        </div>
                    </div>
                    <div class="grid-x small-top-m">
                        <div class="large-12 medium-12 small-12 padding-lr">
                            <div class="stacked-for-small button-group float-left">
                                <button @click="closeReprintingCauseModal()" class="my-button my-success float-left"><span class="btn-txt-mrg">  ثبت </span></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </modal-tiny>
        <!-- Show Reprinting cause modal -->

    </div>
</template>
<style>
    .printJSClass{
        direction: rtl;
        font-family: "B Zar";
    }
</style>
<script>
    import Suggestions from "v-suggestions/src/Suggestions";
    import VuePersianDatetimePicker from 'vue-persian-datetime-picker';
    import VuePagination from '../../public_component/pagination.vue';
    import printJS from 'print-js';

    export default {
        components: {
            Suggestions,
            "vue-select": require("vue-select"),
            datePicker: VuePersianDatetimePicker,
            'vue-pagination' : VuePagination,
        },

        data () {
            return {
                allChecks:[],
                requestSearchValue:'',
                showRequestDetailModal:false,
                showPrintCheckModal:false,
                showGetCheckPreviewModal:false,
                showCheckDeliverModal:false,
                showReprintingCauseModal:false,
                baseURL:window.hostname+'/',
                updateDataThreadNowPlaying:null,
                result_pagination: {
                    total: 0,
                    to: 0,
                    current_page: 1,
                    last_page: ''
                },
                allActiveCheckFormat:[],
                allCheckVerifiers:[],
                inputCheck:{},
                fillCheck:{},
                checkActiveFormatSelect:[],
                checkSelectTemp:[],
                checkVerifierName:[],
                dPayTo:'',
                dFor:'',
                cAmount:0,
                checkDeliverTime:'',
                checkId:'',
                deliverBtn:false,
                previewBtn:false,
                verifierInput:{},
                checkVerifierCount:0,
                checkVerifierCountAlert:false,
                letterDatePersian:'',
                checkHistoryState:false,

            }
        },

        created: function(){
            this.fetchData();
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
            makePagination: function(data){
                this.result_pagination.current_page = data.current_page;
                this.result_pagination.to = data.to;
                this.result_pagination.last_page = data.last_page;
            },

            setUpdateDataThread: function () {
                console.log("...................................................... set search part update thread");
                if (this.updateDataThreadNowPlaying)
                    clearInterval(this.updateDataThreadNowPlaying);
                this.updateDataThreadNowPlaying = setInterval(this.updateDataThread, 60000);
            },

            updateDataThread: function () {
                console.log("...................................................... search part update thread");
                this.fetchData();
            },

            fetchData: function (page=1) {
                axios.get('financial/check/list/get_all_data?page=' + page , {params:{searchValue:this.requestSearchValue}})
                    .then((response) => {
                        this.allChecks = response.data.data;
                        this.makePagination(response.data);
                        console.log(response);
                    }, (error) => {
                        console.log(error);
                    });
            },

            fetchAllActiveCheckFormat: function () {
                axios.get('/financial/admin/check/format/fetch_active_format')
                .then((response) => {
                    this.allActiveCheckFormat = response.data;
                    console.log(response);
                }, (error) => {
                    console.log(error);
                });
            },

            getAllCheckVerifiers: function () {
                axios.get('/financial/check/get_check_verifier')
                    .then((response) => {
                        this.allCheckVerifiers = response.data;
                        console.log(response);
                    }, (error) => {
                        console.log(error);
                    });
            },

            getRequestDetail:function(check){
                this.checkSelectTemp=[];
                this.previewBtn=false;
                this.checkSelectTemp.push(check);
                console.log(JSON.stringify(this.checkSelectTemp));
                this.checkSelectTemp.forEach(item =>{
                    this.dPayTo=item.draft.dPayTo;
                    this.dFor=item.draft.dFor;
                    this.cAmount=item.cAmount;
                });

                this.checkSelectTemp.forEach(item =>{
                    if(item.print_history.length > 0){
                        if(item.check_state.csState == 'DELIVERED'){
                            this.checkHistoryState=true;
                            this.deliverBtn=false;
                        }
                        else this.deliverBtn=true;
                    }
                    else{
                        this.checkHistoryState=false;
                        this.deliverBtn=false;
                    }
                });

                this.checkId=check.id;
                this.inputCheck={};
                this.getAllCheckVerifiers();
                this.fetchAllActiveCheckFormat();
                this.showPrintCheckModal=true;
            },

            selectCheckTemplate:function(check){
                var checkTemp=[];
                checkTemp=check;
                this.checkVerifierCount=checkTemp.cfSecondSignatureWidth;
                var checkedCount=0
                this.allCheckVerifiers.forEach(item =>{
                    if(item.checked ==  true){
                        checkedCount +=1;
                    }
                });
                if(this.checkVerifierCount == 0 && checkedCount >1) {
                    this.checkVerifierCountAlert = true;
                    this.previewBtn=false;
                }
                else{
                    this.previewBtn=true;
                    this.checkVerifierCountAlert = false;
                }
                this.fillCheck={};
                this.checkActiveFormatSelect=[];
                this.checkActiveFormatSelect=check;
            },

            showCheckPreview:function(){

                this.fillCheck.subject=this.checkActiveFormatSelect.cfSubject;
                this.fillCheck.dateTop=this.checkActiveFormatSelect.cfDateTop;
                this.fillCheck.dateRight=this.checkActiveFormatSelect.cfDateRight;
                this.fillCheck.dateWidth=this.checkActiveFormatSelect.cfDateWidth;
                this.fillCheck.stringDateTop=this.checkActiveFormatSelect.cfStringDateTop;
                this.fillCheck.stringDateRight=this.checkActiveFormatSelect.cfStringDateRight;
                this.fillCheck.stringDateWidth=this.checkActiveFormatSelect.cfStringDateWidth;
                this.fillCheck.forTop=this.checkActiveFormatSelect.cfForTop;
                this.fillCheck.forRight=this.checkActiveFormatSelect.cfForRight;
                this.fillCheck.forWidth=this.checkActiveFormatSelect.cfForWidth;
                this.fillCheck.payToTop=this.checkActiveFormatSelect.cfPayToTop;
                this.fillCheck.payToRight=this.checkActiveFormatSelect.cfPayToRight;
                this.fillCheck.payToWidth=this.checkActiveFormatSelect.cfPayToWidth;
                this.fillCheck.stringAmountTop=this.checkActiveFormatSelect.cfStringAmountTop;
                this.fillCheck.stringAmountRight=this.checkActiveFormatSelect.cfStringAmountRight;
                this.fillCheck.stringAmountWidth=this.checkActiveFormatSelect.cfStringAmountWidth;
                this.fillCheck.amountTop=this.checkActiveFormatSelect.cfAmountTop;
                this.fillCheck.amountRight=this.checkActiveFormatSelect.cfAmountRight;
                this.fillCheck.amountWidth=this.checkActiveFormatSelect.cfAmountWidth;
                this.fillCheck.signatureTop=this.checkActiveFormatSelect.cfSignatureTop;
                this.fillCheck.signatureRight=this.checkActiveFormatSelect.cfSignatureRight;
                this.fillCheck.signatureWidth=this.checkActiveFormatSelect.cfSignatureWidth;
                this.fillCheck.signatureWidth=this.checkActiveFormatSelect.cfSignatureWidth;
                this.fillCheck.secondSignatureTop=this.checkActiveFormatSelect.cfSecondSignatureTop;
                this.fillCheck.secondSignatureRight=this.checkActiveFormatSelect.cfSecondSignatureRight;
                this.fillCheck.secondSignatureWidth=this.checkActiveFormatSelect.cfSecondSignatureWidth;
                this.fillCheck.width=this.checkActiveFormatSelect.cfWidth;
                this.fillCheck.height=this.checkActiveFormatSelect.cfHeight;
                this.checkVerifierName=[];
                this.allCheckVerifiers.forEach(item =>{
                    if(item.checked ==  true){
                        this.checkVerifierName.push(item.user.name);
                        this.checkVerifierName.push(item.user.role.rSubject)
                    }
                    console.log(JSON.stringify(this.checkVerifierName));
                });
                this.convertDateToLetter();
                this.showGetCheckPreviewModal=true;
            },

            selectVerifiersSignature: function (verifier,index,state) {
                var verifierTemp={};
                verifierTemp.id=verifier.id;
                verifierTemp.name = verifier.user.name;
                verifierTemp.rSubject = verifier.user.role.rSubject;
                verifierTemp.index = index;
                if(state == false){
                    this.allCheckVerifiers.forEach(item =>{
                        if(item.id == verifierTemp.id){
                            this.allCheckVerifiers.forEach(item =>{
                                if(verifier.id == item.id){
                                    Vue.set(item,"name","");
                                    Vue.set(item,"rSubject","");
                                    Vue.set(item,"index","");
                                    Vue.set(item,"checked",false);
                                }
                            });
                        }
                    });
                }
                if(state == true){
                    this.allCheckVerifiers.forEach(item =>{
                        if(verifierTemp.id == item.id){
                            Vue.set(item,"name",verifierTemp.name);
                            Vue.set(item,"rSubject",verifierTemp.rSubject);
                            Vue.set(item,"index",verifierTemp.index);
                            Vue.set(item,"checked",true);
                        }
                    });

                }
                console.log(JSON.stringify(this.allCheckVerifiers));
            },

            getReprintingCause : function(){
                if(this.checkHistoryState){
                    this.showReprintingCauseModal=true;
                }
                else this.updateCheckValueInPrintAction();

            },

            closeReprintingCauseModal : function(){
                this.$validator.validateAll().then((result) => {
                    if (result) {
                        this.showReprintingCauseModal=false;
                        this.updateCheckValueInPrintAction();
                    }
                });
            },

            updateCheckValueInPrintAction : function(){
                var verifierTempForCheck=[];
                this.allCheckVerifiers.forEach(item =>{
                    if(item.checked ==  true){
                        verifierTempForCheck.push(item.id);
                    }
                });
                console.log(JSON.stringify(verifierTempForCheck));

                axios.post('/financial/check/print/update', {
                    verifiers:verifierTempForCheck,
                    cId:this.checkId,
                    date:this.inputCheck.date,
                    idNumber:this.inputCheck.idNumber,
                    cfSubject:this.fillCheck.subject,
                    description:this.inputCheck.description = undefined ? '' : this.inputCheck.description,
                    searchValue:"",
                }).then((response) => {
                    printJS({ printable: 'printJS-form', type: 'html',targetStyles:['direction','font-family','margin-top','margin-right','width','height','position','top','text-align']});
                    this.allChecks = response.data.data;
                    this.makePagination(response.data);
                    this.showGetCheckPreviewModal=false;
                    this.showPrintCheckModal=false;
                    this.$parent.displayNotif(response.status);
                    console.log(response);
                }, (error) => {
                    console.log(error);
                    this.$parent.displayNotif(error.response.status);
                });
            },

            convertDateToLetter : function(){
                var dateTemp=[];
                //var day=["یکم","دوم","سوم","چهارم","پنجم","ششم","هفتم","هشتم","نهم","دهم","یازده","دوازده","سیزده","چهارده","پانزده","شانزده","هفده","هجده","نوزده","بیست","بیست و یک","بیست و دو","بیست و سه","بیست و چهار","بیست و پنج","بیست و شش","بیست و هفت","بیست و هشت","بیست و نه","سی","سی و یک"];
                var month=["فروردین","اردیبهشت","خرداد","تیر","مرداد","شهریور","مهر","آبان","آذر","دی","بهمن","اسفند"];
                //var year=["هزار و سیصد و نود","","","","","","","","","","","","",];
                dateTemp= this.inputCheck.date.split('/');

                this.letterDatePersian=  dateTemp[2].toPersian() + ' ' + month[dateTemp[1]-1] + ' ' + dateTemp[0].toPersian();
            },

            openCheckDeliverModal:function(){
                this.showCheckDeliverModal=true;
            },

            checkDeliver:function(){
                axios.post('/financial/check/deliver', {
                    cId:this.checkId,
                    date:this.checkDeliverTime,
                    searchValue:"",
                }).then((response) => {
                    this.allChecks = response.data.data;
                    this.makePagination(response.data);
                    this.showCheckDeliverModal=false;
                    this.showPrintCheckModal=false;
                    this.$parent.displayNotif(response.status);
                    console.log(response);
                }, (error) => {
                    console.log(error);
                    this.$parent.displayNotif(error.response.status);
                });
            },

            removeFilter: function () {
                this.requestSearchValue = '';
                this.fetchData();
            },

            search: function () {
                this.fetchData();
            },

    }
}
</script>
