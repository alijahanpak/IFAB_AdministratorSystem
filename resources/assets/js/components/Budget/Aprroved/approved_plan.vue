<template xmlns:v-on="http://www.w3.org/1999/xhtml" xmlns:v-bind="http://www.w3.org/1999/xhtml">
    <!--Inner body start-->
    <div class="medium-10 border-right-line inner-body-pad main-margin">
        <div class="grid-x padding-lr breadcrumbs-pos">
            <div class="medium-12">
                <div class="grid-x">
                    <nav aria-label="You are here:" role="navigation">
                        <ul class="breadcrumbs">
                            <li><a href="">داشبورد</a></li>
                            <li>
                                <a class="disabled">موافقتنامه</a>
                            </li>
                            <li>
                                <a class="disabled">تملک دارایی سرمایه ای</a>
                            </li>
                            <li>
                                <span class="show-for-sr">Current: </span>طرح ها
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
        <div class="grid-x  my-callout-box container-mrg-top dynamic-height-level1">
            <div  class="medium-12 column">
                <ul class="tabs tab-color my-tab-style" data-responsive-accordion-tabs="tabs medium-accordion large-tabs" id="approved_plan_tab_view">
                    <li class="tabs-title is-active"><a href="#provincial_tab" aria-selected="true">استانی</a></li>
                    <li class="tabs-title"><a href="#national_tab">ملی</a></li>
                </ul>
                <div class="tabs-content" data-tabs-content="approved_plan_tab_view">
                    <div class="tabs-panel is-active table-mrg-btm" id="provincial_tab"
                         xmlns:v-on="http://www.w3.org/1999/xhtml">
                        <div class="medium-12 bottom-mrg">
                            <!--Tab 1-->
                            <div class="clearfix border-btm-line bottom-mrg tool-bar">
                                <div style="margin-top: 2px;" class="button-group float-right report-mrg">
                                    <a class="my-button toolbox-btn small" @click="openApprovedPlanInsertModal(0)">جدید</a>
                                    <div class="input-group-button toggle-icon-change">
                                        <button type="button" class="my-button my-icon-brand tiny" @click="showSelectColumn"><i class="fa fa-check-square-o size-14" aria-hidden="true"></i></button>
                                    </div>
                                    <button class="my-button toolbox-btn small dropdown small sm-btn-align"  type="button" data-toggle="reportDropDown1">گزارش</button>
                                    <div  style="width: 113px;" class="dropdown-pane dropdown-pane-sm " data-close-on-click="true"  data-hover="true" data-hover-pane="true"  data-position="bottom" data-alignment="left" id="reportDropDown1" data-dropdown data-auto-focus="true">
                                        <ul class="my-menu small-font ltr-dir">
                                            <li><a  href="#"><i class="fa fa-file-pdf-o icon-margin-dropdown" aria-hidden="true"></i>PDF</a></li>
                                            <li><a  href="#"><i class="fa fa-file-excel-o icon-margin-dropdown" aria-hidden="true"></i>Excel</a></li>
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
                                <div class="float-left">
                                    <div class="input-group float-left">
                                        <input class="input-group-field small-font" type="text">
                                        <div class="input-group-button">
                                            <button type="button" class="my-button my-brand"><i class="fi-magnifying-glass"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--Table Start-->
                            <!--Table Head Start-->
                            <div class="tbl-div-container">
                                <table class="tbl-head">
                                    <colgroup>
                                        <col width="250px"/>
                                        <col width="150px"/>
                                        <col width="150px"/>
                                        <col width="150px"/>
                                        <col width="250px"/>
                                        <col width="12px"/>
                                        <col v-show="selectColumn" width="15px"/>
                                    </colgroup>
                                    <tbody class="tbl-head-style">
                                    <tr class="tbl-head-style-cell">
                                        <th class="tbl-head-style-cell">طرح</th>
                                        <th class="tbl-head-style-cell">مبادله شده</th>
                                        <th class="tbl-head-style-cell">ابلاغی</th>
                                        <th class="tbl-head-style-cell">شهرستان</th>
                                        <th class="tbl-head-style-cell">شرح</th>
                                        <th class="tbl-head-style-cell"></th>
                                        <th v-show="selectColumn" class="tbl-head-style-cell"></th>
                                    </tr>
                                    </tbody>
                                </table>
                                <!--Table Head End-->
                                <!--Table Body Start-->
                                <div class="tbl_body_style dynamic-height-level2">
                                    <table class="tbl-body-contain">
                                        <colgroup>
                                            <col width="250px"/>
                                            <col width="150px"/>
                                            <col width="150px"/>
                                            <col width="150px"/>
                                            <col width="250px"/>
                                            <col v-show="selectColumn" width="15px"/>
                                        </colgroup>
                                        <tbody class="tbl-head-style-cell">
                                            <tr v-for="plans in approvedPlan_prov">
                                                <td> {{ plans.credit_distribution_title.cdtIdNumber + ' - ' + plans.credit_distribution_title.cdtSubject }}</td>
                                                <td>
                                                    <div>{{ plans.capExchangeIdNumber }}</div>
                                                    <div>{{ plans.capExchangeDate }}</div>
                                                </td>
                                                <td>
                                                    <div>{{ plans.capLetterNumber }}</div>
                                                    <div>{{ plans.capLetterDate }}</div>
                                                </td>
                                                <td>
                                                    {{ plans.credit_distribution_title.county.coName }}
                                                </td>
                                                <td>
                                                    <div class="grid-x">
                                                        <div class="medium-11">
                                                            {{ plans.capDescription }}
                                                        </div>
                                                        <div class="medium-1 cell-vertical-center text-left auto-margin">
                                                            <a class="dropdown small sm-btn-align"  type="button" :data-toggle="'approvedPlans' + plans.id"><i class="fa fa-ellipsis-v size-18"></i></a>
                                                            <div class="dropdown-pane dropdown-pane-sm auto-margin" data-close-on-click="true"  data-hover="true" data-hover-pane="true"  data-position="bottom" data-alignment="right" :id="'approvedPlans' + plans.id" data-dropdown data-auto-focus="true">
                                                                <ul class="my-menu small-font text-right">
                                                                    <li><a v-on:click.prevent="approvedPlanUpdateDialog(plans)"><i class="fa fa-pencil-square-o size-16"></i>  ویرایش</a></li>
                                                                    <li><a v-on:click.prevent="openDeleteApprovedPlanConfirm(plans)"><i class="fa fa-trash-o size-16"></i>  حذف</a></li>
                                                                    <li><a v-on:click.prevent="openApprovedAmendmentModal(plans)"><i class="fa fa-newspaper-o size-16"></i>  اصلاحیه</a></li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td  v-show="selectColumn">
                                                    <input class="auto-margin" id="checkbox1" type="checkbox">
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <!--Table Body End-->
                            </div>

                            <div class="grid-x">
                                <div class="medium-12">
                                    <vue-pagination  v-bind:pagination="provincial_pagination"
                                                     v-on:click.native="fetchProvincialData(provincial_pagination.current_page)"
                                                     :offset="4">
                                    </vue-pagination>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- national tab -->
                    <div class="tabs-panel table-mrg-btm" id="national_tab"
                         xmlns:v-on="http://www.w3.org/1999/xhtml">
                        <div class="medium-12 bottom-mrg">
                            <!--Tab 1-->
                            <div class="clearfix border-btm-line bottom-mrg tool-bar">
                                <div style="margin-top: 2px;" class="button-group float-right report-mrg">
                                    <a class="my-button toolbox-btn small" @click="openApprovedPlanInsertModal(1)">جدید</a>
                                    <div class="input-group-button toggle-icon-change">
                                        <button type="button" class="my-button my-icon-brand tiny"><i class="fa fa-check-square-o size-14" aria-hidden="true"></i></button>
                                    </div>
                                    <button class="my-button toolbox-btn small dropdown small sm-btn-align"  type="button" data-toggle="reportDropDown">گزارش</button>
                                    <div  style="width: 113px;" class="dropdown-pane dropdown-pane-sm " data-close-on-click="true"  data-hover="true" data-hover-pane="true"  data-position="bottom" data-alignment="left" id="reportDropDown" data-dropdown data-auto-focus="true">
                                        <ul class="my-menu small-font ltr-dir">
                                            <li><a  href="#"><i class="fa fa-file-pdf-o icon-margin-dropdown" aria-hidden="true"></i>PDF</a></li>
                                            <li><a  href="#"><i class="fa fa-file-excel-o icon-margin-dropdown" aria-hidden="true"></i>Excel</a></li>
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
                                <div class="float-left">
                                    <div class="input-group float-left">
                                        <input class="input-group-field small-font" type="text">
                                        <div class="input-group-button">
                                            <button type="button" class="my-button my-brand"><i class="fi-magnifying-glass"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--Table Start-->
                            <div class="columns">
                                <!--Header Start-->
                                <div class="grid-x table-header">
                                    <div class="medium-3  table-border">
                                        <strong>طرح</strong>
                                    </div>
                                    <div class="medium-2  table-border">
                                        <strong>مبادله شده</strong>
                                    </div>
                                    <div class="medium-2 table-border">
                                        <strong>ابلاغی</strong>
                                    </div>
                                    <div class="medium-5  table-border">
                                        <strong>شرح</strong>
                                    </div>
                                </div>
                                <!--Header End-->
                                <div class="table-contain dynamic-height-level2">
                                    <div class="grid-x" v-for="plans in approvedPlan_nat">
                                        <div class="medium-3 table-contain-border cell-vertical-center">
                                            {{ plans.credit_distribution_title.cdtIdNumber + ' - ' + plans.credit_distribution_title.cdtSubject }}
                                        </div>
                                        <div class="medium-2 table-contain-border cell-vertical-center text-center">
                                            <div>{{ plans.capExchangeIdNumber }}</div>
                                            <div>{{ plans.capExchangeDate }}</div>
                                        </div>
                                        <div class="medium-2 table-contain-border cell-vertical-center text-center">
                                            <div>{{ plans.capLetterNumber }}</div>
                                            <div>{{ plans.capLetterDate }}</div>
                                        </div>
                                        <div class="medium-5  table-contain-border cell-vertical-center">
                                            <div class="grid-x">
                                                <div class="medium-11">
                                                    {{ plans.capDescription }}
                                                </div>
                                                <div class="medium-1 cell-vertical-center text-left">
                                                    <a class="dropdown small sm-btn-align"  type="button" :data-toggle="'approvedPlans' + plans.id"><i class="fa fa-ellipsis-v size-18"></i></a>
                                                    <div class="dropdown-pane dropdown-pane-sm " data-close-on-click="true"  data-hover="true" data-hover-pane="true"  data-position="bottom" data-alignment="right" :id="'approvedPlans' + plans.id" data-dropdown data-auto-focus="true">
                                                        <ul class="my-menu small-font text-right">
                                                            <li><a v-on:click.prevent="approvedPlanUpdateDialog(plans)"><i class="fa fa-pencil-square-o size-16"></i>  ویرایش</a></li>
                                                            <li><a v-on:click.prevent="openDeleteApprovedPlanConfirm(plans)"><i class="fa fa-trash-o size-16"></i>  حذف</a></li>
                                                            <li><a v-on:click.prevent="openApprovedAmendmentModal(plans)"><i class="fa fa-newspaper-o size-16"></i>  اصلاحیه</a></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="grid-x">
                                <div class="medium-12">
                                    <vue-pagination  v-bind:pagination="national_pagination"
                                                     v-on:click.native="fetchNationalData(national_pagination.current_page)"
                                                     :offset="4">
                                    </vue-pagination>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--Forms Start-->
            <!--Insert Modal Start-->
            <!-- use the modal component, pass in the prop -->
            <modal-small v-if="showInsertModal" @close="showInsertModal = false">
                    <div slot="body">
                        <form v-on:submit.prevent="createApprovedPlan">
                            <div class="grid-x" v-if="errorMessage">
                                <div class="medium-12 columns padding-lr">
                                    <div class="alert callout">
                                        <p class="BYekan login-alert"><i class="fi-alert"></i>{{ errorMessage }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="grid-x">
                                <div class="medium-12 padding-lr">
                                    <label>طرح
                                        <select class="form-element-margin-btm"  v-model="approvedPlanInput.cdtId" name="plan" v-validate data-vv-rules="required" :class="{'input': true, 'select-error': errors.has('plan')}">
                                            <option value=""></option>
                                            <option v-for="creditDistributionTitle in creditDistributionTitles" :value="creditDistributionTitle.id">{{ creditDistributionTitle.cdtIdNumber + ' - ' + creditDistributionTitle.cdtSubject + (creditDistributionTitle.county == null ? '' : ' - ' + creditDistributionTitle.county.coName)}}</option>
                                        </select>
                                        <span v-show="errors.has('plan')" class="error-font">لطفا طرح را انتخاب کنید!</span>
                                    </label>
                                </div>
                            </div>
                            <div class="grid-x">
                                <div class="medium-6 padding-lr">
                                    <label>شماره ابلاغ
                                        <input class="form-element-margin-btm" type="text" name="capLetterNumber" v-model="approvedPlanInput.idNumber" v-validate data-vv-rules="required" :class="{'input': true, 'select-error': errors.has('capLetterNumber')}">
                                    </label>
                                    <span v-show="errors.has('capLetterNumber')" class="error-font">شماره فراموش شده است!</span>
                                </div>
                                <div class="medium-4 padding-lr">
                                    <p class="date-picker-lbl">تاریخ ابلاغ
                                        <pdatepicker v-model="approvedPlanInput.date" v-on:closed="checkValidDate('delivery')" errMessage="تاریخ ابلاغ فراموش شده است!" :isValid="dateIsValid_delivery" open-transition-animation="left-slide-fade"></pdatepicker>
                                    </p>
                                </div>
                            </div>
                            <div class="grid-x">
                                <div class="medium-6 padding-lr">
                                    <label>شماره مبادله
                                        <input class="form-element-margin-btm" type="text" name="capExLetterNumber" v-model="approvedPlanInput.exIdNumber" v-validate data-vv-rules="required" :class="{'input': true, 'select-error': errors.has('capExLetterNumber')}">
                                    </label>
                                    <span v-show="errors.has('capExLetterNumber')" class="error-font">شماره فراموش شده است!</span>
                                </div>
                                <div class="medium-4 padding-lr">
                                    <p class="date-picker-lbl">تاریخ مبادله
                                        <pdatepicker v-model="approvedPlanInput.exDate" v-on:closed="checkValidDate('exchange')" errMessage="تاریخ مبادله فراموش شده است!" :isValid="dateIsValid_exchange" open-transition-animation="left-slide-fade"></pdatepicker>
                                    </p>
                                </div>
                            </div>
                            <div class="grid-x">
                                <div class="small-12 padding-lr">
                                    <label>شرح
                                        <textarea name="apDescription" style="min-height: 150px;" v-model="approvedPlanInput.apDescription"></textarea>
                                    </label>
                                </div>
                            </div>
                            <div class="medium-6 padding-lr padding-bottom-modal">
                                <button name="Submit" class="my-button my-success float-left btn-for-load"> <span class="btn-txt-mrg">ثبت</span></button>
                            </div>
                        </form>
                    </div>
            </modal-small>
            <!--Insert Modal End-->

            <!--Update Modal Start-->
            <!--update Modal End-->

            <!-- Delete Modal Start -->
            <modal-tiny v-if="showModalDelete" @close="showModalDelete = false">
                <div  slot="body">
                    <div class="small-font">
                        <p>کاربر گرامی</p>
                        <p class="large-offset-1 modal-text">برای حذف رکورد مورد نظر اطمینان دارید؟</p>
                        <div class="grid-x">
                            <div class="medium-12 column text-center">
                                <button  class="button primary btn-large-w" v-on:click="deleteTinySeason">بله</button>
                            </div>
                        </div>
                    </div>
                </div>
            </modal-tiny>
            <!-- Delete Modal End -->
            <!--Amendment Modal Start-->
            <modal-small v-if="showModalAmendment" @close="showModalAmendment = false">
                <div slot="body">
                    <form v-on:submit.prevent="openAmendmentOfAgreementModal">
                        <div class="grid-x" v-if="errorMessage">
                            <div class="medium-12 columns padding-lr">
                                <div class="alert callout">
                                    <p class="BYekan login-alert"><i class="fi-alert"></i>{{ errorMessage }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="grid-x">
                            <div class="medium-12 cell padding-lr">
                                <label>طرح
                                    <select disabled="true" name="plan" v-model="approvedAmendmentInput.cdtId">
                                        <option value=""></option>
                                        <option v-for="creditDistributionTitle in creditDistributionTitles" :value="creditDistributionTitle.id">{{ creditDistributionTitle.cdtIdNumber + ' - ' + creditDistributionTitle.cdtSubject + (creditDistributionTitle.county == null ? '' : ' - ' + creditDistributionTitle.county.coName)}}</option>
                                    </select>
                                </label>
                            </div>
                        </div>
                        <div class="grid-x">
                            <div class="medium-6 padding-lr">
                                <label>شماره ابلاغ
                                    <input class="form-element-margin-btm" type="text" name="capLetterNumber" v-model="approvedAmendmentInput.idNumber" v-validate data-vv-rules="required" :class="{'input': true, 'select-error': errors.has('capLetterNumber')}">
                                </label>
                                <span v-show="errors.has('capLetterNumber')" class="error-font">شماره ابلاغ فراموش شده است!</span>
                            </div>
                            <div class="medium-4 padding-lr">
                                <p class="date-picker-lbl">تاریخ ابلاغ
                                    <pdatepicker v-model="approvedAmendmentInput.date" v-on:closed="checkValidDate('delivery_amendment')" errMessage="تاریخ ابلاغ فراموش شده است!" :isValid="dateIsValid_delivery_amendment" open-transition-animation="left-slide-fade"></pdatepicker>
                                </p>
                            </div>
                        </div>
                        <div class="grid-x">
                            <div class="medium-6 columns padding-lr">
                                <label>شماره مبادله
                                    <input disabled="true" type="text" name="capExLetterNumber" v-model="approvedAmendmentInput.exIdNumber">
                                </label>
                            </div>
                            <div class="medium-4 columns padding-lr">
                                <label>تاریخ مبادله
                                    <input disabled="true" type="text" name="capExLetterDate"  v-model="approvedAmendmentInput.exDate">
                                </label>
                            </div>
                        </div>
                        <div class="grid-x">
                            <div class="small-12 columns padding-lr">
                                <label>شرح
                                    <textarea name="apDescription" style="min-height: 150px;" v-model="approvedAmendmentInput.apDescription"></textarea>
                                </label>
                            </div>
                        </div>
                        <div class="medium-6 columns padding-lr padding-bottom-modal">
                            <div class="button-group float-left report-mrg">
                                <button @click="showModalAmendment = false" class="my-button my-danger float-left btn-for-load"> <span class="btn-txt-mrg">لغو</span></button>
                                <button class="my-button my-success float-left btn-for-load"> <span class="btn-txt-mrg">تایید</span></button>
                            </div>
                        </div>
                    </form>
                </div>
            </modal-small>
            <!--Amendment Modal End-->

            <!--Amendment Of The Agreement Modal Start-->
            <modal-full-screen v-if="showModalAmendmentOfAgreement" @close="showModalAmendmentOfAgreement = false">
                <div slot="body">
                        <div class="grid-x" v-if="errorMessage">
                            <div class="medium-12 columns padding-lr">
                                <div class="alert callout">
                                    <p class="BYekan login-alert"><i class="fi-alert"></i>{{ errorMessage }}</p>
                                </div>
                            </div>
                        </div>
                        <div style="padding:0px;" class="grid-x border-btm-line">
                            <div class="medium-12 cell padding-lr">
                               <div class="grid-x">
                                   <div class="medium-7">
                                       <strong>طرح: </strong><span>{{ approvedAmendmentProjects.credit_distribution_title.cdtIdNumber + approvedAmendmentProjects.credit_distribution_title.cdtSubject }}</span>
                                   </div>
                                   <div class="medium-1">
                                       <p>شماره ابلاغ : </p>
                                   </div>
                                   <div class="medium-2">
                                       <strong class="btn-red">{{ approvedAmendmentProjects.capLetterNumber }} </strong>
                                   </div>
                                   <div class="medium-1">
                                       <p>تاریخ ابلاغ : </p>
                                   </div>
                                   <div class="medium-1">
                                       <strong class="btn-red">{{ approvedAmendmentProjects.capLetterDate }} </strong>
                                   </div>
                               </div>
                            </div>
                            <div class="medium-12 cell padding-lr">
                                <div class="grid-x">
                                    <div class="medium-12 padding-bottom-modal">
                                        <strong>شرح: </strong><span style="display: inline">{{ approvedAmendmentProjects.capDescription }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <div style="margin-top: 15px;" class="grid-x">
                        <div style="margin-top: 2px;" class="button-group float-right">
                            <a class="my-button toolbox-btn small" @click="openInsertProjectModal">پروژه جدید</a>
                        </div>
                    </div>
                    <div class="grid-x">
                        <!--Table Start-->
                        <!--Table Head Start-->
                        <div class="tbl-div-container">
                            <table class="tbl-head">
                                <colgroup>
                                    <col width="100px"/>
                                    <col width="290px"/>
                                    <col width="150px"/>
                                    <col width="150px"/>
                                    <col width="240px"/>
                                    <col width="12px"/>
                                </colgroup>
                                <tbody class="tbl-head-style ">
                                <tr class="tbl-head-style-cell">
                                    <th class="tbl-head-style-cell">کد پروژه</th>
                                    <th class="tbl-head-style-cell">عنوان پروژه</th>
                                    <th class="tbl-head-style-cell">شهرستان </th>
                                    <th class="tbl-head-style-cell">اعتبار</th>
                                    <th class="tbl-head-style-cell">شرح</th>
                                    <th class="tbl-head-style-cell"></th>
                                </tr>
                                </tbody>
                            </table>
                            <!--Table Head End-->
                            <!--Table Body Start-->
                            <div class="tbl_body_style dynamic-height-level1">
                                <table class="tbl-body-contain">
                                    <colgroup>
                                        <col width="100px"/>
                                        <col width="290px"/>
                                        <col width="150px"/>
                                        <col width="150px"/>
                                        <col width="240px"/>
                                    </colgroup>
                                    <tbody class="tbl-head-style-cell">
                                    <template v-for="project in approvedAmendmentProjects.capital_assets_project">
                                        <tr>
                                            <td>{{ project.cpCode }}</td>
                                            <td>{{ project.cpSubject }}</td>
                                            <td>{{ project.county.coName }}</td>
                                            <td @click="displayCSInfo == project.id ? displayCSInfo = '' : displayCSInfo = project.id">{{ $parent.calcDispAmount(sumOfAmount(project.credit_source) , false) }}</td>
                                            <td>
                                                <div class="grid-x">
                                                    <div class="medium-11">
                                                        {{ project.cpDescription }}
                                                    </div>
                                                    <div class="medium-1 cell-vertical-center text-left">
                                                        <a class="dropdown small sm-btn-align" :data-toggle="'project' + project.id"  type="button"><i class="fa fa-ellipsis-v size-18"></i></a>
                                                        <div class="dropdown-pane dropdown-pane-sm " data-close-on-click="true"  data-hover="true" data-hover-pane="true"  data-position="bottom" data-alignment="right" :id="'project' + project.id" data-dropdown data-auto-focus="true">
                                                            <ul class="my-menu small-font text-right">
                                                                <li><a v-on:click.prevent=""><i class="fa fa-trash-o size-16"></i>  حذف</a></li>
                                                                <li><a v-on:click.prevent="openAPCreditInsertModal"><i class="fa fa-money size-16"></i>  اعتبارات</a></li>
                                                                <li><a v-on:click.prevent="openEditProjectModal"><i class="fa fa-newspaper-o size-16"></i>  اصلاح</a></li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr v-show="displayCSInfo == project.id">
                                            <td colspan="5">
                                                <table class="unstriped tbl-secondary-mrg small-font">
                                                    <thead class="my-thead">
                                                    <tr style="background-color: #F1F1F1 !important;">
                                                        <th>ردیف</th>
                                                        <th>فصل</th>
                                                        <th>عنوان فصل</th>
                                                        <th>ریز فصل</th>
                                                        <th>نحوه اجرا</th>
                                                        <th>مبلغ</th>
                                                        <th>شرح</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <tr v-for="credit_source in project.credit_source">
                                                        <td>{{ credit_source.credit_distribution_row.cdSubject }}</td>
                                                        <td>{{ credit_source.tiny_season.season_title.season.sSubject }}</td>
                                                        <td>{{ credit_source.tiny_season.season_title.castSubject }}</td>
                                                        <td>{{ credit_source.tiny_season.catsSubject }}</td>
                                                        <td>{{ credit_source.how_to_run.htrSubject }}</td>
                                                        <td>{{ $parent.calcDispAmount(credit_source.ccsAmount , false) }}</td>
                                                        <td>
                                                            <div class="grid-x">
                                                                <div class="medium-11">
                                                                    {{ credit_source.ccsDescription }}
                                                                </div>
                                                                <div class="medium-1 cell-vertical-center text-left">
                                                                    <a class="dropdown small sm-btn-align" :data-toggle="'projectCs' + credit_source.id"  type="button"><i class="fa fa-ellipsis-v size-18"></i></a>
                                                                    <div class="dropdown-pane dropdown-pane-sm " data-close-on-click="true"  data-hover="true" data-hover-pane="true"  data-position="bottom" data-alignment="right" :id="'projectCs' + credit_source.id" data-dropdown data-auto-focus="true">
                                                                        <ul class="my-menu small-font text-right">
                                                                            <li><a v-on:click.prevent=""><i class="fa fa-trash-o size-16"></i>  حذف</a></li>
                                                                            <li><a v-on:click.prevent="openAPCreditInsertModal"><i class="fa fa-money size-16"></i>  اعتبارات</a></li>
                                                                            <li><a v-on:click.prevent="openEditProjectModal"><i class="fa fa-newspaper-o size-16"></i>  اصلاح</a></li>
                                                                        </ul>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </td>
                                        </tr>
                                    </template>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                            <!--Table Body End-->
                    </div>
                </div>
            </modal-full-screen>
            <!--Amendment Of The Agreement Modal End-->

            <!--Insert Project Modal Start-->
            <modal-small v-if="showInsertModalProject" @close="showInsertModalProject = false">
                <div slot="body">
                    <form v-on:submit.prevent="insertNewProject">
                        <div class="grid-x" v-if="errorMessage">
                            <div class="medium-12 columns padding-lr">
                                <div class="alert callout">
                                    <p class="BYekan login-alert"><i class="fi-alert"></i>{{ errorMessage }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="grid-x">
                            <div class="medium-12 cell padding-lr">
                                <label>طرح
                                    <select disabled="true" name="plan" v-model="projectAmendmentInput.capId">
                                        <option value=""></option>
                                        <option v-for="approvedPlan in approvedPlans" :value="approvedPlan.id">{{ approvedPlan.credit_distribution_title.cdtIdNumber + ' - ' + approvedPlan.credit_distribution_title.cdtSubject }}</option>
                                    </select>
                                </label>
                            </div>
                        </div>
                        <div class="grid-x">
                            <div class="medium-8 cell padding-lr">
                                <label>عنوان پروژه
                                    <input class="form-element-margin-btm" type="text" name="projectTitle" v-model="projectAmendmentInput.pSubject" v-validate="'required'" :class="{'input': true, 'error-border': errors.has('projectTitle')}">
                                </label>
                                <span v-show="errors.has('projectTitle')" class="error-font">لطفا عنوان پروژه انتخاب کنید!</span>
                            </div>
                            <div class="medium-4 cell padding-lr">
                                <label>کد پروژه
                                    <input class="form-element-margin-btm" type="text" name="projectCode" v-model="projectAmendmentInput.pCode" v-validate="'required|numeric'" :class="{'input': true, 'error-border': errors.has('projectCode')}">
                                </label>
                                <span v-show="errors.has('projectCode')" class="error-font">لطفا کد پروژه انتخاب کنید!</span>
                            </div>
                        </div>
                        <div class="grid-x">
                            <div class="medium-4 cell padding-lr">
                                <label>سال شروع
                                    <input class="form-element-margin-btm datePickerClass" type="text" name="startYear" v-model="projectAmendmentInput.startYear"  v-validate="'required'" :class="{'input': true, 'error-border': errors.has('startYear')}">
                                </label>
                                <span v-show="errors.has('startYear')" class="error-font">لطفا سال شروع پروژه را وارد کنید!</span>
                            </div>
                            <div class="medium-4 cell padding-lr">
                                <label>سال خاتمه
                                    <input class="form-element-margin-btm datePickerClass" type="text" name="endYear" v-model="projectAmendmentInput.endYear" v-validate="'required'" :class="{'input': true, 'error-border': errors.has('endYear')}">
                                </label>
                                <span v-show="errors.has('endYear')" class="error-font">لطفا سال خاتمه پروژه را وارد کنید!</span>
                            </div>
                            <div class="medium-4 cell padding-lr">
                                <label> پیشرفت فیزیکی<span class="btn-red small-font"> (درصد) </span>
                                    <input  type="number" min="0" max="100" value="0" name="physicalProgress" v-model="projectAmendmentInput.pProgress" v-validate="'required|numeric'" :class="{'input': true, 'error-border': errors.has('physicalProgress')}">
                                    <div style="margin-top: -16px;height:2px;" class="alert progress form-element-margin-btm">
                                        <div class="progress-meter" style="width: 100%"></div>
                                    </div>
                                </label>
                                <span v-show="errors.has('physicalProgress')" class="error-font">لطفا پیشرفت فیزیکی را وارد کنید!</span>
                            </div>
                            <div class="medium-4 cell padding-lr">
                                <label>شهرستان
                                    <select class="form-element-margin-btm" name="city" v-model="projectAmendmentInput.county" v-validate data-vv-rules="required" :class="{'input': true, 'select-error': errors.has('city')}">
                                        <option value=""></option>
                                        <option></option>
                                    </select>
                                    <span v-show="errors.has('city')" class="error-font">لطفا شهرستان را انتخاب کنید!</span>
                                </label>
                            </div>
                        </div>
                        <div class="grid-x">
                            <div class="small-12 columns padding-lr">
                                <label>شرح
                                    <textarea name="apDescription" v-model="projectAmendmentInput.description" style="min-height: 150px;" ></textarea>
                                </label>
                            </div>
                        </div>
                        <div class="medium-6 columns padding-lr padding-bottom-modal">
                            <button name="Submit" class="my-button my-success float-left btn-for-load"> <span class="btn-txt-mrg">ثبت</span></button>
                        </div>
                    </form>
                </div>
            </modal-small>
            <!--Insert Project Modal End-->

            <!--Edit Project Modal Start-->
            <modal-small v-if="showEditModalProject" @close="showEditModalProject = false">
                <div slot="body">
                    <form v-on:submit.prevent="">
                        <div class="grid-x" v-if="errorMessage">
                            <div class="medium-12 columns padding-lr">
                                <div class="alert callout">
                                    <p class="BYekan login-alert"><i class="fi-alert"></i>{{ errorMessage }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="grid-x">
                            <div class="medium-12 cell padding-lr">
                                <label>طرح
                                    <select disabled="true"  name="plan">
                                        <option value=""></option>
                                        <option></option>
                                    </select>
                                </label>
                            </div>
                        </div>
                        <div class="grid-x">
                            <div class="medium-8 cell padding-lr">
                                <label>عنوان پروژه
                                    <input class="form-element-margin-btm" type="text" name="projectTitle"  v-validate="'required'" :class="{'input': true, 'error-border': errors.has('projectTitle')}">
                                </label>
                                <span v-show="errors.has('projectTitle')" class="error-font">لطفا عنوان پروژه انتخاب کنید!</span>
                            </div>
                            <div class="medium-4 cell padding-lr">
                                <label>کد پروژه
                                    <input class="form-element-margin-btm" type="text" name="projectCode" v-validate="'required|numeric'" :class="{'input': true, 'error-border': errors.has('projectCode')}">
                                </label>
                                <span v-show="errors.has('projectCode')" class="error-font">لطفا کد پروژه انتخاب کنید!</span>
                            </div>
                        </div>
                        <div class="grid-x">
                            <div class="medium-4 cell padding-lr">
                                <label>سال شروع
                                    <input class="form-element-margin-btm datePickerClass" type="text" name="startYear"  v-validate="'required'" :class="{'input': true, 'error-border': errors.has('startYear')}">
                                </label>
                                <span v-show="errors.has('startYear')" class="error-font">لطفا سال شروع پروژه را وارد کنید!</span>
                            </div>
                            <div class="medium-4 cell padding-lr">
                                <label>سال خاتمه
                                    <input class="form-element-margin-btm datePickerClass" type="text" name="endYear"  v-validate="'required'" :class="{'input': true, 'error-border': errors.has('endYear')}">
                                </label>
                                <span v-show="errors.has('endYear')" class="error-font">لطفا سال خاتمه پروژه را وارد کنید!</span>
                            </div>
                            <div class="medium-4 cell padding-lr">
                                <label> پیشرفت فیزیکی<span class="btn-red small-font"> (درصد) </span>
                                    <input  type="number" min="0" max="100" value="0" name="physicalProgress" v-validate="'required|numeric'" :class="{'input': true, 'error-border': errors.has('physicalProgress')}">
                                    <div style="margin-top: -16px;height:2px;" class="alert progress form-element-margin-btm">
                                        <div class="progress-meter" style="width: 100%"></div>
                                    </div>
                                </label>
                                <span v-show="errors.has('physicalProgress')" class="error-font">لطفا پیشرفت فیزیکی را وارد کنید!</span>
                            </div>
                            <div class="medium-4 cell padding-lr">
                                <label>شهرستان
                                    <select class="form-element-margin-btm" name="city" v-validate data-vv-rules="required" :class="{'input': true, 'select-error': errors.has('city')}">
                                        <option value=""></option>
                                        <option></option>
                                    </select>
                                    <span v-show="errors.has('city')" class="error-font">لطفا شهرستان را انتخاب کنید!</span>
                                </label>
                            </div>
                        </div>
                        <div class="grid-x">
                            <div class="small-12 columns padding-lr">
                                <label>شرح
                                    <textarea name="apDescription" style="min-height: 150px;" ></textarea>
                                </label>
                            </div>
                        </div>
                        <div class="medium-6 columns padding-lr padding-bottom-modal">
                            <button name="Submit" class="my-button my-success float-left btn-for-load"> <span class="btn-txt-mrg">ثبت</span></button>
                        </div>
                    </form>
                </div>
            </modal-small>
            <!--Edit Project Modal End-->

            <!--Project credit source Modal Start-->
            <modal-small v-if="showApCreditEditModal" @close="showApCreditEditModal = false">
                <div  slot="body">
                    <form v-on:submit.prevent="">
                        <div class="grid-x" v-if="errorMessage">
                            <div class="medium-12 columns padding-lr">
                                <div class="alert callout">
                                    <p class="BYekan login-alert"><i class="fi-alert"></i>@{{ errorMessage }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="grid-x">
                            <div class="medium-9 cell padding-lr">
                                <label>ردیف توزیع اعتبار
                                    <select  class="form-element-margin-btm"  name="row"  v-validate data-vv-rules="required" :class="{'input': true, 'select-error': errors.has('row')}">
                                        <option value=""></option>
                                        <option v-for="creditDistributionRow in creditDistributionRows" :value="creditDistributionRow.id">{{ creditDistributionRow.cdSubject }}</option>
                                    </select>
                                    <span v-show="errors.has('row')" class="error-font">لطفا ردیف توزیع را انتخاب کنید!</span>
                                </label>
                            </div>
                            <div class="medium-3 cell padding-lr">
                                <label>نحوه اجرا
                                    <select class="form-element-margin-btm" name="howToRun"  v-validate data-vv-rules="required" :class="{'input': true, 'select-error': errors.has('howToRun')}">
                                        <option value=""></option>
                                        <option></option>
                                    </select>
                                    <span v-show="errors.has('howToRun')" class="error-font">لطفا نحوه اجرا را انتخاب کنید!</span>
                                </label>
                            </div>
                        </div>
                        <div class="grid-x">
                            <div class="medium-4 column padding-lr">
                                <label>فصل
                                    <select class="form-element-margin-btm" @change=""  name="season" v-validate data-vv-rules="required" :class="{'input': true, 'select-error': errors.has('season')}">
                                        <option value=""></option>
                                        <option></option>
                                    </select>
                                    <span v-show="errors.has('season')" class="error-font">لطفا فصل را انتخاب کنید!</span>
                                </label>
                            </div>
                            <div class="medium-8 column padding-lr">
                                <label>عنوان فصل
                                    <select class="form-element-margin-btm"  @change="" name="seasonTitle" v-validate data-vv-rules="required" :class="{'input': true, 'select-error': errors.has('seasonTitle')}">
                                        <option value=""></option>
                                        <option></option>
                                    </select>
                                    <span v-show="errors.has('seasonTitle')" class="error-font">لطفا عنوان فصل را انتخاب کنید!</span>
                                </label>
                            </div>
                        </div>
                        <div class="grid-x">
                            <div class="medium-12 column padding-lr">
                                <label>ریز فصل
                                    <select class="form-element-margin-btm" name="subSeason" v-validate data-vv-rules="required" :class="{'input': true, 'select-error': errors.has('subSeason')}">
                                        <option value=""></option>
                                        <option></option>
                                    </select>
                                    <span v-show="errors.has('subSeason')" class="error-font">لطفا ریز فصل را انتخاب کنید!</span>
                                </label>
                            </div>
                        </div>
                        <div class="grid-x">
                            <div class="medium-6 cell padding-lr">
                                <label>مبلغ اعتبار <span class="btn-red">{{ '(' + $parent.getAmountBaseLabel() + ')' }}</span>
                                    <input class="form-element-margin-btm" type="text" name="amount"  v-validate="'required|decimal'" :class="{'input': true, 'error-border': errors.has('amount')}">
                                </label>
                                <span v-show="errors.has('amount')" class="error-font">لطفا مبلغ اعتبار پروژه را وارد کنید!</span>
                            </div>
                        </div>
                        <div class="grid-x">
                            <div class="small-12 columns padding-lr">
                                <label>شرح
                                    <textarea name="csDescription" style="min-height: 150px;"></textarea>
                                </label>
                            </div>
                        </div>
                        <div class="medium-6 columns padding-lr padding-bottom-modal input-margin-top">
                            <button name="Submit" class="my-button my-success float-left btn-for-load"> <span class="btn-txt-mrg">ثبت</span></button>
                        </div>
                    </form>
                </div>
            </modal-small>
            <!--Project Cost Modal End-->

            <!--Project credit source Modal Insert Start-->
            <modal-small v-if="showApCreditInsertModal" @close="showApCreditInsertModal = false">
                <div  slot="body">
                    <form v-on:submit.prevent="">
                        <div class="grid-x" v-if="errorMessage">
                            <div class="medium-12 columns padding-lr">
                                <div class="alert callout">
                                    <p class="BYekan login-alert"><i class="fi-alert"></i>@{{ errorMessage }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="grid-x">
                            <div class="medium-9 cell padding-lr">
                                <label>ردیف توزیع اعتبار
                                    <select  class="form-element-margin-btm"  name="row"  v-validate data-vv-rules="required" :class="{'input': true, 'select-error': errors.has('row')}">
                                        <option value=""></option>
                                        <option v-for="creditDistributionRow in creditDistributionRows" :value="creditDistributionRow.id">{{ creditDistributionRow.cdSubject }}</option>
                                    </select>
                                    <span v-show="errors.has('row')" class="error-font">لطفا ردیف توزیع را انتخاب کنید!</span>
                                </label>
                            </div>
                            <div class="medium-3 cell padding-lr">
                                <label>نحوه اجرا
                                    <select class="form-element-margin-btm" name="howToRun"  v-validate data-vv-rules="required" :class="{'input': true, 'select-error': errors.has('howToRun')}">
                                        <option value=""></option>
                                        <option></option>
                                    </select>
                                    <span v-show="errors.has('howToRun')" class="error-font">لطفا نحوه اجرا را انتخاب کنید!</span>
                                </label>
                            </div>
                        </div>
                        <div class="grid-x">
                            <div class="medium-4 column padding-lr">
                                <label>فصل
                                    <select class="form-element-margin-btm" @change=""  name="season" v-validate data-vv-rules="required" :class="{'input': true, 'select-error': errors.has('season')}">
                                        <option value=""></option>
                                        <option></option>
                                    </select>
                                    <span v-show="errors.has('season')" class="error-font">لطفا فصل را انتخاب کنید!</span>
                                </label>
                            </div>
                            <div class="medium-8 column padding-lr">
                                <label>عنوان فصل
                                    <select class="form-element-margin-btm"  @change="" name="seasonTitle" v-validate data-vv-rules="required" :class="{'input': true, 'select-error': errors.has('seasonTitle')}">
                                        <option value=""></option>
                                        <option></option>
                                    </select>
                                    <span v-show="errors.has('seasonTitle')" class="error-font">لطفا عنوان فصل را انتخاب کنید!</span>
                                </label>
                            </div>
                        </div>
                        <div class="grid-x">
                            <div class="medium-12 column padding-lr">
                                <label>ریز فصل
                                    <select class="form-element-margin-btm" name="subSeason" v-validate data-vv-rules="required" :class="{'input': true, 'select-error': errors.has('subSeason')}">
                                        <option value=""></option>
                                        <option></option>
                                    </select>
                                    <span v-show="errors.has('subSeason')" class="error-font">لطفا ریز فصل را انتخاب کنید!</span>
                                </label>
                            </div>
                        </div>
                        <div class="grid-x">
                            <div class="medium-6 cell padding-lr">
                                <label>مبلغ اعتبار <span class="btn-red">{{ '(' + $parent.getAmountBaseLabel() + ')' }}</span>
                                    <input class="form-element-margin-btm" type="text" name="amount"  v-validate="'required|decimal'" :class="{'input': true, 'error-border': errors.has('amount')}">
                                </label>
                                <span v-show="errors.has('amount')" class="error-font">لطفا مبلغ اعتبار پروژه را وارد کنید!</span>
                            </div>
                        </div>
                        <div class="grid-x">
                            <div class="small-12 columns padding-lr">
                                <label>شرح
                                    <textarea name="csDescription" style="min-height: 150px;"></textarea>
                                </label>
                            </div>
                        </div>
                        <div class="medium-6 columns padding-lr padding-bottom-modal input-margin-top">
                            <button name="Submit" class="my-button my-success float-left btn-for-load"> <span class="btn-txt-mrg">ثبت</span></button>
                        </div>
                    </form>
                </div>
            </modal-small>
            <!--Project Credit Modal Edit End-->


            <!--Forms End-->
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
                approvedPlan_prov: [],
                approvedPlan_nat: [],
                approvedPlanInput: {},
                approvedAmendmentInput: {},
                projectAmendmentInput: {},
                showInsertModal: false,
                showModalUpdate: false,
                showModalDelete: false,
                showModalAmendment:false,
                showModalAmendmentOfAgreement:false,
                showInsertModalProject:false,
                showEditModalProject:false,
                showApCreditInsertModal:false,
                showApCreditEditModal:false,
                selectColumn:false,
                approvedPlanFill: {},
                creditDistributionTitles: [],
                dateIsValid_delivery: true,
                dateIsValid_delivery_amendment: true,
                dateIsValid_exchange: true,
                approvedAmendmentProjects: [],
                approvedPlans: [],
                displayCSInfo: '',

                provOrNat: '',
                apIdDelete: {},
                national_pagination: {
                    total: 0,
                    to: 0,
                    current_page: 1,
                    last_page: ''
                },

                provincial_pagination: {
                    total: 0,
                    to: 0,
                    current_page: 1,
                    last_page: ''
                },
            }
        },

        created: function () {
            this.fetchProvincialData();
            this.fetchNationalData();
        },

        updated: function () {
            $(this.$el).foundation(); //WORKS!
        },

        mounted: function () {
            console.log("mounted approved project component");
            this.$parent.myResize();
        },

        components:{
            'vue-pagination' : VuePagination
        },

        methods:{
            fetchProvincialData: function (page = 1) {
                axios.get('/budget/approved_plan/capital_assets/fetchData?page=' + page , {params:{pOrN: 0}})
                    .then((response) => {
                        this.approvedPlan_prov = response.data.data;
                        this.makePagination(response.data , "provincial");
                        console.log(response);
                    },(error) => {
                        console.log(error);
                    });
            },

            fetchNationalData: function (page = 1) {
                axios.get('/budget/approved_plan/capital_assets/fetchData?page=' + page , {params:{pOrN: 1}})
                    .then((response) => {
                        this.approvedPlan_nat = response.data.data;
                        this.makePagination(response.data , "national");
                        console.log(response);
                    },(error) => {
                        console.log(error);
                    });
            },

            getCreditDistributionTitle: function (pOrN) {
                axios.get('/budget/admin/credit_distribution_def/plan_cost_title/getAllItem' , {params:{pOrN: pOrN}})
                    .then((response) => {
                        this.creditDistributionTitles = response.data;
                        console.log(response);
                    },(error) => {
                        console.log(error);
                    });
            },

            sumOfAmount: function (items) {
                var sum = 0;
                items.forEach(item => {
                    sum += item.ccsAmount;
            });
                return sum;
            },

            checkValidDate: function (type) {
                  switch (type)
                  {
                      case 'delivery':
                          if (this.approvedPlanInput.date == null || this.approvedPlanInput.date == '')
                          {
                              this.dateIsValid_delivery = false;
                              return false;
                          }
                          else
                          {
                              this.dateIsValid_delivery = true;
                              return true;
                          }
                          break;
                      case 'exchange':
                          if (this.approvedPlanInput.exDate == null || this.approvedPlanInput.exDate == '')
                          {
                              this.dateIsValid_exchange = false;
                              return false;
                          }
                          else
                          {
                              this.dateIsValid_exchange = true;
                              return true;
                          }
                          break;
                      case 'delivery_amendment':
                          if (this.approvedAmendmentInput.date == null || this.approvedAmendmentInput.date == '')
                          {
                              this.dateIsValid_delivery_amendment = false;
                              return false;
                          }
                          else
                          {
                              this.dateIsValid_delivery_amendment = true;
                              return true;
                          }
                          break;
                  }
            },

            getAllProjectWithPlanId: function (pId) {
                axios.get('/budget/approved_project/capital_assets/getAllProjectWithPlanId' , {params:{pId: pId}})
                    .then((response) => {
                        this.approvedAmendmentProjects = response.data;
                        console.log(response);
                        console.log(JSON.stringify(this.approvedAmendmentProjects));
                    },(error) => {
                        console.log(error);
                    });
            },

            getAllApprovedPlan: function (pOrN) {
                axios.get('/budget/approved_plan/capital_assets/getAllItems' , {params:{pOrN: pOrN}})
                    .then((response) => {
                        this.approvedPlans = response.data;
                        console.log(response);
                    },(error) => {
                        console.log(error);
                    });
            },

            openAmendmentOfAgreementModal: function () {
                this.$validator.validateAll().then((result) => {
                    if (result) {
                        if (this.checkValidDate('delivery_amendment')) {
                            this.showModalAmendment = false;
                            this.getAllProjectWithPlanId(this.approvedAmendmentInput.id);
                            this.showModalAmendmentOfAgreement = true;

                        }
                    }
                });
            },

            openApprovedPlanInsertModal: function (type) {
                this.getCreditDistributionTitle(type);
                this.provOrNat = type;
                this.showInsertModal= true;
            },

            createApprovedPlan: function () {
                this.$validator.validateAll().then((result) => {
                    if (result) {
                        if (this.checkValidDate('delivery') && this.checkValidDate('exchange'))
                        {
                            axios.post('/budget/approved_plan/capital_assets/register' , {
                                cdtId: this.approvedPlanInput.cdtId,
                                idNumber: this.approvedPlanInput.idNumber,
                                date: this.approvedPlanInput.date,
                                exIdNumber: this.approvedPlanInput.exIdNumber,
                                exDate: this.approvedPlanInput.exDate,
                                description: this.approvedPlanInput.apDescription,
                                pOrN: this.provOrNat
                            }).then((response) => {
                                if (this.provOrNat == 0)
                                {
                                    this.approvedPlan_prov = response.data.data;
                                    this.makePagination(response.data , "provincial");
                                }
                                else
                                {
                                    this.approvedPlan_nat= response.data.data;
                                    this.makePagination(response.data , "national");
                                }
                                this.showInsertModal = false;
                                this.$parent.displayNotif(response.status);
                                console.log(response);
                            },(error) => {
                                console.log(error);
                                //this.errorMessage = 'ریز فصل با این مشخصات قبلا ثبت شده است!';
                            });
                        }
                    }
                });
            },

            approvedProjectsUpdateDialog: function (item , planId) {
                this.selectedSeasons = item.tiny_season.tsSId;
                this.getTinySeasons();
                this.approvedProjectsFill.apSubSeason = item.cpTsId;
                this.approvedProjectsFill.apPlan = planId;
                this.approvedProjectsFill.apProjectTitle = item.cpSubject;
                this.approvedProjectsFill.apProjectCode = item.cpCode;
                this.approvedProjectsFill.apStartYear = item.cpStartYear;
                this.approvedProjectsFill.apEndYear = item.cpEndOfYear;
                this.approvedProjectsFill.apHowToRun = item.cpHtrId;
                this.approvedProjectsFill.apPhysicalProgress = item.cpPhysicalProgress;
                this.approvedProjectsFill.apCity = item.cpCoId;
                this.approvedProjectsFill.apDescription = item.cpDescription;
                this.creditDistributionRows.forEach(cdr => {
                    "use strict";
                    Vue.set(this.creditDistributionRowInput , 'apCdr' + cdr.id , cdr.id);
                });
                this.errorMessage_update = '';
                this.showModalUpdate = true;
            },

            updateApprovedProjects: function () {
                if (this.approvedProjectsFill.apPlan != '' && this.approvedProjectsFill.apProjectTitle != '' && this.approvedProjectsFill.apProjectCode != '' && this.approvedProjectsFill.apStartYear != '' && this.approvedProjectsFill.apEndYear != ''&& this.approvedProjectsFill.apHowToRun != ''&& this.approvedProjectsFill.apPhysicalProgress != ''&& this.approvedProjectsFill.apCity != ''&& this.approvedProjectsFill.apSeason!= ''&& this.approvedProjectsFill.apSubSeason != '')
                {
                    /*axios.post('/budget/admin/sub_seasons/update' , this.tinySeasonsFill)
                        .then((response) => {
                            if(this.planOrCost == 1)
                                this.tinySeasonsCost = response.data;
                            else
                                this.tinySeasons = response.data;
                            this.showModalUpdate = false;
                            this.$notify({group: 'tinySeasonPm', title: 'پیام سیستم', text: 'بروزرسانی با موفقیت انجام شد.' , type: 'success'});
                            console.log(response);
                        },(error) => {
                            console.log(error);
                            this.errorMessage_update = 'ریز فصل با این مشخصات قبلا ثبت شده است!';
                        });*/
                    alert('ویرایش انجام شد');
                }
                else {
                    this.errorMessage_update = ' لطفا در وارد کردن اطلاعات دقت کنید!';
                }
            },

            openDeleteApprovedProjectsConfirm: function (ap) {
                this.apIdDelete = ap;
                this.showModalDelete = true;
            },

            deleteApprovedProjects: function () {
                /*axios.post('/budget/admin/sub_seasons/delete' , this.tsIdDelete)
                    .then((response) => {
                        if(response.data.tsPlanOrCost == 1)
                            this.tinySeasonsCost = response.data;
                        else
                            this.tinySeasons = response.data;
                        this.showModalDelete = false;
                        this.$notify({group: 'tinySeasonPm', title: 'پیام سیستم', text: 'حذف رکورد با موفقیت انجام شد.' , type: 'success'});
                        console.log(response);
                    },(error) => {
                        console.log(error);
                        this.$notify({group: 'tinySeasonPm', title: 'پیام سیستم', text: 'با توجه به وابستگی رکورد ها، حذف رکورد امکان پذیر نیست.' , type: 'error'});
                    });*/
            },
            openApprovedAmendmentModal: function (plan) {
                this.provOrNat = plan.capProvinceOrNational;
                this.getCreditDistributionTitle(this.provOrNat);
                this.approvedAmendmentInput.id = plan.id;
                this.approvedAmendmentInput.cdtId = plan.capCdtId;
                this.approvedAmendmentInput.idNumber = '';
                this.approvedAmendmentInput.date = '';
                this.approvedAmendmentInput.exIdNumber = plan.capExchangeIdNumber;
                this.approvedAmendmentInput.exDate = plan.capExchangeDate;
                this.approvedAmendmentInput.apDescription = plan.capDescription;
                this.approvedAmendmentInput.parentId = (plan.capCapId == null ? plan.id : plan.capCapId);
                this.showModalAmendment = true;
            },

            createApprovedAmendment: function () {
                this.$validator.validateAll().then((result) => {
                    if (result) {
                        if (this.checkValidDate('delivery_amendment'))
                        {
                            axios.post('/budget/approved_plan/capital_assets/register' , {
                                cdtId: this.approvedAmendmentInput.cdtId,
                                idNumber: this.approvedAmendmentInput.idNumber,
                                date: this.approvedAmendmentInput.date,
                                exIdNumber: this.approvedAmendmentInput.exIdNumber,
                                exDate: this.approvedAmendmentInput.exDate,
                                description: this.approvedAmendmentInput.apDescription,
                                pOrN: this.provOrNat,
                                capId: this.approvedAmendmentInput.parentId
                            }).then((response) => {
                                if (this.provOrNat == 0)
                                {
                                    this.approvedPlan_prov = response.data.data;
                                    this.makePagination(response.data , "provincial");
                                }
                                else
                                {
                                    this.approvedPlan_nat= response.data.data;
                                    this.makePagination(response.data , "national");
                                }
                                this.showInsertModal = false;
                                this.$parent.displayNotif(response.status);
                                console.log(response);
                            },(error) => {
                                console.log(error);
                                //this.errorMessage = 'ریز فصل با این مشخصات قبلا ثبت شده است!';
                            });
                        }
                    }
                });
            },

            openApprovedAmendmentOfAgreementModal: function () {
                this.showModalAmendmentOfAgreement= true;
                this.$parent.myResize();
            },
            openInsertProjectModal: function () {
                this.getAllApprovedPlan(this.provOrNat);
                this.projectAmendmentInput.capId = this.approvedAmendmentInput.parentId;
                this.showInsertModalProject= true;
            },
            openEditProjectModal: function () {
                this.showEditModalProject= true;
            },
            openAPCreditInsertModal: function () {
                this.showApCreditInsertModal=true;
            },
            openAPCreditEditModal: function () {
                this.showApCreditEditModal=true;
            },
            showSelectColumn: function () {
              if (this.selectColumn)
              {
                  this.selectColumn=false;
              }
              else{
                  this.selectColumn=true;
              }
            },
            myResizeModal: function() {
                /*console.log("......................res..........................");
                var tabHeight = $('.tabs').height();

                if (toolBarHeight === undefined)
                {
                    toolBarHeight = -8;
                }

                if (paginationHeight === undefined)
                {
                    paginationHeight = -8;
                }

                if (tabHeight===undefined) {
                    if (toolBarHeight > 0)
                        tabHeight = -28;
                    else
                        tabHeight = -8;
                    notifHeight=0;
                }

                if ($('.vertical-tab').length > 0)
                {
                    tabHeight = 10;
                }

                $('.dynamic-height-level1').css('height', ($.w.outerHeight() - 180) + 'px');

                var x = $(".dynamic-height-level1").height();
                $('.dynamic-height-level2').css('height', (x - 100 - (tabHeight  + toolBarHeight + paginationHeight)) + 'px');*/
            },


            makePagination: function(data , type){
                if (type == "national")
                {
                    this.national_pagination.current_page = data.current_page;
                    this.national_pagination.to = data.to;
                    this.national_pagination.last_page = data.last_page;
                }else if (type == "provincial")
                {
                    this.provincial_pagination.current_page = data.current_page;
                    this.provincial_pagination.to = data.to;
                    this.provincial_pagination.last_page = data.last_page;
                }
            },
        }
    }

</script>
