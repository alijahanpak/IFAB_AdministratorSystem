<template xmlns:v-on="http://www.w3.org/1999/xhtml">
    <div class="grid-x">
        <div class="large-12 medium-12 small-12" v-if="$can('FINANCIAL_ADD_NEW_DRAFT')">
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
                        <th class="tbl-head-style-cell">مبلغ صورت وضعیت </th>
                        <th class="tbl-head-style-cell">مبلغ حواله </th>
                        <th class="tbl-head-style-cell">وضعیت</th>
                        <th class="tbl-head-style-cell"></th>
                    </tr>
                    </tbody>
                    <!--Table Head End-->
                    <!--Table Body Start-->
                </table>
                <div class="tbl_body_style dynamic-height-level-modal2">
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
                                                <suggestions autocomplete="off" style="margin-bottom: -18px;" name="forTitle" v-validate :class="{'input': true, 'select-error': errors.has('forTitle')}"
                                                             v-model="draftInput.for"
                                                             :options="forOptions"
                                                             :onInputChange="onForInputChange">
                                                    <div slot="item" slot-scope="props" class="single-item">
                                                        <strong>{{props.item}}</strong>
                                                    </div>
                                                </suggestions>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="grid-x input-margin-top">
                                        <div class="large-12 medium-12 small-12 padding-lr">
                                            <label>در وجه
                                                <suggestions autocomplete="off" style="margin-bottom: -18px;" name="payToTitle" v-validate :class="{'input': true, 'select-error': errors.has('payToTitle')}"
                                                             v-model="draftInput.payTo"
                                                             :options="payToOptions"
                                                             :onInputChange="onPayToInputChange">
                                                    <div slot="item" slot-scope="props" class="single-item">
                                                        <strong>{{props.item}}</strong>
                                                    </div>
                                                </suggestions>
                                            </label>
                                        </div>
                                    </div>
                                    <div v-if="requestType == 'BUY_SERVICES'" style="margin-top:15px;"  class="grid-x">
                                        <div class="large-6 medium-6 small-12 padding-lr">
                                            <label>مبلغ<span class="btn-red">(ریال)</span>
                                                <money v-if="moneyState== 'none'" @change.native="calculateDraftAmount()" v-model="draftInput.baseAmount"  v-bind="money" class="form-input input-lg text-margin-btm"  v-validate="'required'" :class="{'input': true, 'error-border': errors.has('baseAmount')}"></money>
                                                <money v-if="moneyState== 'block'" @change.native="calculateDraftAmount()" v-model="draftInput.baseAmount"  v-bind="money" class="form-input input-lg text-margin-btm select-error"  v-validate="'required'" :class="{'input': true, 'error-border': errors.has('baseAmount')}"></money>
                                            </label>
                                            <p v-show="errors.has('baseAmount')" class="error-font"> مبلغ صورت وضعیت مورد نظر نامعتبر است!</p>
                                            <p style="margin-top: 10px;" v-show="moneyState== 'block'" class="btn-red">مبلغ صورت وضعیت مورد نظر نامعتبر است!</p>
                                        </div>
                                    </div>
                                    <div v-if="requestType == 'BUY_COMMODITY'" style="margin-top:15px;"  class="grid-x">
                                        <div class="large-6 medium-6 small-12 padding-lr">
                                            <label v-show="requestType == 'BUY_COMMODITY'">مبلغ<span class="btn-red">(ریال)</span>
                                                <money v-if="moneyState== 'none'" @change.native="calculateDraftAmount()" v-model="draftInput.baseAmount"  v-bind="money" class="form-input input-lg text-margin-btm"  v-validate="'required'" :class="{'input': true, 'error-border': errors.has('baseAmount')}"></money>
                                                <money v-if="moneyState== 'block'" @change.native="calculateDraftAmount()" v-model="draftInput.baseAmount"  v-bind="money" class="form-input input-lg text-margin-btm select-error"  v-validate="'required'" :class="{'input': true, 'error-border': errors.has('baseAmount')}"></money>
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

        <!-- Accept Draft modal -->
        <modal-tiny v-if="showAcceptConfirmModal" @close="showAcceptConfirmModal = false">
            <div slot="body">
                <div class="small-font" xmlns:v-on="http://www.w3.org/1999/xhtml">
                    <p class="black-color text-justify" style="font-size: 1rem">کاربر گرامی:</p>
                    <p class="large-offset-1 modal-text">تایید اطلاعات فاکتور به منزله ایجاد تعهد در محل های تامین اعتبار است، آیا صحت اطلاعات را تایید می کنید؟</p>
                    <div class="grid-x">
                        <div class="medium-12 column text-center">
                            <button v-on:click="acceptFactor"   class="my-button my-success"><span class="btn-txt-mrg">   بله   </span></button>
                        </div>
                    </div>
                </div>
            </div>
        </modal-tiny>
        <!-- Accept Draft modal -->

        <!-- pdf  modal -->
        <modal-small v-if="showPdfModal" @close="showPdfModal = false">
            <div style="height: 90vh;" slot="body">
                <div class="grid-x">
                    <div class="large-12 medium-12 small-12">
                        <ul class="tabs tab-color my-tab-style" data-responsive-accordion-tabs="tabs medium-accordion large-tabs" id="draftAndCheck_tab_view">
                            <li class="tabs-title is-active"><a href="#DraftTab" aria-selected="true">حواله</a></li>
                            <li class="tabs-title"><a href="#CheckTab">چک</a></li>
                        </ul>
                        <div class="tabs-content" data-tabs-content="draftAndCheck_tab_view">
                            <!--Draft Tab -->
                            <div class="tabs-panel is-active table-mrg-btm" id="DraftTab">
                                <div class="grid-x" :style="{ width: '100%' , height: !draftIsBlocked ? '74.5vh' : '81vh'}">
                                    <div class="large-12">
                                        <vue-element-loading style="width: 100%;" :active="showLoaderProgress" spinner="line-down" color="#716aca"/>
                                        <embed style="width: 100%;height: 100%" :src="draftPdfPath" />
                                    </div>
                                </div>
                                <div class="grid-x" v-if="!draftIsBlocked">
                                    <div style="margin-bottom:-20px;margin-top: 5px;" class="large-12 medium-12 small-12">
                                        <div class="stacked-for-small button-group float-right">
                                            <button v-if="$can('FINANCIAL_REGISTER_AND_NUMBERING_DRAFT')" @click="openRegisterAndNumberingModal()"  class="my-button my-success"><span class="btn-txt-mrg">   ثبت در دبیرخانه   </span></button>
                                            <button v-if="$can('FINANCIAL_ACCEPT_DRAFT') && youAreDraftVerifier" @click="acceptDraft()"  class="my-button my-success"><span class="btn-txt-mrg">   تایید و امضا   </span></button>
                                            <button v-if="$can('FINANCIAL_ACCEPT_MINUTE_DRAFT') && isMinute" @click="openAcceptMinuteConfirmModal()"  class="my-button my-success"><span class="btn-txt-mrg">   تایید پیشنویس   </span></button>
                                            <button v-if="$can('FINANCIAL_DETERMINE_DECREASES_AND_MAKE_CHECKS') && isAccepted" @click="openGenerateChecksModal()"  class="my-button my-success"><span class="btn-txt-mrg">   صدور چک   </span></button>
                                            <button @click="openReferralModal(draftId)"  class="my-button toolbox-btn float-left btn-for-load"><span class="btn-txt-mrg"> ارجاع </span></button>
                                            <button @click="openResponseRequestModal(draftId)" v-show="canResponse == true" class="my-button toolbox-btn float-left btn-for-load"><span class="btn-txt-mrg"> ارجاع </span></button>
                                            <button @click="openBlockModal()" class="my-button toolbox-btn"><span class="btn-txt-mrg">مسدود</span></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--Draft Tab -->
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
                                            <div class="tbl_body_style dynamic-height-level-modal1">
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
                                                        <td v-show="check.cDelivered" class="text-center"><span class="success-label">تحویل داده شده</span></td>
                                                        <td v-show="!check.cDelivered" class="text-center"></td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <!--Table Body End-->
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--Check Tab -->
                    </div>
                </div>
            </div>
        </modal-small>
        <!-- pdf Factor modal -->

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
                                <div  v-for="percentDec in percentageDecreases" class="grid-x">
                                    <div class="large-9 medium-9  small-12">
                                        <div class="grid-x">
                                            <div class="large-2 medium-3  small-12">
                                                <div class="switch tiny">
                                                    <input :checked="percentDecInput['percentage' + percentDec.id] = percentDec.checked" :disabled="percentDec.isNeed == true" v-on:change="calculatePercentAmount(percentDec.pdPercent,percentDec,percentDecInput['percentage' + percentDec.id])" class="switch-input" v-model="percentDecInput['percentage' + percentDec.id]" :id="'percentage'+percentDec.id" type="checkbox">
                                                    <label class="switch-paddle" :for="'percentage'+percentDec.id">
                                                        <span class="switch-active" aria-hidden="true">بلی</span>
                                                        <span class="switch-inactive" aria-hidden="true">خیر</span>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="large-10 medium-9  small-12">
                                                <p>
                                                    {{percentDec.pdSubject}}
                                                    <span class="btn-red size-12" v-if="percentDec.necessary"> - الزامی</span>
                                                    <span class="btn-red size-12" v-if="percentDec.delivered"> - تحویل داده شده</span>
                                                    {{'(' + percentDec.pdPercent + '%)'}}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="large-3 medium-3  small-12">
                                        <p class="btn-red">{{$root.dispMoneyFormat(percentDec.amountDec)}} ریال</p>
                                    </div>
                                </div>
                            </div>
                            <div style="margin-top: -16px;border-top: 1px solid #E0E0E0;" class="panel-separator padding-lr">
                                <div class="grid-x">
                                    <div class="large-9 medium-9  small-12">
                                        <div class="grid-x">
                                            <div class="large-2 medium-3  small-12"></div>
                                            <div class="large-10 medium-9  small-12">
                                                <p>مبلغ حواله : </p>
                                                <p>مبلغ چک <span> {{draftFor}} </span> </p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="large-3 medium-3  small-12">
                                        <p class="btn-red">{{$root.dispMoneyFormat(draftAmount)}} ریال</p>
                                        <p class="btn-red">{{$root.dispMoneyFormat(finalIncAmount)}} ریال</p>
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
        props:['drafts','requestId','rAcceptedAmount','rCommitmentAmount','contracts','factors','requestType' , 'sumOfDraftAmount'],
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
                registerDate: '',
                letterNumber: '',
                moneyState:'none',
                percentageDecreases:[],
                percentDecInput:{},
                isAccepted: false,

                decreases:[],
                draftAmount:0,
                draftFor:'',
                finalIncAmount:0,
                checks:[],
                draftIsBlocked: true,
                showLoaderProgress:false,
                checkEdited: false,
                checkBaseDelivered: false,
                canResponse:'',
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

        },

        methods : {
            openPdfModal: function (draft){
              this.checks=[];
              var draftHistory=[];
              draftHistory.push(draft);
              this.draftId=draft.id;
              this.youAreDraftVerifier=draft.dYouAreVerifier;
              this.isMinute=draft.dIsMinute;
              this.isAccepted = draft.verifier[0].dvSId != null ? true : false;
              this.draftAmount=draft.dAmount;
              this.draftFor=draft.dFor;
                this.canResponse = draft.dLastRef.rhIsReferral;
              this.openReportFile();
              this.draftPdfPath='';
              this.draftIsBlocked = draft.draft_state.dsState == 'BLOCKED' ? true : false;
              this.showPdfModal=true;

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
                if(this.contracts.length >0)
                    this.forItems = this.contracts;
                else
                    this.forItems = this.factors;
                this.forList= [];
                this.payToList= [];
                if(this.contracts.length >0){
                    this.forItems.forEach(item=> {
                        this.forList.push(item.cSubject +' - ' + item.cLetterNumber + ' - ' + item.cLetterDate);
                        this.payToList.push(item.executor.eSubject);
                    });
                }
                else{
                    this.forItems.forEach(item=> {
                        this.forList.push(item.fSubject );
                        this.payToList.push(item.seller.sSubject);
                    });
                }

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
                    var sumOfPrcents=0;
                    var draftBaseAmountTemp=0;

                    baseAmount=parseInt(this.draftInput.baseAmount.split(',').join(''),10);
                    if(this.contracts.length > 0) {
                        this.contracts.forEach(item => {
                            item.increase_amount.forEach(percent => {
                                sumOfPrcents += Math.round((baseAmount * percent.percentage_increase.piPercent) / 100);
                            });
                        });
                        draftBaseAmountTemp = baseAmount + sumOfPrcents;
                    }
                    this.getSumOfLastDrafts();
                    if(this.contracts.length > 0)
                        this.draftBaseAmount = draftBaseAmountTemp - this.lastDrafts;
                    else
                        this.draftBaseAmount = baseAmount - this.lastDrafts;
                    Math.round(this.draftBaseAmount);
                    if(this.contracts.length > 0){
                        if(((this.draftBaseAmount + this.lastDrafts) > this.requestCAmount) || (this.draftBaseAmount < 0))
                            this.moneyState='block';
                        else
                            this.moneyState='none';
                    }
                    else{
                        if(((this.draftBaseAmount + this.lastDrafts) > this.rAcceptedAmount) || (this.draftBaseAmount < 0))
                            this.moneyState='block';
                        else
                            this.moneyState='none';
                    }
            },

            getSumOfLastDrafts: function (){
                var lastDraftTemp=0;
                this.drafts.forEach(item =>{
                    if (item.draft_state.dsState != 'BLOCKED')
                        lastDraftTemp += item.dAmount;
                });
                this.lastDrafts = lastDraftTemp;
            },

            setInitBaseAmount: function (){
                this.getSumOfLastDrafts();
                this.getBaseAmount();
                this.draftInput.baseAmount= this.$root.dispMoneyFormat(this.requestBaseAmount);
                this.calculateDraftAmount();

            },

            getBaseAmount: function(){
                if(this.contracts.length > 0){
                    this.contracts.forEach(item =>{
                        this.requestBaseAmount += item.cBaseAmount;
                        this.requestCAmount += item.cAmount;
                    });
                }
                else{
                    this.requestBaseAmount=this.rAcceptedAmount;
                }
            },

            openReportFile: function () {
                this.showLoaderProgress = true;
                axios.post('/financial/report/draft' , {dId: this.draftId})
                    .then((response) => {
                        console.log(response.data);
                        this.showLoaderProgress = false;
                        this.draftPdfPath=response.data;
                    },(error) => {
                        console.log(error);
                    this.showLoaderProgress = false;
                    });
            },

            checkAcceptDraft: function(){
                var existNotAccepted = false;
                this.factors.forEach(item => {
                    if (item.fIsAccepted == false)
                        existNotAccepted = true;
                });

                if (existNotAccepted)
                {
                    this.showAcceptConfirmModal = true;
                }else{
                    this.dialogMessage = 'حواله تایید نشده ای موجود نیست! لطفا قبل از تایید اطلاعات حواله نسبت به ثبت حواله جدید اقدام کنید.';
                    this.showDialogModal = true;
                }
            },

            openConfirmDeleteContract: function(cId){
                this.fIdForDelete = cId;
                this.showDeleteConfirmModal = true;
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
                        var isValid=true;
                        if(this.contracts.length > 0){
                            if(((this.draftBaseAmount + this.lastDrafts) > this.requestCAmount) || (this.draftBaseAmount < 0)){
                                this.dialogMessage = 'مبلغ  صورت وضعیت نامعتبر است!';
                                this.showDialogModal = true;
                                isValid=false;
                            }
                        }
                        else {
                            if(((this.draftBaseAmount + this.lastDrafts) > this.rAcceptedAmount) || (this.draftBaseAmount < 0)){
                                this.dialogMessage = 'مبلغ  صورت وضعیت نامعتبر است!';
                                this.showDialogModal = true;
                                isValid=false;
                            }
                        }
                        if(isValid){
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
                        this.percentageDecreases = response.data;
                        this.percentageDecreases.forEach(item =>{
                            Vue.set(item,"amountDec",0);
                        });
                        console.log(JSON.stringify(this.percentageDecreases));
                        this.percentageDecreases.forEach(item => {
                            var isExist=false;
                            var isNeed = false;
                            var isChecked = false;
                            var necessary = false;
                            var delivered = false;
                            if (this.contracts.length > 0)
                            {
                                this.contracts[0].increase_amount.forEach(incAM =>{
                                    if(item.pdPiId == incAM.icaPiId){
                                        isExist = true;
                                        isNeed = true;
                                        isChecked = true;
                                        necessary = true;
                                    }
                                });
                            }

                            this.checks.forEach(check => {
                                if (check.cPdId == item.id)
                                {
                                    isExist = true;
                                    isChecked = true;
                                    if (check.cDelivered)
                                    {
                                        delivered = true;
                                        isNeed = true;
                                    }
                                }
                            });

                            if(isExist)
                                Vue.set(item,"amountDec",Math.round((item.pdPercent * this.draftAmount) / 100));
                            else
                                Vue.set(item,"amountDec",0);
                            Vue.set(item,"isNeed",isNeed);
                            Vue.set(item,"checked",isChecked);
                            Vue.set(item,"necessary",necessary);
                            Vue.set(item,"delivered",delivered);
                        });

                        this.calculteFinalIncAmount();
                        console.log(response);
                    }, (error) => {
                        console.log(error);
                    });

            },

            calculatePercentAmount: function (percent,index,state) {
                var decreasesTemp={};
                this.checkEdited = true;
                decreasesTemp.id=index.id;
                decreasesTemp.amount = Math.round((percent * parseInt(this.draftAmount,10)) / 100);
                Math.round(decreasesTemp.amount);
                if(state == false){
                    this.percentageDecreases.forEach(item =>{
                        if(item.id == decreasesTemp.id){
                            this.percentageDecreases.forEach(item =>{
                                if(index.id == item.id){
                                    Vue.set(item,"amountDec",0);
                                    Vue.set(item,"checked",false);
                                }
                            });
                            //this.percentageDecreases.splice(pos,1);
                        }
                    });
                }
                if(state == true){
                    this.percentageDecreases.forEach(item =>{
                        if(index.id == item.id){
                            Vue.set(item,"amountDec",decreasesTemp.amount);
                            Vue.set(item,"checked",true);
                        }
                    });

                }
                console.log(JSON.stringify(this.percentageDecreases));
                this.calculteFinalIncAmount();
            },

            calculteFinalIncAmount: function(){
                console.log(JSON.stringify(this.percentageDecreases));
                var lastTemp=0;
                this.percentageDecreases.forEach(item =>{
                    lastTemp += item.amountDec;
                });

                this.finalIncAmount =this.draftAmount - lastTemp;
                Math.round(this.finalIncAmount);
            },

            openAcceptGeneratecheckConfirmModal:function (){
                if (this.checkEdited)
                    this.showAcceptGeneratecheckConfirmModal=true;
                else{
                    this.dialogMessage = 'تغییری در مبلغ چک ها ایجاد نشده است!';
                    this.showDialogModal = true;
                }
            },

            generateChecks: function () {
                this.decreases = [];
                console.log(JSON.stringify(this.percentageDecreases));
                this.percentageDecreases.forEach(item => {
                    var decreasesTemp={};
                    if(item.checked){
                        decreasesTemp.id=item.id;
                        decreasesTemp.amount=item.amountDec;
                        this.decreases.push(decreasesTemp);
                    }
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
