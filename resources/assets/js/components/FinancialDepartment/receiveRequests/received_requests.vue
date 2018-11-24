<template>
    <!--Body system-->
    <div class="border-right-line inner-body-pad">
        <div class="grid-x padding-lr breadcrumbs-pos">
            <div class="large-12 medium-12 small-12">
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
            <div class="large-12 medium-12 small-12 padding-lr">
                <ul class="tabs tab-color my-tab-style" data-responsive-accordion-tabs="tabs medium-accordion large-tabs" id="receive_Requests_tab_view">
                    <li v-if="receiveRequests.REQUEST.unreadCount > 0" class="tabs-title is-active"><a href="#rr_REQUEST" aria-selected="true">  درخواست  <span v-show="receiveRequests.REQUEST.unreadCount > 0" class="notif-badge-purple">{{receiveRequests.REQUEST.unreadCount}}</span></a></li>
                    <li v-else class="tabs-title is-active"><a href="#rr_REQUEST" aria-selected="true">  درخواست  <span v-show="receiveRequests.REQUEST.readCount > 0" class="notif-badge-gray">{{receiveRequests.REQUEST.readCount}}</span></a></li>
                    <li v-if="receiveRequests.FINANCIAL.unreadCount > 0" class="tabs-title"><a href="#rr_FINANCIAL"> تامین اعتبار <span v-show="receiveRequests.FINANCIAL.unreadCount > 0" class="notif-badge-purple">{{receiveRequests.FINANCIAL.unreadCount}}</span></a></li>
                    <li v-else class="tabs-title"><a href="#rr_FINANCIAL"> تامین اعتبار <span v-show="receiveRequests.FINANCIAL.readCount > 0" class="notif-badge-gray">{{receiveRequests.FINANCIAL.readCount}}</span></a></li>
                    <li v-if="receiveRequests.PURCHASE_AND_CONTRACT.unreadCount > 0" class="tabs-title"><a href="#rr_PURCHASE_AND_CONTRACT"> خرید / قرارداد<span v-show="receiveRequests.PURCHASE_AND_CONTRACT.unreadCount > 0" class="notif-badge-purple">{{receiveRequests.PURCHASE_AND_CONTRACT.unreadCount}}</span></a></li>
                    <li v-else class="tabs-title"><a href="#rr_PURCHASE_AND_CONTRACT"> خرید / قرارداد<span v-show="receiveRequests.PURCHASE_AND_CONTRACT.readCount > 0" class="notif-badge-gray">{{receiveRequests.PURCHASE_AND_CONTRACT.readCount}}</span></a></li>
                    <li v-if="receiveRequests.PAYMENT.unreadCount > 0" class="tabs-title"><a href="#rr_PAYMENT"> درخواست پرداخت <span v-show="receiveRequests.PAYMENT.unreadCount > 0" class="notif-badge-purple">{{receiveRequests.PAYMENT.unreadCount}}</span></a></li>
                    <li v-else class="tabs-title"><a href="#rr_PAYMENT"> درخواست پرداخت <span v-show="receiveRequests.PAYMENT.readCount > 0" class="notif-badge-gray">{{receiveRequests.PAYMENT.readCount}}</span></a></li>
                    <li v-if="receiveRequests.DRAFT.unreadCount > 0" class="tabs-title"><a href="#rr_DRAFT"> حواله <span v-show="receiveRequests.DRAFT.unreadCount > 0" class="notif-badge-purple">{{receiveRequests.DRAFT.unreadCount}}</span></a></li>
                    <li v-else class="tabs-title"><a href="#rr_DRAFT"> حواله <span v-show="receiveRequests.DRAFT.readCount > 0" class="notif-badge-gray">{{receiveRequests.DRAFT.readCount}}</span></a></li>
                </ul>
                <div class="tabs-content" data-tabs-content="receive_Requests_tab_view">
                    <!--receiveRequests_REQUEST Tab-->
                    <div class="tabs-panel is-active table-mrg-btm" id="rr_REQUEST">
                        <div class="grid-x">
                            <div class="large-12 medium-12 small-12">
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
                            </div>
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
                                    <div class="tbl_body_style dynamic-height-level2">
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
                                            <tr class="table-row" @click="getRequestDetail('REQUEST' , index)" v-for="(receiveRequest , index) in receiveRequests.REQUEST.data">
                                                <td v-show="receiveRequest.rLastRef.rhHasBeenSeen == 0" class="text-center icon-padding-btm"><i class="far fa-envelope size-21 purple-color"></i></td>
                                                <td v-show="receiveRequest.rLastRef.rhHasBeenSeen == 1" class="text-center icon-padding-btm"><i class="far fa-envelope-open size-21 gray-colors"></i></td>
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
                                                        <div v-if="(parseInt(receiveRequest.rAcceptedAmount) != parseInt(receiveRequest.rCommitmentAmount)) && receiveRequest.isFromRefundCosts == false">
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
                                                        <div v-else>
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
                            </div>
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
                                    <div class="tbl_body_style dynamic-height-level2">
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
                                            <tr class="table-row" @click="getRequestDetail('FINANCIAL' , index)" v-for="(receiveFinancial , index) in receiveRequests.FINANCIAL.data">
                                                <td v-show="receiveFinancial.rLastRef.rhHasBeenSeen == 0" class="text-center icon-padding-btm"><i class="far fa-envelope size-21 purple-color"></i></td>
                                                <td v-show="receiveFinancial.rLastRef.rhHasBeenSeen == 1" class="text-center icon-padding-btm"><i class="far fa-envelope-open size-21 gray-colors"></i></td>
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
                                                        <div v-if="(parseInt(receiveFinancial.rAcceptedAmount) != parseInt(receiveFinancial.rCommitmentAmount)) && receiveFinancial.isFromRefundCosts == false">
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
                                                        <div v-else>
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
                            </div>
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
                                    <div class="tbl_body_style dynamic-height-level2">
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
                                            <tr class="table-row" @click="getRequestDetail('PURCHASE_AND_CONTRACT' , index)" v-for="(receivePAndC , index) in receiveRequests.PURCHASE_AND_CONTRACT.data">
                                                <td v-show="receivePAndC.rLastRef.rhHasBeenSeen == 0" class="text-center icon-padding-btm"><i class="far fa-envelope size-21 purple-color"></i></td>
                                                <td v-show="receivePAndC.rLastRef.rhHasBeenSeen == 1" class="text-center icon-padding-btm"><i class="far fa-envelope-open size-21 gray-colors"></i></td>
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
                                                        <div v-if="(parseInt(receivePAndC.rAcceptedAmount) != parseInt(receivePAndC.rCommitmentAmount)) && receivePAndC.isFromRefundCosts == false">
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
                                                        <div v-else>
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
                            </div>
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
                                    <div class="tbl_body_style dynamic-height-level2">
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
                                            <tr class="table-row" @click="getRequestDetail('PAYMENT' , index)" v-for="(receivePayment , index) in receiveRequests.PAYMENT.data">
                                                <td v-show="receivePayment.rLastRef.rhHasBeenSeen == 0" class="text-center icon-padding-btm"><i class="far fa-envelope size-21 purple-color"></i></td>
                                                <td v-show="receivePayment.rLastRef.rhHasBeenSeen == 1" class="text-center icon-padding-btm"><i class="far fa-envelope-open size-21 gray-colors"></i></td>
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
                                                        <div v-if="(parseInt(receivePayment.rAcceptedAmount) != parseInt(receivePayment.rCommitmentAmount)) && receivePayment.isFromRefundCosts == false">
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
                                                        <div v-else>
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
                            </div>
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
                                    <div class="tbl_body_style dynamic-height-level2">
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
                                            <tr class="table-row" @click="getRequestDetail('DRAFT' , index)" v-for="(receiveDraft , index) in receiveRequests.DRAFT.data">
                                                <td v-show="receiveDraft.rLastRef.rhHasBeenSeen == 0" class="text-center icon-padding-btm"><i class="far fa-envelope size-21 purple-color"></i></td>
                                                <td v-show="receiveDraft.rLastRef.rhHasBeenSeen == 1" class="text-center icon-padding-btm"><i class="far fa-envelope-open size-21 gray-colors"></i></td>
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
                                                        <div v-if="(parseInt(receiveDraft.rAcceptedAmount) != parseInt(receiveDraft.rCommitmentAmount)) && receiveDraft.isFromRefundCosts == false">
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
                <div class="small-font" style="z-index: 2">
                    <div class="grid-x">
                        <div class="large-12 medium-12 small-12 container-vh">
                            <ul class="tabs tab-color my-tab-style" data-responsive-accordion-tabs="tabs medium-accordion large-tabs" id="request_tab_view">
                                <li class="tabs-title" :class="selectedRequest.request_level.rlLevel == 'REQUEST' ? 'is-active' : ''"><a href="#requestDetailTab" aria-selected="true">جزییات</a></li>
                                <li class="tabs-title"><a href="#requestVerifiersTab">تایید کنندگان </a></li>
                                <li class="tabs-title" :class="selectedRequest.request_level.rlLevel == 'FINANCIAL' ? 'is-active' : ''"><a href="#creditsTab">اعتبارات</a></li>
                                <li class="tabs-title" :class="selectedRequest.request_level.rlLevel == 'PURCHASE_AND_CONTRACT' ? 'is-active' : ''" v-if="selectedRequest.request_type.rtType == 'BUY_COMMODITY'"><a href="#factorTab">اطلاعات فاکتور</a></li>
                                <li class="tabs-title" :class="selectedRequest.request_level.rlLevel == 'PURCHASE_AND_CONTRACT' ? 'is-active' : ''" v-if="selectedRequest.request_type.rtType == 'BUY_SERVICES'"><a href="#contractTab">اطلاعات قرارداد</a></li>
                                <li v-if="selectedRequest.request_type.rtType == 'BUY_SERVICES'" class="tabs-title" :class="selectedRequest.request_level.rlLevel == 'PAYMENT' ? 'is-active' : ''"><a href="#payRequestTab">درخواست پرداخت </a></li>
                                <li class="tabs-title" :class="selectedRequest.request_level.rlLevel == 'DRAFT' ? 'is-active' : ''"><a href="#draftTab">حواله </a></li>
                                <li class="tabs-title"><a href="#requestHistoryTab">تاریخچه </a></li>
                                <li class="tabs-title"><a href="#requestAttachmentsTab">پیوست ها <span v-show="selectedRequest.attachment.length > 0" class="notif-badge-success">{{selectedRequest.attachment.length}}</span> </a></li>
                            </ul>
                            <div class="tabs-content inner-vh" data-tabs-content="request_tab_view">
                                <!--Tab 1-->
                                <div class="tabs-panel table-mrg-btm" :class="selectedRequest.request_level.rlLevel == 'REQUEST' ? 'is-active' : ''" id="requestDetailTab">
                                    <rDetails v-on:updateReceiveRequestData="updateReceiveRequestData"
                                              v-bind:requestTypeDetail="selectedRequest.request_type.rtType"
                                              v-bind:requestFill="selectedRequest"
                                              v-bind:selectedBuffer="selectedBuffer"
                                              v-bind:selectedIndex="selectedIndex"
                                              v-bind:selectedRequest="selectedRequest"
                                              v-on:setRepoExistCountParent="setRepoExistCount"
                                              v-bind:searchValue="requestSearchValue">
                                    </rDetails>
                                </div>
                                <!--Tab 1-->
                                <!--Tab 2-->
                                <div style="height: 65vh;" class="tabs-panel table-mrg-btm inner-vh-unsize" id="requestVerifiersTab" xmlns:v-on="http://www.w3.org/1999/xhtml">
                                    <div class="grid-x">
                                        <div v-for="verifier in selectedRequest.verifiers" class="large-12 medium-12 small-12 verifier-panel">
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
                                <div class="tabs-panel table-mrg-btm" :class="selectedRequest.request_level.rlLevel == 'FINANCIAL' ? 'is-active' : ''" id="creditsTab" xmlns:v-on="http://www.w3.org/1999/xhtml">
                                    <rCredits v-if="selectedRequest.isFromRefundCosts != true" v-on:closeModal="showRequestDetailModal=false"
                                              v-on:updateReceiveRequestData="updateReceiveRequestData"
                                              v-on:updateCommitmentAmount="updateCommitmentAmount"
                                              v-bind:baseAmount="baseAmount"
                                              v-bind:requestType="selectedRequest.request_type.rtType"
                                              v-bind:requestFill="selectedRequest"
                                              v-bind:UserIsVerifier="selectedRequest.rRemainingVerifiers"
                                              v-bind:requestId="requestId"
                                              v-bind:factorCount="selectedRequest.factor.length"
                                              v-bind:searchValue="requestSearchValue">
                                    </rCredits>
                                    <div v-else class="text-center inner-vh-unsize" style="height: 60vh;display: table">
                                        <div style="display: table-cell; vertical-align: middle;">
                                            <div class="grid-x">
                                                <div style="margin:0 auto;" class="large-4 medium-4 small-12">
                                                    <p class="black-color text-justify" style="font-size: 1rem">کاربر گرامی:</p>
                                                    <p class="large-offset-1 modal-text text-justify">تامین اعتبار این درخواست از تنخواه گردان کارپردازی در نظر گرفته شده است.</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--Tab 3-->
                                <!--Tab 4-->
                                <div class="tabs-panel table-mrg-btm" :class="selectedRequest.request_level.rlLevel == 'PURCHASE_AND_CONTRACT' ? 'is-active' : ''" id="contractTab" xmlns:v-on="http://www.w3.org/1999/xhtml">
                                    <rContract v-if="selectedRequest.request_type.rtType == 'BUY_SERVICES'"
                                               v-on:closeModal="showRequestDetailModal=false"
                                               v-on:updateReceiveRequestData="updateReceiveRequestData"
                                               v-bind:requestId="requestId"
                                               v-bind:contracts="selectedRequest.contract"
                                               v-bind:requestSubject="selectedRequest.rSubject"
                                               v-bind:rCreditIsAccepted="selectedRequest.rCreditIsAccepted"
                                               v-bind:rCostEstimation="selectedRequest.rCostEstimation"
                                               v-bind:rCreditIsExist="selectedRequest.rCreditIsExist"
                                               v-bind:searchValue="requestSearchValue">
                                    </rContract>
                                </div>
                                <!--Tab 4-->
                                <!--Tab 5-->
                                <div class="tabs-panel table-mrg-btm" :class="selectedRequest.request_level.rlLevel == 'PURCHASE_AND_CONTRACT' ? 'is-active' : ''" id="factorTab" xmlns:v-on="http://www.w3.org/1999/xhtml">
                                    <rFactor v-if="selectedRequest.request_type.rtType == 'BUY_COMMODITY'"
                                             v-on:closeModal="showRequestDetailModal=false"
                                             v-on:updateReceiveRequestData="updateReceiveRequestData"
                                             v-bind:requestId="requestId"
                                             v-bind:factors="selectedRequest.factor"
                                             v-bind:rCreditIsAccepted="selectedRequest.rCreditIsAccepted"
                                             v-bind:rCreditIsExist="selectedRequest.rCreditIsExist"
                                             v-bind:isFromRefundCosts="selectedRequest.isFromRefundCosts"
                                             v-bind:request="selectedRequest"
                                             v-bind:searchValue="requestSearchValue">
                                    </rFactor>
                                </div>
                                <!--Tab 5-->
                                <!--Tab 6-->
                                <div v-if="selectedRequest.request_type.rtType == 'BUY_SERVICES'" class="tabs-panel table-mrg-btm" :class="selectedRequest.request_level.rlLevel == 'PAYMENT' ? 'is-active' : ''" id="payRequestTab" xmlns:v-on="http://www.w3.org/1999/xhtml">
                                    <r-pay-request
                                            v-on:closeModal="showRequestDetailModal=false"
                                            v-on:updateReceiveRequestData="updateReceiveRequestData"
                                            v-on:openReferralsModal="openReferralsModal"
                                            v-on:openResponseRequestModal="openResponseRequestModal"
                                            v-bind:requestId="requestId"
                                            v-bind:payRequests="selectedRequest.pay_request"
                                            v-bind:lastRefPrId="selectedRequest.rLastRef.rhPrId"
                                            v-bind:contracts="selectedRequest.contract"
                                            v-bind:factors="selectedRequest.factor"
                                            v-bind:rAcceptedAmount="selectedRequest.rAcceptedAmount"
                                            v-bind:rCommitmentAmount="selectedRequest.rCommitmentAmount"
                                            v-bind:requestType="selectedRequest.request_type.rtType"
                                            v-bind:drafts="selectedRequest.draft"
                                            v-bind:sumOfDraftAmount="selectedRequest.rSumOfDraftAmount"
                                            v-bind:paymentRequestAmount="paymentRequestAmount"
                                            v-bind:searchValue="requestSearchValue">
                                    </r-pay-request>
                                </div>
                                <!--Tab 6-->
                                <!--Tab 6-->
                                <div class="tabs-panel table-mrg-btm" :class="selectedRequest.request_level.rlLevel == 'DRAFT' ? 'is-active' : ''" id="draftTab" xmlns:v-on="http://www.w3.org/1999/xhtml">
                                    <rDraft  v-on:closeModal="showRequestDetailModal=false"
                                             v-on:updateReceiveRequestData="updateReceiveRequestData"
                                             v-on:openReferralsModal="openReferralsModal"
                                             v-on:openResponseRequestModal="openResponseRequestModal"
                                             v-bind:request="selectedRequest"
                                             v-bind:contracts="selectedRequest.contract"
                                             v-bind:factors="selectedRequest.factor"
                                             v-bind:rAcceptedAmount="selectedRequest.rAcceptedAmount"
                                             v-bind:rCommitmentAmount="selectedRequest.rCommitmentAmount"
                                             v-bind:requestType="selectedRequest.request_type.rtType"
                                             v-bind:drafts="selectedRequest.draft"
                                             v-bind:sumOfDraftAmount="selectedRequest.rSumOfDraftAmount"
                                             v-bind:lastRefDId="selectedRequest.rLastRef.rhDId"
                                             v-bind:resultType="'RECEIVED'"
                                             v-bind:searchValue="requestSearchValue">
                                    </rDraft>
                                </div>
                                <!--Tab 6-->
                                <!--Tab 7-->
                                <div style="height: 65vh;" class="tabs-panel table-mrg-btm inner-vh-unsize" id="requestHistoryTab" xmlns:v-on="http://www.w3.org/1999/xhtml">
                                    <div class="grid-x">
                                        <div class="large-12 medium-12 small-12 large-top-m">
                                            <div style="margin-top:-50px;" v-for="recipientUser in selectedRequest.history" class="grid-x timeline">
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
                                                                    <div v-if="recipientUser.destination_user_info != null && selectedRequest.request_state.rsState != 'WAITING_FOR_PAY_REQUEST'">
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
                                <div style="height: 65vh;" class="tabs-panel table-mrg-btm inner-vh-2" id="requestAttachmentsTab" xmlns:v-on="http://www.w3.org/1999/xhtml">
                                    <div class="grid-x">
                                        <vue-element-loading :active="showLoaderProgress" spinner="line-down" color="#716aca"/>
                                        <div class="medium-12 padding-lr">
                                            <label v-show='$can("UNIT_OF_CONTRACT_ADD_NEW_ATTACHMENT")' class="my-button toolbox-btn"> انتخاب فایل
                                                <input @change="addNewAttachment" accept=".jpg,.jpeg,.png,.doc,.docx,.doc,.xls,.xlsx,.pdf" id="File" type="file">
                                            </label>
                                        </div>
                                        <div class="medium-12">
                                            <div class="grid-x">
                                                <div style="margin-top: 15px;margin-bottom: 15px;" v-for="(attachment, index) in receiveRequests[selectedBuffer].data[selectedIndex].attachment" class="large-3 medium-4 small-12 padding-lr">
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
                        <div class="large-12 medium-12 small-12 medium-top-m" style="z-index: 4;">
                            <div style="margin-bottom:-10px;" class="stacked-for-small button-group">
                                <button @click="openSubmitRequestModal()" v-if=" youAreVerifier != '' "  class="my-button my-success float-left btn-for-load"><span class="btn-txt-mrg">  تایید</span></button>
                                <button v-show='$can("SECRETARIAT_REGISTER_AND_NUMBERING") && selectedRequest.rLetterNumber == null && selectedRequest.rLetterDate == null' style="width:130px;" @click="openRegisterAndNumberingModal()" class="my-button my-success"><span class="btn-txt-mrg">  ثبت دبیرخانه</span></button>
                                <button @click="openReferralsModal()"  class="my-button toolbox-btn"><span class="btn-txt-mrg">  ارجاع</span></button>
                                <button @click="openResponseRequestModal()" v-show="selectedRequest.rLastRef.rhIsReferral == true" class="my-button toolbox-btn"><span class="btn-txt-mrg">  پاسخ</span></button>
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
                                <label>دریافت کننده
                                    <select name="selectUser" v-model="referralInput.destUId"  v-validate data-vv-rules="required" :class="{'input': true, 'select-error': errors.has('selectUser')}">
                                        <option value=""></option>
                                        <option v-for="groupUser in groupUsers" :value="groupUser.id">{{groupUser.name}} - {{groupUser.role.rSubject}}</option>
                                    </select>
                                    <p v-show="errors.has('selectUser')" class="error-font">لطفا دریافت کننده را انتخاب کنید!</p>
                                </label>
                            </div>
                            <div name="selectUser" v-if="referralPermission == true" class="large-12 medium-12 small-12 padding-lr">
                                <label>دریافت کننده
                                    <select v-model="referralInput.destUId">
                                        <option value=""></option>
                                        <option v-for="groupUsersByCIds in groupUsersByCId" :value="groupUsersByCIds.id">{{groupUsersByCIds.name}} - {{groupUsersByCIds.role.rSubject}}</option>
                                    </select>
                                    <p v-show="errors.has('selectUser')" class="error-font">لطفا دریافت کننده را انتخاب کنید!</p>
                                </label>
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
                        <button v-show="!$root.btnLoadingCheckStatus" type="submit"  class="my-button my-success float-left btn-for-load"><span class="btn-txt-mrg">  ارجاع</span></button>
                        <p v-show="$root.btnLoadingCheckStatus" class="my-button my-success float-left btn-for-load"><i class="fas fa-spinner fa-pulse btn-txt-mrg"></i></p>
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
                        <template v-if="selectedRequest.rRemainingVerifiers.length <= 0">
                            <div class="large-12 medium-12 small-12 padding-lr">
                                <p class="black-color">آیا برای تایید درخواست اطمینان دارید؟ </p>
                            </div>
                            <div class="large-12 medium-12 small-12 padding-lr">
                                <p class="btn-red">تایید شما به منزله امضا درخواست می باشد.</p>
                            </div>
                            <div class="large-12 medium-12 small-12 padding-lr small-top-m text-center">
                                <button v-show="!$root.btnLoadingCheckStatus" @click="acceptRequest()"  class="my-button my-success btn-for-load"><span class="btn-txt-mrg">  تایید</span></button>
                                <p v-show="$root.btnLoadingCheckStatus" class="my-button my-success"><i class="fas fa-spinner fa-pulse btn-txt-mrg"></i></p>
                            </div>
                        </template>
                        <template v-if="selectedRequest.rRemainingVerifiers.length > 0">
                            <div class="large-12 medium-12 small-12 padding-lr text-center">
                                <p class="modal-text">تایید کنندگان زیر تاکنون درخواست مورد نظر را تایید نکرده اند. در حال حاضر شما امکان تایید درخواست را ندارید. </p>
                            </div>
                            <div v-for="UserVerifier in selectedRequest.rRemainingVerifiers" class="large-12 medium-12 small-12 verifier-panel">
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
                    <form v-on:submit.prevent="responseRequest">
                    <div class="grid-x">
                        <div class="large-12 medium-12 small-12 padding-lr response-panel">
                            <p class="modal-text response-header">پاسخ به :</p>
                            <p class="gray-colors">{{selectedRequest.rLastRef.rhDescription}}</p>
                            <p style="margin-bottom:-10px;color:#9E9E9E;" class="direction-ltr small-font"><span class="black-color">ارجاع دهنده : </span> {{selectedRequest.rLastRef.source_user_info.name + ' - ' + selectedRequest.rLastRef.source_user_info.role.rSubject}}</p>

                        </div>
                            <div class="large-12 medium-12 small-12 small-top-m">
                                <label>متن پاسخ
                                    <textarea v-model="responseDescription"  class="form-element-margin-btm"  style="min-height: 150px;" name="responseDescription"  v-validate="'required'" :class="{'input': true, 'error-border': errors.has('responseDescription')}"></textarea>
                                    <span v-show="errors.has('responseDescription')" class="error-font">لطفا متن پاسخ را وارد کنید!</span>
                                </label>
                            </div>
                            <div class="large-12 medium-12 small-12 padding-lr small-top-m text-center">
                                <button v-show="!$root.btnLoadingCheckStatus" type="submit"  class="my-button my-success btn-for-load"><span class="btn-txt-mrg">  پاسخ</span></button>
                                <p v-show="$root.btnLoadingCheckStatus" class="my-button my-success"><i class="fas fa-spinner fa-pulse btn-txt-mrg"></i></p>
                            </div>
                        </div>
                    </form>
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
                                <date-picker
                                        :color="letterDateAlert ? '#d9534f' : '#5c6bc0'"
                                        v-model="registerDate"
                                        input-class="form-control form-control-lg date-picker-bottom-margin"
                                        id="my-custom-input"
                                        placeholder="انتخاب تاریخ">
                                </date-picker>
                            </label>
                            <p style="margin-top:3px !important;" v-show="letterDateAlert" class="error-font">لطفا تاریخ ثبت درخواست را انتخاب نمایید!</p>
                        </div>
                        <div class="large-12 medium-12 small-12 padding-lr">
                            <label> شماره
                                <input class="form-element-margin-btm" autocomplete="off" type="text" name="letterNumber" v-model="letterNumber" v-validate="'required'" data-vv-as="field" :class="{'input': true, 'error-border': errors.has('letterNumber')}">
                                <span v-show="errors.has('letterNumber')" class="error-font">شماره ثبت فراموش شده / نامعتبر است!</span>
                            </label>
                        </div>
                        <div class="large-12 medium-12 small-12 padding-lr small-top-m text-center">
                            <button v-show="!$root.btnLoadingCheckStatus" @click="registerAndNumbering()"  class="my-button my-success btn-for-load"><span class="btn-txt-mrg">  ثبت</span></button>
                            <p v-show="$root.btnLoadingCheckStatus" class="my-button my-success"><i class="fas fa-spinner fa-pulse btn-txt-mrg"></i></p>
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
                        <button v-show="!$root.btnLoadingCheckStatus" type="submit"  class="my-button my-success"><span class="btn-txt-mrg">  مسدود</span></button>
                        <p v-show="$root.btnLoadingCheckStatus" class="my-button my-success"><i class="fas fa-spinner fa-pulse btn-txt-mrg"></i></p>
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
                        <button v-show="!$root.btnLoadingCheckStatus" type="submit"  class="my-button my-success"><span class="btn-txt-mrg">  خاتمه</span></button>
                        <p v-show="$root.btnLoadingCheckStatus" class="my-button my-success float-left"><i class="fas fa-spinner fa-pulse btn-txt-mrg"></i></p>
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
                requestSearchValue: '',
                selectedBuffer: '',
                selectedIndex: -1,
                selectedRequest:{},
                attachmentIdForDelete: 0,
                showLoaderProgress:false,
                receiveRequests: {REQUEST:{data:[]},FINANCIAL:{data:[]},PURCHASE_AND_CONTRACT:{data:[]},PAYMENT:{data:[]},DRAFT:{data:[]}},
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
                blockInput:{},
                terminateInput: {},
                remainingVerifiers:[],
                groupUsers:[],
                groupUsersByCId:[],
                referralPermission:false,
                referralInput:{},
                youAreVerifier:'',
                youAreVerifierCId:'',
                responseDescription:'',
                baseURL:window.hostname+'/',
                repoExistCount:[],
                commodityCount:'',
                registerDate: '',
                requestId: '',
                letterNumber: '',
                money: {
                    thousands: ',',
                    decimal:'.',
                    masked: true
                },
                baseAmount:0,
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
                draftIsExist: false,
                rCostEstimation:0,

                referralDId: null,
                referralPrId: null,
                paymentRequestAmount:0,
                letterDateAlert:false,
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

        watch:{
            receiveRequests: function (newValue , oldValue) {
                if (this.selectedIndex != -1)
                {
                    this.selectedRequest = newValue[this.selectedBuffer].data[this.selectedIndex];
                    this.requestId = this.selectedRequest.id;
                    this.getBaseAmount();
                    this.getDraftIsExist();
                    this.getIamVerifier();
                }
            },

            registerDate: function (newQuestion, oldQuestion) {
                if(this.registerDate != null)
                    this.letterDateAlert=false;
            },

        },

        methods: {
            setRepoExistCount:function(cECount){
                this.repoExistCount=cECount;
            },

            updateReceiveRequestData: function(requests){
                this.loadReceivedData(requests);
                this.makePagination(requests);
            },

            loadReceivedData: function(requests){
                var unreadCount = 0;
                var readCount = 0;

                requests.REQUEST.data.forEach(item =>{
                    if(item.rLastRef.rhHasBeenSeen == 0){
                        unreadCount += 1;
                    }
                    if(item.rLastRef.rhHasBeenSeen == 1){
                        readCount += 1;
                    }
                });

                Vue.set(requests.REQUEST , 'unreadCount' , unreadCount);
                Vue.set(requests.REQUEST , 'readCount' , readCount);
                /////////////////////////////////////
                unreadCount = 0;
                readCount = 0;
                requests.FINANCIAL.data.forEach(item =>{
                    if(item.rLastRef.rhHasBeenSeen == 0){
                        unreadCount += 1;
                    }
                    if(item.rLastRef.rhHasBeenSeen == 1){
                        readCount += 1;
                    }
                });

                Vue.set(requests.FINANCIAL , 'unreadCount' , unreadCount);
                Vue.set(requests.FINANCIAL , 'readCount' , readCount);
                //////////////////////////////////////
                unreadCount = 0;
                readCount = 0;
                requests.PURCHASE_AND_CONTRACT.data.forEach(item =>{
                    if(item.rLastRef.rhHasBeenSeen == 0){
                        unreadCount += 1;
                    }
                    if(item.rLastRef.rhHasBeenSeen == 1){
                        readCount += 1;
                    }
                });

                Vue.set(requests.PURCHASE_AND_CONTRACT , 'unreadCount' , unreadCount);
                Vue.set(requests.PURCHASE_AND_CONTRACT , 'readCount' , readCount);
                //////////////////////////////////////
                unreadCount = 0;
                readCount = 0;
                requests.PAYMENT.data.forEach(item =>{
                    if(item.rLastRef.rhHasBeenSeen == 0){
                        unreadCount += 1;
                    }
                    if(item.rLastRef.rhHasBeenSeen == 1){
                        readCount += 1;
                    }
                });

                Vue.set(requests.PAYMENT , 'unreadCount' , unreadCount);
                Vue.set(requests.PAYMENT , 'readCount' , readCount);
                //////////////////////////////////////
                unreadCount = 0;
                readCount = 0;
                requests.DRAFT.data.forEach(item =>{
                    if(item.rLastRef.rhHasBeenSeen == 0){
                        unreadCount += 1;
                    }
                    if(item.rLastRef.rhHasBeenSeen == 1){
                        readCount += 1;
                    }
                });

                Vue.set(requests.DRAFT , 'unreadCount' , unreadCount);
                Vue.set(requests.DRAFT , 'readCount' , readCount);
                this.receiveRequests = requests;
                console.log(JSON.stringify(this.receiveRequests));
            },

            updateCommitmentAmount: function(amount){
                this.selectedRequest.rCommitmentAmount = amount;
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

            search: function () {
                this.fetchData();
            },

            removeFilter: function () {
                this.requestSearchValue = '';
                this.fetchData();
            },

            fetchData: function (page=1) {
                axios.get('/financial/request/received/fetchData?page=' + page , {params:{searchValue:this.requestSearchValue}})
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

            getDraftIsExist: function(){
                this.draftIsExist = false;
                this.selectedRequest.draft.forEach(draft => {
                    if (draft.draft_state.dsState != 'BLOCKED')
                    {
                        this.draftIsExist = true;
                    }
                });
            },

            getBaseAmount: function(){
                if (this.selectedRequest.rAcceptedAmount > 0)
                    this.baseAmount= this.selectedRequest.rAcceptedAmount;
                else
                    this.baseAmount= this.selectedRequest.rCostEstimation;
            },

            getIamVerifier: function(){
                if(this.selectedRequest.rYouAreVerifiers.length != 0){
                    this.youAreVerifier=this.selectedRequest.rYouAreVerifiers[0].id;
                    this.youAreVerifierCId=this.selectedRequest.rYouAreVerifiers[0].request_step.rstCId;
                }
            },

            getRequestDetail: function (buffer , index) {
                this.selectedBuffer = buffer;
                this.selectedIndex = index;
                this.selectedRequest = this.receiveRequests[this.selectedBuffer].data[this.selectedIndex];
                if(this.selectedRequest.rLastRef.rhHasBeenSeen==false) {
                    axios.post('/financial/request/received/was_seen', {
                        rhId: this.selectedRequest.rLastRef.id,
                        searchValue: this.requestSearchValue
                    }).then((response) => {
                        this.loadReceivedData(response.data);
                        this.$parent._getUnReadReceivedRequest();
                        this.makePagination(response.data);
                        console.log(response);
                    }, (error) => {
                        console.log(error);
                    });
                }
                this.requestId = this.selectedRequest.id;
                this.getBaseAmount();
                this.getDraftIsExist();
                this.getIamVerifier();
                this.showRequestDetailModal=true;
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
                        var config = {
                            allowLoading:true,
                        };
                        axios.post('/financial/request/referral', {
                            acceptPermission: this.referralPermission == true ? 1 : 0,
                            destUId: this.referralInput.destUId,
                            lastRefId: this.selectedRequest.rLastRef.id,
                            description: this.referralInput.description,
                            verifierId:this.youAreVerifier,
                            dId:this.referralDId,
                            prId:this.referralPrId,
                            searchValue: this.requestSearchValue
                        } , config).then((response) => {
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
                        var config = {
                            allowLoading:true,
                        };
                        axios.post('/financial/request/accept', {
                            lastRefId: this.selectedRequest.rLastRef.id,
                            verifierId: this.youAreVerifier,
                            itemExistCount: this.repoExistCount,
                            searchValue: this.requestSearchValue
                        }, config).then((response) => {
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
                this.$validator.validateAll().then((result) => {
                    if (result) {
                        var config = {
                            allowLoading:true,
                        };
                        axios.post('/financial/request/response', {
                            lastRefId: this.selectedRequest.rLastRef.id,
                            description: this.responseDescription,
                            dId: this.referralDId,
                            prId: this.referralPrId,
                            searchValue: this.requestSearchValue
                        } , config).then((response) => {
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
                    }
                });
            },

            openRegisterAndNumberingModal: function (){
                this.letterNumber = '';
                this.registerDate = '';
                if (this.selectedRequest.rRemainingVerifiers.length == 0){
                    this.showRegisterAndNumberingModal=true;
                    this.letterDateAlert=false;
                }
                else {
                    this.dialogMessage = 'با توجه به اینکه درخواست تایید نهایی نشده است ثبت در دبیرخانه امکان پذیر نیست! شما می توانید آخرین وضعیت تایید درخواست را از بخش تاییدگنندگان مشاهده کنید.';
                    this.showDialogModal = true;
                }
            },

            registerAndNumbering:function () {
                this.$validator.validateAll().then((result) => {
                    if (this.registerDate == '')
                        this.letterDateAlert = true;
                    if(!this.letterDateAlert){
                        if (result) {
                            var config = {
                                allowLoading:true,
                            };
                            axios.post('/financial/request/secretariat/numbering/register', {
                                rId: this.requestId,
                                letterDate: this.registerDate,
                                letterNumber: this.letterNumber,
                                searchValue: this.requestSearchValue
                            } , config).then((response) => {
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
                        }
                    }
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
                        this.updateReceiveRequestData(response.data);
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
                    id: this.attachmentIdForDelete,
                    searchValue: this.requestSearchValue
                }).then((response) => {
                    this.updateReceiveRequestData(response.data);
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
                        var config = {
                            allowLoading:true,
                        };
                        axios.post('/financial/request/block' , {
                            rId: this.requestId,
                            description: this.blockInput.description,
                            searchValue: this.requestSearchValue
                        } , config).then((response) => {
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
                if (this.selectedRequest.rIsPaid)
                    this.showTerminateModal = true;
                else
                {
                    this.dialogMessage = 'درخواست پرداخت نهایی نشده است، پرداخت نهایی به معنای تحویل کلیه چک ها است.';
                    this.showDialogModal = true;
                }
            },

            requestTerminate: function () {
                var config = {
                    allowLoading:true,
                };
                axios.post('/financial/request/terminate' , {
                    rId: this.requestId,
                    description: this.terminateInput.description,
                    searchValue: this.requestSearchValue
                } , config).then((response) => {
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
