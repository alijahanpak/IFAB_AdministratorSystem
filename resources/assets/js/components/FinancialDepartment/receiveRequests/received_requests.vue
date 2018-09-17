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
            <div class="medium-12 padding-lr table-mrg-top">
                <div class="tbl-div-container">
                    <table class="tbl-head">
                        <colgroup>
                            <col width="80px"/>
                            <col width="150px"/>
                            <col width="250px"/>
                            <col width="150px"/>
                            <col width="200px"/>
                            <col width="200px"/>
                            <col width="150px"/>
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
                            <th class="tbl-head-style-cell">مبلغ قرارداد <span class="btn-red small-font">(ریال)</span></th>
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
                                <col width="300px"/>
                                <col width="300px"/>
                                <col width="150px"/>
                                <col width="200px"/>
                                <col width="200px"/>
                                <col width="150px"/>
                                <col width="150px"/>
                            </colgroup>
                            <tbody class="tbl-head-style-cell">
                            <tr class="table-row" @click="getRequestDetail(receiveRequest)" v-for="receiveRequest in receiveRequests">
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
                                        <div v-if="receiveRequest.rAcceptedAmount != receiveRequest.rCostEstimation">
                                            <span class="danger-label">{{$parent.dispMoneyFormat(receiveRequest.rAcceptedAmount)}}</span>
                                        </div>
                                        <div v-else>
                                            {{$parent.dispMoneyFormat(receiveRequest.rAcceptedAmount)}}
                                        </div>
                                    </td>
                                    <td v-else class="text-center"><span class="reserved-label">فاقد قرارداد</span></td>
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
                        <vue-pagination  v-bind:pagination="received_pagination"
                                         v-on:click.native="fetchData(received_pagination.current_page)"
                                         :offset="4">
                        </vue-pagination>
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
                                <li class="tabs-title" v-if="requestType == 'BUY_SERVICES'"><a href="#contractTab">اطلاعات قرارداد</a></li>
                                <li class="tabs-title"><a href="#requestHistoryTab">تاریخچه </a></li>
                                <li class="tabs-title"><a href="#requestAttachmentsTab">پیوست ها </a></li>
                            </ul>
                            <div class="tabs-content" data-tabs-content="request_tab_view">
                                <!--Tab 1-->
                                <div class="tabs-panel is-active table-mrg-btm" id="requestDetailTab">
                                    <rDetails v-bind:requestTypeDetail="requestTypeDetail"
                                              v-bind:requestFill="requestFill"
                                              v-bind:commodityList="commodityList">
                                    </rDetails>
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
                                    <rCredits v-if="isFromRefund != true" v-on:closeModal="showRequestDetailModal=false"
                                              v-on:updateReceiveRequestData="updateReceiveRequestData"
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
                                <div class="tabs-panel table-mrg-btm" id="contractTab" xmlns:v-on="http://www.w3.org/1999/xhtml">
                                    <rContract v-if="requestType == 'BUY_SERVICES'"
                                            v-on:closeModal="showRequestDetailModal=false"
                                            v-on:updateReceiveRequestData="updateReceiveRequestData"
                                            v-bind:requestId="requestId"
                                            v-bind:contracts="contracts"
                                            v-bind:creditIsAccepted="creditIsAccepted"
                                            v-bind:creditIsExist="creditIsExist">
                                    </rContract>
                                </div>
                                <!--Tab 4-->
                                <!--Tab 5-->
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
                                <!--Tab 5-->

                                <!--Tab 6-->
                                <div class="tabs-panel table-mrg-btm" id="requestAttachmentsTab" xmlns:v-on="http://www.w3.org/1999/xhtml">
                                    <div class="grid-x">
                                        <vue-element-loading :active="showLoaderProgress" spinner="spinner" color="#716aca"/>
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
                                                                    <a v-if="$can('UNIT_OF_CONTRACT_DELETE_ATTACHMENT')" class="dropdown small sm-btn-align"  type="button" :data-toggle="'attachmentDel' + index"><i class="fa fa-ellipsis-v size-18"></i></a>
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
                                <!--Tab 6-->
                            </div>
                        </div>
                        <div class="large-12 medium-12 small-12 medium-top-m">
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
            VueElementLoading,
        },
        data () {
            return {
                attachments:[],
                attachmentIdForDelete: 0,
                showLoaderProgress:false,
                receiveRequests:[],
                costTemp:'',
                showRequestDetailModal:false,
                showReferralsModal:false,
                showSubmitRequestModal:false,
                showResponseRequestModal:false,
                showRegisterAndNumberingModal:false,
                showDialogModal: true,
                showDeleteAttachmentConfirmModal: false,
                dialogMessage: '',
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
                referralDestination:'',
                canResponse:'',
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

                /*credits*/

                baseAmount:0,

                /*credits*/

                contracts:[],
                creditIsAccepted: true,
                creditIsExist: false,

                maxInputValue:0,
                updateDataThreadNowPlaying: null,

                received_pagination: {
                    total: 0,
                    to: 0,
                    current_page: 1,
                    last_page: ''
                },
                isFromRefund: false,
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
            updateReceiveRequestData: function(requests , rId){
                this.receiveRequests = requests.data;
                this.receiveRequests.forEach(item => {
                    if (item.id == rId)
                    {
                        this.getRequestDetail(item);
                    }
                });
                this.makePagination(requests);
            },

            makePagination: function(data){
                this.received_pagination.current_page = data.current_page;
                this.received_pagination.to = data.to;
                this.received_pagination.last_page = data.last_page;
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
                        this.receiveRequests = response.data.data;
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
                if(request.rLastRef.rhHasBeenSeen==0) {
                    axios.post('/financial/request/received/was_seen', {
                        rhId: request.rLastRef.id
                    }).then((response) => {
                        this.receiveRequests = response.data.data;
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
                var requestHistory=[];
                requestHistory.push(request);
                this.requestId=request.id;

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

                this.lastVerifier=request.rLastRef.id;
                this.creditIsAccepted = request.rCreditIsAccepted;
                this.creditIsExist = request.rCreditIsExist;
                this.requestType = request.request_type.rtType;
                this.isFromRefund = request.isFromRefundCosts;

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
                alert('ali');
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
                            this.receiveRequests = response.data.data;
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

            openResponseRequestModal: function () {
                this.showResponseRequestModal=true;
            },


            responseRequest: function () {
                axios.post('/financial/request/response', {
                    lastRefId: this.lastVerifier,
                    description: this.responseDescription
                }).then((response) => {
                    this.receiveRequests = response.data.data;
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
                    this.receiveRequests = response.data.data;
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
        }
    }
</script>
