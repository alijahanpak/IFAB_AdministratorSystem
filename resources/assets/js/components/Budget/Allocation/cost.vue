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
                                <span class="show-for-sr">Current: </span> هزینه ای
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
                                    <button class="my-button toolbox-btn small dropdown small sm-btn-align"  type="button" data-toggle="DropDown1">تعداد نمایش<span> 20 </span></button>
                                    <div  style="width: 113px;" class="dropdown-pane dropdown-pane-sm " data-close-on-click="true"  data-hover="true" data-hover-pane="true"  data-position="bottom" data-alignment="left" id="DropDown1" data-dropdown data-auto-focus="true">
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
                                        <col width="200px"/>
                                        <col width="150px"/>
                                        <col width="150px"/>
                                        <col width="150px"/>
                                        <col width="150px"/>
                                        <col width="150px"/>
                                        <col width="12px"/>
                                    </colgroup>
                                    <tbody class="tbl-head-style">
                                    <tr class="tbl-head-style-cell">
                                        <th class="tbl-head-style-cell">برنامه</th>
                                        <th class="tbl-head-style-cell">سرجمع</th>
                                        <th class="tbl-head-style-cell">ردیف اعتبار</th>
                                        <th class="tbl-head-style-cell">شماره</th>
                                        <th class="tbl-head-style-cell">تاریخ</th>
                                        <th class="tbl-head-style-cell">مبلغ</th>
                                        <th class="tbl-head-style-cell"></th>
                                    </tr>
                                    </tbody>
                                </table>
                                <!--Table Head End-->
                                <!--Table Body Start-->
                                <div class="scrollbar-macosx">
                                <div class="tbl_body_style dynamic-height-level2">
                                    <table class="tbl-body-contain">
                                        <colgroup>
                                            <col width="200px"/>
                                            <col width="150px"/>
                                            <col width="150px"/>
                                            <col width="150px"/>
                                            <col width="150px"/>
                                            <col width="150px"/>
                                        </colgroup>
                                        <tbody class="tbl-head-style-cell">
                                            <template v-for="progs in provCostAllocations">
                                                <tr class="tbl-head-style-cell" >
                                                    <td :rowspan="getProjectAllocCount(progs.ca_credit_source_has_allocation)">{{ progs.caLetterNumber }}</td>
                                                    <td :rowspan="getProjectAllocCount(progs.ca_credit_source_has_allocation)" class="text-center">{{ $parent.calcDispAmount(getProgAllocationSum(progs.ca_credit_source_has_allocation) , false) }}</td>
                                                    <td :rowspan="progs.ca_credit_source_has_allocation[0].allocation.length">{{ progs.ca_credit_source_has_allocation[0].credit_distribution_row.cdSubject }}</td>
                                                    <td>{{ progs.ca_credit_source_has_allocation[0].allocation[0].caLetterNumber }}</td>
                                                    <td>{{ progs.ca_credit_source_has_allocation[0].allocation[0].caLetterDate }}</td>
                                                    <td>
                                                        <div class="grid-x">
                                                            <div class="medium-11">
                                                                {{ $parent.calcDispAmount(progs.ca_credit_source_has_allocation[0].allocation[0].caAmount , false) }}
                                                            </div>
                                                            <div class="medium-1 cell-vertical-center text-left">
                                                                <a class="dropdown small sm-btn-align"  type="button" :data-toggle="'provCostAllocation' + progs.id"><i class="fa fa-ellipsis-v size-18"></i></a>
                                                                <div class="dropdown-pane dropdown-pane-sm " data-close-on-click="true"  data-hover="true" data-hover-pane="true"  data-position="bottom" data-alignment="right" :id="'provCostAllocation' + progs.id" data-dropdown data-auto-focus="true">
                                                                    <ul class="my-menu small-font text-right">
                                                                        <li><a v-on:click.prevent=""><i class="fa fa-pencil-square-o size-16"></i>  ویرایش</a></li>
                                                                        <li><a v-on:click.prevent=""><i class="fa fa-trash-o size-16"></i>  حذف</a></li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <template v-for="(credit_source , csIndex) in progs.ca_credit_source_has_allocation">
                                                    <tr class="tbl-head-style-cell" v-if="csIndex > 0">
                                                        <td :rowspan="credit_source.allocation.length">{{ credit_source.credit_distribution_row.cdSubject }}</td>
                                                        <td>{{ credit_source.allocation[0].caLetterNumber }}</td>
                                                        <td>{{ credit_source.allocation[0].caLetterDate }}</td>
                                                        <td>
                                                            <div class="grid-x">
                                                                <div class="medium-11">
                                                                    {{ $parent.calcDispAmount(credit_source.allocation[0].caAmount , false) }}
                                                                </div>
                                                                <div class="medium-1 cell-vertical-center text-left">
                                                                    <a class="dropdown small sm-btn-align"  type="button" :data-toggle="'provCostAllocation' + progs.id + credit_source.id"><i class="fa fa-ellipsis-v size-18"></i></a>
                                                                    <div class="dropdown-pane dropdown-pane-sm " data-close-on-click="true"  data-hover="true" data-hover-pane="true"  data-position="bottom" data-alignment="right" :id="'provCostAllocation' + progs.id + credit_source.id" data-dropdown data-auto-focus="true">
                                                                        <ul class="my-menu small-font text-right">
                                                                            <li><a v-on:click.prevent=""><i class="fa fa-pencil-square-o size-16"></i>  ویرایش</a></li>
                                                                            <li><a v-on:click.prevent=""><i class="fa fa-trash-o size-16"></i>  حذف</a></li>
                                                                        </ul>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <template v-for="(alloc , allocIndex) in credit_source.allocation">
                                                        <tr class="tbl-head-style-cell" v-if="allocIndex > 0">
                                                            <td>{{ alloc.caLetterNumber }}</td>
                                                            <td>{{ alloc.caLetterDate }}</td>
                                                            <td>
                                                                <div class="grid-x">
                                                                    <div class="medium-11">
                                                                        {{ $parent.calcDispAmount(alloc.caAmount , false) }}
                                                                    </div>
                                                                    <div class="medium-1 cell-vertical-center text-left">
                                                                        <a class="dropdown small sm-btn-align"  type="button" :data-toggle="'provCostAllocation' + progs.id + credit_source.id + alloc.id"><i class="fa fa-ellipsis-v size-18"></i></a>
                                                                        <div class="dropdown-pane dropdown-pane-sm " data-close-on-click="true"  data-hover="true" data-hover-pane="true"  data-position="bottom" data-alignment="right" :id="'provCostAllocation' + progs.id + credit_source.id + alloc.id" data-dropdown data-auto-focus="true">
                                                                            <ul class="my-menu small-font text-right">
                                                                                <li><a v-on:click.prevent=""><i class="fa fa-pencil-square-o size-16"></i>  ویرایش</a></li>
                                                                                <li><a v-on:click.prevent=""><i class="fa fa-trash-o size-16"></i>  حذف</a></li>
                                                                            </ul>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    </template>
                                                </template>
                                            </template>
                                        </tbody>
                                    </table>
                                </div>
                                <!--Table Body End-->
                            </div>
                            </div>
                            <!--Table End-->
                        </div>
                    </div>
                    <!--Tab 1 End-->
                    <!--Tab 2 Start-->
                    <div class="tabs-panel table-mrg-btm" id="provincial" xmlns:v-on="http://www.w3.org/1999/xhtml">
                        <div class="medium-12 bottom-mrg">
                            <div class="clearfix border-btm-line bottom-mrg tool-bar">
                                <div style="margin-top: 2px;" class="button-group float-right report-mrg">
                                    <a class="my-button toolbox-btn small" @click="openInsertModal(1)">جدید</a>
                                    <a class="my-button toolbox-btn small">گزارش</a>
                                    <button class="my-button toolbox-btn small dropdown small sm-btn-align"  type="button" data-toggle="DropDown2">تعداد نمایش<span> 20 </span></button>
                                    <div  style="width: 113px;" class="dropdown-pane dropdown-pane-sm " data-close-on-click="true"  data-hover="true" data-hover-pane="true"  data-position="bottom" data-alignment="left" id="DropDown2" data-dropdown data-auto-focus="true">
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
                                        <col width="200px"/>
                                        <col width="150px"/>
                                        <col width="150px"/>
                                        <col width="150px"/>
                                        <col width="150px"/>
                                        <col width="150px"/>
                                        <col width="12px"/>
                                    </colgroup>
                                    <tbody class="tbl-head-style ">
                                    <tr class="tbl-head-style-cell">
                                        <th class="tbl-head-style-cell">برنامه</th>
                                        <th class="tbl-head-style-cell">سرجمع</th>
                                        <th class="tbl-head-style-cell">ردیف اعتبار</th>
                                        <th class="tbl-head-style-cell">شماره</th>
                                        <th class="tbl-head-style-cell">تاریخ</th>
                                        <th class="tbl-head-style-cell">مبلغ</th>
                                        <th class="tbl-head-style-cell"></th>
                                    </tr>
                                    </tbody>
                                </table>
                                <!--Table Head End-->
                                <!--Table Body Start-->
                                <div class="tbl_body_style dynamic-height-level2">
                                    <table class="tbl-body-contain">
                                        <colgroup>
                                            <col width="200px"/>
                                            <col width="150px"/>
                                            <col width="150px"/>
                                            <col width="150px"/>
                                            <col width="150px"/>
                                            <col width="150px"/>
                                        </colgroup>
                                        <tbody class="tbl-head-style-cell">
                                            <template v-for="progs in natCostAllocations">
                                                <tr class="tbl-head-style-cell" >
                                                    <td :rowspan="getProjectAllocCount(progs.ca_credit_source_has_allocation)">{{ progs.caLetterNumber }}</td>
                                                    <td :rowspan="getProjectAllocCount(progs.ca_credit_source_has_allocation)" class="text-center">{{ $parent.calcDispAmount(getProgAllocationSum(progs.ca_credit_source_has_allocation) , false) }}</td>
                                                    <td :rowspan="progs.ca_credit_source_has_allocation[0].allocation.length">{{ progs.ca_credit_source_has_allocation[0].credit_distribution_row.cdSubject }}</td>
                                                    <td>{{ progs.ca_credit_source_has_allocation[0].allocation[0].caLetterNumber }}</td>
                                                    <td>{{ progs.ca_credit_source_has_allocation[0].allocation[0].caLetterDate }}</td>
                                                    <td>
                                                        <div class="grid-x">
                                                            <div class="medium-11">
                                                                {{ $parent.calcDispAmount(progs.ca_credit_source_has_allocation[0].allocation[0].caAmount , false) }}
                                                            </div>
                                                            <div class="medium-1 cell-vertical-center text-left">
                                                                <a class="dropdown small sm-btn-align"  type="button" :data-toggle="'provCostAllocation' + progs.id"><i class="fa fa-ellipsis-v size-18"></i></a>
                                                                <div class="dropdown-pane dropdown-pane-sm " data-close-on-click="true"  data-hover="true" data-hover-pane="true"  data-position="bottom" data-alignment="right" :id="'provCostAllocation' + progs.id" data-dropdown data-auto-focus="true">
                                                                    <ul class="my-menu small-font text-right">
                                                                        <li><a v-on:click.prevent=""><i class="fa fa-pencil-square-o size-16"></i>  ویرایش</a></li>
                                                                        <li><a v-on:click.prevent=""><i class="fa fa-trash-o size-16"></i>  حذف</a></li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <template v-for="(credit_source , csIndex) in progs.ca_credit_source_has_allocation">
                                                    <tr class="tbl-head-style-cell" v-if="csIndex > 0">
                                                        <td :rowspan="credit_source.allocation.length">{{ credit_source.credit_distribution_row.cdSubject }}</td>
                                                        <td>{{ credit_source.allocation[0].caLetterNumber }}</td>
                                                        <td>{{ credit_source.allocation[0].caLetterDate }}</td>
                                                        <td>
                                                            <div class="grid-x">
                                                                <div class="medium-11">
                                                                    {{ $parent.calcDispAmount(credit_source.allocation[0].caAmount , false) }}
                                                                </div>
                                                                <div class="medium-1 cell-vertical-center text-left">
                                                                    <a class="dropdown small sm-btn-align"  type="button" :data-toggle="'provCostAllocation' + progs.id + credit_source.id"><i class="fa fa-ellipsis-v size-18"></i></a>
                                                                    <div class="dropdown-pane dropdown-pane-sm " data-close-on-click="true"  data-hover="true" data-hover-pane="true"  data-position="bottom" data-alignment="right" :id="'provCostAllocation' + progs.id + credit_source.id" data-dropdown data-auto-focus="true">
                                                                        <ul class="my-menu small-font text-right">
                                                                            <li><a v-on:click.prevent=""><i class="fa fa-pencil-square-o size-16"></i>  ویرایش</a></li>
                                                                            <li><a v-on:click.prevent=""><i class="fa fa-trash-o size-16"></i>  حذف</a></li>
                                                                        </ul>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <template v-for="(alloc , allocIndex) in credit_source.allocation">
                                                        <tr class="tbl-head-style-cell" v-if="allocIndex > 0">
                                                            <td>{{ alloc.caLetterNumber }}</td>
                                                            <td>{{ alloc.caLetterDate }}</td>
                                                            <td>
                                                                <div class="grid-x">
                                                                    <div class="medium-11">
                                                                        {{ $parent.calcDispAmount(alloc.caAmount , false) }}
                                                                    </div>
                                                                    <div class="medium-1 cell-vertical-center text-left">
                                                                        <a class="dropdown small sm-btn-align"  type="button" :data-toggle="'provCostAllocation' + progs.id + credit_source.id + alloc.id"><i class="fa fa-ellipsis-v size-18"></i></a>
                                                                        <div class="dropdown-pane dropdown-pane-sm " data-close-on-click="true"  data-hover="true" data-hover-pane="true"  data-position="bottom" data-alignment="right" :id="'provCostAllocation' + progs.id + credit_source.id + alloc.id" data-dropdown data-auto-focus="true">
                                                                            <ul class="my-menu small-font text-right">
                                                                                <li><a v-on:click.prevent=""><i class="fa fa-pencil-square-o size-16"></i>  ویرایش</a></li>
                                                                                <li><a v-on:click.prevent=""><i class="fa fa-trash-o size-16"></i>  حذف</a></li>
                                                                            </ul>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    </template>
                                                </template>
                                            </template>
                                        </tbody>
                                    </table>
                                </div>
                                <!--Table Body End-->
                            </div>
                            <!--Table End-->
                        </div>
                    </div>
                    <!--Tab 2-->
                </div>
                <!--Forms Start-->
                <!--Insert Modal Start-->
                <modal-small v-if="showModal" @close="showModal = false" xmlns:v-on="http://www.w3.org/1999/xhtml">
                    <div  slot="body">
                        <form v-on:submit.prevent="createCostAllocation">
                            <div class="grid-x" v-if="errorMessage">
                                <div class="medium-12 columns padding-lr">
                                    <div class="alert callout">
                                        <p class="BYekan login-alert"><i class="fi-alert"></i>{{ errorMessage }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="grid-x">
                                <div class="medium-4 padding-lr">
                                    <label>شماره نامه
                                        <input class="form-element-margin-btm" type="text" name="letterNumber" v-model="AllocationInput.idNumber">
                                    </label>
                                </div>
                                <div class="medium-4 padding-lr">
                                    <label>تاریخ نامه
                                        <input class="form-element-margin-btm" type="text" name="letterDate" v-model="AllocationInput.date">
                                    </label>
                                </div>
                            </div>
                            <div class="grid-x">
                                <div class="medium-8 cell padding-lr">
                                    <label>موافقت نامه
                                        <select class="form-element-margin-btm"  v-model="selectedCostAgreement" v-on:change="getCreditSource" name="approved" v-validate data-vv-rules="required" :class="{'input': true, 'select-error': errors.has('approved')}">
                                            <option value=""></option>
                                            <option v-for="costAgreement in costAgreements" :value="costAgreement.id">{{ 'موافقتنامه شماره ' + costAgreement.caLetterNumber }}</option>
                                        </select>
                                        <span v-show="errors.has('approved')" class="error-font">لطفا موافقت نامه را انتخاب کنید!</span>
                                    </label>
                                </div>
                            </div>
                            <div class="grid-x">
                                <div class="medium-6 cell padding-lr">
                                    <label>اعتبار مصوب
                                        <select class="form-element-margin-btm" @change=""  v-model="AllocationInput.caCsId" name="credit" v-validate data-vv-rules="required" :class="{'input': true, 'select-error': errors.has('credit')}">
                                            <option value=""></option>
                                            <option v-for="caCreditSource in caCreditSources" :value="caCreditSource.id">{{ caCreditSource.credit_distribution_title.cdtSubject + ' - ' + caCreditSource.credit_distribution_row.cdSubject + ' - ' + caCreditSource.tiny_season.season_title.season.sSubject + ' - ' + caCreditSource.tiny_season.season_title.cstSubject + ' - ' + caCreditSource.tiny_season.ctsSubject + ' - ' + $parent.calcDispAmount(caCreditSource.ccsAmount) }}</option>
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
                            <div style="margin-top: 5px;margin-bottom: 10px" class="grid-x" v-show="creditSourceInfo.approvedAmount">
                                <div class="medium-12 my-callout-bg-color">
                                    <div class="grid-x">
                                        <div class="medium-12">
                                            <span class="btn-red">اعتبار مصوب:</span><span></span>
                                        </div>
                                        <div class="medium-12">
                                            <span class="btn-red">آخرین تخصیص:</span><span></span>
                                        </div>
                                        <div class="medium-12">
                                            <span class="btn-red">درصدآخرین تخصیص:</span><span></span>
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
                </modal-small>
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
                provCostAllocations: [],
                natCostAllocations: [],
                AllocationInput: {},
                provOrNat: '',
                showModal: false,
                showModalUpdate: false,
                showModalDelete: false,
                costAllocationFill: {},
                creditSourceInfo: {},
                caIdDelete: {},
                approvedPlans: {},
                selectedCostAgreement: '',
                costAgreements: {},
                caCreditSources: {},

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
            $('.scrollbar-macosx').scrollbar();

        },

        updated: function () {
            $(this.$el).foundation(); //WORKS!


        },

        mounted: function () {
            console.log("mounted Cost allocation component");
            this.$parent.myResize();


        },

        components:{
            'vue-pagination' : VuePagination
        },

        methods:{
            fetchProvincialData: function (page = 1) {
                axios.get('/budget/allocation/cost/fetchData?page=' + page , {params:{pOrN: 0}})
                    .then((response) => {
                        this.provCostAllocations = response.data.data;
                        this.makePagination(response.data , "provincial");
                        console.log(response);
                    },(error) => {
                        console.log(error);
                    });
            },

            fetchNationalData: function (page = 1) {
                axios.get('/budget/allocation/cost/fetchData?page=' + page , {params:{pOrN: 1}})
                    .then((response) => {
                        this.natCostAllocations = response.data.data;
                        this.makePagination(response.data , "national");
                        console.log(response);
                    },(error) => {
                        console.log(error);
                    });
            },

            getAllCostAgreements: function (pOrN) {
                axios.get('/budget/approved_plan/cost/getAllItems' , {params:{pOrN: pOrN}})
                        .then((response) => {
                        this.costAgreements = response.data;
                        console.log(response);
                        },(error) => {
                            console.log(error);
                });
            },

            getCreditSource: function () {
                axios.get('/budget/approved_plan/cost/credit_source/getAllItem' , {params:{caId: this.selectedCostAgreement}})
                   .then((response) => {
                        this.caCreditSources = response.data;
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

            getProgAllocationSum: function (creditSource) {
                var sum = 0;
                creditSource.forEach(cs => {
                    cs.allocation.forEach(alloc => {
                        sum += alloc.caAmount;
                    });
                });

                return sum;
            },

            getPlanAllocCount: function (projects) {
                  var count = 0;
                    projects.forEach(cap => {
                          cap.credit_source.forEach(cs => {
                             count += cs.allocation.length;
                          });
                      });
                  return count;
            },

            getProjectAllocCount: function (credit_sources) {
                var count = 0;
                credit_sources.forEach(cs => {
                    count += cs.allocation.length;
                });
                return count;
            },

            openInsertModal: function (type) {
                this.provOrNat = type;
                this.getAllCostAgreements(type);
                this.showModal = true;
            },

            createCostAllocation: function () {
                this.$validator.validateAll().then((result) => {
                    if (result) {
                        axios.post('/budget/allocation/cost/register' , {
                            idNumber: this.AllocationInput.idNumber,
                            date: this.AllocationInput.date,
                            ccsId: this.AllocationInput.caCsId,
                            amount: this.AllocationInput.amount,
                            description: this.AllocationInput.description,
                            pOrN: this.provOrNat
                        })
                            .then((response) => {
                                if (this.provOrNat == 0)
                                {
                                    this.provCostAllocations = response.data.data;
                                    this.makePagination(response.data , "provincial");
                                }
                                else
                                {
                                    this.natCostAllocations = response.data.data;
                                    this.makePagination(response.data , "national");
                                }
                                this.showModal = false;
                                this.$parent.displayNotif(response.status);
                                console.log(response);
                            },(error) => {
                                console.log(error);
                                this.errorMessage = 'تخصیص با این مشخصات قبلا ثبت شده است!';
                            });
                    }
                });
            },

            registerOfCreditAllocationAssetsUpdateDialog: function (item) {
                this.costAllocationFill.caPlan = item.caPlan;
                this.costAllocationFill.caSum = item.caSum;
                this.costAllocationFill.caRow = item.caRow;
                this.costAllocationFill.caNumber = item.caNumber;
                this.costAllocationFill.caDate = item.caDate;
                this.costAllocationFill.caCost = item.caCost;

                this.errorMessage_update = '';
                this.showModalUpdate = true;
            },

            updateCostAllocation: function () {

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

            openDeleteCostAllocationConfirm: function (ca) {
                this.apIdDelete = rocaa;
                this.showModalDelete = true;
            },

            deleteCostAllocation: function () {
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


