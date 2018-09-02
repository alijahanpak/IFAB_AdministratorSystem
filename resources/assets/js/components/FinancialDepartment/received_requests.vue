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
            <div class="medium-12 padding-lr" style="margin-top: 15px;">
                <div class="clearfix tool-bar">
                    <!--<div class="medium-12 column padding-lr">
                        <div class="float-left">
                            <div class="input-group float-left">
                                <div class="inner-addon right-addon">
                                    <i v-if="receiveRequestSearchValue == ''"   class="fa fa-search purple-color"  aria-hidden="true"></i>
                                    <i v-if="receiveRequestSearchValue != ''"  class="fa fa-close btn-red"  aria-hidden="true"></i>
                                    <input v-model="receiveRequestSearchValue" class="search" type="text" placeholder="جستجو">
                                </div>
                            </div>
                        </div>
                    </div>-->
                </div>
                <div class="medium-12 padding-lr" style="margin-top: 15px;">
                    <div class="medium-12 column">
                        <div class="tbl-div-container">
                            <table class="tbl-head">
                                <colgroup>
                                    <col width="80px"/>
                                    <col width="400px"/>
                                    <col width="300px"/>
                                    <col width="150px"/>
                                    <col width="200px"/>
                                    <col width="200px"/>
                                    <col width="200px"/>
                                    <col width="12px"/>
                                </colgroup>
                                <tbody class="tbl-head-style">
                                <tr class="tbl-head-style-cell">
                                    <th class="tbl-head-style-cell">وضعیت</th>
                                    <th class="tbl-head-style-cell">عنوان</th>
                                    <th class="tbl-head-style-cell">ارسال کننده</th>
                                    <th class="tbl-head-style-cell">نوع درخواست</th>
                                    <th class="tbl-head-style-cell">مبلغ برآوردی <span class="btn-red small-font">(ریال)</span></th>
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
                                        <col width="300px"/>
                                        <col width="150px"/>
                                        <col width="200px"/>
                                        <col width="200px"/>
                                        <col width="200px"/>
                                    </colgroup>
                                    <tbody class="tbl-head-style-cell">
                                    <tr class="table-row" @click="getRequestDetail(receiveRequest)" v-for="receiveRequest in receiveRequests">
                                        <td v-show="receiveRequest.rLastRef.rhHasBeenSeen == 0" class="text-center icon-padding-btm"><i class="far fa-envelope size-21 purple-color"></i></td>
                                        <td v-show="receiveRequest.rLastRef.rhHasBeenSeen == 1" class="text-center icon-padding-btm"><i class="far fa-envelope-open size-21 purple-color"></i></td>
                                        <td>{{receiveRequest.rSubject}}</td>
                                        <td>{{receiveRequest.rLastRef.source_user_info.name}} - {{receiveRequest.rLastRef.source_user_info.role.rSubject}}</td>
                                        <td v-if="receiveRequest.rRtId==1"> خدمات</td>
                                        <td v-else-if="receiveRequest.rRtId==2"> کالا</td>
                                        <td v-else="receiveRequest.rRtId==3"> تنخواه</td>
                                        <td>{{$parent.dispMoneyFormat(receiveRequest.rCostEstimation)}}</td>
                                        <td>{{receiveRequest.rLetterNumber}}</td>
                                        <td>{{receiveRequest.rLetterDate}}</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Request Detail Modal -->
        <modal-large v-if="showRequestDetailModal" @close="showRequestDetailModal = false">
            <div  slot="body">
                <div class="small-font">
                    <div class="grid-x">
                        <div class="large-12 medium-12 small-12">
                            <ul class="tabs tab-color my-tab-style" data-responsive-accordion-tabs="tabs medium-accordion large-tabs" id="request_tab_view">
                                <li class="tabs-title is-active"><a href="#requestDetailTab" aria-selected="true">جزییات</a></li>
                                <li class="tabs-title"><a href="#requestVerifiersTab">تایید کنندگان </a></li>
                                <li class="tabs-title"><a href="#creditsTab">اعتبارات</a></li>
                                <li class="tabs-title"><a href="#requestHistoryTab">تاریخچه </a></li>
                            </ul>
                            <div class="tabs-content" data-tabs-content="request_tab_view">
                                <!--Tab 1-->
                                <div class="tabs-panel is-active table-mrg-btm" id="requestDetailTab">
                                    <div class="grid-x">
                                        <div v-show="requestTypeDetail == 'SERVICES'" class="large-12 medium-12 small-12">
                                            <table>
                                                <tbody>
                                                <tr>
                                                    <td width="150px">شماره : </td>
                                                    <td>{{requestFill.rLetterNumber}}</td>
                                                </tr>
                                                <tr>
                                                    <td width="150px">تاریخ : </td>
                                                    <td>{{requestFill.rLetterDate}}</td>
                                                </tr>
                                                <tr>
                                                    <td width="150px">موضوع : </td>
                                                    <td>{{requestFill.rSubject}}</td>
                                                </tr>
                                                <tr>
                                                    <td width="150px">مبلغ برآوردی : </td>
                                                    <td>{{$parent.dispMoneyFormat(requestFill.rCostEstimation)}} <span class="btn-red">  ریال  </span></td>
                                                </tr>
                                                <tr>
                                                    <td width="150px">شرح کامل خدمات : </td>
                                                    <td class="text-justify">{{requestFill.rDescription}}</td>
                                                </tr>
                                                <tr>
                                                    <td width="150px">توضیحات تکمیلی : </td>
                                                    <td class="text-justify">{{requestFill.rFurtherDetails}}</td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>

                                        <div v-show="requestTypeDetail == 'COMMODITY'" class="large-12 medium-12 small-12">
                                            <table>
                                                <tbody>
                                                <tr>
                                                    <td width="150px">شماره : </td>
                                                    <td>{{requestFill.rLetterNumber}}</td>
                                                </tr>
                                                <tr>
                                                    <td width="150px">تاریخ : </td>
                                                    <td>{{requestFill.rLetterDate}}</td>
                                                </tr>
                                                <tr>
                                                    <td width="150px">موضوع : </td>
                                                    <td>{{requestFill.rSubject}}</td>
                                                </tr>
                                                </tbody>
                                            </table>

                                            <table>
                                                <thead>
                                                <th width="50">ردیف</th>
                                                <th>شرح و نوع جنس</th>
                                                <th width="100">تعداد</th>
                                                <th v-show='$can("DETERMINE_EXIST_COMMODITY_IN_REPOSITORY")' width="100">موجودی انبار</th>
                                                <th width="200">مبلغ برآوردی <span class="btn-red small-font">(ریال)</span></th>
                                                <th>توضیحات (موارد مصرف)</th>
                                                </thead>
                                                <tbody>
                                                <tr v-for="(lists,index) in commodityList">
                                                    <td>{{index+1}}</td>
                                                    <td>{{lists.commodity.cSubject}}</td>
                                                    <td>{{lists.rcCount}}</td>
                                                    <td v-show='$can("DETERMINE_EXIST_COMMODITY_IN_REPOSITORY")'>
                                                        <input v-on:change="setRepoExistCount(lists.id,commodityCountInput['existCount' + lists.id])" v-model="commodityCountInput['existCount' + lists.id]"  style="margin-bottom: 0px;" class="form-element-margin-btm" type="text" :name="'repoCount' + lists.id" v-validate="'required','min_value:0','max_value:'+lists.rcCount " data-vv-as="field" :class="{'input': true, 'error-border': errors.has('repoCount' + lists.id)}">
                                                        <span v-show="errors.has('repoCount' + lists.id)" class="error-font"></span>
                                                    </td>
                                                    <td>{{$parent.dispMoneyFormat(lists.rcCostEstimation)}}</td>
                                                    <td>{{lists.rcDescription}}</td>
                                                </tr>
                                                <tr>
                                                    <td colspan="4" class="text-center font-wei-bold"> مجموع برآورد</td>
                                                    <td colspan="2" class="text-center font-wei-bold">{{$parent.dispMoneyFormat(requestFill.rCostEstimation)}} <span class="btn-red">  ریال  </span> </td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>

                                        <div v-show="requestTypeDetail == 'FUND'" class="large-12 medium-12 small-12">
                                            <table>
                                                <tbody>
                                                <tr>
                                                    <td width="150px">شماره : </td>
                                                    <td>{{requestFill.rLetterNumber}}</td>
                                                </tr>
                                                <tr>
                                                    <td width="150px">تاریخ : </td>
                                                    <td>{{requestFill.rLetterDate}}</td>
                                                </tr>
                                                <tr>
                                                    <td width="150px">موضوع : </td>
                                                    <td>{{requestFill.rSubject}}</td>
                                                </tr>
                                                <tr>
                                                    <td width="150px">مبلغ برآوردی : </td>
                                                    <td>{{$parent.dispMoneyFormat(requestFill.rCostEstimation)}} <span class="btn-red">  ریال  </span></td>
                                                </tr>
                                                <tr>
                                                    <td width="150px">متن درخواست : </td>
                                                    <td class="text-justify">{{requestFill.rDescription}}</td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>

                                    </div>
                                </div>
                                <!--Tab 1-->
                                <!--Tab 2-->
                                <div class="tabs-panel table-mrg-btm" id="requestVerifiersTab" xmlns:v-on="http://www.w3.org/1999/xhtml">
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
                                <div class="tabs-panel table-mrg-btm" id="creditsTab" xmlns:v-on="http://www.w3.org/1999/xhtml">
                                    <div class="grid-x">
                                        <div class="large-12 medium-12 small-12">
                                            <ul class="tabs tab-color my-tab-style" data-responsive-accordion-tabs="tabs medium-accordion large-tabs" id="credit_tab_view">
                                                <li class="tabs-title is-active"><a href="#creditCapitalAssetsTab" aria-selected="true">تملک دارایی های سرمایه ای</a></li>
                                                <li class="tabs-title"><a href="#creditCostTab">هزینه ای </a></li>
                                            </ul>
                                            <div class="tabs-content" data-tabs-content="credit_tab_view">
                                                <div class="grid-x">
                                                    <div style="margin-top: 10px;" class="large-12 medium-12 small-12 direction-ltr">
                                                        <span class="cost-label">مبالغ : ریال</span>
                                                    </div>
                                                </div>
                                                <!--Tab 1-->
                                                <div class="tabs-panel is-active table-mrg-btm" id="creditCapitalAssetsTab">
                                                    <div class="grid-x">
                                                        <!--Table Start-->
                                                        <!--Table Head Start-->
                                                        <div class="tbl-div-container">
                                                            <table class="tbl-head">
                                                                <colgroup>
                                                                    <col width="200px"/>
                                                                    <col width="120px"/>
                                                                    <col width="250px"/>
                                                                    <col width="320px"/>
                                                                    <col width="150px"/>
                                                                    <col width="120px"/>
                                                                    <col width="60px"/>
                                                                    <col width="12px"/>
                                                                </colgroup>
                                                                <tbody class="tbl-head-style ">
                                                                <tr class="tbl-head-style-cell">
                                                                    <th class="tbl-head-style-cell">شماره طرح</th>
                                                                    <th class="tbl-head-style-cell">کد پروژه</th>
                                                                    <th class="tbl-head-style-cell">عنوان پروژه</th>
                                                                    <th class="tbl-head-style-cell">شرح</th>
                                                                    <th class="tbl-head-style-cell">مبلغ رزرو شده</th>
                                                                    <th class="tbl-head-style-cell">وضعیت</th>
                                                                    <th class="tbl-head-style-cell">عملیات</th>
                                                                    <th class="tbl-head-style-cell"></th>
                                                                </tr>
                                                                </tbody>
                                                            </table>
                                                            <!--Table Head End-->
                                                            <!--Table Body Start-->
                                                            <div class="tbl_body_style dynamic-height-level-modal2">
                                                                <table class="tbl-body-contain">
                                                                    <colgroup>
                                                                        <col width="200px"/>
                                                                        <col width="120px"/>
                                                                        <col width="250px"/>
                                                                        <col width="320px"/>
                                                                        <col width="150px"/>
                                                                        <col width="120px"/>
                                                                        <col width="60px"/>
                                                                    </colgroup>
                                                                    <tbody class="tbl-head-style-cell">
                                                                    <tr v-for="capFinancing in requestCapFinancing">
                                                                        <td v-if="capFinancing.allocation.credit_source != null">{{capFinancing.allocation.credit_source.capital_assets_project.capital_assets_approved_plan.credit_distribution_title.cdtSubject}}</td>
                                                                        <td v-if="capFinancing.allocation.credit_source != null">{{capFinancing.allocation.credit_source.capital_assets_project.cpCode}}</td>
                                                                        <td v-if="capFinancing.allocation.credit_source != null">{{capFinancing.allocation.credit_source.capital_assets_project.cpSubject}}</td>
                                                                        <td v-if="capFinancing.allocation.credit_source != null">{{capFinancing.allocation.credit_source.capital_assets_project.cpDescription}}</td>
                                                                        <template v-if="capFinancing.allocation.credit_source == null">
                                                                            <td colspan="4" class="text-center"><span class="user-verifier-label">تنخواه</span></td>
                                                                        </template>
                                                                        <td class="text-center">{{$parent.dispMoneyFormat(capFinancing.cafAmount)}}</td>
                                                                        <td v-show="capFinancing.cafAccepted == 1"><span class="success-label">تایید شده</span></td>
                                                                        <td v-show="capFinancing.cafAccepted == 0"><span class="reserved-label">رزرو شده</span></td>
                                                                        <td class="text-center"><i class="far fa-trash-alt size-21 btn-red"></i></td>
                                                                    </tr>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                        <!--Table Body End-->
                                                    </div>
                                                    <div class="grid-x">
                                                        <div style="background-color:#F1F1F1;padding: 10px;margin-top: -12px;border: solid 1.5px #D8DEE2;" class="large-12 medium-12 small-12">
                                                            <div class="grid-x">
                                                                <div class="large-4 medium-4 small-12">
                                                                    <p class="p-margin-btm"> مبلغ برآورد : <span class="btn-red"> {{$parent.dispMoneyFormat(baseAmount)}} </span></p>
                                                                </div>
                                                                <div class="large-4 medium-4 small-12">
                                                                    <p class="p-margin-btm"> مبلغ رزرو شده : <span class="btn-red"> {{$parent.dispMoneyFormat(_reservedAmount)}} </span></p>
                                                                </div>
                                                                <div class="large-4 medium-4 small-12">
                                                                    <p class="p-margin-btm"> مبلغ تامین اعتبار شده : <span class="btn-red"> {{$parent.dispMoneyFormat(_financingAmount)}} </span></p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!--Tab 1-->

                                                <!--Tab 2-->
                                                <div class="tabs-panel table-mrg-btm" id="creditCostTab" xmlns:v-on="http://www.w3.org/1999/xhtml">
                                                    <div class="grid-x">
                                                        <!--Table Start-->
                                                        <!--Table Head Start-->
                                                        <div class="tbl-div-container">
                                                            <table class="tbl-head">
                                                                <colgroup>
                                                                    <col width="200px"/>
                                                                    <col width="200px"/>
                                                                    <col width="350px"/>
                                                                    <col width="150px"/>
                                                                    <col width="100px"/>
                                                                    <col width="60px"/>
                                                                    <col width="12px"/>
                                                                </colgroup>
                                                                <tbody class="tbl-head-style ">
                                                                <tr class="tbl-head-style-cell">
                                                                    <th class="tbl-head-style-cell">شماره برنامه</th>
                                                                    <th class="tbl-head-style-cell">شماره نامه</th>
                                                                    <th class="tbl-head-style-cell">شرح</th>
                                                                    <th class="tbl-head-style-cell">مبلغ رزرو شده</th>
                                                                    <th class="tbl-head-style-cell">وضعیت</th>
                                                                    <th class="tbl-head-style-cell">عملیات</th>
                                                                    <th class="tbl-head-style-cell"></th>
                                                                </tr>
                                                                </tbody>
                                                            </table>
                                                            <!--Table Head End-->
                                                            <!--Table Body Start-->
                                                            <div class="tbl_body_style dynamic-height-level-modal2">
                                                                <table class="tbl-body-contain">
                                                                    <colgroup>
                                                                        <col width="200px"/>
                                                                        <col width="200px"/>
                                                                        <col width="350px"/>
                                                                        <col width="150px"/>
                                                                        <col width="100px"/>
                                                                        <col width="60px"/>
                                                                    </colgroup>
                                                                    <tbody class="tbl-head-style-cell">
                                                                    <tr v-for="costFinancing in requestCostFinancing">
                                                                        <td v-if="costFinancing.allocation.credit_source != null">{{costFinancing.allocation.credit_source.credit_distribution_title.cdtIdNumber}}</td>
                                                                        <td v-if="costFinancing.allocation.credit_source != null">{{costFinancing.allocation.credit_source.cost_agreement.caLetterNumber}}</td>
                                                                        <td v-if="costFinancing.allocation.credit_source != null">{{costFinancing.allocation.credit_source.cost_agreement.caDescription}}</td>
                                                                        <template v-if="costFinancing.allocation.credit_source == null">
                                                                           <td colspan="3" class="text-center"><span class="user-verifier-label">تنخواه</span></td>
                                                                        </template>
                                                                        <td class="text-center">{{$parent.dispMoneyFormat(costFinancing.cfAmount)}}</td>
                                                                        <td v-show="costFinancing.cfAccepted == 1"><span class="success-label">تایید شده</span></td>
                                                                        <td v-show="costFinancing.cfAccepted == 0"><span class="reserved-label">رزرو شده</span></td>
                                                                        <td class="text-center"><i class="far fa-trash-alt size-21 btn-red"></i></td>
                                                                    </tr>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                        <!--Table Body End-->
                                                    </div>
                                                    <div class="grid-x">
                                                        <div style="background-color:#F1F1F1;padding: 10px;margin-top: -12px;border: solid 1.5px #D8DEE2;" class="large-12 medium-12 small-12">
                                                            <div class="grid-x">
                                                                <div class="large-4 medium-4 small-12">
                                                                    <p class="p-margin-btm"> مبلغ برآورد : <span class="btn-red"> {{$parent.dispMoneyFormat(baseAmount)}} </span></p>
                                                                </div>
                                                                <div class="large-4 medium-4 small-12">
                                                                    <p class="p-margin-btm"> مبلغ رزرو شده : <span class="btn-red"> {{$parent.dispMoneyFormat(_reservedAmount)}} </span></p>
                                                                </div>
                                                                <div class="large-4 medium-4 small-12">
                                                                    <p class="p-margin-btm"> مبلغ تامین اعتبار شده : <span class="btn-red"> {{$parent.dispMoneyFormat(_financingAmount)}} </span></p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!--Tab 2-->
                                            </div>
                                        </div>
                                        <div style="padding: 0 17px 0 17px;" class="large-12 medium-12 small-12 small-top-m">
                                            <div style="margin-bottom:-10px;margin-top: 5px" class="stacked-for-small button-group float-left">
                                                <button v-show='$can("FINANCIAL_FINAL_REGISTRATION_FINANCING")' @click="openCapitalAssetsModal()" class="my-button my-success float-left"><span class="btn-txt-mrg">ثبت نهایی</span></button>
                                                <button v-show='$can("FINANCIAL_CAPITAL_ASSETS_FINANCING")' @click="openCapitalAssetsModal()" class="my-button toolbox-btn float-left"><span class="btn-txt-mrg">  اعتبارات تملک دارایی های سرمایه ای</span></button>
                                                <button v-show='$can("FINANCIAL_COST_FINANCING")' @click="openCostCreditsModal()" class="my-button toolbox-btn float-left"><span class="btn-txt-mrg">  اعتبارات هزینه ای</span></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--Tab 3-->
                                <!--Tab 4-->
                                <div class="tabs-panel table-mrg-btm" id="requestHistoryTab" xmlns:v-on="http://www.w3.org/1999/xhtml">
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
                                                                    <p style="margin-bottom: 0" class="small-top-m">گیرنده:</p>
                                                                    <div class="grid-x">
                                                                        <div class="large-1 medium-2 small-12">
                                                                            <img style="width: 40px;height: 40px;margin-top: 10px;margin-bottom: 10px;" class="profile-image-cover-index profile-image-cover-pos" :src="recipientUser.destination_user_info.avatarPath != null ? baseURL + recipientUser.destination_user_info.avatarPath : $parent.baseAvatar">
                                                                        </div>
                                                                        <div class="large-11 medium-10 small-12 padding-lr">
                                                                            <p class="small-top-m">
                                                                                {{recipientUser.destination_user_info.name}} - {{recipientUser.destination_user_info.role.rSubject}}
                                                                            </p>
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
                                <!--Tab 4-->
                            </div>
                        </div>
                        <div class="large-12 medium-12 small-12 padding-lr medium-top-m">
                            <div style="margin-bottom:-10px;" class="stacked-for-small button-group">
                                <button @click="openSubmitRequestModal()" v-if=" youAreVerifier != '' "  class="my-button my-success float-left btn-for-load"><span class="btn-txt-mrg">  تایید</span></button>
                                <button @click="openReferralsModal()"  class="my-button toolbox-btn float-left btn-for-load"><span class="btn-txt-mrg">  ارجاع</span></button>
                                <button @click="openResponseRequestModal()" v-show="canResponse == 1 " class="my-button toolbox-btn float-left btn-for-load"><span class="btn-txt-mrg">  پاسخ</span></button>
                                <button v-show='$can("SECRETARIAT_REGISTER_AND_NUMBERING")' style="width:130px;" @click="openRegisterAndNumberingModal()" class="my-button my-success float-left btn-for-load"><span class="btn-txt-mrg">  ثبت دبیرخانه</span></button>
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
                            <div class="large-12 medium-12 small-12 padding-lr text-center">
                                <p class="modal-text">آیا برای تایید درخواست اطمینان دارید؟ </p>
                            </div>
                            <div class="large-12 medium-12 small-12 padding-lr text-center">
                                <p class="modal-text">تایید شما به منزله امضا درخواست می باشد.</p>
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
                                        <img style="width: 60px;height: 60px;margin-top: 10px;margin-bottom: 10px;" class="profile-image-cover-index profile-image-cover-pos" :src="recipientUser.destination_user_info.avatarPath != null ? baseURL + recipientUser.destination_user_info.avatarPath : $parent.baseAvatar">
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

        <!-- Cost Credits Modal Start -->
        <modal-full-screen v-if="showCostCreditsModal" @close="showCostCreditsModal = false">
            <div  slot="body">
                <div class="small-font">
                    <div class="grid-x">
                        <div class="large-12 medium-12 small-12">
                            <ul class="tabs tab-color my-tab-style" data-responsive-accordion-tabs="tabs medium-accordion large-tabs" id="cost_credit_tab_view">
                                <li class="tabs-title is-active"><a href="#programTab" aria-selected="true">برنامه</a></li>
                                <li class="tabs-title"><a href="#creditDistributionResourcesTab">منابع تامین اعتبار </a></li>
                                <li class="tabs-title"><a href="#allocationTab">تخصیص </a></li>
                                <li class="tabs-title"><a href="#fundTab">تنخواه </a></li>
                            </ul>
                            <div class="tabs-content" data-tabs-content="cost_credit_tab_view">
                                <div class="grid-x">
                                    <div style="margin-top: 10px;" class="large-12 medium-12 small-12 direction-ltr">
                                        <span class="cost-label">مبالغ : ریال</span>
                                    </div>
                                </div>
                                <!--Tab 1-->
                                <div class="tabs-panel is-active table-mrg-btm" id="programTab">
                                    <div class="grid-x">
                                        <!--Table Start-->
                                        <!--Table Head Start-->
                                        <div class="tbl-div-container">
                                            <table class="tbl-head">
                                                <colgroup>
                                                    <col width="150px"/>
                                                    <col width="150px"/>
                                                    <col width="150px"/>
                                                    <col width="150px"/>
                                                    <col width="150px"/>
                                                    <col width="150px"/>
                                                    <col width="250px"/>
                                                    <col width="150px"/>
                                                    <col width="40px"/>
                                                    <col width="12px"/>
                                                </colgroup>
                                                <tbody class="tbl-head-style ">
                                                <tr class="tbl-head-style-cell">
                                                    <th class="tbl-head-style-cell">شماره نامه</th>
                                                    <th class="tbl-head-style-cell">شماره طرح</th>
                                                    <th class="tbl-head-style-cell">رزرو شده</th>
                                                    <th class="tbl-head-style-cell">تامین اعتبار شده</th>
                                                    <th class="tbl-head-style-cell">تعهد</th>
                                                    <th class="tbl-head-style-cell">هزینه شده</th>
                                                    <th class="tbl-head-style-cell">شرح</th>
                                                    <th class="tbl-head-style-cell">اعتبار پیشنهادی</th>
                                                    <th class="tbl-head-style-cell"></th>
                                                </tr>
                                                </tbody>
                                            </table>
                                            <!--Table Head End-->
                                            <!--Table Body Start-->
                                            <div class="tbl_body_style dynamic-height-level-modal1">
                                                <table class="tbl-body-contain">
                                                    <colgroup>
                                                        <col width="150px"/>
                                                        <col width="150px"/>
                                                        <col width="150px"/>
                                                        <col width="150px"/>
                                                        <col width="150px"/>
                                                        <col width="150px"/>
                                                        <col width="250px"/>
                                                        <col width="150px"/>
                                                        <col width="40px"/>
                                                    </colgroup>
                                                    <tbody class="tbl-head-style-cell">
                                                    <tr v-for="plan in completeCostAgrement">
                                                        <td>{{plan.caLetterNumber}}</td>
                                                        <td>{{plan.caLetterDate}}</td>
                                                        <td>{{$parent.dispMoneyFormat(plan.caSumOfReserved)}}</td>
                                                        <td>{{$parent.dispMoneyFormat(plan.caSumOfFinancing)}}</td>
                                                        <td>{{$parent.dispMoneyFormat(plan.caSumOfCommitment)}}</td>
                                                        <td>{{$parent.dispMoneyFormat(plan.caSumOfCost)}}</td>
                                                        <td>{{plan.caDescription}}</td>
                                                        <td>
                                                            <input :disabled="plan.isHistory" class="direction-ltr" v-on:keyup="calculationOfCostCredit(plan, plan, 0, plan.amount)" style="margin-bottom:0px;" v-if="plan.selected == true" type="text"  v-model="plan.amount" :name="plan.id" :value="plan.amount"  v-validate="'numeric','min_value:0','max_value:'+ (getRemainingCostAmount(plan , 1) + parseInt(plan.amount , 10))" :class="{'input': true, 'error-border': errors.has(plan.id)}" />
                                                            <span v-show="errors.has(plan.id)" class="error-font"></span>
                                                        </td>
                                                        <td><input :disabled="plan.isHistory" v-on:change="setTextBoxValueCost(plan,plan,0)" v-model="plan.selected" type="checkbox"></td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <!--Table Body End-->
                                    </div>
                                </div>
                                <!--Tab 1-->
                                <!--Tab 2-->
                                <div class="tabs-panel table-mrg-btm" id="creditDistributionResourcesTab" xmlns:v-on="http://www.w3.org/1999/xhtml">
                                    <div class="grid-x">
                                        <!--Table Start-->
                                        <!--Table Head Start-->
                                        <div class="tbl-div-container">
                                            <table class="tbl-head">
                                                <colgroup>
                                                    <col width="150px"/>
                                                    <col width="150px"/>
                                                    <col width="150px"/>
                                                    <col width="150px"/>
                                                    <col width="100"/>
                                                    <col width="250px"/>
                                                    <col width="150px"/>
                                                    <col width="40px"/>
                                                    <col width="12px"/>
                                                </colgroup>
                                                <tbody class="tbl-head-style ">
                                                <tr class="tbl-head-style-cell">
                                                    <th class="tbl-head-style-cell">رزرو شده</th>
                                                    <th class="tbl-head-style-cell">تامین اعتبار</th>
                                                    <th class="tbl-head-style-cell">تعهد</th>
                                                    <th class="tbl-head-style-cell">هزینه شده</th>
                                                    <th class="tbl-head-style-cell">مبلغ</th>
                                                    <th class="tbl-head-style-cell">شرح</th>
                                                    <th class="tbl-head-style-cell">اعتبار پیشنهادی</th>
                                                    <th class="tbl-head-style-cell"></th>
                                                </tr>
                                                </tbody>
                                            </table>
                                            <!--Table Head End-->
                                            <!--Table Body Start-->
                                            <div class="tbl_body_style dynamic-height-level-modal1">
                                                <table class="tbl-body-contain">
                                                    <colgroup>
                                                        <col width="150px"/>
                                                        <col width="150px"/>
                                                        <col width="150px"/>
                                                        <col width="150px"/>
                                                        <col width="100"/>
                                                        <col width="250px"/>
                                                        <col width="150px"/>
                                                        <col width="40px"/>
                                                    </colgroup>
                                                    <tbody class="tbl-head-style-cell">
                                                    <template v-for="plan in completeCostAgrement">
                                                        <tr v-for="creditSource in plan.ca_credit_source_has_allocation">
                                                            <td>{{ $parent.dispMoneyFormat(creditSource.ccsSumOfReserved) }}</td>
                                                            <td>{{ $parent.dispMoneyFormat(creditSource.ccsSumOfFinancing) }}</td>
                                                            <td>{{ $parent.dispMoneyFormat(creditSource.ccsSumOfCommitment) }}</td>
                                                            <td>{{ $parent.dispMoneyFormat(creditSource.ccsSumOfCost) }}</td>
                                                            <td>{{ $parent.dispMoneyFormat(creditSource.ccsAmount) }}</td>
                                                            <td>{{ creditSource.caDescription}}</td>
                                                            <td>
                                                                <input :disabled="creditSource.isHistory" class="direction-ltr" v-on:keyup="calculationOfCostCredit(plan, creditSource, 1, creditSource.amount)" style="margin-bottom:0px;" v-if="creditSource.selected == true" type="text" v-model="creditSource.amount"  :value="creditSource.amount" :name="creditSource.id" v-validate="'numeric','min_value:0','max_value:'+ (getRemainingCostAmount(creditSource , 2) + parseInt(creditSource.amount , 10))" :class="{'input': true, 'error-border': errors.has(creditSource.id)}" />
                                                                <span v-show="errors.has(creditSource.id)" class="error-font"></span>
                                                            </td>
                                                            <td><input :disabled="creditSource.isHistory" v-on:change="setTextBoxValueCost(plan,creditSource,1)" v-model="creditSource.selected" type="checkbox"></td>
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
                                <!--Tab 3-->
                                <div class="tabs-panel table-mrg-btm" id="allocationTab" xmlns:v-on="http://www.w3.org/1999/xhtml">
                                    <div class="grid-x">
                                        <!--Table Start-->
                                        <!--Table Head Start-->
                                        <div class="tbl-div-container">
                                            <table class="tbl-head">
                                                <colgroup>
                                                    <col width="150px"/>
                                                    <col width="150px"/>
                                                    <col width="150px"/>
                                                    <col width="150px"/>
                                                    <col width="150px"/>
                                                    <col width="150px"/>
                                                    <col width="250px"/>
                                                    <col width="150px"/>
                                                    <col width="40px"/>
                                                    <col width="12px"/>
                                                </colgroup>
                                                <tbody class="tbl-head-style ">
                                                <tr class="tbl-head-style-cell">
                                                    <th class="tbl-head-style-cell">شماره نامه</th>
                                                    <th class="tbl-head-style-cell">تاریخ نامه</th>
                                                    <th class="tbl-head-style-cell">رزرو شده</th>
                                                    <th class="tbl-head-style-cell">تامین اعتبار</th>
                                                    <th class="tbl-head-style-cell">تعهد</th>
                                                    <th class="tbl-head-style-cell">هزینه شده</th>
                                                    <th class="tbl-head-style-cell">شرح</th>
                                                    <th class="tbl-head-style-cell">اعتبار پیشنهادی</th>
                                                    <th class="tbl-head-style-cell"></th>
                                                </tr>
                                                </tbody>
                                            </table>
                                            <!--Table Head End-->
                                            <!--Table Body Start-->
                                            <div class="tbl_body_style dynamic-height-level-modal1">
                                                <table class="tbl-body-contain">
                                                    <colgroup>
                                                        <col width="150px"/>
                                                        <col width="150px"/>
                                                        <col width="150px"/>
                                                        <col width="150px"/>
                                                        <col width="150px"/>
                                                        <col width="150px"/>
                                                        <col width="250px"/>
                                                        <col width="150px"/>
                                                        <col width="40px"/>
                                                    </colgroup>
                                                    <tbody class="tbl-head-style-cell">
                                                    <template v-for="plan in completeCostAgrement">
                                                        <template v-for="crditSourse in plan.ca_credit_source_has_allocation">
                                                            <tr v-if="allocation.caFound == 0" v-for="allocation in crditSourse.allocation">
                                                                <td>{{allocation.caLetterNumber}}</td>
                                                                <td>{{allocation.caLetterDate}}</td>
                                                                <td>{{$parent.dispMoneyFormat(allocation.caSumOfReserved)}}</td>
                                                                <td>{{$parent.dispMoneyFormat(allocation.caSumOfFinancing)}}</td>
                                                                <td>{{$parent.dispMoneyFormat(allocation.caSumOfCommitment)}}</td>
                                                                <td>{{$parent.dispMoneyFormat(allocation.caSumOfCost)}}</td>
                                                                <td>{{allocation.caDescription}}</td>
                                                                <td>
                                                                    <input :disabled="allocation.isHistory" class="direction-ltr" v-on:keyup="calculationOfCostCredit(plan,allocation,2,allocation.amount)" style="margin-bottom:0px;" v-if="allocation.selected == true" type="text" v-model="allocation.amount" :value="allocation.amount" :name="allocation.id" v-validate="'numeric','min_value:0','max_value:'+ (getRemainingCostAmount(allocation , 3)  + parseInt(allocation.amount , 10))" :class="{'input': true, 'error-border': errors.has(allocation.id)}"/>
                                                                    <span v-show="errors.has(allocation.id)" class="error-font"></span>
                                                                </td>
                                                                <td><input :disabled="allocation.isHistory" v-on:change="setTextBoxValueCost(plan,allocation,2)" v-model="allocation.selected" type="checkbox"></td>
                                                            </tr>
                                                        </template>
                                                    </template>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <!--Table Body End-->
                                    </div>
                                </div>
                                <!--Tab 3-->

                                <!--Tab 4-->
                                <div class="tabs-panel table-mrg-btm" id="fundTab" xmlns:v-on="http://www.w3.org/1999/xhtml">
                                    <div class="grid-x">
                                        <!--Table Start-->
                                        <!--Table Head Start-->
                                        <div class="tbl-div-container">
                                            <table class="tbl-head">
                                                <colgroup>
                                                    <col width="150px"/>
                                                    <col width="150px"/>
                                                    <col width="150px"/>
                                                    <col width="150px"/>
                                                    <col width="150px"/>
                                                    <col width="150px"/>
                                                    <col width="250px"/>
                                                    <col width="150px"/>
                                                    <col width="40px"/>
                                                    <col width="12px"/>
                                                </colgroup>
                                                <tbody class="tbl-head-style ">
                                                <tr class="tbl-head-style-cell">
                                                    <th class="tbl-head-style-cell">شماره نامه</th>
                                                    <th class="tbl-head-style-cell">تاریخ نامه</th>
                                                    <th class="tbl-head-style-cell">رزرو شده</th>
                                                    <th class="tbl-head-style-cell">تامین اعتبار</th>
                                                    <th class="tbl-head-style-cell">تعهد</th>
                                                    <th class="tbl-head-style-cell">هزینه شده</th>
                                                    <th class="tbl-head-style-cell">اعتبار پیشنهادی</th>
                                                    <th class="tbl-head-style-cell">شرح</th>
                                                    <th class="tbl-head-style-cell"></th>
                                                </tr>
                                                </tbody>
                                            </table>
                                            <!--Table Head End-->
                                            <!--Table Body Start-->
                                            <div class="tbl_body_style dynamic-height-level-modal1">
                                                <table class="tbl-body-contain">
                                                    <colgroup>
                                                        <col width="150px"/>
                                                        <col width="150px"/>
                                                        <col width="150px"/>
                                                        <col width="150px"/>
                                                        <col width="150px"/>
                                                        <col width="150px"/>
                                                        <col width="250px"/>
                                                        <col width="150px"/>
                                                        <col width="40px"/>
                                                    </colgroup>
                                                    <tbody class="tbl-head-style-cell">
                                                        <tr  v-for="found in costFound">
                                                            <td>{{found.caLetterNumber}}</td>
                                                            <td>{{found.caLetterDate}}</td>
                                                            <td>{{$parent.dispMoneyFormat(found.caSumOfReserved)}}</td>
                                                            <td>{{$parent.dispMoneyFormat(found.caSumOfFinancing)}}</td>
                                                            <td>{{$parent.dispMoneyFormat(found.caSumOfCommitment)}}</td>
                                                            <td>{{$parent.dispMoneyFormat(found.caSumOfCost)}}</td>
                                                            <td>{{found.caDescription}}</td>
                                                            <td>
                                                                <input :disabled="found.isHistory" class="direction-ltr" v-on:keyup="calculationOfCostCredit(null,found,3,found.amount)" style="margin-bottom:0px;" v-if="found.selected == true" type="text" v-model="found.amount" :value="found.amount" :name="found.id" v-validate="'numeric','min_value:0','max_value:'+ (getRemainingCostAmount(found , 3) + parseInt(found.amount , 10))" :class="{'input': true, 'error-border': errors.has(found.id)}" />
                                                                <span v-show="errors.has(found.id)" class="error-font"></span>
                                                            </td>
                                                            <td><input  :disabled="found.isHistory" v-on:change="setTextBoxValueCost(null,found,3)" v-model="found.selected" type="checkbox"></td>

                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <!--Table Body End-->
                                    </div>
                                </div>
                                <!--Tab 4-->

                            </div>
                        </div>
                        <div class="large-12 medium-12 small-12 padding-lr small-top-m">
                            <div class="grid-x">
                                <div class="large-6 medium-6 small-12">
                                    <div class="grid-x">
                                        <div class="large-12 medium-12 small-12">
                                            <p> مبلغ برآورد : <span class="btn-red"> {{$parent.dispMoneyFormat(baseAmount)}} </span></p>
                                        </div>
                                        <div class="large-12 medium-12 small-12">
                                            <p> مبلغ تامین اعتبار : <span class="btn-red"> {{$parent.dispMoneyFormat(costReservedAmount)}} </span></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="large-6 medium-6 small-12">
                                    <div class="grid-x">
                                        <div class="large-12 medium-12 small-12">
                                            <div class="stacked-for-small button-group float-left">
                                                <button @click="reserveCostFinance()" class="my-button my-success float-left"><span class="btn-txt-mrg">  ثبت </span></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </modal-full-screen>
        <!-- Cost Credits Modal End -->

        <!-- Capital Assets Modal Start -->
        <modal-full-screen v-if="showCapitalAssetsModal" @close="showCapitalAssetsModal = false">
            <div  slot="body">
                <div class="small-font">
                    <div class="grid-x">
                        <div class="large-12 medium-12 small-12">
                            <ul class="tabs tab-color my-tab-style" data-responsive-accordion-tabs="tabs medium-accordion large-tabs" id="capital_assets_tab_view">
                                <li class="tabs-title is-active"><a href="#caPlaneTab" aria-selected="true">طرح</a></li>
                                <li class="tabs-title"><a href="#caProjectTab">پروژه </a></li>
                                <li class="tabs-title"><a href="#caCreditDistributionResourcesTab">منابع تامین اعتبار </a></li>
                                <li class="tabs-title"><a href="#caAllocationTab">تخصیص </a></li>
                                <li class="tabs-title"><a href="#caFundTab">تنخواه </a></li>
                            </ul>
                            <div class="tabs-content" data-tabs-content="capital_assets_tab_view">
                                <div class="grid-x">
                                    <div style="margin-top: 10px;" class="large-12 medium-12 small-12 direction-ltr">
                                        <span class="cost-label">مبالغ : ریال</span>
                                    </div>
                                </div>
                                <!--Tab 1-->
                                <div class="tabs-panel is-active table-mrg-btm" id="caPlaneTab">
                                    <div class="grid-x">
                                        <!--Table Start-->
                                        <!--Table Head Start-->
                                        <div class="tbl-div-container">
                                            <table class="tbl-head">
                                                <colgroup>
                                                    <col width="150px"/>
                                                    <col width="150px"/>
                                                    <col width="150px"/>
                                                    <col width="150px"/>
                                                    <col width="150px"/>
                                                    <col width="150px"/>
                                                    <col width="250px"/>
                                                    <col width="150px"/>
                                                    <col width="40px"/>
                                                    <col width="12px"/>
                                                </colgroup>
                                                <tbody class="tbl-head-style ">
                                                <tr class="tbl-head-style-cell">
                                                    <th class="tbl-head-style-cell">شماره نامه</th>
                                                    <th class="tbl-head-style-cell">تاریخ نامه</th>
                                                    <th class="tbl-head-style-cell">رزرو شده</th>
                                                    <th class="tbl-head-style-cell">تامین اعتبار شده</th>
                                                    <th class="tbl-head-style-cell">تعهد</th>
                                                    <th class="tbl-head-style-cell">هزینه شده</th>
                                                    <th class="tbl-head-style-cell">شرح</th>
                                                    <th class="tbl-head-style-cell">اعتبار پیشنهادی</th>
                                                    <th class="tbl-head-style-cell"></th>
                                                </tr>
                                                </tbody>
                                            </table>
                                            <!--Table Head End-->
                                            <!--Table Body Start-->
                                            <div class="tbl_body_style dynamic-height-level-modal1">
                                                <table class="tbl-body-contain">
                                                    <colgroup>
                                                        <col width="150px"/>
                                                        <col width="150px"/>
                                                        <col width="150px"/>
                                                        <col width="150px"/>
                                                        <col width="150px"/>
                                                        <col width="150px"/>
                                                        <col width="250px"/>
                                                        <col width="150px"/>
                                                        <col width="40px"/>
                                                    </colgroup>
                                                    <tbody class="tbl-head-style-cell">
                                                    <tr v-for="plan in completeCapitalAssetsAgrement">
                                                        <td>{{plan.credit_distribution_title.cdtIdNumber}}</td>
                                                        <td>{{plan.capLetterNumber}}</td>
                                                        <td>{{plan.capSumOfReserved}}</td>
                                                        <td>{{plan.capSumOfFinancing}}</td>
                                                        <td>{{plan.capSumOfCommitment}}</td>
                                                        <td>{{plan.capSumOfCost}}</td>
                                                        <td>{{plan.capDescription}}</td>
                                                        <td>
                                                            <input :disabled="plan.isHistory" class="direction-ltr" v-on:keyup="calculationOfCapCredit(plan, plan, 0, plan.amount)" style="margin-bottom:0px;" v-if="plan.selected == true" type="text"  v-model="plan.amount" :value="plan.amount" :name="'plan'+plan.id" v-validate="'numeric','min_value:0','max_value:'+ (getRemainingCapitalAssetsAmount(plan , 1) + parseInt(plan.amount , 10))" :class="{'input': true, 'error-border': errors.has('plan' + plan.id)}"/>
                                                            <span v-show="errors.has('plan'+plan.id)" class="error-font"></span>
                                                        </td>
                                                        <td><input :disabled="plan.isHistory" v-on:change="setTextBoxValueCap(plan,plan,0)" v-model="plan.selected" type="checkbox"></td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <!--Table Body End-->
                                    </div>
                                </div>
                                <!--Tab 1-->

                                <!--Tab 2-->
                                <div class="tabs-panel table-mrg-btm" id="caProjectTab" xmlns:v-on="http://www.w3.org/1999/xhtml">
                                    <div class="grid-x">
                                        <!--Table Start-->
                                        <!--Table Head Start-->
                                        <div class="tbl-div-container">
                                            <table class="tbl-head">
                                                <colgroup>
                                                    <col width="250px"/>
                                                    <col width="100px"/>
                                                    <col width="150px"/>
                                                    <col width="150px"/>
                                                    <col width="150px"/>
                                                    <col width="150px"/>
                                                    <col width="250px"/>
                                                    <col width="150px"/>
                                                    <col width="40px"/>
                                                    <col width="12px"/>
                                                </colgroup>
                                                <tbody class="tbl-head-style ">
                                                <tr class="tbl-head-style-cell">
                                                    <th class="tbl-head-style-cell">عنوان</th>
                                                    <th class="tbl-head-style-cell">کد پروژه</th>
                                                    <th class="tbl-head-style-cell">رزرو شده</th>
                                                    <th class="tbl-head-style-cell">تامین اعتبار</th>
                                                    <th class="tbl-head-style-cell">تعهد</th>
                                                    <th class="tbl-head-style-cell">هزینه شده</th>
                                                    <th class="tbl-head-style-cell">شرح</th>
                                                    <th class="tbl-head-style-cell">اعتبار پیشنهادی</th>
                                                    <th class="tbl-head-style-cell"></th>
                                                </tr>
                                                </tbody>
                                            </table>
                                            <!--Table Head End-->
                                            <!--Table Body Start-->
                                            <div class="tbl_body_style dynamic-height-level-modal1">
                                                <table class="tbl-body-contain">
                                                    <colgroup>
                                                        <col width="250px"/>
                                                        <col width="100px"/>
                                                        <col width="150px"/>
                                                        <col width="150px"/>
                                                        <col width="150px"/>
                                                        <col width="150px"/>
                                                        <col width="250px"/>
                                                        <col width="150px"/>
                                                        <col width="40px"/>
                                                    </colgroup>
                                                    <tbody class="tbl-head-style-cell">
                                                    <template v-for="plan in completeCapitalAssetsAgrement">
                                                        <tr v-for="project in plan.capital_assets_project_has_credit_source">
                                                            <td>{{project.cpSubject}}</td>
                                                            <td>{{project.cpCode}}</td>
                                                            <td>{{project.cpSumOfReserved}}</td>
                                                            <td>{{project.cpSumOfFinancing}}</td>
                                                            <td>{{project.cpSumOfCommitment}}</td>
                                                            <td>{{project.cpSumOfCost}}</td>
                                                            <td>{{project.cpDescription}}</td>
                                                            <td>
                                                                <input :disabled="project.isHistory" class="direction-ltr" v-on:keyup="calculationOfCapCredit(plan, project, 1, project.amount)" style="margin-bottom:0px;" v-if="project.selected == true" type="text" v-model="project.amount"  :value="project.amount" :name="'project'+project.id" v-validate="'numeric','min_value:0','max_value:'+ (getRemainingCapitalAssetsAmount(project , 2) + parseInt(project.amount , 10))" :class="{'input': true, 'error-border': errors.has('project'+project.id)}"/>
                                                                <span v-show="errors.has('project'+project.id)" class="error-font"></span>
                                                            </td>
                                                            <td><input :disabled="project.isHistory" v-on:change="setTextBoxValueCap(plan,project,1)" v-model="project.selected" type="checkbox"></td>
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

                                <!--Tab 3-->
                                <div class="tabs-panel table-mrg-btm" id="caCreditDistributionResourcesTab" xmlns:v-on="http://www.w3.org/1999/xhtml">
                                    <div class="grid-x">
                                        <!--Table Start-->
                                        <!--Table Head Start-->
                                        <div class="tbl-div-container">
                                            <table class="tbl-head">
                                                <colgroup>
                                                    <col width="150px"/>
                                                    <col width="150px"/>
                                                    <col width="150px"/>
                                                    <col width="150px"/>
                                                    <col width="150px"/>
                                                    <col width="250px"/>
                                                    <col width="150px"/>
                                                    <col width="40px"/>
                                                    <col width="12px"/>
                                                </colgroup>
                                                <tbody class="tbl-head-style ">
                                                <tr class="tbl-head-style-cell">
                                                    <th class="tbl-head-style-cell">رزرو شده</th>
                                                    <th class="tbl-head-style-cell">تامین اعتبار</th>
                                                    <th class="tbl-head-style-cell">تعهد</th>
                                                    <th class="tbl-head-style-cell">هزینه شده</th>
                                                    <th class="tbl-head-style-cell">مبلغ</th>
                                                    <th class="tbl-head-style-cell">شرح</th>
                                                    <th class="tbl-head-style-cell">اعتبار پیشنهادی</th>
                                                    <th class="tbl-head-style-cell"></th>
                                                </tr>
                                                </tbody>
                                            </table>
                                            <!--Table Head End-->
                                            <!--Table Body Start-->
                                            <div class="tbl_body_style dynamic-height-level-modal1">
                                                <table class="tbl-body-contain">
                                                    <colgroup>
                                                        <col width="150px"/>
                                                        <col width="150px"/>
                                                        <col width="150px"/>
                                                        <col width="150px"/>
                                                        <col width="150px"/>
                                                        <col width="250px"/>
                                                        <col width="150px"/>
                                                        <col width="40px"/>
                                                    </colgroup>
                                                    <tbody class="tbl-head-style-cell">
                                                    <template v-for="plan in completeCapitalAssetsAgrement">
                                                        <template v-for="project in plan.capital_assets_project_has_credit_source">
                                                            <tr v-for="creditSource in project.credit_source_has_allocation">
                                                                <td>{{creditSource.ccsSumOfReserved}}</td>
                                                                <td>{{creditSource.ccsSumOfFinancing}}</td>
                                                                <td>{{creditSource.ccsSumOfCommitment}}</td>
                                                                <td>{{creditSource.ccsSumOfCost}}</td>
                                                                <td>{{creditSource.ccsAmount}}</td>
                                                                <td>{{creditSource.ccsDescription}}</td>
                                                                <td>
                                                                    <input :disabled="creditSource.isHistory" class="direction-ltr" v-on:keyup="calculationOfCapCredit(plan, creditSource, 2, creditSource.amount)" style="margin-bottom:0px;" v-if="creditSource.selected == true" type="text" v-model="creditSource.amount"  :value="creditSource.amount" :name="'creditSource'+creditSource.id" v-validate="'numeric','min_value:0','max_value:'+ (getRemainingCapitalAssetsAmount(creditSource , 3) + parseInt(creditSource.amount , 10))" :class="{'input': true, 'error-border': errors.has('creditSource'+creditSource.id)}" />
                                                                    <span v-show="errors.has('creditSource'+creditSource.id)" class="error-font"></span>
                                                                </td>
                                                                <td><input :disabled="creditSource.isHistory" v-on:change="setTextBoxValueCap(plan,creditSource,2)" v-model="creditSource.selected" type="checkbox"></td>
                                                            </tr>
                                                        </template>
                                                    </template>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <!--Table Body End-->
                                    </div>
                                </div>
                                <!--Tab 3-->


                                <!--Tab 4-->
                                <div class="tabs-panel table-mrg-btm" id="caAllocationTab" xmlns:v-on="http://www.w3.org/1999/xhtml">
                                    <div class="grid-x">
                                        <!--Table Start-->
                                        <!--Table Head Start-->
                                        <div class="tbl-div-container">
                                            <table class="tbl-head">
                                                <colgroup>
                                                    <col width="150px"/>
                                                    <col width="150px"/>
                                                    <col width="150px"/>
                                                    <col width="150px"/>
                                                    <col width="150px"/>
                                                    <col width="150px"/>
                                                    <col width="250px"/>
                                                    <col width="150px"/>
                                                    <col width="40px"/>
                                                    <col width="12px"/>
                                                </colgroup>
                                                <tbody class="tbl-head-style ">
                                                <tr class="tbl-head-style-cell">
                                                    <th class="tbl-head-style-cell">شماره نامه</th>
                                                    <th class="tbl-head-style-cell">رزرو شده</th>
                                                    <th class="tbl-head-style-cell">تامین اعتبار</th>
                                                    <th class="tbl-head-style-cell">تعهد</th>
                                                    <th class="tbl-head-style-cell">هزینه شده</th>
                                                    <th class="tbl-head-style-cell">مبلغ</th>
                                                    <th class="tbl-head-style-cell">شرح</th>
                                                    <th class="tbl-head-style-cell">اعتبار پیشنهادی</th>
                                                    <th class="tbl-head-style-cell"></th>
                                                </tr>
                                                </tbody>
                                            </table>
                                            <!--Table Head End-->
                                            <!--Table Body Start-->
                                            <div class="tbl_body_style dynamic-height-level-modal1">
                                                <table class="tbl-body-contain">
                                                    <colgroup>
                                                        <col width="150px"/>
                                                        <col width="150px"/>
                                                        <col width="150px"/>
                                                        <col width="150px"/>
                                                        <col width="150px"/>
                                                        <col width="150px"/>
                                                        <col width="250px"/>
                                                        <col width="150px"/>
                                                        <col width="40px"/>
                                                    </colgroup>
                                                    <tbody class="tbl-head-style-cell">
                                                    <template v-for="plan in completeCapitalAssetsAgrement">
                                                        <template v-for="creditSource in plan.capital_assets_project_has_credit_source">
                                                            <template v-for="allocations in creditSource.credit_source_has_allocation">
                                                                <tr v-for="alloc in allocations.allocation">
                                                                    <td>{{alloc.caaLetterNumber}}</td>
                                                                    <td>{{alloc.caaSumOfReserved}}</td>
                                                                    <td>{{alloc.caaSumOfFinancing}}</td>
                                                                    <td>{{alloc.caaSumOfCommitment}}</td>
                                                                    <td>{{alloc.caaSumOfCost}}</td>
                                                                    <td>{{alloc.caaAmount}}</td>
                                                                    <td>{{alloc.caaDescription}}</td>
                                                                    <td>
                                                                        <input :disabled="alloc.isHistory" class="direction-ltr" v-on:keyup="calculationOfCapCredit(plan, alloc, 3, alloc.amount)" style="margin-bottom:0px;" v-if="alloc.selected == true" type="text" v-model="alloc.amount"  :value="alloc.amount" :name="'alloc'+alloc.id" v-validate="'numeric','min_value:0','max_value:'+ (getRemainingCapitalAssetsAmount(alloc , 4) + parseInt(alloc.amount , 10))" :class="{'input': true, 'error-border': errors.has('alloc'+alloc.id)}" />
                                                                        <span v-show="errors.has('alloc'+alloc.id)" class="error-font"></span>
                                                                    </td>
                                                                    <td><input :disabled="alloc.isHistory" v-on:change="setTextBoxValueCap(plan,alloc,3)" v-model="alloc.selected" type="checkbox"></td>
                                                                </tr>
                                                            </template>
                                                        </template>
                                                    </template>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <!--Table Body End-->
                                    </div>
                                </div>
                                <!--Tab 4-->

                                <!--Tab 5-->
                                <div class="tabs-panel table-mrg-btm" id="caFundTab" xmlns:v-on="http://www.w3.org/1999/xhtml">
                                    <div class="grid-x">
                                        <!--Table Start-->
                                        <!--Table Head Start-->
                                        <div class="tbl-div-container">
                                            <table class="tbl-head">
                                                <colgroup>
                                                    <col width="150px"/>
                                                    <col width="150px"/>
                                                    <col width="150px"/>
                                                    <col width="150px"/>
                                                    <col width="150px"/>
                                                    <col width="150px"/>
                                                    <col width="250px"/>
                                                    <col width="150px"/>
                                                    <col width="40px"/>
                                                    <col width="12px"/>
                                                </colgroup>
                                                <tbody class="tbl-head-style ">
                                                <tr class="tbl-head-style-cell">
                                                    <th class="tbl-head-style-cell">شماره نامه</th>
                                                    <th class="tbl-head-style-cell">رزرو شده</th>
                                                    <th class="tbl-head-style-cell">تامین اعتبار</th>
                                                    <th class="tbl-head-style-cell">تعهد</th>
                                                    <th class="tbl-head-style-cell">هزینه شده</th>
                                                    <th class="tbl-head-style-cell">مبلغ</th>
                                                    <th class="tbl-head-style-cell">شرح</th>
                                                    <th class="tbl-head-style-cell">اعتبار پیشنهادی</th>
                                                    <th class="tbl-head-style-cell"></th>
                                                </tr>
                                                </tbody>
                                            </table>
                                            <!--Table Head End-->
                                            <!--Table Body Start-->
                                            <div class="tbl_body_style dynamic-height-level-modal1">
                                                <table class="tbl-body-contain">
                                                    <colgroup>
                                                        <col width="150px"/>
                                                        <col width="150px"/>
                                                        <col width="150px"/>
                                                        <col width="150px"/>
                                                        <col width="150px"/>
                                                        <col width="150px"/>
                                                        <col width="250px"/>
                                                        <col width="150px"/>
                                                        <col width="40px"/>
                                                    </colgroup>
                                                    <tbody class="tbl-head-style-cell">
                                                    <tr v-for="found in capitalAssetsFound">
                                                        <td>{{found.caaLetterNumber}}</td>
                                                        <td>{{found.caaSumOfReserved}}</td>
                                                        <td>{{found.caaSumOfFinancing}}</td>
                                                        <td>{{found.caaSumOfCommitment}}</td>
                                                        <td>{{found.caaSumOfCost}}</td>
                                                        <td>{{found.caaAmount}}</td>
                                                        <td>{{found.caaDescription}}</td>
                                                        <td>
                                                            <input :disabled="found.isHistory" class="direction-ltr" v-on:keyup="calculationOfCapCredit(null, found, 4, found.amount)" style="margin-bottom:0px;" v-if="found.selected == true" type="text" v-model="found.amount"  :value="found.amount" :name="'found'+found.id" v-validate="'numeric','min_value:0','max_value:'+ (getRemainingCapitalAssetsAmount(found , 4) + parseInt(found.amount , 10))" :class="{'input': true, 'error-border': errors.has('found'+found.id)}"/>
                                                            <span v-show="errors.has('found'+found.id)" class="error-font"></span>
                                                        </td>
                                                        <td><input :disabled="found.isHistory" v-on:change="setTextBoxValueCap(null,found,4)" v-model="found.selected" type="checkbox"></td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <!--Table Body End-->
                                    </div>
                                </div>
                                <!--Tab 5-->

                            </div>
                        </div>
                        <div class="large-12 medium-12 small-12 padding-lr small-top-m">
                            <div class="grid-x">
                                <div class="large-6 medium-6 small-12">
                                    <div class="grid-x">
                                        <div class="large-12 medium-12 small-12">
                                            <p> مبلغ برآورد : <span class="btn-red"> {{$parent.dispMoneyFormat(baseAmount)}} </span></p>
                                        </div>
                                        <div class="large-12 medium-12 small-12">
                                            <p> مبلغ تامین اعتبار : <span class="btn-red"> {{$parent.dispMoneyFormat(capReservedAmount)}} </span></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="large-6 medium-6 small-12">
                                    <div class="grid-x">
                                        <div class="large-12 medium-12 small-12">
                                            <div class="stacked-for-small button-group float-left">
                                                <button @click="reserveCapitalAssetsFinance()" class="my-button my-success float-left"><span class="btn-txt-mrg">  ثبت </span></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </modal-full-screen>
        <!-- Capital Assets Modal End -->
    </div>
</template>

<script>
    import Suggestions from "v-suggestions/src/Suggestions";
    import VuePersianDatetimePicker from 'vue-persian-datetime-picker';
    export default {
        components: {Suggestions,
        "vue-select": require("vue-select"),
        datePicker: VuePersianDatetimePicker
        },
        data () {
            return {
                receiveRequests:[],
                costTemp:'',
                showRequestDetailModal:false,
                showReferralsModal:false,
                showSubmitRequestModal:false,
                showResponseRequestModal:false,
                showRegisterAndNumberingModal:false,
                showCostCreditsModal:false,
                showCapitalAssetsModal:false,
                receiveRequestSearchValue:'',
                requestTypeDetail:'',
                requestFill:{},
                commodityList:[],
                recipientUsers:[],
                UserIsVerifier:[],
                remainingVerifiers:[],
                verifiers:[],
                groupUsers:[],
                groupUsersByCId:[],
                referralPermission:false,
                referralInput:{},
                lastVerifier:'',
                youAreVerifier:'',
                youAreVerifierCId:'',
                responseDescription:'',
                referralDescription:'',
                referralDestination:'',
                canResponse:'',
                baseURL:window.hostname+'/',
                commodityCountInput:{},
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

                /*credits*/
                completeCostAgrement:[],
                costFound:[],
                allocations:[],
                baseAmount:0,
                costReservedAmount:0,
                capReservedAmount:0,
                lastCostReservedAmount:0,
                lastCapReservedAmount:0,
                _financingAmount: 0,
                _reservedAmount: 0,
                amountInput:{},
                /*credits*/

                /*capital assets*/
                completeCapitalAssetsAgrement:[],
                capitalAssetsFound:[],
                capitalAssetsAllocations:[],
                /*capital assets*/

                requestCostFinancing:[],
                requestCapFinancing:[],
                maxInputValue:0,
            }
        },

        created: function(){
            this.fetchData();
        },

        updated: function () {
            $(this.$el).foundation(); //WORKS!
            this.myResizeModal();
            this.costTemp =  '  ' + this.$parent.getDispAmountBaseLabel();
        },

        mounted: function () {
            this.$parent.myResize();
        },

        methods: {

            fetchData: function (page=1) {
                axios.get('/financial/request/received/fetchData?page=' + page)
                    .then((response) => {
                        this.receiveRequests = response.data.data;
                        this.getUnReadReceivedRequest();
                        console.log(response);
                    }, (error) => {
                        console.log(error);
                    });
            },

            getUnReadReceivedRequest: function(){
                var count = 0;
                 this.receiveRequests.forEach(item => {
                     if (item.rLastRef.rhHasBeenSeen == 0)
                        count++;
                 });
                this.$parent.unReadRequestCount = count;
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

            getCompleteCostAgrement: function () {
                axios.get('/budget/approved_plan/cost/fetchCompleteData')
                    .then((response) => {
                        this.completeCostAgrement = response.data.costAgreement;
                        this.costFound = response.data.costFound;

                        this.addNewFieldInCollection();
                        //get allocations start
                        /*this.completeCostAgrement.forEach(cost => {
                            cost.ca_credit_source_has_allocation.forEach(alloc =>{
                                alloc.allocation.forEach(item =>{
                                    this.allocations.push(item);
                                });
                            });
                        });
                        console.log(JSON.stringify(this.allocations));*/
                        //get allocations start

                        console.log(response);
                    }, (error) => {
                        console.log(error);
                    });

            },

            addNewFieldInCollection:function(){
                this.completeCostAgrement.forEach(cost => {
                    Vue.set(cost,"selected",false);
                    Vue.set(cost,"amount",0);
                    Vue.set(cost,"isHistory",false);
                    cost.ca_credit_source_has_allocation.forEach(cs =>{
                        Vue.set(cs,"selected",false);
                        Vue.set(cs,"amount",0);
                        Vue.set(cs,"isHistory",false);
                        cs.allocation.forEach(alloc =>{
                            var isExist = false;
                            var tempAmount = 0;
                            this.requestCostFinancing.forEach(costFin => {
                                if (costFin.allocation.id == alloc.id)
                                {
                                    isExist = true;
                                    tempAmount = costFin.cfAmount;
                                    costFin.stop = true;
                                }
                            });
                            if (isExist)
                            {
                                Vue.set(alloc,"selected",true);
                                Vue.set(alloc,"amount",tempAmount);
                                Vue.set(alloc,"isHistory",true);
                            }else{
                                Vue.set(alloc,"selected",false);
                                Vue.set(alloc,"amount",0);
                                Vue.set(alloc,"isHistory",false);
                            }
                        });
                    });
                });

                this.completeCostAgrement.forEach(ca => {
                    this.calculationOfCostCreditEdit(ca);
                });

                this.costFound.forEach(found => {
                    var isExist = false;
                    var tempAmount = 0;
                    this.requestCostFinancing.forEach(costFin => {
                        if (costFin.allocation.id == found.id)
                        {
                            isExist = true;
                            tempAmount = costFin.cfAmount;
                            costFin.stop = true;
                        }
                    });
                    if (isExist)
                    {
                        Vue.set(found,"selected",true);
                        Vue.set(found,"amount",tempAmount);
                        Vue.set(found,"isHistory",true);

                    }else{
                        Vue.set(found,"selected",false);
                        Vue.set(found,"amount",0);
                        Vue.set(found,"isHistory",false);
                    }
                });

                this.calculateCostReservedAmount();
            },

            getCompleteCapitalAssetsApproved: function () {
                axios.get('/budget/approved_plan/capital_assets/fetchCompleteData')
                    .then((response) => {
                        this.completeCapitalAssetsAgrement = response.data.caApprovedPlan;
                        this.capitalAssetsFound = response.data.capFound;
                        this.addNewFieldInCapitalAssetsCollection();
                        console.log(JSON.stringify(this.completeCapitalAssetsAgrement));
                        console.log(response);
                    }, (error) => {
                        console.log(error);
                    });
            },

            addNewFieldInCapitalAssetsCollection:function(){
                this.completeCapitalAssetsAgrement.forEach(ca => {
                    Vue.set(ca,"selected",false);
                    Vue.set(ca,"amount",0);
                    Vue.set(ca,"isHistory",false);
                    ca.capital_assets_project_has_credit_source	.forEach(project =>{
                        Vue.set(project,"selected",false);
                        Vue.set(project,"amount",0);
                        Vue.set(project,"isHistory",false);
                        project.credit_source_has_allocation.forEach(cs =>{
                            Vue.set(cs,"selected",false);
                            Vue.set(cs,"amount",0);
                            Vue.set(cs,"isHistory",false);
                            cs.allocation.forEach(alloc =>{
                                var isExist = false;
                                var tempAmount = 0;
                                this.requestCapFinancing.forEach(capFin => {
                                    if (capFin.allocation.id == alloc.id)
                                    {
                                        isExist = true;
                                        tempAmount = capFin.cafAmount;
                                        capFin.stop = true;
                                    }
                                });
                                if (isExist)
                                {
                                    Vue.set(alloc,"selected",true);
                                    Vue.set(alloc,"amount",tempAmount);
                                    Vue.set(alloc,"isHistory",true);
                                }else{
                                    Vue.set(alloc,"selected",false);
                                    Vue.set(alloc,"amount",0);
                                    Vue.set(alloc,"isHistory",false);
                                }
                            });
                        });
                    });
                });

                this.completeCapitalAssetsAgrement.forEach(ca => {
                    this.calculationOfCapCreditEdit(ca);
                });

                this.capitalAssetsFound.forEach(found => {
                    var isExist = false;
                    var tempAmount = 0;
                    this.requestCapFinancing.forEach(capFin => {
                        if (capFin.allocation.id == found.id)
                        {
                            isExist = true;
                            tempAmount = capFin.cafAmount;
                            capFin.stop = true;
                        }
                    });
                    if (isExist)
                    {
                        Vue.set(found,"selected",true);
                        Vue.set(found,"amount",tempAmount);
                        Vue.set(found,"isHistory",true);
                    }else{
                        Vue.set(found,"selected",false);
                        Vue.set(found,"amount",0);
                        Vue.set(found,"isHistory",false);
                    }
                });

                this.calculateCapReservedAmount();
            },

            fetchRequestFinancing: function (){
                axios.get('/financial/request/financing' , {params:{rId:this.requestId}})
                    .then((response) => {
                        this.requestCostFinancing = response.data.costFinancing;
                        this.requestCapFinancing = response.data.capFinancing;
                        this.getFinancingAmount();
                        console.log(this.requestCostFinancing);
                        console.log(response);
                    }, (error) => {
                        console.log(error);
                    });
            },

            getFinancingAmount: function(){
                this._financingAmount = 0;
                this._reservedAmount = 0;
                this.lastCostReservedAmount = 0;
                this.lastCapReservedAmount = 0;
                this.requestCapFinancing.forEach(item => {
                    if (item.cafAccepted == 1)
                        this._financingAmount += parseInt(item.cafAmount , 10);
                    else
                    {
                        this._reservedAmount += parseInt(item.cafAmount , 10);
                    }
                    this.lastCapReservedAmount += parseInt(item.cafAmount , 10);
                });

                this.requestCostFinancing.forEach(item => {
                    if (item.cfAccepted == 1)
                        this._financingAmount += parseInt(item.cfAmount , 10);
                    else
                        this._reservedAmount += parseInt(item.cfAmount , 10);

                    this.lastCostReservedAmount += parseInt(item.cfAmount , 10);
                });
            },

            getRequestDetail: function (request) {
                if(request.rLastRef.rhHasBeenSeen==0) {
                    axios.post('/financial/request/received/was_seen', {
                        rhId: request.rLastRef.id
                    }).then((response) => {
                        this.receiveRequests = response.data.data;
                        console.log(response);
                    }, (error) => {
                        console.log(error);
                    });
                }
                this.showRequestDetailModal=true;
                this.recipientUsers=[];
                this.verifiers=[];
                this.UserIsVerifier=[];
                var requestHistory=[];
                requestHistory.push(request);
                this.requestId=request.id;

                this.requestCostFinancing=[];
                this.requestCapFinancing=[];
                this.fetchRequestFinancing();


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

                requestHistory.forEach(remainUsers => {
                    remainUsers.rRemainingVerifiers.forEach(users => {
                        this.UserIsVerifier.push(users);
                    });
                });

                this.lastVerifier=request.rLastRef.id;

                if(request.rYouAreVerifiers.length != 0){
                    this.youAreVerifier=request.rYouAreVerifiers[0].id;
                    this.youAreVerifierCId=request.rYouAreVerifiers[0].request_step.rstCId;
                }

                this.referralDescription=request.rLastRef.rhDescription;
                this.referralDestination=request.rLastRef.source_user_info.name +' - ' +request.rLastRef.source_user_info.role.rSubject;
                this.canResponse=request.rLastRef.rhIsReferral;

                this.baseAmount= request.rCostEstimation;

                if (request.rRtId == 1){
                    this.requestTypeDetail='SERVICES';
                    this.requestFill.rLetterNumber=request.rLetterNumber;
                    this.requestFill.rLetterDate=request.rLetterDate;
                    this.requestFill.rSubject=request.rSubject;
                    this.requestFill.rCostEstimation=request.rCostEstimation;
                    this.requestFill.rDescription=request.rDescription;
                    this.requestFill.rFurtherDetails=request.rFurtherDetails;
                }
                else if (request.rRtId == 2){
                    var commodityTemp=[];
                    commodityTemp.push(request);
                    this.commodityList=[];
                    this.requestTypeDetail='COMMODITY';
                    this.requestFill.rLetterNumber=request.rLetterNumber;
                    this.requestFill.rLetterDate=request.rLetterDate;
                    this.requestFill.rSubject=request.rSubject;
                    this.requestFill.rCostEstimation=request.rCostEstimation;
                    commodityTemp.forEach(items => {
                        items.request_commodity.forEach(commodity => {
                            this.commodityList.push(commodity);
                        });
                    });
                }
                else if (request.rRtId == 3){
                    this.requestTypeDetail='FUND';
                    this.requestFill.rLetterNumber=request.rLetterNumber;
                    this.requestFill.rLetterDate=request.rLetterDate;
                    this.requestFill.rSubject=request.rSubject;
                    this.requestFill.rCostEstimation=request.rCostEstimation;
                    this.requestFill.rDescription=request.rDescription;
                }
            },

            openReferralsModal: function () {
                this.showReferralsModal=true;
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
                            verifierId:this.youAreVerifier
                        }).then((response) => {
                            this.receiveRequests = response.data.data;
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

            hideSubmitRequestModal: function () {
              this.showSubmitRequestModal=false;
            },

            acceptRequest: function () {

                axios.post('/financial/request/accept', {
                    lastRefId: this.lastVerifier,
                    verifierId: this.youAreVerifier,
                    itemExistCount: this.repoExistCount
                }).then((response) => {
                    this.receiveRequests = response.data.data;
                    this.showSubmitRequestModal = false;
                    this.showRequestDetailModal = false;
                    this.$parent.displayNotif(response.status);
                    console.log(response);
                }, (error) => {
                    console.log(error);
                    this.$parent.displayNotif(error.response.status);
                });
            },

            openResponseRequestModal: function () {
                this.showResponseRequestModal=true;
            },

            responseRequest: function () {
                axios.post('/financial/request/response', {
                    lastRefId: this.lastVerifier,
                    description: this.responseDescription
                }).then((response) => {
                    this.receiveRequests = response.data.data;
                    this.showResponseRequestModal = false;
                    this.showRequestDetailModal = false;
                    this.$parent.displayNotif(response.status);
                    console.log(response);
                }, (error) => {
                    console.log(error);
                    this.$parent.displayNotif(error.response.status);
                });
            },

            setRepoExistCount: function (cId,count) {
                console.log(JSON.stringify(this.commodityCountInput));
                var repoExistCountInput={};
                repoExistCountInput.rcId=cId;
                repoExistCountInput.existCount=count;

                if(this.repoExistCount === undefined || this.repoExistCount.length == 0){
                    this.repoExistCount.push(repoExistCountInput);
                }
                else{
                    this.repoExistCount.forEach((item,index) =>{
                        if(item.rcId ==  repoExistCountInput.rcId){
                            this.repoExistCount.splice(index,1);
                            this.repoExistCount.push(repoExistCountInput);
                        }
                        else{
                            this.repoExistCount.push(repoExistCountInput);
                        }
                    });
                }
            },

            openRegisterAndNumberingModal: function (){
              this.showRegisterAndNumberingModal=true;
            },

            registerAndNumbering:function () {
                axios.post('/financial/request/secretariat/numbering/register', {
                    rId: this.requestId,
                    letterDate: this.registerDate,
                    letterNumber: this.letterNumber
                }).then((response) => {
                    this.receiveRequests = response.data.data;
                    this.showRegisterAndNumberingModal = false;
                    this.showRequestDetailModal = false;
                    this.$parent.displayNotif(response.status);
                    console.log(response);
                }, (error) => {
                    console.log(error);
                    this.$parent.displayNotif(error.response.status);
                });
            },

            openCostCreditsModal:function () {
                this.completeCostAgrement= [];
                this.costFound = [];
                this.costReservedAmount = 0;
                this.getFinancingAmount();
                this.getCompleteCostAgrement();
                this.showCostCreditsModal=true;
                this.reservedAmount=0;
            },

            myResizeModal: function() {
                var x = $.w.outerHeight();
                $('.dynamic-height-level-modal1').css('height', (x-320) + 'px');
                $('.dynamic-height-level-modal2').css('height', (x-460) + 'px');
            },

            openCapitalAssetsModal:function () {
                this.completeCapitalAssetsAgrement = [];
                this.capitalAssetsFound = [];
                this.capReservedAmount = 0;
                this.getFinancingAmount();
                this.getCompleteCapitalAssetsApproved ();
                this.showCapitalAssetsModal=true;

            },

            /////////////////////// cost financing //////////////////////////////
            calculationOfCostCredit: function(rootData,data,type,value){
                var aCount=0;
                var piceOfAmount=0;
                var piceOfDivRemAmount=0;
                var allocIsNotExist = true;
                if (!isNaN(value))
                {
                    if(type == 0){ //plan level
                        data.ca_credit_source_has_allocation.forEach(cs => {
                            aCount += cs.allocation.length;
                        });
                        piceOfAmount = (value / aCount) >> 0;
                        piceOfDivRemAmount = value % aCount;
                        data.ca_credit_source_has_allocation.forEach(cs => {
                            cs.selected = true;
                            cs.allocation.forEach( alloc =>{
                                alloc.selected = true;
                                var remainingAmount = parseInt(alloc.caAmount) - (parseInt(alloc.caSumOfCost) + parseInt(alloc.caSumOfReserved) + parseInt(alloc.caSumOfFinancing) + parseInt(alloc.caSumOfCommitment));
                                if( remainingAmount >= (piceOfAmount + piceOfDivRemAmount)) {
                                    alloc.amount = (piceOfAmount + piceOfDivRemAmount);
                                    piceOfDivRemAmount = 0;
                                    allocIsNotExist = false;
                                }
                                else if (remainingAmount >= piceOfAmount){
                                    alloc.amount = piceOfAmount;
                                    allocIsNotExist = false;
                                }else{
                                    if (remainingAmount <= 0)
                                    {
                                        alloc.amount = 0;
                                    }else{
                                        alloc.amount = remainingAmount;
                                        allocIsNotExist = false;
                                    }
                                }
                                console.log(JSON.stringify(alloc));
                            });
                        });
                        this.calculationOfCostCreditEdit(rootData);
                        this.calculateCostReservedAmount();

                    }
                    else if(type == 1){ //credit source level
                        aCount = data.allocation.length;
                        piceOfAmount = (value / aCount)  >> 0;
                        piceOfDivRemAmount = value % aCount;
                        data.allocation.forEach( alloc =>{
                            alloc.selected = true;
                            var remainingAmount = parseInt(alloc.caAmount) - (parseInt(alloc.caSumOfCost) + parseInt(alloc.caSumOfReserved) + parseInt(alloc.caSumOfFinancing) + parseInt(alloc.caSumOfCommitment));
                            if (remainingAmount > 0) {
                                if (remainingAmount >= (piceOfAmount + piceOfDivRemAmount)) {
                                    alloc.amount = (piceOfAmount + piceOfDivRemAmount);
                                    piceOfDivRemAmount = 0;
                                    allocIsNotExist = false;
                                }
                                else if (remainingAmount >= piceOfAmount) {
                                    alloc.amount = piceOfAmount;
                                    allocIsNotExist = false;
                                } else {
                                    if (remainingAmount <= 0)
                                    {
                                        alloc.amount = 0;
                                    }else{
                                        alloc.amount = remainingAmount;
                                        allocIsNotExist = false;
                                    }
                                }
                            }
                        });
                        this.calculationOfCostCreditEdit(rootData);
                        this.calculateCostReservedAmount();
                    }
                    else if(type == 2){ //allocation level
                        data.selected = true;
                        var remainingAmount = parseInt(data.caAmount) - (parseInt(data.caSumOfCost) + parseInt(data.caSumOfReserved) + parseInt(data.caSumOfFinancing) + parseInt(data.caSumOfCommitment));
                        if (remainingAmount > 0) {
                            if (remainingAmount >= value) {
                                data.amount = value;
                                allocIsNotExist = false;
                            }
                            else {
                                if (remainingAmount <= 0)
                                {
                                    data.amount = 0;
                                }else{
                                    data.amount = remainingAmount;
                                    allocIsNotExist = false;
                                }
                            }
                        }
                        this.calculationOfCostCreditEdit(rootData);
                        this.calculateCostReservedAmount();
                    }else if(type == 3) //found level
                    {
                        data.selected = true;
                        var remainingAmount = parseInt(data.caAmount) - (parseInt(data.caSumOfCost) + parseInt(data.caSumOfReserved) + parseInt(data.caSumOfFinancing) + parseInt(data.caSumOfCommitment));
                        if (remainingAmount > 0)
                        {
                            if(remainingAmount >= value) {
                                data.amount = value;
                                allocIsNotExist = false;
                            }
                            else{
                                if (remainingAmount <= 0)
                                {
                                    data.amount = 0;
                                }else{
                                    data.amount = remainingAmount;
                                    allocIsNotExist = false;
                                }
                            }
                        }

                        if (data.amount == 0)
                        {
                            data.amount = 0;
                            data.selected = false;
                        }
                        this.calculateCostReservedAmount();
                    }else{
                        allocIsNotExist = false;
                    }

                    if (allocIsNotExist)
                        this.$parent.displayNotif(1);
                }
            },

            calculationOfCostCreditEdit: function(data){
                var sumOfPlanAmount=0;
                var csIsHistory = false;
                if (data != null)
                {
                    data.ca_credit_source_has_allocation.forEach(cs => {
                        var sumOfAlloc= 0 ;
                        var isHistory = false;
                        cs.allocation.forEach( alloc =>{
                            sumOfAlloc += parseInt(alloc.amount , 10);
                            if (parseInt(alloc.amount , 10) != 0)
                                alloc.selected = true;
                            else
                                alloc.selected = false;

                            if (alloc.isHistory)
                                isHistory = true;
                        });
                        cs.amount = sumOfAlloc;
                        cs.isHistory = isHistory;
                        sumOfPlanAmount += sumOfAlloc;
                        if (sumOfAlloc != 0)
                            cs.selected = true;
                        else
                            cs.selected = false;

                        if (isHistory)
                            csIsHistory = isHistory;
                    });
                    if (sumOfPlanAmount != 0)
                        data.selected = true;
                    else
                        data.selected = false;
                    data.amount = sumOfPlanAmount;
                    data.isHistory = csIsHistory;
                    console.log(JSON.stringify(data));
                }
            },

            setTextBoxValueCost: function (rootData,data,type) {
                if (data.selected == true)
                {
                    this.calculationOfCostCredit(rootData,data,type,(this.baseAmount - this.costReservedAmount));
                }else{
                    if (type == 0)
                    {
                        data.amount = 0;
                        data.ca_credit_source_has_allocation.forEach(cs => {
                            cs.selected = false;
                            cs.amount = 0;
                            cs.allocation.forEach( alloc =>{
                                alloc.selected = false;
                                alloc.amount = 0;
                            });
                        });
                        this.calculationOfCostCreditEdit(rootData);
                        this.calculateCostReservedAmount();
                    }else if (type == 1)
                    {
                        data.amount = 0;
                        cs.allocation.forEach( alloc =>{
                            alloc.selected = true;
                            alloc.amount = 0;
                        });
                        this.calculationOfCostCreditEdit(rootData);
                        this.calculateCostReservedAmount();
                    }else if (type == 2)
                    {
                        data.amount = 0;
                        data.selected = false;
                        this.calculationOfCostCreditEdit(rootData);
                        this.calculateCostReservedAmount();
                    } else if (type == 3)
                    {
                        data.amount = 0;
                        data.selected = false;
                        this.calculateCostReservedAmount();
                    }
                }

            },

            ///////////////////// capital assets fainancing /////////////////////////////
            calculationOfCapCredit: function(rootData,data,type,value){
                var aCount=0;
                var piceOfAmount=0;
                var piceOfDivRemAmount=0;
                var allocIsNotExist = true;

                if (!isNaN(value))
                {
                    if(type == 0){ //plan level
                        data.capital_assets_project_has_credit_source.forEach(project => {
                            project.credit_source_has_allocation.forEach(cs => {
                                aCount += cs.allocation.length;
                            });
                        });
                        piceOfAmount = (value / aCount) >> 0;
                        piceOfDivRemAmount = value % aCount;
                        data.capital_assets_project_has_credit_source.forEach(project => {
                            project.selected = true;
                            project.credit_source_has_allocation.forEach(cs => {
                                cs.selected = true;
                                cs.allocation.forEach( alloc =>{
                                    alloc.selected = true;
                                    var remainingAmount = parseInt(alloc.caaAmount) - (parseInt(alloc.caaSumOfCost) + parseInt(alloc.caaSumOfReserved) + parseInt(alloc.caaSumOfFinancing) + parseInt(alloc.caaSumOfCommitment));
                                    if( remainingAmount >= (piceOfAmount + piceOfDivRemAmount)) {
                                        alloc.amount = (piceOfAmount + piceOfDivRemAmount);
                                        piceOfDivRemAmount = 0;
                                        allocIsNotExist = false;
                                    }
                                    else if (remainingAmount >= piceOfAmount){
                                        alloc.amount = piceOfAmount;
                                        allocIsNotExist = false;
                                    }else{
                                        if (remainingAmount <= 0)
                                        {
                                            alloc.amount = 0;
                                        }else{
                                            alloc.amount = remainingAmount;
                                            allocIsNotExist = false;
                                        }
                                    }
                                    console.log(JSON.stringify(alloc));
                                });
                            });
                        });
                        this.calculationOfCapCreditEdit(rootData);
                        this.calculateCapReservedAmount();
                    }
                    else if(type == 1){ //credit source level
                        data.credit_source_has_allocation.forEach(cs => {
                            aCount += cs.allocation.length;
                        });
                        piceOfAmount = (value / aCount)  >> 0;
                        piceOfDivRemAmount = value % aCount;
                        data.credit_source_has_allocation.forEach(cs => {
                            cs.selected = true;
                            cs.allocation.forEach( alloc =>{
                                alloc.selected = true;
                                var remainingAmount = parseInt(alloc.caaAmount) - (parseInt(alloc.caaSumOfCost) + parseInt(alloc.caaSumOfReserved) + parseInt(alloc.caaSumOfFinancing) + parseInt(alloc.caaSumOfCommitment));
                                if( remainingAmount >= (piceOfAmount + piceOfDivRemAmount)) {
                                    alloc.amount = (piceOfAmount + piceOfDivRemAmount);
                                    piceOfDivRemAmount = 0;
                                    allocIsNotExist = false;
                                }
                                else if (remainingAmount >= piceOfAmount){
                                    alloc.amount = piceOfAmount;
                                    allocIsNotExist = false;
                                }else{
                                    if (remainingAmount <= 0)
                                    {
                                        alloc.amount = 0;
                                    }else{
                                        alloc.amount = remainingAmount;
                                        allocIsNotExist = false;
                                    }
                                }
                                console.log(JSON.stringify(alloc));
                            });
                        });
                        this.calculationOfCapCreditEdit(rootData);
                        this.calculateCapReservedAmount();
                    }
                    else if(type == 2) { //allocation level
                        aCount += data.allocation.length;
                        piceOfAmount = (value / aCount)  >> 0;
                        piceOfDivRemAmount = value % aCount;
                        data.allocation.forEach( alloc =>{
                            alloc.selected = true;
                            var remainingAmount = parseInt(alloc.caaAmount) - (parseInt(alloc.caaSumOfCost) + parseInt(alloc.caaSumOfReserved) + parseInt(alloc.caaSumOfFinancing) + parseInt(alloc.caaSumOfCommitment));
                            if( remainingAmount >= (piceOfAmount + piceOfDivRemAmount)) {
                                alloc.amount = (piceOfAmount + piceOfDivRemAmount);
                                piceOfDivRemAmount = 0;
                                allocIsNotExist = false;
                            }
                            else if (remainingAmount >= piceOfAmount){
                                alloc.amount = piceOfAmount;
                                allocIsNotExist = false;
                            }else{
                                if (remainingAmount <= 0)
                                {
                                    alloc.amount = 0;
                                }else{
                                    alloc.amount = remainingAmount;
                                    allocIsNotExist = false;
                                }
                            }
                            console.log(JSON.stringify(alloc));
                        });

                        this.calculationOfCapCreditEdit(rootData);
                        this.calculateCapReservedAmount();
                    }
                    else if(type == 3){ //allocation level
                        data.selected = true;
                        var remainingAmount = parseInt(data.caaAmount) - (parseInt(data.caaSumOfCost) + parseInt(data.caaSumOfReserved) + parseInt(data.caaSumOfFinancing) + parseInt(data.caaSumOfCommitment));
                        if (remainingAmount > 0) {
                            if (remainingAmount >= value) {
                                data.amount = value;
                                allocIsNotExist = false;
                            }
                            else {
                                if (remainingAmount <= 0)
                                {
                                    data.amount = 0;
                                }else{
                                    data.amount = remainingAmount;
                                    allocIsNotExist = false;
                                }
                            }
                        }
                        this.calculationOfCapCreditEdit(rootData);
                        this.calculateCapReservedAmount();
                    }else if(type == 4) //found level
                    {
                        data.selected = true;
                        var remainingAmount = parseInt(data.caaAmount) - (parseInt(data.caaSumOfCost) + parseInt(data.caaSumOfReserved) + parseInt(data.caaSumOfFinancing) + parseInt(data.caaSumOfCommitment));
                        if (remainingAmount > 0)
                        {
                            if(remainingAmount >= value) {
                                data.amount = value;
                                allocIsNotExist = false;
                            }
                            else{
                                if (remainingAmount <= 0)
                                {
                                    data.amount = 0;
                                }else{
                                    data.amount = remainingAmount;
                                    allocIsNotExist = false;
                                }
                            }
                        }

                        if (data.amount == 0)
                        {
                            data.amount = 0;
                            data.selected = false;
                        }
                        this.calculateCapReservedAmount();
                    }else{
                        allocIsNotExist = false;
                    }

                    if (allocIsNotExist)
                        this.$parent.displayNotif(1);
                }
            },

            calculateCostReservedAmount: function(){
                this.costReservedAmount = this.lastCapReservedAmount; // sum with last cap
                this.completeCostAgrement.forEach(plan => {
                    plan.ca_credit_source_has_allocation.forEach(cs => {
                        cs.allocation.forEach( alloc =>{
                            this.costReservedAmount += parseInt(alloc.amount , 10);
                        });
                    });
                });

                this.costFound.forEach(found => {
                    this.costReservedAmount += parseInt(found.amount , 10);
                });
            },

            calculateCapReservedAmount: function(){
                this.capReservedAmount = this.lastCostReservedAmount; // sum with last cost
                this.completeCapitalAssetsAgrement.forEach(plan => {
                    plan.capital_assets_project_has_credit_source.forEach(project => {
                        project.credit_source_has_allocation.forEach(cs => {
                            cs.allocation.forEach( alloc =>{
                                this.capReservedAmount += parseInt(alloc.amount , 10);
                            });
                        });
                    });
                });


                this.capitalAssetsFound.forEach(found => {
                    this.capReservedAmount += parseInt(found.amount , 10);
                });
            },

            calculationOfCapCreditEdit: function(data){
                var sumOfProjectAmount=0;
                var sumOfCsAmount=0;
                var projectIsHistory = false;
                var csIsHistory = false;

                if (data != null)
                {
                    data.capital_assets_project_has_credit_source.forEach(project => {
                        sumOfCsAmount=0;
                        project.credit_source_has_allocation.forEach(cs => {
                            var sumOfAlloc= 0 ;
                            var isHistory = false;
                            cs.allocation.forEach( alloc =>{
                                sumOfAlloc += parseInt(alloc.amount , 10);
                                if (parseInt(alloc.amount , 10) != 0)
                                    alloc.selected = true;
                                else
                                    alloc.selected = false;

                                if (alloc.isHistory == true)
                                    isHistory = true;
                            });
                            cs.isHistory = isHistory;
                            cs.amount = sumOfAlloc;
                            sumOfCsAmount += sumOfAlloc;
                            if (sumOfAlloc != 0)
                                cs.selected = true;
                            else
                                cs.selected = false;

                            if (isHistory)
                                csIsHistory = isHistory;
                        });
                        project.amount = sumOfCsAmount;
                        project.isHistory = csIsHistory;
                        sumOfProjectAmount += sumOfCsAmount;
                        if (sumOfCsAmount != 0)
                            project.selected = true;
                        else
                            project.selected = false;

                        if (csIsHistory)
                            projectIsHistory = csIsHistory;
                    });

                    if (sumOfProjectAmount != 0)
                        data.selected = true;
                    else
                        data.selected = false;
                    data.amount = sumOfProjectAmount;
                    if (projectIsHistory)
                        data.isHistory = projectIsHistory;
                    console.log(JSON.stringify(data));
                }
            },

            setTextBoxValueCap: function (rootData,data,type) {
                if (data.selected == true)
                {
                    this.calculationOfCapCredit(rootData,data,type,this.baseAmount - this.capReservedAmount);
                }else{
                    if (type == 0)
                    {
                        data.amount = 0;
                        data.capital_assets_project_has_credit_source.forEach(project => {
                            project.selected = false;
                            project.amount = 0;
                            project.credit_source_has_allocation.forEach(cs => {
                                cs.selected = false;
                                cs.amount = 0;
                                cs.allocation.forEach( alloc =>{
                                    alloc.selected = false;
                                    alloc.amount = 0;
                                });
                            });
                        });
                        this.calculationOfCapCreditEdit(rootData);
                        this.calculateCapReservedAmount();
                    }else if (type == 1)
                    {
                        data.amount = 0;
                        data.credit_source_has_allocation.forEach(cs => {
                            cs.selected = false;
                            cs.amount = 0;
                            cs.allocation.forEach( alloc =>{
                                alloc.selected = false;
                                alloc.amount = 0;
                            });
                        });
                        this.calculationOfCapCreditEdit(rootData);
                        this.calculateCapReservedAmount();
                    }else if (type == 2)
                    {
                        data.amount = 0;
                        data.allocation.forEach(cs => {
                            alloc.selected = false;
                            alloc.amount = 0;
                        });
                        this.calculationOfCapCreditEdit(rootData);
                        this.calculateCapReservedAmount();
                    }else if (type == 3)
                    {
                        data.amount = 0;
                        data.selected = false;
                        this.calculationOfCapCreditEdit(rootData);
                        this.calculateCapReservedAmount();
                    } else if (type == 4)
                    {
                        data.amount = 0;
                        data.selected = false;
                        this.calculateCapReservedAmount();
                    }
                }

            },

            reserveCostFinance: function () {
                this.$validator.validateAll().then((result) => {
                    if (result) {
                var costFinancing= [];
                this.completeCostAgrement.forEach(cost => {
                    cost.ca_credit_source_has_allocation.forEach(alloc =>{
                        alloc.allocation.forEach(item =>{
                            if(item.selected == true){
                                var obj={};
                                Vue.set(obj,"aId",item.id);
                                Vue.set(obj,"amount",item.amount);
                                costFinancing.push(obj);
                            }
                        });
                    });
                });

                this.costFound.forEach(found => {
                    if(found.selected == true) {
                        var obj = {};
                        Vue.set(obj, "aId", found.id);
                        Vue.set(obj, "amount", found.amount);
                        costFinancing.push(obj);
                    }
                });
                console.log(JSON.stringify(costFinancing));
                axios.post('/financial/request/financing/reservation', {
                    rId: this.requestId,
                    costFinancing: costFinancing,
                }).then((response) => {
                    this.requestCostFinancing = response.data.costFinancing;
                    this.showCostCreditsModal = false;
                    this.$parent.displayNotif(response.status);
                    console.log(response);
                }, (error) => {
                    console.log(error);
                    this.$parent.displayNotif(error.response.status);
                });
                    }
                });
            },

            reserveCapitalAssetsFinance: function () {
                this.$validator.validateAll().then((result) => {
                    if (result) {
                var capitalAssetsFinancing= [];
                this.completeCapitalAssetsAgrement.forEach(ca => {
                    ca.capital_assets_project_has_credit_source	.forEach(project =>{
                        project.credit_source_has_allocation.forEach(cs =>{
                            cs.allocation.forEach(alloc => {
                                if (alloc.selected == true) {
                                    var obj = {};
                                    Vue.set(obj, "aId", alloc.id);
                                    Vue.set(obj, "amount", alloc.amount);
                                    capitalAssetsFinancing.push(obj);
                                }

                            });
                        });
                    });
                });
                this.capitalAssetsFound.forEach(found => {
                    if(found.selected == true) {
                        var obj = {};
                        Vue.set(obj, "aId", found.id);
                        Vue.set(obj, "amount", found.amount);
                        capitalAssetsFinancing.push(obj);
                    }
                });
                console.log(JSON.stringify(capitalAssetsFinancing));
                axios.post('/financial/request/financing/reservation', {
                    rId: this.requestId,
                    capFinancing: capitalAssetsFinancing,
                }).then((response) => {
                    this.requestCapFinancing = response.data.capFinancing;
                    this.showCapitalAssetsModal = false;
                    this.$parent.displayNotif(response.status);
                    console.log(response);
                }, (error) => {
                    console.log(error);
                    this.$parent.displayNotif(error.response.status);
                });
                    }
                });
            },

            getRemainingCostAmount: function (data, type) {
                var remainingAmount= 0;
                if (type == 1)
                {
                    data.ca_credit_source_has_allocation.forEach(alloc =>{
                        alloc.allocation.forEach(item =>{
                            remainingAmount += item.caAmount - (item.caSumOfCost + item.caSumOfReserved + item.caSumOfFinancing + item.caSumOfCommitment);
                        });
                    });
                }else if(type == 2)
                {
                    data.allocation.forEach(item =>{
                        remainingAmount += item.caAmount - (item.caSumOfCost + item.caSumOfReserved + item.caSumOfFinancing + item.caSumOfCommitment);
                    });
                }else if(type == 3){
                    remainingAmount = data.caAmount - (data.caSumOfCost + data.caSumOfReserved + data.caSumOfFinancing + data.caSumOfCommitment);
                }

                var temp = (this.baseAmount - this.costReservedAmount);
                return  (remainingAmount < temp ? remainingAmount : temp);
            },

            getRemainingCapitalAssetsAmount: function (data, type) {
                var remainingCapAmount= 0;
                if (type == 1)
                {
                    data.capital_assets_project_has_credit_source.forEach(project =>{
                        project.credit_source_has_allocation.forEach(cs => {
                            cs.allocation.forEach(alloc => {
                                remainingCapAmount += alloc.caaAmount - (alloc.caaSumOfCost + alloc.caaSumOfReserved + alloc.caaSumOfFinancing + alloc.caaSumOfCommitment);
                            });
                        });
                    });
                }else if(type == 2)
                {
                    data.credit_source_has_allocation.forEach(cs => {
                        cs.allocation.forEach(alloc => {
                            remainingCapAmount += alloc.caaAmount - (alloc.caaSumOfCost + alloc.caaSumOfReserved + alloc.caaSumOfFinancing + alloc.caaSumOfCommitment);
                        });
                    });

                }else if(type == 3){
                    data.allocation.forEach(alloc => {
                        remainingCapAmount += alloc.caaAmount - (alloc.caaSumOfCost + alloc.caaSumOfReserved + alloc.caaSumOfFinancing + alloc.caaSumOfCommitment);
                    });
                }else if(type == 4){
                    remainingCapAmount += data.caaAmount - (data.caaSumOfCost + data.caaSumOfReserved + data.caaSumOfFinancing + data.caaSumOfCommitment);
                }

                var temp = (this.baseAmount - this.capReservedAmount);
                return  (remainingCapAmount < temp ? remainingCapAmount : temp);
            },
        }
    }
</script>
