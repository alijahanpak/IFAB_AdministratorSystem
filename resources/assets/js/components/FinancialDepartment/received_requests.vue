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
                    <button style="width: 120px;" class="my-button toolbox-btn small dropdown small sm-btn-align"  type="button" data-toggle="insertDropDown">جدید</button>
                    <div  style="width: 120px;" class="dropdown-pane dropdown-pane-sm " data-close-on-click="true"  data-hover="true" data-hover-pane="true"  data-position="bottom" data-alignment="right" id="insertDropDown" data-dropdown data-auto-focus="true">
                        <ul class="my-menu small-font">
                            <li v-for="submissionsTypes in submissionsType" :value="submissionsTypes.id"><a  @click="openSubmissionsModal(submissionsTypes)">{{ submissionsTypes.rtSubject }}</a></li>
                        </ul>
                    </div>
                </div>
                <div class="medium-12 column">
                    <div class="tbl-div-container">
                        <table class="tbl-head">
                            <colgroup>
                                <col width="50px"/>
                                <col width="590px"/>
                                <col width="200px"/>
                                <col width="200px"/>
                                <col width="200px"/>
                                <col width="200px"/>
                                <col width="12px"/>
                            </colgroup>
                            <tbody class="tbl-head-style">
                            <tr class="tbl-head-style-cell">
                                <th class="tbl-head-style-cell">ردیف</th>
                                <th class="tbl-head-style-cell">عنوان</th>
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
                                    <col width="50px"/>
                                    <col width="590px"/>
                                    <col width="200px"/>
                                    <col width="200px"/>
                                    <col width="200px"/>
                                    <col width="200px"/>
                                </colgroup>
                                <tbody class="tbl-head-style-cell">
                                <tr class="table-row" @click="getSubmissionDetail(allSubmissions)" v-for="(allSubmissions,index) in submissions">
                                    <td>{{index+1}}</td>
                                    <td>{{allSubmissions.rSubject}}</td>
                                    <td v-if="allSubmissions.rRtId==1"> خدمات</td>
                                    <td v-else-if="allSubmissions.rRtId==2"> کالا</td>
                                    <td v-else="allSubmissions.rRtId==3"> تنخواه</td>
                                    <td>{{allSubmissions.rCostEstimation.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")}}</td>
                                    <td>{{allSubmissions.rLetterNumber}}</td>
                                    <td>{{allSubmissions.rLetterDate}}</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Submission Buy commodity Modal -->
        <modal-large v-if="showBuyCommodityModal" @close="showBuyCommodityModal = false">
            <div  slot="body">
                <form v-on:submit.prevent="createRequest" >
                    <div class="small-font">
                        <ul class="tabs tab-color my-tab-style" data-responsive-accordion-tabs="tabs medium-accordion large-tabs" id="commodity_tab_view">
                            <li class="tabs-title is-active"><a href="#reciverTab" aria-selected="true">دریافت کنندگان</a></li>
                            <li class="tabs-title"><a href="#commodityTab">فرم درخواست </a></li>
                        </ul>
                        <div class="tabs-content" data-tabs-content="commodity_tab_view">
                            <!--Tab 1-->
                            <div class="tabs-panel is-active table-mrg-btm" id="reciverTab">
                                <div class="grid-x">
                                    <div v-for="recipientsGroup in recipients"  class="large-12 medium-12 small-12">
                                        <div class="grid-x">
                                            <div v-if="recipientsGroup.rstIsRequire == 1" class="large-6 medium-6 small-12">
                                                <label>{{recipientsGroup.category.cSubject}}
                                                    <select class="form-element-margin-btm" :name="'recipient'+recipientsGroup.id" v-validate data-vv-rules="required" :class="{'input': true, 'select-error': errors.has('recipient'+recipientsGroup.id)}">
                                                        <option value=""></option>
                                                        <template v-for="rolCat in recipientsGroup.category.role_category">
                                                            <option v-for="users in rolCat.role.user" @click="getUserRecipients(recipientsGroup.id,users.id)" :value="recipientsGroup.id">{{users.name}} - {{rolCat.role.rSubject}}</option>
                                                        </template>
                                                    </select>
                                                    <span v-show="errors.has('recipient'+recipientsGroup.id)" class="error-font">لطفا فیلد {{recipientsGroup.category.cSubject}}  را انتخاب کنید!</span>
                                                </label>
                                            </div>
                                            <div v-else="recipientsGroup.rstIsRequire==0" class="large-6 medium-6 small-12">
                                                <div class="grid-x">
                                                    <div style="margin-top: 20px;" class="large-12 medium-12  small-12">
                                                        <label> آیا درخواست نیاز به بررسی و تایید {{recipientsGroup.category.cSubject}} دارد؟
                                                            <div class="switch small">
                                                                <input checked="false" v-model="isRequireChangeState" class="switch-input" id="is-require-state" type="checkbox">
                                                                <label class="switch-paddle" for="is-require-state">
                                                                    <span class="switch-active" aria-hidden="true">بلی</span>
                                                                    <span class="switch-inactive" aria-hidden="true">خیر</span>
                                                                </label>
                                                            </div>
                                                        </label>
                                                    </div>
                                                    <div class="large-12 medium-12  small-12">
                                                        <label>{{recipientsGroup.category.cSubject}}
                                                            <select :disabled="!isRequireChangeState" class="form-element-margin-btm"  :name="'recipient'[+recipientsGroup.id]" v-validate data-vv-rules="required" :class="{'input': true, 'select-error': errors.has('\'recipient\'[+recipientsGroup.id]')}">
                                                                <template v-if="isRequireChangeState == true">
                                                                    <option value=""></option>
                                                                    <template v-for="rolCat in recipientsGroup.category.role_category">
                                                                        <option v-for="users in rolCat.role.user" :value="users.id" >{{users.name}} - {{rolCat.role.rSubject}}</option>
                                                                    </template>
                                                                </template>
                                                                <template v-else="isRequireChangeState == false">
                                                                    <option value=""></option>
                                                                </template>
                                                            </select>
                                                            <span v-show="errors.has('\'recipient\'[+recipientsGroup.id]')" class="error-font">لطفا فیلد {{recipientsGroup.category.cSubject}}}  را انتخاب کنید!</span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--Tab 1-->

                            <!--Tab 2-->
                            <div class="tabs-panel table-mrg-btm" id="commodityTab" xmlns:v-on="http://www.w3.org/1999/xhtml">
                                <div style="margin-top: 25px" class="grid-x">
                                    <div class="medium-6">
                                        <label>موضوع
                                            <input class="form-element-margin-btm" type="text" name="requestSubject" v-model="requestInput.rSubject" v-validate="'required'" :class="{'input': true, 'error-border': errors.has('requestSubject')}">
                                        </label>
                                        <span v-show="errors.has('requestSubject')" class="error-font">لطفا موضوع را برای درخواست مورد نظر را وارد نمایید!</span>
                                    </div>
                                    <!--Commodity Start-->
                                    <div  v-show="requestTypeSend == 'BUY_COMMODITY'" style="margin-top: 20px;" class="large-12 medium-12 small-12">
                                        <table class="stack">
                                            <thead>
                                            <tr style="color: #575962;">
                                                <th width="50">ردیف</th>
                                                <th>شرح و نوع جنس</th>
                                                <th width="100">تعداد</th>
                                                <th width="200">مبلغ برآوردی <span class="btn-red small-font">({{costTemp}})</span></th>
                                                <th>توضیحات (موارد مصرف)</th>
                                                <th>عملیات</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr v-for="(commodityRequests,index) in commodityRequest">
                                                <td>{{index+1}}</td>
                                                <td>{{commodityRequests.commodityName}}</td>
                                                <td>{{commodityRequests.commodityCount}}</td>
                                                <td>{{commodityRequests.commodityPrice}}</td>
                                                <td>{{commodityRequests.commodityDescription}}</td>
                                                <td class="text-center"><a @click="deleteCommodityItem(index)"><i class="far fa-trash-alt btn-red size-18"></i></a></td>
                                            </tr>
                                            <tr>
                                                <td></td>
                                                <td>
                                                    <suggestions style="margin-bottom: -18px;" name="commodityTitle" v-validate :class="{'input': true, 'select-error': errors.has('commodityTitle')}"
                                                                 v-model="commodityQuery"
                                                                 :options="commodityOptions"
                                                                 :onInputChange="onCommodityInputChange">
                                                        <div slot="item" slot-scope="props" class="single-item">
                                                            <strong>{{props.item}}</strong>
                                                        </div>
                                                    </suggestions>
                                                </td>
                                                <td>
                                                    <input id="number" v-model="commodityItem.commodityCount" class="text-margin-btm" type="number" value="1">
                                                </td>
                                                <td>
                                                    <money v-model="commodityItem.commodityPrice"  v-bind="money" class="form-input input-lg text-margin-btm"  v-validate="'required'" :class="{'input': true, 'error-border': errors.has('price')}"></money>
                                                </td>
                                                <td>
                                                    <input v-model="commodityItem.commodityDescription" class="text-margin-btm" type="text">
                                                </td>
                                                <td class="text-center"><a v-if="commodityQuery != '' && commodityItem.commodityCount != '' && commodityItem.commodityPrice" @click="addCommodityItem()"><i class="fas fa-check btn-green size-18"></i></a></td>
                                            </tr>
                                            <tr>
                                                <td colspan="4" class="text-center font-wei-bold"> مجموع برآورد</td>
                                                <td colspan="2" class="text-center font-wei-bold">{{sumOfCommodityPrice.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")}} <span class="btn-red">{{  costTemp  }}</span> </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <!--Commodity End-->

                                    <!--Service Start-->
                                    <div v-show="requestTypeSend == 'BUY_SERVICES'" class="large-12 medium-12 small-12">
                                        <div class="grid-x">
                                            <div class="large-4 medium-4 small-12">
                                                <label>برآورد تقریبی اعتبار مورد نیاز <span class="btn-red">({{costTemp}})</span>
                                                    <money v-model="requestInput.serviceEstimated"  v-bind="money" class="form-input input-lg text-margin-btm"  v-validate="'required'" :class="{'input': true, 'error-border': errors.has('serviceEstimated')}"></money>
                                                </label>
                                                <span v-show="errors.has('serviceEstimated')" class="error-font">لطفا مبلغ تقریبی را برای درخواست مورد نظر را وارد نمایید!</span>
                                            </div>
                                            <div class="large-12 medium-12 small-12">
                                                <label>شرح کامل خدمات
                                                    <textarea v-if="requestTypeSend == 'BUY_SERVICES'" class="form-element-margin-btm"  style="min-height: 150px;" name="fullDescription" v-model="requestInput.fullDescription"  v-validate="'required'" :class="{'input': true, 'error-border': errors.has('fullDescription')}"></textarea>
                                                    <textarea v-else="" class="form-element-margin-btm"  style="min-height: 150px;" name="fullDescription" v-model="requestInput.fullDescription"   :class="{'input': true, 'error-border': errors.has('fullDescription')}"></textarea>
                                                    <span v-show="errors.has('fullDescription')" class="error-font">لطفا شرح کامل خدمات را وارد کنید!</span>
                                                </label>
                                            </div>
                                            <div class="large-12 medium-12 small-12">
                                                <label>توضیحات تکمیلی
                                                    <textarea v-if="requestTypeSend == 'BUY_SERVICES'" class="form-element-margin-btm"  style="min-height: 150px;" name="furtherDescription" v-model="requestInput.furtherDescription"  v-validate="'required'" :class="{'input': true, 'error-border': errors.has('furtherDescription')}"></textarea>
                                                    <textarea v-else="" class="form-element-margin-btm"  style="min-height: 150px;" name="furtherDescription" v-model="requestInput.furtherDescription"  :class="{'input': true, 'error-border': errors.has('furtherDescription')}"></textarea>
                                                    <span v-show="errors.has('furtherDescription')" class="error-font">لطفا شرح کامل خدمات را وارد کنید!</span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <!--Service End-->

                                    <!--Fund Start-->
                                    <div v-show="requestTypeSend == 'FUND'" class="large-12 medium-12 small-12">
                                        <div class="grid-x">
                                            <div class="large-4 medium-4 small-12">
                                                <label> مبلغ تنخواه <span class="btn-red">({{costTemp}})</span>
                                                    <money v-model="requestInput.fundEstimated"  v-bind="money" class="form-input input-lg text-margin-btm"  v-validate="'required'" :class="{'input': true, 'error-border': errors.has('fundEstimated')}"></money>
                                                </label>
                                                <span v-show="errors.has('fundEstimated')" class="error-font">لطفا مبلغ تنخواه را برای درخواست مورد نظر را وارد نمایید!</span>
                                            </div>
                                            <div class="large-12 medium-12 small-12">
                                                <label>متن درخواست
                                                    <textarea v-if="requestTypeSend == 'FUND'" class="form-element-margin-btm"  style="min-height: 150px;" name="requestText" v-model="requestInput.fullDescription"  v-validate="'required'" :class="{'input': true, 'error-border': errors.has('fullDescription')}"></textarea>
                                                    <textarea v-else="" class="form-element-margin-btm"  style="min-height: 150px;" name="requestText" v-model="requestInput.fullDescription" :class="{'input': true, 'error-border': errors.has('fullDescription')}"></textarea>
                                                    <span v-show="errors.has('fullDescription')" class="error-font">لطفا شرح کامل خدمات را وارد کنید!</span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <!--Fund End-->
                                </div>
                            </div>
                            <!--Tab 2-->
                            <div class="large-12 medium-12 small-12 padding-lr padding-bottom-modal medium-top-m">
                                <button type="submit" class="my-button my-success float-left btn-for-load"><span class="btn-txt-mrg">  ثبت</span></button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </modal-large>
        <!-- Submission Buy  Modal -->

        <!-- Submission Detail Modal -->
        <modal-large v-if="showSubmissionDeatilModal" @close="showSubmissionDeatilModal = false">
            <div  slot="body">
                <div class="small-font">
                    <div class="grid-x">
                        <div v-show="requestTypeDetail == 'SERVICES'" class="large-12 medium-12 small-12">
                            <ul class="tabs tab-color my-tab-style" data-responsive-accordion-tabs="tabs medium-accordion large-tabs" id="service_tab_view">
                                <li class="tabs-title is-active"><a href="#serviceDetailTab" aria-selected="true">جزییات درخواست</a></li>
                                <li class="tabs-title"><a href="#serviceHistoryTab">تاریخچه درخواست </a></li>
                            </ul>
                            <div class="tabs-content" data-tabs-content="service_tab_view">
                                <!--Tab 1-->
                                <div class="tabs-panel is-active table-mrg-btm" id="serviceDetailTab">
                                    <div class="grid-x">
                                        <div class="large-12 medium-12 small-12">
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
                                                    <td>{{requestFill.rCostEstimation.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")}} <span class="btn-red">  {{costTemp}}  </span></td>
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
                                    </div>
                                </div>
                                <!--Tab 1-->
                                <!--Tab 2-->
                                <div class="tabs-panel table-mrg-btm" id="serviceHistoryTab" xmlns:v-on="http://www.w3.org/1999/xhtml">
                                    <div v-for="recipientUser in recipientUsers" class="grid-x timeline">
                                        <div class="large-12 medium-12 small-12 timeline-item">
                                            <div class="grid-x">
                                                <div class="large-4 medium-2 small-12">

                                                </div>
                                                <div class="large-8 medium-10 small-12 timeline-content timeline-icon">
                                                    <img class="profile-image-cover-index profile-image-cover-pos" :src="imgDataUrl">
                                                </div>
                                                <div class="large-8 medium-10 small-12 timeline-content">
                                                    <div class="grid-x">
                                                        <div class="large-12 medium-12 small-12 timeline-content-header">
                                                            <p>{{recipientUser.destination_user_info.name}}</p>
                                                            <p style="margin-top:-10px;" class="small-font">{{recipientUser.destination_user_info.role.rSubject}}</p>
                                                            <span style="text-align: left" class="timeline-state gray-color">{{recipientUser.request_state.rsSubject}}</span>
                                                        </div>
                                                        <div class="large-12 medium-12 small-12">
                                                            <p class="small-top-m text-justify">
                                                                {{recipientUser.rhDescription}}
                                                            </p>
                                                            <p style="direction: ltr;" class="gray-color small-font"><i class="far fa-calendar-alt"></i><span> {{recipientUser.created_at}} </span> - <i class="far fa-clock"></i> <span>{{recipientUser.created_at}}</span></p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--Tab 2-->
                            </div>
                        </div>
                        <div v-show="requestTypeDetail == 'COMMODITY'" class="large-12 medium-12 small-12">
                            <ul class="tabs tab-color my-tab-style" data-responsive-accordion-tabs="tabs medium-accordion large-tabs" id="commodity_tab_view">
                                <li class="tabs-title is-active"><a href="#commodityDetailTab" aria-selected="true">جزییات درخواست</a></li>
                                <li class="tabs-title"><a href="#commodityHistoryTab">تاریخچه درخواست </a></li>
                            </ul>
                            <div class="tabs-content" data-tabs-content="commodity_tab_view">
                                <!--Tab 1-->
                                <div class="tabs-panel is-active table-mrg-btm" id="commodityDetailTab">
                                    <div class="grid-x">
                                        <div class="large-12 medium-12 small-12">
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
                                                <th width="200">مبلغ برآوردی <span class="btn-red small-font">({{costTemp}})</span></th>
                                                <th>توضیحات (موارد مصرف)</th>
                                                </thead>
                                                <tbody>
                                                <tr v-for="(lists,index) in commodityList">
                                                    <td>{{index+1}}</td>
                                                    <td>{{lists.commodity.cSubject}}</td>
                                                    <td>{{lists.rcCount}}</td>
                                                    <td>{{lists.rcCostEstimation.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")}}</td>
                                                    <td>{{lists.rcDescription}}</td>
                                                </tr>
                                                <tr>
                                                    <td colspan="4" class="text-center font-wei-bold"> مجموع برآورد</td>
                                                    <td colspan="2" class="text-center font-wei-bold">{{requestFill.rCostEstimation.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")}} <span class="btn-red">{{  costTemp  }}</span> </td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <!--Tab 1-->
                                <!--Tab 2-->
                                <div class="tabs-panel table-mrg-btm" id="commodityHistoryTab" xmlns:v-on="http://www.w3.org/1999/xhtml">
                                    <div v-for="recipientUser in recipientUsers" class="grid-x timeline">
                                        <div class="large-12 medium-12 small-12 timeline-item">
                                            <div class="grid-x">
                                                <div class="large-4 medium-2 small-12">

                                                </div>
                                                <div class="large-8 medium-10 small-12 timeline-content timeline-icon">
                                                    <img class="profile-image-cover-index profile-image-cover-pos" :src="imgDataUrl">
                                                </div>
                                                <div class="large-8 medium-10 small-12 timeline-content">
                                                    <div class="grid-x">
                                                        <div class="large-12 medium-12 small-12 timeline-content-header">
                                                            <p>{{recipientUser.destination_user_info.name}}</p>
                                                            <p style="margin-top:-10px;" class="small-font">{{recipientUser.destination_user_info.role.rSubject}}</p>
                                                            <span style="text-align: left" class="timeline-state gray-color">{{recipientUser.request_state.rsSubject}}</span>
                                                        </div>
                                                        <div class="large-12 medium-12 small-12">
                                                            <p class="small-top-m text-justify">
                                                                {{recipientUser.rhDescription}}
                                                            </p>
                                                            <p style="direction: ltr;" class="gray-color small-font"><i class="far fa-calendar-alt"></i><span> {{recipientUser.created_at}} </span> - <i class="far fa-clock"></i> <span>{{recipientUser.created_at}}</span></p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--Tab 2-->
                            </div>
                        </div>
                        <div v-show="requestTypeDetail == 'FUND'" class="large-12 medium-12 small-12">
                            <ul class="tabs tab-color my-tab-style" data-responsive-accordion-tabs="tabs medium-accordion large-tabs" id="fund_tab_view">
                                <li class="tabs-title is-active"><a href="#fundDetailTab" aria-selected="true">جزییات درخواست</a></li>
                                <li class="tabs-title"><a href="#fundHistoryTab">تاریخچه درخواست </a></li>
                            </ul>
                            <div class="tabs-content" data-tabs-content="fund_tab_view">
                                <!--Tab 1-->
                                <div class="tabs-panel is-active table-mrg-btm" id="fundDetailTab">
                                    <div class="grid-x">
                                        <div class="large-12 medium-12 small-12">
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
                                                    <td>{{requestFill.rCostEstimation.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")}} <span class="btn-red">  {{costTemp}}  </span></td>
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
                                <div class="tabs-panel table-mrg-btm" id="fundHistoryTab" xmlns:v-on="http://www.w3.org/1999/xhtml">
                                    <div v-for="recipientUser in recipientUsers" class="grid-x timeline">
                                        <div class="large-12 medium-12 small-12 timeline-item">
                                            <div class="grid-x">
                                                <div class="large-4 medium-2 small-12">

                                                </div>
                                                <div class="large-8 medium-10 small-12 timeline-content timeline-icon">
                                                    <img class="profile-image-cover-index profile-image-cover-pos" :src="imgDataUrl">
                                                </div>
                                                <div class="large-8 medium-10 small-12 timeline-content">
                                                    <div class="grid-x">
                                                        <div class="large-12 medium-12 small-12 timeline-content-header">
                                                            <p>{{recipientUser.destination_user_info.name}}</p>
                                                            <p style="margin-top:-10px;" class="small-font">{{recipientUser.destination_user_info.role.rSubject}}</p>
                                                            <span style="text-align: left" class="timeline-state gray-color">{{recipientUser.request_state.rsSubject}}</span>
                                                        </div>
                                                        <div class="large-12 medium-12 small-12">
                                                            <p class="small-top-m text-justify">
                                                                {{recipientUser.rhDescription}}
                                                            </p>
                                                            <p style="direction: ltr;" class="gray-color small-font"><i class="far fa-calendar-alt"></i><span> {{recipientUser.created_at}} </span> - <i class="far fa-clock"></i> <span>{{recipientUser.created_at}}</span></p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--Tab 2-->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </modal-large>
        <!-- Submission Detail Modal -->
    </div>
</template>

<script>
    import Suggestions from "v-suggestions/src/Suggestions";
    export default {
        components: {Suggestions},
        "vue-select": require("vue-select"),
        data () {
            return {
                receiveRequests:[]



            }
        },

        created: function(){
            this.fetchData();
        },

        updated: function () {
            $(this.$el).foundation(); //WORKS!
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


    }
}
</script>
