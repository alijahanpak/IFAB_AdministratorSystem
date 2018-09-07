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
                                <span class="show-for-sr">Current: </span>درخواست های ارسالی
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
                    <div class="tbl-div-container">
                        <table class="tbl-head">
                            <colgroup>
                                <col width="590px"/>
                                <col width="200px"/>
                                <col width="200px"/>
                                <col width="200px"/>
                                <col width="200px"/>
                                <col width="12px"/>
                            </colgroup>
                            <tbody class="tbl-head-style">
                            <tr class="tbl-head-style-cell">
                                <th class="tbl-head-style-cell">عنوان</th>
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
                                    <col width="590px"/>
                                    <col width="200px"/>
                                    <col width="200px"/>
                                    <col width="200px"/>
                                    <col width="200px"/>
                                </colgroup>
                                <tbody class="tbl-head-style-cell">
                                <tr class="table-row" @click="getSubmissionDetail(allSubmissions)" v-for="allSubmissions in submissions">
                                    <td>{{allSubmissions.rSubject}}</td>
                                    <td>{{allSubmissions.request_type.rtSubject}}</td>
                                    <td>{{ $parent.dispMoneyFormat(allSubmissions.rCostEstimation) }}</td>
                                    <td>{{allSubmissions.rLetterNumber}}</td>
                                    <td>{{allSubmissions.rLetterDate}}</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="grid-x">
                        <div class="medium-12">
                            <vue-pagination  v-bind:pagination="posted_pagination"
                                             v-on:click.native="fetchData(posted_pagination.current_page)"
                                             :offset="4">
                            </vue-pagination>
                        </div>
                    </div>
                </div>
        </div>
        <!-- Submission Buy Modal -->
        <modal-large v-if="showBuyCommodityModal" @close="showBuyCommodityModal = false">
            <div  slot="body">
                <form v-on:submit.prevent="createRequest" >
                    <div class="small-font">
                        <ul class="tabs tab-color my-tab-style" data-responsive-accordion-tabs="tabs medium-accordion large-tabs" id="commodity_tab_view">
                            <li class="tabs-title is-active"><a href="#reciverTab" aria-selected="true">دریافت کنندگان</a></li>
                            <li class="tabs-title"><a href="#commodityTab">فرم درخواست </a></li>
                            <li class="tabs-title"><a href="#attachmentTab">پیوست ها </a></li>
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
                                                                <input v-on:change="dropUserRecipients(recipientsGroup.id,isRequireChangeState)" checked="false" v-model="isRequireChangeState" class="switch-input" id="is-require-state" type="checkbox">
                                                                <label class="switch-paddle" for="is-require-state">
                                                                    <span class="switch-active" aria-hidden="true">بلی</span>
                                                                    <span class="switch-inactive" aria-hidden="true">خیر</span>
                                                                </label>
                                                            </div>
                                                        </label>
                                                    </div>
                                                    <div class="large-12 medium-12  small-12">
                                                        <label>{{recipientsGroup.category.cSubject}}
                                                            <select  :disabled="!isRequireChangeState" class="form-element-margin-btm"  :name="'recipient'+recipientsGroup.id" v-validate data-vv-rules="required" :class="{'input': true, 'select-error': errors.has('recipient'+recipientsGroup.id)}">
                                                                <template v-if="isRequireChangeState == true">
                                                                    <option value=""></option>
                                                                    <template v-for="rolCat in recipientsGroup.category.role_category">
                                                                        <option v-for="users in rolCat.role.user" @click="getUserRecipients(recipientsGroup.id,users.id)" :value="recipientsGroup.id">{{users.name}} - {{rolCat.role.rSubject}}</option>
                                                                    </template>
                                                                </template>
                                                                <template v-if="isRequireChangeState == false">
                                                                    <option value=""></option>
                                                                </template>
                                                            </select>
                                                            <span v-show="errors.has('recipient'+recipientsGroup.id)" class="error-font">لطفا فیلد {{recipientsGroup.category.cSubject}}  را انتخاب کنید!</span>
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
                                                <th width="200">مبلغ برآوردی <span class="btn-red small-font">(ریال)</span></th>
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
                                                <td colspan="2" class="text-center font-wei-bold">{{$parent.dispMoneyFormat(sumOfCommodityPrice)}} <span class="btn-red">{{  'ریال'  }}</span> </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <!--Commodity End-->

                                    <!--Service Start-->
                                    <div v-show="requestTypeSend == 'BUY_SERVICES'" class="large-12 medium-12 small-12">
                                        <div class="grid-x">
                                            <div class="large-4 medium-4 small-12">
                                                <label>برآورد تقریبی اعتبار مورد نیاز <span class="btn-red">(ریال)</span>
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
                                                    <textarea class="form-element-margin-btm"  style="min-height: 150px;" name="furtherDescription" v-model="requestInput.furtherDescription"></textarea>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <!--Service End-->

                                    <!--Fund Start-->
                                    <div v-show="requestTypeSend == 'FUND'" class="large-12 medium-12 small-12">
                                        <div class="grid-x">
                                            <div class="large-4 medium-4 small-12">
                                                <label> مبلغ تنخواه <span class="btn-red">(ریال)</span>
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

                            <!--Tab 3 - Attachment Tab-->
                            <div class="tabs-panel table-mrg-btm" id="attachmentTab" xmlns:v-on="http://www.w3.org/1999/xhtml">
                                <div style="margin-top: 25px" class="grid-x">
                                    <div class="medium-12">
                                        <div class="grid-x container-mrg-top">
                                            <div class="medium-12 padding-lr">
                                                <label class="my-button my-brand"> انتخاب فایل
                                                    <input @change="uploadFieldChange" accept=".jpg,.jpeg,.png,.doc,.docx,.doc,.xls,.xlsx,.pdf" id="File" type="file">
                                                </label>
                                                <br><br>
                                            </div>
                                            <div class="medium-12">
                                                <div class="grid-x">
                                                    <div style="margin-top: 15px;margin-bottom: 15px;" v-for="(attachment, index) in attachments" class="large-3 medium-4 small-12 padding-lr">
                                                        <div class="format-card">
                                                            <a style="margin-right: 8px;margin-top:8px;" class="dropdown small sm-btn-align"  type="button" :data-toggle="'attachment' + index"><i class="fa fa-ellipsis-v size-18"></i></a>
                                                            <div class="dropdown-pane dropdown-pane-sm " data-close-on-click="true"  data-hover="true" data-hover-pane="true"  data-position="bottom" data-alignment="right" :id="'attachment' + index" data-dropdown data-auto-focus="true">
                                                                <ul class="my-menu small-font text-right">
                                                                    <li><a @click="removeAttachment(index)"><i class="fa fa-trash-o size-16"></i>  حذف</a></li>
                                                                </ul>
                                                            </div>
                                                            <div style="padding:15px;" class="text-center">
                                                                <i v-if="attachment.name.split('.').pop().toLowerCase() == 'pdf'" class="fas fa-file-pdf size-72 btn-red"></i>
                                                                <i v-if="attachment.name.split('.').pop().toLowerCase() == 'jpg' || attachment.name.split('.').pop().toLowerCase() == 'jpeg' || attachment.name.split('.').pop().toLowerCase() == 'png'" class="fas fa-file-image size-72 purple-color"></i>
                                                                <i v-if="attachment.name.split('.').pop().toLowerCase() == 'doc' || attachment.name.split('.').pop().toLowerCase() == 'docx'" class="fas fa-file-word size-72 blue-color"></i>
                                                                <i v-if="attachment.name.split('.').pop().toLowerCase() == 'xls' || attachment.name.split('.').pop().toLowerCase() == 'xlsx'" class="fas fa-file-excel size-72 btn-green"></i>
                                                                <h3 style="margin-top:10px;" class="gray-colors">{{attachment.name.split('.').pop().toUpperCase()}}</h3>
                                                            </div>
                                                            <div class="format-container direction-ltr">
                                                                <p style="height:50px" class="small-top-m gray-color"><b>{{attachment.name}}</b></p>
                                                                <p class="gray-color small-top-m">{{  Number((attachment.size / 1000).toFixed(1)) + ' کیلوبایت'}}</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!--            <button class="my-button my-brand" v-on:click.prevent="submit">بارگذاری</button>-->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--Tab 3 - Attachment Tab-->

                            <div class="large-12 medium-12 small-12 padding-lr padding-bottom-modal medium-top-m">
                                <button type="submit"  class="my-button my-success float-left btn-for-load"><span class="btn-txt-mrg">  ثبت</span></button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </modal-large>
        <!-- Submission Buy Modal -->

        <!-- Submission Detail Modal -->
        <modal-large v-if="showSubmissionDeatilModal" @close="showSubmissionDeatilModal = false">
            <div  slot="body">
                <div class="small-font">
                    <div class="grid-x">
                        <div class="large-12 medium-12 small-12">
                            <ul class="tabs tab-color my-tab-style" data-responsive-accordion-tabs="tabs medium-accordion large-tabs" id="request_tab_view">
                                <li class="tabs-title is-active"><a href="#requestDetailTab" aria-selected="true">جزییات</a></li>
                                <li class="tabs-title"><a href="#requestVerifiersTab">تایید کنندگان </a></li>
                                <li class="tabs-title"><a href="#requestHistoryTab">تاریخچه </a></li>
                                <li class="tabs-title"><a href="#requestAttachmentsTab">پیوست </a></li>
                            </ul>
                            <div class="tabs-content" data-tabs-content="request_tab_view">
                                <!--Tab 1-->
                                <div class="tabs-panel is-active table-mrg-btm" id="requestDetailTab">
                                    <div class="grid-x">
                                        <div v-if="requestTypeDetail == 'SERVICES'" class="large-12 medium-12 small-12">
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

                                        <div v-if="requestTypeDetail == 'COMMODITY'" class="large-12 medium-12 small-12">
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
                                                <th width="150">موجود در انبار</th>
                                                <th width="200">مبلغ برآوردی <span class="btn-red small-font">(ریال)</span></th>
                                                <th>توضیحات (موارد مصرف)</th>
                                                </thead>
                                                <tbody>
                                                <tr v-for="(lists,index) in commodityList">
                                                    <td>{{index+1}}</td>
                                                    <td>{{lists.commodity.cSubject}}</td>
                                                    <td>{{lists.rcCount}}</td>
                                                    <td>{{lists.rcExistCount}}</td>
                                                    <td>{{$parent.dispMoneyFormat(lists.rcCostEstimation)}}</td>
                                                    <td>{{lists.rcDescription}}</td>
                                                </tr>
                                                <tr>
                                                    <td colspan="4" class="text-center font-wei-bold"> مجموع برآورد</td>
                                                    <td colspan="2" class="text-center font-wei-bold">{{$parent.dispMoneyFormat(requestFill.rCostEstimation)}} <span class="btn-red">{{  'ریال'  }}</span> </td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>

                                        <div v-if="requestTypeDetail == 'FUND'" class="large-12 medium-12 small-12">
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
                                                                            <img style="width: 40px;height: 40px;margin-top: 10px;margin-bottom: 10px;" class="profile-image-cover-index profile-image-cover-pos" :src="(recipientUser.destination_user_info != null && recipientUser.destination_user_info.avatarPath != null) ? baseURL + recipientUser.destination_user_info.avatarPath : $parent.baseAvatar">
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
                                <!--Tab 3-->

                                <!--Tab 4-->
                                <div class="tabs-panel table-mrg-btm" id="requestAttachmentsTab" xmlns:v-on="http://www.w3.org/1999/xhtml">
                                    <div class="grid-x medium-top-m">
                                        <div style="margin-top: 15px;margin-bottom: 15px;" v-for="attachment in attachments" class="large-3 medium-4 small-12 padding-lr">
                                            <a  v-bind:href="attachment.aPath" target="_blank">
                                                <div class="format-card">
                                                    <div style="padding:15px;" class="text-center">
                                                        <i v-if="attachment.aPath.split('.').pop().toLowerCase() == 'pdf'" class="fas fa-file-pdf size-72 btn-red"></i>
                                                        <i v-if="attachment.aPath.split('.').pop().toLowerCase() == 'jpg' || attachment.aPath.split('.').pop().toLowerCase() == 'jpeg' || attachment.aPath.split('.').pop().toLowerCase() == 'png'" class="fas fa-file-image size-72 purple-color"></i>
                                                        <i v-if="attachment.aPath.split('.').pop().toLowerCase() == 'doc' || attachment.aPath.split('.').pop().toLowerCase() == 'docx'" class="fas fa-file-word size-72 blue-color"></i>
                                                        <i v-if="attachment.aPath.split('.').pop().toLowerCase() == 'xls' || attachment.aPath.split('.').pop().toLowerCase() == 'xlsx'" class="fas fa-file-excel size-72 btn-green"></i>
                                                        <h3 style="margin-top:10px;" class="gray-colors">{{attachment.aPath.split('.').pop().toUpperCase()}}</h3>
                                                    </div>
                                                    <div class="format-container direction-ltr">
                                                        <p style="height: 50px;" class="small-top-m gray-color"><b>{{attachment.aName}}</b></p>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <!--Tab 4-->

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
    import VuePagination from '../../public_component/pagination.vue';
    export default {
        components: {
            Suggestions,
            "vue-select": require("vue-select"),
            'vue-pagination' : VuePagination,
        },
        data () {
            return {
                imgUrl: [],
                attachments: [],
                extension:[],
                // Each file will need to be sent as FormData element
                data: new FormData(),
                percentCompleted: 0, // You can store upload progress 0-100 in value, and show it on the screen
                submissionsType:{},
                submissions:[],
                commodity:[],
                recipients:[],
                requestInput:{},
                requestFill:{},
                showBuyCommodityModal:false,
                showSubmissionDeatilModal:false,
                //commodity input text
                commodityQuery: '',
                commodityList: [],
                selectedCommodity: null,
                commodityOptions: {},
                //commodity input text
                money: {
                    thousands: ',',
                    precision: 0,
                    masked: true
                },
                commodityItem:{},
                commodityRequest:[],
                sumOfCommodityPrice:0,
                convertCommodityPrice:'',
                requestTypeSend:'',
                requestTypeDetail:'',
                requestTypeId:'',
                recipientUsers:[],
                recipientUsersTemp:[],
                isRequireChangeState:false,
                verifiers:[],
                baseURL:window.hostname+'/',
                submitBtnState:true,
                updateDataThreadNowPlaying:null,
                posted_pagination: {
                    total: 0,
                    to: 0,
                    current_page: 1,
                    last_page: ''
                },


            }
        },

        created: function(){
            this.fetchData();
            this.fetchSubmissionsType();
            this.setUpdateDataThread();
        },

        updated: function () {
            $(this.$el).foundation(); //WORKS!
            //this.costTemp =  '  ' + this.$parent.getDispAmountBaseLabel();
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
                this.posted_pagination.current_page = data.current_page;
                this.posted_pagination.to = data.to;
                this.posted_pagination.last_page = data.last_page;
            },

            setUpdateDataThread: function () {
                console.log("...................................................... set posted request update thread");
                if (this.updateDataThreadNowPlaying)
                    clearInterval(this.updateDataThreadNowPlaying);
                this.updateDataThreadNowPlaying = setInterval(this.updateDataThread, 60000);
            },

            updateDataThread: function () {
                console.log("...................................................... posted request update thread");
                this.fetchData();
            },

            fetchData: function (page=1) {
                axios.get('/financial/request/posted/fetchData?page=' + page)
                    .then((response) => {
                        this.submissions = response.data.data;
                        this.makePagination(response.data);
                        console.log(response);
                    }, (error) => {
                        console.log(error);
                    });
            },

            fetchSubmissionsType: function () {
                axios.get('/financial/request/types/fetchData')
                    .then((response) => {
                        this.submissionsType = response.data;
                        console.log(response);
                    }, (error) => {
                        console.log(error);
                    });
            },

            fetchRecipientsGroup: function () {
                axios.get('/financial/request/steps/fetchData', {params:{requestType:this.requestTypeSend}})
                    .then((response) => {
                        this.recipients = response.data;

                        /*this.recipients.forEach(rec=> {
                            rec.category.role_category.forEach(role_category =>{
                                role_category.role.user.forEach(user=>{
                                    this.recipientsUsers.push(user.id);
                                });
                            });
                        });

                        console.log(JSON.stringify(this.recipientsUsers));*/
                        console.log(response);
                    }, (error) => {
                        console.log(error);
                    });
            },

            /*-----------------------------------------------------------------------------
            ------------------ Commodity search Item Start ------------------------------
            -----------------------------------------------------------------------------*/
            fetchCommodity: function () {
                axios.get('/financial/commodity/fetchData')
                    .then((response) => {
                        this.commodity = response.data;
                        this.commodityList= [];
                        this.commodity.forEach(subject=> {
                            this.commodityList.push(subject.cSubject)
                        });
                        console.log(response);
                    }, (error) => {
                        console.log(error);
                    });
            },

            onCommodityInputChange(commodityQuery) {
                if (commodityQuery.trim().length === 0) {
                    return null
                }
                // return the matching countries as an array
                return this.commodityList.filter((commodityes) => {
                    return commodityes.toLowerCase().includes(commodityQuery.toLowerCase())
                })
            },
            onCommoditySelected(item) {
                this.selectedCommodity = item
            },
            onSearchItemSelected(item) {
                this.selectedSearchItem = item
            },

            /*-----------------------------------------------------------------------------
            ------------------ Commodity search Item End ------------------------------
            -----------------------------------------------------------------------------*/

            openSubmissionsModal: function (st) {
                this.submitBtnState=true;
                this.requestInput={};
                this.commodityList=[];
                this.commodityRequest=[];
                this.isRequireChangeState=false;
                this.requestTypeSend=st.rtType;
                this.requestTypeId=st.id;
                this.recipientUsersTemp=[];
                this.verifiers=[];
                this.recipientUsers=[];
                this.attachments=[];
                this.fetchRecipientsGroup();

                this.showBuyCommodityModal=true;
                this.fetchCommodity();
                this.sumOfCommodityPrice=0;

            },

            addCommodityItem: function () {
                this.commodityItem.commodityName=this.commodityQuery;
                this.commodityRequest.push(this.commodityItem);
                console.log(JSON.stringify(this.commodityRequest));
                this.commodityQuery='';
                var temp;
                temp=this.commodityItem.commodityPrice.split(',').join('');
                this.sumOfCommodityPrice += parseInt(temp,10);
                this.commodityItem={};
                if(this.commodityRequest.length >= 0){
                    this.btnState=false;
                }

            },

            deleteCommodityItem: function (index) {
                var arrayTemp=[];
                arrayTemp=this.commodityRequest[index];
                //arrayTemp.commodityPrice.replace(',','');
                this.sumOfCommodityPrice-=parseInt(arrayTemp.commodityPrice.split(',').join(''),10);
                this.commodityRequest.splice(index,1);
            },

            createRequest: function () {
                this.$validator.validateAll().then((result) => {
                    if (result) {
                        var config = {
                            headers: {'Content-Type': 'multipart/form-data'},
                            onUploadProgress: function (progressEvent) {
                                this.percentCompleted = Math.round((progressEvent.loaded * 100) / progressEvent.total);
                                this.$forceUpdate();
                            }.bind(this)
                        };

                        this.recipients.forEach(item => {
                            if(this.recipientUsersTemp[item.id] != null){
                                var recipientUsersInput={};
                                recipientUsersInput.stepId=item.id;
                                recipientUsersInput.userId=this.recipientUsersTemp[item.id];
                                this.recipientUsers.push(recipientUsersInput);
                                console.log(JSON.stringify(this.recipientUsers))
                            }
                            });
                            if(this.requestTypeSend == 'BUY_SERVICES'){
                                this.sumOfCommodityPrice=this.requestInput.serviceEstimated.split(',').join('');

                            }
                            if(this.requestTypeSend == 'FUND'){
                                this.sumOfCommodityPrice=this.requestInput.fundEstimated.split(',').join('');


                            }
                            this.prepareFields();
                            this.data.append('subject', this.requestInput.rSubject );
                            this.data.append('rtId', this.requestTypeId );
                            this.data.append('costEstimation', this.sumOfCommodityPrice);
                            this.data.append('description', this.requestInput.fullDescription);
                            this.data.append('furtherDetails', this.requestInput.furtherDescription);
                            if(this.requestTypeSend == 'BUY_COMMODITY'){
                                this.commodityRequest.forEach ((items,index) => {
                                    this.data.append('items['+index+'][subject]', items.commodityName );
                                    this.data.append('items['+index+'][count]', items.commodityCount );
                                    this.data.append('items['+index+'][costEstimation]', items.commodityPrice.split(',').join(''));
                                    this.data.append('items['+index+'][description]', items.commodityDescription == undefined ? '' :  items.commodityDescription );
                                });
                            }
                            else {
                                this.data.append('items',null);
                            }
                            this.recipientUsers.forEach((user,index) => {
                                this.data.append('verifiers['+index+'][rstId]', user.stepId );
                                this.data.append('verifiers['+index+'][uId]', user.userId );
                            });


                            axios.post('/financial/request/register', this.data , config).then((response) => {
                                this.submissions = response.data.data;
                                this.makePagination(response.data);
                                this.showBuyCommodityModal = false;
                                this.$parent.displayNotif(response.status);
                                console.log(response);
                                this.resetData();
                            }, (error) => {
                                console.log(error);
                                this.$parent.displayNotif(error.response.status);
                                this.data = new FormData();
                            });


                        }
                    });

                },

            getUserRecipients:function (stepId,userId) {
                this.recipientUsersTemp[stepId]=userId;
                console.log(JSON.stringify(this.recipientUsersTemp));
             },

            dropUserRecipients:function (stepId) {
                if(this.isRequireChangeState == false){
                    this.recipientUsersTemp[stepId]= null;
                    console.log(JSON.stringify(this.recipientUsersTemp));
                }
                else{
                    console.log(JSON.stringify(this.recipientUsersTemp));
                }
             },


            getSubmissionDetail: function (submission) {
                this.showSubmissionDeatilModal=true;
                this.recipientUsers=[];
                this.verifiers=[];
                this.attachments=[];
                var requestHistory=[];
                requestHistory.push(submission);
                console.log(JSON.stringify(requestHistory));
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

                requestHistory.forEach(attach => {
                    attach.attachment.forEach(item => {
                        this.attachments.push(item);
                    });
                });

                if (submission.rRtId == 1){
                    this.requestTypeDetail='SERVICES';
                    this.requestFill.rLetterNumber=submission.rLetterNumber;
                    this.requestFill.rLetterDate=submission.rLetterDate
                    this.requestFill.rSubject=submission.rSubject;
                    this.requestFill.rCostEstimation=submission.rCostEstimation;
                    this.requestFill.rDescription=submission.rDescription;
                    this.requestFill.rFurtherDetails=submission.rFurtherDetails;
                }
                else if (submission.rRtId == 2){
                    var commodityTemp=[];
                    commodityTemp.push(submission);
                    this.commodityList=[];
                    this.requestTypeDetail='COMMODITY';
                    this.requestFill.rLetterNumber=submission.rLetterNumber;
                    this.requestFill.rLetterDate=submission.rLetterDate;
                    this.requestFill.rSubject=submission.rSubject;
                    this.requestFill.rCostEstimation=submission.rCostEstimation;
                    commodityTemp.forEach(items => {
                        items.request_commodity.forEach(commodity => {
                            this.commodityList.push(commodity);
                        });
                    });
                }
                else if (submission.rRtId == 3){
                    this.requestTypeDetail='FUND';
                    this.requestFill.rLetterNumber=submission.rLetterNumber;
                    this.requestFill.rLetterDate=submission.rLetterDate
                    this.requestFill.rSubject=submission.rSubject;
                    this.requestFill.rCostEstimation=submission.rCostEstimation;
                    this.requestFill.rDescription=submission.rDescription;
                }
            },

            /*--------------------------- File Upload Start--------------------------------------*/
            getAttachmentSize() {
                this.upload_size = 0; // Reset to beginningƒ
                this.attachments.map((item) => { this.upload_size += parseInt(item.size); });
                this.upload_size = Number((this.upload_size).toFixed(1));
                this.$forceUpdate();

            },

            prepareFields() {
                if (this.attachments.length > 0) {
                    for (var i = 0; i < this.attachments.length; i++) {
                        let attachment = this.attachments[i];
                        this.data.append('attachments[]', attachment);
                        console.log(attachment.name);
                    }

                }
            },

            removeAttachment(index) {
                this.attachments.splice(index , 1);
                this.imgUrl.splice(index, 1);
                this.getAttachmentSize();
            },
            // This function will be called every time you add a file
            uploadFieldChange(e) {
                /*this.extension='';
                this.extension= e.target.files[0].name.split('.').pop().toLowerCase();*/
                var files = e.target.files || e.dataTransfer.files;
                if (!files.length)
                    return;
                for (var i = files.length - 1; i >= 0; i--) {
                    this.attachments.push(files[i]);
                }
                console.log(this.attachments);
                //this.attachments.name.split('.').pop().toLowerCase();

                // Reset the form to avoid copying these files multiple times into this.attachments
                document.getElementById("attachments").value = [];

            },

            resetData() {
                this.data = new FormData(); // Reset it completely
                this.attachments = [];
            },
            /*----------------------------- File Upload End---------------------------------*/
    }
}
</script>
