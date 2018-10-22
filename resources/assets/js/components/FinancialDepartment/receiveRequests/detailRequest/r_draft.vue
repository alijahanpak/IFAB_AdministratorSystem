<template xmlns:v-on="http://www.w3.org/1999/xhtml">
    <div class="grid-x">
        <div class="large-12 medium-12 small-12" v-show="$can('FINANCIAL_ADD_NEW_DRAFT') && requestType != 'BUY_SERVICES'">
            <div class="clearfix tool-bar">
                <div class="button-group float-right report-mrg">
                    <a class="my-button toolbox-btn small" @click="openInsertDraftModal()">پیشنویس حواله</a>
                </div>
            </div>
        </div>
        <div class="large-12 medium-12 small-12 small-top-m">
            <!--Table Start-->
            <!--Table Head Start-->
            <div class="tbl-div-container">
                <table class="tbl-head">
                    <colgroup>
                        <col width="350px"/>
                        <col width="200px"/>
                        <col width="200px"/>
                        <col width="150px"/>
                        <col width="150px"/>
                        <col width="130px"/>
                        <col width="12px"/>
                    </colgroup>
                    <tbody class="tbl-head-style ">
                    <tr class="tbl-head-style-cell">
                        <th class="tbl-head-style-cell">بابت</th>
                        <th class="tbl-head-style-cell">در وجه</th>
                        <th class="tbl-head-style-cell">ارسال کننده</th>
                        <th class="tbl-head-style-cell">درخواست پرداخت </th>
                        <th class="tbl-head-style-cell">مبلغ حواله </th>
                        <th class="tbl-head-style-cell">وضعیت</th>
                        <th class="tbl-head-style-cell"></th>
                    </tr>
                    </tbody>
                    <!--Table Head End-->
                    <!--Table Body Start-->
                </table>
                <div style="height: 51vh" class="tbl_body_style inner-vh-unsize">
                    <table class="tbl-body-contain">
                        <colgroup>
                            <col width="350px"/>
                            <col width="200px"/>
                            <col width="200px"/>
                            <col width="150px"/>
                            <col width="150px"/>
                            <col width="130px"/>
                        </colgroup>
                        <tbody class="tbl-head-style-cell">
                        <tr @click="openPdfModal(draft)" class="table-row" v-for="draft in drafts">
                            <td>{{draft.dFor}}</td>
                            <td>{{draft.dPayTo}}</td>
                            <td :data-toggle="'dLastRef' + draft.id">{{draft.dLastRef.source_user_info.name}} - {{draft.dLastRef.source_user_info.role.rSubject}}
                                <div class="clearfix tool-bar" v-if="draft.dLastRef.rhDescription !== null">
                                    <div  style="width: 300px;" class="dropdown-pane dropdown-pane-sm " data-close-on-click="true"  data-hover="true" data-hover-pane="true" data-h-offset="20px"  data-position="auto" data-alignment="auto" :id="'dLastRef' + draft.id" data-dropdown data-auto-focus="true">
                                        <ul class="my-menu small-font">
                                            <div class="grid-x">
                                                <div class="medium-12">
                                                    <p class="black-color">{{draft.dLastRef.source_user_info.name}} - {{draft.dLastRef.source_user_info.role.rSubject}}</p>
                                                    <p class="gray-colors text-justify" style="margin-top: -10px">{{ draft.dLastRef.rhDescription }}</p>
                                                    <p style="direction: ltr;margin-bottom: -10px;" class="gray-color small-font float-left"><i class="far fa-calendar-alt"></i><span> {{draft.dLastRef.rhShamsiDate}} </span> - <i class="far fa-clock"></i> <span>{{draft.dLastRef.rhShamsiTime}}</span></p>
                                                </div>
                                            </div>
                                        </ul>
                                    </div>
                                </div>
                            </td>
                            <td class="text-center">{{$root.dispMoneyFormat(draft.dBaseAmount)}}</td>
                            <td class="text-center">{{$root.dispMoneyFormat(draft.dAmount)}}</td>
                            <td v-show="draft.draft_state.dsState == 'MINUTE'" class="text-center"><span class="reserved-label">{{ draft.draft_state.dsSubject }}</span></td>
                            <td v-show="draft.draft_state.dsState == 'NEW'" class="text-center"><span class="danger-label">{{ draft.draft_state.dsSubject }}</span></td>
                            <td v-show="draft.draft_state.dsState == 'ACCEPTED'" class="text-center"><span class="success-label">{{ draft.draft_state.dsSubject }}</span></td>
                            <td v-show="draft.draft_state.dsState == 'BLOCKED'" class="text-center"><span class="blocked-label">{{ draft.draft_state.dsSubject }}</span></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <!--Table Body End-->
        </div>

        <!--Insert Draft Start-->
        <modal-small v-if="showInsertDraftModal" @close="showInsertDraftModal = false">
            <div  slot="body">
                <form v-on:submit.prevent="addNewDraft" >
                    <div class="small-font">
                        <div class="large-12 medium-12 small-12">
                            <ul class="tabs tab-color my-tab-style" data-responsive-accordion-tabs="tabs medium-accordion large-tabs" id="draft_tab_view">
                                <li class="tabs-title is-active"><a href="#verTab" aria-selected="true">امضا کننده</a></li>
                                <li class="tabs-title"><a href="#drafTab">حواله </a></li>
                            </ul>
                            <div class="tabs-content" data-tabs-content="draft_tab_view">
                                <!--Tab 1-->
                                <div class="tabs-panel is-active table-mrg-btm" id="verTab">
                                    <div class="grid-x">
                                        <div class="large-8 medium-8 small-12">
                                            <label>امضا کننده
                                                <select name="verifierUser" v-validate data-vv-rules="required"  v-model="draftInput.verifierId" :class="{'input': true, 'select-error': errors.has('verifierUser')}">
                                                    <option value=""></option>
                                                    <option v-for="user in directorGeneralUsers" :value="user.id">{{user.name}} - {{user.role.rSubject}}</option>
                                                </select>
                                                <p v-show="errors.has('verifierUser')" class="error-font">لطفا امضا کننده را انتخاب کنید!</p>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <!--Tab 1-->
                                <!--Tab 2-->
                                <div class="tabs-panel table-mrg-btm" id="drafTab">
                                    <div class="grid-x">
                                        <div class="large-12 medium-12 small-12 padding-lr">
                                            <label>بابت
                                                <suggestions autocomplete="off" style="margin-bottom: -18px;" name="forTitle" v-validate="'required'" :class="{'input': true, 'select-error': errors.has('forTitle')}"
                                                             v-model="draftInput.for"
                                                             :options="forOptions"
                                                             :onInputChange="onForInputChange">
                                                    <div slot="item" slot-scope="props" class="single-item">
                                                        <strong>{{props.item}}</strong>
                                                    </div>
                                                </suggestions>
                                            </label>
                                            <p v-show="errors.has('forTitle')" class="error-font">لطفا فیلد بابت را وارد نمایید!</p>
                                        </div>
                                    </div>
                                    <div class="grid-x input-margin-top">
                                        <div class="large-12 medium-12 small-12 padding-lr">
                                            <label>در وجه
                                                <suggestions autocomplete="off" style="margin-bottom: -18px;" name="payToTitle" v-validate="'required'" :class="{'input': true, 'select-error': errors.has('payToTitle')}"
                                                             v-model="draftInput.payTo"
                                                             :options="payToOptions"
                                                             :onInputChange="onPayToInputChange">
                                                    <div slot="item" slot-scope="props" class="single-item">
                                                        <strong>{{props.item}}</strong>
                                                    </div>
                                                </suggestions>
                                            </label>
                                            <p v-show="errors.has('payToTitle')" class="error-font">لطفا فیلد در وجه را وارد نمایید!</p>
                                        </div>
                                    </div>
                                    <div v-if="requestType == 'BUY_SERVICES'" style="margin-top:15px;"  class="grid-x">
                                        <div class="large-6 medium-6 small-12 padding-lr">
                                            <label>مبلغ<span class="btn-red">(ریال)</span>
                                                <money v-if="moneyState== 'none'" @keyup.native="calculateDraftAmount()" v-model="draftInput.baseAmount"  v-bind="money" class="form-input input-lg text-margin-btm"  v-validate="'required'" :class="{'input': true, 'error-border': errors.has('baseAmount')}"></money>
                                                <money v-if="moneyState== 'block'" @keyup.native="calculateDraftAmount()" v-model="draftInput.baseAmount"  v-bind="money" class="form-input input-lg text-margin-btm select-error"  v-validate="'required'" :class="{'input': true, 'error-border': errors.has('baseAmount')}"></money>
                                            </label>
                                            <p v-show="errors.has('baseAmount')" class="error-font"> مبلغ صورت وضعیت مورد نظر نامعتبر است!</p>
                                            <p style="margin-top: 10px;" v-show="moneyState== 'block'" class="btn-red">مبلغ صورت وضعیت مورد نظر نامعتبر است!</p>
                                        </div>
                                    </div>
                                    <div v-if="requestType == 'BUY_COMMODITY'" style="margin-top:15px;"  class="grid-x">
                                        <div class="large-6 medium-6 small-12 padding-lr">
                                            <label v-show="requestType == 'BUY_COMMODITY'">مبلغ<span class="btn-red">(ریال)</span>
                                                <money v-if="moneyState== 'none'" @keyup.native="calculateDraftAmount()" v-model="draftInput.baseAmount"  v-bind="money" class="form-input input-lg text-margin-btm"  v-validate="'required'" :class="{'input': true, 'error-border': errors.has('baseAmount')}"></money>
                                                <money v-if="moneyState== 'block'" @keyup.native="calculateDraftAmount()" v-model="draftInput.baseAmount"  v-bind="money" class="form-input input-lg text-margin-btm select-error"  v-validate="'required'" :class="{'input': true, 'error-border': errors.has('baseAmount')}"></money>
                                            </label>
                                            <p v-show="errors.has('baseAmount')" class="error-font"> مبلغ صورت وضعیت مورد نظر نامعتبر است!</p>
                                            <p style="margin-top: 10px;" v-show="moneyState== 'block'" class="btn-red">مبلغ صورت وضعیت مورد نظر نامعتبر است!</p>
                                        </div>
                                    </div>
                                    <div style="margin-top: 10px;" class="grid-x padding-lr">
                                        <div class="large-12 medium-12 small-12 panel-separator">
                                            <div class="grid-x">
                                                <div class="large-9 medium-9  small-12">
                                                    <div class="grid-x">
                                                        <div class="large-12 medium-12 small-12">
                                                            <p>مبلغ تعهد شده : </p>
                                                            <p>مبلغ حواله های ثبت شده تا کنون : </p>
                                                            <p>مبلغ نهایی حواله : </p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="large-3 medium-3 small-12">
                                                    <p class="btn-red">{{$root.dispMoneyFormat(rCommitmentAmount)}} ریال</p>
                                                    <p class="btn-red">{{$root.dispMoneyFormat(lastDrafts)}} ریال</p>
                                                    <p class="btn-red">{{$root.dispMoneyFormat(draftBaseAmount)}} ریال</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <!--Tab 2-->
                            </div>
                        </div>
                        <div class="grid-x medium-top-m padding-lr">
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
        <!--Insert Draft End-->

        <!-- pdf  modal -->
        <modal-small v-if="showPdfModal" @close="showPdfModal = false">
            <div style="height: 88vh;" slot="body">
                <div class="grid-x">
                    <div class="large-12 medium-12 small-12">
                        <ul class="tabs tab-color my-tab-style" data-responsive-accordion-tabs="tabs medium-accordion large-tabs" id="draftAndCheck_tab_view">
                            <li class="tabs-title is-active"><a href="#DraftTab" aria-selected="true">حواله</a></li>
                            <li class="tabs-title"><a href="#DocumentTab">سند هزینه</a></li>
                            <li class="tabs-title"><a href="#CheckTab">چک</a></li>
                        </ul>
                        <div class="tabs-content" data-tabs-content="draftAndCheck_tab_view">
                            <!--Draft Tab -->
                            <div class="tabs-panel is-active table-mrg-btm" id="DraftTab">
                                <div class="grid-x" :style="{ width: '100%' , height: !draftIsBlocked ? '72.5vh' : '76vh'}">
                                    <div class="large-12">
                                        <vue-element-loading style="width: 100%;" :active="showLoaderProgress" spinner="line-down" color="#716aca"/>
                                        <embed style="width: 100%;height: 100%" :src="draftPdfPath + '#page=1&zoom=65'" />
                                    </div>
                                </div>
                                <div class="grid-x" v-if="!draftIsBlocked" style="margin-top: 0.5rem">
                                    <div style="margin-bottom:-20px;margin-top: 5px;" class="large-12 medium-12 small-12">
                                        <div class="stacked-for-small button-group float-right">
                                            <button v-show="$can('FINANCIAL_REGISTER_AND_NUMBERING_DRAFT')" @click="openRegisterAndNumberingModal()"  class="my-button my-success"><span class="btn-txt-mrg">   ثبت در دبیرخانه   </span></button>
                                            <button v-show="$can('FINANCIAL_ACCEPT_DRAFT') && youAreDraftVerifier" @click="checkAcceptDraftConfirmModal()"  class="my-button my-success"><span class="btn-txt-mrg">   تایید و امضا   </span></button>
                                            <button v-show="$can('FINANCIAL_ACCEPT_MINUTE_DRAFT') && isMinute" @click="openAcceptMinuteConfirmModal()"  class="my-button my-success"><span class="btn-txt-mrg">   تایید پیشنویس   </span></button>
                                            <button v-show="$can('FINANCIAL_DETERMINE_DECREASES_AND_MAKE_CHECKS') && isAccepted" @click="openGenerateChecksModal()"  class="my-button my-success"><span class="btn-txt-mrg">   صدور چک   </span></button>
                                            <button @click="openReferralModal(draftId)"  class="my-button toolbox-btn float-left btn-for-load"><span class="btn-txt-mrg"> ارجاع </span></button>
                                            <button @click="openResponseRequestModal(draftId)" v-show="canResponse == true" class="my-button toolbox-btn float-left btn-for-load"><span class="btn-txt-mrg"> پاسخ </span></button>
                                            <button v-show="$can('DRAFT_BLOCK')" @click="openBlockModal()" class="my-button toolbox-btn"><span class="btn-txt-mrg">مسدود</span></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--Draft Tab -->
                            <!--Document Tab -->
                            <div class="tabs-panel table-mrg-btm" id="DocumentTab">
                                <div class="grid-x" style="width: 100%;height: 76vh">
                                    <div class="large-12">
                                        <vue-element-loading style="width: 100%;" :active="showDocumentLoaderProgress" spinner="line-down" color="#716aca"/>
                                        <embed style="width: 100%;height: 100%" :src="documentPdfPath + '#page=1&zoom=50'" />
                                    </div>
                                </div>
                            </div>
                            <!--Document Tab -->
                            <!--Check Tab -->
                            <div class="tabs-panel table-mrg-btm" id="CheckTab">
                                <div class="grid-x">
                                    <div class="large-12 medium-12 small-12 small-top-m">
                                        <!--Table Start-->
                                        <!--Table Head Start-->
                                        <div class="tbl-div-container">
                                            <table class="tbl-head">
                                                <colgroup>
                                                    <col width="400px"/>
                                                    <col width="200px"/>
                                                    <col width="200px"/>
                                                    <col width="12px"/>
                                                </colgroup>
                                                <tbody class="tbl-head-style ">
                                                <tr class="tbl-head-style-cell">
                                                    <th class="tbl-head-style-cell">بابت</th>
                                                    <th class="tbl-head-style-cell">مبلغ چک </th>
                                                    <th class="tbl-head-style-cell">وضعیت</th>
                                                    <th class="tbl-head-style-cell"></th>
                                                </tr>
                                                </tbody>
                                                <!--Table Head End-->
                                                <!--Table Body Start-->
                                            </table>
                                            <div class="tbl_body_style" style="height: 70vh">
                                                <table class="tbl-body-contain">
                                                    <colgroup>
                                                        <col width="400px"/>
                                                        <col width="200px"/>
                                                        <col width="200px"/>
                                                    </colgroup>
                                                    <tbody class="tbl-head-style-cell">
                                                    <tr v-for="check in checks">
                                                        <td v-if="check.percentage_decrease != null">{{check.percentage_decrease.pdSubject}}  ({{check.percentage_decrease.pdPercent}}%)</td>
                                                        <td v-else>{{draftFor}}</td>
                                                        <td class="text-center">{{$root.dispMoneyFormat(check.cAmount)}}</td>
                                                        <td v-show="check.check_state.csState == 'WAITING_FOR_PRINT'" class="text-center"><span class="danger-label">{{ check.check_state.csSubject }}</span></td>
                                                        <td v-show="check.check_state.csState == 'WAITING_FOR_DELIVERY'" class="text-center"><span class="reserved-label">{{ check.check_state.csSubject }}</span></td>
                                                        <td v-show="check.check_state.csState == 'DELIVERED'" class="text-center"><span class="success-label">{{ check.check_state.csSubject }}</span></td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <!--Table Body End-->
                                    </div>
                                </div>
                            </div>
                            <!--Check Tab -->
                        </div>
                    </div>
                </div>
            </div>
        </modal-small>
        <!-- pdf Factor modal -->

        <!-- Accept Draft modal -->
        <modal-tiny v-if="showCheckAcceptDraftModal" @close="showCheckAcceptDraftModal = false">
            <div slot="body">
                <div class="small-font" xmlns:v-on="http://www.w3.org/1999/xhtml">
                    <p class="black-color text-justify" style="font-size: 1rem">کاربر گرامی:</p>
                    <p class="large-offset-1 modal-text">آیا برای تایید حوله اطمینان دارید؟</p>
                    <div class="grid-x">
                        <div class="medium-12 column text-center">
                            <button v-on:click="acceptDraft()"   class="my-button my-success"><span class="btn-txt-mrg">   بله   </span></button>
                        </div>
                    </div>
                </div>
            </div>
        </modal-tiny>
        <!-- Accept Draft modal -->

        <!-- Accept Draft Minute modal -->
        <modal-tiny v-if="showAcceptMinuteConfirmModal" @close="showAcceptMinuteConfirmModal = false">
            <div slot="body">
                <div class="small-font" xmlns:v-on="http://www.w3.org/1999/xhtml">
                    <p class="black-color text-justify" style="font-size: 1rem">کاربر گرامی:</p>
                    <p class="large-offset-1 modal-text">آیا پیش نویس حواله مورد تایید است؟</p>
                    <div class="grid-x">
                        <div class="medium-12 column text-center">
                            <button v-on:click="acceptDraftMinute()"   class="my-button my-success"><span class="btn-txt-mrg">   بله   </span></button>
                        </div>
                    </div>
                </div>
            </div>
        </modal-tiny>
        <!-- Accept Draft Minute modal -->

        <!-- Register And Numbering Draft Start -->
        <modal-tiny v-if="showRegisterAndNumberingModal" @close="showRegisterAndNumberingModal = false">
            <div  slot="body">
                <div class="small-font" xmlns:v-on="http://www.w3.org/1999/xhtml">
                    <div class="grid-x">
                        <div class="large-12 medium-12 small-12 padding-lr">
                            <label>تاریخ
                                <date-picker
                                        :color="'#5c6bc0'"
                                        v-model="registerDate"
                                        input-class="form-control form-control-lg date-picker-bottom-margin"
                                        id="my-custom-input"
                                        placeholder="انتخاب تاریخ">
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
                            <button @click="registerAndNumberingDraft()"  class="my-button my-success btn-for-load"><span class="btn-txt-mrg">  ثبت</span></button>
                        </div>
                    </div>
                </div>
            </div>
        </modal-tiny>
        <!-- Register And Numbering Draft End -->

        <!-- Generate Checks  modal -->
        <modal-small v-if="showGenerateChecksModal" @close="showGenerateChecksModal = false">
            <div slot="body">
                <div class="small-font" xmlns:v-on="http://www.w3.org/1999/xhtml">
                    <div class="grid-x">
                        <div class="large-12 medium-12 small-12 padding-lr">
                            <div class="panel-separator padding-lr">
                                <div  v-for="(percentDecCategory , index) in percentageDecreasesCategory" class="grid-x">
                                    <div class="large-8 medium-8  small-12">
                                        <div class="grid-x">
                                            <div class="large-12 medium-12  small-12">
                                                <label>{{ percentDecCategory.pdcSubject }}<span class="btn-red size-12" v-if="percentDecCategory.necessary"> - الزامی</span><span class="btn-red size-12" v-if="percentDecCategory.delivered"> - تحویل داده شده</span>
                                                    <select v-model="percentDecInput['percentage' + percentDecCategory.id]" :disabled="percentDecCategory.isNeed == true || requestType == 'FUND'" v-on:change="calculatePercentAmount(percentDecInput['percentage' + percentDecCategory.id], index)">
                                                        <option value=""></option>
                                                        <option v-for="pd in percentDecCategory.percentage_decrease" :value="pd.id" selected="selected" >{{pd.pdSubject}} - {{'(' + pd.pdPercent + '%)'}}</option>
                                                    </select>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div style="display: table" class="large-4 medium-4 small-12 text-left">
                                        <p style="display: table-cell; vertical-align: middle" class="btn-red text-left">{{$root.dispMoneyFormat(percentDecCategory.amountDec)}} ریال</p>
                                    </div>
                                </div>
                            </div>
                            <div style="margin-top: -16px;border-top: 1px solid #E0E0E0;" class="panel-separator padding-lr">
                                <div class="grid-x">
                                    <div class="large-9 medium-9  small-12">
                                        <div class="grid-x">
                                            <div class="large-12 medium-2 small-12">
                                                <p>مبلغ حواله : </p>
                                                <p>مبلغ چک <span> {{draftFor}} </span> </p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="large-3 medium-3  small-12 text-left">
                                        <p class="btn-red text-left">{{$root.dispMoneyFormat(draftAmount)}} ریال</p>
                                        <p class="btn-red text-left">{{$root.dispMoneyFormat(finalIncAmount)}} ریال</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="grid-x small-top-m">
                        <div class="large-12 medium-12 small-12 padding-lr">
                            <div class="stacked-for-small button-group float-left">
                                <button @click="openAcceptGeneratecheckConfirmModal()" class="my-button my-success float-left"><span class="btn-txt-mrg">  ثبت </span></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </modal-small>
        <!-- Generate Checks  modal -->
        <messageDialog v-show="showDialogModal" @close="showDialogModal =false">
            {{dialogMessage}}
        </messageDialog>

        <!-- Accept Generate check modal -->
        <modal-tiny v-if="showAcceptGeneratecheckConfirmModal" @close="showAcceptGeneratecheckConfirmModal = false">
            <div slot="body">
                <div class="small-font" xmlns:v-on="http://www.w3.org/1999/xhtml">
                    <p class="black-color text-justify" style="font-size: 1rem">کاربر گرامی:</p>
                    <p class="large-offset-1 modal-text">آیا برای صدور چک اطمینان دارید؟</p>
                    <div class="grid-x">
                        <div class="medium-12 column text-center">
                            <button v-on:click="generateChecks()"   class="my-button my-success"><span class="btn-txt-mrg">   بله   </span></button>
                        </div>
                    </div>
                </div>
            </div>
        </modal-tiny>
        <!-- Accept Generate check modal -->
        <!-- block Detail Modal Start -->
        <modal-tiny v-if="showBlockModal" @close="showBlockModal = false">
            <div  slot="body">
                <form v-on:submit.prevent="requestBlock">
                    <div class="small-font">
                        <div class="grid-x">
                            <div class="large-12 medium-12 small-12 padding-lr">
                                <p class="black-color text-justify" style="font-size: 1rem">کاربر گرامی:</p>
                                <p class="large-offset-1 modal-text">توجه داشته باشید که در صورت مسدود کردن حواله دیگر امکان بازگشت آن به حالت فعال وجود ندارد، با مسدود شدن حواله مبلغ حواله در محاسبات در نظر گرفته نخواهد شد.</p>
                                <label>شرح
                                    <textarea v-model="blockInput.description"  class="form-element-margin-btm"  style="min-height: 150px;" name="blockDescription"  v-validate="'required'" :class="{'input': true, 'error-border': errors.has('blockDescription')}"></textarea>
                                    <span v-show="errors.has('blockDescription')" class="error-font">لطفا دلیل مسدود کردن حواله را وارد کنید!</span>
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
        <!-- block Detail Modal End -->
    </div>
</template>
<script>
    import Suggestions from "v-suggestions/src/Suggestions";
    import VueElementLoading from 'vue-element-loading';
    export default{
        props:['drafts','requestId','rAcceptedAmount','rCommitmentAmount','contracts','factors','requestType' , 'sumOfDraftAmount' , 'lastRefDId'],
        components: {
            Suggestions,
            VueElementLoading,
        },
        data () {
            return {
                showInsertDraftModal:false,
                showAcceptConfirmModal: false,
                showDeleteConfirmModal: false,
                showAcceptMinuteConfirmModal: false,
                showRegisterAndNumberingModal:false,
                showPdfModal: false,
                showDialogModal: false,
                showGenerateChecksModal: false,
                showAcceptGeneratecheckConfirmModal: false,
                showBlockModal: false,
                showCheckAcceptDraftModal: false,
                dialogMessage: '',
                draftInput:{},
                blockInput:{},
                directorGeneralUsers:[],
                money: {
                    thousands: ',',
                    precision: 0,
                    masked: true
                },

                //for & PayTo input text
                forQuery: '',
                forItems: [],
                forList: [],
                payToList: [],
                selectedFor: null,
                forOptions: {},
                //for & PayTo input text
                draftBaseAmount:0,
                lastDrafts:0,
                initBaseAmount:0,
                requestBaseAmount:0,
                requestBaseAmountTemp:0,
                requestCAmount:0,
                draftId:'',
                youAreDraftVerifier:'',
                isMinute: false,
                draftPdfPath:'',
                documentPdfPath:'',
                registerDate: '',
                letterNumber: '',
                moneyState:'none',
                percentageDecreasesCategory:[],
                percentDecInput:[],
                isAccepted: false,

                decreases:[],
                draftAmount:0,
                draftFor:'',
                finalIncAmount:0,
                checks:[],
                draftIsBlocked: true,
                showLoaderProgress:false,
                showDocumentLoaderProgress: false,
                checkEdited: false,
                checkBaseDelivered: false,
                canResponse:'',
                checkSize:false,
            }
        },

        created: function () {
            $(this.$el).foundation(); //WORKS!
            this.getDirectorGeneralUsers();
        },
        updated: function () {
            $(this.$el).foundation(); //WORKS!
            this.myResizeDraft();
        },

        mounted: function () {
            this.checkOpenLastRef();
        },

        methods : {
            checkOpenLastRef: function(){
                this.drafts.forEach(draft => {
                    if (draft.dLastRef.rhDId == this.lastRefDId)
                    {
                        this.openPdfModal(draft);
                        return;
                    }
                });
            },

            fetchDocument: function(){
                this.showDocumentLoaderProgress = true;
                axios.post('/financial/report/document' , {dId: this.draftId} , {responseType:'blob'})
                    .then((response) => {
                        console.log(response.data);
                        var file = new Blob([response.data], {type: 'application/pdf'});
                        var fileURL = window.URL.createObjectURL(file);
                        this.documentPdfPath = fileURL;
                        this.showDocumentLoaderProgress = false;
                    },(error) => {
                        console.log(error);
                        this.showDocumentLoaderProgress = false;
                    });
            },

            openPdfModal: function (draft){
              this.checks = [];
              this.checkSize = false;
              var draftHistory = [];
              draftHistory.push(draft);
              this.draftId = draft.id;
              this.youAreDraftVerifier = draft.dYouAreVerifier;
              this.isMinute = draft.dIsMinute;
              this.isAccepted = draft.verifier[0].dvSId != null ? true : false;
              this.draftAmount = draft.dAmount;
              this.draftFor = draft.dFor;this.canResponse = draft.dLastRef.rhIsReferral;
              this.letterNumber = draft.dLetterNumber;
              this.openReportFile();
              this.fetchDocument();
              this.draftPdfPath = '';
              this.draftIsBlocked = draft.draft_state.dsState == 'BLOCKED' ? true : false;
              this.showPdfModal = true;

              draftHistory.forEach(item =>{
                  if (item.check.lenght == null)
                      this.checkSize=true;
              });
              this.checkBaseDelivered = false;
              draftHistory.forEach(item =>{
                  item.check.forEach(ch =>{
                      this.checks.push(ch);
                      if (ch.cPdId == null && ch.cDelivered)
                          this.checkBaseDelivered = true;
                  });
              });
              console.log(JSON.stringify(this.checks));
            },

            getDirectorGeneralUsers: function () {
                axios.get('/admin/user/getDirectorGeneralUsers')
                    .then((response) => {
                        this.directorGeneralUsers = response.data;
                        console.log(response);
                    }, (error) => {
                        console.log(error);
                    });
            },

            /*-----------------------------------------------------------------------------
          ------------------ For Draft Start ------------------------------
          -----------------------------------------------------------------------------*/
            getAllFor: function () {
                this.forItems = this.factors;
                this.forList= [];
                this.payToList= [];
                this.forItems.forEach(item=> {
                    this.forList.push(item.fSubject );
                    this.payToList.push(item.seller.sSubject);
                });
            },

            onForInputChange(forInput) {
                if (forInput.trim().length === 0) {
                    return null
                }
                // return the matching countries as an array
                return this.forList.filter((fors) => {
                    return fors.toLowerCase().includes(forInput.toLowerCase())
                })
            },
            onForSelected(item) {
                this.selectedFor = item
            },
            onSearchItemSelected(item) {
                this.selectedSearchItem = item
            },

            onPayToInputChange(PayToInput) {
                if (PayToInput.trim().length === 0) {
                    return null
                }
                // return the matching countries as an array
                return this.payToList.filter((payTOes) => {
                    return payTOes.toLowerCase().includes(PayToInput.toLowerCase())
                })
            },
            onForPayTOSelected(item) {
                this.selectedPayTo = item
            },
            onSearchItemSelected(item) {
                this.selectedSearchItem = item
            },

            /*-----------------------------------------------------------------------------
            ------------------ For Draft End ------------------------------
            -----------------------------------------------------------------------------*/

            calculateDraftAmount: function(){
                    var baseAmount=0;
                    baseAmount=parseInt(this.draftInput.baseAmount.split(',').join(''),10);
                    this.getSumOfLastDrafts();
                    this.draftBaseAmount = Math.round(baseAmount - this.lastDrafts);
                    if(((this.draftBaseAmount + this.lastDrafts) > this.rAcceptedAmount) || (this.draftBaseAmount < 0))
                        this.moneyState='block';
                    else
                        this.moneyState='none';

            },

            getSumOfLastDrafts: function (){
                this.lastDrafts = parseInt(this.sumOfDraftAmount,10);
            },

            setInitBaseAmount: function (){
                this.getSumOfLastDrafts();
                this.getBaseAmount();
                this.draftInput.baseAmount= this.$root.dispMoneyFormat(this.requestBaseAmount);
                this.calculateDraftAmount();

            },

            getBaseAmount: function(){
                this.requestBaseAmount=this.rAcceptedAmount;
            },

            openReportFile: function () {
                this.showLoaderProgress = true;
                axios.post('/financial/report/draft' , {dId: this.draftId} , {responseType:'blob'})
                    .then((response) => {
                        console.log(response.data);
                        var file = new Blob([response.data], {type: 'application/pdf'});
                        var fileURL = window.URL.createObjectURL(file);
                        this.draftPdfPath=fileURL;
                        this.showLoaderProgress = false;
                    },(error) => {
                        console.log(error);
                    this.showLoaderProgress = false;
                    });
            },

            openConfirmDeleteContract: function(cId){
                this.fIdForDelete = cId;
                this.showDeleteConfirmModal = true;
            },

            checkAcceptDraftConfirmModal: function(){
              this.showCheckAcceptDraftModal=true;
            },

            acceptDraft: function(){
                axios.post('/financial/draft/accept', {
                    rId: this.requestId,
                    dId:this.draftId
                }).then((response) => {
                    this.$emit('updateReceiveRequestData' , response.data , this.requestId);
                    this.$emit('closeModal');
                    this.$root.displayNotif(response.status);
                    console.log(response);
                }, (error) => {
                    console.log(error);
                    this.$root.displayNotif(error.response.status);
                });
            },

            deleteFactor: function() {
                axios.post('/financial/request/factor/delete', {
                    rId: this.requestId,
                    fId: this.fIdForDelete,
                }).then((response) => {
                    if (response.status == 200)
                        this.$emit('updateReceiveRequestData' , response.data , this.requestId);
                    this.showDeleteConfirmModal = false;
                    this.$root.displayNotif(response.status);
                    console.log(response);
                }, (error) => {
                    console.log(error);
                    this.$root.displayNotif(error.response.status);
                });
            },

            myResizeDraft: function() {
                var x = $.w.outerHeight();
                $('.dynamic-height-level-modal1').css('height', (x-200) + 'px');
            },

            openInsertDraftModal:function () {
                if(this.rCommitmentAmount != this.rAcceptedAmount){
                    this.dialogMessage = 'تامین اعتبار به درستی انجام نشده است!';
                    this.showDialogModal = true;
                }
                else{
                    if (this.sumOfDraftAmount < this.rCommitmentAmount)
                    {
                        this.draftBaseAmount=0,
                        this.lastDrafts=0,
                        this.initBaseAmount=0,
                        this.requestBaseAmount=0,
                        this.requestCAmount=0,
                        this.forItems=[];
                        this.getAllFor();
                        this.draftInput = {};
                        this.setInitBaseAmount();
                        this.showInsertDraftModal = true;
                    }else {
                        this.dialogMessage = 'امکان تهیه پیشنویس حواله وجود ندارد، مجموع مبلغ حواله ها با مبلغ تعهد شده درخواست برابر است! در صورت نیاز درخواست های تایید نشده را مسدود کنید.';
                        this.showDialogModal = true;
                    }
                }
            },

            addNewDraft:function () {
                this.$validator.validateAll().then((result) => {
                    if (result) {
                        if(((this.draftBaseAmount + this.lastDrafts) > this.rAcceptedAmount) || (this.draftBaseAmount < 0)){
                            this.dialogMessage = 'مبلغ  صورت وضعیت نامعتبر است!';
                            this.showDialogModal = true;
                        }
                        else{
                            axios.post('financial/draft/register', {
                                rId: this.requestId,
                                for: this.draftInput.for,
                                payTo: this.draftInput.payTo,
                                baseAmount: parseInt(this.draftInput.baseAmount.split(',').join(''),10),
                                amount: this.draftBaseAmount,
                                verifierId: this.draftInput.verifierId
                            }).then((response) => {
                                this.$emit('updateReceiveRequestData' , response.data , this.requestId);
                                this.$emit('closeModal');
                                this.showInsertDraftModal = false;
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

            openRegisterAndNumberingModal:function(){
                if (this.isAccepted)
                    this.showRegisterAndNumberingModal=true;
                else
                {
                    this.dialogMessage = 'حواله امضاء نشده است!';
                    this.showDialogModal = true;
                }
            },

            registerAndNumberingDraft:function () {
                axios.post('/financial/draft/numbering', {
                    rId: this.requestId,
                    dId:this.draftId,
                    letterDate: this.registerDate,
                    letterNumber: this.letterNumber
                }).then((response) => {
                    this.$emit('updateReceiveRequestData' , response.data , this.requestId);
                    this.$emit('closeModal');
                    this.showRegisterAndNumberingModal = false;
                    this.$root.displayNotif(response.status);
                    console.log(response);
                }, (error) => {
                    console.log(error);
                    this.$root.displayNotif(error.response.status);
                });
            },

            openAcceptMinuteConfirmModal:function(){
                this.showAcceptMinuteConfirmModal=true;
            },

            acceptDraftMinute:function () {
                axios.post('/financial/draft/accept_minute', {
                    rId: this.requestId,
                    dId:this.draftId,
                }).then((response) => {
                    this.$emit('updateReceiveRequestData' , response.data , this.requestId);
                    this.$emit('closeModal');
                    this.showAcceptMinuteConfirmModal = false;
                    this.$root.displayNotif(response.status);
                    console.log(response);
                }, (error) => {
                    console.log(error);
                    this.$root.displayNotif(error.response.status);
                });
            },

            openGenerateChecksModal:function(){
                this.percentDecInput = [];
                this.getAllPercentageDecreases();
                this.checkEdited = false;
                if (!this.checkBaseDelivered)
                    this.showGenerateChecksModal=true;
                else{
                    this.dialogMessage = 'با توجه به اینکه چک پیمانکار / فروشنده / ... تحویل داده شده است، امکان اصلاح وجود ندارد.';
                    this.showDialogModal = true;
                }
            },

            getAllPercentageDecreases:function () {
                axios.get('/financial/draft/get_percentage_decrease')
                    .then((response) => {
                        this.percentageDecreasesCategory = response.data;
                        this.percentageDecreasesCategory.forEach(category =>{
                            Vue.set(category,"amountDec",0);
                            category.percentage_decrease.forEach(item =>{
                                Vue.set(item,"amountDec",0);
                            });
                        });
                        console.log(JSON.stringify(this.percentageDecreasesCategory));
                        this.percentageDecreasesCategory.forEach((category , index) => {
                            var _isNeed = false;
                            var _necessary = false;
                            var _isChecked = false;
                            var _delivered = false;
                            var selectedValue = '';
                            category.percentage_decrease.forEach(item => {
                                var isExist = false;
                                if (this.contracts.length > 0) {
                                    this.contracts[0].increase_amount.forEach(incAM => {
                                        if (item.pdPiId == incAM.icaPiId) {
                                            isExist = true;
                                            _isChecked = true;
                                            _necessary = true;
                                            _isNeed = true;
                                        }
                                    });
                                }

                                this.checks.forEach(check => {
                                    if (check.cPdId == item.id) {
                                        isExist = true;
                                        _isChecked = true;
                                        if (check.cDelivered) {
                                            _delivered = true;
                                            _isNeed = true;
                                        }
                                    }
                                });

                                if (isExist)
                                    Vue.set(item, "amountDec", Math.round((item.pdPercent * this.draftAmount) / 100));
                                else
                                    Vue.set(item, "amountDec", 0);
                                Vue.set(item, "checked", _isChecked);
                                Vue.set(item, "delivered", _delivered);
                                selectedValue = _isChecked == true ? item.id : '';
                            });
                            Vue.set(category, "isNeed", _isNeed);
                            Vue.set(category, "necessary", _necessary);
                            Vue.set(category, "delivered", _delivered);
                            this.percentDecInput['percentage' + category.id] = selectedValue;
                            if (_isChecked)
                                this.calculatePercentAmount(selectedValue , index);
                        });

                        this.calculateFinalIncAmount();
                        console.log(response);
                    }, (error) => {
                        console.log(error);
                    });

            },

            calculatePercentAmount: function (pdId, catIndex) {
                if (pdId != '')
                {
                    var selectedPercent = null;
                    this.percentageDecreasesCategory.forEach(percentageDecrease =>{
                        percentageDecrease.percentage_decrease.forEach(item =>{
                            if (item.id == pdId)
                                selectedPercent = item;
                        });
                    });
                    if (selectedPercent != null)
                    {
                        this.checkEdited = true;
                        var tempAmount = Math.round((selectedPercent.pdPercent * parseInt(this.draftAmount,10)) / 100);
                        var amountDec = 0;
                        this.percentageDecreasesCategory.forEach(category =>{
                            category.percentage_decrease.forEach(item => {
                                if (selectedPercent.id == item.id) {
                                    Vue.set(item, "amountDec", tempAmount);
                                    Vue.set(item, "checked", true);
                                    amountDec = tempAmount;
                                }
                            });
                        });
                        Vue.set(this.percentageDecreasesCategory[catIndex], "amountDec", amountDec);
                        console.log(JSON.stringify(this.percentageDecreasesCategory));
                    }
                }else{
                    this.percentageDecreasesCategory[catIndex].percentage_decrease.forEach(item => {
                        Vue.set(item,"amountDec",0);
                        Vue.set(item,"checked",false);
                    });
                    Vue.set(this.percentageDecreasesCategory[catIndex], "amountDec", 0);
                }
                this.calculateFinalIncAmount();
            },

            calculateFinalIncAmount: function(){
                console.log(JSON.stringify(this.percentageDecreasesCategory));
                var lastTemp=0;
                this.percentageDecreasesCategory.forEach(category =>{
                    category.percentage_decrease.forEach(item => {
                        lastTemp += item.amountDec;
                    });
                });

                this.finalIncAmount = Math.round(this.draftAmount - lastTemp);
            },

            openAcceptGeneratecheckConfirmModal:function (){
                if (this.checkEdited || this.checkSize)
                    this.showAcceptGeneratecheckConfirmModal=true;
                else{
                    this.dialogMessage = 'تغییری در مبلغ چک ها ایجاد نشده است!';
                    this.showDialogModal = true;
                }
            },

            generateChecks: function () {
                this.decreases = [];
                console.log(JSON.stringify(this.percentageDecreasesCategory));
                this.percentageDecreasesCategory.forEach(category => {
                    category.percentage_decrease.forEach(item => {
                        var decreasesTemp={};
                        if(item.checked){
                            decreasesTemp.id=item.id;
                            decreasesTemp.amount=item.amountDec;
                            this.decreases.push(decreasesTemp);
                        }
                    });
                });
                console.log(JSON.stringify(this.decreases));
                axios.post('/financial/check/generate', {
                    rId: this.requestId,
                    dId:this.draftId,
                    decreases:this.decreases,
                    baseCheckAmount:this.finalIncAmount
                }).then((response) => {
                    this.$emit('updateReceiveRequestData' , response.data , this.requestId);
                    this.$emit('closeModal');
                    this.showAcceptGeneratecheckConfirmModal = false;
                    this.showPdfModal = false;
                    this.$root.displayNotif(response.status);
                    console.log(response);
                }, (error) => {
                    console.log(error);
                    this.$root.displayNotif(error.response.status);
                });
            },

            openReferralModal:function () {
                this.$emit('openReferralsModal' , this.draftId , null);
            },

            openBlockModal: function () {
                this.blockInput = {};
                if (this.checks.length == 0)
                    this.showBlockModal = true;
                else
                {
                    this.dialogMessage = 'با توجه به اینکه برای حواله چک صادر شده است، امکان مسدود کردن حواله وجود ندارد.';
                    this.showDialogModal = true;
                }
            },

            requestBlock: function () {
                this.$validator.validateAll().then((result) => {
                    if (result) {
                        axios.post('/financial/draft/block' , {
                            dId: this.draftId,
                            description: this.blockInput.description
                        })
                            .then((response) => {
                                this.$emit('updateReceiveRequestData' , response.data , this.requestId);
                                this.draftIsBlocked = true;
                                this.showBlockModal = false;
                                this.$root.displayNotif(response.status);
                            },(error) => {
                                console.log(error);
                                this.$root.displayNotif(error.response.status);
                            });
                    }
                });
            },

            openResponseRequestModal:function () {
                this.$emit('openResponseRequestModal' , this.draftId , null);
            },

        }
    }
</script>
