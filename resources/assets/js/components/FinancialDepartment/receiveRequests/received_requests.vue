<template>
<!--Body system-->
    <div class="medium-10 border-right-line inner-body-pad main-margin">
        <div class="grid-x padding-lr breadcrumbs-pos">
            <div class="medium-12">
                <div class="grid-x">
                    <nav aria-label="You are here:" role="navigation">
                        <ul class="breadcrumbs">
                            <li><router-link to="/budget">داشبورد</router-link></li>
                            <li>
                                <a class="disabled">کارتابل</a>
                            </li>
                            <li>
                                <span class="show-for-sr">Current: </span>درخواست های دریافتی
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
        <div class="grid-x my-callout-box container-mrg-top dynamic-height-level1">
            <!--receive_Requests_tab_view Start-->
            <div class="medium-12 padding-lr table-mrg-top">
                <ul class="tabs tab-color my-tab-style" data-responsive-accordion-tabs="tabs medium-accordion large-tabs" id="receive_Requests_tab_view">
                    <li v-if="rr_REQUEST_Unreads > 0" class="tabs-title is-active"><a href="#rr_REQUEST" aria-selected="true">  درخواست  <span v-show="rr_REQUEST_Unreads > 0" class="notif-badge-purple">{{rr_REQUEST_Unreads}}</span></a></li>
                    <li v-if="rr_REQUEST_Unreads == 0" class="tabs-title is-active"><a href="#rr_REQUEST" aria-selected="true">  درخواست  <span v-show="rr_REQUEST_Reads > 0" class="notif-badge-gray">{{rr_REQUEST_Reads}}</span></a></li>
                    <li v-if="rr_FINANCIAL_Unreads > 0" class="tabs-title"><a href="#rr_FINANCIAL"> تامین اعتبار <span v-show="rr_FINANCIAL_Unreads > 0" class="notif-badge-purple">{{rr_FINANCIAL_Unreads}}</span></a></li>
                    <li v-if="rr_FINANCIAL_Unreads == 0"class="tabs-title"><a href="#rr_FINANCIAL"> تامین اعتبار <span v-show="rr_FINANCIAL_Reads > 0" class="notif-badge-gray">{{rr_FINANCIAL_Reads}}</span></a></li>
                    <li v-if="rr_PURCHASE_AND_CONTRACT_Unreads > 0" class="tabs-title"><a href="#rr_PURCHASE_AND_CONTRACT"> خرید / قرارداد<span v-show="rr_PURCHASE_AND_CONTRACT_Unreads > 0" class="notif-badge-purple">{{rr_PURCHASE_AND_CONTRACT_Unreads}}</span></a></li>
                    <li v-if="rr_PURCHASE_AND_CONTRACT_Unreads == 0" class="tabs-title"><a href="#rr_PURCHASE_AND_CONTRACT"> خرید / قرارداد<span v-show="rr_PURCHASE_AND_CONTRACT_Reads > 0" class="notif-badge-gray">{{rr_PURCHASE_AND_CONTRACT_Reads}}</span></a></li>
                    <li v-if="rr_PAYMENT_Unreads > 0" class="tabs-title"><a href="#rr_PAYMENT"> درخواست پرداخت <span v-show="rr_PAYMENT_Unreads > 0" class="notif-badge-purple">{{rr_PAYMENT_Unreads}}</span></a></li>
                    <li v-if="rr_PAYMENT_Unreads == 0" class="tabs-title"><a href="#rr_PAYMENT"> درخواست پرداخت <span v-show="rr_PAYMENT_Reads > 0" class="notif-badge-gray">{{rr_PAYMENT_Reads}}</span></a></li>
                    <li v-if="rr_DRAFT_Unreads > 0" class="tabs-title"><a href="#rr_DRAFT"> حواله <span v-show="rr_DRAFT_Unreads > 0" class="notif-badge-purple">{{rr_DRAFT_Unreads}}</span></a></li>
                    <li v-if="rr_DRAFT_Unreads == 0" class="tabs-title"><a href="#rr_DRAFT"> حواله <span v-show="rr_DRAFT_Reads > 0" class="notif-badge-gray">{{rr_DRAFT_Reads}}</span></a></li>
                </ul>
                <div class="tabs-content" data-tabs-content="receive_Requests_tab_view">
                    <!--receiveRequests_REQUEST Tab-->
                    <div class="tabs-panel is-active table-mrg-btm" id="rr_REQUEST">
                        <div class="grid-x">
                            <div class="large-12 medium-12 small-12">
                                <div class="tbl-div-container">
                                    <table class="tbl-head">
                                        <colgroup>
                                            <col width="80px"/>
                                            <col width="400px"/>
                                            <col width="400px"/>
                                            <col width="150px"/>
                                            <col width="200x"/>
                                            <col width="200px"/>
                                            <col width="200px"/>
                                            <col width="150px"/>
                                            <col width="12px"/>
                                        </colgroup>
                                        <tbody class="tbl-head-style">
                                        <tr class="tbl-head-style-cell">
                                            <th class="tbl-head-style-cell">وضعیت</th>
                                            <th class="tbl-head-style-cell">عنوان</th>
                                            <th class="tbl-head-style-cell">ارسال کننده</th>
                                            <th class="tbl-head-style-cell">نوع درخواست</th>
                                            <th class="tbl-head-style-cell">مبلغ برآوردی <span class="btn-red small-font">(ریال)</span></th>
                                            <th class="tbl-head-style-cell">مبلغ نهایی <span class="btn-red small-font">(ریال)</span></th>
                                            <th class="tbl-head-style-cell">شماره</th>
                                            <th class="tbl-head-style-cell">تاریخ</th>
                                            <th class="tbl-head-style-cell"></th>
                                        </tr>
                                        </tbody>
                                    </table>
                                    <!--Table Head End-->
                                    <!--Table Body Start-->
                                    <div class="tbl_body_style dynamic-height-levelR">
                                        <table class="tbl-body-contain">
                                            <colgroup>
                                                <col width="15vw"/>
                                                <col width="400px"/>
                                                <col width="400px"/>
                                                <col width="150px"/>
                                                <col width="200x"/>
                                                <col width="200px"/>
                                                <col width="200px"/>
                                                <col width="150px"/>
                                                <col width="12px"/>
                                            </colgroup>
                                            <tbody class="tbl-head-style-cell">
                                            <tr class="table-row" @click="getRequestDetail(receiveRequest)" v-for="receiveRequest in receiveRequests_REQUEST">
                                                <td v-show="receiveRequest.rLastRef.rhHasBeenSeen == 0" class="text-center icon-padding-btm"><i class="far fa-envelope size-21 purple-color"></i></td>
                                                <td v-show="receiveRequest.rLastRef.rhHasBeenSeen == 1" class="text-center icon-padding-btm"><i class="far fa-envelope-open size-21 purple-color"></i></td>
                                                <td>{{receiveRequest.rSubject}}</td>
                                                <td :data-toggle="'lastRef' + receiveRequest.id">{{receiveRequest.rLastRef.source_user_info.name}} - {{receiveRequest.rLastRef.source_user_info.role.rSubject}}
                                                    <div class="clearfix tool-bar" v-if="receiveRequest.rLastRef.rhDescription !== null">
                                                        <div  style="width: 300px;" class="dropdown-pane dropdown-pane-sm " data-close-on-click="true"  data-hover="true" data-hover-pane="true" data-h-offset="20px"  data-position="auto" data-alignment="auto" :id="'lastRef' + receiveRequest.id" data-dropdown data-auto-focus="true">
                                                            <ul class="my-menu small-font">
                                                                <div class="grid-x">
                                                                    <div class="medium-12">
                                                                        <p class="black-color">{{receiveRequest.rLastRef.source_user_info.name}} - {{receiveRequest.rLastRef.source_user_info.role.rSubject}}</p>
                                                                        <p class="gray-colors text-justify" style="margin-top: -10px">{{ receiveRequest.rLastRef.rhDescription }}</p>
                                                                        <p style="direction: ltr;margin-bottom: -10px;" class="gray-color small-font float-left"><i class="far fa-calendar-alt"></i><span> {{receiveRequest.rLastRef.rhShamsiDate}} </span> - <i class="far fa-clock"></i> <span>{{receiveRequest.rLastRef.rhShamsiTime}}</span></p>
                                                                    </div>
                                                                </div>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>{{ receiveRequest.request_type.rtSubject }}</td>
                                                <template v-if="receiveRequest.request_type.rtType == 'BUY_SERVICES' || receiveRequest.request_type.rtType == 'BUY_COMMODITY'">
                                                    <td class="text-center">{{$parent.dispMoneyFormat(receiveRequest.rCostEstimation)}}</td>
                                                    <td class="text-center" v-if="receiveRequest.rAcceptedAmount > 0">
                                                        <div v-if="parseInt(receiveRequest.rAcceptedAmount) != parseInt(receiveRequest.rCommitmentAmount)">
                                                            <span class="danger-label" :data-toggle="'needForEditFinancing' + receiveRequest.id">{{$parent.dispMoneyFormat(receiveRequest.rAcceptedAmount)}}</span>
                                                            <div class="clearfix tool-bar">
                                                                <div  style="width: 300px;" class="dropdown-pane dropdown-pane-sm " data-close-on-click="true"  data-hover="true" data-hover-pane="true" data-h-offset="20px"  data-position="auto" data-alignment="auto" :id="'needForEditFinancing' + receiveRequest.id" data-dropdown data-auto-focus="true">
                                                                    <ul class="my-menu small-font">
                                                                        <div class="grid-x">
                                                                            <div class="medium-12">
                                                                                <p class="black-color text-justify">کاربر گرامی:</p>
                                                                                <p class="gray-colors text-justify" style="margin-top: -10px">مبلغ قرارداد / فاکتور با مبلغ تعهد شده از محل های تامین اعتبار تفاوت دارد، لطفا نسبت به اصلاح تامین اعتبار اقدام کنید.</p>
                                                                            </div>
                                                                        </div>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div v-else="">
                                                            {{$parent.dispMoneyFormat(receiveRequest.rAcceptedAmount)}}
                                                        </div>
                                                    </td>
                                                    <td v-else-if="receiveRequest.request_type.rtType == 'BUY_SERVICES'" class="text-center"><span class="reserved-label">فاقد قرارداد</span></td>
                                                    <td v-else-if="receiveRequest.request_type.rtType == 'BUY_COMMODITY'" class="text-center"><span class="reserved-label">فاقد فاکتور</span></td>
                                                </template>
                                                <template v-else>
                                                    <td colspan="2" class="text-center">{{$parent.dispMoneyFormat(receiveRequest.rCostEstimation)}}</td>
                                                </template>
                                                <td class="text-center">{{receiveRequest.rLetterNumber}}</td>
                                                <td class="text-center">{{receiveRequest.rLetterDate}}</td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="grid-x">
                                    <div class="medium-12">
                                        <vue-pagination  v-bind:pagination="received_pagination_REQUEST"
                                                         v-on:click.native="fetchData(received_pagination_REQUEST.current_page)"
                                                         :offset="4">
                                        </vue-pagination>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--receiveRequests_REQUEST Tab-->

                    <!--receiveRequests_FINANCIAL Tab-->
                    <div class="tabs-panel table-mrg-btm" id="rr_FINANCIAL">
                        <div class="grid-x">
                            <div class="large-12 medium-12 small-12">
                                <div class="tbl-div-container">
                                    <table class="tbl-head">
                                        <colgroup>
                                            <col width="80px"/>
                                            <col width="400px"/>
                                            <col width="400px"/>
                                            <col width="150px"/>
                                            <col width="200x"/>
                                            <col width="200px"/>
                                            <col width="200px"/>
                                            <col width="150px"/>
                                            <col width="12px"/>
                                        </colgroup>
                                        <tbody class="tbl-head-style">
                                        <tr class="tbl-head-style-cell">
                                            <th class="tbl-head-style-cell">وضعیت</th>
                                            <th class="tbl-head-style-cell">عنوان</th>
                                            <th class="tbl-head-style-cell">ارسال کننده</th>
                                            <th class="tbl-head-style-cell">نوع درخواست</th>
                                            <th class="tbl-head-style-cell">مبلغ برآوردی <span class="btn-red small-font">(ریال)</span></th>
                                            <th class="tbl-head-style-cell">مبلغ نهایی <span class="btn-red small-font">(ریال)</span></th>
                                            <th class="tbl-head-style-cell">شماره</th>
                                            <th class="tbl-head-style-cell">تاریخ</th>
                                            <th class="tbl-head-style-cell"></th>
                                        </tr>
                                        </tbody>
                                    </table>
                                    <!--Table Head End-->
                                    <!--Table Body Start-->
                                    <div class="tbl_body_style dynamic-height-levelR">
                                        <table class="tbl-body-contain">
                                            <colgroup>
                                                <col width="80px"/>
                                                <col width="400px"/>
                                                <col width="400px"/>
                                                <col width="150px"/>
                                                <col width="200x"/>
                                                <col width="200px"/>
                                                <col width="200px"/>
                                                <col width="150px"/>
                                                <col width="12px"/>
                                            </colgroup>
                                            <tbody class="tbl-head-style-cell">
                                            <tr class="table-row" @click="getRequestDetail(receiveFinancial)" v-for="receiveFinancial in receiveRequests_FINANCIAL">
                                                <td v-show="receiveFinancial.rLastRef.rhHasBeenSeen == 0" class="text-center icon-padding-btm"><i class="far fa-envelope size-21 purple-color"></i></td>
                                                <td v-show="receiveFinancial.rLastRef.rhHasBeenSeen == 1" class="text-center icon-padding-btm"><i class="far fa-envelope-open size-21 purple-color"></i></td>
                                                <td>{{receiveFinancial.rSubject}}</td>
                                                <td :data-toggle="'lastRef' + receiveFinancial.id">{{receiveFinancial.rLastRef.source_user_info.name}} - {{receiveFinancial.rLastRef.source_user_info.role.rSubject}}
                                                    <div class="clearfix tool-bar" v-if="receiveFinancial.rLastRef.rhDescription !== null || receiveFinancial.request_history_last_point.length > 0">
                                                        <div  style="width: 300px;" class="dropdown-pane dropdown-pane-sm " data-close-on-click="true"  data-hover="true" data-hover-pane="true" data-h-offset="20px"  data-position="auto" data-alignment="auto" :id="'lastRef' + receiveFinancial.id" data-dropdown data-auto-focus="true">
                                                            <ul class="my-menu small-font">
                                                                <div class="grid-x">
                                                                    <div class="medium-12">
                                                                        <p class="black-color" v-if="receiveFinancial.rLastRef.rhDescription !== null">{{receiveFinancial.rLastRef.source_user_info.name}} - {{receiveFinancial.rLastRef.source_user_info.role.rSubject}}</p>
                                                                        <p class="gray-colors text-justify" style="margin-top: -10px" v-if="receiveFinancial.rLastRef.rhDescription !== null">{{ receiveFinancial.rLastRef.rhDescription }}</p>
                                                                        <p style="direction: ltr;margin-bottom: -10px;" class="gray-color small-font float-left" v-if="receiveFinancial.rLastRef.rhDescription !== null"><i class="far fa-calendar-alt"></i><span> {{receiveFinancial.rLastRef.rhShamsiDate}} </span> - <i class="far fa-clock"></i> <span>{{receiveFinancial.rLastRef.rhShamsiTime}}</span></p>
                                                                        <br v-if="receiveFinancial.request_history_last_point.length > 0"/>
                                                                        <p class="btn-red" v-if="receiveFinancial.request_history_last_point.length > 0">نکته:</p>
                                                                        <p class="gray-colors text-justify" style="margin-top: -10px" v-if="receiveFinancial.request_history_last_point.length > 0">{{ receiveFinancial.request_history_last_point[0].rhlpDescription }}</p>
                                                                    </div>
                                                                </div>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>{{ receiveFinancial.request_type.rtSubject }}</td>
                                                <template v-if="receiveFinancial.request_type.rtType == 'BUY_SERVICES' || receiveFinancial.request_type.rtType == 'BUY_COMMODITY'">
                                                    <td class="text-center">{{$parent.dispMoneyFormat(receiveFinancial.rCostEstimation)}}</td>
                                                    <td class="text-center" v-if="receiveFinancial.rAcceptedAmount > 0">
                                                        <div v-if="parseInt(receiveFinancial.rAcceptedAmount) != parseInt(receiveFinancial.rCommitmentAmount)">
                                                            <span class="danger-label" :data-toggle="'needForEditFinancing' + receiveFinancial.id">{{$parent.dispMoneyFormat(receiveFinancial.rAcceptedAmount)}}</span>
                                                            <div class="clearfix tool-bar">
                                                                <div  style="width: 300px;" class="dropdown-pane dropdown-pane-sm " data-close-on-click="true"  data-hover="true" data-hover-pane="true" data-h-offset="20px"  data-position="auto" data-alignment="auto" :id="'needForEditFinancing' + receiveFinancial.id" data-dropdown data-auto-focus="true">
                                                                    <ul class="my-menu small-font">
                                                                        <div class="grid-x">
                                                                            <div class="medium-12">
                                                                                <p class="black-color text-justify">کاربر گرامی:</p>
                                                                                <p class="gray-colors text-justify" style="margin-top: -10px">مبلغ قرارداد / فاکتور با مبلغ تعهد شده از محل های تامین اعتبار تفاوت دارد، لطفا نسبت به اصلاح تامین اعتبار اقدام کنید.</p>
                                                                            </div>
                                                                        </div>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div v-else="">
                                                            {{$parent.dispMoneyFormat(receiveFinancial.rAcceptedAmount)}}
                                                        </div>
                                                    </td>
                                                    <td v-else-if="receiveFinancial.request_type.rtType == 'BUY_SERVICES'" class="text-center"><span class="reserved-label">فاقد قرارداد</span></td>
                                                    <td v-else-if="receiveFinancial.request_type.rtType == 'BUY_COMMODITY'" class="text-center"><span class="reserved-label">فاقد فاکتور</span></td>
                                                </template>
                                                <template v-else>
                                                    <td colspan="2" class="text-center">{{$parent.dispMoneyFormat(receiveFinancial.rCostEstimation)}}</td>
                                                </template>
                                                <td class="text-center">{{receiveFinancial.rLetterNumber}}</td>
                                                <td class="text-center">{{receiveFinancial.rLetterDate}}</td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="grid-x">
                                    <div class="medium-12">
                                        <vue-pagination  v-bind:pagination="received_pagination_FINANCIAL"
                                                         v-on:click.native="fetchData(received_pagination_FINANCIAL.current_page)"
                                                         :offset="4">
                                        </vue-pagination>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--receiveRequests_FINANCIAL Tab-->

                    <!--receiveRequests_PURCHASE_AND_CONTRACT Tab-->
                    <div class="tabs-panel table-mrg-btm" id="rr_PURCHASE_AND_CONTRACT">
                        <div class="grid-x">
                            <div class="large-12 medium-12 small-12">
                                <div class="tbl-div-container">
                                    <table class="tbl-head">
                                        <colgroup>
                                            <col width="80px"/>
                                            <col width="400px"/>
                                            <col width="400px"/>
                                            <col width="150px"/>
                                            <col width="200x"/>
                                            <col width="200px"/>
                                            <col width="200px"/>
                                            <col width="150px"/>
                                            <col width="12px"/>
                                        </colgroup>
                                        <tbody class="tbl-head-style">
                                        <tr class="tbl-head-style-cell">
                                            <th class="tbl-head-style-cell">وضعیت</th>
                                            <th class="tbl-head-style-cell">عنوان</th>
                                            <th class="tbl-head-style-cell">ارسال کننده</th>
                                            <th class="tbl-head-style-cell">نوع درخواست</th>
                                            <th class="tbl-head-style-cell">مبلغ برآوردی <span class="btn-red small-font">(ریال)</span></th>
                                            <th class="tbl-head-style-cell">مبلغ نهایی <span class="btn-red small-font">(ریال)</span></th>
                                            <th class="tbl-head-style-cell">شماره</th>
                                            <th class="tbl-head-style-cell">تاریخ</th>
                                            <th class="tbl-head-style-cell"></th>
                                        </tr>
                                        </tbody>
                                    </table>
                                    <!--Table Head End-->
                                    <!--Table Body Start-->
                                    <div class="tbl_body_style dynamic-height-levelR">
                                        <table class="tbl-body-contain">
                                            <colgroup>
                                                <col width="80px"/>
                                                <col width="400px"/>
                                                <col width="400px"/>
                                                <col width="150px"/>
                                                <col width="200x"/>
                                                <col width="200px"/>
                                                <col width="200px"/>
                                                <col width="150px"/>
                                                <col width="12px"/>
                                            </colgroup>
                                            <tbody class="tbl-head-style-cell">
                                            <tr class="table-row" @click="getRequestDetail(receivePAndC)" v-for="receivePAndC in receiveRequests_PURCHASE_AND_CONTRACT">
                                                <td v-show="receivePAndC.rLastRef.rhHasBeenSeen == 0" class="text-center icon-padding-btm"><i class="far fa-envelope size-21 purple-color"></i></td>
                                                <td v-show="receivePAndC.rLastRef.rhHasBeenSeen == 1" class="text-center icon-padding-btm"><i class="far fa-envelope-open size-21 purple-color"></i></td>
                                                <td>{{receivePAndC.rSubject}}</td>
                                                <td :data-toggle="'lastRef' + receivePAndC.id">{{receivePAndC.rLastRef.source_user_info.name}} - {{receivePAndC.rLastRef.source_user_info.role.rSubject}}
                                                    <div class="clearfix tool-bar" v-if="receivePAndC.rLastRef.rhDescription !== null">
                                                        <div  style="width: 300px;" class="dropdown-pane dropdown-pane-sm " data-close-on-click="true"  data-hover="true" data-hover-pane="true" data-h-offset="20px"  data-position="auto" data-alignment="auto" :id="'lastRef' + receivePAndC.id" data-dropdown data-auto-focus="true">
                                                            <ul class="my-menu small-font">
                                                                <div class="grid-x">
                                                                    <div class="medium-12">
                                                                        <p class="black-color">{{receivePAndC.rLastRef.source_user_info.name}} - {{receivePAndC.rLastRef.source_user_info.role.rSubject}}</p>
                                                                        <p class="gray-colors text-justify" style="margin-top: -10px">{{ receivePAndC.rLastRef.rhDescription }}</p>
                                                                        <p style="direction: ltr;margin-bottom: -10px;" class="gray-color small-font float-left"><i class="far fa-calendar-alt"></i><span> {{receivePAndC.rLastRef.rhShamsiDate}} </span> - <i class="far fa-clock"></i> <span>{{receivePAndC.rLastRef.rhShamsiTime}}</span></p>
                                                                    </div>
                                                                </div>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>{{ receivePAndC.request_type.rtSubject }}</td>
                                                <template v-if="receivePAndC.request_type.rtType == 'BUY_SERVICES' || receivePAndC.request_type.rtType == 'BUY_COMMODITY'">
                                                    <td class="text-center">{{$parent.dispMoneyFormat(receivePAndC.rCostEstimation)}}</td>
                                                    <td class="text-center" v-if="receivePAndC.rAcceptedAmount > 0">
                                                        <div v-if="parseInt(receivePAndC.rAcceptedAmount) != parseInt(receivePAndC.rCommitmentAmount)">
                                                            <span class="danger-label" :data-toggle="'needForEditFinancing' + receivePAndC.id">{{$parent.dispMoneyFormat(receivePAndC.rAcceptedAmount)}}</span>
                                                            <div class="clearfix tool-bar">
                                                                <div  style="width: 300px;" class="dropdown-pane dropdown-pane-sm " data-close-on-click="true"  data-hover="true" data-hover-pane="true" data-h-offset="20px"  data-position="auto" data-alignment="auto" :id="'needForEditFinancing' + receivePAndC.id" data-dropdown data-auto-focus="true">
                                                                    <ul class="my-menu small-font">
                                                                        <div class="grid-x">
                                                                            <div class="medium-12">
                                                                                <p class="black-color text-justify">کاربر گرامی:</p>
                                                                                <p class="gray-colors text-justify" style="margin-top: -10px">مبلغ قرارداد / فاکتور با مبلغ تعهد شده از محل های تامین اعتبار تفاوت دارد، لطفا نسبت به اصلاح تامین اعتبار اقدام کنید.</p>
                                                                            </div>
                                                                        </div>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div v-else="">
                                                            {{$parent.dispMoneyFormat(receivePAndC.rAcceptedAmount)}}
                                                        </div>
                                                    </td>
                                                    <td v-else-if="receivePAndC.request_type.rtType == 'BUY_SERVICES'" class="text-center"><span class="reserved-label">فاقد قرارداد</span></td>
                                                    <td v-else-if="receivePAndC.request_type.rtType == 'BUY_COMMODITY'" class="text-center"><span class="reserved-label">فاقد فاکتور</span></td>
                                                </template>
                                                <template v-else>
                                                    <td colspan="2" class="text-center">{{$parent.dispMoneyFormat(receivePAndC.rCostEstimation)}}</td>
                                                </template>
                                                <td class="text-center">{{receivePAndC.rLetterNumber}}</td>
                                                <td class="text-center">{{receivePAndC.rLetterDate}}</td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="grid-x">
                                    <div class="medium-12">
                                        <vue-pagination  v-bind:pagination="received_pagination_PURCHASE_AND_CONTRACT"
                                                         v-on:click.native="fetchData(received_pagination_PURCHASE_AND_CONTRACT.current_page)"
                                                         :offset="4">
                                        </vue-pagination>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--receiveRequests_PURCHASE_AND_CONTRACT Tab-->

                    <!--receiveRequests_PAYMENT Tab-->
                    <div class="tabs-panel table-mrg-btm" id="rr_PAYMENT">
                        <div class="grid-x">
                            <div class="large-12 medium-12 small-12">
                                <div class="tbl-div-container">
                                    <table class="tbl-head">
                                        <colgroup>
                                            <col width="80px"/>
                                            <col width="400px"/>
                                            <col width="400px"/>
                                            <col width="150px"/>
                                            <col width="200x"/>
                                            <col width="200px"/>
                                            <col width="200px"/>
                                            <col width="150px"/>
                                            <col width="12px"/>
                                        </colgroup>
                                        <tbody class="tbl-head-style">
                                        <tr class="tbl-head-style-cell">
                                            <th class="tbl-head-style-cell">وضعیت</th>
                                            <th class="tbl-head-style-cell">عنوان</th>
                                            <th class="tbl-head-style-cell">ارسال کننده</th>
                                            <th class="tbl-head-style-cell">نوع درخواست</th>
                                            <th class="tbl-head-style-cell">مبلغ برآوردی <span class="btn-red small-font">(ریال)</span></th>
                                            <th class="tbl-head-style-cell">مبلغ نهایی <span class="btn-red small-font">(ریال)</span></th>
                                            <th class="tbl-head-style-cell">شماره</th>
                                            <th class="tbl-head-style-cell">تاریخ</th>
                                            <th class="tbl-head-style-cell"></th>
                                        </tr>
                                        </tbody>
                                    </table>
                                    <!--Table Head End-->
                                    <!--Table Body Start-->
                                    <div class="tbl_body_style dynamic-height-levelR">
                                        <table class="tbl-body-contain">
                                            <colgroup>
                                                <col width="80px"/>
                                                <col width="400px"/>
                                                <col width="400px"/>
                                                <col width="150px"/>
                                                <col width="200x"/>
                                                <col width="200px"/>
                                                <col width="200px"/>
                                                <col width="150px"/>
                                                <col width="12px"/>
                                            </colgroup>
                                            <tbody class="tbl-head-style-cell">
                                            <tr class="table-row" @click="getRequestDetail(receivePayment)" v-for="receivePayment in receiveRequests_PAYMENT">
                                                <td v-show="receivePayment.rLastRef.rhHasBeenSeen == 0" class="text-center icon-padding-btm"><i class="far fa-envelope size-21 purple-color"></i></td>
                                                <td v-show="receivePayment.rLastRef.rhHasBeenSeen == 1" class="text-center icon-padding-btm"><i class="far fa-envelope-open size-21 purple-color"></i></td>
                                                <td>{{receivePayment.rSubject}}</td>
                                                <td :data-toggle="'lastRef' + receivePayment.id">{{receivePayment.rLastRef.source_user_info.name}} - {{receivePayment.rLastRef.source_user_info.role.rSubject}}
                                                    <div class="clearfix tool-bar" v-if="receivePayment.rLastRef.rhDescription !== null">
                                                        <div  style="width: 300px;" class="dropdown-pane dropdown-pane-sm " data-close-on-click="true"  data-hover="true" data-hover-pane="true" data-h-offset="20px"  data-position="auto" data-alignment="auto" :id="'lastRef' + receivePayment.id" data-dropdown data-auto-focus="true">
                                                            <ul class="my-menu small-font">
                                                                <div class="grid-x">
                                                                    <div class="medium-12">
                                                                        <p class="black-color">{{receivePayment.rLastRef.source_user_info.name}} - {{receivePayment.rLastRef.source_user_info.role.rSubject}}</p>
                                                                        <p class="gray-colors text-justify" style="margin-top: -10px">{{ receivePayment.rLastRef.rhDescription }}</p>
                                                                        <p style="direction: ltr;margin-bottom: -10px;" class="gray-color small-font float-left"><i class="far fa-calendar-alt"></i><span> {{receivePayment.rLastRef.rhShamsiDate}} </span> - <i class="far fa-clock"></i> <span>{{receivePayment.rLastRef.rhShamsiTime}}</span></p>
                                                                    </div>
                                                                </div>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>{{ receivePayment.request_type.rtSubject }}</td>
                                                <template v-if="receivePayment.request_type.rtType == 'BUY_SERVICES' || receivePayment.request_type.rtType == 'BUY_COMMODITY'">
                                                    <td class="text-center">{{$parent.dispMoneyFormat(receivePayment.rCostEstimation)}}</td>
                                                    <td class="text-center" v-if="receivePayment.rAcceptedAmount > 0">
                                                        <div v-if="parseInt(receivePayment.rAcceptedAmount) != parseInt(receivePayment.rCommitmentAmount)">
                                                            <span class="danger-label" :data-toggle="'needForEditFinancing' + receivePayment.id">{{$parent.dispMoneyFormat(receivePayment.rAcceptedAmount)}}</span>
                                                            <div class="clearfix tool-bar">
                                                                <div  style="width: 300px;" class="dropdown-pane dropdown-pane-sm " data-close-on-click="true"  data-hover="true" data-hover-pane="true" data-h-offset="20px"  data-position="auto" data-alignment="auto" :id="'needForEditFinancing' + receivePayment.id" data-dropdown data-auto-focus="true">
                                                                    <ul class="my-menu small-font">
                                                                        <div class="grid-x">
                                                                            <div class="medium-12">
                                                                                <p class="black-color text-justify">کاربر گرامی:</p>
                                                                                <p class="gray-colors text-justify" style="margin-top: -10px">مبلغ قرارداد / فاکتور با مبلغ تعهد شده از محل های تامین اعتبار تفاوت دارد، لطفا نسبت به اصلاح تامین اعتبار اقدام کنید.</p>
                                                                            </div>
                                                                        </div>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div v-else="">
                                                            {{$parent.dispMoneyFormat(receivePayment.rAcceptedAmount)}}
                                                        </div>
                                                    </td>
                                                    <td v-else-if="receivePayment.request_type.rtType == 'BUY_SERVICES'" class="text-center"><span class="reserved-label">فاقد قرارداد</span></td>
                                                    <td v-else-if="receivePayment.request_type.rtType == 'BUY_COMMODITY'" class="text-center"><span class="reserved-label">فاقد فاکتور</span></td>
                                                </template>
                                                <template v-else>
                                                    <td colspan="2" class="text-center">{{$parent.dispMoneyFormat(receivePayment.rCostEstimation)}}</td>
                                                </template>
                                                <td class="text-center">{{receivePayment.rLetterNumber}}</td>
                                                <td class="text-center">{{receivePayment.rLetterDate}}</td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="grid-x">
                                    <div class="medium-12">
                                        <vue-pagination  v-bind:pagination="received_pagination_PAYMENT"
                                                         v-on:click.native="fetchData(received_pagination_PAYMENT.current_page)"
                                                         :offset="4">
                                        </vue-pagination>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--receiveRequests_PAYMENT Tab-->

                    <!--receiveRequests_DRAFT Tab-->
                    <div class="tabs-panel table-mrg-btm" id="rr_DRAFT">
                        <div class="grid-x">
                            <div class="large-12 medium-12 small-12">
                                <div class="tbl-div-container">
                                    <table class="tbl-head">
                                        <colgroup>
                                            <col width="80px"/>
                                            <col width="400px"/>
                                            <col width="400px"/>
                                            <col width="150px"/>
                                            <col width="200x"/>
                                            <col width="200px"/>
                                            <col width="200px"/>
                                            <col width="150px"/>
                                            <col width="12px"/>
                                        </colgroup>
                                        <tbody class="tbl-head-style">
                                        <tr class="tbl-head-style-cell">
                                            <th class="tbl-head-style-cell">وضعیت</th>
                                            <th class="tbl-head-style-cell">عنوان</th>
                                            <th class="tbl-head-style-cell">ارسال کننده</th>
                                            <th class="tbl-head-style-cell">نوع درخواست</th>
                                            <th class="tbl-head-style-cell">مبلغ برآوردی <span class="btn-red small-font">(ریال)</span></th>
                                            <th class="tbl-head-style-cell">مبلغ نهایی <span class="btn-red small-font">(ریال)</span></th>
                                            <th class="tbl-head-style-cell">شماره</th>
                                            <th class="tbl-head-style-cell">تاریخ</th>
                                            <th class="tbl-head-style-cell"></th>
                                        </tr>
                                        </tbody>
                                    </table>
                                    <!--Table Head End-->
                                    <!--Table Body Start-->
                                    <div class="tbl_body_style dynamic-height-levelR">
                                        <table class="tbl-body-contain">
                                            <colgroup>
                                                <col width="80px"/>
                                                <col width="400px"/>
                                                <col width="400px"/>
                                                <col width="150px"/>
                                                <col width="200x"/>
                                                <col width="200px"/>
                                                <col width="200px"/>
                                                <col width="150px"/>
                                                <col width="12px"/>
                                            </colgroup>
                                            <tbody class="tbl-head-style-cell">
                                            <tr class="table-row" @click="getRequestDetail(receiveDraft)" v-for="receiveDraft in receiveRequests_DRAFT">
                                                <td v-show="receiveDraft.rLastRef.rhHasBeenSeen == 0" class="text-center icon-padding-btm"><i class="far fa-envelope size-21 purple-color"></i></td>
                                                <td v-show="receiveDraft.rLastRef.rhHasBeenSeen == 1" class="text-center icon-padding-btm"><i class="far fa-envelope-open size-21 purple-color"></i></td>
                                                <td>{{receiveDraft.rSubject}}</td>
                                                <td :data-toggle="'lastRef' + receiveDraft.id">{{receiveDraft.rLastRef.source_user_info.name}} - {{receiveDraft.rLastRef.source_user_info.role.rSubject}}
                                                    <div class="clearfix tool-bar" v-if="receiveDraft.rLastRef.rhDescription !== null">
                                                        <div  style="width: 300px;" class="dropdown-pane dropdown-pane-sm " data-close-on-click="true"  data-hover="true" data-hover-pane="true" data-h-offset="20px"  data-position="auto" data-alignment="auto" :id="'lastRef' + receiveDraft.id" data-dropdown data-auto-focus="true">
                                                            <ul class="my-menu small-font">
                                                                <div class="grid-x">
                                                                    <div class="medium-12">
                                                                        <p class="black-color">{{receiveDraft.rLastRef.source_user_info.name}} - {{receiveDraft.rLastRef.source_user_info.role.rSubject}}</p>
                                                                        <p class="gray-colors text-justify" style="margin-top: -10px">{{ receiveDraft.rLastRef.rhDescription }}</p>
                                                                        <p style="direction: ltr;margin-bottom: -10px;" class="gray-color small-font float-left"><i class="far fa-calendar-alt"></i><span> {{receiveDraft.rLastRef.rhShamsiDate}} </span> - <i class="far fa-clock"></i> <span>{{receiveDraft.rLastRef.rhShamsiTime}}</span></p>
                                                                    </div>
                                                                </div>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>{{ receiveDraft.request_type.rtSubject }}</td>
                                                <template v-if="receiveDraft.request_type.rtType == 'BUY_SERVICES' || receiveDraft.request_type.rtType == 'BUY_COMMODITY'">
                                                    <td class="text-center">{{$parent.dispMoneyFormat(receiveDraft.rCostEstimation)}}</td>
                                                    <td class="text-center" v-if="receiveDraft.rAcceptedAmount > 0">
                                                        <div v-if="parseInt(receiveDraft.rAcceptedAmount) != parseInt(receiveDraft.rCommitmentAmount)">
                                                            <span class="danger-label" :data-toggle="'needForEditFinancing' + receiveDraft.id">{{$parent.dispMoneyFormat(receiveDraft.rAcceptedAmount)}}</span>
                                                            <div class="clearfix tool-bar">
                                                                <div  style="width: 300px;" class="dropdown-pane dropdown-pane-sm " data-close-on-click="true"  data-hover="true" data-hover-pane="true" data-h-offset="20px"  data-position="auto" data-alignment="auto" :id="'needForEditFinancing' + receiveDraft.id" data-dropdown data-auto-focus="true">
                                                                    <ul class="my-menu small-font">
                                                                        <div class="grid-x">
                                                                            <div class="medium-12">
                                                                                <p class="black-color text-justify">کاربر گرامی:</p>
                                                                                <p class="gray-colors text-justify" style="margin-top: -10px">مبلغ قرارداد / فاکتور با مبلغ تعهد شده از محل های تامین اعتبار تفاوت دارد، لطفا نسبت به اصلاح تامین اعتبار اقدام کنید.</p>
                                                                            </div>
                                                                        </div>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div v-else="">
                                                            {{$parent.dispMoneyFormat(receiveDraft.rAcceptedAmount)}}
                                                        </div>
                                                    </td>
                                                    <td v-else-if="receiveDraft.request_type.rtType == 'BUY_SERVICES'" class="text-center"><span class="reserved-label">فاقد قرارداد</span></td>
                                                    <td v-else-if="receiveDraft.request_type.rtType == 'BUY_COMMODITY'" class="text-center"><span class="reserved-label">فاقد فاکتور</span></td>
                                                </template>
                                                <template v-else>
                                                    <td colspan="2" class="text-center">{{$parent.dispMoneyFormat(receiveDraft.rCostEstimation)}}</td>
                                                </template>
                                                <td class="text-center">{{receiveDraft.rLetterNumber}}</td>
                                                <td class="text-center">{{receiveDraft.rLetterDate}}</td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="grid-x">
                                    <div class="medium-12">
                                        <vue-pagination  v-bind:pagination="received_pagination_PAYMENT"
                                                         v-on:click.native="fetchData(received_pagination_PAYMENT.current_page)"
                                                         :offset="4">
                                        </vue-pagination>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--receiveRequests_DRAFT Tab-->
                </div>
            </div>
            <!--receive_Requests_tab_view End-->
        </div>

        <!-- Request Detail Modal -->
        <modal-large v-if="showRequestDetailModal" @close="showRequestDetailModal = false">
            <div slot="body">
                <div class="small-font">
                    <div class="grid-x">
                        <div class="large-12 medium-12 small-12 container-vh">
                            <ul class="tabs tab-color my-tab-style" data-responsive-accordion-tabs="tabs medium-accordion large-tabs" id="request_tab_view">
                                <li class="tabs-title" :class="requestLevel == 'REQUEST' ? 'is-active' : ''"><a href="#requestDetailTab" aria-selected="true">جزییات</a></li>
                                <li class="tabs-title"><a href="#requestVerifiersTab">تایید کنندگان </a></li>
                                <li class="tabs-title" :class="requestLevel == 'FINANCIAL' ? 'is-active' : ''"><a href="#creditsTab">اعتبارات</a></li>
                                <li class="tabs-title" :class="requestLevel == 'PURCHASE_AND_CONTRACT' ? 'is-active' : ''" v-if="requestType == 'BUY_COMMODITY'"><a href="#factorTab">اطلاعات فاکتور</a></li>
                                <li class="tabs-title" :class="requestLevel == 'PURCHASE_AND_CONTRACT' ? 'is-active' : ''" v-if="requestType == 'BUY_SERVICES'"><a href="#contractTab">اطلاعات قرارداد</a></li>
                                <li v-if="requestType == 'BUY_SERVICES'" class="tabs-title" :class="requestLevel == 'PAYMENT' ? 'is-active' : ''"><a href="#payRequestTab">درخواست پرداخت </a></li>
                                <li class="tabs-title" :class="requestLevel == 'DRAFT' ? 'is-active' : ''"><a href="#draftTab">حواله </a></li>
                                <li class="tabs-title"><a href="#requestHistoryTab">تاریخچه </a></li>
                                <li class="tabs-title"><a href="#requestAttachmentsTab">پیوست ها </a></li>
                            </ul>
                            <div class="tabs-content inner-vh" data-tabs-content="request_tab_view">
                                <!--Tab 1-->
                                <div class="tabs-panel table-mrg-btm" :class="requestLevel == 'REQUEST' ? 'is-active' : ''" id="requestDetailTab">
                                    <rDetails v-bind:requestTypeDetail="requestTypeDetail"
                                              v-bind:requestFill="requestFill"
                                              v-bind:commodityList="commodityList"
                                              v-on:setRepoExistCountParent="setRepoExistCount"
                                    >
                                    </rDetails>
                                </div>
                                <!--Tab 1-->
                                <!--Tab 2-->
                                <div class="tabs-panel table-mrg-btm inner-vh-2" id="requestVerifiersTab" xmlns:v-on="http://www.w3.org/1999/xhtml">
                                    <div class="grid-x">
                                        <div v-for="verifier in verifiers" class="large-12 medium-12 small-12 verifier-panel">
                                            <div class="grid-x">
                                                <div class="large-1 medium-1 small-12">
                                                    <img style="width: 60px;height: 60px;margin-top: 10px;margin-bottom: 10px;" class="profile-image-cover-index profile-image-cover-pos" :src="verifier.user.avatarPath != null ? baseURL + verifier.user.avatarPath : $parent.baseAvatar">
                                                </div>
                                                <div class="large-6 medium-6 small-12 small-top-m">
                                                    <p>{{verifier.user.name}}</p>
                                                    <p style="margin-top:-13px;color:#757575;" class="small-font">{{verifier.user.role.rSubject}}</p>
                                                </div>
                                                <div v-show="verifier.rvSId != null" style="direction: ltr;" class="large-5 medium-5 small-12 small-top-m">
                                                    <p class="user-verifier-label">تایید شده</p>
                                                    <p style="margin-bottom: 0;color:#9E9E9E;margin-top:-8px" class="small-font"><i class="far fa-calendar-alt"></i><span> {{verifier.rvShamsiDate}} </span> - <i class="far fa-clock"></i> <span>{{verifier.rvShamsiTime}}</span></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--Tab 2-->
                                <!--Tab 3-->
                                <div class="tabs-panel table-mrg-btm" :class="requestLevel == 'FINANCIAL' ? 'is-active' : ''" id="creditsTab" xmlns:v-on="http://www.w3.org/1999/xhtml">
                                    <rCredits v-if="isFromRefund != true" v-on:closeModal="showRequestDetailModal=false"
                                              v-on:updateReceiveRequestData="updateReceiveRequestData"
                                              v-on:updateCommitmentAmount="updateCommitmentAmount"
                                            v-bind:baseAmount="baseAmount"
                                            v-bind:requestType="requestType"
                                            v-bind:requestFill="requestFill"
                                            v-bind:UserIsVerifier="UserIsVerifier"
                                            v-bind:requestId="requestId">
                                    </rCredits>
                                    <div v-else>
                                        <p>از تنخواه گردان کارپردازی</p>
                                    </div>
                                </div>
                                <!--Tab 3-->
                                <!--Tab 4-->
                                <div class="tabs-panel table-mrg-btm" :class="requestLevel == 'PURCHASE_AND_CONTRACT' ? 'is-active' : ''" id="contractTab" xmlns:v-on="http://www.w3.org/1999/xhtml">
                                    <rContract v-if="requestType == 'BUY_SERVICES'"
                                            v-on:closeModal="showRequestDetailModal=false"
                                            v-on:updateReceiveRequestData="updateReceiveRequestData"
                                            v-bind:requestId="requestId"
                                            v-bind:contracts="contracts"
                                            v-bind:requestSubject="requestSubject"
                                            v-bind:rCreditIsAccepted="rCreditIsAccepted"
                                            v-bind:rCreditIsExist="rCreditIsExist">
                                    </rContract>
                                </div>
                                <!--Tab 4-->
                                <!--Tab 5-->
                                <div class="tabs-panel table-mrg-btm" :class="requestLevel == 'PURCHASE_AND_CONTRACT' ? 'is-active' : ''" id="factorTab" xmlns:v-on="http://www.w3.org/1999/xhtml">
                                    <rFactor v-if="requestType == 'BUY_COMMODITY'"
                                             v-on:closeModal="showRequestDetailModal=false"
                                             v-on:updateReceiveRequestData="updateReceiveRequestData"
                                             v-bind:requestId="requestId"
                                             v-bind:factors="factors"
                                             v-bind:rCreditIsAccepted="rCreditIsAccepted"
                                             v-bind:rCreditIsExist="rCreditIsExist"
                                             v-bind:isFromRefundCosts="isFromRefundCosts">
                                    </rFactor>
                                </div>
                                <!--Tab 5-->
                                <!--Tab 6-->
                                <div v-if="requestType == 'BUY_SERVICES'" class="tabs-panel table-mrg-btm" :class="requestLevel == 'PAYMENT' ? 'is-active' : ''" id="payRequestTab" xmlns:v-on="http://www.w3.org/1999/xhtml">
                                    <r-pay-request
                                            v-on:closeModal="showRequestDetailModal=false"
                                            v-on:updateReceiveRequestData="updateReceiveRequestData"
                                            v-on:openReferralsModal="openReferralsModal"
                                            v-on:openResponseRequestModal="openResponseRequestModal"
                                            v-bind:requestId="requestId"
                                            v-bind:payRequests="payRequests"
                                            v-bind:lastRefPrId="lastRefPrId"
                                            v-bind:contracts="contracts"
                                            v-bind:factors="factors"
                                            v-bind:rAcceptedAmount="rAcceptedAmount"
                                            v-bind:rCommitmentAmount="rCommitmentAmount"
                                            v-bind:requestType="requestType"
                                            v-bind:drafts="drafts"
                                            v-bind:sumOfDraftAmount="rSumOfDraftAmount"
                                            v-bind:paymentRequestAmount="paymentRequestAmount"
                                                >
                                    </r-pay-request>
                                </div>
                                <!--Tab 6-->
                                <!--Tab 6-->
                                <div class="tabs-panel table-mrg-btm" :class="requestLevel == 'DRAFT' ? 'is-active' : ''" id="draftTab" xmlns:v-on="http://www.w3.org/1999/xhtml">
                                    <rDraft  v-on:closeModal="showRequestDetailModal=false"
                                             v-on:updateReceiveRequestData="updateReceiveRequestData"
                                             v-on:openReferralsModal="openReferralsModal"
                                             v-on:openResponseRequestModal="openResponseRequestModal"
                                             v-bind:requestId="requestId"
                                             v-bind:contracts="contracts"
                                             v-bind:factors="factors"
                                             v-bind:rAcceptedAmount="rAcceptedAmount"
                                             v-bind:rCommitmentAmount="rCommitmentAmount"
                                             v-bind:requestType="requestType"
                                             v-bind:drafts="drafts"
                                             v-bind:sumOfDraftAmount="rSumOfDraftAmount"
                                             v-bind:lastRefDId="lastRefDId">
                                    </rDraft>
                                </div>
                                <!--Tab 6-->
                                <!--Tab 7-->
                                <div class="tabs-panel table-mrg-btm inner-vh-2" id="requestHistoryTab" xmlns:v-on="http://www.w3.org/1999/xhtml">
                                    <div class="grid-x">
                                        <div class="large-12 medium-12 small-12 large-top-m">
                                            <div style="margin-top:-50px;" v-for="recipientUser in recipientUsers" class="grid-x timeline">
                                                <div class="large-12 medium-12 small-12 timeline-item">
                                                    <div class="grid-x">
                                                        <div class="large-3 medium-3 small-12">

                                                        </div>
                                                        <div class="large-7 medium-7 small-12 timeline-icon">
                                                            <img style="width: 57px;height: 57px;margin-top: 1px;margin-bottom: 10px;" class="profile-image-cover-index profile-image-cover-pos" :src="recipientUser.source_user_info.avatarPath != null ? baseURL + recipientUser.source_user_info.avatarPath : $parent.baseAvatar">
                                                        </div>
                                                        <div class="large-7 medium-7 small-12 timeline-content">
                                                            <div class="grid-x">
                                                                <div class="large-12 medium-12 small-12 timeline-content-header">
                                                                    <p>{{recipientUser.source_user_info.name}}</p>
                                                                    <p style="margin-top:-13px;margin-bottom: -5px;" class="small-font">{{recipientUser.source_user_info.role.rSubject}}</p>
                                                                    <span class="timeline-state gray-color">{{recipientUser.request_state.rsSubject}}</span>
                                                                </div>
                                                                <div class="large-12 medium-12 small-12">
                                                                    <p class="small-top-m text-justify gray-colors">
                                                                        {{recipientUser.rhDescription}}
                                                                    </p>
                                                                    <div v-if="recipientUser.destination_user_info != null && requestState != 'WAITING_FOR_PAY_REQUEST'">
                                                                        <p v-if="recipientUser.source_user_info.id != recipientUser.destination_user_info.id" style="margin-bottom: 0" class="small-top-m">گیرنده:</p>
                                                                        <div v-if="recipientUser.source_user_info.id != recipientUser.destination_user_info.id" class="grid-x">
                                                                            <div class="large-1 medium-2 small-12">
                                                                                <img style="width: 40px;height: 40px;margin-top: 10px;margin-bottom: 10px;" class="profile-image-cover-index profile-image-cover-pos" :src="recipientUser.destination_user_info.avatarPath != null ? baseURL + recipientUser.destination_user_info.avatarPath : $parent.baseAvatar">
                                                                            </div>
                                                                            <div class="large-11 medium-10 small-12 padding-lr">
                                                                                <p class="small-top-m" v-if="recipientUser.destination_user_info != null">
                                                                                    {{recipientUser.destination_user_info.name}} - {{recipientUser.destination_user_info.role.rSubject}}
                                                                                </p>
                                                                                <p class="small-top-m btn-red" v-else>
                                                                                    در انتظار مشاهده
                                                                                </p>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <p style="direction: ltr;margin-bottom: -15px;" class="gray-color small-font"><i class="far fa-calendar-alt"></i><span> {{recipientUser.rhShamsiDate}} </span> - <i class="far fa-clock"></i> <span>{{recipientUser.rhShamsiTime}}</span></p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="large-3 medium-3 small-12">

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--Tab 7-->

                                <!--Tab 8-->
                                <div class="tabs-panel table-mrg-btm inner-vh-2" id="requestAttachmentsTab" xmlns:v-on="http://www.w3.org/1999/xhtml">
                                    <div class="grid-x">
                                        <vue-element-loading :active="showLoaderProgress" spinner="line-down" color="#716aca"/>
                                        <div class="medium-12 padding-lr">
                                            <label v-show='$can("UNIT_OF_CONTRACT_ADD_NEW_ATTACHMENT")' class="my-button toolbox-btn"> انتخاب فایل
                                                <input @change="addNewAttachment" accept=".jpg,.jpeg,.png,.doc,.docx,.doc,.xls,.xlsx,.pdf" id="File" type="file">
                                            </label>
                                        </div>
                                        <div class="medium-12">
                                            <div class="grid-x">
                                                <div style="margin-top: 15px;margin-bottom: 15px;" v-for="(attachment, index) in attachments" class="large-3 medium-4 small-12 padding-lr">
                                                    <div class="format-card">
                                                        <a  v-bind:href="attachment.aPath" target="_blank">
                                                            <div style="padding:15px;" class="text-center">
                                                                <i v-if="attachment.aName.split('.').pop().toLowerCase() == 'pdf'" class="fas fa-file-pdf size-72 btn-red"></i>
                                                                <i v-if="attachment.aName.split('.').pop().toLowerCase() == 'jpg' || attachment.aName.split('.').pop().toLowerCase() == 'jpeg' || attachment.aName.split('.').pop().toLowerCase() == 'png'" class="fas fa-file-image size-72 purple-color"></i>
                                                                <i v-if="attachment.aName.split('.').pop().toLowerCase() == 'doc' || attachment.aName.split('.').pop().toLowerCase() == 'docx'" class="fas fa-file-word size-72 blue-color"></i>
                                                                <i v-if="attachment.aName.split('.').pop().toLowerCase() == 'xls' || attachment.aName.split('.').pop().toLowerCase() == 'xlsx'" class="fas fa-file-excel size-72 btn-green"></i>
                                                                <h3 style="margin-top:10px;" class="gray-colors">{{attachment.aName.split('.').pop().toUpperCase()}}</h3>
                                                            </div>
                                                        </a>
                                                        <div class="format-container direction-ltr">
                                                            <p style="cursor: pointer;" :data-toggle="'attachment' + index" class="small-top-m gray-color one-line"><b>{{attachment.aName}}</b></p>
                                                            <div class="clearfix tool-bar">
                                                                <div style="width: 200px" class="dropdown-pane dropdown-pane-sm " data-close-on-click="true"  data-hover="true" data-hover-pane="true"  data-position="auto" data-alignment="auto" :id="'attachment' + index" data-dropdown data-auto-focus="true">
                                                                    <ul class="my-menu small-font">
                                                                        <div class="grid-x">
                                                                            <div class="medium-12">
                                                                                <p style="word-break: break-all;" class="black-color">{{attachment.aName}}</p>
                                                                            </div>
                                                                        </div>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                            <div class="grid-x">
                                                                <div class="large-10">
                                                                    <p v-if="Number((attachment.aSize / 1000).toFixed(1)) < 1024 " class="gray-colors">{{  Number((attachment.aSize / 1000).toFixed(1)) + ' کیلوبایت'}}</p>
                                                                    <p v-if="Number((attachment.aSize / 1000).toFixed(1)) > 1024" class="gray-colors">{{  Number(((attachment.aSize / 1000)/1024).toFixed(1)) + ' مگابایت'}}</p>
                                                                </div>
                                                                <div style="direction:rtl;" class="large-2">
                                                                    <a v-show="$can('UNIT_OF_CONTRACT_DELETE_ATTACHMENT')" class="dropdown small sm-btn-align"  type="button" :data-toggle="'attachmentDel' + index"><i class="fa fa-ellipsis-v size-18"></i></a>
                                                                    <div class="dropdown-pane dropdown-pane-sm " data-close-on-click="true"  data-hover="true" data-hover-pane="true"  data-position="bottom" data-alignment="right" :id="'attachmentDel' + index" data-dropdown data-auto-focus="true">
                                                                        <ul class="my-menu small-font text-right">
                                                                            <li><a @click="openDeleteAttachmentCinfirmModel(attachment.id)"><i class="fa fa-trash-o size-16"></i>  حذف</a></li>
                                                                        </ul>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!--            <button class="my-button my-brand" v-on:click.prevent="submit">بارگذاری</button>-->
                                        </div>
                                    </div>
                                </div>
                                <!--Tab 8-->
                            </div>
                        </div>
                        <div class="large-12 medium-12 small-12 medium-top-m">
                            <div style="margin-bottom:-10px;" class="stacked-for-small button-group">
                                <button @click="openSubmitRequestModal()" v-if=" youAreVerifier != '' "  class="my-button my-success float-left btn-for-load"><span class="btn-txt-mrg">  تایید</span></button>
                                <button v-show='$can("SECRETARIAT_REGISTER_AND_NUMBERING") && rLetterNumber == null && rLetterDate == null' style="width:130px;" @click="openRegisterAndNumberingModal()" class="my-button my-success"><span class="btn-txt-mrg">  ثبت دبیرخانه</span></button>
                                <button @click="openReferralsModal()"  class="my-button toolbox-btn"><span class="btn-txt-mrg">  ارجاع</span></button>
                                <button @click="openResponseRequestModal()" v-show="canResponse == true" class="my-button toolbox-btn"><span class="btn-txt-mrg">  پاسخ</span></button>
                                <button v-show="$can('REQUEST_CLOSED')" @click="openTerminateModal()" class="my-button toolbox-btn"><span class="btn-txt-mrg">خاتمه</span></button>
                                <button v-show="$can('REQUEST_BLOCK')" @click="openBlockModal()" class="my-button toolbox-btn"><span class="btn-txt-mrg">مسدود</span></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </modal-large>
        <!-- Request Detail Modal End-->

        <!-- Referral Detail Modal Start-->
        <modal-small v-if="showReferralsModal" @close="showReferralsModal = false">
            <div  slot="body">
                <form v-on:submit.prevent="requestReferral">
                    <div class="small-font">
                        <div class="grid-x">
                            <div v-show="youAreVerifier != ''" class="large-12 medium-12 small-12 padding-lr">
                                <input id="checkbox1"  v-model="referralPermission" type="checkbox"><label for="checkbox1">ارجاع با انتقال مجوز تایید</label>
                            </div>
                            <div v-if="referralPermission == false" class="large-12 medium-12 small-12 padding-lr">
                                <select v-model="referralInput.destUId">
                                    <option value=""></option>
                                    <option v-for="groupUser in groupUsers" :value="groupUser.id">{{groupUser.name}} - {{groupUser.role.rSubject}}</option>
                                </select>
                            </div>
                            <div v-if="referralPermission == true" class="large-12 medium-12 small-12 padding-lr">
                                <select v-model="referralInput.destUId">
                                    <option value=""></option>
                                    <option v-for="groupUsersByCIds in groupUsersByCId" :value="groupUsersByCIds.id">{{groupUsersByCIds.name}} - {{groupUsersByCIds.role.rSubject}}</option>
                                </select>
                            </div>
                            <div class="large-12 medium-12 small-12 padding-lr">
                                <label>شرح ارجاع
                                    <textarea v-model="referralInput.description"  class="form-element-margin-btm"  style="min-height: 150px;" name="referralDescription"  v-validate="'required'" :class="{'input': true, 'error-border': errors.has('referralDescription')}"></textarea>
                                    <span v-show="errors.has('referralDescription')" class="error-font">لطفا شرح ارجاع را وارد کنید!</span>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="large-12 medium-12 small-12 padding-lr small-top-m">
                        <button type="submit"  class="my-button my-success float-left btn-for-load"><span class="btn-txt-mrg">  ارجاع</span></button>
                    </div>
                </form>
            </div>
        </modal-small>
        <!-- Referral Detail Modal End-->

        <!-- Submit Request modal -->
        <modal-tiny v-if="showSubmitRequestModal" @close="showSubmitRequestModal = false">
            <div  slot="body">
                <div class="small-font" xmlns:v-on="http://www.w3.org/1999/xhtml">
                    <div class="grid-x">
                        <template v-if="UserIsVerifier.length <= 0">
                            <div class="large-12 medium-12 small-12 padding-lr">
                                <p class="black-color">آیا برای تایید درخواست اطمینان دارید؟ </p>
                            </div>
                            <div class="large-12 medium-12 small-12 padding-lr">
                                <p class="btn-red">تایید شما به منزله امضا درخواست می باشد.</p>
                            </div>
                            <div class="large-12 medium-12 small-12 padding-lr small-top-m text-center">
                                <button @click="acceptRequest()"  class="my-button my-success btn-for-load"><span class="btn-txt-mrg">  تایید</span></button>
                            </div>
                        </template>
                        <template v-if="UserIsVerifier.length > 0">
                            <div class="large-12 medium-12 small-12 padding-lr text-center">
                                <p class="modal-text">تایید کنندگان زیر تاکنون درخواست مورد نظر را تایید نکرده اند. در حال حاضر شما امکان تایید درخواست را ندارید. </p>
                            </div>
                            <div v-for="UserVerifier in UserIsVerifier" class="large-12 medium-12 small-12 verifier-panel">
                                <div class="grid-x">
                                    <div class="large-2 medium-2 small-12">
                                        <img style="width: 60px;height: 60px;margin-top: 10px;margin-bottom: 10px;" class="profile-image-cover-index profile-image-cover-pos" :src="UserVerifier.user.avatarPath != null ?baseURL + UserVerifier.user.avatarPath : $parent.baseAvatar">
                                    </div>
                                    <div class="large-10 medium-10 small-12 small-top-m">
                                        <p>{{UserVerifier.user.name}}</p>
                                        <p style="margin-top:-13px;color:#757575;" class="small-font">{{UserVerifier.user.role.rSubject}}</p>
                                    </div>
                                </div>
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

        <!-- confirm delete attachment modal -->
        <modal-tiny v-if="showDeleteAttachmentConfirmModal" @close="showDeleteAttachmentConfirmModal = false">
            <div  slot="body">
                <div class="small-font" xmlns:v-on="http://www.w3.org/1999/xhtml">
                    <div class="grid-x">
                        <div class="large-12 medium-12 small-12 padding-lr">
                            <p class="black-color">آیا تمایل دارید فایل مورد نظر را حذف کنید؟</p>
                        </div>
                        <div class="large-12 medium-12 small-12 padding-lr small-top-m text-center">
                            <button @click="removeAttachment()"  class="my-button my-success btn-for-load"><span class="btn-txt-mrg">  بله</span></button>
                        </div>
                    </div>
                </div>
            </div>
        </modal-tiny>
        <!-- confirm delete attachment modal -->

        <!-- Response Request modal -->
        <modal-tiny v-if="showResponseRequestModal" @close="showResponseRequestModal = false">
            <div  slot="body">
                <div class="small-font" xmlns:v-on="http://www.w3.org/1999/xhtml">
                    <div class="grid-x">
                        <div class="large-12 medium-12 small-12 padding-lr response-panel">
                            <p class="modal-text response-header">پاسخ به :</p>
                            <p class="gray-colors">{{referralDescription}}</p>
                            <p style="margin-bottom:-10px;color:#9E9E9E;" class="direction-ltr small-font"><span class="black-color">ارجاع دهنده : </span> {{referralDestination}}</p>

                        </div>
                        <div class="large-12 medium-12 small-12 small-top-m">
                            <label>متن پاسخ
                                <textarea v-model="responseDescription"  class="form-element-margin-btm"  style="min-height: 150px;" name="referralDescription"  v-validate="'required'" :class="{'input': true, 'error-border': errors.has('responseDescription')}"></textarea>
                                <span v-show="errors.has('responseDescription')" class="error-font">لطفا متن پاسخ را وارد کنید!</span>
                            </label>
                        </div>
                        <div class="large-12 medium-12 small-12 padding-lr small-top-m text-center">
                            <button @click="responseRequest()"  class="my-button my-success btn-for-load"><span class="btn-txt-mrg">  پاسخ</span></button>
                        </div>
                    </div>
                </div>
            </div>
        </modal-tiny>
        <!-- Response Request modal -->

        <!-- RegisterAndNumbering Start -->
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
                            <button @click="registerAndNumbering()"  class="my-button my-success btn-for-load"><span class="btn-txt-mrg">  ثبت</span></button>
                        </div>
                    </div>
                </div>
            </div>
        </modal-tiny>
        <!-- RegisterAndNumbering End -->
        <messageDialog v-show="showDialogModal" @close="showDialogModal =false">
            {{dialogMessage}}
        </messageDialog>
        <!-- block Detail Modal Start-->
        <modal-tiny v-if="showBlockModal" @close="showBlockModal = false">
            <div  slot="body">
                <form v-on:submit.prevent="requestBlock">
                    <div class="small-font">
                        <div class="grid-x">
                            <div class="large-12 medium-12 small-12 padding-lr">
                                <p class="black-color text-justify" style="font-size: 1rem">کاربر گرامی:</p>
                                <p class="large-offset-1 modal-text">توجه داشته باشید که در صورت مسدود کردن درخواست دیگر امکان بازگشت آن به حالت فعال وجود ندارد، با مسدود کردن درخواست محل های تامین اعتبار آزاد می گردد. </p>
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
        <!-- block Detail Modal Start-->
        <modal-tiny v-if="showTerminateModal" @close="showTerminateModal = false">
            <div  slot="body">
                <form v-on:submit.prevent="requestTerminate">
                    <div class="small-font">
                        <div class="grid-x">
                            <div class="large-12 medium-12 small-12 padding-lr">
                                <p class="black-color text-justify" style="font-size: 1rem">کاربر گرامی:</p>
                                <p class="large-offset-1 modal-text">توجه داشته باشید که در صورت خاتمه درخواست دیگر امکان بازگشت آن به حالت فعال وجود ندارد. </p>
                                <label>شرح
                                    <textarea v-model="terminateInput.description"  class="form-element-margin-btm"  style="min-height: 150px;"></textarea>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="large-12 medium-12 small-12 padding-lr small-top-m text-center">
                        <button type="submit"  class="my-button my-success"><span class="btn-txt-mrg">  خاتمه</span></button>
                    </div>
                </form>
            </div>
        </modal-tiny>
        <!-- block Detail Modal End-->

    </div>
</template>

<script>
    import Suggestions from "v-suggestions/src/Suggestions";
    import VuePersianDatetimePicker from 'vue-persian-datetime-picker';
    import VuePagination from '../../../public_component/pagination.vue';
    import VueElementLoading from 'vue-element-loading'
    /* Import Local Components Start*/
    import rDetails from './detailRequest/r_details.vue';
    import rCredits from './detailRequest/r_credits.vue';
    import rContract from './detailRequest/r_contract.vue';
    import rFactor from './detailRequest/r_factor.vue';
    import rDraft from './detailRequest/r_draft.vue';
    import rPayRequest from './detailRequest/r_pay_request.vue';
    /* Import Local Components End*/
    export default {
        components: {
            Suggestions,
            "vue-select": require("vue-select"),
            datePicker: VuePersianDatetimePicker,
            'vue-pagination' : VuePagination,
            rDetails,
            rCredits,
            rContract,
            rFactor,
            rDraft,
            rPayRequest,
            VueElementLoading,
        },
        data () {
            return {
                attachments:[],
                attachmentIdForDelete: 0,
                showLoaderProgress:false,
                receiveRequests_REQUEST:[],
                receiveRequests_FINANCIAL:[],
                receiveRequests_PURCHASE_AND_CONTRACT:[],
                receiveRequests_PAYMENT:[],
                receiveRequests_DRAFT:[],
                costTemp:'',
                showRequestDetailModal:false,
                showReferralsModal:false,
                showSubmitRequestModal:false,
                showResponseRequestModal:false,
                showRegisterAndNumberingModal:false,
                showDialogModal: false,
                showDeleteAttachmentConfirmModal: false,
                showBlockModal: false,
                showTerminateModal: false,
                dialogMessage: '',
                receiveRequestSearchValue:'',
                requestTypeDetail:'',
                requestFill:{},
                blockInput:{},
                terminateInput: {},
                commodityList:[],
                recipientUsers:[],
                UserIsVerifier:[],
                remainingVerifiers:[],
                verifiers:[],
                groupUsers:[],
                groupUsersByCId:[],
                referralPermission:false,
                referralInput:{},
                isPaid: false,
                lastVerifier:'',
                youAreVerifier:'',
                youAreVerifierCId:'',
                responseDescription:'',
                referralDestination:'',
                canResponse:'',
                baseURL:window.hostname+'/',
                repoExistCount:[],
                commodityCount:'',
                registerDate: '',
                requestId: '',
                letterNumber: '',
                requestType:'',
                money: {
                    thousands: ',',
                    decimal:'.',
                    masked: true
                },
                requestLevel: '',

                /*credits*/

                baseAmount:0,

                /*credits*/

                contracts:[],

                rCreditIsAccepted: true,
                rCreditIsExist: false,

                factors:[],

                maxInputValue:0,
                updateDataThreadNowPlaying: null,

                received_pagination_REQUEST: {
                    total: 0,
                    to: 0,
                    current_page: 1,
                    last_page: ''
                },
                received_pagination_FINANCIAL: {
                    total: 0,
                    to: 0,
                    current_page: 1,
                    last_page: ''
                },
                received_pagination_PURCHASE_AND_CONTRACT: {
                    total: 0,
                    to: 0,
                    current_page: 1,
                    last_page: ''
                },
                received_pagination_PAYMENT: {
                    total: 0,
                    to: 0,
                    current_page: 1,
                    last_page: ''
                },
                isFromRefund: false,
                isFromRefundCosts:false,

                drafts:[],
                payRequests: [],
                draftIsExist: false,
                rCostEstimation:0,
                rAcceptedAmount:0,

                rr_REQUEST_Unreads:0,
                rr_FINANCIAL_Unreads:0,
                rr_PURCHASE_AND_CONTRACT_Unreads:0,
                rr_PAYMENT_Unreads:0,
                rr_REQUEST_Reads:0,
                rr_FINANCIAL_Reads:0,
                rr_PURCHASE_AND_CONTRACT_Reads:0,
                rr_PAYMENT_Reads:0,
                rr_DRAFT_Unreads: 0,
                rr_DRAFT_Reads: 0,
                referralDId: null,
                referralPrId: null,
                rLetterNumber: null,
                rLetterDate: null,
                rSumOfDraftAmount: 0,
                lastRefPrId: -1,
                lastRefDId: -1,
                paymentRequestAmount:0,
                requestSubject:'',
            }
        },

        created: function(){
            this.fetchData();
            this.setUpdateDataThread();
        },

        updated: function () {
            $(this.$el).foundation(); //WORKS!
            this.myResizeModal();
            this.costTemp =  '  ' + this.$parent.getDispAmountBaseLabel();
        },

        mounted: function () {
            this.$parent.myResize();
        },

        beforeDestroy: function () {
            clearInterval(this.updateDataThreadNowPlaying);
            console.log('...................................... kill update data thread');
        },

        methods: {
            setRepoExistCount:function(cECount){
                this.repoExistCount=cECount;
            },

            updateReceiveRequestData: function(requests , rId){
                this.loadReceivedData(requests);
                this.receiveRequests_REQUEST.forEach(rec => {
                    if (rec.id == rId)
                    {
                        this.getRequestDetail(rec);
                        return;
                    }
                });
                this.receiveRequests_FINANCIAL.forEach(rec => {
                    if (rec.id == rId)
                    {
                        this.getRequestDetail(rec);
                        return;
                    }
                });
                this.receiveRequests_PURCHASE_AND_CONTRACT.forEach(rec => {
                    if (rec.id == rId)
                    {
                        this.getRequestDetail(rec);
                        return;
                    }
                });
                this.receiveRequests_PAYMENT.forEach(rec => {
                    if (rec.id == rId)
                    {
                        this.getRequestDetail(rec);
                        return;
                    }
                });
                this.receiveRequests_DRAFT.forEach(rec => {
                    if (rec.id == rId)
                    {
                        this.getRequestDetail(rec);
                        return;
                    }
                });
                this.makePagination(requests);
            },

            loadReceivedData: function(requests){
                var REQUEST_UnreadsTemp=0;
                var FINANCIAL_UnreadsTemp=0;
                var PURCHASE_AND_CONTRACT_UnreadsTemp=0;
                var PAYMENT_UnreadsTemp=0;
                var REQUEST_ReadsTemp=0;
                var FINANCIAL_ReadsTemp=0;
                var PURCHASE_AND_CONTRACT_ReadsTemp=0;
                var PAYMENT_ReadsTemp=0;
                var DRAFT_ReadsTemp=0;
                var DRAFT_UnreadsTemp=0;

                this.receiveRequests_REQUEST = requests.REQUEST.data;
                this.receiveRequests_REQUEST.forEach(item =>{
                    if(item.rLastRef.rhHasBeenSeen == 0){
                        REQUEST_UnreadsTemp += 1;
                    }
                    if(item.rLastRef.rhHasBeenSeen == 1){
                        REQUEST_ReadsTemp += 1;
                    }
                });
                this.rr_REQUEST_Unreads=REQUEST_UnreadsTemp;
                this.rr_REQUEST_Reads=REQUEST_ReadsTemp;

                this.receiveRequests_FINANCIAL = requests.FINANCIAL.data;
                this.receiveRequests_FINANCIAL.forEach(item =>{
                    if(item.rLastRef.rhHasBeenSeen == 0){
                        FINANCIAL_UnreadsTemp += 1;
                    }
                    if(item.rLastRef.rhHasBeenSeen == 1){
                        FINANCIAL_ReadsTemp += 1;
                    }
                });
                this.rr_FINANCIAL_Unreads=FINANCIAL_UnreadsTemp;
                this.rr_FINANCIAL_Reads=FINANCIAL_ReadsTemp;

                this.receiveRequests_PURCHASE_AND_CONTRACT = requests.PURCHASE_AND_CONTRACT.data;
                this.receiveRequests_PURCHASE_AND_CONTRACT.forEach(item =>{
                    if(item.rLastRef.rhHasBeenSeen == 0){
                        PURCHASE_AND_CONTRACT_UnreadsTemp += 1;
                    }
                    if(item.rLastRef.rhHasBeenSeen == 1){
                        PURCHASE_AND_CONTRACT_ReadsTemp += 1;
                    }
                });
                this.rr_PURCHASE_AND_CONTRACT_Unreads=PURCHASE_AND_CONTRACT_UnreadsTemp;
                this.rr_PURCHASE_AND_CONTRACT_Reads=PURCHASE_AND_CONTRACT_ReadsTemp;

                this.receiveRequests_PAYMENT = requests.PAYMENT.data;
                this.receiveRequests_PAYMENT.forEach(item =>{
                    if(item.rLastRef.rhHasBeenSeen == 0){
                        PAYMENT_UnreadsTemp += 1;
                    }
                    if(item.rLastRef.rhHasBeenSeen == 1){
                        PAYMENT_ReadsTemp += 1;
                    }
                });
                this.rr_PAYMENT_Unreads=PAYMENT_UnreadsTemp;
                this.rr_PAYMENT_Reads=PAYMENT_ReadsTemp;

                this.receiveRequests_DRAFT = requests.DRAFT.data;
                this.receiveRequests_DRAFT.forEach(item =>{
                    if(item.rLastRef.rhHasBeenSeen == 0){
                        DRAFT_UnreadsTemp += 1;
                    }
                    if(item.rLastRef.rhHasBeenSeen == 1){
                        DRAFT_ReadsTemp += 1;
                    }
                });
                this.rr_DRAFT_Unreads=DRAFT_UnreadsTemp;
                this.rr_DRAFT_Reads=DRAFT_ReadsTemp;
            },

            updateCommitmentAmount: function(amount , rId){
                this.receiveRequests_REQUEST.forEach(item => {
                    if (item.id == rId)
                    {
                        item.rCommitmentAmount = amount;
                        return;
                    }
                });

                this.receiveRequests_FINANCIAL.forEach(item => {
                    if (item.id == rId)
                    {
                        item.rCommitmentAmount = amount;
                        return;
                    }
                });

                this.receiveRequests_PURCHASE_AND_CONTRACT.forEach(item => {
                    if (item.id == rId)
                    {
                        item.rCommitmentAmount = amount;
                        return;
                    }
                });

                this.receiveRequests_PAYMENT.forEach(item => {
                    if (item.id == rId)
                    {
                        item.rCommitmentAmount = amount;
                        return;
                    }
                });

                this.receiveRequests_DRAFT.forEach(item => {
                    if (item.id == rId)
                    {
                        item.rCommitmentAmount = amount;
                        return;
                    }
                });
            },

            makePagination: function(data){
                this.received_pagination_REQUEST.current_page = data.REQUEST.current_page;
                this.received_pagination_REQUEST.to = data.REQUEST.to;
                this.received_pagination_REQUEST.last_page = data.REQUEST.last_page;

                this.received_pagination_FINANCIAL.current_page = data.FINANCIAL.current_page;
                this.received_pagination_FINANCIAL.to = data.FINANCIAL.to;
                this.received_pagination_FINANCIAL.last_page = data.FINANCIAL.last_page;

                this.received_pagination_PURCHASE_AND_CONTRACT.current_page = data.PURCHASE_AND_CONTRACT.current_page;
                this.received_pagination_PURCHASE_AND_CONTRACT.to = data.PURCHASE_AND_CONTRACT.to;
                this.received_pagination_PURCHASE_AND_CONTRACT.last_page = data.PURCHASE_AND_CONTRACT.last_page;

                this.received_pagination_PAYMENT.current_page = data.PAYMENT.current_page;
                this.received_pagination_PAYMENT.to = data.PAYMENT.to;
                this.received_pagination_PAYMENT.last_page = data.PAYMENT.last_page;
            },

            setUpdateDataThread: function () {
                console.log("...................................................... set received request update thread");
                if (this.updateDataThreadNowPlaying)
                    clearInterval(this.updateDataThreadNowPlaying);
                this.updateDataThreadNowPlaying = setInterval(this.updateDataThread, 60000);
            },

            updateDataThread: function () {
                console.log("...................................................... received request update thread");
                this.fetchData();
            },

            fetchData: function (page=1) {
                axios.get('/financial/request/received/fetchData?page=' + page)
                    .then((response) => {
                        this.loadReceivedData(response.data);
                        this.$parent._getUnReadReceivedRequest();
                        this.makePagination(response.data);
                        console.log(response);
                    }, (error) => {
                        console.log(error);
                });
            },

            getGroupUsers: function () {
                axios.get('/admin/user/getMyGroupUsers')
                    .then((response) => {
                        this.groupUsers = response.data;
                        console.log(response);
                    }, (error) => {
                        console.log(error);
                    });
            },

            getMyCategoryUsers: function () {
                axios.get('/admin/user/getMyCategoryUsers',{params:{cId:this.youAreVerifierCId}})
                    .then((response) => {
                        this.groupUsersByCId = response.data;
                        console.log(response);
                    }, (error) => {
                        console.log(error);
                    });
            },


            getRequestDetail: function (request) {
                if(request.rLastRef.rhHasBeenSeen==false) {
                    axios.post('/financial/request/received/was_seen', {
                        rhId: request.rLastRef.id
                    }).then((response) => {
                        this.loadReceivedData(response.data);
                        this.$parent._getUnReadReceivedRequest();
                        this.makePagination(response.data);
                        console.log(response);
                    }, (error) => {
                        console.log(error);
                    });
                }
                this.showRequestDetailModal=true;
                this.recipientUsers=[];
                this.verifiers=[];
                this.UserIsVerifier=[];
                this.attachments=[];
                this.contracts=[];
                this.factors=[];
                this.drafts=[];
                this.payRequests =[];
                var requestHistory=[];
                requestHistory.push(request);
                this.requestId=request.id;
                this.requestSubject = request.rSubject;
                this.requestType= request.request_type.rtType ;
                this.rSumOfDraftAmount = request.rSumOfDraftAmount;
                /*this.requestCostFinancing=[];
                this.requestCapFinancing=[];
                this.fetchRequestFinancing();*/

                requestHistory.forEach(users => {
                    users.history.forEach(userHistory => {
                        this.recipientUsers.push(userHistory);
                    });
                });

                requestHistory.forEach(users => {
                    users.verifiers.forEach(verify => {
                        this.verifiers.push(verify);
                    });
                });

                requestHistory.forEach(item => {
                    item.contract.forEach(con => {
                        this.contracts.push(con);
                    });
                });

                requestHistory.forEach(item => {
                    item.factor.forEach(fac => {
                        this.factors.push(fac);
                    });
                });

                requestHistory.forEach(item => {
                    item.draft.forEach(draf => {
                        this.drafts.push(draf);
                    });
                });

                requestHistory.forEach(item => {
                    item.pay_request.forEach(payment => {
                        this.payRequests.push(payment);
                    });
                });

                requestHistory.forEach(remainUsers => {
                    remainUsers.rRemainingVerifiers.forEach(users => {
                        this.UserIsVerifier.push(users);
                    });
                });

                requestHistory.forEach(attach => {
                    attach.attachment.forEach(item => {
                        this.attachments.push(item);
                    });
                });

                this.isPaid = request.rIsPaid;
                this.draftIsExist = false;
                this.drafts.forEach(draft => {
                    if (draft.draft_state.dsState != 'BLOCKED')
                    {
                        this.draftIsExist = true;
                    }
                });

                this.rLetterNumber = request.rLetterNumber;
                this.rLetterDate = request.rLetterDate;
                this.requestLevel = request.request_level.rlLevel;
                this.lastVerifier=request.rLastRef.id;
                this.lastRefPrId = request.rLastRef.rhPrId;
                this.lastRefDId = request.rLastRef.rhDId;
                this.rCreditIsAccepted = request.rCreditIsAccepted;
                this.rCreditIsExist = request.rCreditIsExist;

                this.requestType = request.request_type.rtType;
                this.isFromRefund = request.isFromRefundCosts;
                this.isFromRefundCosts=request.isFromRefundCosts;

                /* Prop to Draft Component*/
                this.rCommitmentAmount=request.rCommitmentAmount;
                this.rAcceptedAmount=request.rAcceptedAmount;
                /* Prop to Draft Component*/

                if(request.rYouAreVerifiers.length != 0){
                    this.youAreVerifier=request.rYouAreVerifiers[0].id;
                    this.youAreVerifierCId=request.rYouAreVerifiers[0].request_step.rstCId;
                }

                this.referralDescription=request.rLastRef.rhDescription;
                this.referralDestination=request.rLastRef.source_user_info.name +' - ' +request.rLastRef.source_user_info.role.rSubject;
                this.canResponse=request.rLastRef.rhIsReferral;

                if (request.rAcceptedAmount > 0)
                    this.baseAmount= request.rAcceptedAmount;
                else
                    this.baseAmount= request.rCostEstimation;

                if (request.request_type.rtType == 'BUY_SERVICES'){
                    this.requestTypeDetail='SERVICES';
                    this.requestFill.rLetterNumber=request.rLetterNumber;
                    this.requestFill.rLetterDate=request.rLetterDate;
                    this.requestFill.rSubject=request.rSubject;
                    this.requestFill.rCostEstimation=request.rCostEstimation;
                    this.requestFill.rDescription=request.rDescription;
                    this.requestFill.rFurtherDetails=request.rFurtherDetails;
                    this.requestFill.rAcceptedAmount=request.rAcceptedAmount;
                }
                else if (request.request_type.rtType == 'BUY_COMMODITY'){
                    var commodityTemp=[];
                    commodityTemp.push(request);
                    this.commodityList=[];
                    this.requestTypeDetail='COMMODITY';
                    this.requestFill.rLetterNumber=request.rLetterNumber;
                    this.requestFill.rLetterDate=request.rLetterDate;
                    this.requestFill.rSubject=request.rSubject;
                    this.requestFill.rCostEstimation=request.rCostEstimation;
                    this.requestFill.rAcceptedAmount=request.rAcceptedAmount;
                    commodityTemp.forEach(items => {
                        items.request_commodity.forEach(commodity => {
                            this.commodityList.push(commodity);
                        });
                    });
                }
                else if (request.request_type.rtType == 'FUND'){
                    this.requestTypeDetail='FUND';
                    this.requestFill.rLetterNumber=request.rLetterNumber;
                    this.requestFill.rLetterDate=request.rLetterDate;
                    this.requestFill.rSubject=request.rSubject;
                    this.requestFill.rCostEstimation=request.rCostEstimation;
                    this.requestFill.rDescription=request.rDescription;
                }
            },

            openReferralsModal: function (dId = null , prId = null) {
                this.showReferralsModal=true;
                this.referralDId = dId;
                this.referralPrId = prId;
                this.getGroupUsers();
                this.getMyCategoryUsers();
            },

            requestReferral: function () {
                this.$validator.validateAll().then((result) => {
                    if (result) {
                        axios.post('/financial/request/referral', {
                            acceptPermission: this.referralPermission == true ? 1 : 0,
                            destUId: this.referralInput.destUId,
                            lastRefId: this.lastVerifier,
                            description: this.referralInput.description,
                            verifierId:this.youAreVerifier,
                            dId:this.referralDId,
                            prId:this.referralPrId
                        }).then((response) => {
                            this.loadReceivedData(response.data);
                            this.$parent._getUnReadReceivedRequest();
                            this.makePagination(response.data);
                            this.showReferralsModal = false;
                            this.showRequestDetailModal = false;
                            this.referralInput = {};
                            this.$parent.displayNotif(response.status);
                            console.log(response);
                        }, (error) => {
                            console.log(error);
                            this.$parent.displayNotif(error.response.status);
                        });
                    }
                });
            },

            openSubmitRequestModal: function () {
              this.showSubmitRequestModal=true;
            },

            closeRequestDetailModal: function () {
                this.showRequestDetailModal=false;
            },

            hideSubmitRequestModal: function () {
              this.showSubmitRequestModal=false;
            },

            acceptRequest: function () {
                this.$validator.validateAll().then((result) => {
                    if (result) {
                        axios.post('/financial/request/accept', {
                            lastRefId: this.lastVerifier,
                            verifierId: this.youAreVerifier,
                            itemExistCount: this.repoExistCount
                        }).then((response) => {
                            this.loadReceivedData(response.data);
                            this.$parent._getUnReadReceivedRequest();
                            this.makePagination(response.data);
                            this.showSubmitRequestModal = false;
                            this.showRequestDetailModal = false;
                            this.$parent.displayNotif(response.status);
                            console.log(response);
                        }, (error) => {
                            console.log(error);
                            this.$parent.displayNotif(error.response.status);
                        });
                    }
                });
            },

            openResponseRequestModal: function (dId = null , prId = null) {
                this.referralDId = dId;
                this.referralPrId = prId;
                this.showResponseRequestModal=true;
            },


            responseRequest: function () {
                axios.post('/financial/request/response', {
                    lastRefId: this.lastVerifier,
                    description: this.responseDescription,
                    dId: this.referralDId,
                    prId: this.referralPrId
                }).then((response) => {
                    this.loadReceivedData(response.data);
                    this.$parent._getUnReadReceivedRequest();
                    this.makePagination(response.data);
                    this.showResponseRequestModal = false;
                    this.showRequestDetailModal = false;
                    this.$parent.displayNotif(response.status);
                    console.log(response);
                }, (error) => {
                    console.log(error);
                    this.$parent.displayNotif(error.response.status);
                });
            },

            openRegisterAndNumberingModal: function (){
                if (this.UserIsVerifier.length == 0)
                    this.showRegisterAndNumberingModal=true;
                else {
                    this.dialogMessage = 'با توجه به اینکه درخواست تایید نهایی نشده است ثبت در دبیرخانه امکان پذیر نیست! شما می توانید آخرین وضعیت تایید درخواست را از بخش تاییدگنندگان مشاهده کنید.';
                    this.showDialogModal = true;
                }
            },

            registerAndNumbering:function () {
                axios.post('/financial/request/secretariat/numbering/register', {
                    rId: this.requestId,
                    letterDate: this.registerDate,
                    letterNumber: this.letterNumber
                }).then((response) => {
                    this.loadReceivedData(response.data);
                    this.$parent._getUnReadReceivedRequest();
                    this.makePagination(response.data);
                    this.showRegisterAndNumberingModal = false;
                    this.showRequestDetailModal = false;
                    this.$parent.displayNotif(response.status);
                    console.log(response);
                }, (error) => {
                    console.log(error);
                    this.$parent.displayNotif(error.response.status);
                });
            },


            myResizeModal: function() {
                var x = $.w.outerHeight();
                $('.dynamic-height-level-modal1').css('height', (x-320) + 'px');
                $('.dynamic-height-level-modal2').css('height', (x-460) + 'px');
                $('.dynamic-height-level-modal3').css('height', (x-580) + 'px');
            },

            addNewAttachment(e) {
                this.extension= e.target.files[0].name.split('.').pop().toLowerCase();
                var files = e.target.files || e.dataTransfer.files;
                if (!files.length)
                    return;

                var newAttachments = [];
                for (var i = files.length - 1; i >= 0; i--) {
                    console.log(files[i].size);
                    if((files[i].size / 1000).toFixed(1) > 2048){
                        this.$parent.displayNotif(2);
                    }
                    else{
                        newAttachments.push(files[i]);
                    }
                }

                if (newAttachments.length > 0) {
                    this.showLoaderProgress = true;
                    this.data = new FormData();
                    for (var i = 0; i < newAttachments.length; i++) {
                        let attachment = newAttachments[i];
                        this.data.append('attachments[]', attachment);
                        //console.log(attachment.name);
                    }

                    this.data.append('rId', this.requestId);
                    axios.post('/financial/request/attachment/new', this.data).then((response) => {
                        this.updateReceiveRequestData(response.data , this.requestId);
                        this.showLoaderProgress = false;
                        this.$parent.displayNotif(response.status);
                        console.log(response);
                        this.data = new FormData();
                    }, (error) => {
                        console.log(error);
                        this.showLoaderProgress = false;
                        this.$parent.displayNotif(error.response.status);
                        this.data = new FormData();
                    });
                }
            },

            openDeleteAttachmentCinfirmModel: function(aId)
            {
                this.attachmentIdForDelete = aId;
                this.showDeleteAttachmentConfirmModal = true;
            },

            removeAttachment: function () {
                this.showDeleteAttachmentConfirmModal = false;
                axios.post('/financial/request/attachment/delete', {
                    rId: this.requestId,
                    id: this.attachmentIdForDelete
                }).then((response) => {
                    this.updateReceiveRequestData(response.data , this.requestId);
                    this.$parent.displayNotif(response.status);
                    console.log(response);
                }, (error) => {
                    console.log(error);
                    this.$parent.displayNotif(error.response.status);
                });
            },

            openBlockModal: function () {
                this.blockInput = {};
                if (!this.draftIsExist)
                    this.showBlockModal = true;
                else
                {
                    this.dialogMessage = 'با توجه به اینکه برای درخواست حواله صادر شده است، امکان مسدود کردن درخواست وجود ندارد.';
                    this.showDialogModal = true;
                }
            },

            requestBlock: function () {
                this.$validator.validateAll().then((result) => {
                    if (result) {
                        axios.post('/financial/request/block' , {
                            rId: this.requestId,
                            description: this.blockInput.description
                        }).then((response) => {
                            this.loadReceivedData(response.data);
                            this.$parent._getUnReadReceivedRequest();
                            this.makePagination(response.data);
                            this.showBlockModal = false;
                            this.showRequestDetailModal = false;
                            this.$parent.displayNotif(response.status);
                        },(error) => {
                            console.log(error);
                        });
                    }
                });
            },

            openTerminateModal: function () {
                this.terminateInput = {};
                if (this.isPaid)
                    this.showTerminateModal = true;
                else
                {
                    this.dialogMessage = 'درخواست پرداخت نهایی نشده است، پرداخت نهایی به معنای تحویل کلیه چک ها است.';
                    this.showDialogModal = true;
                }
            },

            requestTerminate: function () {
                axios.post('/financial/request/terminate' , {
                    rId: this.requestId,
                    description: this.terminateInput.description
                }).then((response) => {
                    this.loadReceivedData(response.data);
                    this.$parent._getUnReadReceivedRequest();
                    this.makePagination(response.data);
                    this.showTerminateModal = false;
                    this.showRequestDetailModal = false;
                    this.$parent.displayNotif(response.status);
                },(error) => {
                    console.log(error);
                });
            },
        }
    }
</script>
