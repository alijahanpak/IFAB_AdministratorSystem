<template xmlns:v-on="http://www.w3.org/1999/xhtml" xmlns:v-bind="http://www.w3.org/1999/xhtml">
    <!--Inner body start-->
    <div class="medium-10 border-right-line inner-body-pad main-margin">
        <div class="grid-x padding-lr breadcrumbs-pos">
            <div class="medium-12">
                <div class="grid-x">
                    <nav aria-label="You are here:" role="navigation">
                        <ul class="breadcrumbs">
                            <li><router-link to="/budget">داشبورد</router-link></li>
                            <li>
                                <a class="disabled">توزیع اعتبار</a>
                            </li>
                            <li>
                                <a class="disabled">تملک دارایی های سرمایه ای</a>
                            </li>
                            <li>
                                <a class="disabled">استانی</a>
                            </li>
                            <li>
                                <span class="show-for-sr">Current: </span> پیشنهاد بودجه
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
        <div class="grid-x my-callout-box container-mrg-top dynamic-height-level1">
                <div class="medium-12 padding-lr" style="margin-top: 15px;">
                    <div class="clearfix tool-bar">
                        <div class="button-group float-right report-mrg">
                            <a class="my-button toolbox-btn small" @click="openInsertModal">جدید</a>
                            <div v-if="!selectColumn" class="input-group-button toggle-icon-change">
                                <button type="button" class="my-button my-icon-brand tiny" @click="showSelectColumn(proposals)"><i class="fa fa-check-square-o size-14" aria-hidden="true"></i></button>
                            </div>
                            <div v-if="selectColumn" class="input-group-button toggle-icon-change">
                                <button type="button" class="my-button my-icon-danger tiny" @click="showSelectColumn(proposals)"><i class="fa fa-times size-14" aria-hidden="true"></i></button>
                            </div>
                            <button class="my-button toolbox-btn small dropdown small sm-btn-align"  type="button" data-toggle="reportDropDownPlan">گزارش</button>
                            <div  style="width: 113px;" class="dropdown-pane dropdown-pane-sm " data-close-on-click="true"  data-hover="true" data-hover-pane="true"  data-position="bottom" data-alignment="left" id="reportDropDownPlan" data-dropdown data-auto-focus="true">
                                <ul class="my-menu small-font ltr-dir">
                                    <li><a @click="openReportModal('pdf')"><i class="fa fa-file-pdf-o icon-margin-dropdown" aria-hidden="true"></i>PDF</a></li>
                                    <li><a @click="openReportModal('excel')"><i class="fa fa-file-excel-o icon-margin-dropdown" aria-hidden="true"></i>Excel</a></li>
                                </ul>
                            </div>
                            <button class="my-button toolbox-btn small dropdown small sm-btn-align"  type="button" data-toggle="assetsDropDown">تعداد نمایش<span> 20 </span></button>
                            <div  style="width: 113px;" class="dropdown-pane dropdown-pane-sm " data-close-on-click="true"  data-hover="true" data-hover-pane="true"  data-position="bottom" data-alignment="left" id="assetsDropDown" data-dropdown data-auto-focus="true">
                                <ul class="my-menu small-font ltr-dir">
                                    <li><a  href="#">10</a></li>
                                    <li><a  href="#">20<span class="fi-check checked-color size-14"></span></a></li>
                                    <li><a  href="#">30</a></li>
                                    <li><a  href="#">50</a></li>
                                    <li><a  href="#">100</a></li>
                                    <li><a  href="#">200</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="float-right cost-label-2">
                            <span class="small-font">{{ costTemp }}</span>
                        </div>
                        <div class="float-left">
                            <div class="input-group float-left">
                                <div class="inner-addon right-addon">
                                    <i v-if="searchOfferValue == ''" class="fa fa-search purple-color"  aria-hidden="true"></i>
                                    <i v-if="searchOfferValue != ''" class="fa fa-close btn-red"  aria-hidden="true"></i>
                                    <input v-model="searchOfferValue" class="search" type="text" placeholder="جستوجو">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div  class="medium-12 column padding-lr">
                    <div class="tbl-div-container">
                        <table class="tbl-head">
                            <colgroup>
                                <col width="100px"/>
                                <col width="150px"/>
                                <col width="150px"/>
                                <col width="150px"/>
                                <col width="100px"/>
                                <col width="200px"/>
                                <col v-show="selectColumn" width="15px"/>
                                <col width="12px"/>
                            </colgroup>
                            <tbody class="tbl-head-style">
                            <tr class="tbl-head-style-cell">
                                <th class="tbl-head-style-cell">شهرستان</th>
                                <th class="tbl-head-style-cell">طرح</th>
                                <th class="tbl-head-style-cell">کد پروژه</th>
                                <th class="tbl-head-style-cell">عنوان</th>
                                <th class="tbl-head-style-cell">اعتبار</th>
                                <th class="tbl-head-style-cell">شرح</th>
                                <th class="tbl-head-style-checkbox" v-show="selectColumn"><input type="checkbox" @click="toggleSelect(proposals)" :checked="allSelected(proposals)"></th>
                                <th class="tbl-head-style-cell"></th>
                            </tr>
                            </tbody>
                        </table>

                        <div class="tbl_body_style dynamic-height-level2">
                            <table class="tbl-body-contain">
                                <colgroup>
                                    <col width="100px"/>
                                    <col width="150px"/>
                                    <col width="150px"/>
                                    <col width="150px"/>
                                    <col width="100px"/>
                                    <col width="200px"/>
                                    <col v-show="selectColumn" width="15px"/>
                                </colgroup>
                                <tbody class="tbl-head-style-cell">
                                <template v-for="county in proposals">
                                    <tr class="tbl-head-style-cell">
                                        <td :rowspan="getPlanProposalCount(county.credit_distribution_plan_has_proposal)">{{ county.coName }}</td>
                                        <td :rowspan="county.credit_distribution_plan_has_proposal[0].proposal.length">{{ county.credit_distribution_plan_has_proposal[0].credit_distribution_title.cdtIdNumber + ' - ' + county.credit_distribution_plan_has_proposal[0].credit_distribution_title.cdtSubject }}</td>
                                        <td>{{ county.credit_distribution_plan_has_proposal[0].proposal[0].pbpCode  }}</td>
                                        <td>{{ county.credit_distribution_plan_has_proposal[0].proposal[0].pbpSubject }}</td>
                                        <td>{{ $parent.calcDispAmount(county.credit_distribution_plan_has_proposal[0].proposal[0].pbpAmount , false)  }}</td>
                                        <td>
                                            <div class="grid-x">
                                                <div class="medium-11 text-justify">
                                                    {{ county.credit_distribution_plan_has_proposal[0].proposal[0].pbpDescription }}
                                                </div>
                                                <div class="medium-1 cell-vertical-center text-left">
                                                    <a class="dropdown small sm-btn-align"  type="button" :data-toggle="'pProposal' + county.id"><i class="fa fa-ellipsis-v size-18"></i></a>
                                                    <div class="dropdown-pane dropdown-pane-sm " data-close-on-click="true"  data-hover="true" data-hover-pane="true"  data-position="bottom" data-alignment="right" :id="'pProposal' + county.id" data-dropdown data-auto-focus="true">
                                                        <ul class="my-menu small-font text-right">
                                                            <li><a v-on:click.prevent="openUpdateModal(county.credit_distribution_plan_has_proposal[0].proposal[0] , county.credit_distribution_plan_has_proposal[0].cdpCoId)"><i class="fa fa-pencil-square-o size-16"></i>  ویرایش</a></li>
                                                            <li><a v-on:click.prevent="openDeleteModal(county.credit_distribution_plan_has_proposal[0].proposal[0].id)"><i class="fa fa-trash-o size-16"></i>  حذف</a></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td  v-show="selectColumn">
                                            <input class="auto-margin" v-model="county.credit_distribution_plan_has_proposal[0].proposal[0].checked" type="checkbox">
                                        </td>
                                    </tr>
                                    <template v-for="(plan , pIndex) in county.credit_distribution_plan_has_proposal">
                                        <tr class="tbl-head-style-cell" v-if="pIndex > 0">
                                            <td :rowspan="plan.proposal.length">{{ plan.credit_distribution_title.cdtIdNumber + ' - ' + plan.credit_distribution_title.cdtSubject }}</td>
                                            <td>{{ plan.proposal[0].pbpCode  }}</td>
                                            <td>{{ plan.proposal[0].pbpSubject }}</td>
                                            <td>{{ $parent.calcDispAmount(plan.proposal[0].pbpAmount , false)  }}</td>
                                            <td>
                                                <div class="grid-x">
                                                    <div class="medium-11 text-justify">
                                                        {{ plan.proposal[0].pbpDescription }}
                                                    </div>
                                                    <div class="medium-1 cell-vertical-center text-left">
                                                        <a class="dropdown small sm-btn-align"  type="button" :data-toggle="'ppProposal' + county.id + plan.id"><i class="fa fa-ellipsis-v size-18"></i></a>
                                                        <div class="dropdown-pane dropdown-pane-sm " data-close-on-click="true"  data-hover="true" data-hover-pane="true"  data-position="bottom" data-alignment="right" :id="'ppProposal' + county.id + plan.id" data-dropdown data-auto-focus="true">
                                                            <ul class="my-menu small-font text-right">
                                                                <li><a v-on:click.prevent="openUpdateModal(plan.proposal[0] , plan.cdpCoId)"><i class="fa fa-pencil-square-o size-16"></i>  ویرایش</a></li>
                                                                <li><a v-on:click.prevent="openDeleteModal(plan.proposal[0].id)"><i class="fa fa-trash-o size-16"></i>  حذف</a></li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td  v-show="selectColumn">
                                                <input class="auto-margin" v-model="plan.proposal[0].checked" type="checkbox">
                                            </td>
                                        </tr>
                                        <template v-for="(proposal , ppIndex) in plan.proposal">
                                            <tr class="tbl-head-style-cell" v-if="ppIndex > 0">
                                                <td>{{ proposal.pbpCode  }}</td>
                                                <td>{{ proposal.pbpSubject }}</td>
                                                <td>{{ $parent.calcDispAmount(proposal.pbpAmount , false)  }}</td>
                                                <td>
                                                    <div class="grid-x">
                                                        <div class="medium-11 text-justify">
                                                            {{ proposal.pbpDescription }}
                                                        </div>
                                                        <div class="medium-1 cell-vertical-center text-left">
                                                            <a class="dropdown small sm-btn-align"  type="button" :data-toggle="'proposal' + county.id + plan.id + proposal.id"><i class="fa fa-ellipsis-v size-18"></i></a>
                                                            <div class="dropdown-pane dropdown-pane-sm " data-close-on-click="true"  data-hover="true" data-hover-pane="true"  data-position="bottom" data-alignment="right" :id="'proposal' + county.id + plan.id + proposal.id" data-dropdown data-auto-focus="true">
                                                                <ul class="my-menu small-font text-right">
                                                                    <li><a v-on:click.prevent="openUpdateModal(proposal , plan.cdpCoId)"><i class="fa fa-pencil-square-o size-16"></i>  ویرایش</a></li>
                                                                    <li><a v-on:click.prevent="openDeleteModal(proposal.id)"><i class="fa fa-trash-o size-16"></i>  حذف</a></li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td  v-show="selectColumn">
                                                    <input class="auto-margin" v-model="proposal.checked" type="checkbox">
                                                </td>
                                            </tr>
                                        </template>
                                    </template>
                                </template>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="grid-x">
                        <div class="medium-8">
                            <vue-pagination  v-bind:pagination="pagination"
                                             v-on:click.native="fetchData(pagination.current_page)"
                                             :offset="4">
                            </vue-pagination>
                        </div>
                        <div style="color: #575962;" v-show="selectColumn" class="medium-4 small-font">
                            <div class="float-left">
                                <p> تعداد رکورد های انتخاب شده :<span class="selected-row-style">{{ selectedLength(proposals) }}</span></p>
                            </div>
                        </div>
                    </div>
                </div>
                <!--Forms Start-->
                <!--Insert Modal Start-->
                <modal-small v-if="showInsertModal" @close="showInsertModal = false" xmlns:v-on="http://www.w3.org/1999/xhtml">
                    <div  slot="body">
                        <form v-on:submit.prevent="createCdpProposal">
                            <div class="grid-x" v-if="errorMessage">
                                <div class="medium-12 columns padding-lr">
                                    <div class="alert callout">
                                        <p class="BYekan login-alert"><i class="fi-alert"></i>{{ errorMessage }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="grid-x">
                                <div class="medium-4 cell padding-lr">
                                    <label>شهرستان
                                        <select class="form-element-margin-btm" name="pCounty" v-model="selectedCounty" @change="getCDPWithCoId" v-validate data-vv-rules="required" :class="{'input': true, 'select-error': errors.has('pCounty')}">
                                            <option value=""></option>
                                            <option v-for="county in counties" :value="county.id">{{ county.coName }}</option>
                                        </select>
                                        <span v-show="errors.has('pCounty')" class="error-font">شهرستان را انتخاب کنید!</span>
                                    </label>
                                </div>
                                <div class="medium-8 cell padding-lr">
                                    <label>طرح
                                        <select class="form-element-margin-btm" name="planCode" v-model="cdpProposalInput.cdpId" @change="getRemianingAmount(cdpProposalInput.cdpId)" v-validate data-vv-rules="required" :class="{'input': true, 'select-error': errors.has('planCode')}">
                                            <option value=""></option>
                                            <option v-for="cdp in creditDistributionPlans" :value="cdp.id">{{ cdp.credit_distribution_title.cdtIdNumber + ' - ' + cdp.credit_distribution_title.cdtSubject + ' - ' + ' فصل ' + cdp.credit_distribution_title.budget_season.bsSubject + ' - ' + ' ردیف ' + cdp.credit_distribution_row.cdSubject + ' - ' + ' با اعتبار ' + $parent.calcDispAmount(cdp.cdpCredit) }}</option>
                                        </select>
                                    </label>
                                    <span v-show="errors.has('planCode')" class="error-font">کد طرح مورد نظر را انتخاب کنید!</span>
                                </div>
                            </div>
                            <div class="grid-x my-callout-bg-color" style="margin-top: 10px;margin-bottom: 10px" v-show="cdpProposalInput.cdpId != null && cdpProposalInput.cdpId != ''">
                                <div class="medium-12">
                                    <span>اعتبار باقیمانده: </span><span class="btn-red" id="pbpPlanAmount" style="margin-bottom: 0;">{{ remainingAmount }} </span><span>{{ '(' + $parent.getAmountBaseLabel() + ')' }}</span>
                                </div>
                            </div>
                            <div class="grid-x">
                                <div class="medium-12 columns padding-lr">
                                    <label>عنوان پروژه
                                        <input class="form-element-margin-btm" type="text" name="projectTitle" v-model="cdpProposalInput.pSubject" v-validate data-vv-rules="required" :class="{'input': true, 'select-error': errors.has('projectTitle')}">
                                    </label>
                                    <span v-show="errors.has('projectTitle')" class="error-font">عنوان پروژه فراموش شده است!</span>
                                </div>
                            </div>
                            <div class="grid-x">
                                <div class="medium-6 columns padding-lr">
                                    <label>کد پروژه
                                        <input class="form-element-margin-btm" type="text" name="projectCode" v-model="cdpProposalInput.pCode" v-validate data-vv-rules="required" :class="{'input': true, 'select-error': errors.has('projectCode')}">
                                    </label>
                                    <span v-show="errors.has('projectCode')" class="error-font">کد پروژه فراموش شده است!</span>
                                </div>
                                <div class="medium-6 columns padding-lr">
                                    <label><span>مبلغ اعتبار</span><span style="color: #D9534F;"></span>
                                        <input class="form-element-margin-btm" type="text" name="pAmount" v-model="cdpProposalInput.pAmount" v-validate data-vv-rules="required" :class="{'input': true, 'select-error': errors.has('pAmount')}">
                                    </label>
                                    <span v-show="errors.has('pAmount')" class="error-font">مبلغ اعتبار فراموش شده است!</span>
                                </div>
                            </div>
                            <div class="grid-x">
                                <div class="small-12 columns padding-lr">
                                    <label>شرح
                                        <textarea name="pDescription" style="min-height: 150px;" v-model="cdpProposalInput.pDescription"></textarea>
                                    </label>
                                </div>
                            </div>
                            <div class="medium-6 columns padding-lr padding-bottom-modal">
                                <button name="Submit" class="my-button my-success float-left btn-for-load"> <span class="btn-txt-mrg">ثبت</span></button>
                            </div>
                        </form>
                    </div>
                </modal-small>
                <!--Insert Modal End-->
            <!--update Modal Start-->
            <modal-small v-if="showUpdateModal" @close="showUpdateModal = false" xmlns:v-on="http://www.w3.org/1999/xhtml">
                <div  slot="body">
                    <form v-on:submit.prevent="updateCdpProposal">
                        <div class="grid-x" v-if="errorMessage">
                            <div class="medium-12 columns padding-lr">
                                <div class="alert callout">
                                    <p class="BYekan login-alert"><i class="fi-alert"></i>{{ errorMessage }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="grid-x">
                            <div class="medium-4 cell padding-lr">
                                <label>شهرستان
                                    <select class="form-element-margin-btm" name="pCounty" v-model="selectedCounty" @change="getCDPWithCoId" v-validate data-vv-rules="required" :class="{'input': true, 'select-error': errors.has('pCounty')}">
                                        <option value=""></option>
                                        <option v-for="county in counties" :value="county.id">{{ county.coName }}</option>
                                    </select>
                                    <span v-show="errors.has('pCounty')" class="error-font">شهرستان را انتخاب کنید!</span>
                                </label>
                            </div>
                            <div class="medium-8 cell padding-lr">
                                <label>طرح
                                    <select class="form-element-margin-btm" name="planCode" v-model="cdpProposalFill.cdpId" @change="getRemianingAmount(cdpProposalFill.cdpId)" v-validate data-vv-rules="required" :class="{'input': true, 'select-error': errors.has('planCode')}">
                                        <option value=""></option>
                                        <option v-for="cdp in creditDistributionPlans" :value="cdp.id">{{ cdp.credit_distribution_title.cdtIdNumber + ' - ' + cdp.credit_distribution_title.cdtSubject + ' - ' + ' فصل ' + cdp.credit_distribution_title.budget_season.bsSubject + ' - ' + ' ردیف ' + cdp.credit_distribution_row.cdSubject + ' - ' + ' با اعتبار ' + $parent.calcDispAmount(cdp.cdpCredit) }}</option>
                                    </select>
                                </label>
                                <span v-show="errors.has('planCode')" class="error-font">کد طرح مورد نظر را انتخاب کنید!</span>
                            </div>
                        </div>
                        <div class="grid-x my-callout-bg-color" style="margin-top: 10px;margin-bottom: 10px" v-show="cdpProposalFill.cdpId != null && cdpProposalFill.cdpId != ''">
                            <div class="medium-12">
                                <span>اعتبار باقیمانده: </span><span class="btn-red" style="margin-bottom: 0;">{{ remainingAmount }} </span><span>{{ '(' + $parent.getAmountBaseLabel() + ')' }}</span>
                            </div>
                        </div>
                        <div class="grid-x">
                            <div class="medium-12 columns padding-lr">
                                <label>عنوان پروژه
                                    <input class="form-element-margin-btm" type="text" name="projectTitle" v-model="cdpProposalFill.pSubject" v-validate data-vv-rules="required" :class="{'input': true, 'select-error': errors.has('projectTitle')}">
                                </label>
                                <span v-show="errors.has('projectTitle')" class="error-font">عنوان پروژه فراموش شده است!</span>
                            </div>
                        </div>
                        <div class="grid-x">
                            <div class="medium-6 columns padding-lr">
                                <label>کد پروژه
                                    <input class="form-element-margin-btm" type="text" name="projectCode" v-model="cdpProposalFill.pCode" v-validate data-vv-rules="required" :class="{'input': true, 'select-error': errors.has('projectCode')}">
                                </label>
                                <span v-show="errors.has('projectCode')" class="error-font">کد پروژه فراموش شده است!</span>
                            </div>
                            <div class="medium-6 columns padding-lr">
                                <label><span>مبلغ اعتبار</span><span style="color: #D9534F;"></span>
                                    <input class="form-element-margin-btm" type="text" name="pAmount" v-model="cdpProposalFill.pAmount" v-validate data-vv-rules="required" :class="{'input': true, 'select-error': errors.has('pAmount')}">
                                </label>
                                <span v-show="errors.has('pAmount')" class="error-font">مبلغ اعتبار فراموش شده است!</span>
                            </div>
                        </div>
                        <div class="grid-x">
                            <div class="small-12 columns padding-lr">
                                <label>شرح
                                    <textarea name="pDescription" style="min-height: 150px;" v-model="cdpProposalFill.pDescription"></textarea>
                                </label>
                            </div>
                        </div>
                        <div class="medium-6 columns padding-lr padding-bottom-modal">
                            <button name="Submit" class="my-button my-success float-left btn-for-load"> <span class="btn-txt-mrg">ثبت</span></button>
                        </div>
                    </form>
                </div>
            </modal-small>
            <!--update Modal End-->
            <!-- Delete Modal Start -->
            <modal-tiny v-if="showDeleteModal" @close="showDeleteModal = false">
                <div  slot="body">
                    <div class="small-font">
                        <p>کاربر گرامی</p>
                        <p class="large-offset-1 modal-text">آیا برای حذف این رکورد اطمینان دارید؟</p>
                        <div class="grid-x">
                            <div class="medium-12 column text-center">
                                <button v-on:click="deleteSelectedProposal" class="my-button my-success"><span class="btn-txt-mrg">   بله   </span></button>
                            </div>
                        </div>
                    </div>
                </div>
            </modal-tiny>
            <!-- Delete Modal End -->
            <!--Report Modal Start-->
            <modal-tiny v-if="showModalReport" @close="showModalReport= false">
                <div  slot="body">
                    <div class="small-font">
                        <form v-on:submit.prevent="openReportFile">
                            <div class="grid-x padding-lr">
                                <div class="medium-12">
                                    <label>عنوان
                                        <input type="text" v-model="reportOptions.title">
                                    </label>
                                </div>
                            </div>
                            <div v-show="reportType == 'pdf'">
                                <div style="margin-top: 10px;" class="grid-x padding-lr">
                                    <div class="medium-2">
                                        <div class="switch tiny">
                                            <input checked="true" class="switch-input" id="yes-no-1" v-model="reportOptions.withReporterName" type="checkbox">
                                            <label class="switch-paddle" for="yes-no-1">
                                                <span class="switch-active" aria-hidden="true">بلی</span>
                                                <span class="switch-inactive" aria-hidden="true">خیر</span>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="medium-10">
                                        <p>درج نام کاربر تهیه کننده گزارش</p>
                                    </div>
                                </div>
                                <div class="grid-x padding-lr">
                                    <div class="medium-2">
                                        <div class="switch tiny">
                                            <input checked="true" class="switch-input" id="yes-no-2" type="checkbox" v-model="reportOptions.withFiscalYear">
                                            <label class="switch-paddle" for="yes-no-2">
                                                <span class="switch-active" aria-hidden="true">بلی</span>
                                                <span class="switch-inactive" aria-hidden="true">خیر</span>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="medium-10">
                                        <p>درج سال مالی</p>
                                    </div>
                                </div>
                                <div class="grid-x padding-lr">
                                    <div class="medium-2">
                                        <div class="switch tiny">
                                            <input checked="true" class="switch-input" id="yes-no3" type="checkbox" v-model="reportOptions.withReportDate">
                                            <label class="switch-paddle" for="yes-no3">
                                                <span class="switch-active" aria-hidden="true">بلی</span>
                                                <span class="switch-inactive" aria-hidden="true">خیر</span>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="medium-10">
                                        <p>درج تاریخ گزارش</p>
                                    </div>
                                </div>
                                <div class="grid-x padding-lr">
                                    <div class="medium-2">
                                        <div class="switch tiny">
                                            <input checked="true" class="switch-input" id="yes-no4" type="checkbox" v-model="reportOptions.orientation">
                                            <label class="switch-paddle" for="yes-no4">
                                                <span class="switch-active" aria-hidden="true">افقی</span>
                                                <span class="switch-inactive" aria-hidden="true">عمودی</span>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="medium-10">
                                        <p>جهت کاغذ</p>
                                    </div>
                                </div>
                            </div>
                            <div class="medium-12 columns padding-lr padding-bottom-modal input-margin-top">
                                <button name="Submit" class="my-button my-success float-left"> <span class="btn-txt-mrg">مشاهده</span></button>
                            </div>
                        </form>
                    </div>
                </div>
            </modal-tiny>

            <!--Report Modal End-->
            </div>
        </div>
    </div>
</template>
<script>
    import VuePagination from '../../../public_component/pagination.vue';
    export default {
        data(){
            return {
                errorMessage: '',
                errorMessage_update: '',
                searchOfferValue:'',
                proposals: [],
                cdpProposalInput: {},
                cdpProposalFill: {},
                showInsertModal: false,
                showUpdateModal: false,
                showDeleteModal: false,
                showModalReport:false,
                selectColumn:false,
                creditDistributionPlans: {},
                counties: {},
                selectCounty: '',
                costTemp:'',
                selectedProposalIdForDelete: '',
                remainingAmount: 0,
                selectedItems: [],
                selectedCount: 0,
                reportOptions: {title:'' , withReporterName: true , withFiscalYear: true , withReportDate: true , orientation: true ,costLabel: true},

                pagination: {
                    total: 0,
                    to: 0,
                    current_page: 1,
                    last_page: ''
                },
            }
        },
        created: function () {
            this.fetchData();
            $(this.$el).foundation(); //WORKS!
        },

        updated: function () {
            $(this.$el).foundation(); //WORKS!
            this.$parent.userIsActive();
            this.costTemp =  ' مبالغ: ' + this.$parent.getDispAmountBaseLabel();
        },

        mounted: function () {
            console.log("mounted credit distribution plans component");
            this.$parent.myResize();
            $(this.$el).foundation(); //WORKS!
        },

        components:{
            'vue-pagination' : VuePagination
        },

        methods:{
            fetchData: function (page = 1) {
                axios.get('/budget/credit_distribution/capital_assets/provincial/proposal/fetchData?page=' + page)
                    .then((response) => {
                        this.setData(response.data.data);
                        this.makePagination(response.data);
                        console.log(response);
                    },(error) => {
                        console.log(error);
                    });
            },

            setData: function ( data) {
                this.proposals = data;
                this.selectAll(this.proposals);
                //console.log(JSON.stringify(this.proposals));

            },

            getRemianingAmount: function (cdpId) {
                if (cdpId != '')
                {
                    axios.get('/budget/credit_distribution/capital_assets/provincial/plans/getPlanRemainingAmount' , {params:{cdpId: cdpId}})
                        .then((response) => {
                            this.remainingAmount = response.data.remainingAmount;
                            console.log(response);
                        },(error) => {
                            console.log(error);
                        });
                }
                else
                    this.remainingAmount = 0;
            },

            getCDPWithCoId: function () {
                if (this.selectedCounty != '')
                {
                    axios.get('/budget/credit_distribution/capital_assets/provincial/plans/getAllWithCountyId' , {params:{coId: this.selectedCounty}})
                        .then((response) => {
                            this.creditDistributionPlans = response.data;
                            console.log(response);
                        },(error) => {
                            console.log(error);
                        });
                }
                else
                    this.creditDistributionPlans = [];
            },

            getCounties: function () {
                axios.get('/admin/get_all_counties')
                    .then((response) => {
                        this.counties = response.data;
                        console.log(response);
                    },(error) => {
                        console.log(error);
                    });
            },

            getPlanProposalCount: function (plans) {
                var count = 0;
                plans.forEach(plan => {
                    count += plan.proposal.length;
                });
                return count;
            },

            openInsertModal: function () {
                this.selectedCounty = '';
                this.cdpProposalInput = [];
                this.getCounties();
                this.showInsertModal = true;
            },

            createCdpProposal: function () {
                this.$validator.validateAll().then((result) => {
                    if (result) {
                        axios.post('/budget/credit_distribution/capital_assets/provincial/proposal/register' , {
                            cdpId: this.cdpProposalInput.cdpId,
                            pSubject: this.cdpProposalInput.pSubject,
                            pCode: this.cdpProposalInput.pCode,
                            pAmount: this.cdpProposalInput.pAmount,
                            pDescription: this.cdpProposalInput.pDescription
                        })
                            .then((response) => {
                                this.setData(response.data.data);
                                this.makePagination(response.data);
                                this.showInsertModal = false;
                                this.$parent.displayNotif(response.status);
                                console.log(response);
                            },(error) => {
                                console.log(error);
                                this.$parent.displayNotif(error.response.status);
                            });
                    }
                });
            },

            openUpdateModal: function (proposal , coId) {
                this.selectedCounty = '';
                this.cdpProposalFill = [];
                this.getCounties();
                this.cdpProposalFill.id = proposal.id;
                this.cdpProposalFill.cdpId = proposal.pbpCdpId;
                this.getRemianingAmount(this.cdpProposalFill.cdpId);
                this.cdpProposalFill.pSubject = proposal.pbpSubject;
                this.cdpProposalFill.pCode = proposal.pbpCode;
                this.cdpProposalFill.pAmount = this.$parent.calcDispAmount(proposal.pbpAmount , false);
                this.cdpProposalFill.pDescription = proposal.pbpDescription;
                this.selectedCounty = coId;
                this.getCDPWithCoId();

                this.errorMessage = '';
                this.showUpdateModal = true;
            },

            updateCdpProposal: function () {
                this.$validator.validateAll().then((result) => {
                    if (result) {
                        axios.post('/budget/credit_distribution/capital_assets/provincial/proposal/update' , {
                            id: this.cdpProposalFill.id,
                            cdpId: this.cdpProposalFill.cdpId,
                            pSubject: this.cdpProposalFill.pSubject,
                            pCode: this.cdpProposalFill.pCode,
                            pAmount: this.cdpProposalFill.pAmount,
                            pDescription: this.cdpProposalFill.pDescription
                        })
                            .then((response) => {
                                this.setData(response.data.data);
                                this.makePagination(response.data);
                                this.showUpdateModal = false;
                                this.$parent.displayNotif(response.status);
                                console.log(response);
                            },(error) => {
                                console.log(error);
                                this.$parent.displayNotif(error.response.status);
                            });
                    }
                });

            },

            openDeleteModal: function (pId) {
                this.selectedProposalIdForDelete = pId;
                this.showDeleteModal = true;
            },

            deleteSelectedProposal: function () {
                axios.post('/budget/credit_distribution/capital_assets/provincial/proposal/delete' , {id: this.selectedProposalIdForDelete})
                    .then((response) => {
                        if (response.status != 204)
                            this.setData(response.data.data);
                        this.showDeleteModal = false;
                        this.$parent.displayNotif(response.status);
                        console.log(response);
                    },(error) => {
                        console.log(error);
                        this.showDeleteModal = false;
                    });
            },

            showSelectColumn: function (county) {
                this.selectAll(county);
                if (this.selectColumn)
                {
                    this.selectColumn=false;
                }
                else {
                    this.selectColumn = true;
                }
            },

            openReportModal: function (type) {
                this.reportType = type;
                this.selectedItems = [];
                var isSelected=false;
                if (this.selectedLength(this.proposals) != 0)
                {
                    this.showModalReport = true;
                    this.proposals.forEach(plans => {
                        plans.credit_distribution_plan_has_proposal.forEach(plan => {
                            plan.proposal.forEach(proposal=> {
                                if (proposal.checked == true)
                                    isSelected = true;
                            });
                        });
                        if (isSelected) {
                            this.selectedItems.push(plans);
                            isSelected = false;
                        }
                    });
                    this.reportOptions.title = ' پیشنهاد بودجه توزیع اعتبار تملک دارایی های سرمایه ای استانی';
                }
                else{
                    this.$parent.displayNotif(800);
                }

                //console.log(JSON.stringify(this.selectedItems));
            },

            openReportFile: function () {
                axios.post('/budget/credit_distribution/report' , {pOrN: this.provOrNat , type: this.reportType ,options: this.reportOptions , selectedItems: this.selectedItems})
                    .then((response) => {
                        console.log(response.data);
                        window.open(response.data);
                    },(error) => {
                        console.log(error);
                    });
            },

            toggleSelect: function(county) {
                var temp = false;
                county.forEach(plans => {
                        plans.credit_distribution_plan_has_proposal.forEach(plan => {
                            plan.proposal.forEach(proposal=> {
                                if (proposal.checked)
                                    temp = true;
                            });
                    });
                });
                county.forEach(plans => {
                    if(temp){
                        plans.credit_distribution_plan_has_proposal.forEach(plan => {
                            plan.proposal.forEach(proposal=> {
                                proposal.checked = false;
                            });
                        });
                    } else {
                        plans.credit_distribution_plan_has_proposal.forEach(plan => {
                            plan.proposal.forEach(proposal=> {
                                proposal.checked = true;
                            });
                        });
                    }
                });
                //console.log(JSON.stringify(this.approvedProjects_prov));
            },

            allSelected: function(county) {
                var temp = true;
                //console.log(JSON.stringify(this.approvedProjects_prov));
                county.forEach(plans => {
                    plans.credit_distribution_plan_has_proposal.forEach(plan => {
                        plan.proposal.forEach(proposal=> {
                            if (proposal.checked == false)
                                temp = false;
                        });
                    });
                });
                return temp;
            },

            selectAll: function (county) {
                county.forEach(plans => {
                        plans.credit_distribution_plan_has_proposal.forEach(plan => {
                            plan.proposal.forEach(proposal=> {
                                this.$set(proposal, 'checked', true);
                            });
                    });
                });
                console.log(JSON.stringify(this.approvedProjects_prov));
            },

            selectedLength: function (county) {
                var counter=0;
                county.forEach(plans => {
                        plans.credit_distribution_plan_has_proposal.forEach(plan => {
                            plan.proposal.forEach(proposal => {
                                counter += proposal.checked;
                            });
                        });
                });
                return counter;
            },

            makePagination: function(data){
                this.pagination.current_page = data.current_page;
                this.pagination.to = data.to;
                this.pagination.last_page = data.last_page;
            },
        }
    }
</script>

