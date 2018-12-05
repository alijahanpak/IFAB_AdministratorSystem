<template xmlns:v-on="http://www.w3.org/1999/xhtml">
    <!--Inner body start-->
    <div class="medium-10 border-right-line inner-body-pad">
        <div class="grid-x padding-lr breadcrumbs-pos">
            <div class="medium-12">
                <div class="grid-x">
                    <nav aria-label="You are here:" role="navigation">
                        <ul class="breadcrumbs">
                            <li><router-link to="/budget">داشبورد</router-link></li>
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
                <div class="float-left cost-label">
                    <span class="small-font">{{ costTemp }}</span>
                </div>
                <ul class="tabs tab-color my-tab-style" data-responsive-accordion-tabs="tabs medium-accordion large-tabs" id="Register_of_credit_allocation_assets_tab_view">
                    <li class="tabs-title is-active"><a href="#national" aria-selected="true">استانی</a></li>
                    <li class="tabs-title"><a href="#provincial">ملی</a></li>
                    <li class="tabs-title"><a href="#provincialFound">تنخواه - استانی</a></li>
                </ul>
                <div class="tabs-content" data-tabs-content="Register_of_credit_allocation_assets_tab_view">
                    <!--Tab 1-->
                    <div class="tabs-panel is-active table-mrg-btm" id="national" xmlns:v-on="http://www.w3.org/1999/xhtml">
                        <div class="medium-12 bottom-mrg">
                            <div class="clearfix tool-bar">
                                <div class="button-group float-right report-mrg">
                                    <a v-show="$can('BUDGET_CAPITAL_ASSETS_ALLOCATION_INSERT')" class="my-button toolbox-btn small" @click="openInsertModal(0)">جدید</a>
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
                                    <button class="my-button toolbox-btn small dropdown small sm-btn-align"  type="button" data-toggle="assetsDropDownProv">تعداد نمایش<span> {{ itemInPage }} </span></button>
                                    <div  style="width: 113px;" class="dropdown-pane dropdown-pane-sm " data-close-on-click="true"  data-hover="true" data-hover-pane="true"  data-position="bottom" data-alignment="left" id="assetsDropDownProv" data-dropdown data-auto-focus="true">
                                        <ul class="my-menu small-font ltr-dir">
                                            <li><a  @click="changeItemInPage(10 , 0)">10<span v-show="itemInPage == 10" class="fi-check checked-color size-14"></span></a></li>
                                            <li><a  @click="changeItemInPage(25 , 0)">25<span v-show="itemInPage == 25" class="fi-check checked-color size-14"></span></a></li>
                                            <li><a  @click="changeItemInPage(50 , 0)">50<span v-show="itemInPage == 50" class="fi-check checked-color size-14"></span></a></li>
                                            <li><a  @click="changeItemInPage(100 , 0)">100<span v-show="itemInPage == 100" class="fi-check checked-color size-14"></span></a></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="float-left">
                                    <div class="input-group float-left">
                                        <div class="inner-addon right-addon">
                                            <i v-if="provSearchValue == ''" class="fa fa-search purple-color"  aria-hidden="true"></i>
                                            <i v-if="provSearchValue != ''" v-on:click.stop="removeFilter(0)" class="fa fa-close btn-red"  aria-hidden="true"></i>
                                            <input v-model="provSearchValue" v-on:keyup.enter="search(0)" class="search" type="text" placeholder="جستجو">
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
                                    <table class="tbl-body-contain unstriped">
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
                                            <template v-for="(plans , index) in provCapitalAssetsAllocations">
                                                <tr class="tbl-head-style-cell" :style="index % 2 == 1 ? 'background-color: #efefef' : ''">
                                                    <td :rowspan="getPlanAllocCount(plans.capital_assets_project_has_credit_source)">{{ plans.credit_distribution_title.cdtIdNumber + ' - ' + plans.credit_distribution_title.cdtSubject + ' - '  + plans.credit_distribution_title.county.coName}}
                                                        <div v-show="!plans.capActive" class="text-center" style="margin-top: 5px">
                                                            <span class="new-badage">غیر فعال</span>
                                                        </div>
                                                    </td>
                                                    <td :rowspan="getProjectAllocCount(plans.capital_assets_project_has_credit_source[0].credit_source_has_allocation)">{{ plans.capital_assets_project_has_credit_source[0].cpCode + ' - ' + plans.capital_assets_project_has_credit_source[0].cpSubject }}</td>
                                                    <td v-if="plans.capital_assets_project_has_credit_source[0].credit_source_has_allocation[0].ccsDeleted" :rowspan="getProjectAllocCount(plans.capital_assets_project_has_credit_source[0].credit_source_has_allocation)" class="text-center"><span class="comlpleted-badage">حذف شده</span></td>
                                                    <td v-if="!plans.capital_assets_project_has_credit_source[0].credit_source_has_allocation[0].ccsDeleted" :rowspan="getProjectAllocCount(plans.capital_assets_project_has_credit_source[0].credit_source_has_allocation)" class="text-center">{{ $parent.calcDispAmount(getProjectAllocationSum(plans.capital_assets_project_has_credit_source[0].credit_source_has_allocation) , false) }}</td>
                                                    <td :rowspan="plans.capital_assets_project_has_credit_source[0].credit_source_has_allocation[0].allocation.length" class="text-center">{{ plans.capital_assets_project_has_credit_source[0].credit_source_has_allocation[0].credit_distribution_row.cdSubject }}</td>
                                                    <td v-if="plans.capital_assets_project_has_credit_source[0].credit_source_has_allocation[0].allocation[0].caaFoundId == null" class="text-center">{{ plans.capital_assets_project_has_credit_source[0].credit_source_has_allocation[0].allocation[0].caaLetterNumber }}</td>
                                                    <td class="text-center" v-if="plans.capital_assets_project_has_credit_source[0].credit_source_has_allocation[0].allocation[0].caaFoundId != null"><i class="fa fa-exchange btn-red has-tip top" data-tooltip aria-haspopup="true" data-disable-hover="false" title="تبدیل شده از تنخواه"></i></td>
                                                    <td class="text-center">{{ plans.capital_assets_project_has_credit_source[0].credit_source_has_allocation[0].allocation[0].caaLetterDate }}</td>
                                                    <td class="text-center">
                                                        <div class="grid-x">
                                                            <div class="medium-11">
                                                                <div :data-toggle="'Paper' + plans.capital_assets_project_has_credit_source[0].credit_source_has_allocation[0].allocation[0].id" v-if="plans.capital_assets_project_has_credit_source[0].credit_source_has_allocation[0].allocation[0].caaDtId != null" class="clearfix tool-bar">
                                                                    <div style="min-width: 200px" class="dropdown-pane dropdown-pane-sm " data-close-on-click="true"  data-hover="true" data-hover-pane="true" data-h-offset="20px"  data-position="auto" data-alignment="auto" :id="'Paper' + plans.capital_assets_project_has_credit_source[0].credit_source_has_allocation[0].allocation[0].id" data-dropdown data-auto-focus="true">
                                                                        <ul class="my-menu small-font">
                                                                            <div class="grid-x">
                                                                                <div class="medium-12">
                                                                                    <p class="black-color font-wei-bold text-right">نماد اخزا: <span class="font-wei gray-color">{{plans.capital_assets_project_has_credit_source[0].credit_source_has_allocation[0].allocation[0].caaSymbolOfAkhza}}</span></p>
                                                                                    <p class="black-color font-wei-bold text-right">نوع اوراق: <span class="font-wei gray-color">{{plans.capital_assets_project_has_credit_source[0].credit_source_has_allocation[0].allocation[0].due_type.dtSubject}}</span></p>
                                                                                    <p class="black-color font-wei-bold text-right">تاریخ سر رسید: <span class="font-wei btn-red">{{plans.capital_assets_project_has_credit_source[0].credit_source_has_allocation[0].allocation[0].caaDueDate}}</span></p>
                                                                                </div>
                                                                            </div>
                                                                        </ul>
                                                                    </div>
                                                                    <span  class="btn-red font-wei-bold">{{ $parent.calcDispAmount(plans.capital_assets_project_has_credit_source[0].credit_source_has_allocation[0].allocation[0].caaAmount , false) }}</span>
                                                                </div>
                                                                <span v-else>{{ $parent.calcDispAmount(plans.capital_assets_project_has_credit_source[0].credit_source_has_allocation[0].allocation[0].caaAmount , false) }}</span>
                                                            </div>
                                                            <div v-show="$can('BUDGET_CAPITAL_ASSETS_ALLOCATION_EDIT') || $can('BUDGET_CAPITAL_ASSETS_ALLOCATION_DELETE')" class="medium-1 cell-vertical-center text-left">
                                                                <a class="dropdown small sm-btn-align" :data-toggle="'provCapitalAssetsAllocation' + plans.capital_assets_project_has_credit_source[0].credit_source_has_allocation[0].allocation[0].id"><i class="fa fa-ellipsis-v size-18"></i></a>
                                                                <div class="dropdown-pane dropdown-pane-sm " data-close-on-click="true"  data-hover="true" data-hover-pane="true"  data-position="bottom" data-alignment="right" :id="'provCapitalAssetsAllocation' + plans.capital_assets_project_has_credit_source[0].credit_source_has_allocation[0].allocation[0].id" data-dropdown data-auto-focus="true">
                                                                    <ul class="my-menu small-font text-right">
                                                                        <li v-show="$can('BUDGET_CAPITAL_ASSETS_ALLOCATION_EDIT')"><a v-on:click.prevent="openUpdateModal(plans.capital_assets_project_has_credit_source[0].credit_source_has_allocation[0].allocation[0] , plans.id , plans.capital_assets_project_has_credit_source[0].id , 0)"><i class="fa fa-pencil-square-o size-16"></i>  ویرایش</a></li>
                                                                        <li v-show="$can('BUDGET_CAPITAL_ASSETS_ALLOCATION_DELETE')"><a v-on:click.prevent="openDeleteModal(plans.capital_assets_project_has_credit_source[0].credit_source_has_allocation[0].allocation[0] , 0)"><i class="fa fa-trash-o size-16"></i>  حذف</a></li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td  v-show="selectColumn">
                                                        <input class="auto-margin" v-model="plans.capital_assets_project_has_credit_source[0].credit_source_has_allocation[0].allocation[0].checked" type="checkbox">
                                                    </td>
                                                </tr>
                                               <template v-for="(projects, proIndex) in plans.capital_assets_project_has_credit_source">
                                                   <tr class="tbl-head-style-cell" v-if="proIndex > 0"  :style="index % 2 == 1 ? 'background-color: #efefef' : ''">
                                                       <td :rowspan="getProjectAllocCount(projects.credit_source_has_allocation)">{{ projects.cpCode + ' - ' + projects.cpSubject }}</td>
                                                       <td v-if="!projects.credit_source_has_allocation[0].ccsDeleted" :rowspan="getProjectAllocCount(projects.credit_source_has_allocation)" class="text-center">{{ $parent.calcDispAmount(getProjectAllocationSum(projects.credit_source_has_allocation) , false) }}</td>
                                                       <td v-if="projects.credit_source_has_allocation[0].ccsDeleted" :rowspan="getProjectAllocCount(projects.credit_source_has_allocation)" class="text-center">
                                                           <span class="comlpleted-badage">حذف شده</span>
                                                       </td>
                                                       <td :rowspan="projects.credit_source_has_allocation[0].allocation.length" class="text-center">{{ projects.credit_source_has_allocation[0].credit_distribution_row.cdSubject }}</td>
                                                       <td class="text-center" v-if="projects.credit_source_has_allocation[0].allocation[0].caaFoundId == null">{{ projects.credit_source_has_allocation[0].allocation[0].caaLetterNumber }}</td>
                                                       <td class="text-center" v-if="projects.credit_source_has_allocation[0].allocation[0].caaFoundId != null"><i class="fa fa-exchange btn-red has-tip top" data-tooltip aria-haspopup="true" data-disable-hover="false" title="تبدیل شده از تنخواه"></i></td>
                                                       <td class="text-center">{{ projects.credit_source_has_allocation[0].allocation[0].caaLetterDate }}</td>
                                                       <td class="text-center">
                                                           <div class="grid-x">
                                                               <div class="medium-11">
                                                                   <div :data-toggle="'Paper' + projects.credit_source_has_allocation[0].allocation[0].id" v-if="projects.credit_source_has_allocation[0].allocation[0].caaDtId != null" class="clearfix tool-bar">
                                                                       <div style="min-width: 200px" class="dropdown-pane dropdown-pane-sm " data-close-on-click="true"  data-hover="true" data-hover-pane="true" data-h-offset="20px"  data-position="auto" data-alignment="auto" :id="'Paper' + projects.credit_source_has_allocation[0].allocation[0].id" data-dropdown data-auto-focus="true">
                                                                           <ul class="my-menu small-font">
                                                                               <div class="grid-x">
                                                                                   <div class="medium-12">
                                                                                       <p class="black-color font-wei-bold text-right">نماد اخزا: <span class="font-wei gray-color">{{projects.credit_source_has_allocation[0].allocation[0].caaSymbolOfAkhza}}</span></p>
                                                                                       <p class="black-color font-wei-bold text-right">نوع اوراق: <span class="font-wei gray-color">{{projects.credit_source_has_allocation[0].allocation[0].due_type.dtSubject}}</span></p>
                                                                                       <p class="black-color font-wei-bold text-right">تاریخ سر رسید: <span class="font-wei btn-red">{{projects.credit_source_has_allocation[0].allocation[0].caaDueDate}}</span></p>
                                                                                   </div>
                                                                               </div>
                                                                           </ul>
                                                                       </div>
                                                                       <span  class="btn-red font-wei-bold">{{ $parent.calcDispAmount(projects.credit_source_has_allocation[0].allocation[0].caaAmount , false) }}</span>
                                                                   </div>
                                                                   <span v-else>{{ $parent.calcDispAmount(projects.credit_source_has_allocation[0].allocation[0].caaAmount , false) }}</span>
                                                               </div>
                                                               <div v-show="$can('BUDGET_CAPITAL_ASSETS_ALLOCATION_EDIT') || $can('BUDGET_CAPITAL_ASSETS_ALLOCATION_DELETE')" class="medium-1 cell-vertical-center text-left">
                                                                   <a class="dropdown small sm-btn-align" :data-toggle="'provCapitalAssetsAllocation' + projects.credit_source_has_allocation[0].allocation[0].id"><i class="fa fa-ellipsis-v size-18"></i></a>
                                                                   <div class="dropdown-pane dropdown-pane-sm " data-close-on-click="true"  data-hover="true" data-hover-pane="true"  data-position="bottom" data-alignment="right" :id="'provCapitalAssetsAllocation' + projects.credit_source_has_allocation[0].allocation[0].id" data-dropdown data-auto-focus="true">
                                                                       <ul class="my-menu small-font text-right">
                                                                           <li v-show="$can('BUDGET_CAPITAL_ASSETS_ALLOCATION_EDIT')"><a v-on:click.prevent="openUpdateModal(projects.credit_source_has_allocation[0].allocation[0] , plans.id , projects.id , 0)"><i class="fa fa-pencil-square-o size-16"></i>  ویرایش</a></li>
                                                                           <li v-show="$can('BUDGET_CAPITAL_ASSETS_ALLOCATION_DELETE')"><a v-on:click.prevent="openDeleteModal(projects.credit_source_has_allocation[0].allocation[0] , 0)"><i class="fa fa-trash-o size-16"></i>  حذف</a></li>
                                                                       </ul>
                                                                   </div>
                                                               </div>
                                                           </div>
                                                       </td>
                                                       <td  v-show="selectColumn">
                                                           <input class="auto-margin" v-model="projects.credit_source_has_allocation[0].allocation[0].checked" type="checkbox">
                                                       </td>
                                                   </tr>
                                                    <template v-for="(credit_source , csIndex) in projects.credit_source_has_allocation">
                                                        <tr class="tbl-head-style-cell" v-if="csIndex > 0"  :style="index % 2 == 1 ? 'background-color: #efefef' : ''">
                                                            <td :rowspan="credit_source.allocation.length" class="text-center">{{ credit_source.credit_distribution_row.cdSubject }}</td>
                                                            <td class="text-center" v-if="credit_source.allocation[0].caaFoundId == null">{{ credit_source.allocation[0].caaLetterNumber }}</td>
                                                            <td class="text-center" v-if="credit_source.allocation[0].caaFoundId != null"><i class="fa fa-exchange btn-red has-tip top" data-tooltip aria-haspopup="true" data-disable-hover="false" title="تبدیل شده از تنخواه"></i></td>
                                                            <td class="text-center">{{ credit_source.allocation[0].caaLetterDate }}</td>
                                                            <td class="text-center">
                                                                <div class="grid-x">
                                                                    <div class="medium-11">
                                                                        <div :data-toggle="'Paper' + credit_source.allocation[0].id" v-if="credit_source.allocation[0].caaDtId != null" class="clearfix tool-bar">
                                                                            <div style="min-width: 200px" class="dropdown-pane dropdown-pane-sm " data-close-on-click="true"  data-hover="true" data-hover-pane="true" data-h-offset="20px"  data-position="auto" data-alignment="auto" :id="'Paper' + credit_source.allocation[0].id" data-dropdown data-auto-focus="true">
                                                                                <ul class="my-menu small-font">
                                                                                    <div class="grid-x">
                                                                                        <div class="medium-12">
                                                                                            <p class="black-color font-wei-bold text-right">نماد اخزا: <span class="font-wei gray-color">{{credit_source.allocation[0].caaSymbolOfAkhza}}</span></p>
                                                                                            <p class="black-color font-wei-bold text-right">نوع اوراق: <span class="font-wei gray-color">{{credit_source.allocation[0].due_type.dtSubject}}</span></p>
                                                                                            <p class="black-color font-wei-bold text-right">تاریخ سر رسید: <span class="font-wei btn-red">{{credit_source.allocation[0].caaDueDate}}</span></p>
                                                                                        </div>
                                                                                    </div>
                                                                                </ul>
                                                                            </div>
                                                                            <span  class="btn-red font-wei-bold">{{ $parent.calcDispAmount(credit_source.allocation[0].caaAmount , false) }}</span>
                                                                        </div>
                                                                        <span v-else>{{ $parent.calcDispAmount(credit_source.allocation[0].caaAmount , false) }}</span>
                                                                    </div>
                                                                    <div v-show="$can('BUDGET_CAPITAL_ASSETS_ALLOCATION_EDIT') || $can('BUDGET_CAPITAL_ASSETS_ALLOCATION_DELETE')" class="medium-1 cell-vertical-center text-left">
                                                                        <a class="dropdown small sm-btn-align" :data-toggle="'provCapitalAssetsAllocation' + credit_source.allocation[0].id"><i class="fa fa-ellipsis-v size-18"></i></a>
                                                                        <div class="dropdown-pane dropdown-pane-sm " data-close-on-click="true"  data-hover="true" data-hover-pane="true"  data-position="bottom" data-alignment="right" :id="'provCapitalAssetsAllocation' + credit_source.allocation[0].id" data-dropdown data-auto-focus="true">
                                                                            <ul class="my-menu small-font text-right">
                                                                                <li v-show="$can('BUDGET_CAPITAL_ASSETS_ALLOCATION_EDIT')"><a v-on:click.prevent="openUpdateModal(credit_source.allocation[0] , plans.id , projects.id , 0)"><i class="fa fa-pencil-square-o size-16"></i>  ویرایش</a></li>
                                                                                <li v-show="$can('BUDGET_CAPITAL_ASSETS_ALLOCATION_DELETE')"><a v-on:click.prevent="openDeleteModal(credit_source.allocation[0] , 0)"><i class="fa fa-trash-o size-16"></i>  حذف</a></li>
                                                                            </ul>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td  v-show="selectColumn">
                                                                <input class="auto-margin" v-model="credit_source.allocation[0].checked" type="checkbox">
                                                            </td>
                                                        </tr>
                                                        <template v-for="(alloc , allocIndex) in credit_source.allocation">
                                                            <tr class="tbl-head-style-cell" v-if="allocIndex > 0"  :style="index % 2 == 1 ? 'background-color: #efefef' : ''">
                                                                <td class="text-center" v-if="alloc.caaFoundId == null">{{ alloc.caaLetterNumber }}</td>
                                                                <td class="text-center" v-if="alloc.caaFoundId != null"><i class="fa fa-exchange btn-red has-tip top" data-tooltip aria-haspopup="true" data-disable-hover="false" title="تبدیل شده از تنخواه"></i></td>
                                                                <td class="text-center">{{ alloc.caaLetterDate }}</td>
                                                                <td class="text-center">
                                                                    <div class="grid-x">
                                                                        <div class="medium-11">
                                                                            <div :data-toggle="'Paper' + alloc.id" v-if="alloc.caaDtId != null" class="clearfix tool-bar">
                                                                                <div style="min-width: 200px" class="dropdown-pane dropdown-pane-sm " data-close-on-click="true"  data-hover="true" data-hover-pane="true" data-h-offset="20px"  data-position="auto" data-alignment="auto" :id="'Paper' + alloc.id" data-dropdown data-auto-focus="true">
                                                                                    <ul class="my-menu small-font">
                                                                                        <div class="grid-x">
                                                                                            <div class="medium-12">
                                                                                                <p class="black-color font-wei-bold text-right">نماد اخزا: <span class="font-wei gray-color">{{alloc.caaSymbolOfAkhza}}</span></p>
                                                                                                <p class="black-color font-wei-bold text-right">نوع اوراق: <span class="font-wei gray-color">{{alloc.due_type.dtSubject}}</span></p>
                                                                                                <p class="black-color font-wei-bold text-right">تاریخ سر رسید: <span class="font-wei btn-red">{{alloc.caaDueDate}}</span></p>
                                                                                            </div>
                                                                                        </div>
                                                                                    </ul>
                                                                                </div>
                                                                                <span  class="btn-red font-wei-bold">{{ $parent.calcDispAmount(alloc.caaAmount , false) }}</span>
                                                                            </div>
                                                                            <span v-else>{{ $parent.calcDispAmount(alloc.caaAmount , false) }}</span>
                                                                        </div>
                                                                        <div v-show="$can('BUDGET_CAPITAL_ASSETS_ALLOCATION_EDIT') || $can('BUDGET_CAPITAL_ASSETS_ALLOCATION_DELETE')" class="medium-1 cell-vertical-center text-left">
                                                                            <a class="dropdown small sm-btn-align" :data-toggle="'provCapitalAssetsAllocation' + alloc.id"><i class="fa fa-ellipsis-v size-18"></i></a>
                                                                            <div class="dropdown-pane dropdown-pane-sm " data-close-on-click="true"  data-hover="true" data-hover-pane="true"  data-position="bottom" data-alignment="right" :id="'provCapitalAssetsAllocation' + alloc.id" data-dropdown data-auto-focus="true">
                                                                                <ul class="my-menu small-font text-right">
                                                                                    <li v-show="$can('BUDGET_CAPITAL_ASSETS_ALLOCATION_EDIT')"><a v-on:click.prevent="openUpdateModal(alloc , plans.id , projects.id , 0)"><i class="fa fa-pencil-square-o size-16"></i>  ویرایش</a></li>
                                                                                    <li v-show="$can('BUDGET_CAPITAL_ASSETS_ALLOCATION_DELETE')"><a v-on:click.prevent="openDeleteModal(alloc , 0)"><i class="fa fa-trash-o size-16"></i>  حذف</a></li>
                                                                                </ul>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </td>
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
                        </div>
                    </div>
                    <!--Tab 1-->
                    <!--Tab 2-->
                    <div class="tabs-panel table-mrg-btm" id="provincial" xmlns:v-on="http://www.w3.org/1999/xhtml">
                        <div class="medium-12 bottom-mrg">
                            <div class="clearfix tool-bar">
                                <div  class="button-group float-right report-mrg">
                                    <a v-show="$can('BUDGET_CAPITAL_ASSETS_ALLOCATION_INSERT')" class="my-button toolbox-btn small" @click="openInsertModal(1)">جدید</a>
                                    <div v-if="!selectColumn" class="input-group-button toggle-icon-change">
                                        <button type="button" class="my-button my-icon-brand tiny" @click="showSelectColumn(natCapitalAssetsAllocations)"><i class="fa fa-check-square-o size-14" aria-hidden="true"></i></button>
                                    </div>
                                    <div v-if="selectColumn" class="input-group-button toggle-icon-change">
                                        <button type="button" class="my-button my-icon-danger tiny" @click="showSelectColumn(natCapitalAssetsAllocations)"><i class="fa fa-times size-14" aria-hidden="true"></i></button>
                                    </div>
                                    <button class="my-button toolbox-btn small dropdown small sm-btn-align"  type="button" data-toggle="reportDropDownNat">گزارش</button>
                                    <div  style="width: 113px;" class="dropdown-pane dropdown-pane-sm " data-close-on-click="true"  data-hover="true" data-hover-pane="true"  data-position="bottom" data-alignment="left" id="reportDropDownNat" data-dropdown data-auto-focus="true">
                                        <ul class="my-menu small-font ltr-dir">
                                            <li><a  @click="openReportModal(1,'pdf')"><i class="fa fa-file-pdf-o icon-margin-dropdown" aria-hidden="true"></i>PDF</a></li>
                                            <li><a  @click="openReportModal(1,'excel')"><i class="fa fa-file-excel-o icon-margin-dropdown" aria-hidden="true"></i>Excel</a></li>
                                        </ul>
                                    </div>
                                    <button class="my-button toolbox-btn small dropdown small sm-btn-align"  type="button" data-toggle="assetsDropDownNat">تعداد نمایش<span> {{ natItemInPage }} </span></button>
                                    <div  style="width: 113px;" class="dropdown-pane dropdown-pane-sm " data-close-on-click="true"  data-hover="true" data-hover-pane="true"  data-position="bottom" data-alignment="left" id="assetsDropDownNat" data-dropdown data-auto-focus="true">
                                        <ul class="my-menu small-font ltr-dir">
                                            <li><a  @click="changeItemInPage(10 , 1)">10<span v-show="natItemInPage == 10" class="fi-check checked-color size-14"></span></a></li>
                                            <li><a  @click="changeItemInPage(25 , 1)">25<span v-show="natItemInPage == 25" class="fi-check checked-color size-14"></span></a></li>
                                            <li><a  @click="changeItemInPage(50 , 1)">50<span v-show="natItemInPage == 50" class="fi-check checked-color size-14"></span></a></li>
                                            <li><a  @click="changeItemInPage(100 , 1)">100<span v-show="natItemInPage == 100" class="fi-check checked-color size-14"></span></a></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="float-left">
                                    <div class="input-group float-left">
                                        <div class="inner-addon right-addon">
                                            <i v-if="natSearchValue == ''" class="fa fa-search purple-color"  aria-hidden="true"></i>
                                            <i v-if="natSearchValue != ''" v-on:click.stop="removeFilter(1)" class="fa fa-close btn-red"  aria-hidden="true"></i>
                                            <input v-model="natSearchValue" v-on:keyup.enter="search(1)" class="search" type="text" placeholder="جستجو">
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
                                        <th class="tbl-head-style-checkbox" v-show="selectColumn"><input type="checkbox" @click="toggleSelect(natCapitalAssetsAllocations)" :checked="allSelected(natCapitalAssetsAllocations)"></th>
                                        <th class="tbl-head-style-cell"></th>
                                    </tr>
                                    </tbody>
                                </table>

                                <div class="tbl_body_style dynamic-height-level2">
                                    <table class="tbl-body-contain unstriped">
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
                                        <template v-for="(plans, index) in natCapitalAssetsAllocations">
                                            <tr class="tbl-head-style-cell" :style="index % 2 == 1 ? 'background-color: #efefef' : ''">
                                                <td :rowspan="getPlanAllocCount(plans.capital_assets_project_has_credit_source)">{{ plans.credit_distribution_title.cdtIdNumber + ' - ' + plans.credit_distribution_title.cdtSubject }}
                                                    <div v-show="!plans.capActive" class="text-center" style="margin-top: 5px">
                                                        <span class="new-badage">غیر فعال</span>
                                                    </div>
                                                </td>
                                                <td :rowspan="getProjectAllocCount(plans.capital_assets_project_has_credit_source[0].credit_source_has_allocation)">{{ plans.capital_assets_project_has_credit_source[0].cpCode + ' - ' +  plans.capital_assets_project_has_credit_source[0].cpSubject }}</td>
                                                <td v-if="plans.capital_assets_project_has_credit_source[0].credit_source_has_allocation[0].ccsDeleted" :rowspan="getProjectAllocCount(plans.capital_assets_project_has_credit_source[0].credit_source_has_allocation)" class="text-center"><span class="comlpleted-badage">حذف شده</span></td>
                                                <td v-if="!plans.capital_assets_project_has_credit_source[0].credit_source_has_allocation[0].ccsDeleted" :rowspan="getProjectAllocCount(plans.capital_assets_project_has_credit_source[0].credit_source_has_allocation)" class="text-center">{{ $parent.calcDispAmount(getProjectAllocationSum(plans.capital_assets_project_has_credit_source[0].credit_source_has_allocation) , false) }}</td>
                                                <td :rowspan="plans.capital_assets_project_has_credit_source[0].credit_source_has_allocation[0].allocation.length" class="text-center">{{ plans.capital_assets_project_has_credit_source[0].credit_source_has_allocation[0].credit_distribution_row.cdSubject }}</td>
                                                <td class="text-center">{{ plans.capital_assets_project_has_credit_source[0].credit_source_has_allocation[0].allocation[0].caaLetterNumber }}</td>
                                                <td class="text-center">{{ plans.capital_assets_project_has_credit_source[0].credit_source_has_allocation[0].allocation[0].caaLetterDate }}</td>
                                                <td class="text-center">
                                                    <div class="grid-x">
                                                        <div class="medium-11">
                                                            <div :data-toggle="'_Paper' + plans.capital_assets_project_has_credit_source[0].credit_source_has_allocation[0].allocation[0].id" v-if="plans.capital_assets_project_has_credit_source[0].credit_source_has_allocation[0].allocation[0].caaDtId != null" class="clearfix tool-bar">
                                                                <div style="min-width: 200px" class="dropdown-pane dropdown-pane-sm " data-close-on-click="true"  data-hover="true" data-hover-pane="true" data-h-offset="20px"  data-position="auto" data-alignment="auto" :id="'_Paper' + plans.capital_assets_project_has_credit_source[0].credit_source_has_allocation[0].allocation[0].id" data-dropdown data-auto-focus="true">
                                                                    <ul class="my-menu small-font">
                                                                        <div class="grid-x">
                                                                            <div class="medium-12">
                                                                                <p class="black-color font-wei-bold text-right">نماد اخزا: <span class="font-wei gray-color">{{plans.capital_assets_project_has_credit_source[0].credit_source_has_allocation[0].allocation[0].caaSymbolOfAkhza}}</span></p>
                                                                                <p class="black-color font-wei-bold text-right">نوع اوراق: <span class="font-wei gray-color">{{plans.capital_assets_project_has_credit_source[0].credit_source_has_allocation[0].allocation[0].due_type.dtSubject}}</span></p>
                                                                                <p class="black-color font-wei-bold text-right">تاریخ سر رسید: <span class="font-wei btn-red">{{plans.capital_assets_project_has_credit_source[0].credit_source_has_allocation[0].allocation[0].caaDueDate}}</span></p>
                                                                            </div>
                                                                        </div>
                                                                    </ul>
                                                                </div>
                                                                <span  class="btn-red font-wei-bold">{{ $parent.calcDispAmount(plans.capital_assets_project_has_credit_source[0].credit_source_has_allocation[0].allocation[0].caaAmount , false) }}</span>
                                                            </div>
                                                            <span v-else>{{ $parent.calcDispAmount(plans.capital_assets_project_has_credit_source[0].credit_source_has_allocation[0].allocation[0].caaAmount , false) }}</span>
                                                        </div>
                                                        <div v-show="$can('BUDGET_CAPITAL_ASSETS_ALLOCATION_EDIT') || $can('BUDGET_CAPITAL_ASSETS_ALLOCATION_DELETE')" class="medium-1 cell-vertical-center text-left">
                                                            <a class="dropdown small sm-btn-align" :data-toggle="'natCapitalAssetsAllocation' + plans.capital_assets_project_has_credit_source[0].credit_source_has_allocation[0].allocation[0].id"><i class="fa fa-ellipsis-v size-18"></i></a>
                                                            <div class="dropdown-pane dropdown-pane-sm " data-close-on-click="true"  data-hover="true" data-hover-pane="true"  data-position="bottom" data-alignment="right" :id="'natCapitalAssetsAllocation' + plans.capital_assets_project_has_credit_source[0].credit_source_has_allocation[0].allocation[0].id" data-dropdown data-auto-focus="true">
                                                                <ul class="my-menu small-font text-right">
                                                                    <li v-show="$can('BUDGET_CAPITAL_ASSETS_ALLOCATION_EDIT')"><a v-on:click.prevent="openUpdateModal(plans.capital_assets_project_has_credit_source[0].credit_source_has_allocation[0].allocation[0] , plans.id , plans.capital_assets_project_has_credit_source[0].id , 1)"><i class="fa fa-pencil-square-o size-16"></i>  ویرایش</a></li>
                                                                    <li v-show="$can('BUDGET_CAPITAL_ASSETS_ALLOCATION_DELETE')"><a v-on:click.prevent="openDeleteModal(plans.capital_assets_project_has_credit_source[0].credit_source_has_allocation[0].allocation[0] , 1)"><i class="fa fa-trash-o size-16"></i>  حذف</a></li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td  v-show="selectColumn">
                                                    <input class="auto-margin" v-model="plans.capital_assets_project_has_credit_source[0].credit_source_has_allocation[0].allocation[0].checked" type="checkbox">
                                                </td>
                                            </tr>
                                            <template v-for="(projects, proIndex) in plans.capital_assets_project_has_credit_source">
                                                <tr class="tbl-head-style-cell" v-if="proIndex > 0"  :style="index % 2 == 1 ? 'background-color: #efefef' : ''">
                                                    <td :rowspan="getProjectAllocCount(projects.credit_source_has_allocation)">{{ projects.cpCode + ' - ' +  projects.cpSubject }}</td>
                                                    <td v-if="!projects.credit_source_has_allocation[0].ccsDeleted" :rowspan="getProjectAllocCount(projects.credit_source_has_allocation)" class="text-center">{{ $parent.calcDispAmount(getProjectAllocationSum(projects.credit_source_has_allocation) , false) }}</td>
                                                    <td v-if="projects.credit_source_has_allocation[0].ccsDeleted" :rowspan="getProjectAllocCount(projects.credit_source_has_allocation)" class="text-center">
                                                        <span class="comlpleted-badage">حذف شده</span>
                                                    </td>
                                                    <td :rowspan="projects.credit_source_has_allocation[0].allocation.length" class="text-center">{{ projects.credit_source_has_allocation[0].credit_distribution_row.cdSubject }}</td>
                                                    <td class="text-center">{{ projects.credit_source_has_allocation[0].allocation[0].caaLetterNumber }}</td>
                                                    <td class="text-center">{{ projects.credit_source_has_allocation[0].allocation[0].caaLetterDate }}</td>
                                                    <td class="text-center">
                                                        <div class="grid-x">
                                                            <div class="medium-11">
                                                                <div :data-toggle="'_Paper' + projects.credit_source_has_allocation[0].allocation[0].id" v-if="projects.credit_source_has_allocation[0].allocation[0].caaDtId != null" class="clearfix tool-bar">
                                                                    <div style="min-width: 200px" class="dropdown-pane dropdown-pane-sm " data-close-on-click="true"  data-hover="true" data-hover-pane="true" data-h-offset="20px"  data-position="auto" data-alignment="auto" :id="'_Paper' + projects.credit_source_has_allocation[0].allocation[0].id" data-dropdown data-auto-focus="true">
                                                                        <ul class="my-menu small-font">
                                                                            <div class="grid-x">
                                                                                <div class="medium-12">
                                                                                    <p class="black-color font-wei-bold text-right">نماد اخزا: <span class="font-wei gray-color">{{projects.credit_source_has_allocation[0].allocation[0].caaSymbolOfAkhza}}</span></p>
                                                                                    <p class="black-color font-wei-bold text-right">نوع اوراق: <span class="font-wei gray-color">{{projects.credit_source_has_allocation[0].allocation[0].due_type.dtSubject}}</span></p>
                                                                                    <p class="black-color font-wei-bold text-right">تاریخ سر رسید: <span class="font-wei btn-red">{{projects.credit_source_has_allocation[0].allocation[0].caaDueDate}}</span></p>
                                                                                </div>
                                                                            </div>
                                                                        </ul>
                                                                    </div>
                                                                    <span  class="btn-red font-wei-bold">{{ $parent.calcDispAmount(projects.credit_source_has_allocation[0].allocation[0].caaAmount , false) }}</span>
                                                                </div>
                                                                <span v-else>{{ $parent.calcDispAmount(projects.credit_source_has_allocation[0].allocation[0].caaAmount , false) }}</span>
                                                            </div>
                                                            <div v-show="$can('BUDGET_CAPITAL_ASSETS_ALLOCATION_EDIT') || $can('BUDGET_CAPITAL_ASSETS_ALLOCATION_DELETE')" class="medium-1 cell-vertical-center text-left">
                                                                <a class="dropdown small sm-btn-align" :data-toggle="'natCapitalAssetsAllocation' + projects.credit_source_has_allocation[0].allocation[0].id"><i class="fa fa-ellipsis-v size-18"></i></a>
                                                                <div class="dropdown-pane dropdown-pane-sm " data-close-on-click="true"  data-hover="true" data-hover-pane="true"  data-position="bottom" data-alignment="right" :id="'natCapitalAssetsAllocation' + projects.credit_source_has_allocation[0].allocation[0].id" data-dropdown data-auto-focus="true">
                                                                    <ul class="my-menu small-font text-right">
                                                                        <li v-show="$can('BUDGET_CAPITAL_ASSETS_ALLOCATION_EDIT')"><a v-on:click.prevent="openUpdateModal(projects.credit_source_has_allocation[0].allocation[0] , plans.id , projects.id , 1)"><i class="fa fa-pencil-square-o size-16"></i>  ویرایش</a></li>
                                                                        <li v-show="$can('BUDGET_CAPITAL_ASSETS_ALLOCATION_DELETE')"><a v-on:click.prevent="openDeleteModal(projects.credit_source_has_allocation[0].allocation[0] , 1)"><i class="fa fa-trash-o size-16"></i>  حذف</a></li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td  v-show="selectColumn">
                                                        <input class="auto-margin" v-model="projects.credit_source_has_allocation[0].allocation[0].checked" type="checkbox">
                                                    </td>
                                                </tr>
                                                <template v-for="(credit_source , csIndex) in projects.credit_source_has_allocation">
                                                    <tr class="tbl-head-style-cell" v-if="csIndex > 0"  :style="index % 2 == 1 ? 'background-color: #efefef' : ''">
                                                        <td :rowspan="credit_source.allocation.length" class="text-center">{{ credit_source.credit_distribution_row.cdSubject }}</td>
                                                        <td class="text-center">{{ credit_source.allocation[0].caaLetterNumber }}</td>
                                                        <td class="text-center">{{ credit_source.allocation[0].caaLetterDate }}</td>
                                                        <td class="text-center">
                                                            <div class="grid-x">
                                                                <div class="medium-11">
                                                                    <div :data-toggle="'_Paper' + credit_source.allocation[0].id" v-if="credit_source.allocation[0].caaDtId != null" class="clearfix tool-bar">
                                                                        <div style="min-width: 200px" class="dropdown-pane dropdown-pane-sm " data-close-on-click="true"  data-hover="true" data-hover-pane="true" data-h-offset="20px"  data-position="auto" data-alignment="auto" :id="'_Paper' + credit_source.allocation[0].id" data-dropdown data-auto-focus="true">
                                                                            <ul class="my-menu small-font">
                                                                                <div class="grid-x">
                                                                                    <div class="medium-12">
                                                                                        <p class="black-color font-wei-bold text-right">نماد اخزا: <span class="font-wei gray-color">{{credit_source.allocation[0].caaSymbolOfAkhza}}</span></p>
                                                                                        <p class="black-color font-wei-bold text-right">نوع اوراق: <span class="font-wei gray-color">{{credit_source.allocation[0].due_type.dtSubject}}</span></p>
                                                                                        <p class="black-color font-wei-bold text-right">تاریخ سر رسید: <span class="font-wei btn-red">{{credit_source.allocation[0].caaDueDate}}</span></p>
                                                                                    </div>
                                                                                </div>
                                                                            </ul>
                                                                        </div>
                                                                        <span  class="btn-red font-wei-bold">{{ $parent.calcDispAmount(credit_source.allocation[0].caaAmount , false) }}</span>
                                                                    </div>
                                                                    <span v-else>{{ $parent.calcDispAmount(credit_source.allocation[0].caaAmount , false) }}</span>
                                                                </div>
                                                                <div v-show="$can('BUDGET_CAPITAL_ASSETS_ALLOCATION_EDIT') || $can('BUDGET_CAPITAL_ASSETS_ALLOCATION_DELETE')" class="medium-1 cell-vertical-center text-left">
                                                                    <a class="dropdown small sm-btn-align" :data-toggle="'natCapitalAssetsAllocation' + credit_source.allocation[0].id"><i class="fa fa-ellipsis-v size-18"></i></a>
                                                                    <div class="dropdown-pane dropdown-pane-sm " data-close-on-click="true"  data-hover="true" data-hover-pane="true"  data-position="bottom" data-alignment="right" :id="'natCapitalAssetsAllocation' + credit_source.allocation[0].id" data-dropdown data-auto-focus="true">
                                                                        <ul class="my-menu small-font text-right">
                                                                            <li v-show="$can('BUDGET_CAPITAL_ASSETS_ALLOCATION_EDIT')"><a v-on:click.prevent="openUpdateModal(credit_source.allocation[0] , plans.id , projects.id , 1)"><i class="fa fa-pencil-square-o size-16"></i>  ویرایش</a></li>
                                                                            <li v-show="$can('BUDGET_CAPITAL_ASSETS_ALLOCATION_DELETE')"><a v-on:click.prevent="openDeleteModal(credit_source.allocation[0] , 1)"><i class="fa fa-trash-o size-16"></i>  حذف</a></li>
                                                                        </ul>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td  v-show="selectColumn">
                                                            <input class="auto-margin" v-model="credit_source.allocation[0].checked" type="checkbox">
                                                        </td>
                                                    </tr>
                                                    <template v-for="(alloc , allocIndex) in credit_source.allocation">
                                                        <tr class="tbl-head-style-cell" v-if="allocIndex > 0"  :style="index % 2 == 1 ? 'background-color: #efefef' : ''">
                                                            <td class="text-center">{{ alloc.caaLetterNumber }}</td>
                                                            <td class="text-center">{{ alloc.caaLetterDate }}</td>
                                                            <td class="text-center">
                                                                <div class="grid-x">
                                                                    <div class="medium-11">
                                                                        <div :data-toggle="'_Paper' + alloc.id" v-if="alloc.caaDtId != null" class="clearfix tool-bar">
                                                                            <div style="min-width: 200px" class="dropdown-pane dropdown-pane-sm " data-close-on-click="true"  data-hover="true" data-hover-pane="true" data-h-offset="20px"  data-position="auto" data-alignment="auto" :id="'_Paper' + alloc.id" data-dropdown data-auto-focus="true">
                                                                                <ul class="my-menu small-font">
                                                                                    <div class="grid-x">
                                                                                        <div class="medium-12">
                                                                                            <p class="black-color font-wei-bold text-right">نماد اخزا: <span class="font-wei gray-color">{{alloc.caaSymbolOfAkhza}}</span></p>
                                                                                            <p class="black-color font-wei-bold text-right">نوع اوراق: <span class="font-wei gray-color">{{alloc.due_type.dtSubject}}</span></p>
                                                                                            <p class="black-color font-wei-bold text-right">تاریخ سر رسید: <span class="font-wei btn-red">{{alloc.caaDueDate}}</span></p>
                                                                                        </div>
                                                                                    </div>
                                                                                </ul>
                                                                            </div>
                                                                            <span  class="btn-red font-wei-bold">{{ $parent.calcDispAmount(alloc.caaAmount , false) }}</span>
                                                                        </div>
                                                                        <span v-else>{{ $parent.calcDispAmount(alloc.caaAmount , false) }}</span>
                                                                    </div>
                                                                    <div v-show="$can('BUDGET_CAPITAL_ASSETS_ALLOCATION_EDIT') || $can('BUDGET_CAPITAL_ASSETS_ALLOCATION_DELETE')" class="medium-1 cell-vertical-center text-left">
                                                                        <a class="dropdown small sm-btn-align" :data-toggle="'natCapitalAssetsAllocation' + alloc.id"><i class="fa fa-ellipsis-v size-18"></i></a>
                                                                        <div class="dropdown-pane dropdown-pane-sm " data-close-on-click="true"  data-hover="true" data-hover-pane="true"  data-position="bottom" data-alignment="right" :id="'natCapitalAssetsAllocation' + alloc.id" data-dropdown data-auto-focus="true">
                                                                            <ul class="my-menu small-font text-right">
                                                                                <li v-show="$can('BUDGET_CAPITAL_ASSETS_ALLOCATION_EDIT')"><a v-on:click.prevent="openUpdateModal(alloc , plans.id , projects.id , 1)"><i class="fa fa-pencil-square-o size-16"></i>  ویرایش</a></li>
                                                                                <li v-show="$can('BUDGET_CAPITAL_ASSETS_ALLOCATION_DELETE')"><a v-on:click.prevent="openDeleteModal(alloc , 1)"><i class="fa fa-trash-o size-16"></i>  حذف</a></li>
                                                                            </ul>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </td>
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
                                    <div class="medium-12">
                                        <vue-pagination  v-bind:pagination="national_pagination"
                                                         v-on:click.native="fetchNationalData(national_pagination.current_page)"
                                                         :offset="4">
                                        </vue-pagination>
                                    </div>
                                </div>
                                <div style="color: #575962;" v-show="selectColumn" class="medium-4 small-font">
                                    <div class="float-left">
                                        <p> تعداد رکورد های انتخاب شده :<span class="selected-row-style">{{ selectedLength(natCapitalAssetsAllocations) }}</span></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--Tab 2-->
                    <!--Tab 3-->
                    <div class="tabs-panel table-mrg-btm" id="provincialFound" xmlns:v-on="http://www.w3.org/1999/xhtml">
                        <div class="medium-12 bottom-mrg">
                            <div class="clearfix tool-bar">
                                <div style="margin-top: 2px;margin-bottom: 3px;" class="button-group float-right">
                                    <a v-show="$can('BUDGET_CAPITAL_ASSETS_FOUND_INSERT')" class="my-button toolbox-btn small" @click="openInsertFoundModal">جدید</a>
                                    <div v-if="!selectColumn" class="input-group-button toggle-icon-change">
                                        <button type="button" class="my-button my-icon-brand tiny" @click="foundShowSelectColumn(provCapitalAssetsFounds)"><i class="fa fa-check-square-o size-14" aria-hidden="true"></i></button>
                                    </div>
                                    <div v-if="selectColumn" class="input-group-button toggle-icon-change">
                                        <button type="button" class="my-button my-icon-danger tiny" @click="foundShowSelectColumn(provCapitalAssetsFounds)"><i class="fa fa-times size-14" aria-hidden="true"></i></button>
                                    </div>
                                    <button class="my-button toolbox-btn small dropdown small sm-btn-align"  type="button" data-toggle="reportDropDown1">گزارش</button>
                                    <div  style="width: 113px;" class="dropdown-pane dropdown-pane-sm " data-close-on-click="true"  data-hover="true" data-hover-pane="true"  data-position="bottom" data-alignment="left" id="reportDropDown1" data-dropdown data-auto-focus="true">
                                        <ul class="my-menu small-font ltr-dir">
                                            <li><a  @click="foundOpenReportModal('pdf')"><i class="fa fa-file-pdf-o icon-margin-dropdown" aria-hidden="true"></i>PDF</a></li>
                                            <li><a  @click="foundOpenReportModal('excel')"><i class="fa fa-file-excel-o icon-margin-dropdown" aria-hidden="true"></i>Excel</a></li>
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
                                        <th class="tbl-head-style-checkbox" v-show="selectColumn"><input type="checkbox" @click="foundToggleSelect(provCapitalAssetsFounds)" :checked="foundAllSelected(provCapitalAssetsFounds)"></th>
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
                                                        <div v-show="$can('BUDGET_CAPITAL_ASSETS_FOUND_EDIT') || $can('BUDGET_CAPITAL_ASSETS_FOUND_DELETE') || $can('BUDGET_CAPITAL_ASSETS_FOUND_CONVERT_TO_ALLOCATION')" class="medium-1 cell-vertical-center text-left">
                                                            <a class="dropdown small sm-btn-align" :data-toggle="'capitalAssetsFound' + found.id"><i class="fa fa-ellipsis-v size-18"></i></a>
                                                            <div style="width: 170px" class="dropdown-pane dropdown-pane-sm" data-close-on-click="true"  data-hover="true" data-hover-pane="true"  data-position="bottom" data-alignment="right" :id="'capitalAssetsFound' + found.id" data-dropdown data-auto-focus="true">
                                                                <ul class="my-menu small-font text-right">
                                                                    <li v-show="$can('BUDGET_CAPITAL_ASSETS_FOUND_EDIT')"><a v-on:click.prevent="openFoundUpdateModal(found)"><i class="fa fa-newspaper-o size-16"></i>  ویرایش</a></li>
                                                                    <li v-show="$can('BUDGET_CAPITAL_ASSETS_FOUND_DELETE')"><a v-on:click.prevent="openFoundDeleteModal(found)"><i class="fa fa-trash-o size-16"></i>  حذف</a></li>
                                                                    <li v-show="$can('BUDGET_CAPITAL_ASSETS_FOUND_CONVERT_TO_ALLOCATION')"><a v-on:click.prevent="openConvertToModal(found.id)"><i class="fa fa-trash-o size-16"></i>  تبدیل به تخصیص</a></li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td  v-show="selectColumn">
                                                    <input class="auto-margin" v-model="found.checked" type="checkbox">
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
                <modal-large v-if="showInsertModal" @close="showInsertModal = false" xmlns:v-on="http://www.w3.org/1999/xhtml">
                    <div  slot="body">
                        <form v-on:submit.prevent="createCapitalAssetsAllocation">
                            <div class="grid-x">
                                <div class="large-7 medium-7 small-12">
                                    <div class="grid-x">
                                        <div class="medium-6 padding-lr">
                                            <label>شماره نامه
                                                <input class="form-element-margin-btm" type="text" name="letterNumber" v-model="AllocationInput.idNumber">
                                            </label>
                                        </div>
                                        <div class="medium-6 padding-lr">
                                            <label>تاریخ
                                                <date-picker
                                                        :color="checkAllocationDateValid ? '#d9534f' : '#5c6bc0'"
                                                        v-model="AllocationInput.date"
                                                        input-class="form-control form-control-lg date-picker-bottom-margin"
                                                        id="AllocationInputDate"
                                                        placeholder="انتخاب تاریخ">
                                                </date-picker>
                                                <p style="margin-top:3px !important;" v-show="checkAllocationDateValid" class="error-font">لطفا تاریخ مورد نظر را انتخاب نمایید!</p>
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
                                                <select class="form-element-margin-btm" @change="displayCreditResourceInfo(AllocationInput.pcsId)"  v-model="AllocationInput.pcsId" name="credit" v-validate data-vv-rules="required" :class="{'input': true, 'select-error': errors.has('credit')}">
                                                    <option value=""></option>
                                                    <option v-for="projectCreditSource in projectCreditSources" :value="projectCreditSource.id">{{ projectCreditSource.credit_distribution_row.cdSubject + ' - فصل ' + projectCreditSource.tiny_season.season_title.season.sSubject + ' - ' + projectCreditSource.tiny_season.season_title.castSubject + ' - ' + projectCreditSource.tiny_season.catsSubject + ' - ' + $parent.calcDispAmount(projectCreditSource.ccsAmount) }}</option>
                                                </select>
                                                <span v-show="errors.has('credit')" class="error-font">لطفا اعتبار مصوب را انتخاب کنید!</span>
                                            </label>
                                        </div>
                                        <div class="medium-6 cell padding-lr">
                                            <label>مبلغ تخصیص <span class="btn-red">{{ '(' + $parent.getAmountBaseLabel() + ')' }}</span>
                                                <input class="form-element-margin-btm" type="text"  v-model="AllocationInput.amount" name="creditCost" v-validate="'required|min_value:1|max_value:' + maxInputAmount" :class="{'input': true, 'select-error': errors.has('creditCost')}"/>
                                            </label>
                                            <span v-show="errors.has('creditCost')" class="error-font">مبلغ تخصیص فراموش شده / نا معتبر است!</span>
                                        </div>
                                    </div>
                                    <div class="grid-x padding-lr" style="margin-top: 10px" v-show="creditSourceInfo != ''">
                                        <div class="medium-12 my-callout-bg-color size-14">
                                            <div class="medium-12">
                                                <span class="btn-red">اعتبار مصوب:</span><span>{{ ' ' + $parent.calcDispAmount(creditSourceInfo.ccsAmount) }}</span>
                                            </div>
                                            <div class="medium-12">
                                                <span class="btn-red">آخرین تخصیص:</span><span>{{ ' ' + $parent.calcDispAmount(creditSourceInfo.ccsSumOfAllocation) }}</span>
                                            </div>
                                            <div class="medium-12">
                                                <span class="btn-red">درصدآخرین تخصیص:</span><span>{{ ' ' + $parent.calcPrecent(creditSourceInfo.ccsAmount , creditSourceInfo.ccsSumOfAllocation) }}</span>
                                            </div>
                                            <div class="medium-12 ">
                                                <span class="btn-red">باقیمانده:</span><span>{{ ' ' + $parent.calcDispAmount(creditSourceInfo.ccsAmount - creditSourceInfo.ccsSumOfAllocation) }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="large-5 medium-5 small-12">
                                    <div class="grid-x">
                                        <div class="small-12 columns padding-lr">
                                            <label>شرح
                                                <textarea name="csDescription" style="min-height: 300px;" v-model="AllocationInput.description"></textarea>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="grid-x padding-lr top-margin-element">
                                <div style="display: table">
                                    <div style="display:table-cell">
                                        <div class="switch tiny">
                                            <input class="switch-input" type="checkbox" v-model="AllocationInput.isPapers" id="isPapers" @change="clearDueInformation()">
                                            <label class="switch-paddle" for="isPapers">
                                                <span class="switch-active" aria-hidden="true">بلی</span>
                                                <span class="switch-inactive" aria-hidden="true">خیر</span>
                                            </label>
                                        </div>
                                    </div>
                                    <div style="display: table-cell;padding-right: 8px;">
                                        <p style="position: relative;">اوراق خزانه</p>
                                    </div>
                                </div>
                            </div>
                            <div class="grid-x">
                                <div class="medium-4 cell padding-lr">
                                    <label>نماد اخزا
                                        <input :disabled="!AllocationInput.isPapers" class="form-element-margin-btm" type="text"  v-model="AllocationInput.symbolOfAkhza" name="akhza" v-validate="{rules: 'required' , disabled:!AllocationInput.isPapers}" :class="{'input': true, 'select-error': errors.has('akhza')}"/>
                                    </label>
                                    <span v-show="errors.has('akhza')" class="error-font">نماد اخزا فراموش شده / نا معتبر است!</span>
                                </div>
                                <div class="medium-4 cell padding-lr">
                                    <label> تاریخ سر رسید
                                        <date-picker
                                                :color="checkAllocationDueDateValid ? '#d9534f' : '#5c6bc0'"
                                                v-model="AllocationInput.dueDate"
                                                input-class="form-control form-control-lg date-picker-bottom-margin"
                                                id="AllocationInputDueDate"
                                                :disabled="!AllocationInput.isPapers"
                                                placeholder="انتخاب تاریخ">
                                        </date-picker>
                                        <p style="margin-top:3px !important;" v-show="checkAllocationDueDateValid" class="error-font">لطفا تاریخ سر رسید را انتخاب نمایید!</p>
                                    </label>
                                </div>
                                <div class="medium-4 cell padding-lr">
                                    <label>نوع اوراق
                                        <select class="form-element-margin-btm" :disabled="!AllocationInput.isPapers"  v-model="AllocationInput.dtId" name="dueType" v-validate="{rules: 'required' , disabled:!AllocationInput.isPapers}" :class="{'input': true, 'select-error': errors.has('dueType')}">
                                            <option value=""></option>
                                            <option v-for="dt in dueType" :value="dt.id">{{ dt.dtSubject }}</option>
                                        </select>
                                        <span v-show="errors.has('dueType')" class="error-font">لطفا نوع اوراق را انتخاب کنید!</span>
                                    </label>
                                </div>
                            </div>
                            <div class="medium-6 columns padding-lr padding-bottom-modal top-margin-element">
                                <button v-show="!$root.btnLoadingCheckStatus" name="Submit" class="my-button my-success float-left btn-for-load"> <span class="btn-txt-mrg">ثبت</span></button>
                                <p v-show="$root.btnLoadingCheckStatus" class="my-button my-success float-left"><i class="fas fa-spinner fa-pulse btn-txt-mrg"></i></p>
                            </div>
                        </form>
                    </div>
                </modal-large>
                <!--Insert Modal End-->
                <!--update Modal Start-->
                <modal-large v-if="showUpdateModal" @close="showUpdateModal = false" xmlns:v-on="http://www.w3.org/1999/xhtml">
                    <div  slot="body">
                        <form v-on:submit.prevent="updateCapitalAssetsAllocation">
                            <div class="grid-x">
                                <div class="large-7 medium-7 small-12">
                                    <div class="grid-x">
                                        <div class="medium-6 padding-lr">
                                            <label>شماره نامه
                                                <input class="form-element-margin-btm" type="text" name="letterNumber" v-model="AllocationFill.idNumber">
                                            </label>
                                        </div>
                                        <div class="medium-6 padding-lr">
                                            <label>تاریخ
                                                <date-picker
                                                        :color="'#5c6bc0'"
                                                        v-model="AllocationFill.date"
                                                        input-class="form-control form-control-lg date-picker-bottom-margin"
                                                        id="AllocationFillDate"
                                                        placeholder="انتخاب تاریخ">
                                                </date-picker>
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
                                                <select class="form-element-margin-btm" @change="displayCreditResourceInfo(AllocationFill.pcsId)"  v-model="AllocationFill.pcsId" name="credit" v-validate data-vv-rules="required" :class="{'input': true, 'select-error': errors.has('credit')}">
                                                    <option value=""></option>
                                                    <option v-for="projectCreditSource in projectCreditSources" :value="projectCreditSource.id">{{ projectCreditSource.credit_distribution_row.cdSubject + ' - فصل ' + projectCreditSource.tiny_season.season_title.season.sSubject + ' - ' + projectCreditSource.tiny_season.season_title.castSubject + ' - ' + projectCreditSource.tiny_season.catsSubject + ' - ' + $parent.calcDispAmount(projectCreditSource.ccsAmount) }}</option>
                                                </select>
                                                <span v-show="errors.has('credit')" class="error-font">لطفا اعتبار مصوب را انتخاب کنید!</span>
                                            </label>
                                        </div>
                                        <div class="medium-6 cell padding-lr">
                                            <label>مبلغ تخصیص <span class="btn-red">{{ '(' + $parent.getAmountBaseLabel() + ')' }}</span>
                                                <input :disabled="AllocationFill.isFound" class="form-element-margin-btm" type="text"  v-model="AllocationFill.amount" name="creditCost" v-validate="'required|min_value:' + minInputAmount + '|max_value:' + maxInputAmount" :class="{'input': true, 'select-error': errors.has('creditCost')}"/>
                                            </label>
                                            <span v-show="errors.has('creditCost')" class="error-font">مبلغ تخصیص فراموش شده / نا معتبر است!</span>
                                        </div>
                                    </div>
                                    <div style="margin-top: 10px" class="grid-x padding-lr" v-show="creditSourceInfo != ''">
                                        <div class="medium-12 my-callout-bg-color">
                                            <div class="grid-x size-14">
                                                <div class="large-6 medium-6 small-12">
                                                    <div class="medium-12">
                                                        <span class="btn-red">اعتبار مصوب:</span><span>{{ ' ' + $parent.calcDispAmount(creditSourceInfo.ccsAmount) }}</span>
                                                    </div>
                                                    <div class="medium-12">
                                                        <span class="btn-red">آخرین تخصیص:</span><span>{{ ' ' + $parent.calcDispAmount(creditSourceInfo.ccsSumOfAllocation) }}</span>
                                                    </div>
                                                    <div class="medium-12">
                                                        <span class="btn-red">درصدآخرین تخصیص:</span><span>{{ ' ' + $parent.calcPrecent(creditSourceInfo.ccsAmount , creditSourceInfo.ccsSumOfAllocation) }}</span>
                                                    </div>
                                                    <div class="medium-12 ">
                                                        <span class="btn-red">باقیمانده:</span><span>{{ ' ' + $parent.calcDispAmount(creditSourceInfo.ccsAmount - creditSourceInfo.ccsSumOfAllocation) }}</span>
                                                    </div>
                                                </div>
                                                <div class="large-6 medium-6 small-12">
                                                    <div class="medium-12">
                                                        <span class="btn-red">رزرو شده:</span><span>{{ ' ' + $parent.calcDispAmount(creditSourceInfo.ccsSumOfReserved) }}</span>
                                                    </div>
                                                    <div class="medium-12">
                                                        <span class="btn-red">تعهد شده:</span><span>{{ ' ' + $parent.calcDispAmount(creditSourceInfo.ccsSumOfCommitment) }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="large-5 medium-5 small-12">
                                    <div class="grid-x">
                                        <div class="small-12 columns padding-lr">
                                            <label>شرح
                                                <textarea name="csDescription" style="min-height: 300px;" v-model="AllocationFill.description"></textarea>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div v-if="AllocationFill.isPapers" class="grid-x">
                                <div class="medium-4 cell padding-lr">
                                    <label>نماد اخزا
                                        <input class="form-element-margin-btm" type="text"  v-model="AllocationFill.symbolOfAkhza" name="akhza" v-validate="{rules: 'required'}" :class="{'input': true, 'select-error': errors.has('_akhza')}"/>
                                    </label>
                                    <span v-show="errors.has('_akhza')" class="error-font">نماد اخزا فراموش شده / نا معتبر است!</span>
                                </div>
                                <div class="medium-4 cell padding-lr">
                                    <label> تاریخ سر رسید
                                        <date-picker
                                                :color="checkAllocationDueDateValid ? '#d9534f' : '#5c6bc0'"
                                                v-model="AllocationFill.dueDate"
                                                input-class="form-control form-control-lg date-picker-bottom-margin"
                                                id="_AllocationInputDueDate"
                                                placeholder="انتخاب تاریخ">
                                        </date-picker>
                                        <p style="margin-top:3px !important;" v-show="checkAllocationDueDateValid" class="error-font">لطفا تاریخ سر رسید را انتخاب نمایید!</p>
                                    </label>
                                </div>
                                <div class="medium-4 cell padding-lr">
                                    <label>نوع اوراق
                                        <select class="form-element-margin-btm" v-model="AllocationFill.dtId" name="dueType" v-validate="{rules: 'required'}" :class="{'input': true, 'select-error': errors.has('_dueType')}">
                                            <option value=""></option>
                                            <option v-for="dt in dueType" :value="dt.id">{{ dt.dtSubject }}</option>
                                        </select>
                                        <span v-show="errors.has('_dueType')" class="error-font">لطفا نوع اوراق را انتخاب کنید!</span>
                                    </label>
                                </div>
                            </div>
                            <div class="medium-6 columns padding-lr top-margin-element">
                                <button  v-show="!$root.btnLoadingCheckStatus" name="Submit" class="my-button my-success float-left btn-for-load"> <span class="btn-txt-mrg">ثبت</span></button>
                                <p v-show="$root.btnLoadingCheckStatus" class="my-button my-success float-left"><i class="fas fa-spinner fa-pulse btn-txt-mrg"></i></p>
                            </div>
                        </form>
                    </div>
                </modal-large>
                <!--update Modal End-->
                <!-- Delete Modal Start -->
                <modal-tiny v-if="showDeleteModal" @close="showDeleteModal = false">
                    <div  slot="body">
                        <div class="small-font">
                            <p>کاربر گرامی</p>
                            <p class="large-offset-1 modal-text">آیا برای حذف این رکورد اطمینان دارید؟</p>
                            <div class="grid-x">
                                <div class="medium-12 column text-center">
                                    <button v-show="!$root.btnLoadingCheckStatus" v-on:click="deleteCapitalAssetsAllocation" class="my-button my-success"><span class="btn-txt-mrg">   بله   </span></button>
                                    <p v-show="$root.btnLoadingCheckStatus" class="my-button my-success"><i class="fas fa-spinner fa-pulse btn-txt-mrg"></i></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </modal-tiny>
                <!-- Delete Modal End -->
                <!--Insert found Modal Start-->
                <modal-tiny v-if="showInsertFoundModal" @close="showInsertFoundModal = false" xmlns:v-on="http://www.w3.org/1999/xhtml">
                    <div  slot="body">
                        <form v-on:submit.prevent="createProvincialFound">
                            <div class="grid-x">
                                <div class="medium-12 padding-lr">
                                    <label>تاریخ
                                        <!--<date-picker v-on:closed="checkValidDate(foundInput)" errMessage="تاریخ دریافت فراموش شده است!" :isValid="dateIsValid_found"-->
                                        <date-picker
                                                :color="checkAllocationDateValid ? '#d9534f' : '#5c6bc0'"
                                                v-model="foundInput.date"
                                                input-class="form-control form-control-lg date-picker-bottom-margin"
                                                id="foundInputDate"
                                                placeholder="انتخاب تاریخ">
                                        </date-picker>
                                        <p style="margin-top:3px !important;" v-show="checkAllocationDateValid" class="error-font">لطفا تاریخ مورد نظر را انتخاب نمایید!</p>
                                    </label>
                                </div>
                            </div>
                            <div class="grid-x top-margin-element">
                                <div class="medium-12 cell padding-lr">
                                    <label>مبلغ تنخواه <span class="btn-red">{{ '(' + $parent.getAmountBaseLabel() + ')' }}</span>
                                        <input class="form-element-margin-btm" type="text"  v-model="foundInput.amount" name="foundAmount" v-validate="'required|min_value:1'" :class="{'input': true, 'select-error': errors.has('foundAmount')}"/>
                                    </label>
                                    <span v-show="errors.has('foundAmount')" class="error-font">مبلغ تنخواه فراموش شده / نا معتبر است!</span>
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
                                <button v-show="!$root.btnLoadingCheckStatus" name="Submit" class="my-button my-success float-left btn-for-load"> <span class="btn-txt-mrg">ثبت</span></button>
                                <p v-show="$root.btnLoadingCheckStatus" class="my-button my-success float-left"><i class="fas fa-spinner fa-pulse btn-txt-mrg"></i></p>
                            </div>
                        </form>
                    </div>
                </modal-tiny>
                <!--Insert found Modal End-->
                <!--Insert found Modal Start-->
                <modal-tiny v-if="showUpdateFoundModal" @close="showUpdateFoundModal = false" xmlns:v-on="http://www.w3.org/1999/xhtml">
                    <div  slot="body">
                        <form v-on:submit.prevent="updateProvincialFound">
                            <div class="grid-x">
                                <div class="medium-12 padding-lr">
                                    <label>تاریخ
                                        <date-picker
                                                :color="'#5c6bc0'"
                                                v-model="foundFill.date"
                                                input-class="form-control form-control-lg date-picker-bottom-margin"
                                                id="foundFillDate"
                                                placeholder="انتخاب تاریخ">
                                        </date-picker>
                                    </label>
                                </div>
                            </div>
                            <div style="margin-top: 5px" class="grid-x padding-lr">
                                <div class="medium-12 my-callout-bg-color">
                                    <div class="grid-x">
                                        <div class="medium-12 ">
                                            <span class="btn-red">مبلغ تنخواه:</span><span>{{ ' ' + $parent.calcDispAmount(foundFill.lastAmount) }}</span>
                                        </div>
                                        <div class="medium-12 ">
                                            <span class="btn-red">تعهد شده:</span><span>{{ ' ' + $parent.calcDispAmount(foundFill.sumOfCommitment) }}</span>
                                        </div>
                                        <div class="medium-12 ">
                                            <span class="btn-red">رزرو شده:</span><span>{{ ' ' + $parent.calcDispAmount(foundFill.sumOfReserved) }}</span>
                                        </div>
                                        <div class="medium-12 ">
                                            <span class="btn-red">تبدیل شده:</span><span>{{ ' ' + $parent.calcDispAmount(foundFill.convertedAllocAmount) }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="grid-x">
                                <div class="medium-12 cell padding-lr">
                                    <label>مبلغ تنخواه <span class="btn-red">{{ '(' + $parent.getAmountBaseLabel() + ')' }}</span>
                                        <input class="form-element-margin-btm" type="text"  v-model="foundFill.amount" name="foundAmount" v-validate="'required|min_value:' + minInputAmount" :class="{'input': true, 'select-error': errors.has('foundAmount')}"/>
                                    </label>
                                    <span v-show="errors.has('foundAmount')" class="error-font">مبلغ تنخواه فراموش شده / نا معتبر است!</span>
                                </div>
                            </div>
                            <div class="grid-x">
                                <div class="small-12 columns padding-lr">
                                    <label>شرح
                                        <textarea name="csDescription" style="min-height: 150px;" v-model="foundFill.description"></textarea>
                                    </label>
                                </div>
                            </div>
                            <div class="medium-6 columns padding-lr padding-bottom-modal">
                                <button v-show="!$root.btnLoadingCheckStatus" name="Submit" class="my-button my-success float-left btn-for-load"> <span class="btn-txt-mrg">ثبت</span></button>
                                <p v-show="$root.btnLoadingCheckStatus" class="my-button my-success float-left"><i class="fas fa-spinner fa-pulse btn-txt-mrg"></i></p>
                            </div>
                        </form>
                    </div>
                </modal-tiny>
                <!--Insert found Modal End-->
                <!-- Delete Modal Start -->
                <modal-tiny v-if="showDeleteFoundModal" @close="showDeleteFoundModal = false">
                    <div  slot="body">
                        <div class="small-font">
                            <p>کاربر گرامی</p>
                            <p class="large-offset-1 modal-text">آیا برای حذف این رکورد اطمینان دارید؟</p>
                            <div class="grid-x">
                                <div class="medium-12 column text-center">
                                    <button v-show="!$root.btnLoadingCheckStatus" v-on:click="deleteProvincialFound" class="my-button my-success"><span class="btn-txt-mrg">   بله   </span></button>
                                    <p v-show="$root.btnLoadingCheckStatus" class="my-button my-success"><i class="fas fa-spinner fa-pulse btn-txt-mrg"></i></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </modal-tiny>
                <!-- Delete Modal End -->
                <!--Insert Modal Start-->
                <modal-large v-if="showConvertToModal" @close="showConvertToModal = false" xmlns:v-on="http://www.w3.org/1999/xhtml">
                    <div  slot="body">
                        <form v-on:submit.prevent="convertToAllocation">
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
                                        <select class="form-element-margin-btm" @change="displayCreditResourceInfo(AllocationInput.pcsId)"  v-model="AllocationInput.pcsId" name="credit" v-validate data-vv-rules="required" :class="{'input': true, 'select-error': errors.has('credit')}">
                                            <option value=""></option>
                                            <option v-for="projectCreditSource in projectCreditSources" :value="projectCreditSource.id">{{ projectCreditSource.credit_distribution_row.cdSubject + ' - فصل ' + projectCreditSource.tiny_season.season_title.season.sSubject + ' - ' + projectCreditSource.tiny_season.season_title.castSubject + ' - ' + projectCreditSource.tiny_season.catsSubject + ' - ' + $parent.calcDispAmount(projectCreditSource.ccsAmount) }}</option>
                                        </select>
                                        <span v-show="errors.has('credit')" class="error-font">لطفا اعتبار مصوب را انتخاب کنید!</span>
                                    </label>
                                </div>
                            </div>
                            <div style="margin-top: 10px;" class="grid-x padding-lr" v-show="creditSourceInfo != ''">
                                <div class="medium-6 my-callout-bg-color">
                                    <div class="medium-12">
                                        <span class="btn-red">اعتبار مصوب:</span><span>{{ ' ' + $parent.calcDispAmount(creditSourceInfo.ccsAmount) }}</span>
                                    </div>
                                    <div class="medium-12">
                                        <span class="btn-red">آخرین تخصیص:</span><span>{{ ' ' + $parent.calcDispAmount(creditSourceInfo.ccsSumOfAllocation) }}</span>
                                    </div>
                                    <div class="medium-12">
                                        <span class="btn-red">درصدآخرین تخصیص:</span><span>{{ ' ' + $parent.calcPrecent(creditSourceInfo.ccsAmount , creditSourceInfo.ccsSumOfAllocation) }}</span>
                                    </div>
                                </div>
                                <div class="medium-6 my-callout-bg-color">
                                    <div class="medium-12 ">
                                        <span class="btn-red">مجموع مبالغ انتخاب شده:</span><span>{{ ' ' + $parent.calcDispAmount(sumOfSelectedAmount) }}</span>
                                    </div>
                                    <div class="medium-12 ">
                                        <span class="btn-red">باقیمانده:</span><span>{{ ' ' + $parent.calcDispAmount(creditSourceInfo.ccsAmount - creditSourceInfo.ccsSumOfAllocation - sumOfSelectedAmount) }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="grid-x" style="margin-top: 10px">
                                <div class="medium-8 cell padding-lr">
                                    <label>هزینه <span class="btn-red">{{ '(' + $parent.getAmountBaseLabel() + ')' }}</span>
                                        <div class="tbl-div-container form-element-margin-btm inner-vh-unsize"  style="height: 30vh;">
                                            <table class="tbl-head">
                                                <colgroup>
                                                    <col width="750px"/>
                                                    <col width="200px"/>
                                                    <col v-show="selectColumn" width="15px"/>
                                                    <col width="12px"/>
                                                </colgroup>
                                                <tbody class="tbl-head-style">
                                                <tr class="tbl-head-style-cell">
                                                    <th class="tbl-head-style-cell">عنوان</th>
                                                    <th class="tbl-head-style-cell">مبلغ</th>
                                                    <th class="tbl-head-style-checkbox" v-show="selectColumn"></th>
                                                    <th class="tbl-head-style-cell"></th>
                                                </tr>
                                                </tbody>
                                            </table>
                                            <div class="tbl_body_style inner-vh-2">
                                                <table class="tbl-body-contain">
                                                    <colgroup>
                                                        <col width="750px"/>
                                                        <col width="200px"/>
                                                        <col v-show="selectColumn" width="15px"/>
                                                    </colgroup>
                                                    <tbody class="tbl-head-style-cell">
                                                    <tr class="tbl-head-style-cell" v-for="capFinancing in capFinancings">
                                                        <td>{{ capFinancing.request.rSubject + ' - ' + capFinancing.request.rLetterNumber + ' - ' + capFinancing.request.rLetterDate }}</td>
                                                        <td class="text-center">{{ $parent.calcDispAmount(capFinancing.cafAmount , false) }}</td>
                                                        <td>
                                                            <input class="auto-margin" v-model="capFinancing.checked" @change="checkSelectedAmount(capFinancing.checked ,capFinancing.cafAmount)" type="checkbox">
                                                        </td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <span class="error-font" v-show="unSelectedCost">حداقل یک مورد را از لیست هزینه انتخاب کنید!</span>
                                        <span class="error-font" v-show="overflowError">مجموع مبالغ انتخاب شده از باقیمانده بیشتر است!</span>
                                    </label>
                                </div>
                                <div class="small-4 columns padding-lr">
                                    <label>شرح
                                        <textarea name="csDescription" style="height: 30vh;" v-model="AllocationInput.description"></textarea>
                                    </label>
                                </div>
                            </div>
                            <div class="medium-6 columns padding-lr padding-bottom-modal">
                                <button v-show="!$root.btnLoadingCheckStatus" name="Submit" class="my-button my-success float-left btn-for-load"> <span class="btn-txt-mrg">ثبت</span></button>
                                <p v-show="$root.btnLoadingCheckStatus" class="my-button my-success float-left"><i class="fas fa-spinner fa-pulse btn-txt-mrg"></i></p>
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
                <!--Report Found Modal Start-->
                <modal-tiny v-if="showModalReportFound" @close="showModalReportFound= false">
                    <div  slot="body">
                        <div class="small-font">
                            <form v-on:submit.prevent="foundOpenReportFile">
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
                <!--Report Found Modal End-->
                <!-- report pdf modal -->
                <modal-large v-show="showPdfModal" @close="showPdfModal =false">
                    <div  slot="body">
                        <div class="grid-x">
                            <div class="large-12 medium-12 small-12" style="width: 100%;height: 75vh">
                                <vue-element-loading style="width: 100%;" :active="showLoaderProgress" spinner="line-down" color="#716aca"/>
                                <iframe style="width: 100%;height: 100%;border: 0px" :src="reportPdfPath" />
                            </div>
                        </div>
                    </div>
                </modal-large>
                <!-- end report pdf modal -->
                <!--Forms End-->
                <messageDialog v-show="showDialogModal" @close="showDialogModal =false">
                    {{dialogMessage}}
                </messageDialog>
            </div>
        </div>
    </div>
</template>
<script>
    import VuePagination from '../../../public_component/pagination.vue';
    import VueElementLoading from 'vue-element-loading';
    export default {
        data(){
            return {
                provCapitalAssetsAllocations: [],
                provCapitalAssetsFounds: [],
                natCapitalAssetsAllocations: [],
                selectedCapFinancings: [],
                capFinancings: [],
                AllocationInput: {dueDate: null, symbolOfAkhza: null , dtId: null},
                foundInput: {},
                foundFill: {},
                provOrNat: '',
                costTemp:'',
                itemInPage: 10,
                natItemInPage: 10,
                provSearchValue: '',
                natSearchValue: '',
                showInsertModal: false,
                showInsertFoundModal: false,
                showUpdateFoundModal: false,
                showDeleteFoundModal: false,
                showUpdateModal: false,
                showDeleteModal: false,
                showModalReportFound:false,
                showConvertToModal: false,
                showModalReport:false,
                selectColumn:false,
                unSelectedCost: false,
                dateIsValid_found: true,
                showPdfModal: false,
                AllocationFill: {},
                creditSourceInfo: '',
                aIdForDelete: '',
                fIdForDelete: '',
                approvedPlans: {},
                selectedPlan: '',
                selectedProject: '',
                approvedProjects: {},
                projectCreditSources: {},
                selectedItems: [],
                dueType: [],
                selectedCount: 0,
                reportOptions: {title:'' , withReporterName: true , withFiscalYear: true , withReportDate: true , orientation: true , costLabel:true},
                foundIdForConvertTo: '',
                updateDataThreadNowPlaying: null,
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
                sumOfSelectedAmount: 0,
                overflowError: false,
                maxInputAmount: 1,
                minInputAmount: 1,
                lastPcsId: 0,
                lastAmount: 0,
                dialogMessage:'',
                showDialogModal: false,
                reportPdfPath: '',
                showLoaderProgress: false,
                checkAllocationDateValid:false,
                checkAllocationDueDateValid:false,
            }
        },

        watch: {
            AllocationInput: function (newQuestion, oldQuestion) {
                if(this.AllocationInput.date != null)
                    this.checkAllocationDateValid=false;
                if(this.AllocationInput.dueDate != null)
                {
                    this.checkAllocationDueDateValid=false;
                }
            },
            foundInput: function (newQuestion, oldQuestion) {
                if(this.foundInput.date != null)
                    this.checkAllocationDateValid=false;
            }
        },
        created: function () {
            this.fetchProvincialData();
            this.fetchNationalData();
            this.fetchProvincialFoundData();

            this.setUpdateDataThread();
        },

        updated: function () {
            $(this.$el).foundation(); //WORKS!
            this.costTemp =  ' مبالغ: ' + this.$parent.getDispAmountBaseLabel();
            console.log('...................................... update capital assets allocation');
        },

        mounted: function () {
            console.log("mounted capital assets allocation component");
            this.$parent.myResize();
        },

        beforeDestroy: function () {
            clearInterval(this.updateDataThreadNowPlaying);
            console.log('...................................... kill update data thread');
        },

        components:{
            'vue-pagination' : VuePagination,
            VueElementLoading,
        },

        methods:{
            fetchProvincialData: function (page = 1) {
                axios.get('/budget/allocation/capital_assets/fetchData?page=' + page , {params:{
                    pOrN: 0,
                    searchValue: this.provSearchValue,
                    itemInPage: this.itemInPage
                }})
                    .then((response) => {
                        this.setData(0 , response.data.data);
                        this.makePagination(response.data , "provincial");
                        console.log(response);
                    },(error) => {
                        console.log(error);
                    });
            },

            fetchProvincialFoundData: function () {
                axios.get('/budget/allocation/capital_assets/found/fetchData')
                    .then((response) => {
                        this.foundSetData(response.data);
                        console.log(response);
                    },(error) => {
                        console.log(error);
                    });
            },

            fetchNationalData: function (page = 1) {
                axios.get('/budget/allocation/capital_assets/fetchData?page=' + page , {params:{
                    pOrN: 1,
                    searchValue: this.natSearchValue,
                    itemInPage: this.natItemInPage
                }})
                    .then((response) => {
                        this.setData(1 , response.data.data);
                        this.makePagination(response.data , "national");
                        console.log(response);
                    },(error) => {
                        console.log(error);
                    });
            },

            fetchDueTypeData: function () {
                axios.get('/budget/allocation/capital_assets/due_type/fetchData')
                    .then((response) => {
                        this.dueType = response.data;
                        console.log(response);
                    },(error) => {
                        console.log(error);
                    });
            },

            search: function (type) {
                if (type == 0)
                {
                    this.fetchProvincialData();
                }else{
                    this.fetchNationalData();
                }
            },

            changeItemInPage: function (number , type) {
                if (type == 0)
                {
                    this.itemInPage = number;
                    this.fetchProvincialData();
                }else{
                    this.natItemInPage = number;
                    this.fetchNationalData();
                }
            },

            removeFilter: function (type) {
                if (type == 0)
                {
                    this.provSearchValue = '';
                    this.fetchProvincialData();
                }else{
                    this.natSearchValue = '';
                    this.fetchNationalData();
                }
            },

            setData: function (type , data) {
                if (type == 0)
                {
                    this.provCapitalAssetsAllocations = data;
                    this.selectAll(this.provCapitalAssetsAllocations);
                    console.log(JSON.stringify(this.provCapitalAssetsAllocations));
                }else {
                    this.natCapitalAssetsAllocations = data;
                    this.selectAll(this.natCapitalAssetsAllocations);
                }
            },

            foundSetData: function (data) {
                this.provCapitalAssetsFounds = data;
                this.foundSelectAll(this.provCapitalAssetsFounds);
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

            displayCreditResourceInfo: function (pcsId) {
                axios.get('/budget/allocation/capital_assets/getCapitalAssetsCreditSourceInfo' , {params:{pcsId: pcsId}})
                    .then((response) => {
                        this.creditSourceInfo = response.data;
                        this.maxInputAmount = parseFloat(this.$parent.calcDispAmount(this.creditSourceInfo.ccsAmount - this.creditSourceInfo.ccsSumOfAllocation , false , false));
                        if (this.lastPcsId == pcsId)
                        {
                            this.maxInputAmount += parseFloat(this.lastAmount);
                        }
                        if (this.creditSourceInfo.ccsSumOfReserved + this.creditSourceInfo.ccsSumOfCommitment == 0)
                            this.minInputAmount = 1;
                        else
                            this.minInputAmount = parseFloat(this.$parent.calcDispAmount(this.creditSourceInfo.ccsSumOfReserved + this.creditSourceInfo.ccsSumOfCommitment , false , false));
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
                this.AllocationInput={};
                this.checkAllocationDateValid=false;
                this.checkAllocationDueDateValid=false;
                this.lastPcsId = 0;
                this.approvedPlans = [];
                this.approvedProjects = [];
                this.projectCreditSources = [];
                this.creditSourceInfo = [];
                this.selectedPlan = '';
                this.selectedProject = '';
                this.provOrNat = type;
                this.fetchDueTypeData();
                this.getAllApprovedPlan(type);
                this.showInsertModal = true;
            },

            createCapitalAssetsAllocation: function () {
                this.$validator.validateAll().then((result) => {
                    if(this.AllocationInput.date == null)
                        this.checkAllocationDateValid = true;
                    if(this.AllocationInput.dueDate == null && this.AllocationInput.isPapers)
                        this.checkAllocationDueDateValid = true;
                    else
                        this.checkAllocationDueDateValid = false;
                    if(!this.checkAllocationDateValid && !this.checkAllocationDueDateValid) {
                        if (result) {
                            var config = {
                                allowLoading: true,
                            };
                            axios.post('/budget/allocation/capital_assets/register', {
                                idNumber: this.AllocationInput.idNumber,
                                date: this.AllocationInput.date,
                                pcsId: this.AllocationInput.pcsId,
                                amount: this.AllocationInput.amount,
                                dueDate: this.AllocationInput.dueDate,
                                symbolOfAkhza: this.AllocationInput.symbolOfAkhza,
                                dtId: this.AllocationInput.dtId,
                                description: this.AllocationInput.description,
                                pOrN: this.provOrNat,
                                searchValue: this.provOrNat == 0 ? this.provSearchValue : this.natSearchValue,
                                itemInPage: this.provOrNat == 0 ? this.itemInPage : this.natItemInPage
                            }, config)
                                .then((response) => {
                                    if (this.provOrNat == 0) {
                                        this.setData(0, response.data.data);
                                        this.makePagination(response.data, "provincial");
                                    }
                                    else {
                                        this.setData(1, response.data.data);
                                        this.makePagination(response.data, "national");
                                    }
                                    this.showInsertModal = false;
                                    this.$parent.displayNotif(response.status);
                                    console.log(response);
                                }, (error) => {
                                    console.log(error);
                                    this.showUpdateModal = false;
                                    this.$parent.displayNotif(error.response.status);
                                });
                        }
                    }
                });
            },

            openUpdateModal: function (item , planId , projectId , type) {
                this.checkAllocationDateValid=false;
                this.checkAllocationPurDateValid=false;
                this.clearDueInformation();
                this.creditSourceInfo = '';
                this.AllocationFill.id = item.id;
                if (item.caaFoundId == null)
                {
                    this.AllocationFill.isFound = false;
                }else{
                    this.AllocationFill.isFound = true;
                }
                this.AllocationFill.idNumber = item.caaLetterNumber;
                this.AllocationFill.date = item.caaLetterDate;
                if (item.caaDtId != null)
                    this.AllocationFill.isPapers = true;
                else
                    this.AllocationFill.isPapers = false;
                this.AllocationFill.dueDate = item.caaDueDate;
                this.AllocationFill.dtId = item.caaDtId;
                this.AllocationFill.symbolOfAkhza = item.caaSymbolOfAkhza;
                this.AllocationFill.pcsId = item.caaCcsId;
                this.AllocationFill.amount = this.$parent.calcDispAmount(item.caaAmount , false , false);
                this.lastPcsId = this.AllocationFill.caaCcsId;
                this.lastAmount = this.AllocationFill.amount;
                this.AllocationFill.description = item.caaDescription;
                this.selectedPlan = planId;
                this.selectedProject = projectId;
                this.provOrNat = type;
                this.showUpdateModal = true;
                this.getAllApprovedPlan(type);
                this.getProjects();
                this.getProjectsCreditSource();
                this.fetchDueTypeData()
                this.displayCreditResourceInfo(this.AllocationFill.pcsId);
            },

            updateCapitalAssetsAllocation: function () {
                this.$validator.validateAll().then((result) => {
                    if (result) {
                        var config = {
                            allowLoading:true,
                        };
                        axios.post('/budget/allocation/capital_assets/update' , {
                            id: this.AllocationFill.id,
                            idNumber: this.AllocationFill.idNumber,
                            date: this.AllocationFill.date,
                            pcsId: this.AllocationFill.pcsId,
                            amount: this.AllocationFill.amount,
                            dueDate: this.AllocationFill.dueDate,
                            symbolOfAkhza: this.AllocationFill.symbolOfAkhza,
                            dtId: this.AllocationFill.dtId,
                            description: this.AllocationFill.description,
                            pOrN: this.provOrNat,
                            searchValue: this.provOrNat == 0 ? this.provSearchValue : this.natSearchValue,
                            itemInPage: this.provOrNat == 0 ? this.itemInPage : this.natItemInPage
                        } , config)
                            .then((response) => {
                                if (this.provOrNat == 0)
                                {
                                    this.setData(0 , response.data.data);
                                    this.makePagination(response.data , "provincial");
                                }
                                else
                                {
                                    this.setData(1 , response.data.data);
                                    this.makePagination(response.data , "national");
                                }
                                this.showUpdateModal = false;
                                this.$parent.displayNotif(response.status);
                                console.log(response);
                            },(error) => {
                                console.log(error);
                                this.showUpdateModal = false;
                                this.$parent.displayNotif(error.response.status);
                            });
                    }
                });
            },

            openDeleteModal: function (allocation , type) {
                if (allocation.caaSumOfCommitment == 0 && allocation.caaSumOfReserved == 0)
                {
                    this.aIdForDelete = allocation.id;
                    this.provOrNat = type;
                    this.showDeleteModal = true;
                }else{
                    this.dialogMessage = 'با توجه به اینکه از این محل تعهد و یا مبلغی برای تامین اعتبار رزرو شده است، امکان حذف وجود ندارد.';
                    this.showDialogModal = true;
                }
            },

            deleteCapitalAssetsAllocation: function () {
                var config = {
                    allowLoading:true,
                };
                axios.post('/budget/allocation/capital_assets/delete' , {
                    id: this.aIdForDelete,
                    pOrN: this.provOrNat,
                    searchValue: this.provOrNat == 0 ? this.provSearchValue : this.natSearchValue,
                    itemInPage: this.provOrNat == 0 ? this.itemInPage : this.natItemInPage
                } , config)
                    .then((response) => {
                        if (response.status != 204) {
                            if (this.provOrNat == 0) {
                                this.setData(0, response.data.data);
                                this.makePagination(response.data, "provincial");
                            }
                            else {
                                this.setData(1, response.data.data);
                                this.makePagination(response.data, "national");
                            }
                        }
                        this.showDeleteModal = false;
                        this.$parent.displayNotif(response.status);
                        console.log(response);
                    },(error) => {
                        console.log(error);
                        this.showDeleteModal = false;
                    });
            },

            openInsertFoundModal:function () {
                this.showInsertFoundModal = true;
            },

            createProvincialFound: function () {
                this.$validator.validateAll().then((result) => {
                    if(this.foundInput.date == null)
                        this.checkAllocationDateValid=true;
                    if(!this.checkAllocationDateValid ) {
                        if (result) {
                            var config = {
                                allowLoading: true,
                            };
                            axios.post('/budget/allocation/capital_assets/found/register', {
                                date: this.foundInput.date,
                                amount: this.foundInput.amount,
                                description: this.foundInput.description,
                                pOrN: 0
                            }, config)
                                .then((response) => {
                                    this.foundSetData(response.data);
                                    this.showInsertFoundModal = false;
                                    this.$parent.displayNotif(response.status);
                                    console.log(response);
                                }, (error) => {
                                    console.log(error);
                            });
                        }
                    }
                });
            },

            openFoundUpdateModal: function (item) {
                this.foundFill.id = item.id;
                this.foundFill.date = item.caaLetterDate;
                this.foundFill.amount = this.$parent.calcDispAmount(item.caaAmount , false , false);
                this.foundFill.description = item.caaDescription;
                this.foundFill.lastAmount =  item.caaAmount;
                this.foundFill.sumOfCommitment = item.caaSumOfCommitment;
                this.foundFill.sumOfReserved = item.caaSumOfReserved;
                this.foundFill.convertedAllocAmount = item.caaConvertedAllocAmount;
                this.minInputAmount = (this.foundFill.sumOfCommitment + this.foundFill.sumOfReserved + this.foundFill.convertedAllocAmount) == 0 ? 1 : (this.$parent.calcDispAmount((this.foundFill.sumOfCommitment + this.foundFill.sumOfReserved + this.foundFill.convertedAllocAmount), false, false));
                this.showUpdateFoundModal = true;
            },

            updateProvincialFound: function () {
                this.$validator.validateAll().then((result) => {
                    if (result) {
                        if (this.checkValidDate(this.foundFill)) {
                            var config = {
                                allowLoading:true,
                            };
                            axios.post('/budget/allocation/capital_assets/found/update' , {
                                id: this.foundFill.id,
                                date: this.foundFill.date,
                                amount: this.foundFill.amount,
                                description: this.foundFill.description,
                                pOrN: 0
                            } , config)
                                .then((response) => {
                                    this.foundSetData(response.data);
                                    this.showUpdateFoundModal = false;
                                    this.$parent.displayNotif(response.status);
                                    console.log(response);
                                },(error) => {
                                    console.log(error);
                                });
                        }
                    }
                });
            },

            openFoundDeleteModal: function (fund) {
                if (fund.caaConvertedAllocAmount == 0 && fund.caaSumOfReserved == 0 && fund.caaSumOfCommitment == 0)
                {
                    this.fIdForDelete = fund.id;
                    this.showDeleteFoundModal = true;
                }else{
                    this.dialogMessage = 'در محل تنخواه انتخاب شده تعهد / رزرو / تبدیل به تخصیص، ایجاد شده است، بنابراین امکان حذف وجود ندارد.';
                    this.showDialogModal = true;
                }
            },

            deleteProvincialFound: function () {
                var config = {
                    allowLoading:true,
                };
                axios.post('/budget/allocation/capital_assets/found/delete' , {
                    id: this.fIdForDelete,
                    pOrN: 0
                }  , config)
                    .then((response) => {
                        if (response.status != 204) {
                            this.foundSetData(response.data);
                        }
                        this.showDeleteFoundModal = false;
                        this.$parent.displayNotif(response.status);
                        console.log(response);
                    },(error) => {
                        console.log(error);
                        this.showDeleteFoundModal = false;
                    });
            },

            ////////////// this method created for test convert found to allocation ///////////////////
            getCapitalAssetsCosts: function () {
                axios.get('/budget/allocation/capital_assets/found/get_all_fund_cap_spent' , {params:{fId: this.foundIdForConvertTo}})
                    .then((response) => {
                        this.capFinancings = response.data;
                        this.capFinancings.forEach(cost => {
                            this.$set(cost , 'checked' , false);
                        });
                        console.log(response);
                    },(error) => {
                        console.log(error);
                    });
            },

            convertToAllocation: function () {
                this.$validator.validateAll().then((result) => {
                    if (result) {
                        if (this.checkSelectedCosts(this.capFinancings))
                        {
                            if (this.checkOverflowFundAmount()) {
                                this.selectedCapFinancings = [];
                                this.capFinancings.forEach(cost => {
                                    if (cost.checked)
                                        this.selectedCapFinancings.push(cost);
                                });
                                var config = {
                                    allowLoading:true,
                                };
                                axios.post('/budget/allocation/capital_assets/found/convert_to_allocation', {
                                    id: this.foundIdForConvertTo,
                                    pcsId: this.AllocationInput.pcsId,
                                    amount: this.AllocationInput.amount,
                                    description: this.AllocationInput.description,
                                    capFinancings: this.selectedCapFinancings,
                                    searchValue: this.provOrNat == 0 ? this.provSearchValue : this.natSearchValue,
                                    itemInPage: this.provOrNat == 0 ? this.itemInPage : this.natItemInPage
                                } , config)
                                    .then((response) => {
                                        this.provCapitalAssetsFounds = response.data.found;
                                        this.provCapitalAssetsAllocations = response.data.allocation_prov.data;
                                        this.showConvertToModal = false;
                                        this.$parent.displayNotif(response.status);
                                        console.log(response);
                                    }, (error) => {
                                        console.log(error);
                                    });
                                console.log(JSON.stringify(this.selectedCapFinancings));
                            }else{
                                this.overflowError = true;
                            }
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

            checkOverflowFundAmount: function(){
                if ((this.creditSourceInfo.ccsAmount - this.creditSourceInfo.ccsSumOfAllocation - this.sumOfSelectedAmount) >= 0)
                {
                    return true
                }else{
                    return false;
                }
            },

            openConvertToModal: function (fId) {
                this.capFinancings = [];
                this.approvedPlans = [];
                this.approvedProjects =[];
                this.projectCreditSources = [];
                this.unSelectedCost = false;
                this.selectedPlan = '';
                this.selectedProject = '';
                this.AllocationInput = [];
                this.creditSourceInfo = '';
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

            checkValidDate: function (data) {
                if (data.date == null || data.date == '')
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
                        this.reportOptions.title = 'تنخواه تملک دارایی های سرمایه ای - استانی';
                    }
                    else{
                        this.$parent.displayNotif(800);
                    }
                }

                console.log(JSON.stringify(this.selectedItems));
            },

            openReportFile: function () {
                if (this.reportType == 'pdf')
                {
                    this.reportPdfPath = '';
                    this.showModalReport = false;
                    this.showLoaderProgress = true;
                    this.showPdfModal = true;
                    axios.post('budget/allocation/capital_assets/report' , {pOrN: this.provOrNat ,
                            type: this.reportType ,
                            options: this.reportOptions ,
                            selectedItems: this.selectedItems},
                        {responseType: 'blob'})
                        .then((response) => {
                            var file = new Blob([response.data], {type: 'application/pdf'});
                            var fileURL = window.URL.createObjectURL(file);
                            this.reportPdfPath = fileURL;
                            this.showLoaderProgress = false;
                        },(error) => {
                            this.showLoaderProgress = false;
                            console.log(error);
                        });
                }else{
                    axios.post('budget/allocation/capital_assets/report' , {pOrN: this.provOrNat ,
                        type: this.reportType ,
                        options: this.reportOptions ,
                        selectedItems: this.selectedItems})
                        .then((response) => {
                            window.open(response.data);
                            this.showModalReport = false;
                        },(error) => {
                            console.log(error);
                        });
                }
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

            ////////////////////////////Found Data////////////////////
            foundOpenReportModal: function (type) {
                this.reportType = type;
                this.selectedItems = [];
                if (this.foundSelectedLength(this.provCapitalAssetsFounds) != 0)
                {
                    this.showModalReportFound = true;
                    this.provCapitalAssetsFounds.forEach(plan => {
                        if (plan.checked == true)
                            this.selectedItems.push(plan);
                    });
                    this.reportOptions.title = 'تنخواه تملک دارایی های سرمایه ای استانی';
                }
                else{
                    this.$parent.displayNotif(800);
                }
                console.log(JSON.stringify(this.selectedItems));
            },

            foundOpenReportFile: function () {
                if (this.reportType == 'pdf')
                {
                    this.reportPdfPath = '';
                    this.showModalReportFound = false;
                    this.showLoaderProgress = true;
                    this.showPdfModal = true;
                    axios.post('budget/allocation/capital_assets/found/report' , {type: this.reportType ,
                            options: this.reportOptions ,
                            selectedItems: this.selectedItems},
                        {responseType: 'blob'})
                        .then((response) => {
                            var file = new Blob([response.data], {type: 'application/pdf'});
                            var fileURL = window.URL.createObjectURL(file);
                            this.reportPdfPath = fileURL;
                            this.showLoaderProgress = false;
                        },(error) => {
                            this.showLoaderProgress = false;
                            console.log(error);
                        });
                }else{
                    axios.post('budget/allocation/capital_assets/found/report' , {type: this.reportType ,
                        options: this.reportOptions ,
                        selectedItems: this.selectedItems})
                        .then((response) => {
                            window.open(response.data);
                            this.showModalReport = false;
                        },(error) => {
                            console.log(error);
                        });
                }
            },

            foundShowSelectColumn: function (found) {
                this.foundSelectAll(found);
                if (this.selectColumn)
                {
                    this.selectColumn=false;
                }
                else {
                    this.selectColumn = true;
                }
            },

            foundToggleSelect: function(found) {
                if(found.find(plan => plan.checked)){
                    found.forEach(plan => plan.checked = false)
                } else {
                    found.forEach(plan => plan.checked = true)
                }
            },

            foundAllSelected: function(found) {
                return found.every(function(plan){
                    return plan.checked;
                });
            },

            foundSelectAll: function (found) {
                found.forEach(plan => {
                    this.$set(plan , 'checked' , true);
                });
            },

            foundSelectedLength: function (found) {
                return found.filter(function (value) {
                    return value.checked === true;
                }).length;
            },

            setUpdateDataThread: function () {
                console.log("...................................................... set capital assets allocation update thread");
                if (this.updateDataThreadNowPlaying)
                    clearInterval(this.updateDataThreadNowPlaying);
                this.updateDataThreadNowPlaying = setInterval(this.updateDataThread, 120000);
            },

            updateDataThread: function () {
                console.log("...................................................... capital assets allocation update thread");
                this.fetchProvincialData();
                this.fetchNationalData();
                this.fetchProvincialFoundData();
            },

            checkSelectedAmount: function (state , amount) {
                if (state == true)
                {
                    this.sumOfSelectedAmount += amount;
                }else{
                    this.sumOfSelectedAmount -= amount;
                }
            },

            clearDueInformation: function () {
                this.AllocationInput.symbolOfAkhza = null;
                this.AllocationInput.dueDate = null;
                this.AllocationInput.dtId = null;
                this.AllocationFill.symbolOfAkhza = null;
                this.AllocationFill.dueDate = null;
                this.AllocationFill.dtId = null;
                this.checkAllocationDueDateValid = false;
            },
        }
    }
</script>

