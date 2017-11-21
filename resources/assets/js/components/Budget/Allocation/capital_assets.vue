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
                    <li class="tabs-title"><a href="#provincialFound">تنخواه - استانی</a></li>
                </ul>
                <div class="tabs-content" data-tabs-content="Register_of_credit_allocation_assets_tab_view">
                    <!--Tab 1-->
                    <div class="tabs-panel is-active table-mrg-btm" id="national" xmlns:v-on="http://www.w3.org/1999/xhtml">
                        <div class="medium-12 bottom-mrg">
                            <div class="clearfix border-btm-line bottom-mrg tool-bar">
                                <div style="margin-top: 2px;" class="button-group float-right report-mrg">
                                    <a class="my-button toolbox-btn small" @click="openInsertModal(0)">جدید</a>
                                    <div v-if="!selectColumn" class="input-group-button toggle-icon-change">
                                        <button type="button" class="my-button my-icon-brand tiny" @click="showSelectColumn(provCapitalAssetsAllocations)"><i class="fa fa-check-square-o size-14" aria-hidden="true"></i></button>
                                    </div>
                                    <div v-if="selectColumn" class="input-group-button toggle-icon-change">
                                        <button type="button" class="my-button my-icon-danger tiny" @click="showSelectColumn(provCapitalAssetsAllocations)"><i class="fa fa-times size-14" aria-hidden="true"></i></button>
                                    </div>
                                    <button class="my-button toolbox-btn small dropdown small sm-btn-align"  type="button" data-toggle="reportDropDownProv">گزارش</button>
                                    <div  style="width: 113px;" class="dropdown-pane dropdown-pane-sm " data-close-on-click="true"  data-hover="true" data-hover-pane="true"  data-position="bottom" data-alignment="left" id="reportDropDownProv" data-dropdown data-auto-focus="true">
                                        <ul class="my-menu small-font ltr-dir">
                                            <li><a  @click="openReportModal(0,'pdf')"><i class="fa fa-file-pdf-o icon-margin-dropdown" aria-hidden="true"></i>PDF</a></li>
                                            <li><a  @click="openReportModal(0,'excel')"><i class="fa fa-file-excel-o icon-margin-dropdown" aria-hidden="true"></i>Excel</a></li>
                                        </ul>
                                    </div>
                                    <button class="my-button toolbox-btn small dropdown small sm-btn-align"  type="button" data-toggle="assetsDropDownProv">تعداد نمایش<span> 20 </span></button>
                                    <div  style="width: 113px;" class="dropdown-pane dropdown-pane-sm " data-close-on-click="true"  data-hover="true" data-hover-pane="true"  data-position="bottom" data-alignment="left" id="assetsDropDownProv" data-dropdown data-auto-focus="true">
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
                                        <div class="inner-addon right-addon">
                                            <i v-if="searchProvValue == ''" class="fa fa-search purple-color"  aria-hidden="true"></i>
                                            <i v-if="searchProvValue != ''" class="fa fa-close btn-red"  aria-hidden="true"></i>
                                            <input v-model="searchProvValue" class="search" type="text" placeholder="جستوجو">
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
                                        <col v-show="selectColumn" width="15px"/>
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
                                        <th class="tbl-head-style-checkbox" v-show="selectColumn"><input type="checkbox" @click="toggleSelect(provCapitalAssetsAllocations)" :checked="allSelected(provCapitalAssetsAllocations)"></th>
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
                                            <col v-show="selectColumn" width="15px"/>
                                        </colgroup>
                                        <tbody class="tbl-head-style-cell">
                                            <template v-for="plans in provCapitalAssetsAllocations">
                                                <tr class="tbl-head-style-cell">
                                                    <td :rowspan="getPlanAllocCount(plans.capital_assets_project_has_credit_source)">{{ plans.credit_distribution_title.cdtIdNumber + ' - ' + plans.credit_distribution_title.cdtSubject }}
                                                        <div v-show="!plans.capActive" class="text-center" style="margin-top: 5px">
                                                            <span class="new-badage">غیر فعال</span>
                                                        </div>
                                                    </td>
                                                    <td :rowspan="getProjectAllocCount(plans.capital_assets_project_has_credit_source[0].credit_source_has_allocation)">{{ plans.capital_assets_project_has_credit_source[0].cpCode + ' - ' +plans.capital_assets_project_has_credit_source[0].cpSubject }}</td>
                                                    <td v-if="plans.capital_assets_project_has_credit_source[0].credit_source_has_allocation[0].ccsDeleted" :rowspan="getProjectAllocCount(plans.capital_assets_project_has_credit_source[0].credit_source_has_allocation)" class="text-center"><span class="comlpleted-badage">حذف شده</span></td>
                                                    <td v-if="!plans.capital_assets_project_has_credit_source[0].credit_source_has_allocation[0].ccsDeleted" :rowspan="getProjectAllocCount(plans.capital_assets_project_has_credit_source[0].credit_source_has_allocation)" class="text-center">{{ $parent.calcDispAmount(getProjectAllocationSum(plans.capital_assets_project_has_credit_source[0].credit_source_has_allocation) , false) }}</td>
                                                    <td :rowspan="plans.capital_assets_project_has_credit_source[0].credit_source_has_allocation[0].allocation.length">{{ plans.capital_assets_project_has_credit_source[0].credit_source_has_allocation[0].credit_distribution_row.cdSubject }}</td>
                                                    <td v-if="plans.capital_assets_project_has_credit_source[0].credit_source_has_allocation[0].allocation[0].caaFoundId == null">{{ plans.capital_assets_project_has_credit_source[0].credit_source_has_allocation[0].allocation[0].caaLetterNumber }}</td>
                                                    <td class="text-center" v-if="plans.capital_assets_project_has_credit_source[0].credit_source_has_allocation[0].allocation[0].caaFoundId != null"><i class="fa fa-exchange btn-red has-tip top" data-tooltip aria-haspopup="true" data-disable-hover="false" title="تبدیل شده از تنخواه"></i></td>
                                                    <td class="text-center">{{ plans.capital_assets_project_has_credit_source[0].credit_source_has_allocation[0].allocation[0].caaLetterDate }}</td>
                                                    <td class="text-center">{{ $parent.calcDispAmount(plans.capital_assets_project_has_credit_source[0].credit_source_has_allocation[0].allocation[0].caaAmount , false) }}</td>
                                                    <td  v-show="selectColumn">
                                                        <input class="auto-margin" v-model="plans.capital_assets_project_has_credit_source[0].credit_source_has_allocation[0].allocation[0].checked" type="checkbox">
                                                    </td>
                                                </tr>
                                               <template v-for="(projects, proIndex) in plans.capital_assets_project_has_credit_source">
                                                   <tr class="tbl-head-style-cell" v-if="proIndex > 0">
                                                       <td :rowspan="getProjectAllocCount(projects.credit_source_has_allocation)">{{ projects.cpCode + ' - ' + projects.cpSubject }}</td>
                                                       <td v-if="!projects.credit_source_has_allocation[0].ccsDeleted" :rowspan="getProjectAllocCount(projects.credit_source_has_allocation)" class="text-center">{{ $parent.calcDispAmount(getProjectAllocationSum(projects.credit_source_has_allocation) , false) }}</td>
                                                       <td v-if="projects.credit_source_has_allocation[0].ccsDeleted" :rowspan="getProjectAllocCount(projects.credit_source_has_allocation)" class="text-center">
                                                           <span class="comlpleted-badage">حذف شده</span>
                                                       </td>
                                                       <td :rowspan="projects.credit_source_has_allocation[0].allocation.length">{{ projects.credit_source_has_allocation[0].credit_distribution_row.cdSubject }}</td>
                                                       <td v-if="projects.credit_source_has_allocation[0].allocation[0].caaFoundId == null">{{ projects.credit_source_has_allocation[0].allocation[0].caaLetterNumber }}</td>
                                                       <td class="text-center" v-if="projects.credit_source_has_allocation[0].allocation[0].caaFoundId != null"><i class="fa fa-exchange btn-red has-tip top" data-tooltip aria-haspopup="true" data-disable-hover="false" title="تبدیل شده از تنخواه"></i></td>
                                                       <td class="text-center">{{ projects.credit_source_has_allocation[0].allocation[0].caaLetterDate }}</td>
                                                       <td class="text-center">{{ $parent.calcDispAmount(projects.credit_source_has_allocation[0].allocation[0].caaAmount , false) }}</td>
                                                       <td  v-show="selectColumn">
                                                           <input class="auto-margin" v-model="projects.credit_source_has_allocation[0].allocation[0].checked" type="checkbox">
                                                       </td>
                                                   </tr>
                                                    <template v-for="(credit_source , csIndex) in projects.credit_source_has_allocation">
                                                        <tr class="tbl-head-style-cell" v-if="csIndex > 0">
                                                            <td :rowspan="credit_source.allocation.length">{{ credit_source.credit_distribution_row.cdSubject }}</td>
                                                            <td v-if="credit_source.allocation[0].caaFoundId == null">{{ credit_source.allocation[0].caaLetterNumber }}</td>
                                                            <td class="text-center" v-if="credit_source.allocation[0].caaFoundId != null"><i class="fa fa-exchange btn-red has-tip top" data-tooltip aria-haspopup="true" data-disable-hover="false" title="تبدیل شده از تنخواه"></i></td>
                                                            <td class="text-center">{{ credit_source.allocation[0].caaLetterDate }}</td>
                                                            <td class="text-center">{{ $parent.calcDispAmount(credit_source.allocation[0].caaAmount , false) }}</td>
                                                            <td  v-show="selectColumn">
                                                                <input class="auto-margin" v-model="credit_source.allocation[0].checked" type="checkbox">
                                                            </td>
                                                        </tr>
                                                        <template v-for="(alloc , allocIndex) in credit_source.allocation">
                                                            <tr class="tbl-head-style-cell" v-if="allocIndex > 0">
                                                                <td v-if="alloc.caaFoundId == null">{{ alloc.caaLetterNumber }}</td>
                                                                <td class="text-center" v-if="alloc.caaFoundId != null"><i class="fa fa-exchange btn-red has-tip top" data-tooltip aria-haspopup="true" data-disable-hover="false" title="تبدیل شده از تنخواه"></i></td>
                                                                <td class="text-center">{{ alloc.caaLetterDate }}</td>
                                                                <td class="text-center">{{ $parent.calcDispAmount(alloc.caaAmount , false) }}</td>
                                                                <td  v-show="selectColumn">
                                                                    <input class="auto-margin" v-model="alloc.checked" type="checkbox">
                                                                </td>
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
                                <div class="medium-8">
                                    <vue-pagination  v-bind:pagination="provincial_pagination"
                                                     v-on:click.native="fetchProvincialData(provincial_pagination.current_page)"
                                                     :offset="4">
                                    </vue-pagination>
                                </div>
                                <div style="color: #575962;" v-show="selectColumn" class="medium-4 small-font">
                                    <div class="float-left">
                                        <p> تعداد رکورد های انتخاب شده :<span class="selected-row-style">{{ selectedLength(provCapitalAssetsAllocations) }}</span></p>
                                    </div>
                                </div>
                            </div>
                            <!--Table Start-->

                            <!--Table Start-->
                            <!--<div class="columns">

                                <div class="table-contain  dynamic-height-level2">
                                    <div class="grid-x" v-for="plans in provCapitalAssetsAllocations">
                                        <div class="medium-2 table-contain-border1 cell-vertical-center">
                                            {{ plans.credit_distribution_title.cdtIdNumber + ' - ' + plans.credit_distribution_title.cdtSubject + ' بلاتبلا تبلا تبلات بلات بلات بلات بلات بلات بلات بلات بلاتب لات بلات بلات بلا' }}
                                        </div>
                                        <div class="medium-10">
                                            <div class="grid-x" v-for="projects in plans.capital_assets_project">
                                                <div class="medium-2 table-contain-border cell-vertical-center">
                                                    {{ projects.cpCode + ' - ' + projects.cpSubject }}
                                                </div>
                                                <div class="medium-1 table-contain-border cell-vertical-center">
                                                    {{ $parent.calcDispAmount(getProjectAllocationSum(projects.credit_source) , false) }}
                                                </div>
                                                <div class="medium-9">
                                                    <div v-for="credit_source in projects.credit_source" class="grid-x">
                                                        <div class="medium-2 table-contain-border cell-vertical-center">
                                                            {{ credit_source.credit_distribution_row.cdSubject }}
                                                        </div>
                                                        <div class="medium-1 table-contain-border cell-vertical-center">
                                                            {{ credit_source.how_to_run.htrSubject }}
                                                        </div>
                                                        <div class="medium-1 table-contain-border cell-vertical-center">
                                                            {{ credit_source.tiny_season.season_title.season.sSubject }}
                                                        </div>
                                                        <div class="medium-2 table-contain-border cell-vertical-center">
                                                            {{ credit_source.tiny_season.season_title.castSubject }}
                                                        </div>
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
                                                            {{ credit_source.tiny_season.catsSubject }}
                                                        </div>
                                                        <div class="medium-3">
                                                            <div  class="grid-x" v-for="alloc in credit_source.allocation">
                                                                <div class="medium-12  table-contain-border">
                                                                    <div class="grid-x">
                                                                        <div class="medium-10">
                                                                            {{ $parent.calcDispAmount(alloc.caaAmount , false) }}
                                                                        </div>
                                                                        <div class="medium-2 cell-vertical-center text-left">
                                                                            <a class="dropdown small sm-btn-align"  type="button" :data-toggle="'rocaaRegisterOfCreditAllocationAssets' + alloc.id"><i class="fa fa-ellipsis-v size-18"></i></a>
                                                                            <div class="dropdown-pane dropdown-pane-sm " data-close-on-click="true"  data-hover="true" data-hover-pane="true"  data-position="bottom" data-alignment="right" :id="'rocaaRegisterOfCreditAllocationAssets' + alloc.id" data-dropdown data-auto-focus="true">
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
                                    <div v-if="!selectColumn" class="input-group-button toggle-icon-change">
                                        <button type="button" class="my-button my-icon-brand tiny" @click="showSelectColumn"><i class="fa fa-check-square-o size-14" aria-hidden="true"></i></button>
                                    </div>
                                    <div v-if="selectColumn" class="input-group-button toggle-icon-change">
                                        <button type="button" class="my-button my-icon-danger tiny" @click="showSelectColumn"><i class="fa fa-times size-14" aria-hidden="true"></i></button>
                                    </div>
                                    <button class="my-button toolbox-btn small dropdown small sm-btn-align"  type="button" data-toggle="reportDropDownNat">گزارش</button>
                                    <div  style="width: 113px;" class="dropdown-pane dropdown-pane-sm " data-close-on-click="true"  data-hover="true" data-hover-pane="true"  data-position="bottom" data-alignment="left" id="reportDropDownNat" data-dropdown data-auto-focus="true">
                                        <ul class="my-menu small-font ltr-dir">
                                            <li><a  href="#"><i class="fa fa-file-pdf-o icon-margin-dropdown" aria-hidden="true"></i>PDF</a></li>
                                            <li><a  href="#"><i class="fa fa-file-excel-o icon-margin-dropdown" aria-hidden="true"></i>Excel</a></li>
                                        </ul>
                                    </div>
                                    <button class="my-button toolbox-btn small dropdown small sm-btn-align"  type="button" data-toggle="assetsDropDownNat">تعداد نمایش<span> 20 </span></button>
                                    <div  style="width: 113px;" class="dropdown-pane dropdown-pane-sm " data-close-on-click="true"  data-hover="true" data-hover-pane="true"  data-position="bottom" data-alignment="left" id="assetsDropDownNat" data-dropdown data-auto-focus="true">
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
                                        <div class="inner-addon right-addon">
                                            <i v-if="searchNatValue == ''" class="fa fa-search purple-color"  aria-hidden="true"></i>
                                            <i v-if="searchNatValue != ''" class="fa fa-close btn-red"  aria-hidden="true"></i>
                                            <input v-model="searchNatValue" class="search" type="text" placeholder="جستوجو">
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
                                        <col v-show="selectColumn" width="15px"/>
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
                                        <th class="tbl-head-style-checkbox" v-show="selectColumn"><input type="checkbox"></th>
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
                                            <col v-show="selectColumn" width="15px"/>
                                        </colgroup>
                                        <tbody class="tbl-head-style-cell">
                                        <template v-for="plans in natCapitalAssetsAllocations">
                                            <tr class="tbl-head-style-cell" >
                                                <td :rowspan="getPlanAllocCount(plans.capital_assets_project_has_credit_source)">{{ plans.credit_distribution_title.cdtIdNumber + ' - ' + plans.credit_distribution_title.cdtSubject }}
                                                    <div v-show="!plans.capActive" class="text-center" style="margin-top: 5px">
                                                        <span class="new-badage">غیر فعال</span>
                                                    </div>
                                                </td>
                                                <td :rowspan="getProjectAllocCount(plans.capital_assets_project_has_credit_source[0].credit_source_has_allocation)">{{ plans.capital_assets_project_has_credit_source[0].cpCode }}</td>
                                                <td v-if="plans.capital_assets_project_has_credit_source[0].credit_source_has_allocation[0].ccsDeleted" :rowspan="getProjectAllocCount(plans.capital_assets_project_has_credit_source[0].credit_source_has_allocation)" class="text-center"><span class="comlpleted-badage">حذف شده</span></td>
                                                <td v-if="!plans.capital_assets_project_has_credit_source[0].credit_source_has_allocation[0].ccsDeleted" :rowspan="getProjectAllocCount(plans.capital_assets_project_has_credit_source[0].credit_source_has_allocation)" class="text-center">{{ $parent.calcDispAmount(getProjectAllocationSum(plans.capital_assets_project_has_credit_source[0].credit_source_has_allocation) , false) }}</td>
                                                <td :rowspan="plans.capital_assets_project_has_credit_source[0].credit_source_has_allocation[0].allocation.length">{{ plans.capital_assets_project_has_credit_source[0].credit_source_has_allocation[0].credit_distribution_row.cdSubject }}</td>
                                                <td>{{ plans.capital_assets_project_has_credit_source[0].credit_source_has_allocation[0].allocation[0].caaLetterNumber }}</td>
                                                <td>{{ plans.capital_assets_project_has_credit_source[0].credit_source_has_allocation[0].allocation[0].caaLetterDate }}</td>
                                                <td>{{ $parent.calcDispAmount(plans.capital_assets_project_has_credit_source[0].credit_source_has_allocation[0].allocation[0].caaAmount , false) }}</td>
                                                <td  v-show="selectColumn">
                                                    <input class="auto-margin" type="checkbox">
                                                </td>
                                            </tr>
                                            <template v-for="(projects, proIndex) in plans.capital_assets_project_has_credit_source">
                                                <tr class="tbl-head-style-cell" v-if="proIndex > 0">
                                                    <td :rowspan="getProjectAllocCount(projects.credit_source_has_allocation)">{{ projects.cpCode }}</td>
                                                    <td v-if="!projects.credit_source_has_allocation[0].ccsDeleted" :rowspan="getProjectAllocCount(projects.credit_source_has_allocation)" class="text-center">{{ $parent.calcDispAmount(getProjectAllocationSum(projects.credit_source_has_allocation) , false) }}</td>
                                                    <td v-if="projects.credit_source_has_allocation[0].ccsDeleted" :rowspan="getProjectAllocCount(projects.credit_source_has_allocation)" class="text-center">
                                                        <span class="comlpleted-badage">حذف شده</span>
                                                    </td>
                                                    <td :rowspan="projects.credit_source_has_allocation[0].allocation.length">{{ projects.credit_source_has_allocation[0].credit_distribution_row.cdSubject }}</td>
                                                    <td>{{ projects.credit_source_has_allocation[0].allocation[0].caaLetterNumber }}</td>
                                                    <td>{{ projects.credit_source_has_allocation[0].allocation[0].caaLetterDate }}</td>
                                                    <td>{{ $parent.calcDispAmount(projects.credit_source_has_allocation[0].allocation[0].caaAmount , false) }}</td>
                                                    <td  v-show="selectColumn">
                                                        <input class="auto-margin" type="checkbox">
                                                    </td>
                                                </tr>
                                                <template v-for="(credit_source , csIndex) in projects.credit_source_has_allocation">
                                                    <tr class="tbl-head-style-cell" v-if="csIndex > 0">
                                                        <td :rowspan="credit_source.allocation.length">{{ credit_source.credit_distribution_row.cdSubject }}</td>
                                                        <td>{{ credit_source.allocation[0].caaLetterNumber }}</td>
                                                        <td>{{ credit_source.allocation[0].caaLetterDate }}</td>
                                                        <td>{{ $parent.calcDispAmount(credit_source.allocation[0].caaAmount , false) }}</td>
                                                        <td  v-show="selectColumn">
                                                            <input class="auto-margin" type="checkbox">
                                                        </td>
                                                    </tr>
                                                    <template v-for="(alloc , allocIndex) in credit_source.allocation">
                                                        <tr class="tbl-head-style-cell" v-if="allocIndex > 0">
                                                            <td>{{ alloc.caaLetterNumber }}</td>
                                                            <td>{{ alloc.caaLetterDate }}</td>
                                                            <td>{{ $parent.calcDispAmount(alloc.caaAmount , false) }}</td>
                                                            <td  v-show="selectColumn">
                                                                <input class="auto-margin" type="checkbox">
                                                            </td>
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
                    <div class="tabs-panel table-mrg-btm" id="provincialFound" xmlns:v-on="http://www.w3.org/1999/xhtml">
                        <div class="medium-12 bottom-mrg">
                            <div class="clearfix border-btm-line bottom-mrg tool-bar">
                                <div style="margin-top: 2px;" class="button-group float-right">
                                    <a class="my-button toolbox-btn small" @click="openInsertFoundModal">جدید</a>
                                    <div v-if="!selectColumn" class="input-group-button toggle-icon-change">
                                        <button type="button" class="my-button my-icon-brand tiny" @click="showSelectColumn"><i class="fa fa-check-square-o size-14" aria-hidden="true"></i></button>
                                    </div>
                                    <div v-if="selectColumn" class="input-group-button toggle-icon-change">
                                        <button type="button" class="my-button my-icon-danger tiny" @click="showSelectColumn"><i class="fa fa-times size-14" aria-hidden="true"></i></button>
                                    </div>
                                    <button class="my-button toolbox-btn small dropdown small sm-btn-align"  type="button" data-toggle="reportDropDown1">گزارش</button>
                                    <div  style="width: 113px;" class="dropdown-pane dropdown-pane-sm " data-close-on-click="true"  data-hover="true" data-hover-pane="true"  data-position="bottom" data-alignment="left" id="reportDropDown1" data-dropdown data-auto-focus="true">
                                        <ul class="my-menu small-font ltr-dir">
                                            <li><a  href="#"><i class="fa fa-file-pdf-o icon-margin-dropdown" aria-hidden="true"></i>PDF</a></li>
                                            <li><a  href="#"><i class="fa fa-file-excel-o icon-margin-dropdown" aria-hidden="true"></i>Excel</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <!--Table Start-->
                            <div class="tbl-div-container">
                                <table class="tbl-head">
                                    <colgroup>
                                        <col width="150px"/>
                                        <col width="150px"/>
                                        <col width="150px"/>
                                        <col width="150px"/>
                                        <col width="200px"/>
                                        <col v-show="selectColumn" width="15px"/>
                                        <col width="12px"/>
                                    </colgroup>
                                    <tbody class="tbl-head-style">
                                    <tr class="tbl-head-style-cell">
                                        <th class="tbl-head-style-cell">تاریخ</th>
                                        <th class="tbl-head-style-cell">مبلغ</th>
                                        <th class="tbl-head-style-cell">هزینه</th>
                                        <th class="tbl-head-style-cell">تبدیل شده به تخصیص</th>
                                        <th class="tbl-head-style-cell">شرح</th>
                                        <th class="tbl-head-style-checkbox" v-show="selectColumn"><input type="checkbox"></th>
                                        <th class="tbl-head-style-cell"></th>
                                    </tr>
                                    </tbody>
                                </table>
                                <div class="tbl_body_style dynamic-height-level2">
                                    <table class="tbl-body-contain">
                                        <colgroup>
                                            <col width="150px"/>
                                            <col width="150px"/>
                                            <col width="150px"/>
                                            <col width="150px"/>
                                            <col width="200px"/>
                                            <col v-show="selectColumn" width="15px"/>
                                        </colgroup>
                                        <tbody class="tbl-head-style-cell">
                                            <tr class="tbl-head-style-cell" v-for="found in provCapitalAssetsFounds">
                                                <td class="text-center">{{ found.caaLetterDate }}</td>
                                                <td class="text-center">{{ $parent.calcDispAmount(found.caaAmount , false) }}</td>
                                                <td class="text-center">{{ $parent.calcDispAmount(found.caaSumOfCost , false) }}</td>
                                                <td class="text-center">{{ $parent.calcDispAmount(found.caaConvertedAllocAmount , false) }}</td>
                                                <td>
                                                    <div class="grid-x">
                                                        <div class="medium-11">
                                                            {{ found.caaDescription }}
                                                        </div>
                                                        <div class="medium-1 cell-vertical-center text-left">
                                                            <a class="dropdown small sm-btn-align" :data-toggle="'capitalAssetsFound' + found.id"  type="button"><i class="fa fa-ellipsis-v size-18"></i></a>
                                                            <div class="dropdown-pane dropdown-pane-sm " data-close-on-click="true"  data-hover="true" data-hover-pane="true"  data-position="bottom" data-alignment="right" :id="'capitalAssetsFound' + found.id" data-dropdown data-auto-focus="true">
                                                                <ul class="my-menu small-font text-right">
                                                                    <li><a v-on:click.prevent=""><i class="fa fa-newspaper-o size-16"></i>  ویراش</a></li>
                                                                    <li><a v-on:click.prevent=""><i class="fa fa-trash-o size-16"></i>  حذف</a></li>
                                                                    <li><a v-on:click.prevent="openConvertToModal(found.id)"><i class="fa fa-trash-o size-16"></i>  تبدیل به تخصیص</a></li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--Tab 3-->
                </div>
                <!--Forms Start-->
                <!--Insert Modal Start-->
                <modal-small v-if="showModal" @close="showModal = false" xmlns:v-on="http://www.w3.org/1999/xhtml">
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
                                <div class="medium-4 padding-lr">
                                    <label>شماره نامه
                                        <input class="form-element-margin-btm" type="text" name="letterNumber" v-model="AllocationInput.idNumber">
                                    </label>
                                </div>
                                <div class="medium-4 padding-lr">
                                    <p class="date-picker-lbl">تاریخ نامه
                                        <!--<input class="form-element-margin-btm" type="text" name="letterDate" v-model="AllocationInput.date">-->
                                        <pdatepicker id="datePicker" v-model="AllocationInput.date"  open-transition-animation="left-slide-fade"></pdatepicker>
                                    </p>
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
                                    <label>مبلغ تخصیص <span class="btn-red">{{ '(' + $parent.getAmountBaseLabel() + ')' }}</span>
                                        <input class="form-element-margin-btm" type="text"  v-model="AllocationInput.amount" name="creditCost" v-validate data-vv-rules="required" :class="{'input': true, 'select-error': errors.has('creditCost')}"/>
                                    </label>
                                    <span v-show="errors.has('creditCost')" class="error-font">لطفا مبلغ تخصیص را وارد کنید!</span>
                                </div>
                            </div>
                            <div class="grid-x my-callout-bg-color" v-show="creditSourceInfo.approvedAmount">
                                <div class="medium-12">
                                    <span class="btn-red">اعتبار مصوب:</span><span>{{ ' ' + $parent.calcDispAmount(creditSourceInfo.approvedAmount) }}</span>
                                </div>
                                <div class="medium-12">
                                    <span class="btn-red">آخرین تخصیص:</span><span>{{ ' ' + $parent.calcDispAmount(creditSourceInfo.sumAllocation) }}</span>
                                </div>
                                <div class="medium-12">
                                    <span class="btn-red">درصدآخرین تخصیص:</span><span>{{ ' ' + $parent.calcPrecent(creditSourceInfo.approvedAmount , creditSourceInfo.sumAllocation) }}</span>
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
                <!--Insert found Modal Start-->
                <modal-tiny v-if="showInsertFoundModal" @close="showInsertFoundModal = false" xmlns:v-on="http://www.w3.org/1999/xhtml">
                    <div  slot="body">
                        <form v-on:submit.prevent="createProvincialFound">
                            <div class="grid-x" v-if="errorMessage">
                                <div class="medium-12 columns padding-lr">
                                    <div class="alert callout">
                                        <p class="BYekan login-alert"><i class="fi-alert"></i>{{ errorMessage }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="grid-x">
                                <div class="medium-6 padding-lr">
                                    <p class="date-picker-lbl">تاریخ
                                        <pdatepicker v-model="foundInput.date" v-on:closed="checkValidDate" errMessage="تاریخ دریافت تنخواه فراموش شده است!" :isValid="dateIsValid_found"  open-transition-animation="left-slide-fade"></pdatepicker>
                                    </p>
                                </div>
                            </div>
                            <div class="grid-x">
                                <div class="medium-12 cell padding-lr">
                                    <label>مبلغ تنخواه <span class="btn-red">{{ '(' + $parent.getAmountBaseLabel() + ')' }}</span>
                                        <input class="form-element-margin-btm" type="text"  v-model="foundInput.amount" name="foundAmount" v-validate data-vv-rules="required" :class="{'input': true, 'select-error': errors.has('foundAmount')}"/>
                                    </label>
                                    <span v-show="errors.has('foundAmount')" class="error-font">لطفا مبلغ تنخواه را وارد کنید!</span>
                                </div>
                            </div>
                            <div class="grid-x">
                                <div class="small-12 columns padding-lr">
                                    <label>شرح
                                        <textarea name="csDescription" style="min-height: 150px;" v-model="foundInput.description"></textarea>
                                    </label>
                                </div>
                            </div>
                            <div class="medium-6 columns padding-lr padding-bottom-modal">
                                <button name="Submit" class="my-button my-success float-left btn-for-load"> <span class="btn-txt-mrg">ثبت</span></button>
                            </div>
                        </form>
                    </div>
                </modal-tiny>
                <!--Insert found Modal End-->
                <!--Insert Modal Start-->
                <modal-large v-if="showConvertToModal" @close="showConvertToModal = false" xmlns:v-on="http://www.w3.org/1999/xhtml">
                    <div  slot="body">
                        <form v-on:submit.prevent="convertToAllocation">
                            <div class="grid-x" v-if="errorMessage">
                                <div class="medium-12 columns padding-lr">
                                    <div class="alert callout">
                                        <p class="BYekan login-alert"><i class="fi-alert"></i>{{ errorMessage }}</p>
                                    </div>
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
                                <div class="medium-12 cell padding-lr">
                                    <label>اعتبار مصوب
                                        <select class="form-element-margin-btm" @change="displayCreditResourceInfo"  v-model="AllocationInput.pcsId" name="credit" v-validate data-vv-rules="required" :class="{'input': true, 'select-error': errors.has('credit')}">
                                            <option value=""></option>
                                            <option v-for="projectCreditSource in projectCreditSources" :value="projectCreditSource.id">{{ projectCreditSource.credit_distribution_row.cdSubject + ' - فصل ' + projectCreditSource.tiny_season.season_title.season.sSubject + ' - ' + projectCreditSource.tiny_season.season_title.castSubject + ' - ' + projectCreditSource.tiny_season.catsSubject + ' - ' + $parent.calcDispAmount(projectCreditSource.ccsAmount) }}</option>
                                        </select>
                                        <span v-show="errors.has('credit')" class="error-font">لطفا اعتبار مصوب را انتخاب کنید!</span>
                                    </label>
                                </div>
                            </div>
                            <div class="grid-x my-callout-bg-color" v-show="creditSourceInfo.approvedAmount">
                                <div class="medium-12">
                                    <span class="btn-red">اعتبار مصوب:</span><span>{{ ' ' + $parent.calcDispAmount(creditSourceInfo.approvedAmount) }}</span>
                                </div>
                                <div class="medium-12">
                                    <span class="btn-red">آخرین تخصیص:</span><span>{{ ' ' + $parent.calcDispAmount(creditSourceInfo.sumAllocation) }}</span>
                                </div>
                                <div class="medium-12">
                                    <span class="btn-red">درصدآخرین تخصیص:</span><span>{{ ' ' + $parent.calcPrecent(creditSourceInfo.approvedAmount , creditSourceInfo.sumAllocation) }}</span>
                                </div>
                            </div>
                            <div class="grid-x" style="margin-top: 10px">
                                <div class="medium-12 cell padding-lr">
                                    <label>هزینه <span class="btn-red">{{ '(' + $parent.getAmountBaseLabel() + ')' }}</span>
                                        <div class="tbl-div-container form-element-margin-btm">
                                            <table class="tbl-head">
                                                <colgroup>
                                                    <col width="250px"/>
                                                    <col width="150px"/>
                                                    <col width="600px"/>
                                                    <col v-show="selectColumn" width="15px"/>
                                                    <col width="12px"/>
                                                </colgroup>
                                                <tbody class="tbl-head-style">
                                                <tr class="tbl-head-style-cell">
                                                    <th class="tbl-head-style-cell">عنوان</th>
                                                    <th class="tbl-head-style-cell">مبلغ</th>
                                                    <th class="tbl-head-style-cell">شرح</th>
                                                    <th class="tbl-head-style-checkbox" v-show="selectColumn"><input type="checkbox"></th>
                                                    <th class="tbl-head-style-cell"></th>
                                                </tr>
                                                </tbody>
                                            </table>
                                            <div class="tbl_body_style">
                                                <table class="tbl-body-contain">
                                                    <colgroup>
                                                        <col width="250px"/>
                                                        <col width="150px"/>
                                                        <col width="600px"/>
                                                        <col v-show="selectColumn" width="15px"/>
                                                    </colgroup>
                                                    <tbody class="tbl-head-style-cell">
                                                    <tr class="tbl-head-style-cell" v-for="capCost in capitalAssetsCosts">
                                                        <td>{{ capCost.cacSubject }}</td>
                                                        <td class="text-center">{{ $parent.calcDispAmount(capCost.cacAmount , false) }}</td>
                                                        <td>{{ capCost.cacDescription }}</td>
                                                        <td>
                                                            <input class="auto-margin" v-model="capCost.checked" type="checkbox">
                                                        </td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <span class="error-font" v-show="unSelectedCost">حداقل یک مورد از لیست هزینه انتخاب کنید!</span>
                                    </label>
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
                provCapitalAssetsFounds: [],
                natCapitalAssetsAllocations: [],
                selectedCosts: [],
                capitalAssetsCosts: [],
                AllocationInput: {},
                foundInput: {},
                provOrNat: '',
                searchProvValue:'',
                searchNatValue:'',
                showModal: false,
                showInsertFoundModal: false,
                showModalUpdate: false,
                showModalDelete: false,
                showConvertToModal: false,
                showModalReport:false,
                selectColumn:false,
                unSelectedCost: false,
                dateIsValid_found: true,
                registerOfCreditAllocationAssetsFill: {rocaPlan: '' ,rocaaProject:'',rocaaRow:'',roccaCost:'',rocaaNumber:'',rocaaDate:''},
                creditSourceInfo: {},
                rocaaIdDelete: {},
                approvedPlans: {},
                selectedPlan: '',
                selectedProject: '',
                approvedProjects: {},
                projectCreditSources: {},
                selectedItems: [],
                selectedCount: 0,
                reportOptions: {title:'' , withReporterName: true , withFiscalYear: true , withReportDate: true , orientation: true , costLabel:false},
                foundIdForConvertTo: '',

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
            this.fetchProvincialFoundData();
            //this.getAllApprovedPlan(0); // 0 = provincial
        },

        updated: function () {
            $(this.$el).foundation(); //WORKS!
            this.$parent.userIsActive();
        },

        mounted: function () {
            console.log("mounted capital assets allocation component");
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
                        this.setData(0 , response.data.data);
                        this.selectAll(this.provCapitalAssetsAllocations);
                        this.makePagination(response.data , "provincial");
                        console.log(response);
                    },(error) => {
                        console.log(error);
                    });
            },

            fetchProvincialFoundData: function () {
                axios.get('/budget/allocation/capital_assets/found/fetchData')
                    .then((response) => {
                        this.provCapitalAssetsFounds = response.data;
                        this.setData(2 , response.data.data);
                        this.selectAll(this.provCapitalAssetsFounds);
                        console.log(response);
                    },(error) => {
                        console.log(error);
                    });
            },

            fetchNationalData: function (page = 1) {
                axios.get('/budget/allocation/capital_assets/fetchData?page=' + page , {params:{pOrN: 1}})
                    .then((response) => {
                        this.natCapitalAssetsAllocations = response.data.data;
                        this.setData(1 , response.data.data);
                        this.selectAll(this.natCapitalAssetsAllocations);
                        this.makePagination(response.data , "national");
                        console.log(response);
                    },(error) => {
                        console.log(error);
                    });
            },

            setData: function (type , data) {
                if (type == 0)
                {
                    this.provCapitalAssetsAllocations = data;
                    this.selectAll(this.provCapitalAssetsAllocations);
                    console.log(JSON.stringify(this.provCapitalAssetsAllocations));
                }else if(type==1) {
                    this.approvedProjects_nat = data;
                    this.selectAll(this.approvedProjects_nat);
                }
                else{
                    this.provCapitalAssetsFounds = data;
                    this.selectAll(this.provCapitalAssetsFounds);
                }
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

            openInsertFoundModal:function () {
                this.showInsertFoundModal = true;
            },

            createProvincialFound: function () {
                this.$validator.validateAll().then((result) => {
                    if (result) {
                        if (this.checkValidDate()) {
                            axios.post('/budget/allocation/capital_assets/found/register' , {
                                date: this.foundInput.date,
                                amount: this.foundInput.amount,
                                description: this.foundInput.description,
                                pOrN: 0
                            })
                                .then((response) => {
                                    this.provCapitalAssetsFounds = response.data;
                                    this.showInsertFoundModal = false;
                                    this.$parent.displayNotif(response.status);
                                    console.log(response);
                                },(error) => {
                                    console.log(error);
                                });
                        }
                    }
                });
            },

            ////////////// this method created for test convert found to allocation ///////////////////
            getCapitalAssetsCosts: function () {
                axios.get('/budget/allocation/capital_assets/found/getAllCapitalAssetsCosts' , {params:{fId: this.foundIdForConvertTo}})
                    .then((response) => {
                        this.capitalAssetsCosts = response.data;
                        this.capitalAssetsCosts.forEach(cost => {
                            this.$set(cost , 'checked' , true);
                        });
                        console.log(response);
                    },(error) => {
                        console.log(error);
                    });
            },

            convertToAllocation: function () {
                this.$validator.validateAll().then((result) => {
                    if (result) {
                        if (this.checkSelectedCosts(this.capitalAssetsCosts))
                        {
                            this.selectedCosts = [];
                            this.capitalAssetsCosts.forEach(cost => {
                                if (cost.checked)
                                    this.selectedCosts.push(cost);
                            });
                            axios.post('/budget/allocation/capital_assets/found/convert_to_allocation' , {
                                id: this.foundIdForConvertTo,
                                pcsId: this.AllocationInput.pcsId,
                                amount: this.AllocationInput.amount,
                                description: this.AllocationInput.description,
                                selectedCosts: this.selectedCosts
                            })
                                .then((response) => {
                                    this.provCapitalAssetsFounds = response.data.found;
                                    this.provCapitalAssetsAllocations = response.data.allocation_prov.data;
                                    this.showConvertToModal = false;
                                    this.$parent.displayNotif(response.status);
                                    console.log(response);
                                },(error) => {
                                    console.log(error);
                                });
                            console.log(JSON.stringify(this.selectedCosts));
                        }
                        else{
                            this.unSelectedCost = true;
                        }
                    }
                });
            },

            checkSelectedCosts: function (costs) {
                var state = false;
                this.unSelectedCost = false;
                costs.forEach(cost => {
                    if (cost.checked)
                        state = true;
                });
                return state;
            },

            openConvertToModal: function (fId) {
                this.unSelectedCost = false;
                this.selectedPlan = '';
                this.selectedProject = '';
                this.AllocationInput = [];
                this.creditSourceInfo = [];
                this.showConvertToModal = true;
                this.foundIdForConvertTo = fId;
                this.getCapitalAssetsCosts();
                this.getAllApprovedPlan(0);
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

            checkValidDate: function () {
                if (this.foundInput.date == null || this.foundInput.date == '')
                {
                    this.dateIsValid_found = false;
                    return false;
                }
                else
                {
                    this.dateIsValid_found = true;
                    return true;
                }
            },

            openReportModal: function (proOrNat , type) {
                this.provOrNat = proOrNat;
                this.reportType = type;
                this.selectedItems = [];
                var isSelected=false;
                if (proOrNat == 0)
                {
                    if (this.selectedLength(this.provCapitalAssetsAllocations) != 0)
                    {
                        this.showModalReport = true;
                        this.provCapitalAssetsAllocations.forEach(plan => {
                            plan.capital_assets_project_has_credit_source.forEach(projects => {
                                projects.credit_source_has_allocation.forEach(credit_source =>{
                                    credit_source.allocation.forEach(alloc =>{
                                        if (alloc.checked == true)
                                            isSelected=true;
                                    });
                                });
                            });
                            if (isSelected){
                                this.selectedItems.push(plan);
                                isSelected=false;
                            }

                        });
                        this.reportOptions.title = 'تخصیص اعتبار تملک داریی های سرمایه ای استانی';
                    }
                    else{
                        this.$parent.displayNotif(800);
                    }
                }
                else if(proOrNat == 1) {
                    if (this.selectedLength(this.natCapitalAssetsAllocations) != 0)
                    {
                        this.showModalReport = true;
                        this.natCapitalAssetsAllocations.forEach(plan => {
                            plan.capital_assets_project_has_credit_source.forEach(projects => {
                                projects.credit_source_has_allocation.forEach(credit_source =>{
                                    credit_source.allocation.forEach(alloc =>{
                                        if (alloc.checked == true)
                                            this.selectedItems.push(plan);
                                    });
                                });
                            });
                        });
                        this.reportOptions.title = 'تخصیص اعتبار تملک داریی های سرمایه ای ملی';
                    }
                    else{
                        this.$parent.displayNotif(800);
                    }
                }
                else {
                    if (this.selectedLength(this.provCapitalAssetsFounds) != 0)
                    {
                        this.showModalReport = true;
                        this.provCapitalAssetsFounds.forEach(plan => {
                            if(found.provCapitalAssetsFounds.every(function(project){return project.checked;}))
                                this.selectedItems.push(plan);
                        });
                        this.reportOptions.title = 'تخصیص اعتبار تنخواه- استانی';
                    }
                    else{
                        this.$parent.displayNotif(800);
                    }
                }

                console.log(JSON.stringify(this.selectedItems));
            },

            openReportFile: function () {
                axios.post('/budget/allocation/capital_assets/report' , {pOrN: this.provOrNat , type: this.reportType ,options: this.reportOptions , selectedItems: this.selectedItems})
                    .then((response) => {
                        console.log(response.data);
                        window.open(response.data);
                    },(error) => {
                        console.log(error);
                    });
            },

            showSelectColumn: function (plans) {
                this.selectAll(plans);
                if (this.selectColumn)
                {
                    this.selectColumn=false;
                }
                else {
                    this.selectColumn = true;
                }
            },


            toggleSelect: function(plans) {
                var temp = false;
                plans.forEach(plan => {
                    plan.capital_assets_project_has_credit_source.forEach(projects => {
                            projects.credit_source_has_allocation.forEach(credit_source =>{
                                credit_source.allocation.forEach(alloc =>{
                                    if (alloc.checked)
                                    temp = true;
                                });
                            });
                    });
                });
                plans.forEach(plan => {
                    if(temp){
                        plan.capital_assets_project_has_credit_source.forEach(projects => {
                            projects.credit_source_has_allocation.forEach(credit_source =>{
                                credit_source.allocation.forEach(alloc =>{
                                    alloc.checked = false;

                                 });
                             });
                        });
                    } else {
                        plan.capital_assets_project_has_credit_source.forEach(projects => {
                            projects.credit_source_has_allocation.forEach(credit_source =>{
                                credit_source.allocation.forEach(alloc =>{
                                    alloc.checked = true;
                                 });
                            });
                        });
                    }
                });
                console.log(JSON.stringify(this.provCapitalAssetsAllocations));
            },

            allSelected: function(plans) {
                var temp = true;
                console.log(JSON.stringify(this.provCapitalAssetsAllocations));
                plans.forEach(plan => {
                    plan.capital_assets_project_has_credit_source.forEach(projects => {
                            projects.credit_source_has_allocation.forEach(credit_source =>{
                                credit_source.allocation.forEach(alloc =>{
                                if (alloc.checked == false)
                            temp = false;
                            });
                        });
                    });
                });
                return temp;
            },

            selectAll: function (plans) {
                plans.forEach(plan => {
                    plan.capital_assets_project_has_credit_source.forEach(projects => {
                        projects.credit_source_has_allocation.forEach(credit_source =>{
                            credit_source.allocation.forEach(alloc =>{
                                this.$set(alloc, 'checked' , true);
                            });
                        });
                    });
                });
            },

            selectedLength: function (plans) {
                var counter=0;
                plans.forEach(plan => {
                    plan.capital_assets_project_has_credit_source.forEach(projects => {
                        projects.credit_source_has_allocation.forEach(credit_source =>{
                            credit_source.allocation.forEach(alloc =>{
                                counter+=alloc.checked;
                            });
                        });
                    });
                });
                return counter;
            },

        }
    }
</script>

