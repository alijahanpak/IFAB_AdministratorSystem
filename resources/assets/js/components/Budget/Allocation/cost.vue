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
                                <span class="show-for-sr">Current: </span> هزینه ای
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
                                    <a v-show="$can('BUDGET_COST_ALLOCATION_INSERT')" class="my-button toolbox-btn small" @click="openInsertModal(0)">جدید</a>
                                    <div v-if="!selectColumn" class="input-group-button toggle-icon-change">
                                        <button type="button" class="my-button my-icon-brand tiny" @click="showSelectColumn(provCostAllocations)"><i class="fa fa-check-square-o size-14" aria-hidden="true"></i></button>
                                    </div>
                                    <div v-if="selectColumn" class="input-group-button toggle-icon-change">
                                        <button type="button" class="my-button my-icon-danger tiny" @click="showSelectColumn(provCostAllocations)"><i class="fa fa-times size-14" aria-hidden="true"></i></button>
                                    </div>
                                    <button class="my-button toolbox-btn small dropdown small sm-btn-align"  type="button" data-toggle="reportDropDownProv">گزارش</button>
                                    <div  style="width: 113px;" class="dropdown-pane dropdown-pane-sm " data-close-on-click="true"  data-hover="true" data-hover-pane="true"  data-position="bottom" data-alignment="left" id="reportDropDownProv" data-dropdown data-auto-focus="true">
                                        <ul class="my-menu small-font ltr-dir">
                                            <li><a  @click="openReportModal(0,'pdf')"><i class="fa fa-file-pdf-o icon-margin-dropdown" aria-hidden="true"></i>PDF</a></li>
                                            <li><a  @click="openReportModal(0,'excel')"><i class="fa fa-file-excel-o icon-margin-dropdown" aria-hidden="true"></i>Excel</a></li>
                                        </ul>
                                    </div>
                                    <button class="my-button toolbox-btn small dropdown small sm-btn-align"  type="button" data-toggle="DropDownProv">تعداد نمایش<span> {{ itemInPage }} </span></button>
                                    <div  style="width: 113px;" class="dropdown-pane dropdown-pane-sm " data-close-on-click="true"  data-hover="true" data-hover-pane="true"  data-position="bottom" data-alignment="left" id="DropDownProv" data-dropdown data-auto-focus="true">
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
                            <!--Table Start-->
                            <!--Table Head Start-->
                            <div class="tbl-div-container">
                                <table class="tbl-head">
                                    <colgroup>
                                        <col width="150px"/>
                                        <col width="150px"/>
                                        <col width="100px"/>
                                        <col width="100px"/>
                                        <col width="150px"/>
                                        <col width="150px"/>
                                        <col width="150px"/>
                                        <col v-show="selectColumn" width="15px"/>
                                        <col width="12px"/>
                                    </colgroup>
                                    <tbody class="tbl-head-style">
                                    <tr class="tbl-head-style-cell">
                                        <th class="tbl-head-style-cell">موافقتنامه</th>
                                        <th class="tbl-head-style-cell">برنامه</th>
                                        <th class="tbl-head-style-cell">سرجمع</th>
                                        <th class="tbl-head-style-cell">ردیف اعتبار</th>
                                        <th class="tbl-head-style-cell">شماره</th>
                                        <th class="tbl-head-style-cell">تاریخ</th>
                                        <th class="tbl-head-style-cell">مبلغ</th>
                                        <th class="tbl-head-style-checkbox" v-show="selectColumn"><input type="checkbox" @click="toggleSelect(provCostAllocations)" :checked="allSelected(provCostAllocations)"></th>
                                        <th class="tbl-head-style-cell"></th>
                                    </tr>
                                    </tbody>
                                </table>
                                <!--Table Head End-->
                                <!--Table Body Start-->
                                <div class="tbl_body_style dynamic-height-level2">
                                    <table class="tbl-body-contain unstriped">
                                        <colgroup>
                                            <col width="150px"/>
                                            <col width="150px"/>
                                            <col width="100px"/>
                                            <col width="100px"/>
                                            <col width="150px"/>
                                            <col width="150px"/>
                                            <col width="150px"/>
                                            <col v-show="selectColumn" width="15px"/>
                                        </colgroup>
                                        <tbody class="tbl-head-style-cell">
                                        <template v-for="(progs, index) in provCostAllocations">
                                            <tr class="tbl-head-style-cell" :style="index % 2 == 1 ? 'background-color: #efefef' : ''">
                                                <td class="text-center" :rowspan="getProjectAllocCount(progs.ca_credit_source_has_allocation)">{{ progs.caLetterNumber }}
                                                    <div v-show="!progs.caActive" class="text-center" style="margin-top: 5px">
                                                        <span class="new-badage">غیر فعال</span>
                                                    </div>
                                                </td>
                                                <td :rowspan="progs.ca_credit_source_has_allocation[0].allocation.length">{{ progs.ca_credit_source_has_allocation[0].credit_distribution_title.cdtIdNumber + ' - ' + progs.ca_credit_source_has_allocation[0].credit_distribution_title.cdtSubject }}</td>
                                                <td v-if="progs.ca_credit_source_has_allocation[0].ccsDeleted" :rowspan="progs.ca_credit_source_has_allocation[0].allocation.length" class="text-center"><span class="comlpleted-badage">حذف شده</span></td>
                                                <td v-if="!progs.ca_credit_source_has_allocation[0].ccsDeleted" :rowspan="progs.ca_credit_source_has_allocation[0].allocation.length" class="text-center">{{ $parent.calcDispAmount(getProgAllocationSum(progs.ca_credit_source_has_allocation[0].allocation) , false) }}</td>
                                                <td class="text-center" :rowspan="progs.ca_credit_source_has_allocation[0].allocation.length">{{ progs.ca_credit_source_has_allocation[0].credit_distribution_row.cdSubject }}</td>
                                                <td v-if="progs.ca_credit_source_has_allocation[0].allocation[0].caFoundId == null" class="text-center">{{ progs.ca_credit_source_has_allocation[0].allocation[0].caLetterNumber }}</td>
                                                <td class="text-center" v-if="progs.ca_credit_source_has_allocation[0].allocation[0].caFoundId != null"><i class="fa fa-exchange btn-red has-tip top" data-tooltip aria-haspopup="true" data-disable-hover="false" title="تبدیل شده از تنخواه"></i></td>
                                                <td class="text-center">{{ progs.ca_credit_source_has_allocation[0].allocation[0].caLetterDate }}</td>
                                                <td class="text-center">
                                                    <div class="grid-x">
                                                        <div class="medium-11">
                                                            {{ $parent.calcDispAmount(progs.ca_credit_source_has_allocation[0].allocation[0].caAmount , false) }}
                                                        </div>
                                                        <div v-show="$can('BUDGET_COST_ALLOCATION_EDIT') || $can('BUDGET_COST_ALLOCATION_DELETE')" class="medium-1 cell-vertical-center text-left">
                                                            <a class="dropdown small sm-btn-align" :data-toggle="'provCostAllocation' + progs.ca_credit_source_has_allocation[0].allocation[0].id"><i class="fa fa-ellipsis-v size-18"></i></a>
                                                            <div class="dropdown-pane dropdown-pane-sm " data-close-on-click="true"  data-hover="true" data-hover-pane="true"  data-position="bottom" data-alignment="right" :id="'provCostAllocation' + progs.ca_credit_source_has_allocation[0].allocation[0].id" data-dropdown data-auto-focus="true">
                                                                <ul class="my-menu small-font text-right">
                                                                    <li v-show="$can('BUDGET_COST_ALLOCATION_EDIT')"><a v-on:click.prevent="openUpdateModal(progs.ca_credit_source_has_allocation[0].allocation[0] , progs.id , 0)"><i class="fa fa-pencil-square-o size-16"></i>  ویرایش</a></li>
                                                                    <li v-show="$can('BUDGET_COST_ALLOCATION_DELETE')"><a v-on:click.prevent="openDeleteModal(progs.ca_credit_source_has_allocation[0].allocation[0] , 0)"><i class="fa fa-trash-o size-16"></i>  حذف</a></li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td  v-show="selectColumn">
                                                    <input class="auto-margin" v-model="progs.ca_credit_source_has_allocation[0].allocation[0].checked" type="checkbox">
                                                </td>
                                            </tr>
                                            <template v-for="(credit_source , csIndex) in progs.ca_credit_source_has_allocation">
                                                <tr class="tbl-head-style-cell" v-if="csIndex > 0" :style="index % 2 == 1 ? 'background-color: #efefef' : ''">
                                                    <td :rowspan="credit_source.allocation.length">{{ credit_source.credit_distribution_title.cdtIdNumber + ' - ' + credit_source.credit_distribution_title.cdtSubject }}</td>
                                                    <td :rowspan="credit_source.allocation.length" class="text-center">{{ $parent.calcDispAmount(getCsAllocationSum(credit_source.allocation) , false) }}</td>
                                                    <td class="text-center" :rowspan="credit_source.allocation.length">{{ credit_source.credit_distribution_row.cdSubject }}</td>
                                                    <td v-if="credit_source.allocation[0].caFoundId == null" class="text-center">{{ credit_source.allocation[0].caLetterNumber }}</td>
                                                    <td class="text-center" v-if="credit_source.allocation[0].caFoundId != null"><i class="fa fa-exchange btn-red has-tip top" data-tooltip aria-haspopup="true" data-disable-hover="false" title="تبدیل شده از تنخواه"></i></td>
                                                    <td class="text-center">{{ credit_source.allocation[0].caLetterDate }}</td>
                                                    <td class="text-center">
                                                        <div class="grid-x">
                                                            <div class="medium-11">
                                                                {{ $parent.calcDispAmount(credit_source.allocation[0].caAmount , false) }}
                                                            </div>
                                                            <div v-show="$can('BUDGET_COST_ALLOCATION_EDIT') || $can('BUDGET_COST_ALLOCATION_DELETE')" class="medium-1 cell-vertical-center text-left">
                                                                <a class="dropdown small sm-btn-align" :data-toggle="'provCostAllocation' + credit_source.allocation[0].id"><i class="fa fa-ellipsis-v size-18"></i></a>
                                                                <div class="dropdown-pane dropdown-pane-sm " data-close-on-click="true"  data-hover="true" data-hover-pane="true"  data-position="bottom" data-alignment="right" :id="'provCostAllocation' + credit_source.allocation[0].id" data-dropdown data-auto-focus="true">
                                                                    <ul class="my-menu small-font text-right">
                                                                        <li v-show="$can('BUDGET_COST_ALLOCATION_EDIT')"><a v-on:click.prevent="openUpdateModal(credit_source.allocation[0] , progs.id , 0)"><i class="fa fa-pencil-square-o size-16"></i>  ویرایش</a></li>
                                                                        <li v-show="$can('BUDGET_COST_ALLOCATION_DELETE')"><a v-on:click.prevent="openDeleteModal(credit_source.allocation[0] , 0)"><i class="fa fa-trash-o size-16"></i>  حذف</a></li>
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
                                                    <tr class="tbl-head-style-cell" v-if="allocIndex > 0" :style="index % 2 == 1 ? 'background-color: #efefef' : ''">
                                                        <td class="text-center" v-if="alloc.caFoundId == null">{{ alloc.caLetterNumber }}</td>
                                                        <td class="text-center" v-if="alloc.caFoundId != null"><i class="fa fa-exchange btn-red has-tip top" data-tooltip aria-haspopup="true" data-disable-hover="false" title="تبدیل شده از تنخواه"></i></td>
                                                        <td class="text-center">{{ alloc.caLetterDate }}</td>
                                                        <td class="text-center">
                                                            <div class="grid-x">
                                                                <div class="medium-11">
                                                                    {{ $parent.calcDispAmount(alloc.caAmount , false) }}
                                                                </div>
                                                                <div v-show="$can('BUDGET_COST_ALLOCATION_EDIT') || $can('BUDGET_COST_ALLOCATION_DELETE')" class="medium-1 cell-vertical-center text-left">
                                                                    <a class="dropdown small sm-btn-align" :data-toggle="'provCostAllocation' + alloc.id"><i class="fa fa-ellipsis-v size-18"></i></a>
                                                                    <div class="dropdown-pane dropdown-pane-sm " data-close-on-click="true"  data-hover="true" data-hover-pane="true"  data-position="bottom" data-alignment="right" :id="'provCostAllocation' + alloc.id" data-dropdown data-auto-focus="true">
                                                                        <ul class="my-menu small-font text-right">
                                                                            <li v-show="$can('BUDGET_COST_ALLOCATION_EDIT')"><a v-on:click.prevent="openUpdateModal(alloc , progs.id , 0)"><i class="fa fa-pencil-square-o size-16"></i>  ویرایش</a></li>
                                                                            <li v-show="$can('BUDGET_COST_ALLOCATION_DELETE')"><a v-on:click.prevent="openDeleteModal(alloc , 0)"><i class="fa fa-trash-o size-16"></i>  حذف</a></li>
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
                                        </tbody>
                                    </table>
                                </div>
                                <!--Table Body End-->
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
                                        <p> تعداد رکورد های انتخاب شده :<span class="selected-row-style">{{ selectedLength(provCostAllocations) }}</span></p>
                                    </div>
                                </div>
                            </div>
                            <!--Table End-->
                        </div>
                    </div>
                    <!--Tab 1 End-->
                    <!--Tab 2 Start-->
                    <div class="tabs-panel table-mrg-btm" id="provincial" xmlns:v-on="http://www.w3.org/1999/xhtml">
                        <div class="medium-12 bottom-mrg">
                            <div class="clearfix tool-bar">
                                <div class="button-group float-right report-mrg">
                                    <a v-show="$can('BUDGET_COST_ALLOCATION_INSERT')" class="my-button toolbox-btn small" @click="openInsertModal(1)">جدید</a>
                                    <div v-if="!selectColumn" class="input-group-button toggle-icon-change">
                                        <button type="button" class="my-button my-icon-brand tiny" @click="showSelectColumn(natCostAllocations)"><i class="fa fa-check-square-o size-14" aria-hidden="true"></i></button>
                                    </div>
                                    <div v-if="selectColumn" class="input-group-button toggle-icon-change">
                                        <button type="button" class="my-button my-icon-danger tiny" @click="showSelectColumn(natCostAllocations)"><i class="fa fa-times size-14" aria-hidden="true"></i></button>
                                    </div>
                                    <button class="my-button toolbox-btn small dropdown small sm-btn-align"  type="button" data-toggle="reportDropDownNat">گزارش</button>
                                    <div  style="width: 113px;" class="dropdown-pane dropdown-pane-sm " data-close-on-click="true"  data-hover="true" data-hover-pane="true"  data-position="bottom" data-alignment="left" id="reportDropDownNat" data-dropdown data-auto-focus="true">
                                        <ul class="my-menu small-font ltr-dir">
                                            <li><a  @click="openReportModal(1,'pdf')"><i class="fa fa-file-pdf-o icon-margin-dropdown" aria-hidden="true"></i>PDF</a></li>
                                            <li><a  @click="openReportModal(1,'excel')"><i class="fa fa-file-excel-o icon-margin-dropdown" aria-hidden="true"></i>Excel</a></li>
                                        </ul>
                                    </div>
                                    <button class="my-button toolbox-btn small dropdown small sm-btn-align"  type="button" data-toggle="DropDownNat">تعداد نمایش<span> {{ natItemInPage }} </span></button>
                                    <div  style="width: 113px;" class="dropdown-pane dropdown-pane-sm " data-close-on-click="true"  data-hover="true" data-hover-pane="true"  data-position="bottom" data-alignment="left" id="DropDownNat" data-dropdown data-auto-focus="true">
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
                            <!--Table Head Start-->
                            <div class="tbl-div-container">
                                <table class="tbl-head">
                                    <colgroup>
                                        <col width="150px"/>
                                        <col width="150px"/>
                                        <col width="100px"/>
                                        <col width="100px"/>
                                        <col width="150px"/>
                                        <col width="150px"/>
                                        <col width="150px"/>
                                        <col v-show="selectColumn" width="15px"/>
                                        <col width="12px"/>
                                    </colgroup>
                                    <tbody class="tbl-head-style ">
                                    <tr class="tbl-head-style-cell">
                                        <th class="tbl-head-style-cell">موافقتنامه</th>
                                        <th class="tbl-head-style-cell">برنامه</th>
                                        <th class="tbl-head-style-cell">سرجمع</th>
                                        <th class="tbl-head-style-cell">ردیف اعتبار</th>
                                        <th class="tbl-head-style-cell">شماره</th>
                                        <th class="tbl-head-style-cell">تاریخ</th>
                                        <th class="tbl-head-style-cell">مبلغ</th>
                                        <th class="tbl-head-style-checkbox" v-show="selectColumn"><input type="checkbox" @click="toggleSelect(natCostAllocations)" :checked="allSelected(natCostAllocations)"></th>
                                        <th class="tbl-head-style-cell"></th>
                                    </tr>
                                    </tbody>
                                </table>
                                <!--Table Head End-->
                                <!--Table Body Start-->
                                <div class="tbl_body_style dynamic-height-level2">
                                    <table class="tbl-body-contain unstriped">
                                        <colgroup>
                                            <col width="150px"/>
                                            <col width="150px"/>
                                            <col width="100px"/>
                                            <col width="100px"/>
                                            <col width="150px"/>
                                            <col width="150px"/>
                                            <col width="150px"/>
                                            <col v-show="selectColumn" width="15px"/>
                                        </colgroup>
                                        <tbody class="tbl-head-style-cell">
                                        <template v-for="(progs , index) in natCostAllocations">
                                            <tr class="tbl-head-style-cell" :style="index % 2 == 1 ? 'background-color: #efefef' : ''">
                                                <td :rowspan="getProjectAllocCount(progs.ca_credit_source_has_allocation)" class="text-center">{{ progs.caLetterNumber }}</td>
                                                <td :rowspan="progs.ca_credit_source_has_allocation[0].allocation.length">{{ progs.ca_credit_source_has_allocation[0].credit_distribution_title.cdtIdNumber + ' - ' + progs.ca_credit_source_has_allocation[0].credit_distribution_title.cdtSubject }}</td>
                                                <td :rowspan="progs.ca_credit_source_has_allocation[0].allocation.length" class="text-center">{{ $parent.calcDispAmount(getProgAllocationSum(progs.ca_credit_source_has_allocation[0].allocation) , false) }}</td>
                                                <td :rowspan="progs.ca_credit_source_has_allocation[0].allocation.length" class="text-center">{{ progs.ca_credit_source_has_allocation[0].credit_distribution_row.cdSubject }}</td>
                                                <td class="text-center">{{ progs.ca_credit_source_has_allocation[0].allocation[0].caLetterNumber }}</td>
                                                <td class="text-center">{{ progs.ca_credit_source_has_allocation[0].allocation[0].caLetterDate }}</td>
                                                <td class="text-center">
                                                    <div class="grid-x">
                                                        <div class="medium-11">
                                                            {{ $parent.calcDispAmount(progs.ca_credit_source_has_allocation[0].allocation[0].caAmount , false) }}
                                                        </div>
                                                        <div v-show="$can('BUDGET_COST_ALLOCATION_EDIT') || $can('BUDGET_COST_ALLOCATION_DELETE')" class="medium-1 cell-vertical-center text-left">
                                                            <a class="dropdown small sm-btn-align" :data-toggle="'natCostAllocation' + progs.ca_credit_source_has_allocation[0].allocation[0].id"><i class="fa fa-ellipsis-v size-18"></i></a>
                                                            <div class="dropdown-pane dropdown-pane-sm " data-close-on-click="true"  data-hover="true" data-hover-pane="true"  data-position="bottom" data-alignment="right" :id="'natCostAllocation' + progs.ca_credit_source_has_allocation[0].allocation[0].id" data-dropdown data-auto-focus="true">
                                                                <ul class="my-menu small-font text-right">
                                                                    <li v-show="$can('BUDGET_COST_ALLOCATION_EDIT')"><a v-on:click.prevent="openUpdateModal(progs.ca_credit_source_has_allocation[0].allocation[0] , progs.id , 1)"><i class="fa fa-pencil-square-o size-16"></i>  ویرایش</a></li>
                                                                    <li v-show="$can('BUDGET_COST_ALLOCATION_DELETE')"><a v-on:click.prevent="openDeleteModal(progs.ca_credit_source_has_allocation[0].allocation[0] , 1)"><i class="fa fa-trash-o size-16"></i>  حذف</a></li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td  v-show="selectColumn">
                                                    <input class="auto-margin" v-model="progs.ca_credit_source_has_allocation[0].allocation[0].checked" type="checkbox">
                                                </td>
                                            </tr>
                                            <template v-for="(credit_source , csIndex) in progs.ca_credit_source_has_allocation">
                                                <tr class="tbl-head-style-cell" v-if="csIndex > 0" :style="index % 2 == 1 ? 'background-color: #efefef' : ''">
                                                    <td :rowspan="credit_source.allocation.length">{{ credit_source.credit_distribution_title.cdtIdNumber + ' - ' + credit_source.credit_distribution_title.cdtSubject }}</td>
                                                    <td :rowspan="credit_source.allocation.length" class="text-center">{{ $parent.calcDispAmount(getCsAllocationSum(credit_source.allocation) , false) }}</td>
                                                    <td :rowspan="credit_source.allocation.length" class="text-center">{{ credit_source.credit_distribution_row.cdSubject }}</td>
                                                    <td class="text-center">{{ credit_source.allocation[0].caLetterNumber }}</td>
                                                    <td class="text-center">{{ credit_source.allocation[0].caLetterDate }}</td>
                                                    <td class="text-center">
                                                        <div class="grid-x">
                                                            <div class="medium-11">
                                                                {{ $parent.calcDispAmount(credit_source.allocation[0].caAmount , false) }}
                                                            </div>
                                                            <div v-show="$can('BUDGET_COST_ALLOCATION_EDIT') || $can('BUDGET_COST_ALLOCATION_DELETE')" class="medium-1 cell-vertical-center text-left">
                                                                <a class="dropdown small sm-btn-align" :data-toggle="'natCostAllocation' + credit_source.allocation[0].id"><i class="fa fa-ellipsis-v size-18"></i></a>
                                                                <div class="dropdown-pane dropdown-pane-sm " data-close-on-click="true"  data-hover="true" data-hover-pane="true"  data-position="bottom" data-alignment="right" :id="'natCostAllocation' + credit_source.allocation[0].id" data-dropdown data-auto-focus="true">
                                                                    <ul class="my-menu small-font text-right">
                                                                        <li v-show="$can('BUDGET_COST_ALLOCATION_EDIT')"><a v-on:click.prevent="openUpdateModal(credit_source.allocation[0] , progs.id , 1)"><i class="fa fa-pencil-square-o size-16"></i>  ویرایش</a></li>
                                                                        <li v-show="$can('BUDGET_COST_ALLOCATION_DELETE')"><a v-on:click.prevent="openDeleteModal(credit_source.allocation[0] , 1)"><i class="fa fa-trash-o size-16"></i>  حذف</a></li>
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
                                                    <tr class="tbl-head-style-cell" v-if="allocIndex > 0" :style="index % 2 == 1 ? 'background-color: #efefef' : ''">
                                                        <td class="text-center">{{ alloc.caLetterNumber }}</td>
                                                        <td class="text-center">{{ alloc.caLetterDate }}</td>
                                                        <td class="text-center">
                                                            <div class="grid-x">
                                                                <div class="medium-11">
                                                                    {{ $parent.calcDispAmount(alloc.caAmount , false) }}
                                                                </div>
                                                                <div v-show="$can('BUDGET_COST_ALLOCATION_EDIT') || $can('BUDGET_COST_ALLOCATION_DELETE')" class="medium-1 cell-vertical-center text-left">
                                                                    <a class="dropdown small sm-btn-align" :data-toggle="'natCostAllocation' + alloc.id"><i class="fa fa-ellipsis-v size-18"></i></a>
                                                                    <div class="dropdown-pane dropdown-pane-sm " data-close-on-click="true"  data-hover="true" data-hover-pane="true"  data-position="bottom" data-alignment="right" :id="'natCostAllocation' + alloc.id" data-dropdown data-auto-focus="true">
                                                                        <ul class="my-menu small-font text-right">
                                                                            <li v-show="$can('BUDGET_COST_ALLOCATION_EDIT')"><a v-on:click.prevent="openUpdateModal(alloc , progs.id , 1)"><i class="fa fa-pencil-square-o size-16"></i>  ویرایش</a></li>
                                                                            <li v-show="$can('BUDGET_COST_ALLOCATION_DELETE')"><a v-on:click.prevent="openDeleteModal(alloc , 1)"><i class="fa fa-trash-o size-16"></i>  حذف</a></li>
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
                                        </tbody>
                                    </table>
                                </div>
                                <!--Table Body End-->
                            </div>
                            <div class="grid-x">
                                <div class="medium-8">
                                    <vue-pagination  v-bind:pagination="national_pagination"
                                                     v-on:click.native="fetchNationalData(national_pagination.current_page)"
                                                     :offset="4">
                                    </vue-pagination>
                                </div>
                                <div style="color: #575962;" v-show="selectColumn" class="medium-4 small-font">
                                    <div class="float-left">
                                        <p> تعداد رکورد های انتخاب شده :<span class="selected-row-style">{{ selectedLength(natCostAllocations) }}</span></p>
                                    </div>
                                </div>
                            </div>
                            <!--Table End-->
                        </div>
                    </div>
                    <!--Tab 2-->
                    <!--Tab 3-->
                    <div class="tabs-panel table-mrg-btm" id="provincialFound" xmlns:v-on="http://www.w3.org/1999/xhtml">
                        <div class="medium-12 bottom-mrg">
                            <div class="clearfix tool-bar">
                                <div style="margin-top: 2px;margin-bottom: 3px;" class="button-group float-right">
                                    <a v-show="$can('BUDGET_COST_FOUND_INSERT')" class="my-button toolbox-btn small" @click="openInsertFoundModal">جدید</a>
                                    <div v-if="!selectColumn" class="input-group-button toggle-icon-change">
                                        <button type="button" class="my-button my-icon-brand tiny" @click="foundShowSelectColumn(provCostFounds)"><i class="fa fa-check-square-o size-14" aria-hidden="true"></i></button>
                                    </div>
                                    <div v-if="selectColumn" class="input-group-button toggle-icon-change">
                                        <button type="button" class="my-button my-icon-danger tiny" @click="foundShowSelectColumn(provCostFounds)"><i class="fa fa-times size-14" aria-hidden="true"></i></button>
                                    </div>
                                    <button class="my-button toolbox-btn small dropdown small sm-btn-align"  type="button" data-toggle="foundReportDropDown">گزارش</button>
                                    <div  style="width: 113px;" class="dropdown-pane dropdown-pane-sm " data-close-on-click="true"  data-hover="true" data-hover-pane="true"  data-position="bottom" data-alignment="left" id="foundReportDropDown" data-dropdown data-auto-focus="true">
                                        <ul class="my-menu small-font ltr-dir">
                                            <li><a  @click="foundOpenReportModal('pdf')"><i class="fa fa-file-pdf-o icon-margin-dropdown" aria-hidden="true"></i>PDF</a></li>
                                            <li><a   @click="foundOpenReportModal('excel')"><i class="fa fa-file-excel-o icon-margin-dropdown" aria-hidden="true"></i>Excel</a></li>
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
                                        <th class="tbl-head-style-checkbox" v-show="selectColumn"><input type="checkbox" @click="foundToggleSelect(provCostFounds)" :checked="foundAllSelected(provCostFounds)"></th>
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
                                        <tr class="tbl-head-style-cell" v-for="found in provCostFounds">
                                            <td class="text-center">{{ found.caLetterDate }}</td>
                                            <td class="text-center">{{ $parent.calcDispAmount(found.caAmount , false) }}</td>
                                            <td class="text-center">{{ $parent.calcDispAmount(found.caSumOfCost , false) }}</td>
                                            <td class="text-center">{{ $parent.calcDispAmount(found.caConvertedAllocAmount , false) }}</td>
                                            <td>
                                                <div class="grid-x">
                                                    <div class="medium-11">
                                                        {{ found.caDescription }}
                                                    </div>
                                                    <div v-show="$can('BUDGET_COST_FOUND_EDIT') || $can('BUDGET_COST_FOUND_DELETE') || $can('BUDGET_COST_FOUND_CONVERT_TO_ALLOCATION')" class="medium-1 cell-vertical-center text-left">
                                                        <a class="dropdown small sm-btn-align" :data-toggle="'costFound' + found.id"><i class="fa fa-ellipsis-v size-18"></i></a>
                                                        <div style="width: 170px" class="dropdown-pane dropdown-pane-sm " data-close-on-click="true"  data-hover="true" data-hover-pane="true"  data-position="bottom" data-alignment="right" :id="'costFound' + found.id" data-dropdown data-auto-focus="true">
                                                            <ul class="my-menu small-font text-right">
                                                                <li v-show="$can('BUDGET_COST_FOUND_EDIT')"><a v-on:click.prevent="openUpdateFoundModal(found)"><i class="fa fa-newspaper-o size-16"></i>  ویرایش</a></li>
                                                                <li v-show="$can('BUDGET_COST_FOUND_DELETE')"><a v-on:click.prevent="openDeleteFoundModal(found)"><i class="fa fa-trash-o size-16"></i>  حذف</a></li>
                                                                <li v-show="$can('BUDGET_COST_FOUND_CONVERT_TO_ALLOCATION')"><a v-on:click.prevent="openConvertToModal(found)"><i class="fa fa-trash-o size-16"></i>  تبدیل به تخصیص</a></li>
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
                            <div class="grid-x">
                                <div style="color: #575962;" v-show="selectColumn" class="medium-12 small-font">
                                    <div class="float-left">
                                        <p> تعداد رکورد های انتخاب شده :<span class="selected-row-style">{{ foundSelectedLength(provCostFounds) }}</span></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--Tab 3-->
                </div>
                <!--Forms Start-->
                <!--Insert Modal Start-->
                <modal-small v-if="showInsertModal" @close="showInsertModal = false" xmlns:v-on="http://www.w3.org/1999/xhtml">
                    <div  slot="body">
                        <form v-on:submit.prevent="createCostAllocation">
                            <div class="grid-x">
                                <div class="large-6 medium-6 small-12 padding-lr">
                                    <label>شماره نامه
                                        <input class="form-element-margin-btm" type="text" name="letterNumber" v-model="AllocationInput.idNumber">
                                    </label>
                                </div>
                                <div class="large-6 medium-6 small-12 padding-lr">
                                    <label>تاریخ
                                        <date-picker
                                                :color="checkAllocationDateValid ? '#d9534f' : '#5c6bc0'"
                                                v-model="AllocationInput.date"
                                                input-class="form-control form-control-lg date-picker-bottom-margin"
                                                id="AllocationInputDate"
                                                placeholder="انتخاب تاریخ">
                                        </date-picker>
                                    </label>
                                    <p style="margin-top:3px !important;" v-show="checkAllocationDateValid" class="error-font">لطفا تاریخ مورد نظر را انتخاب نمایید!</p>
                                </div>
                            </div>
                            <div class="grid-x">
                                <div class="large-12 medium-12 small-12 cell padding-lr">
                                    <label>موافقت نامه
                                        <select class="form-element-margin-btm"  v-model="selectedCostAgreement" v-on:change="getCreditSource" name="approved" v-validate data-vv-rules="required" :class="{'input': true, 'select-error': errors.has('approved')}">
                                            <option value=""></option>
                                            <option v-for="costAgreement in costAgreements" :value="costAgreement.id">{{ 'موافقتنامه شماره ' + costAgreement.caLetterNumber + '  ابلاغ شده در تاریخ  ' + costAgreement.caLetterDate}}</option>
                                        </select>
                                        <span v-show="errors.has('approved')" class="error-font">لطفا موافقت نامه را انتخاب کنید!</span>
                                    </label>
                                </div>
                            </div>
                            <div class="grid-x">
                                <div class="medium-6 cell padding-lr">
                                    <label>اعتبار مصوب
                                        <select class="form-element-margin-btm" @change="displayCreditResourceInfo(AllocationInput.caCsId)"  v-model="AllocationInput.caCsId" name="credit" v-validate data-vv-rules="required" :class="{'input': true, 'select-error': errors.has('credit')}">
                                            <option value=""></option>
                                            <option v-for="caCreditSource in caCreditSources" :value="caCreditSource.id">{{ caCreditSource.credit_distribution_title.cdtSubject + ' - ' + caCreditSource.credit_distribution_row.cdSubject + ' - ' + caCreditSource.tiny_season.season_title.season.sSubject + ' - ' + caCreditSource.tiny_season.season_title.cstSubject + ' - ' + caCreditSource.tiny_season.ctsSubject + ' - ' + $parent.calcDispAmount(caCreditSource.ccsAmount) }}</option>
                                        </select>
                                        <span v-show="errors.has('credit')" class="error-font">لطفا اعتبار مصوب را انتخاب کنید!</span>
                                    </label>
                                </div>
                                <div class="medium-6 cell padding-lr">
                                    <label>مبلغ تخصیص <span class="btn-red">(میلیون ریال)</span>
                                        <input class="form-element-margin-btm" type="text"  v-model="AllocationInput.amount" name="creditCost" v-validate="'required|decimal|min_value:1|max_value:' + maxInputAmount" :class="{'input': true, 'select-error': errors.has('creditCost')}"/>
                                    </label>
                                    <span v-show="errors.has('creditCost')" class="error-font">مبلغ تخصیص فراموش شده / نا معتبر است!</span>
                                </div>
                            </div>
                            <div style="margin-top: 5px" class="grid-x padding-lr" v-show="creditSourceInfo != ''">
                                <div class="medium-12 my-callout-bg-color">
                                    <div class="grid-x">
                                        <div class="medium-12 ">
                                            <span class="btn-red">اعتبار مصوب:</span><span>{{ ' ' + $parent.calcDispAmount(creditSourceInfo.ccsAmount) }}</span>
                                        </div>
                                        <div class="medium-12">
                                            <span class="btn-red">آخرین تخصیص:</span><span>{{ ' ' + $parent.calcDispAmount(creditSourceInfo.ccsSumOfAllocation) }}</span>
                                        </div>
                                        <div class="medium-12">
                                            <span class="btn-red">درصدآخرین تخصیص:</span><span>{{ ' ' + $parent.calcPrecent(creditSourceInfo.ccsAmount , creditSourceInfo.ccsSumOfAllocation) }}</span>
                                        </div>
                                        <div class="medium-12 ">
                                            <span class="btn-red">باقی مانده:</span><span>{{ ' ' + $parent.calcDispAmount(creditSourceInfo.ccsAmount - creditSourceInfo.ccsSumOfAllocation) }}</span>
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
                                <button v-show="!$root.btnLoadingCheckStatus" name="Submit" class="my-button my-success float-left btn-for-load"> <span class="btn-txt-mrg">ثبت</span></button>
                                <p v-show="$root.btnLoadingCheckStatus" class="my-button my-success float-left"><i class="fas fa-spinner fa-pulse btn-txt-mrg"></i></p>
                            </div>
                        </form>
                    </div>
                </modal-small>
                <!--Insert Modal End-->
                <!--update Modal Start-->
                <modal-small v-if="showUpdateModal" @close="showUpdateModal = false" xmlns:v-on="http://www.w3.org/1999/xhtml">
                    <div  slot="body">
                        <form v-on:submit.prevent="updateCostAllocation">
                            <div class="grid-x">
                                <div class="large-6 medium-6 small-12 padding-lr">
                                    <label>شماره نامه
                                        <input class="form-element-margin-btm" type="text" name="letterNumber" v-model="AllocationFill.idNumber">
                                    </label>
                                </div>
                                <div class="large-6 medium-6 small-12 padding-lr">
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
                                <div class="large-12 medium-12 small-12 cell padding-lr">
                                    <label>موافقت نامه
                                        <select class="form-element-margin-btm"  v-model="selectedCostAgreement" v-on:change="getCreditSource" name="approved" v-validate data-vv-rules="required" :class="{'input': true, 'select-error': errors.has('approved')}">
                                            <option value=""></option>
                                            <option v-for="costAgreement in costAgreements" :value="costAgreement.id">{{ 'موافقتنامه شماره ' + costAgreement.caLetterNumber + '  ابلاغ شده در تاریخ  ' + costAgreement.caLetterDate}}</option>
                                        </select>
                                        <span v-show="errors.has('approved')" class="error-font">لطفا موافقت نامه را انتخاب کنید!</span>
                                    </label>
                                </div>
                            </div>
                            <div class="grid-x">
                                <div class="medium-6 cell padding-lr">
                                    <label>اعتبار مصوب
                                        <select class="form-element-margin-btm" @change="displayCreditResourceInfo(AllocationFill.caCsId)"  v-model="AllocationFill.caCsId" name="credit" v-validate data-vv-rules="required" :class="{'input': true, 'select-error': errors.has('credit')}">
                                            <option value=""></option>
                                            <option v-for="caCreditSource in caCreditSources" :value="caCreditSource.id">{{ caCreditSource.credit_distribution_title.cdtSubject + ' - ' + caCreditSource.credit_distribution_row.cdSubject + ' - ' + caCreditSource.tiny_season.season_title.season.sSubject + ' - ' + caCreditSource.tiny_season.season_title.cstSubject + ' - ' + caCreditSource.tiny_season.ctsSubject + ' - ' + $parent.calcDispAmount(caCreditSource.ccsAmount) }}</option>
                                        </select>
                                        <span v-show="errors.has('credit')" class="error-font">لطفا اعتبار مصوب را انتخاب کنید!</span>
                                    </label>
                                </div>
                                <div class="medium-6 cell padding-lr">
                                    <label>مبلغ تخصیص <span class="btn-red">(میلیون ریال)</span>
                                        <input :disabled="AllocationFill.isFound" class="form-element-margin-btm" type="text"  v-model="AllocationFill.amount" name="creditCost" v-validate="'required|decimal|min_value:' + minInputAmount + '|max_value:' + maxInputAmount" :class="{'input': true, 'select-error': errors.has('creditCost')}"/>
                                    </label>
                                    <span v-show="errors.has('creditCost')" class="error-font">مبلغ تخصیص فراموش شده / نا معتبر است!</span>
                                </div>
                            </div>
                            <div style="margin-top: 10px" class="grid-x padding-lr" v-show="creditSourceInfo != ''">
                                <div class="medium-12 my-callout-bg-color">
                                    <div class="grid-x">
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
                                                <span class="btn-red">باقی مانده:</span><span>{{ ' ' + $parent.calcDispAmount(creditSourceInfo.ccsAmount - creditSourceInfo.ccsSumOfAllocation) }}</span>
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
                            <div class="grid-x">
                                <div class="small-12 columns padding-lr">
                                    <label>شرح
                                        <textarea name="csDescription" style="min-height: 150px;" v-model="AllocationFill.description"></textarea>
                                    </label>
                                </div>
                            </div>
                            <div class="medium-6 columns padding-lr padding-bottom-modal">
                                <button v-show="!$root.btnLoadingCheckStatus" name="Submit" class="my-button my-success float-left btn-for-load"> <span class="btn-txt-mrg">ثبت</span></button>
                                <p v-show="$root.btnLoadingCheckStatus" class="my-button my-success float-left"><i class="fas fa-spinner fa-pulse btn-txt-mrg"></i></p>
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
                                    <button v-show="!$root.btnLoadingCheckStatus" v-on:click="deleteCostAllocation" class="my-button my-success"><span class="btn-txt-mrg">   بله   </span></button>
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
                                        <!--<date-picker v-on:closed="checkValidDate(foundInput)" errMessage="تاریخ دریافت تنخواه فراموش شده است!" :isValid="dateIsValid_found"-->
                                        <date-picker
                                                :color="checkAllocationDateValid ? '#d9534f' : '#5c6bc0'"
                                                v-model="foundInput.date"
                                                input-class="form-control form-control-lg date-picker-bottom-margin"
                                                id="foundInputDate"
                                                placeholder="انتخاب تاریخ">
                                        </date-picker>
                                    </label>
                                    <p style="margin-top:3px !important;" v-show="checkAllocationDateValid" class="error-font">لطفا تاریخ مورد نظر را انتخاب نمایید!</p>
                                </div>
                            </div>
                            <div class="grid-x">
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
                <!--update found Modal Start-->
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
                                <button name="Submit" class="my-button my-success float-left btn-for-load"> <span class="btn-txt-mrg">ثبت</span></button>
                            </div>
                        </form>
                    </div>
                </modal-tiny>
                <!--update found Modal End-->
                <!-- Delete Modal Start -->
                <modal-tiny v-if="showDeleteFoundModal" @close="showDeleteFoundModal = false">
                    <div  slot="body">
                        <div class="small-font">
                            <p>کاربر گرامی</p>
                            <p class="large-offset-1 modal-text">آیا برای حذف این رکورد اطمینان دارید؟</p>
                            <div class="grid-x">
                                <div class="medium-12 column text-center">
                                    <button v-on:click="deleteFound" class="my-button my-success"><span class="btn-txt-mrg">   بله   </span></button>
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
                                    <label>موافقت نامه
                                        <select class="form-element-margin-btm"  v-model="selectedCostAgreement" v-on:change="getCreditSource" name="approved" v-validate data-vv-rules="required" :class="{'input': true, 'select-error': errors.has('approved')}">
                                            <option value=""></option>
                                            <option v-for="costAgreement in costAgreements" :value="costAgreement.id">{{ 'موافقتنامه شماره ' + costAgreement.caLetterNumber + '  ابلاغ شده در تاریخ  ' + costAgreement.caLetterDate}}</option>
                                        </select>
                                        <span v-show="errors.has('approved')" class="error-font">لطفا موافقت نامه را انتخاب کنید!</span>
                                    </label>
                                </div>
                                <div class="medium-6 cell padding-lr">
                                    <label>اعتبار مصوب
                                        <select class="form-element-margin-btm" @change="displayCreditResourceInfo(AllocationInput.caCsId)"  v-model="AllocationInput.caCsId" name="credit" v-validate data-vv-rules="required" :class="{'input': true, 'select-error': errors.has('credit')}">
                                            <option value=""></option>
                                            <option v-for="caCreditSource in caCreditSources" :value="caCreditSource.id">{{ caCreditSource.credit_distribution_title.cdtSubject + ' - ' + caCreditSource.credit_distribution_row.cdSubject + ' - ' + caCreditSource.tiny_season.season_title.season.sSubject + ' - ' + caCreditSource.tiny_season.season_title.cstSubject + ' - ' + caCreditSource.tiny_season.ctsSubject + ' - ' + $parent.calcDispAmount(caCreditSource.ccsAmount) }}</option>
                                        </select>
                                        <span v-show="errors.has('credit')" class="error-font">لطفا اعتبار مصوب را انتخاب کنید!</span>
                                    </label>
                                </div>
                            </div>
                            <div style="margin-top: 10px;" class="grid-x padding-lr" v-show="creditSourceInfo != ''">
                                <div class="medium-6 my-callout-bg-color">
                                    <div class="medium-12 ">
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
                                        <span class="btn-red">باقی مانده:</span><span>{{ ' ' + $parent.calcDispAmount(creditSourceInfo.ccsAmount - creditSourceInfo.ccsSumOfAllocation - sumOfSelectedAmount) }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="grid-x" style="margin-top: 10px">
                                <div class="medium-8 cell padding-lr">
                                    <label>هزینه <span class="btn-red">{{ '(' + $parent.getAmountBaseLabel() + ')' }}</span>
                                        <div class="tbl-div-container form-element-margin-btm inner-vh-unsize"  style="height: 40vh;">
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
                                                        <tr class="tbl-head-style-cell" v-for="costFinancing in costFinancings">
                                                            <td>{{ costFinancing.request.rSubject + ' - ' + costFinancing.request.rLetterNumber + ' - ' + costFinancing.request.rLetterDate }}</td>
                                                            <td class="text-center">{{ $parent.calcDispAmount(costFinancing.cfAmount , false) }}</td>
                                                            <td>
                                                                <input class="auto-margin" v-model="costFinancing.checked" @change="checkSelectedAmount(costFinancing.checked ,costFinancing.cfAmount)" type="checkbox">
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <span class="error-font" v-show="unSelectedCost">حداقل یک مورد را از لیست هزینه انتخاب کنید!</span>
                                        <span class="error-font" v-show="overflowError">مجموع مبالغ انتخاب شده از باقی مانده بیشتر است!</span>
                                    </label>
                                </div>
                                <div class="small-4 columns padding-lr">
                                    <label>شرح
                                        <textarea name="csDescription" style="height: 40vh;" v-model="AllocationInput.description"></textarea>
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
                                                <input checked="true" class="switch-input" id="yes-no-3" type="checkbox" v-model="reportOptions.withReportDate">
                                                <label class="switch-paddle" for="yes-no-3">
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
                                                <input checked="true" class="switch-input" id="yes-no-4" type="checkbox" v-model="reportOptions.orientation">
                                                <label class="switch-paddle" for="yes-no-4">
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
                                                <input checked="true" class="switch-input" id="yes-no1" v-model="reportOptions.withReporterName" type="checkbox">
                                                <label class="switch-paddle" for="yes-no1">
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
                                                <input checked="true" class="switch-input" id="yes-no2" type="checkbox" v-model="reportOptions.withFiscalYear">
                                                <label class="switch-paddle" for="yes-no2">
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
                provCostAllocations: [],
                natCostAllocations: [],
                provCostFounds: [],
                costFinancings: [],
                selectedCostFinance: [],
                AllocationInput: {},
                foundInput: {},
                foundFill: {},
                provOrNat: '',
                costTemp:'',
                itemInPage: 10,
                natItemInPage: 10,
                provSearchValue: '',
                natSearchValue: '',
                dialogMessage:'',
                showDialogModal: false,
                showInsertModal: false,
                showUpdateModal: false,
                showDeleteModal: false,
                showModalReport:false,
                showPdfModal: false,
                selectColumn:false,
                showInsertFoundModal: false,
                showUpdateFoundModal: false,
                showDeleteFoundModal: false,
                showConvertToModal: false,
                showModalReportFound:false,
                maxInputAmount: 0,
                minInputAmount: 0,
                lastCaCsId: 0,
                lastAmount: 0,
                AllocationFill: {},
                creditSourceInfo: '',
                caIdForDelete: '',
                foundIdForDelete: '',
                approvedPlans: {},
                selectedCostAgreement: '',
                costAgreements: {},
                caCreditSources: {},
                dateIsValid_found: true,
                unSelectedCost: false,
                selectedItems: [],
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
                reportPdfPath: '',
                showLoaderProgress: false,
                checkAllocationDateValid:false,
            }
        },

        watch: {
            AllocationInput: function (newQuestion, oldQuestion) {
            if(this.AllocationInput.date != null)
                this.checkAllocationDateValid=false;
            },
            foundInput: function (newQuestion, oldQuestion) {
            if(this.foundInput.date != null)
                this.checkAllocationDateValid=false;
            }
        },

        created: function () {
            this.fetchProvincialData();
            this.fetchProvincialFoundData();
            this.fetchNationalData();

            this.setUpdateDataThread();
        },

        updated: function () {
            $(this.$el).foundation(); //WORKS!
            this.costTemp =  ' مبالغ: ' + this.$parent.getDispAmountBaseLabel();
        },

        mounted: function () {
            console.log("mounted Cost allocation component");
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
                axios.get('/budget/allocation/cost/fetchData?page=' + page , {params:{
                    pOrN: 0,
                    searchValue: this.provSearchValue,
                    itemInPage: this.itemInPage
                }})
                    .then((response) => {
                        this.setData(0,response.data.data);
                        this.makePagination(response.data , "provincial");
                        console.log(response);
                    },(error) => {
                        console.log(error);
                    });
            },

            fetchProvincialFoundData: function () {
                axios.get('/budget/allocation/cost/found/fetchData')
                    .then((response) => {
                        this.foundSetData(response.data);
                        console.log(response);
                    },(error) => {
                        console.log(error);
                    });
            },

            fetchNationalData: function (page = 1) {
                axios.get('/budget/allocation/cost/fetchData?page=' + page , {params:{
                    pOrN: 1,
                    searchValue: this.natSearchValue,
                    itemInPage: this.natItemInPage
                }})
                    .then((response) => {
                        this.setData(1,response.data.data);
                        this.makePagination(response.data , "national");
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
                    this.provCostAllocations = data;
                    this.selectAll(this.provCostAllocations);
                    console.log(JSON.stringify(this.provCostAllocations));
                }else {
                    this.natCostAllocations = data;
                    this.selectAll(this.natCostAllocations);
                }
            },

            foundSetData: function (data) {
                this.provCostFounds = data;
                this.foundSelectAll(this.provCostFounds);
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

            displayCreditResourceInfo: function (caCsId) {
                axios.get('/budget/allocation/cost/getCostCreditSourceInfo' , {params:{caCsId: caCsId}})
                    .then((response) => {
                        this.creditSourceInfo = response.data;
                        this.maxInputAmount = parseFloat(this.$parent.calcDispAmount(this.creditSourceInfo.ccsAmount - this.creditSourceInfo.ccsSumOfAllocation , false , false));
                        if (this.lastCaCsId == caCsId)
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

            getProgAllocationSum: function (allocation) {
                var sum = 0;
                allocation.forEach(alloc => {
                    sum += alloc.caAmount;
                });
                return sum;
            },

            getCsAllocationSum: function (allocs) {
                var sum = 0;
                allocs.forEach(alloc => {
                    sum += alloc.caAmount;
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
                this.checkAllocationDateValid=false;
                this.lastCaCsId = 0;
                this.creditSourceInfo = '';
                this.AllocationInput = [];
                this.costAgreements = [];
                this.caCreditSources = [];
                this.selectedCostAgreement = '';
                this.provOrNat = type;
                this.getAllCostAgreements(type);
                this.showInsertModal = true;
            },

            createCostAllocation: function () {
                this.$validator.validateAll().then((result) => {
                    if(this.AllocationInput.date == null)
                        this.checkAllocationDateValid=true;
                    if(!this.checkAllocationDateValid ) {
                        if (result) {
                            var config = {
                                allowLoading:true,
                            };
                            axios.post('/budget/allocation/cost/register', {
                                idNumber: this.AllocationInput.idNumber,
                                date: this.AllocationInput.date,
                                caCsId: this.AllocationInput.caCsId,
                                amount: this.AllocationInput.amount,
                                description: this.AllocationInput.description,
                                pOrN: this.provOrNat,
                                searchValue: this.provOrNat == 0 ? this.provSearchValue : this.natSearchValue,
                                itemInPage: this.provOrNat == 0 ? this.itemInPage : this.natItemInPage
                            } , config)
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

                                });
                        }
                    }
                });
            },

            openUpdateModal: function (item , progId , type) {
                this.AllocationFill.id = item.id;
                if (item.caFoundId == null)
                {
                    this.AllocationFill.isFound = false;
                }else{
                    this.AllocationFill.isFound = true;
                }
                this.checkAllocationDateValid=false;
                this.AllocationFill.idNumber = item.caLetterNumber;
                this.AllocationFill.date = item.caLetterDate;
                this.AllocationFill.caCsId = item.caCcsId;
                this.lastCaCsId = this.AllocationFill.caCsId;
                this.AllocationFill.amount = this.$parent.calcDispAmount(item.caAmount , false , false);
                this.lastAmount = this.AllocationFill.amount;
                this.AllocationFill.description = item.caDescription;
                this.selectedCostAgreement = progId;
                this.showUpdateModal = true;
                this.displayCreditResourceInfo(this.AllocationFill.caCsId);
                this.getCreditSource();
                this.provOrNat = type;
                this.getAllCostAgreements(type);
            },

            updateCostAllocation: function () {
                this.$validator.validateAll().then((result) => {
                    if (result) {
                        var config = {
                            allowLoading:true,
                        };
                        axios.post('/budget/allocation/cost/update' , {
                            id: this.AllocationFill.id,
                            idNumber: this.AllocationFill.idNumber,
                            date: this.AllocationFill.date,
                            caCsId: this.AllocationFill.caCsId,
                            amount: this.AllocationFill.amount,
                            description: this.AllocationFill.description,
                            pOrN: this.provOrNat,
                            searchValue: this.provOrNat == 0 ? this.provSearchValue : this.natSearchValue,
                            itemInPage: this.provOrNat == 0 ? this.itemInPage : this.natItemInPage
                        } , config)
                            .then((response) => {
                                if (this.provOrNat == 0)
                                {
                                    this.setData(0,response.data.data);
                                    this.makePagination(response.data , "provincial");
                                }
                                else
                                {
                                    this.setData(1,response.data.data);
                                    this.makePagination(response.data , "national");
                                }
                                this.showUpdateModal = false;
                                this.$parent.displayNotif(response.status);
                                console.log(response);
                            },(error) => {
                                console.log(error);
                            });
                    }
                });
            },

            openDeleteModal: function (allocation , type) {
                if (allocation.caSumOfCommitment == 0 && allocation.caSumOfReserved == 0)
                {
                    this.provOrNat = type;
                    this.caIdForDelete = allocation.id;
                    this.showDeleteModal = true;
                }else{
                    this.dialogMessage = 'با توجه به اینکه از این محل تعهد و یا مبلغی برای تامین اعتبار رزرو شده است، امکان حذف وجود ندارد.';
                    this.showDialogModal = true;
                }
            },

            deleteCostAllocation: function () {
                var config = {
                    allowLoading:true,
                };
                axios.post('/budget/allocation/cost/delete' , {
                    id: this.caIdForDelete,
                    pOrN: this.provOrNat,
                    searchValue: this.provOrNat == 0 ? this.provSearchValue : this.natSearchValue,
                    itemInPage: this.provOrNat == 0 ? this.itemInPage : this.natItemInPage
                    } , config)
                    .then((response) => {
                        if (response.status != 204)
                        {
                            if (this.provOrNat == 0)
                            {
                                this.setData(0,response.data.data);
                                this.makePagination(response.data , "provincial");
                            }
                            else
                            {
                                this.setData(1,response.data.data);
                                this.makePagination(response.data , "national");
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

            ////////////// this method created for test convert found to allocation ///////////////////
            getCostSpents: function () {
                axios.get('/budget/allocation/cost/found/get_all_fund_cost_spent' , {params:{fId: this.foundIdForConvertTo}})
                    .then((response) => {
                        this.costFinancings = response.data;
                        this.costFinancings.forEach(cost => {
                            this.$set(cost , 'checked' , false);
                        });
                        console.log(response);
                    },(error) => {
                        console.log(error);
                    });
            },

            openInsertFoundModal:function () {
                this.foundInput = [];
                this.checkAllocationDateValid=false;
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
                            if (this.checkValidDate(this.foundInput)) {
                                axios.post('/budget/allocation/cost/found/register', {
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
                    }
                });
            },

            openUpdateFoundModal: function (item) {
                this.foundFill.id = item.id;
                this.foundFill.date = item.caLetterDate;
                this.foundFill.amount = this.$parent.calcDispAmount(item.caAmount , false , false);
                this.foundFill.description = item.caDescription;
                this.foundFill.lastAmount =  item.caAmount;
                this.foundFill.sumOfCommitment = item.caSumOfCommitment;
                this.foundFill.sumOfReserved = item.caSumOfReserved;
                this.foundFill.convertedAllocAmount = item.caConvertedAllocAmount;
                this.minInputAmount = (this.foundFill.sumOfCommitment + this.foundFill.sumOfReserved + this.foundFill.convertedAllocAmount) == 0 ? 1 : (this.$parent.calcDispAmount((this.foundFill.sumOfCommitment + this.foundFill.sumOfReserved + this.foundFill.convertedAllocAmount), false, false));
                this.showUpdateFoundModal = true;
            },

            updateProvincialFound: function () {
                this.$validator.validateAll().then((result) => {
                    if (result) {
                        if (this.checkValidDate(this.foundFill)) {
                            axios.post('/budget/allocation/cost/found/update' , {
                                        id: this.foundFill.id,
                                        date: this.foundFill.date,
                                        amount: this.foundFill.amount,
                                        description: this.foundFill.description,
                                        pOrN: 0
                                    })
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

            openDeleteFoundModal: function (fund) {
                if (fund.caConvertedAllocAmount == 0 && fund.caSumOfReserved == 0 && fund.caSumOfCommitment == 0)
                {
                    this.foundIdForDelete = fund.id;
                    this.showDeleteFoundModal = true;
                }else{
                    this.dialogMessage = 'در محل تنخواه انتخاب شده تعهد / رزرو / تبدیل به تخصیص، ایجاد شده است، بنابراین امکان حذف وجود ندارد.';
                    this.showDialogModal = true;
                }
            },

            deleteFound: function () {
                axios.post('/budget/allocation/cost/found/delete' , {
                            id: this.foundIdForDelete,
                            pOrN: 0
                        }).then((response) => {
                        if (response.status != 204)
                            this.foundSetData(response.data);
                        this.showDeleteFoundModal = false;
                        this.$parent.displayNotif(response.status);
                        console.log(response);
                    },(error) => {
                        console.log(error);
                        this.showDeleteFoundModal = false;
                    });
            },

            convertToAllocation: function () {
                this.$validator.validateAll().then((result) => {
                    if (result) {
                        if (this.checkSelectedCosts(this.costFinancings))
                        {
                            if (this.checkOverflowFundAmount())
                            {
                                this.selectedCostFinance = [];
                                this.costFinancings.forEach(cost => {
                                    if (cost.checked)
                                        this.selectedCostFinance.push(cost);
                                });
                                var config = {
                                    allowLoading:true,
                                };
                                axios.post('/budget/allocation/cost/found/convert_to_allocation' , {
                                    id: this.foundIdForConvertTo,
                                    caCsId: this.AllocationInput.caCsId,
                                    amount: this.AllocationInput.amount,
                                    description: this.AllocationInput.description,
                                    costFinancings: this.selectedCostFinance,
                                    searchValue: this.provSearchValue,
                                    itemInPage: this.itemInPage
                                } , config)
                                    .then((response) => {
                                        this.provCostFounds = response.data.found;
                                        this.provCostAllocations = response.data.allocation_prov.data;
                                        this.showConvertToModal = false;
                                        this.$parent.displayNotif(response.status);
                                        console.log(response);
                                    },(error) => {
                                        console.log(error);
                                    });
                                console.log(JSON.stringify(this.selectedCostFinance));
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

            checkOverflowFundAmount: function(){
                if ((this.creditSourceInfo.ccsAmount - this.creditSourceInfo.ccsSumOfAllocation - this.sumOfSelectedAmount) >= 0)
                {
                    return true
                }else{
                    return false;
                }
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

            openConvertToModal: function (fund) {
                this.costFinancings = [];
                this.costAgreements = [];
                this.caCreditSources = [];
                this.unSelectedCost = false;
                this.selectedCostAgreement = '';
                this.AllocationInput = [];
                this.creditSourceInfo = '';
                this.showConvertToModal = true;
                this.foundIdForConvertTo = fund.id;
                this.getCostSpents();
                this.getAllCostAgreements(0);
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

            openReportModal: function (proOrNat , type) {
                this.provOrNat = proOrNat;
                this.reportType = type;
                this.selectedItems = [];
                var isSelected=false;
                if (proOrNat == 0)
                {
                    if (this.selectedLength(this.provCostAllocations) != 0)
                    {
                        this.showModalReport = true;
                        this.provCostAllocations.forEach(plan => {
                            plan.ca_credit_source_has_allocation.forEach(credit_source => {
                                credit_source.allocation.forEach(alloc =>{
                                    if (alloc.checked == true)
                                        isSelected=true;
                                });
                            });
                            if (isSelected){
                                this.selectedItems.push(plan);
                                isSelected=false;
                            }

                        });
                        this.reportOptions.title = 'تخصیص اعتبار هزینه ای استانی';
                    }
                    else{
                        this.$parent.displayNotif(800);
                    }
                }
                else{
                    if (this.selectedLength(this.natCostAllocations) != 0)
                    {
                        this.showModalReport = true;
                        this.natCostAllocations.forEach(plan => {
                            plan.ca_credit_source_has_allocation.forEach(credit_source => {
                                credit_source.allocation.forEach(alloc =>{
                                    if (alloc.checked == true)
                                        isSelected=true;
                                });
                            });
                            if (isSelected){
                                this.selectedItems.push(plan);
                                isSelected=false;
                            }

                        });
                        this.reportOptions.title = 'تخصیص اعتبار هزینه ای ملی';
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
                    axios.post('budget/allocation/cost/report' , {pOrN: this.provOrNat ,
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
                    axios.post('budget/allocation/cost/report' , {pOrN: this.provOrNat ,
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

            showSelectColumn: function (progs) {
                this.selectAll(progs);
                if (this.selectColumn)
                {
                    this.selectColumn=false;
                }
                else {
                    this.selectColumn = true;
                }
            },


            toggleSelect: function(progs) {
                var temp = false;
                progs.forEach(plan => {
                    plan.ca_credit_source_has_allocation.forEach(credit_source => {
                        credit_source.allocation.forEach(alloc =>{
                            if (alloc.checked)
                                temp = true;
                        });
                    });
                });
                progs.forEach(plan => {
                    if(temp){
                        plan.ca_credit_source_has_allocation.forEach(credit_source => {
                            credit_source.allocation.forEach(alloc =>{
                                alloc.checked = false;
                            });
                        });
                    } else {
                        plan.ca_credit_source_has_allocation.forEach(credit_source => {
                            credit_source.allocation.forEach(alloc =>{
                                alloc.checked = true;
                            });
                        });
                    }
                });
                console.log(JSON.stringify(this.provCapitalAssetsAllocations));
            },

            allSelected: function(progs) {
                var temp = true;
                console.log(JSON.stringify(this.provCapitalAssetsAllocations));
                progs.forEach(plan => {
                    plan.ca_credit_source_has_allocation.forEach(credit_source => {
                        credit_source.allocation.forEach(alloc =>{
                            if (alloc.checked == false)
                                temp = false;
                        });
                    });
                });
                return temp;
            },

            selectAll: function (progs) {
                progs.forEach(plan => {
                    plan.ca_credit_source_has_allocation.forEach(credit_source => {
                        credit_source.allocation.forEach(alloc =>{
                                this.$set(alloc, 'checked' , true);
                        });
                    });
                });
            },

            selectedLength: function (progs) {
                var counter=0;
                progs.forEach(plan => {
                    plan.ca_credit_source_has_allocation.forEach(credit_source => {
                        credit_source.allocation.forEach(alloc =>{
                            counter+=alloc.checked;
                        });
                    });
                });
                return counter;
            },

            ////////////////////////////Found Data////////////////////
            foundOpenReportModal: function (type) {
                this.reportType = type;
                this.selectedItems = [];
                if (this.foundSelectedLength(this.provCostFounds) != 0)
                {
                    this.showModalReportFound = true;
                    this.provCostFounds.forEach(plan => {
                        if (plan.checked == true)
                            this.selectedItems.push(plan);
                    });
                    this.reportOptions.title = 'تنخواه هزینه ای - استانی';
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
                    axios.post('budget/allocation/cost/found/report' , {type: this.reportType ,
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
                    axios.post('budget/allocation/cost/found/report' , {type: this.reportType ,
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
                console.log("...................................................... set cost allocation update thread");
                if (this.updateDataThreadNowPlaying)
                    clearInterval(this.updateDataThreadNowPlaying);
                this.updateDataThreadNowPlaying = setInterval(this.updateDataThread, 120000);
            },

            updateDataThread: function () {
                console.log("...................................................... cost allocation update thread");
                this.fetchProvincialData();
                this.fetchProvincialFoundData();
                this.fetchNationalData();
            },

            checkSelectedAmount: function (state , amount) {
                if (state == true)
                {
                    this.sumOfSelectedAmount += amount;
                }else{
                    this.sumOfSelectedAmount -= amount;
                }
            }

        }
    }
</script>
