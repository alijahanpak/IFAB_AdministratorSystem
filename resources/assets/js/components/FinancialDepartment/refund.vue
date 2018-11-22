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
                                <span class="show-for-sr">Current: </span>تنخواه گردان کارپردازی
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
        <div class="grid-x my-callout-box container-mrg-top dynamic-height-level1">
            <div class="medium-12 padding-lr" style="margin-top: 15px;">
                <div class="medium-12 column">
                    <div class="tbl-div-container">
                        <table class="tbl-head">
                            <colgroup>
                                <col width="300px"/>
                                <col width="150px"/>
                                <col width="150px"/>
                                <col width="150px"/>
                                <col width="250px"/>
                                <col width="12px"/>
                            </colgroup>
                            <tbody class="tbl-head-style">
                            <tr class="tbl-head-style-cell">
                                <th class="tbl-head-style-cell">عنوان</th>
                                <th class="tbl-head-style-cell">مبلغ <span class="btn-red small-font">(ریال)</span></th>
                                <th class="tbl-head-style-cell">شماره</th>
                                <th class="tbl-head-style-cell">تاریخ</th>
                                <th class="tbl-head-style-cell">بررسی نشده</th>
                                <th class="tbl-head-style-cell"></th>
                            </tr>
                            </tbody>
                        </table>
                        <!--Table Head End-->
                        <!--Table Body Start-->
                        <div class="tbl_body_style dynamic-height-level2">
                            <table class="tbl-body-contain">
                                <colgroup>
                                    <col width="300px"/>
                                    <col width="150px"/>
                                    <col width="150px"/>
                                    <col width="150px"/>
                                    <col width="250px"/>
                                </colgroup>
                                <tbody class="tbl-head-style-cell">
                                <tr class="table-row" @click="openFactorDetailModal(index)" v-for="(refund,index) in refunds">
                                    <td>{{refund.rSubject}}</td>
                                    <td class="text-center">{{$root.dispMoneyFormat(refund.rAcceptedAmount)}}</td>
                                    <td class="text-center">{{refund.rLetterNumber}}</td>
                                    <td class="text-center">{{refund.rLetterDate}}</td>
                                    <td v-if="refund.unreadFactors > 0" class="text-center"><span class="danger-label">{{refund.unreadFactors}}</span></td>
                                    <td v-else class="text-center"></td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Accept Factor modal -->
        <modal-large v-if="showAcceptFactorModal" @close="showAcceptFactorModal = false">
            <div slot="body">
                <div class="small-font" xmlns:v-on="http://www.w3.org/1999/xhtml">
                   <div class="grid-x">
                       <div class="large-12 medium-12 small-12">
                           <ul class="tabs tab-color my-tab-style" data-responsive-accordion-tabs="tabs medium-accordion large-tabs" id="factor_tab_view">
                               <li class="tabs-title is-active"><a href="#waitingForAcceptTab" aria-selected="true">در انتظار بررسی</a></li>
                               <li class="tabs-title" v-show="$can('REGISTER_FACTOR_IN_REFUND')"><a href="#temporaryTab">موقت</a></li>
                           </ul>
                           <div class="tabs-content" data-tabs-content="factor_tab_view">
                               <!--Tab 1-->
                               <div class="tabs-panel is-active table-mrg-btm" id="waitingForAcceptTab">
                                   <div style="margin-top: 10px;margin-bottom: 20px">
                                       <div class="tbl-div-container">
                                           <table class="tbl-head">
                                               <colgroup>
                                                   <col width="250px"/>
                                                   <col width="150px"/>
                                                   <col width="200px"/>
                                                   <col width="300px"/>
                                                   <template v-if="selectedRefund.unreadFactors > 0">
                                                       <col width="150px"/>
                                                       <col width="80px"/>
                                                       <col width="150px"/>
                                                   </template>
                                                   <template v-else>
                                                       <col width="150px"/>
                                                   </template>
                                                   <col width="12px"/>
                                               </colgroup>
                                               <tbody class="tbl-head-style ">
                                               <tr class="tbl-head-style-cell">
                                                   <th class="tbl-head-style-cell">عنوان</th>
                                                   <th class="tbl-head-style-cell">مبلغ</th>
                                                   <th class="tbl-head-style-cell">فروشنده</th>
                                                   <th class="tbl-head-style-cell">شرح</th>
                                                   <template v-if=" selectedRefund.unreadFactors > 0">
                                                       <th class="tbl-head-style-cell"></th>
                                                       <th class="tbl-head-style-cell">وضعیت</th>
                                                       <th class="tbl-head-style-cell"></th>
                                                       <th class="tbl-head-style-cell"> </th>
                                                       <th class="tbl-head-style-cell"></th>
                                                   </template>
                                                   <template v-else>
                                                       <th class="tbl-head-style-cell">وضعیت</th>
                                                   </template>
                                                   <th class="tbl-head-style-cell"></th>
                                               </tr>
                                               </tbody>
                                               <!--Table Head End-->
                                               <!--Table Body Start-->
                                           </table>
                                           <div style="height: 50vh;" class="tbl_body_style inner-vh-unsize">
                                               <table class="tbl-body-contain">
                                                   <colgroup>
                                                       <col width="250px"/>
                                                       <col width="150px"/>
                                                       <col width="200px"/>
                                                       <col width="300px"/>
                                                       <template v-if=" selectedRefund.unreadFactors > 0">
                                                           <col width="150px"/>
                                                           <col width="80px"/>
                                                           <col width="150px"/>
                                                       </template>
                                                       <template v-else>
                                                           <col width="150px"/>
                                                       </template>
                                                   </colgroup>
                                                   <tbody class="tbl-head-style-cell">
                                                   <tr v-for="factor in waitingForAcceptFactors">
                                                       <td>{{factor.fSubject}}</td>
                                                       <td class="text-center">{{$root.dispMoneyFormat(factor.fAmount)}}</td>
                                                       <td class="text-center">{{factor.seller.sSubject}}</td>
                                                       <td class="text-justify">{{factor.fDescription}}</td>
                                                       <template v-if=" selectedRefund.unreadFactors > 0">
                                                           <template v-if="factor.factor_state.fsState == 'PENDING_REVIEW'">
                                                               <td class="text-center" v-show="factor.factor_state.fsState == 'PENDING_REVIEW'"><span class="reserved-label">{{ factor.factor_state.fsSubject }}</span></td>
                                                               <td class="text-center" v-show="$can('ACCEPT_FACTOR_IN_REFUND')">
                                                                   <a style="margin-bottom: 0px" class="my-button my-success small" @click="openConfirmFactor(factor.id)">تایید</a>
                                                               </td>
                                                               <td class="text-center" v-show="$can('ACCEPT_FACTOR_IN_REFUND')">
                                                                   <a style="margin-bottom: 0px" class="my-button toolbox-btn small" @click="openRejectFactor(factor.id)">عدم تایید</a>
                                                               </td>
                                                           </template>
                                                           <template v-else>
                                                               <td colspan="3" class="text-center" v-show="factor.factor_state.fsState == 'NOT_ACCEPTED'"><span class="blocked-label">{{ factor.factor_state.fsSubject }}</span></td>
                                                               <td colspan="3" class="text-center" v-show="factor.factor_state.fsState == 'ACCEPTED'"><span class="success-label">{{ factor.factor_state.fsSubject }}</span></td>
                                                           </template>
                                                       </template>
                                                       <template v-else>
                                                           <td class="text-center" v-show="factor.factor_state.fsState == 'NOT_ACCEPTED'"><span class="blocked-label">{{ factor.factor_state.fsSubject }}</span></td>
                                                           <td class="text-center" v-show="factor.factor_state.fsState == 'ACCEPTED'"><span class="success-label">{{ factor.factor_state.fsSubject }}</span></td>
                                                       </template>
                                                   </tr>
                                                   </tbody>
                                               </table>
                                           </div>
                                       </div>
                                       <!--Table Body End-->
                                       <div class="grid-x">
                                           <div style="background-color:#F1F1F1;padding: 10px;margin-top: -12px;border: solid 1.5px #D8DEE2;" class="large-12 medium-12 small-12">
                                               <div class="grid-x">
                                                   <div class="large-4 medium-4 small-12">
                                                       <p class="p-margin-btm"> مبلغ تنخواه : <span class="btn-red"> {{$root.dispMoneyFormat(selectedRefund.rAcceptedAmount)}} </span></p>
                                                   </div>
                                                   <div class="large-4 medium-4 small-12">
                                                       <p class="p-margin-btm"> مبلغ هزینه شده : <span class="btn-red"> {{$root.dispMoneyFormat(selectedRefund.rFinalSpent)}} </span></p>
                                                   </div>
                                                   <div class="large-4 medium-4 small-12">
                                                       <p class="p-margin-btm"> مبلغ باقی مانده : <span class="btn-red"> {{$root.dispMoneyFormat(selectedRefund.rAcceptedAmount - selectedRefund.rFinalSpent)}} </span></p>
                                                   </div>
                                               </div>
                                           </div>
                                       </div>
                                   </div>
                               </div>
                               <!--Tab 2-->
                               <div v-show="$can('REGISTER_FACTOR_IN_REFUND')" class="tabs-panel table-mrg-btm inner-vh-unsize" id="temporaryTab">
                                   <a class="my-button toolbox-btn small" @click="openInsertFactorModal()">فاکتور جدید</a>
                                   <div class="tbl-div-container">
                                       <table class="tbl-head">
                                           <colgroup>
                                               <col width="300px"/>
                                               <col width="150px"/>
                                               <col width="200px"/>
                                               <col width="300px"/>
                                               <col width="150px"/>
                                               <col width="12px"/>
                                           </colgroup>
                                           <tbody class="tbl-head-style ">
                                           <tr class="tbl-head-style-cell">
                                               <th class="tbl-head-style-cell">عنوان</th>
                                               <th class="tbl-head-style-cell">مبلغ</th>
                                               <th class="tbl-head-style-cell">فروشنده</th>
                                               <th class="tbl-head-style-cell">شرح</th>
                                               <th class="tbl-head-style-cell">وضعیت</th>
                                               <th class="tbl-head-style-cell"></th>
                                           </tr>
                                           </tbody>
                                           <!--Table Head End-->
                                           <!--Table Body Start-->
                                       </table>
                                       <div style="height: 36vh;" class="tbl_body_style inner-vh-unsize">
                                           <table class="tbl-body-contain">
                                               <colgroup>
                                                   <col width="300px"/>
                                                   <col width="150px"/>
                                                   <col width="200px"/>
                                                   <col width="300px"/>
                                                   <col width="150px"/>
                                               </colgroup>
                                               <tbody class="tbl-head-style-cell">
                                               <tr v-for="factor in temporaryFactors">
                                                   <td>{{factor.fSubject}}</td>
                                                   <td class="text-center">{{$root.dispMoneyFormat(factor.fAmount)}}</td>
                                                   <td class="text-center">{{factor.seller.sSubject}}</td>
                                                   <td class="text-justify">{{factor.fDescription}}</td>
                                                   <td class="text-center">
                                                       <div class="grid-x">
                                                           <div class="medium-11">
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
                                               </tbody>
                                           </table>
                                       </div>
                                   </div>
                                   <!--Table Body End-->
                                   <div class="grid-x">
                                       <div style="background-color:#F1F1F1;padding: 10px;margin-top: -12px;border: solid 1.5px #D8DEE2;" class="large-12 medium-12 small-12">
                                           <div class="grid-x">
                                               <div class="large-4 medium-4 small-12">
                                                   <p class="p-margin-btm"> مبلغ تنخواه : <span class="btn-red"> {{$root.dispMoneyFormat(selectedRefund.rAcceptedAmount)}} </span></p>
                                               </div>
                                               <div class="large-4 medium-4 small-12">
                                                   <p class="p-margin-btm"> مبلغ هزینه شده : <span class="btn-red"> {{$root.dispMoneyFormat(selectedRefund.rFinalSpent)}} </span></p>
                                               </div>
                                               <div class="large-4 medium-4 small-12">
                                                   <p class="p-margin-btm"> مبلغ باقی مانده : <span class="btn-red"> {{$root.dispMoneyFormat(selectedRefund.rAcceptedAmount - selectedRefund.rFinalSpent)}} </span></p>
                                               </div>
                                           </div>
                                       </div>
                                   </div>
                                   <div class="grid-x" style="margin-top: 10px">
                                       <div class="large-12 medium-12 small-12">
                                            <button @click="checkAcceptFactor()"  class="my-button my-success float-left"><span class="btn-txt-mrg">درخواست بررسی</span></button>
                                       </div>
                                   </div>
                               </div>
                           </div>
                       </div>
                   </div>
                </div>
            </div>
        </modal-large>
        <!-- Accept Factor modal -->

        <!-- Confirm Factor modal -->
        <modal-tiny v-if="showAcceptRefundFactor" @close="showAcceptRefundFactor = false">
            <div slot="body">
                <div class="small-font" xmlns:v-on="http://www.w3.org/1999/xhtml">
                    <p class="black-color text-justify" style="font-size: 1rem">کاربر گرامی:</p>
                    <p class="large-offset-1 modal-text">آیا برای تایید فاکتور اطمینان دارید؟</p>
                    <div class="grid-x">
                        <div class="medium-12 column text-center">
                            <button v-show="!$root.btnLoadingCheckStatus" v-on:click="acceptRefundFactor"   class="my-button my-success"><span class="btn-txt-mrg">   بله   </span></button>
                            <p v-show="$root.btnLoadingCheckStatus" class="my-button my-success"><i class="fas fa-spinner fa-pulse btn-txt-mrg"></i></p>
                        </div>
                    </div>
                </div>
            </div>
        </modal-tiny>
        <!-- Confirm Factor modal -->

        <!-- Reject Factor modal -->
        <modal-tiny v-if="showRejectRefundFactor" @close="showRejectRefundFactor = false">
            <div slot="body">
                <div class="small-font" xmlns:v-on="http://www.w3.org/1999/xhtml">
                    <p class="black-color text-justify" style="font-size: 1rem">کاربر گرامی:</p>
                    <p class="large-offset-1 modal-text">آیا برای عدم تایید فاکتور اطمینان دارید؟</p>
                    <div class="grid-x">
                        <div class="medium-12 column text-center">
                            <button  v-show="!$root.btnLoadingCheckStatus" v-on:click="rejectRefundFactor"   class="my-button my-success"><span class="btn-txt-mrg">   بله   </span></button>
                            <p v-show="$root.btnLoadingCheckStatus" class="my-button my-success"><i class="fas fa-spinner fa-pulse btn-txt-mrg"></i></p>
                        </div>
                    </div>
                </div>
            </div>
        </modal-tiny>
        <!-- Reject Factor modal -->
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
                                        <span class="btn-red">مبلغ تنخواه:</span><span>{{ ' ' + $root.dispMoneyFormat(selectedRefund.rAcceptedAmount) + 'ریال'}}</span>
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
                                        <span class="btn-red">مبلغ تنخواه:</span><span>{{ ' ' + $root.dispMoneyFormat(selectedRefund.rAcceptedAmount) + 'ریال'}}</span>
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
        <!--update Factor End-->
        <messageDialog v-show="showDialogModal" @close="showDialogModal =false">
            {{dialogMessage}}
        </messageDialog>
    </div>
</template>
<script>
    import Suggestions from "v-suggestions/src/Suggestions";
    import VuePersianDatetimePicker from 'vue-persian-datetime-picker';

    export default {
        components: {
            Suggestions,
            "vue-select": require("vue-select"),
            datePicker: VuePersianDatetimePicker,
        },

        data () {
            return {
                refunds:[],
                showInsertFactorModal:false,
                showDeleteConfirmModal: false,
                showAcceptConfirmModal: false,
                showUpdateFactorModal: false,
                showRequestDetailModal:false,
                showPrintCheckModal:false,
                showAcceptFactorModal:false,
                showAcceptRefundFactor:false,
                showRejectRefundFactor:false,
                baseURL:window.hostname+'/',
                updateDataThreadNowPlaying:null,
                money: {
                    thousands: ',',
                    precision: 0,
                    masked: true
                },
                allActiveCheckFormat:[],
                allCheckVerifiers:[],
                inputCheck:{},
                waitingForAcceptFactors:[],
                temporaryFactors:[],
                requestId:'',
                factorId:'',
                selectedRefund:[],
                selectedIndex: -1,
                sumOfFactors:0,
                moneyState:'none',
                refundRemainingAmount: 0,
                factorInput:{},
                dialogMessage: '',
                showDialogModal: false,
                sellerItems: [],
                sellerList: [],
                selectedFactorId: -1,

            }
        },

        created: function(){
            this.fetchAllRefund();
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

        watch: {
            // whenever question changes, this function will run
            refunds: function (newQuestion, oldQuestion) {
                if (this.selectedIndex != -1)
                {
                    this.selectedRefund=this.refunds[this.selectedIndex];
                    this.splitFactorDetail();
                }
                this.getPendingFactors();
                this.$root.getRefundCount();
            },
        },

        methods: {

            setUpdateDataThread: function () {
                console.log("...................................................... set search part update thread");
                if (this.updateDataThreadNowPlaying)
                    clearInterval(this.updateDataThreadNowPlaying);
                this.updateDataThreadNowPlaying = setInterval(this.updateDataThread, 60000);
            },

            updateDataThread: function () {
                console.log("...................................................... search part update thread");
                //this.fetchData();
            },

            fetchAllRefund: function () {
                axios.get('/financial/refund/fetch_all_refund')
                    .then((response) => {
                        this.refunds = response.data;
                        console.log(response);
                    }, (error) => {
                        console.log(error);
                });
            },

            getPendingFactors: function(){
                this.refunds.forEach(item => {
                    var pendingFactorsTemp=0;
                    item.factor.forEach(fac => {
                        if(fac.factor_state.fsState =='PENDING_REVIEW')

                            pendingFactorsTemp += 1;
                    });
                    item.rRelativeFactor.forEach(rFac => {
                        if(rFac.factor_state.fsState =='PENDING_REVIEW')
                            pendingFactorsTemp += 1;
                    });
                    Vue.set(item , "unreadFactors" ,pendingFactorsTemp);
                });
            },

            openFactorDetailModal : function(index){
                this.selectedIndex = index;
                this.selectedRefund = [];
                this.selectedRefund = this.refunds[this.selectedIndex];
                this.splitFactorDetail();
                this.showAcceptFactorModal=true;
            },

            splitFactorDetail : function () {
                this.waitingForAcceptFactors=[];
                this.temporaryFactors = [];
                this.selectedRefund.factor.forEach(item => {
                    if(item.factor_state.fsState != 'TEMPORARY')
                        this.waitingForAcceptFactors.push(item);
                    else
                        this.temporaryFactors.push(item);
                });
                this.selectedRefund.rRelativeFactor.forEach(item => {
                    if(item.factor_state.fsState != 'TEMPORARY')
                        this.waitingForAcceptFactors.push(item);
                    else
                        this.temporaryFactors.push(item);
                });
            },

            openConfirmFactor: function(fId){
                this.factorId=fId;
                this.showAcceptRefundFactor=true;
            },

            acceptRefundFactor: function(){
                var config = {
                    allowLoading:true,
                };
                axios.post('/financial/refund/factor/accept', {
                    fId:this.factorId,
                    rId: this.selectedRefund.id
                } , config).then((response) => {
                    this.refunds = response.data;
                    this.$emit('closeModal');
                    this.showAcceptRefundFactor=false;
                    this.$root.displayNotif(response.status);
                    console.log(response);
                }, (error) => {
                    console.log(error);
                    this.$root.displayNotif(error.response.status);
                });
            },

            openRejectFactor: function(fId){
                this.factorId=fId;
                this.showRejectRefundFactor=true;
            },

            rejectRefundFactor: function(){
                var config = {
                    allowLoading:true,
                };
                axios.post('/financial/refund/factor/reject', {
                    fId:this.factorId,
                } , config).then((response) => {
                    this.refunds = response.data;
                    this.$emit('closeModal');
                    this.showRejectRefundFactor=false;
                    this.$root.displayNotif(response.status);
                    console.log(response);
                }, (error) => {
                    console.log(error);
                    this.$root.displayNotif(error.response.status);
                });
            },

            getSumOfAllFactorAmount: function(){
                var sumTemp=0;
                this.sumOfFactors=0;
                this.selectedRefund.factor.forEach(item => {
                    if(item.factor_state.fsState != 'NOT_ACCEPTED')
                        sumTemp += item.fAmount;
                });

                this.selectedRefund.rRelativeFactor.forEach(item => {
                    if(item.factor_state.fsState != 'NOT_ACCEPTED')
                        sumTemp += item.fAmount;
                });

                this.sumOfFactors = sumTemp;
            },

            openInsertFactorModal:function () {
                this.getSumOfAllFactorAmount();
                if(this.sumOfFactors > this.selectedRefund.rAcceptedAmount){
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

            calculateRemainingAmount: function (inputValue = 0 , baseAmount = 0) {
                inputValue += ''; //for cast to string
                this.refundRemainingAmount = ((this.selectedRefund.rAcceptedAmount - this.sumOfFactors) - parseInt(inputValue.split(',').join(''),10)) + baseAmount;
                if (this.refundRemainingAmount < 0)
                    this.moneyState = 'block';
                else
                    this.moneyState = 'none';
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

            addNewFactor:function () {
                this.$validator.validateAll().then((result) => {
                    if (result) {
                        if ((parseInt(this.factorInput.amount.split(',').join(''),10) <= 0) || (this.refundRemainingAmount < 0))
                        {
                            this.moneyState = 'block';
                        }else {
                            this.moneyState = 'none';
                            axios.post('/financial/refund/factor/new', {
                                rId: this.selectedRefund.id,
                                searchValue: '',
                                subject: this.factorInput.subject,
                                seller: this.factorInput.seller,
                                amount: parseInt(this.factorInput.amount.split(',').join(''), 10),
                                description: this.factorInput.description,
                                resultType: 'REFUND'
                            }).then((response) => {
                                this.refunds = response.data;
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
                                searchValue: '',
                                refundId: '',
                                subject: this.factorInput.subject,
                                seller: this.factorInput.seller,
                                amount: parseInt(this.factorInput.amount.split(',').join(''),10),
                                description: this.factorInput.description,
                                resultType: 'REFUND'
                            }).then((response) => {
                                this.refunds = response.data
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

            openConfirmDeleteFactor: function(cId){
                this.selectedFactorId = cId;
                this.showDeleteConfirmModal = true;
            },

            deleteFactor: function() {
                axios.post('/financial/refund/factor/delete', {
                    fId: this.selectedFactorId,
                    searchValue: '',
                    resultType: 'REFUND'
                }).then((response) => {
                    if (response.status == 200)
                        this.refunds = response.data;
                    this.showDeleteConfirmModal = false;
                    this.$root.displayNotif(response.status);
                    console.log(response);
                }, (error) => {
                    console.log(error);
                    this.$root.displayNotif(error.response.status);
                });
            },

            checkAcceptFactor: function(){
                if (this.temporaryFactors.length > 0)
                {
                    this.showAcceptConfirmModal = true;
                }else{
                    this.dialogMessage = 'فاکتور تایید نشده ای موجود نیست! لطفا قبل از درخواست بررسی فاکتور نسبت به ثبت فاکتور جدید اقدام کنید.';
                    this.showDialogModal = true;
                }
            },

            acceptFactor: function(){
                axios.post('/financial/refund/factor/check_request', {
                    rId: this.selectedRefund.id,
                    searchValue: '',
                    resultType: 'REFUND'
                }).then((response) => {
                    this.refunds = response.data;
                    this.showAcceptConfirmModal=false;
                    this.$root.displayNotif(response.status);
                    console.log(response);
                }, (error) => {
                    console.log(error);
                    this.$root.displayNotif(error.response.status);
                });
            },
    }
}
</script>
