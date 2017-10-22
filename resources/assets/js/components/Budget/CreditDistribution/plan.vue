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
                                <a class="disabled">توزیع اعتبار</a>
                            </li>
                            <li>
                                <a class="disabled">تملک دارایی های سرمایه ای</a>
                            </li>
                            <li>
                                <a class="disabled">استانی</a>
                            </li>
                            <li>
                                <span class="show-for-sr">Current: </span> طرح های توزیع اعتبار
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
        <div class="grid-x my-callout-box container-mrg-top dynamic-height-level1">
            <div class="medium-12 column">
                <ul class="tabs tab-color my-tab-style" data-responsive-accordion-tabs="tabs medium-accordion large-tabs" id="Register_of_credit_allocation_assets_tab_view">
                    <li class="tabs-title is-active"><a href="#plan" aria-selected="true">طرح</a></li>
                    <li class="tabs-title"><a href="#row">ردیف</a></li>
                    <li class="tabs-title"><a href="#budget">فصل بودجه</a></li>
                    <li class="tabs-title"><a href="#province">شهرستان</a></li>
                </ul>
                <div class="tabs-content" data-tabs-content="Register_of_credit_allocation_assets_tab_view">
                    <!--Tab 1-->
                    <div class="tabs-panel is-active table-mrg-btm" id="plan" xmlns:v-on="http://www.w3.org/1999/xhtml">
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

                            <div class="tbl-div-container">
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
                                        <th class="tbl-head-style-cell">سرجمع</th>
                                        <th class="tbl-head-style-cell">ردیف اعتبار</th>
                                        <th class="tbl-head-style-cell">شماره</th>
                                        <th class="tbl-head-style-cell">تاریخ</th>
                                        <th class="tbl-head-style-cell">مبلغ</th>
                                        <th class="tbl-head-style-cell"></th>
                                    </tr>
                                    </tbody>
                                </table>

                                <div class="tbl_body_style dynamic-height-level2">
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
                                            <template v-for="plans in provCapitalAssetsAllocations">
                                                <tr class="tbl-head-style-cell" >
                                                    <td :rowspan="getPlanAllocCount(plans.capital_assets_project_has_credit_source)">{{ plans.credit_distribution_title.cdtIdNumber + ' - ' + plans.credit_distribution_title.cdtSubject }}</td>
                                                    <td :rowspan="getProjectAllocCount(plans.capital_assets_project_has_credit_source[0].credit_source_has_allocation)">{{ plans.capital_assets_project_has_credit_source[0].cpCode }}</td>
                                                    <td :rowspan="getProjectAllocCount(plans.capital_assets_project_has_credit_source[0].credit_source_has_allocation)" class="text-center">{{ $parent.calcDispAmount(getProjectAllocationSum(plans.capital_assets_project_has_credit_source[0].credit_source_has_allocation) , false) }}</td>
                                                    <td :rowspan="plans.capital_assets_project_has_credit_source[0].credit_source_has_allocation[0].allocation.length">{{ plans.capital_assets_project_has_credit_source[0].credit_source_has_allocation[0].credit_distribution_row.cdSubject }}</td>
                                                    <td>{{ plans.capital_assets_project_has_credit_source[0].credit_source_has_allocation[0].allocation[0].caaLetterNumber }}</td>
                                                    <td>{{ plans.capital_assets_project_has_credit_source[0].credit_source_has_allocation[0].allocation[0].caaLetterDate }}</td>
                                                    <td>{{ $parent.calcDispAmount(plans.capital_assets_project_has_credit_source[0].credit_source_has_allocation[0].allocation[0].caaAmount , false) }}</td>
                                                </tr>
                                               <template v-for="(projects, proIndex) in plans.capital_assets_project_has_credit_source">
                                                   <tr class="tbl-head-style-cell" v-if="proIndex > 0">
                                                       <td :rowspan="getProjectAllocCount(projects.credit_source_has_allocation)">{{ projects.cpCode }}</td>
                                                       <td :rowspan="getProjectAllocCount(projects.credit_source_has_allocation)">{{ $parent.calcDispAmount(getProjectAllocationSum(projects.credit_source_has_allocation) , false) }}</td>
                                                       <td :rowspan="projects.credit_source_has_allocation[0].allocation.length">{{ projects.credit_source_has_allocation[0].credit_distribution_row.cdSubject }}</td>
                                                       <td>{{ projects.credit_source_has_allocation[0].allocation[0].caaLetterNumber }}</td>
                                                       <td>{{ projects.capital_assets_project_has_credit_source[0].credit_source_has_allocation[0].allocation[0].caaLetterDate }}</td>
                                                       <td>{{ $parent.calcDispAmount(projects.capital_assets_project_has_credit_source[0].credit_source_has_allocation[0].allocation[0].caaAmount , false) }}</td>
                                                   </tr>
                                                    <template v-for="(credit_source , csIndex) in projects.credit_source_has_allocation">
                                                        <tr class="tbl-head-style-cell" v-if="csIndex > 0">
                                                            <td :rowspan="credit_source.allocation.length">{{ credit_source.credit_distribution_row.cdSubject }}</td>
                                                            <td>{{ credit_source.allocation[0].caaLetterNumber }}</td>
                                                            <td>{{ credit_source.allocation[0].caaLetterDate }}</td>
                                                            <td>{{ $parent.calcDispAmount(credit_source.allocation[0].caaAmount , false) }}</td>
                                                        </tr>
                                                        <template v-for="(alloc , allocIndex) in credit_source.allocation">
                                                            <tr class="tbl-head-style-cell" v-if="allocIndex > 0">
                                                                <td>{{ alloc.caaLetterNumber }}</td>
                                                                <td>{{ alloc.caaLetterDate }}</td>
                                                                <td>{{ $parent.calcDispAmount(alloc.caaAmount , false) }}</td>
                                                            </tr>
                                                        </template>
                                                    </template>
                                               </template>
                                            </template>
                                        </tbody>
                                    </table>
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
                            <!--Table Start-->
                        </div>
                    </div>
                    <!--Tab 1-->
                    <!--Tab 2-->
                    <div class="tabs-panel table-mrg-btm" id="row" xmlns:v-on="http://www.w3.org/1999/xhtml">
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
                            <div class="tbl-div-container">
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
                                        <th class="tbl-head-style-cell">سرجمع</th>
                                        <th class="tbl-head-style-cell">ردیف اعتبار</th>
                                        <th class="tbl-head-style-cell">شماره</th>
                                        <th class="tbl-head-style-cell">تاریخ</th>
                                        <th class="tbl-head-style-cell">مبلغ</th>
                                        <th class="tbl-head-style-cell"></th>
                                    </tr>
                                    </tbody>
                                </table>

                                <div class="tbl_body_style dynamic-height-level2">
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
                                        <template v-for="plans in natCapitalAssetsAllocations">
                                            <tr class="tbl-head-style-cell" >
                                                <td :rowspan="getPlanAllocCount(plans.capital_assets_project_has_credit_source)">{{ plans.credit_distribution_title.cdtIdNumber + ' - ' + plans.credit_distribution_title.cdtSubject }}</td>
                                                <td :rowspan="getProjectAllocCount(plans.capital_assets_project_has_credit_source[0].credit_source_has_allocation)">{{ plans.capital_assets_project_has_credit_source[0].cpCode }}</td>
                                                <td :rowspan="getProjectAllocCount(plans.capital_assets_project_has_credit_source[0].credit_source_has_allocation)" class="text-center">{{ $parent.calcDispAmount(getProjectAllocationSum(plans.capital_assets_project_has_credit_source[0].credit_source_has_allocation) , false) }}</td>
                                                <td :rowspan="plans.capital_assets_project_has_credit_source[0].credit_source_has_allocation[0].allocation.length">{{ plans.capital_assets_project_has_credit_source[0].credit_source_has_allocation[0].credit_distribution_row.cdSubject }}</td>
                                                <td>{{ plans.capital_assets_project_has_credit_source[0].credit_source_has_allocation[0].allocation[0].caaLetterNumber }}</td>
                                                <td>{{ plans.capital_assets_project_has_credit_source[0].credit_source_has_allocation[0].allocation[0].caaLetterDate }}</td>
                                                <td>{{ $parent.calcDispAmount(plans.capital_assets_project_has_credit_source[0].credit_source_has_allocation[0].allocation[0].caaAmount , false) }}</td>
                                            </tr>
                                            <template v-for="(projects, proIndex) in plans.capital_assets_project_has_credit_source">
                                                <tr class="tbl-head-style-cell" v-if="proIndex > 0">
                                                    <td :rowspan="getProjectAllocCount(projects.credit_source_has_allocation)">{{ projects.cpCode }}</td>
                                                    <td :rowspan="getProjectAllocCount(projects.credit_source_has_allocation)">{{ $parent.calcDispAmount(getProjectAllocationSum(projects.credit_source_has_allocation) , false) }}</td>
                                                    <td :rowspan="projects.credit_source_has_allocation[0].allocation.length">{{ projects.credit_source_has_allocation[0].credit_distribution_row.cdSubject }}</td>
                                                    <td>{{ projects.credit_source_has_allocation[0].allocation[0].caaLetterNumber }}</td>
                                                    <td>{{ projects.capital_assets_project_has_credit_source[0].credit_source_has_allocation[0].allocation[0].caaLetterDate }}</td>
                                                    <td>{{ $parent.calcDispAmount(projects.capital_assets_project_has_credit_source[0].credit_source_has_allocation[0].allocation[0].caaAmount , false) }}</td>
                                                </tr>
                                                <template v-for="(credit_source , csIndex) in projects.credit_source_has_allocation">
                                                    <tr class="tbl-head-style-cell" v-if="csIndex > 0">
                                                        <td :rowspan="credit_source.allocation.length">{{ credit_source.credit_distribution_row.cdSubject }}</td>
                                                        <td>{{ credit_source.allocation[0].caaLetterNumber }}</td>
                                                        <td>{{ credit_source.allocation[0].caaLetterDate }}</td>
                                                        <td>{{ $parent.calcDispAmount(credit_source.allocation[0].caaAmount , false) }}</td>
                                                    </tr>
                                                    <template v-for="(alloc , allocIndex) in credit_source.allocation">
                                                        <tr class="tbl-head-style-cell" v-if="allocIndex > 0">
                                                            <td>{{ alloc.caaLetterNumber }}</td>
                                                            <td>{{ alloc.caaLetterDate }}</td>
                                                            <td>{{ $parent.calcDispAmount(alloc.caaAmount , false) }}</td>
                                                        </tr>
                                                    </template>
                                                </template>
                                            </template>
                                        </template>
                                        </tbody>
                                    </table>
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
                    <!--Tab 2-->
                    <!--Tab 3-->
                    <div class="tabs-panel table-mrg-btm" id="budget" xmlns:v-on="http://www.w3.org/1999/xhtml">
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
                            <div class="tbl-div-container">
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
                                        <th class="tbl-head-style-cell">سرجمع</th>
                                        <th class="tbl-head-style-cell">ردیف اعتبار</th>
                                        <th class="tbl-head-style-cell">شماره</th>
                                        <th class="tbl-head-style-cell">تاریخ</th>
                                        <th class="tbl-head-style-cell">مبلغ</th>
                                        <th class="tbl-head-style-cell"></th>
                                    </tr>
                                    </tbody>
                                </table>

                                <div class="tbl_body_style dynamic-height-level2">
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
                                        <template v-for="plans in natCapitalAssetsAllocations">
                                            <tr class="tbl-head-style-cell" >
                                                <td :rowspan="getPlanAllocCount(plans.capital_assets_project_has_credit_source)">{{ plans.credit_distribution_title.cdtIdNumber + ' - ' + plans.credit_distribution_title.cdtSubject }}</td>
                                                <td :rowspan="getProjectAllocCount(plans.capital_assets_project_has_credit_source[0].credit_source_has_allocation)">{{ plans.capital_assets_project_has_credit_source[0].cpCode }}</td>
                                                <td :rowspan="getProjectAllocCount(plans.capital_assets_project_has_credit_source[0].credit_source_has_allocation)" class="text-center">{{ $parent.calcDispAmount(getProjectAllocationSum(plans.capital_assets_project_has_credit_source[0].credit_source_has_allocation) , false) }}</td>
                                                <td :rowspan="plans.capital_assets_project_has_credit_source[0].credit_source_has_allocation[0].allocation.length">{{ plans.capital_assets_project_has_credit_source[0].credit_source_has_allocation[0].credit_distribution_row.cdSubject }}</td>
                                                <td>{{ plans.capital_assets_project_has_credit_source[0].credit_source_has_allocation[0].allocation[0].caaLetterNumber }}</td>
                                                <td>{{ plans.capital_assets_project_has_credit_source[0].credit_source_has_allocation[0].allocation[0].caaLetterDate }}</td>
                                                <td>{{ $parent.calcDispAmount(plans.capital_assets_project_has_credit_source[0].credit_source_has_allocation[0].allocation[0].caaAmount , false) }}</td>
                                            </tr>
                                            <template v-for="(projects, proIndex) in plans.capital_assets_project_has_credit_source">
                                                <tr class="tbl-head-style-cell" v-if="proIndex > 0">
                                                    <td :rowspan="getProjectAllocCount(projects.credit_source_has_allocation)">{{ projects.cpCode }}</td>
                                                    <td :rowspan="getProjectAllocCount(projects.credit_source_has_allocation)">{{ $parent.calcDispAmount(getProjectAllocationSum(projects.credit_source_has_allocation) , false) }}</td>
                                                    <td :rowspan="projects.credit_source_has_allocation[0].allocation.length">{{ projects.credit_source_has_allocation[0].credit_distribution_row.cdSubject }}</td>
                                                    <td>{{ projects.credit_source_has_allocation[0].allocation[0].caaLetterNumber }}</td>
                                                    <td>{{ projects.capital_assets_project_has_credit_source[0].credit_source_has_allocation[0].allocation[0].caaLetterDate }}</td>
                                                    <td>{{ $parent.calcDispAmount(projects.capital_assets_project_has_credit_source[0].credit_source_has_allocation[0].allocation[0].caaAmount , false) }}</td>
                                                </tr>
                                                <template v-for="(credit_source , csIndex) in projects.credit_source_has_allocation">
                                                    <tr class="tbl-head-style-cell" v-if="csIndex > 0">
                                                        <td :rowspan="credit_source.allocation.length">{{ credit_source.credit_distribution_row.cdSubject }}</td>
                                                        <td>{{ credit_source.allocation[0].caaLetterNumber }}</td>
                                                        <td>{{ credit_source.allocation[0].caaLetterDate }}</td>
                                                        <td>{{ $parent.calcDispAmount(credit_source.allocation[0].caaAmount , false) }}</td>
                                                    </tr>
                                                    <template v-for="(alloc , allocIndex) in credit_source.allocation">
                                                        <tr class="tbl-head-style-cell" v-if="allocIndex > 0">
                                                            <td>{{ alloc.caaLetterNumber }}</td>
                                                            <td>{{ alloc.caaLetterDate }}</td>
                                                            <td>{{ $parent.calcDispAmount(alloc.caaAmount , false) }}</td>
                                                        </tr>
                                                    </template>
                                                </template>
                                            </template>
                                        </template>
                                        </tbody>
                                    </table>
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
                    <!--Tab 3-->
                    <!--Tab 4-->
                    <div class="tabs-panel table-mrg-btm" id="province" xmlns:v-on="http://www.w3.org/1999/xhtml">
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
                            <div class="tbl-div-container">
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
                                        <th class="tbl-head-style-cell">سرجمع</th>
                                        <th class="tbl-head-style-cell">ردیف اعتبار</th>
                                        <th class="tbl-head-style-cell">شماره</th>
                                        <th class="tbl-head-style-cell">تاریخ</th>
                                        <th class="tbl-head-style-cell">مبلغ</th>
                                        <th class="tbl-head-style-cell"></th>
                                    </tr>
                                    </tbody>
                                </table>

                                <div class="tbl_body_style dynamic-height-level2">
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
                                        <template v-for="plans in natCapitalAssetsAllocations">
                                            <tr class="tbl-head-style-cell" >
                                                <td :rowspan="getPlanAllocCount(plans.capital_assets_project_has_credit_source)">{{ plans.credit_distribution_title.cdtIdNumber + ' - ' + plans.credit_distribution_title.cdtSubject }}</td>
                                                <td :rowspan="getProjectAllocCount(plans.capital_assets_project_has_credit_source[0].credit_source_has_allocation)">{{ plans.capital_assets_project_has_credit_source[0].cpCode }}</td>
                                                <td :rowspan="getProjectAllocCount(plans.capital_assets_project_has_credit_source[0].credit_source_has_allocation)" class="text-center">{{ $parent.calcDispAmount(getProjectAllocationSum(plans.capital_assets_project_has_credit_source[0].credit_source_has_allocation) , false) }}</td>
                                                <td :rowspan="plans.capital_assets_project_has_credit_source[0].credit_source_has_allocation[0].allocation.length">{{ plans.capital_assets_project_has_credit_source[0].credit_source_has_allocation[0].credit_distribution_row.cdSubject }}</td>
                                                <td>{{ plans.capital_assets_project_has_credit_source[0].credit_source_has_allocation[0].allocation[0].caaLetterNumber }}</td>
                                                <td>{{ plans.capital_assets_project_has_credit_source[0].credit_source_has_allocation[0].allocation[0].caaLetterDate }}</td>
                                                <td>{{ $parent.calcDispAmount(plans.capital_assets_project_has_credit_source[0].credit_source_has_allocation[0].allocation[0].caaAmount , false) }}</td>
                                            </tr>
                                            <template v-for="(projects, proIndex) in plans.capital_assets_project_has_credit_source">
                                                <tr class="tbl-head-style-cell" v-if="proIndex > 0">
                                                    <td :rowspan="getProjectAllocCount(projects.credit_source_has_allocation)">{{ projects.cpCode }}</td>
                                                    <td :rowspan="getProjectAllocCount(projects.credit_source_has_allocation)">{{ $parent.calcDispAmount(getProjectAllocationSum(projects.credit_source_has_allocation) , false) }}</td>
                                                    <td :rowspan="projects.credit_source_has_allocation[0].allocation.length">{{ projects.credit_source_has_allocation[0].credit_distribution_row.cdSubject }}</td>
                                                    <td>{{ projects.credit_source_has_allocation[0].allocation[0].caaLetterNumber }}</td>
                                                    <td>{{ projects.capital_assets_project_has_credit_source[0].credit_source_has_allocation[0].allocation[0].caaLetterDate }}</td>
                                                    <td>{{ $parent.calcDispAmount(projects.capital_assets_project_has_credit_source[0].credit_source_has_allocation[0].allocation[0].caaAmount , false) }}</td>
                                                </tr>
                                                <template v-for="(credit_source , csIndex) in projects.credit_source_has_allocation">
                                                    <tr class="tbl-head-style-cell" v-if="csIndex > 0">
                                                        <td :rowspan="credit_source.allocation.length">{{ credit_source.credit_distribution_row.cdSubject }}</td>
                                                        <td>{{ credit_source.allocation[0].caaLetterNumber }}</td>
                                                        <td>{{ credit_source.allocation[0].caaLetterDate }}</td>
                                                        <td>{{ $parent.calcDispAmount(credit_source.allocation[0].caaAmount , false) }}</td>
                                                    </tr>
                                                    <template v-for="(alloc , allocIndex) in credit_source.allocation">
                                                        <tr class="tbl-head-style-cell" v-if="allocIndex > 0">
                                                            <td>{{ alloc.caaLetterNumber }}</td>
                                                            <td>{{ alloc.caaLetterDate }}</td>
                                                            <td>{{ $parent.calcDispAmount(alloc.caaAmount , false) }}</td>
                                                        </tr>
                                                    </template>
                                                </template>
                                            </template>
                                        </template>
                                        </tbody>
                                    </table>
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
                    <!--Tab 4-->
                </div>
                <!--Forms Start-->
                <!--Insert Modal Start-->
                <modal-small v-if="showModal" @close="showModal = false" xmlns:v-on="http://www.w3.org/1999/xhtml">
                    <div  slot="body">
                        <form v-on:submit.prevent="createCreditDistributionPlan">
                            <div class="grid-x" v-if="errorMessage">
                                <div class="medium-12 columns padding-lr">
                                    <div class="alert callout">
                                        <p class="BYekan login-alert"><i class="fi-alert"></i>{{ errorMessage }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="grid-x">
                                <div class="medium-8 cell padding-lr">
                                    <label>عنوان طرح
                                        <select class="form-element-margin-btm"  v-model="CdPlanInput.cdtId" name="plan" v-validate data-vv-rules="required" :class="{'input': true, 'select-error': errors.has('plan')}">
                                            <option value=""></option>
                                            <option v-for="creditDistributionTitle in creditDistributionTitles" :value="creditDistributionTitle.id">{{ creditDistributionTitle.cdtIdNumber + ' - ' + creditDistributionTitle.cdtSubject + (creditDistributionTitle.county == null ? '' : ' - ' + creditDistributionTitle.county.coName)}}</option>
                                        </select>
                                        <span v-show="errors.has('plan')" class="error-font">لطفا طرح را انتخاب کنید!</span>
                                    </label>
                                    <span class="form-error error-font" data-form-error-for="cdpTitle">طرح توزیع اعتبار را انتخاب کنید!</span>
                                </div>
                                <div class="medium-4 cell padding-lr">
                                    <label>ردیف توزیع اعتبار
                                        <select  class="form-element-margin-btm"  name="row" v-model="CdPlanInput.cdrId" v-validate data-vv-rules="required" :class="{'input': true, 'select-error': errors.has('row')}">
                                            <option value=""></option>
                                            <option v-for="creditDistributionRow in creditDistributionRows" :value="creditDistributionRow.id">{{ creditDistributionRow.cdSubject }}</option>
                                        </select>
                                        <span v-show="errors.has('row')" class="error-font">لطفا ردیف توزیع را انتخاب کنید!</span>
                                    </label>
                                </div>
                            </div>
                            <div class="grid-x" style="margin-top: 1rem">
                                <div class="medium-12 columns">
                                    <div class="grid-x">
                                        <span class="padding-lr">مبالغ</span><span style="color: #D9534F;">{{ '(' + $parent.getAmountBaseLabel() + ')' }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="grid-x">
                                <div class="medium-12 columns">
                                    <div class="grid-x">
                                        <div v-for="county in counties" class="medium-3 padding-lr">
                                            <label>{{ county.coName }}
                                                <input class="form-element-margin-btm" type="text"  v-model="CdPlanInput['county' + county.id]" :name="'county' + county.id" v-validate data-vv-rules="required|decimal" :class="{'input': true, 'select-error': errors.has('county' + county.id)}"/>
                                            </label>
                                            <span v-show="errors.has('county' + county.id)" class="error-font">مبلغ فراموش شده است!</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="grid-x">
                                <div class="small-12 columns padding-lr">
                                    <label>شرح
                                        <textarea name="csDescription" style="min-height: 150px;" v-model="CdPlanInput.description"></textarea>
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
                CdPlanInput: {},
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
                creditDistributionTitles: {},
                creditDistributionRows: {},
                counties: {},
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
            this.fetchNationalData();
            this.getAllApprovedPlan(0); // 0 = provincial
        },

        updated: function () {
            $(this.$el).foundation(); //WORKS!
        },

        mounted: function () {
            console.log("mounted credit distribution plans component");
            this.$parent.myResize();
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
                axios.get('/budget/allocation/capital_assets/fetchData?page=' + page , {params:{pOrN: 1}})
                    .then((response) => {
                        this.natCapitalAssetsAllocations = response.data.data;
                        this.makePagination(response.data , "national");
                        console.log(response);
                    },(error) => {
                        console.log(error);
                    });
            },

            getCreditDistributionTitle: function () {
                axios.get('/budget/admin/credit_distribution_def/plan_cost_title/getAllItem' , {params:{pOrN: 1}})
                    .then((response) => {
                        this.creditDistributionTitles = response.data;
                        console.log(response);
                    },(error) => {
                        console.log(error);
                    });
            },

            getCreditDistributionRow: function () {
                axios.get('/budget/admin/credit_distribution_def/rows/getAllItems' , {params:{planOrCost: 0}})
                    .then((response) => {
                        this.creditDistributionRows = response.data;
                        console.log(response);
                    },(error) => {
                        console.log(error);
                    });
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

            getProjectAllocationSum: function (creditSource) {
                var sum = 0;
                creditSource.forEach(cs => {
                    cs.allocation.forEach(alloc => {
                        sum += alloc.caaAmount;
                    });
                });

                return sum;
            },

            getPlanAllocCount: function (projects) {
                  var count = 0;
                    projects.forEach(cap => {
                          cap.credit_source_has_allocation.forEach(cs => {
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
                this.getCreditDistributionTitle();
                this.getCreditDistributionRow();
                this.getCounties();
                this.showModal = true;
            },

            createCreditDistributionPlan: function () {
                this.$validator.validateAll().then((result) => {
                    if (result) {
                        var jsonString = '{';
                        jsonString += '"cdtId":"' + this.CdPlanInput.cdtId + '",';
                        jsonString += '"cdrId":"' + this.CdPlanInput.cdrId + '",';
                        jsonString += '"description":"' + this.CdPlanInput.description + '",';
                        this.counties.forEach(county => {
                            if (this.CdPlanInput['county' + county.id])
                                jsonString += '"county' + county.id + '":"' + this.CdPlanInput['county' + county.id] + '",';
                        });
                        jsonString += '"":""}';
                        axios.post('/budget/credit_distribution/capital_assets/provincial/plans/register' , JSON.parse(jsonString))
                            .then((response) => {
                                this.provCapitalAssetsAllocations = response.data.data;
                                this.makePagination(response.data , "provincial");
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

