<template xmlns:v-on="http://www.w3.org/1999/xhtml">
    <!--Inner body start-->
    <div class="medium-10 border-right-line inner-body-pad main-margin">
        <div class="grid-x padding-lr breadcrumbs-pos">
            <div class="medium-12">
                <div class="grid-x">
                    <nav aria-label="You are here:" role="navigation">
                        <ul class="breadcrumbs">
                            <li><router-link to="/budget">داشبورد</router-link></li>
                            <li>
                                <a class="disabled">مدیریت</a>
                            </li>
                            <li>
                                <a class="disabled">تخصیص اعتبار</a>
                            </li>
                            <li>
                                <span class="show-for-sr">Current: </span> تملک دارایی سرمایه ای
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
        <div class="grid-x my-callout-box container-mrg-top dynamic-height-level1">
            <div class="medium-12 column">
                <ul class="tabs tab-color my-tab-style" data-responsive-accordion-tabs="tabs medium-accordion large-tabs" id="Register_of_credit_allocation_assets_tab_view">
                    <li class="tabs-title is-active"><a href="#national" aria-selected="true">استانی</a></li>
                    <li class="tabs-title"><a href="#provincial">ملی</a></li>
                </ul>
                <div class="tabs-content" data-tabs-content="Register_of_credit_allocation_assets_tab_view">
                    <!--Tab 1-->
                    <div class="tabs-panel is-active table-mrg-btm" id="national" xmlns:v-on="http://www.w3.org/1999/xhtml">
                        <div class="medium-12 bottom-mrg">
                            <div class="clearfix border-btm-line bottom-mrg tool-bar">
                                <div style="margin-top: 2px;" class="button-group float-right report-mrg">
                                    <a class="my-button toolbox-btn small" @click="openInsertModal(0)">جدید</a>
                                    <a class="my-button toolbox-btn small">گزارش</a>
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

                            <div class="tbl-div-container dynamic-height-level2">
                                <table class="tbl-head">
                                    <colgroup>
                                        <col width="200px"/>
                                        <col width="150px"/>
                                        <col width="150px"/>
                                        <col width="150px"/>
                                        <col width="150px"/>
                                        <col width="150px"/>
                                        <col width="150px"/>
                                        <col width="12px"/>
                                    </colgroup>
                                    <tbody class="tbl-head-style">
                                    <tr class="tbl-head-style-cell">
                                        <th class="tbl-head-style-cell">طرح</th>
                                        <th class="tbl-head-style-cell">پروژه</th>
                                        <th class="tbl-head-style-cell">ردیف اعتبار</th>
                                        <th class="tbl-head-style-cell">شماره</th>
                                        <th class="tbl-head-style-cell">تاریخ</th>
                                        <th class="tbl-head-style-cell">مبلغ</th>
                                        <th class="tbl-head-style-cell">سرجمع</th>
                                        <th class="tbl-head-style-cell"></th>
                                    </tr>
                                    </tbody>
                                </table>
                                <div class="">
                                    <table class="tbl-body-contain">
                                        <colgroup>
                                            <col width="200px"/>
                                            <col width="150px"/>
                                            <col width="150px"/>
                                            <col width="150px"/>
                                            <col width="150px"/>
                                            <col width="150px"/>
                                            <col width="150px"/>
                                        </colgroup>
                                        <tbody class="tbl-head-style-cell">
                                        <tr class="tbl-head-style-cell" v-for="plans in provCapitalAssetsAllocations">
                                            <td rowspan="3">{{ plans.credit_distribution_title.cdtIdNumber + ' - ' + plans.credit_distribution_title.cdtSubject + ' بلاتبلا تبلا تبلات بلات بلات بلات بلات بلات بلات بلات بلاتب لات بلات بلات بلا' }}</td>
                                            <td>Row A-2</td>
                                            <td>Row A-2</td>
                                            <td>Row A-2</td>
                                            <td>Row A-2</td>
                                            <td>Row A-2</td>
                                            <td>Row A-2</td>
                                        </tr>
                                        <tr class="tbl-head-style-cell">
                                            <td>Row A-2</td>
                                            <td>Row A-2</td>
                                            <td>Row A-2</td>
                                            <td>Row A-2</td>
                                            <td>Row A-2</td>
                                            <td>Row A-2</td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <!--Table Start-->
                            <!--<div class="columns">

                                <div class="table-contain  dynamic-height-level2">
                                    <div class="grid-x" v-for="plans in provCapitalAssetsAllocations">
                                        <div class="medium-2 table-contain-border1 cell-vertical-center">
                                            {{ plans.credit_distribution_title.cdtIdNumber + ' - ' + plans.credit_distribution_title.cdtSubject + ' بلاتبلا تبلا تبلات بلات بلات بلات بلات بلات بلات بلات بلاتب لات بلات بلات بلا' }}
                                        </div>
                                        <div class="medium-10">
                                            <div class="grid-x">
                                                <div class="medium-10" v-for="projects in plans.capital_assets_project">
                                                    <div class="grid-x">
                                                        <div class="medium-3 table-contain-border cell-vertical-center">
                                                            {{ projects.cpCode + ' - ' + projects.cpSubject + ' بلاتبلا تبلا تبلات بلات بلات بلات بلات بلات بلات بلات بلاتب لات بلات بلات بلا'}}
                                                        </div>
                                                        <div class="medium-9">
                                                            <div v-for="credit_source in projects.credit_source" class="grid-x" >
                                                                <div class="medium-4 table-contain-border cell-vertical-center">
                                                                    {{ credit_source.credit_distribution_row.cdSubject }}
                                                                </div>
                                                                <div class="medium-8">
                                                                    <div  class="grid-x" v-for="alloc in credit_source.allocation">
                                                                        <div class="medium-4 table-contain-border cell-vertical-center">
                                                                            {{ alloc.caaLetterNumber }}
                                                                        </div>
                                                                        <div class="medium-4 table-contain-border cell-vertical-center">
                                                                            {{ alloc.caaLetterDate }}
                                                                        </div>
                                                                        <div class="medium-4 table-contain-border cell-vertical-center">
                                                                            {{ $parent.calcDispAmount(alloc.caaAmount , false) }}
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div style="border-right: 1px solid #C7CDD1;" class="medium-2 table-contain-border1 cell-vertical-center" data-equalizer-watch="foo" >
                                                    <div class="grid-x">
                                                        <div class="medium-11">
                                                            {{ }}
                                                        </div>
                                                        <div class="medium-1 cell-vertical-center text-left">
                                                            <a class="dropdown small sm-btn-align"  type="button" :data-toggle="'rocaaRegisterOfCreditAllocationAssets'"><i class="fa fa-ellipsis-v size-18"></i></a>
                                                            <div class="dropdown-pane dropdown-pane-sm " data-close-on-click="true"  data-hover="true" data-hover-pane="true"  data-position="bottom" data-alignment="right" :id="'rocaaRegisterOfCreditAllocationAssets'" data-dropdown data-auto-focus="true">
                                                                <ul class="my-menu small-font text-right">
                                                                    <li><a v-on:click.prevent="registerOfCreditAllocationAssetsUpdateDialog(alloc , 1)"><i class="fi-pencil size-16"></i>  ویرایش</a></li>
                                                                    <li><a v-on:click.prevent="openDeleteRegisterOfCreditAllocationAssetsConfirm(alloc)"><i class="fi-trash size-16"></i>  حذف</a></li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="grid-x">
                                    <div class="medium-12">
                                        <vue-pagination  v-bind:pagination="provincial_pagination"
                                                         v-on:click.native="fetchProvincialData(provincial_pagination.current_page)"
                                                         :offset="4">
                                        </vue-pagination>
                                    </div>
                                </div>
                            </div>-->
                        </div>
                    </div>
                    <!--Tab 1-->
                    <!--Tab 2-->
                    <div class="tabs-panel table-mrg-btm" id="provincial" xmlns:v-on="http://www.w3.org/1999/xhtml">
                        <div class="medium-12 bottom-mrg">
                            <div class="clearfix border-btm-line bottom-mrg tool-bar">
                                <div style="margin-top: 2px;" class="button-group float-right report-mrg">
                                    <a class="my-button toolbox-btn small" @click="openInsertModal(1)">جدید</a>
                                    <a class="my-button toolbox-btn small">گزارش</a>
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
                                    <div class="medium-2 table-border">
                                        <strong>طرح</strong>
                                    </div>
                                    <div class="medium-10">
                                        <div class="grid-x">
                                            <div class="medium-2 table-border">
                                                <strong>پروژه</strong>
                                            </div>
                                            <div class="medium-8">
                                                <div class="grid-x">
                                                    <div class="medium-6 table-border">
                                                        <strong>ردیف اعتبار</strong>
                                                    </div>
                                                    <div class="medium-2 table-border">
                                                        <strong>شماره</strong>
                                                    </div>
                                                    <div class="medium-2 table-border">
                                                        <strong>تاریخ</strong>
                                                    </div>
                                                    <div class="medium-2  table-border">
                                                        <strong>مبلغ</strong>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="medium-2 table-border">
                                                <strong>سرجمع</strong>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--Header End-->
                                <div class="table-contain dynamic-height-level2">
                                    <div class="grid-x row-bottom-border" v-for="plans in registerOfCreditAllocationAssets">
                                        <div class="medium-2 table-contain-border1 cell-vertical-center">
                                            @{{ plans.credit_distribution_title.cdtIdNumber }}
                                        </div>
                                        <div class="medium-10">
                                            <div class="grid-x">
                                                <div class="medium-10 table-contain-border cell-vertical-center" v-for="projects in plans.capital_assets_project">
                                                    <div class="grid-x">
                                                        <div class="medium-3">
                                                            @{{ projects.cpCode }}
                                                        </div>
                                                        <div class="medium-9">
                                                            <div v-for="cdrCp in projects.cdr_cp" class="grid-x">
                                                                <div class="medium-6 table-contain-border cell-vertical-center">
                                                                    @{{ cdrCp.credit_distribution_row.cdSubject }}                                 سه درصدنفت وگاز
                                                                </div>
                                                                <div class="medium-6 table-contain-border cell-vertical-center">
                                                                    <div  class="grid-x">
                                                                        <div class="medium-2 table-contain-border cell-vertical-center">
                                                                            @{{ registerOfCreditAllocationAssets.rocaaNumber }}
                                                                        </div>
                                                                        <div class="medium-2 table-contain-border cell-vertical-center">
                                                                            @{{ registerOfCreditAllocationAssets.rocaaDate }}
                                                                        </div>
                                                                        <div class="medium-2  table-contain-border cell-vertical-center">
                                                                            123456
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div style="border-right: 1px solid #C7CDD1;" class="medium-2 table-contain-border1 cell-vertical-center">
                                                    <div class="grid-x">
                                                        <div class="medium-11">
                                                            @{{ }}
                                                        </div>
                                                        <div class="medium-1 cell-vertical-center text-left">
                                                            <a class="dropdown small sm-btn-align"  type="button" :data-toggle="'rocaaRegisterOfCreditAllocationAssets' + registerOfCreditAllocationAssets.id"><i class="fa fa-ellipsis-v size-18"></i></a>
                                                            <div class="dropdown-pane dropdown-pane-sm " data-close-on-click="true"  data-hover="true" data-hover-pane="true"  data-position="bottom" data-alignment="right" :id="'rocaaRegisterOfCreditAllocationAssets' + registerOfCreditAllocationAssets.id" data-dropdown data-auto-focus="true">
                                                                <ul class="my-menu small-font text-right">
                                                                    <li><a v-on:click.prevent="registerOfCreditAllocationAssetsUpdateDialog(tinySeason , 1)"><i class="fi-pencil size-16"></i>  ویرایش</a></li>
                                                                    <li><a v-on:click.prevent="openDeleteRegisterOfCreditAllocationAssetsConfirm(registerOfCreditAllocationAssets)"><i class="fi-trash size-16"></i>  حذف</a></li>
                                                                </ul>
                                                            </div>
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
                    <!--Tab 2-->
                    <notifications group="allocationPm"
                                   position="bottom right"
                                   animation-type="velocity"
                                   :speed="700" />
                </div>
                <!--Forms Start-->
                <!--Insert Modal Start-->
                <modal-large v-if="showModal" @close="showModal = false" xmlns:v-on="http://www.w3.org/1999/xhtml">
                    <div  slot="body">
                        <form v-on:submit.prevent="createCapitalAssetsAllocation">
                            <div class="grid-x" v-if="errorMessage">
                                <div class="medium-12 columns padding-lr">
                                    <div class="alert callout">
                                        <p class="BYekan login-alert"><i class="fi-alert"></i>{{ errorMessage }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="grid-x">
                                <div class="medium-2 padding-lr">
                                    <label>شماره نامه
                                        <input class="form-element-margin-btm" type="text" name="letterNumber" v-model="AllocationInput.idNumber">
                                    </label>
                                </div>
                                <div class="medium-2 padding-lr">
                                    <label>تاریخ نامه
                                        <input class="form-element-margin-btm" type="text" name="letterDate" v-model="AllocationInput.date">
                                    </label>
                                </div>
                            </div>
                            <div class="grid-x">
                                <div class="medium-6 cell padding-lr">
                                    <label>طرح
                                        <select class="form-element-margin-btm"  v-model="selectedPlan" v-on:change="getProjects" name="plan" v-validate data-vv-rules="required" :class="{'input': true, 'select-error': errors.has('plan')}">
                                            <option value=""></option>
                                            <option v-for="approvedPlan in approvedPlans" :value="approvedPlan.id">{{ approvedPlan.credit_distribution_title.cdtIdNumber + ' - ' + approvedPlan.credit_distribution_title.cdtSubject + (approvedPlan.credit_distribution_title.county == null ? '' : ' - ' + approvedPlan.credit_distribution_title.county.coName) }}</option>
                                        </select>
                                        <span v-show="errors.has('plan')" class="error-font">لطفا طرح را انتخاب کنید!</span>
                                    </label>
                                </div>
                                <div class="medium-6 cell padding-lr">
                                    <label>پروژه
                                        <select class="form-element-margin-btm" v-model="selectedProject" v-on:change="getProjectsCreditSource" name="projectTitle" v-validate data-vv-rules="required" :class="{'input': true, 'select-error': errors.has('projectTitle')}">
                                            <option value=""></option>
                                            <option v-for="project in approvedProjects" :value="project.id">{{ project.cpCode + ' - ' + project.cpSubject }}</option>
                                        </select>
                                    </label>
                                    <span v-show="errors.has('projectTitle')" class="error-font">لطفا عنوان پروژه انتخاب کنید!</span>
                                </div>
                            </div>
                            <div class="grid-x">
                                <div class="medium-6 cell padding-lr">
                                    <label>اعتبار مصوب
                                        <select class="form-element-margin-btm" @change="displayCreditResourceInfo"  v-model="AllocationInput.pcsId" name="credit" v-validate data-vv-rules="required" :class="{'input': true, 'select-error': errors.has('credit')}">
                                            <option value=""></option>
                                            <option v-for="projectCreditSource in projectCreditSources" :value="projectCreditSource.id">{{ projectCreditSource.credit_distribution_row.cdSubject + ' - فصل ' + projectCreditSource.tiny_season.season_title.season.sSubject + ' - ' + projectCreditSource.tiny_season.season_title.castSubject + ' - ' + projectCreditSource.tiny_season.catsSubject + ' - ' + $parent.calcDispAmount(projectCreditSource.ccsAmount) }}</option>
                                        </select>
                                        <span v-show="errors.has('credit')" class="error-font">لطفا اعتبار مصوب را انتخاب کنید!</span>
                                    </label>
                                </div>
                                <div class="medium-6 cell padding-lr">
                                    <label>مبلغ تخصیص <span class="btn-red">(میلیون ریال)</span>
                                        <input class="form-element-margin-btm" type="text"  v-model="AllocationInput.amount" name="creditCost" v-validate data-vv-rules="required" :class="{'input': true, 'select-error': errors.has('creditCost')}"/>
                                    </label>
                                    <span v-show="errors.has('creditCost')" class="error-font">لطفا مبلغ تخصیص انتخاب کنید!</span>
                                </div>
                            </div>
                            <div style="margin-top: 15px;" class="grid-x padding-lr" v-show="creditSourceInfo.approvedAmount">
                                <div class="medium-12 my-callout-bg-color">
                                    <div class="grid-x">
                                        <div class="medium-4">
                                            <span class="btn-red">اعتبار مصوب:</span><span>{{ ' ' + $parent.calcDispAmount(creditSourceInfo.approvedAmount) }}</span>
                                        </div>
                                        <div class="medium-4">
                                            <span class="btn-red">آخرین تخصیص:</span><span>{{ ' ' + $parent.calcDispAmount(creditSourceInfo.sumAllocation) }}</span>
                                        </div>
                                        <div class="medium-4">
                                            <span class="btn-red">درصدآخرین تخصیص:</span><span>{{ ' ' + $parent.calcPrecent(creditSourceInfo.approvedAmount , creditSourceInfo.sumAllocation) }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="grid-x">
                                <div class="small-12 columns padding-lr">
                                    <label>شرح
                                        <textarea name="csDescription" style="min-height: 150px;" v-model="AllocationInput.description"></textarea>
                                    </label>
                                </div>
                            </div>
                            <div class="medium-6 columns padding-lr padding-bottom-modal">
                                <button name="Submit" class="my-button my-success float-left btn-for-load"> <span class="btn-txt-mrg">ثبت</span></button>
                            </div>
                        </form>
                    </div>
                </modal-large>
                <!--Insert Modal End-->

                <!--Update Modal Start-->
<!--                <modal-large v-if="showModalUpdate" @close="showModalUpdate = false">
                    <div  slot="body">
                        <div class="grid-x" v-if="errorMessage">
                            <div class="medium-12 columns padding-lr">
                                <div class="alert callout">
                                    <p class="BYekan login-alert"><i class="fi-alert"></i>@{{ errorMessage }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="grid-x">
                            <div class="medium-2 padding-lr">
                                <label>شماره نامه
                                    <input class="form-element-margin-btm" type="text" name="letterNumber" v-model="AllocationInput.rocaaNumber">
                                </label>
                            </div>
                            <div class="medium-2 padding-lr">
                                <label>تاریخ نامه
                                    <input class="form-element-margin-btm" type="text" name="letterDate" v-model="AllocationInput.rocaaDate">
                                </label>
                            </div>
                        </div>

                        <div class="grid-x">
                            <div class="medium-6 cell padding-lr">
                                <label>طرح
                                    <select class="form-element-margin-btm"  v-model="AllocationInput.rocaaPlan" name="plan" v-validate data-vv-rules="required" :class="{'input': true, 'select-error': errors.has('plan')}">
                                        <option value=""></option>
                                        <option value="1">1</option>
                                    </select>
                                    <span v-show="errors.has('plan')" class="error-font">لطفا طرح را انتخاب کنید!</span>
                                </label>
                            </div>
                            <div class="medium-6 cell padding-lr">
                                <label>عنوان پروژه
                                    <select class="form-element-margin-btm"  v-model="AllocationInput.rocaaProject" name="projectTitle" v-validate data-vv-rules="required" :class="{'input': true, 'select-error': errors.has('projectTitle')}">
                                        <option value=""></option>
                                        <option value="1">1</option>
                                    </select>
                                </label>
                                <span v-show="errors.has('projectTitle')" class="error-font">لطفا عنوان پروژه انتخاب کنید!</span>
                            </div>
                        </div>
                        <div style="margin-top: 15px;" class="grid-x padding-lr">
                            <div class="medium-12 my-callout-bg-color">
                                <div class="grid-x">
                                    <div class="medium-4">
                                        <p class="btn-red">ردیف توزیع اعتبار</p>
                                    </div>
                                    <div class="medium-3">
                                        <p class="btn-red">اعتبار مبادله شده</p>
                                    </div>
                                    <div class="medium-2">
                                        <p class="btn-red">آخرین تخصیص</p>
                                    </div>
                                    <div class="medium-3">
                                        <p class="btn-red text-center">مبلغ</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div style="margin-top: 15px;margin-bottom: 25px;" class="grid-x padding-lr small-font">
                            <div class="medium-12">
                                <div class="grid-x">
                                    <div class="medium-4 padding-lr">
                                        <p>ردیف توزیع اعتبار</p>
                                    </div>
                                    <div class="medium-3 padding-lr">
                                        <p>اعتبار مبادله شده</p>
                                    </div>
                                    <div class="medium-2 padding-lr">
                                        <p>آخرین تخصیص</p>
                                    </div>
                                    <div style="margin-top: -7px;" class="medium-3 padding-lr">
                                        <label>
                                            <input class="form-element-margin-btm" type="text" name="cost" v-model="AllocationInput.rocaaCost" v-validate="'required|numeric'" :class="{'input': true, 'error-border': errors.has('cost')}">
                                        </label>
                                        <span v-show="errors.has('cost')" class="error-font">لطفا مبلغ را وارد کنید!</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="medium-6 columns padding-lr padding-bottom-modal">
                            <button name="Submit" class="my-button my-success float-left btn-for-load"> <span class="btn-txt-mrg">ثبت</span></button>
                        </div>
                    </div>
                </modal-large>-->
                <!--Update Modal End-->

                <!-- Delete Modal Start-->
<!--                <modal-tiny v-if="showModalDelete" @close="showModalDelete = false">
                    <div  slot="body">
                        <div class="small-font" xmlns:v-on="http://www.w3.org/1999/xhtml">
                            <p>کاربر گرامی</p>
                            <p class="large-offset-1 modal-text">برای حذف رکورد مورد نظر اطمینان دارید؟</p>
                            <div class="grid-x">
                                <div class="medium-12 column text-center">
                                    <button  class="button primary btn-large-w" v-on:click="deleteTinySeason">بله</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </modal-tiny>-->
                <!-- Delete Modal End-->
                <!--Forms End-->
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
                provCapitalAssetsAllocations: [],
                natCapitalAssetsAllocations: [],
                AllocationInput: {},
                provOrNat: '',
                showModal: false,
                showModalUpdate: false,
                showModalDelete: false,
                registerOfCreditAllocationAssetsFill: {rocaPlan: '' ,rocaaProject:'',rocaaRow:'',roccaCost:'',rocaaNumber:'',rocaaDate:''},
                creditSourceInfo: {},
                rocaaIdDelete: {},
                approvedPlans: {},
                selectedPlan: '',
                selectedProject: '',
                approvedProjects: {},
                projectCreditSources: {},

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
            this.getAllApprovedPlan(0); // 0 = provincial
        },

        updated: function () {
            $(this.$el).foundation(); //WORKS!
        },

        mounted: function () {
            console.log("mounted capital assets allocation component");
            res();
        },

        components:{
            'vue-pagination' : VuePagination
        },

        methods:{
            fetchProvincialData: function (page = 1) {
                axios.get('/budget/allocation/capital_assets/fetchData?page=' + page , {params:{pOrN: 0}})
                    .then((response) => {
                        this.provCapitalAssetsAllocations = response.data.data;
                        this.makePagination(response.data , "provincial");
                        console.log(response);
                    },(error) => {
                        console.log(error);
                    });
            },

            fetchNationalData: function (page = 1) {
                axios.get('/budget/allocation/register_of_credit_allocation_assets/fetchData?page=' + page , {params:{planOrCost: 0}})
                    .then((response) => {
                        this.natCapitalAssetsAllocations = response.data.data;
                        this.makePagination(response.data , "national");
                        console.log(response);
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

            getProjects: function () {
                axios.get('/budget/approved_project/capital_assets/getAllItems' , {params:{pId: this.selectedPlan , planOrCost: 0}})
                    .then((response) => {
                        this.approvedProjects = response.data;
                        console.log(response);
                    },(error) => {
                        console.log(error);
                    });
            },

            getProjectsCreditSource: function () {
                axios.get('/budget/approved_project/capital_assets/credit_source/getAllItem' , {params:{pId: this.selectedProject}})
                   .then((response) => {
                        this.projectCreditSources = response.data;
                        console.log(response);
                    },(error) => {
                        console.log(error);
                });
            },

            displayCreditResourceInfo: function () {
                axios.get('/budget/allocation/capital_assets/getCapitalAssetsCreditSourceInfo' , {params:{pcsId: this.AllocationInput.pcsId}})
                    .then((response) => {
                        this.creditSourceInfo = response.data;
                        console.log(response);
                    },(error) => {
                        console.log(error);
                    });

            },

            openInsertModal: function (type) {
                this.provOrNat = type;
                this.getAllApprovedPlan(type);
                this.showModal = true;
            },

            createCapitalAssetsAllocation: function () {
                this.$validator.validateAll().then((result) => {
                    if (result) {
                        axios.post('/budget/allocation/capital_assets/register' , {
                            idNumber: this.AllocationInput.idNumber,
                            date: this.AllocationInput.date,
                            pcsId: this.AllocationInput.pcsId,
                            amount: this.AllocationInput.amount,
                            description: this.AllocationInput.description,
                            pOrN: this.provOrNat
                        })
                            .then((response) => {
                                if (this.provOrNat == 0)
                                {
                                    this.provCapitalAssetsAllocations = response.data.data;
                                    this.makePagination(response.data , "provincial");
                                }
                                else
                                {
                                    this.natCapitalAssetsAllocations = response.data.data;
                                    this.makePagination(response.data , "national");
                                }
                                this.showModal = false;
                                this.displayNotif(response.status);
                                console.log(response);
                            },(error) => {
                                console.log(error);
                                this.errorMessage = 'تخصیص با این مشخصات قبلا ثبت شده است!';
                            });
                    }
                });
            },

            registerOfCreditAllocationAssetsUpdateDialog: function (item) {
                this.registerOfCreditAllocationAssetsFill.rocaPlan = item.rocaPlan;
                this.registerOfCreditAllocationAssetsFill.rocaaProject = item.rocaaProject;
                this.registerOfCreditAllocationAssetsFill.rocaaRow = item.rocaaRow;
                this.registerOfCreditAllocationAssetsFill.roccaCost = item.roccaCost;
                this.registerOfCreditAllocationAssetsFill.rocaaNumber = item.rocaaNumber;
                this.registerOfCreditAllocationAssetsFill.rocaaDate = item.rocaaDate;

                this.errorMessage_update = '';
                this.showModalUpdate = true;
            },

            updateRegisterOfCreditAllocationAssets: function () {

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

            },

            openDeleteRegisterOfCreditAllocationAssetsConfirm: function (rocaa) {
                this.apIdDelete = rocaa;
                this.showModalDelete = true;
            },

            deleteRegisterOfCreditAllocationAssets: function () {
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

            displayNotif: function (httpStatusCode) {
                switch (httpStatusCode){
                    case 204:
                        this.$notify({group: 'allocationPm', title: 'پیام سیستم', text: 'با توجه به وابستگی رکورد ها، حذف رکورد امکان پذیر نیست.' , type: 'error'});
                        break;
                    case 200:
                        this.$notify({group: 'allocationPm', title: 'پیام سیستم', text: 'درخواست با موفقیت انجام شد.' , type: 'success'});
                        break;
                }
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

<style>

</style>

