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
                    <div class="medium-12 column">
                        <div class="float-left cost-label">
                            <span class="small-font"> مبالغ : {{costTemp}} </span>
                        </div>
                    </div>
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
                                    <col width="200px"/>
                                    <col width="150px"/>
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
                                    <th class="tbl-head-style-cell">قیمت</th>
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
                                        <col width="200px"/>
                                        <col width="150px"/>
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
                                        <td>{{$parent.calcDispAmount(receiveRequest.rCostEstimation,false)}}</td>
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
                                                    <td width="150px">مبلغ برآردی : </td>
                                                    <td>{{$parent.calcDispAmount(requestFill.rCostEstimation,false)}} <span class="btn-red">  {{costTemp}}  </span></td>
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
                                                <th width="200">مبلغ برآوردی <span class="btn-red small-font">({{costTemp}})</span></th>
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
                                                    <td>{{$parent.calcDispAmount(lists.rcCostEstimation,false)}}</td>
                                                    <td>{{lists.rcDescription}}</td>
                                                </tr>
                                                <tr>
                                                    <td colspan="4" class="text-center font-wei-bold"> مجموع برآورد</td>
                                                    <td colspan="2" class="text-center font-wei-bold">{{$parent.calcDispAmount(requestFill.rCostEstimation,false)}} <span class="btn-red">{{  costTemp  }}</span> </td>
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
                                                    <td width="150px">مبلغ برآردی : </td>
                                                    <td>{{$parent.calcDispAmount(requestFill.rCostEstimation,false)}} <span class="btn-red">  {{costTemp}}  </span></td>
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
                                        <div class="large-12 medium-12 small-12 small-top-m">
                                            <div class="stacked-for-small button-group float-left">
                                                <button @click="openCostCreditsModal()" class="my-button my-success float-left"><span class="btn-txt-mrg">  اعتبارات هزینه ای</span></button>
                                                <button @click="" class="my-button my-success float-left"><span class="btn-txt-mrg">  اعتبارات عمرانی</span></button>
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
                                                                    <span style="text-align: left;" class="timeline-state gray-color">{{recipientUser.request_state.rsSubject}}</span>
                                                                </div>
                                                                <div class="large-12 medium-12 small-12">
                                                                    <div class="grid-x">
                                                                        <div class="large-1 medium-2 small-12">
                                                                            <img style="width: 40px;height: 40px;margin-top: 10px;margin-bottom: 10px;" class="profile-image-cover-index profile-image-cover-pos" :src="recipientUser.destination_user_info.avatarPath != null ? baseURL + recipientUser.destination_user_info.avatarPath : $parent.baseAvatar">
                                                                        </div>
                                                                        <div class="large-11 medium-10 small-12 padding-lr">
                                                                            <p class="small-top-m">
                                                                                {{recipientUser.destination_user_info.name}} - {{recipientUser.destination_user_info.role.rSubject}} :
                                                                            </p>
                                                                        </div>
                                                                    </div>
                                                                    <p class="small-top-m text-justify gray-colors">
                                                                        {{recipientUser.rhDescription}}
                                                                    </p>
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
                            <div class="stacked-for-small button-group">
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
                                        <img style="width: 60px;height: 60px;margin-top: 10px;margin-bottom: 10px;" class="profile-image-cover-index profile-image-cover-pos" :src="$parent.imgDataUrl">
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
                                                    <tr v-for="plan in completeCostAgrement">
                                                        <td>{{plan.caLetterNumber}}</td>
                                                        <td>{{plan.caLetterDate}}</td>
                                                        <td>{{plan.caSumOfCost}}</td>
                                                        <td>{{plan.caSumOfReserved}}</td>
                                                        <td>{{plan.caSumOfFinancing}}</td>
                                                        <td>{{plan.caSumOfCommitment}}</td>
                                                        <td>{{plan.caDescription}}</td>
                                                        <td><input v-on:keyup="calculationOfCostCredit(plan,plan,0,amountInput['planAmount' + plan.id])" style="margin-bottom:0px;" v-show="plan.selected == true" type="text"  v-model="amountInput['planAmount' + plan.id]" :name="'planAmount' + plan.id" :value="plan.amount" /></td>
                                                        <td><input v-on:change="setTextBoxValueCost(plan,plan,0,'planAmount' + plan.id)" v-model="plan.selected" type="checkbox" :name="'plan' + plan.id"></td>

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
                                                            <td>{{creditSource.caSumOfCost}}</td>
                                                            <td>{{creditSource.caSumOfReserved}}</td>
                                                            <td>{{creditSource.caSumOfFinancing}}</td>
                                                            <td>{{creditSource.caSumOfCommitment}}</td>
                                                            <td>{{$parent.calcDispAmount(creditSource.ccsAmount,false)}}</td>
                                                            <td>{{creditSource.caDescription}}</td>
                                                            <td><input style="margin-bottom:0px;" v-show="creditSource.selected == true" type="text" :name="'creditSourceAmount' + creditSource.id"  :value="creditSource.amount" /></td>
                                                            <td><input v-on:change="calculationOfCostCredit(plan,creditSource,0)" v-model="creditSource.selected" type="checkbox" :name="'creditSource' + creditSource.id"></td>
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
                                                                <td>{{allocation.caSumOfCost}}</td>
                                                                <td>{{allocation.caSumOfReserved}}</td>
                                                                <td>{{allocation.caSumOfFinancing}}</td>
                                                                <td>{{allocation.caSumOfCommitment}}</td>
                                                                <td>{{allocation.caDescription}}</td>
                                                                <td><input class="direction-ltr" v-on:change="calculationOfCostCredit(plan,allocation,0,amountInput['allocationAmount' + allocation.id])" style="margin-bottom:0px;" v-show="allocation.selected == true" type="text" :v-model="amountInput['allocationAmount' + allocation.id]" :name="'allocationAmount' + allocation.id" :value="allocation.amount" /></td>
                                                                <td><input v-on:change="setTextBoxValueCost('allocationAmount' + allocation.id)"  v-model="allocation.selected" type="checkbox" :name="'allocation' + allocation.id"></td>
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
                                                            <td>{{found.caSumOfCost}}</td>
                                                            <td>{{found.caSumOfReserved}}</td>
                                                            <td>{{found.caSumOfFinancing}}</td>
                                                            <td>{{found.caSumOfCommitment}}</td>
                                                            <td>{{found.caDescription}}</td>
                                                            <td><input v-on:change="calculationOfCostCredit(plan,found,0,amountInput['foundAmount' + found.id])" style="margin-bottom:0px;" v-show="found.selected == true" type="text" v-model="amountInput['foundAmount' + found.id]" :name="'foundAmount' + found.id"  :value="found.amount" /></td>
                                                            <td><input v-on:change="calculationOfCostCredit(plan,found,0,amountInput['foundAmount' + found.id])" v-model="found.selected" type="checkbox" :name="'costFound' + found.id"></td>
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
                            <p> مبلغ برآورد : <span class="btn-red"> {{$parent.calcDispAmount(baseAmount,false)}} </span></p>
                        </div>
                        <div class="large-12 medium-12 small-12 padding-lr">
                            <p> مبلغ تامین اعتبار : <span class="btn-red"> {{$parent.calcDispAmount(reservedAmount,false)}} </span></p>
                        </div>
                        <div class="large-12 medium-12 small-12 padding-lr">
                            <div class="stacked-for-small button-group float-left">
                                <button @click="" class="my-button my-success float-left"><span class="btn-txt-mrg">  ثبت </span></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </modal-full-screen>
        <!-- Cost Credits Modal End -->
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
                reservedAmount:0,
                amountInput:{},
                /*credits*/
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

            getCompleteCostAgrement: function () {
                axios.get('/budget/approved_plan/cost/fetchCompleteData')
                    .then((response) => {
                        this.completeCostAgrement = response.data.costAgreement;
                        this.costFound = response.data.costAgreement;

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
                    cost.ca_credit_source_has_allocation.forEach(alloc =>{
                        Vue.set(alloc,"selected",false);
                        Vue.set(alloc,"amount",0);
                        alloc.allocation.forEach(item =>{
                            Vue.set(item,"selected",false);
                            Vue.set(item,"amount",0);
                        });
                    });
                });

                this.costFound.forEach(found => {
                    Vue.set(found,"selected",false);
                    Vue.set(found,"amount",0);
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
                this.getCompleteCostAgrement();
                this.showCostCreditsModal=true;
            },

            myResizeModal: function() {
                var x = $.w.outerHeight();
                $('.dynamic-height-level-modal1').css('height', (x-320) + 'px');
            },

            calculationOfCostCredit: function(rootData,data,type,value){

                value= this.$parent.calcRealAmount(value.split(',').join(''));

                var aCount=0;
                var piceOfAmount=0;
                if(type == 0){ //plan level
                    data.ca_credit_source_has_allocation.forEach(cs => {
                        aCount += cs.allocation.length;
                         });
                    piceOfAmount = value / aCount;
                    data.ca_credit_source_has_allocation.forEach(cs => {
                        cs.selected = true;
                        cs.allocation.forEach( alloc =>{
                            alloc.selected = true;
                            var remainingAmount= alloc.caAmount - (alloc.caSumOfCost + alloc.caSumOfReserved + alloc.caSumOfFinancing + alloc.caSumOfCommitment );
                            if( remainingAmount >= piceOfAmount) {
                                alloc.amount = this.$parent.calcDispAmount(piceOfAmount,false);
                                this.reservedAmount += piceOfAmount;
                            }
                            else{
                                alloc.amount = this.$parent.calcDispAmount(remainingAmount,false);
                                this.reservedAmount += remainingAmount;
                            }
                            console.log(JSON.stringify(alloc));

                        });
                    });
                    this.calculationOfCostCreditEdit(rootData);
                 }
                 if(type == 1){ //credit source level
                     aCount = data.allocation.length;
                     data.ca_credit_source_has_allocation.forEach(cs => {

                     });
                     piceOfAmount = value / aCount;
                     data.allocation.forEach( alloc =>{
                         alloc.selected = true;
                         var remainingAmount= alloc.caAmount - (alloc.caSumOfCost + alloc.caSumOfReserved + alloc.caSumOfFinancing + alloc.caSumOfCommitment );
                         if( remainingAmount >= piceOfAmount) {
                             alloc.amount = this.$parent.calcDispAmount(piceOfAmount,false);
                             this.reservedAmount += piceOfAmount;
                         }
                         else{
                             alloc.amount = this.$parent.calcDispAmount(remainingAmount,false);
                             this.reservedAmount += remainingAmount;
                         }
                     });
                     this.calculationOfCostCreditEdit(rootData);
                 }
                 if(type == 2){ //allocation level
                     //alert(data);
                 }
                 if(type == 3){ //found level
                     //alert(data);
                 }
            },

            calculationOfCostCreditEdit: function(data){
                var sumOfPlanAmount=0;
                data.ca_credit_source_has_allocation.forEach(cs => {
                    var sumOfAlloc= 0 ;
                    cs.allocation.forEach( alloc =>{
                        sumOfAlloc += this.$parent.calcRealAmount(alloc.amount.split(',').join(''));
                    });
                    cs.amount = this.$parent.calcDispAmount(sumOfAlloc,false);
                    sumOfPlanAmount += this.$parent.calcRealAmount(cs.amount.split(',').join(''));
                });
                data.amount = this.$parent.calcDispAmount(sumOfPlanAmount,false);
                console.log(JSON.stringify(data));
            },

            setTextBoxValueCost: function (rootData,data,type,inputName) {
                this.amountInput[inputName]=this.$parent.calcDispAmount((this.baseAmount - this.reservedAmount),false);
                this.calculationOfCostCredit(rootData,data,type,this.amountInput[inputName]);
            },



}
}
</script>
