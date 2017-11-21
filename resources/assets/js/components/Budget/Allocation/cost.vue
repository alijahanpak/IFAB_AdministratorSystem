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
                                        <div class="inner-addon right-addon">
                                            <i v-if="searchProvValue == ''" class="fa fa-search purple-color"  aria-hidden="true"></i>
                                            <i v-if="searchProvValue != ''" class="fa fa-close btn-red"  aria-hidden="true"></i>
                                            <input v-model="searchProvValue" class="search" type="text" placeholder="جستوجو">
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
                                        <th class="tbl-head-style-checkbox" v-show="selectColumn"><input id="checkboxColumn" type="checkbox"></th>
                                        <th class="tbl-head-style-cell"></th>
                                    </tr>
                                    </tbody>
                                </table>
                                <!--Table Head End-->
                                <!--Table Body Start-->
                                <div class="tbl_body_style dynamic-height-level2">
                                    <table class="tbl-body-contain">
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
                                        <template v-for="progs in provCostAllocations">
                                            <tr class="tbl-head-style-cell" >
                                                <td :rowspan="getProjectAllocCount(progs.ca_credit_source_has_allocation)">{{ progs.caLetterNumber }}
                                                    <div v-show="!progs.caActive" class="text-center" style="margin-top: 5px">
                                                        <span class="new-badage">غیر فعال</span>
                                                    </div>
                                                </td>
                                                <td :rowspan="progs.ca_credit_source_has_allocation[0].allocation.length">{{ progs.ca_credit_source_has_allocation[0].credit_distribution_title.cdtIdNumber + ' - ' + progs.ca_credit_source_has_allocation[0].credit_distribution_title.cdtSubject }}</td>
                                                <td v-if="progs.ca_credit_source_has_allocation[0].ccsDeleted" :rowspan="progs.ca_credit_source_has_allocation[0].allocation.length" class="text-center"><span class="comlpleted-badage">حذف شده</span></td>
                                                <td v-if="!progs.ca_credit_source_has_allocation[0].ccsDeleted" :rowspan="progs.ca_credit_source_has_allocation[0].allocation.length" class="text-center">{{ $parent.calcDispAmount(getProgAllocationSum(progs.ca_credit_source_has_allocation) , false) }}</td>
                                                <td :rowspan="progs.ca_credit_source_has_allocation[0].allocation.length">{{ progs.ca_credit_source_has_allocation[0].credit_distribution_row.cdSubject }}</td>
                                                <td v-if="progs.ca_credit_source_has_allocation[0].allocation[0].caFoundId == null">{{ progs.ca_credit_source_has_allocation[0].allocation[0].caLetterNumber }}</td>
                                                <td class="text-center" v-if="progs.ca_credit_source_has_allocation[0].allocation[0].caFoundId != null"><i class="fa fa-exchange btn-red has-tip top" data-tooltip aria-haspopup="true" data-disable-hover="false" title="تبدیل شده از تنخواه"></i></td>
                                                <td>{{ progs.ca_credit_source_has_allocation[0].allocation[0].caLetterDate }}</td>
                                                <td>
                                                    <div class="grid-x">
                                                        <div class="medium-11">
                                                            {{ $parent.calcDispAmount(progs.ca_credit_source_has_allocation[0].allocation[0].caAmount , false) }}
                                                        </div>
                                                        <div class="medium-1 cell-vertical-center text-left">
                                                            <a class="dropdown small sm-btn-align"  type="button" :data-toggle="'provCostAllocation' + progs.ca_credit_source_has_allocation[0].allocation[0].id"><i class="fa fa-ellipsis-v size-18"></i></a>
                                                            <div class="dropdown-pane dropdown-pane-sm " data-close-on-click="true"  data-hover="true" data-hover-pane="true"  data-position="bottom" data-alignment="right" :id="'provCostAllocation' + progs.ca_credit_source_has_allocation[0].allocation[0].id" data-dropdown data-auto-focus="true">
                                                                <ul class="my-menu small-font text-right">
                                                                    <li><a v-on:click.prevent="openUpdateModal(progs.ca_credit_source_has_allocation[0].allocation[0] , progs.id , 0)"><i class="fa fa-pencil-square-o size-16"></i>  ویرایش</a></li>
                                                                    <li><a v-on:click.prevent="openDeleteModal(progs.ca_credit_source_has_allocation[0].allocation[0].id , 0)"><i class="fa fa-trash-o size-16"></i>  حذف</a></li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td  v-show="selectColumn">
                                                    <input class="auto-margin" type="checkbox">
                                                </td>
                                            </tr>
                                            <template v-for="(credit_source , csIndex) in progs.ca_credit_source_has_allocation">
                                                <tr class="tbl-head-style-cell" v-if="csIndex > 0">
                                                    <td :rowspan="credit_source.allocation.length">{{ credit_source.credit_distribution_title.cdtIdNumber + ' - ' + credit_source.credit_distribution_title.cdtSubject }}</td>
                                                    <td :rowspan="credit_source.allocation.length" class="text-center">{{ $parent.calcDispAmount(getCsAllocationSum(credit_source.allocation) , false) }}</td>
                                                    <td :rowspan="credit_source.allocation.length">{{ credit_source.credit_distribution_row.cdSubject }}</td>
                                                    <td v-if="credit_source.allocation[0].caFoundId == null">{{ credit_source.allocation[0].caLetterNumber }}</td>
                                                    <td class="text-center" v-if="credit_source.allocation[0].caFoundId != null"><i class="fa fa-exchange btn-red has-tip top" data-tooltip aria-haspopup="true" data-disable-hover="false" title="تبدیل شده از تنخواه"></i></td>
                                                    <td>{{ credit_source.allocation[0].caLetterDate }}</td>
                                                    <td>
                                                        <div class="grid-x">
                                                            <div class="medium-11">
                                                                {{ $parent.calcDispAmount(credit_source.allocation[0].caAmount , false) }}
                                                            </div>
                                                            <div class="medium-1 cell-vertical-center text-left">
                                                                <a class="dropdown small sm-btn-align"  type="button" :data-toggle="'provCostAllocation' + credit_source.allocation[0].id"><i class="fa fa-ellipsis-v size-18"></i></a>
                                                                <div class="dropdown-pane dropdown-pane-sm " data-close-on-click="true"  data-hover="true" data-hover-pane="true"  data-position="bottom" data-alignment="right" :id="'provCostAllocation' + credit_source.allocation[0].id" data-dropdown data-auto-focus="true">
                                                                    <ul class="my-menu small-font text-right">
                                                                        <li><a v-on:click.prevent="openUpdateModal(credit_source.allocation[0] , progs.id , 0)"><i class="fa fa-pencil-square-o size-16"></i>  ویرایش</a></li>
                                                                        <li><a v-on:click.prevent="openDeleteModal(credit_source.allocation[0].id , 0)"><i class="fa fa-trash-o size-16"></i>  حذف</a></li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <template v-for="(alloc , allocIndex) in credit_source.allocation">
                                                    <tr class="tbl-head-style-cell" v-if="allocIndex > 0">
                                                        <td v-if="alloc.caFoundId == null">{{ alloc.caLetterNumber }}</td>
                                                        <td class="text-center" v-if="alloc.caFoundId != null"><i class="fa fa-exchange btn-red has-tip top" data-tooltip aria-haspopup="true" data-disable-hover="false" title="تبدیل شده از تنخواه"></i></td>
                                                        <td>{{ alloc.caLetterDate }}</td>
                                                        <td>
                                                            <div class="grid-x">
                                                                <div class="medium-11">
                                                                    {{ $parent.calcDispAmount(alloc.caAmount , false) }}
                                                                </div>
                                                                <div class="medium-1 cell-vertical-center text-left">
                                                                    <a class="dropdown small sm-btn-align"  type="button" :data-toggle="'provCostAllocation' + alloc.id"><i class="fa fa-ellipsis-v size-18"></i></a>
                                                                    <div class="dropdown-pane dropdown-pane-sm " data-close-on-click="true"  data-hover="true" data-hover-pane="true"  data-position="bottom" data-alignment="right" :id="'provCostAllocation' + alloc.id" data-dropdown data-auto-focus="true">
                                                                        <ul class="my-menu small-font text-right">
                                                                            <li><a v-on:click.prevent="openUpdateModal(alloc , progs.id , 0)"><i class="fa fa-pencil-square-o size-16"></i>  ویرایش</a></li>
                                                                            <li><a v-on:click.prevent="openDeleteModal(alloc.id , 0)"><i class="fa fa-trash-o size-16"></i>  حذف</a></li>
                                                                        </ul>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td  v-show="selectColumn">
                                                            <input class="auto-margin" type="checkbox">
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
                                <div class="medium-12">
                                    <vue-pagination  v-bind:pagination="provincial_pagination"
                                                     v-on:click.native="fetchProvincialData(provincial_pagination.current_page)"
                                                     :offset="4">
                                    </vue-pagination>
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
                                        <div class="inner-addon right-addon">
                                            <i v-if="searchNatValue == ''" class="fa fa-search purple-color"  aria-hidden="true"></i>
                                            <i v-if="searchNatValue != ''" class="fa fa-close btn-red"  aria-hidden="true"></i>
                                            <input v-model="searchNatValue" class="search" type="text" placeholder="جستوجو">
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
                                        <th class="tbl-head-style-checkbox" v-show="selectColumn"><input type="checkbox"></th>
                                        <th class="tbl-head-style-cell"></th>
                                    </tr>
                                    </tbody>
                                </table>
                                <!--Table Head End-->
                                <!--Table Body Start-->
                                <div class="tbl_body_style dynamic-height-level2">
                                    <table class="tbl-body-contain">
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
                                        <template v-for="progs in natCostAllocations">
                                            <tr class="tbl-head-style-cell" >
                                                <td :rowspan="getProjectAllocCount(progs.ca_credit_source_has_allocation)">{{ progs.caLetterNumber }}</td>
                                                <td :rowspan="progs.ca_credit_source_has_allocation[0].allocation.length">{{ progs.ca_credit_source_has_allocation[0].credit_distribution_title.cdtIdNumber + ' - ' + progs.ca_credit_source_has_allocation[0].credit_distribution_title.cdtSubject }}</td>
                                                <td :rowspan="progs.ca_credit_source_has_allocation[0].allocation.length" class="text-center">{{ $parent.calcDispAmount(getProgAllocationSum(progs.ca_credit_source_has_allocation) , false) }}</td>
                                                <td :rowspan="progs.ca_credit_source_has_allocation[0].allocation.length">{{ progs.ca_credit_source_has_allocation[0].credit_distribution_row.cdSubject }}</td>
                                                <td>{{ progs.ca_credit_source_has_allocation[0].allocation[0].caLetterNumber }}</td>
                                                <td>{{ progs.ca_credit_source_has_allocation[0].allocation[0].caLetterDate }}</td>
                                                <td>
                                                    <div class="grid-x">
                                                        <div class="medium-11">
                                                            {{ $parent.calcDispAmount(progs.ca_credit_source_has_allocation[0].allocation[0].caAmount , false) }}
                                                        </div>
                                                        <div class="medium-1 cell-vertical-center text-left">
                                                            <a class="dropdown small sm-btn-align"  type="button" :data-toggle="'natCostAllocation' + progs.ca_credit_source_has_allocation[0].allocation[0].id"><i class="fa fa-ellipsis-v size-18"></i></a>
                                                            <div class="dropdown-pane dropdown-pane-sm " data-close-on-click="true"  data-hover="true" data-hover-pane="true"  data-position="bottom" data-alignment="right" :id="'natCostAllocation' + progs.ca_credit_source_has_allocation[0].allocation[0].id" data-dropdown data-auto-focus="true">
                                                                <ul class="my-menu small-font text-right">
                                                                    <li><a v-on:click.prevent="openUpdateModal(progs.ca_credit_source_has_allocation[0].allocation[0] , progs.id , 1)"><i class="fa fa-pencil-square-o size-16"></i>  ویرایش</a></li>
                                                                    <li><a v-on:click.prevent="openDeleteModal(progs.ca_credit_source_has_allocation[0].allocation[0].id , 1)"><i class="fa fa-trash-o size-16"></i>  حذف</a></li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td  v-show="selectColumn">
                                                    <input class="auto-margin" id="checkboxNational" type="checkbox">
                                                </td>
                                            </tr>
                                            <template v-for="(credit_source , csIndex) in progs.ca_credit_source_has_allocation">
                                                <tr class="tbl-head-style-cell" v-if="csIndex > 0">
                                                    <td :rowspan="credit_source.allocation.length">{{ credit_source.credit_distribution_title.cdtIdNumber + ' - ' + credit_source.credit_distribution_title.cdtSubject }}</td>
                                                    <td :rowspan="credit_source.allocation.length" class="text-center">{{ $parent.calcDispAmount(getCsAllocationSum(credit_source.allocation) , false) }}</td>
                                                    <td :rowspan="credit_source.allocation.length">{{ credit_source.credit_distribution_row.cdSubject }}</td>
                                                    <td>{{ credit_source.allocation[0].caLetterNumber }}</td>
                                                    <td>{{ credit_source.allocation[0].caLetterDate }}</td>
                                                    <td>
                                                        <div class="grid-x">
                                                            <div class="medium-11">
                                                                {{ $parent.calcDispAmount(credit_source.allocation[0].caAmount , false) }}
                                                            </div>
                                                            <div class="medium-1 cell-vertical-center text-left">
                                                                <a class="dropdown small sm-btn-align"  type="button" :data-toggle="'natCostAllocation' + credit_source.allocation[0].id"><i class="fa fa-ellipsis-v size-18"></i></a>
                                                                <div class="dropdown-pane dropdown-pane-sm " data-close-on-click="true"  data-hover="true" data-hover-pane="true"  data-position="bottom" data-alignment="right" :id="'natCostAllocation' + credit_source.allocation[0].id" data-dropdown data-auto-focus="true">
                                                                    <ul class="my-menu small-font text-right">
                                                                        <li><a v-on:click.prevent="openUpdateModal(credit_source.allocation[0] , progs.id , 1)"><i class="fa fa-pencil-square-o size-16"></i>  ویرایش</a></li>
                                                                        <li><a v-on:click.prevent="openDeleteModal(credit_source.allocation[0].id , 1)"><i class="fa fa-trash-o size-16"></i>  حذف</a></li>
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
                                                                    <a class="dropdown small sm-btn-align"  type="button" :data-toggle="'natCostAllocation' + alloc.id"><i class="fa fa-ellipsis-v size-18"></i></a>
                                                                    <div class="dropdown-pane dropdown-pane-sm " data-close-on-click="true"  data-hover="true" data-hover-pane="true"  data-position="bottom" data-alignment="right" :id="'natCostAllocation' + alloc.id" data-dropdown data-auto-focus="true">
                                                                        <ul class="my-menu small-font text-right">
                                                                            <li><a v-on:click.prevent="openUpdateModal(alloc , progs.id , 1)"><i class="fa fa-pencil-square-o size-16"></i>  ویرایش</a></li>
                                                                            <li><a v-on:click.prevent="openDeleteModal(alloc.id , 1)"><i class="fa fa-trash-o size-16"></i>  حذف</a></li>
                                                                        </ul>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td  v-show="selectColumn">
                                                            <input class="auto-margin" type="checkbox">
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
                                <div class="medium-12">
                                    <vue-pagination  v-bind:pagination="national_pagination"
                                                     v-on:click.native="fetchNationalData(national_pagination.current_page)"
                                                     :offset="4">
                                    </vue-pagination>
                                </div>
                            </div>
                            <!--Table End-->
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
                                    <button class="my-button toolbox-btn small dropdown small sm-btn-align"  type="button" data-toggle="foundReportDropDown">گزارش</button>
                                    <div  style="width: 113px;" class="dropdown-pane dropdown-pane-sm " data-close-on-click="true"  data-hover="true" data-hover-pane="true"  data-position="bottom" data-alignment="left" id="foundReportDropDown" data-dropdown data-auto-focus="true">
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
                                                    <div class="medium-1 cell-vertical-center text-left">
                                                        <a class="dropdown small sm-btn-align" :data-toggle="'costFound' + found.id"  type="button"><i class="fa fa-ellipsis-v size-18"></i></a>
                                                        <div style="width: 170px" class="dropdown-pane dropdown-pane-sm " data-close-on-click="true"  data-hover="true" data-hover-pane="true"  data-position="bottom" data-alignment="right" :id="'costFound' + found.id" data-dropdown data-auto-focus="true">
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
                <modal-small v-if="showInsertModal" @close="showInsertModal = false" xmlns:v-on="http://www.w3.org/1999/xhtml">
                    <div  slot="body">
                        <form v-on:submit.prevent="createCostAllocation">
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
                                <div class="medium-8 cell padding-lr">
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
                                        <select class="form-element-margin-btm" @change="displayCreditResourceInfo"  v-model="AllocationInput.caCsId" name="credit" v-validate data-vv-rules="required" :class="{'input': true, 'select-error': errors.has('credit')}">
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
                            <div style="margin-top: 5px" class="grid-x" v-show="creditSourceInfo.approvedAmount">
                                <div class="medium-12 my-callout-bg-color">
                                    <div class="grid-x">
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
                <!--update Modal Start-->
                <modal-small v-if="showUpdateModal" @close="showUpdateModal = false" xmlns:v-on="http://www.w3.org/1999/xhtml">
                    <div  slot="body">
                        <form v-on:submit.prevent="updateCostAllocation">
                            <div class="grid-x">
                                <div class="medium-4 padding-lr">
                                    <label>شماره نامه
                                        <input class="form-element-margin-btm" type="text" name="letterNumber" v-model="AllocationFill.idNumber">
                                    </label>
                                </div>
                                <div class="medium-4 padding-lr">
                                    <p class="date-picker-lbl">تاریخ نامه
                                        <pdatepicker id="updateDatePicker" v-model="AllocationFill.date"  open-transition-animation="left-slide-fade"></pdatepicker>
                                    </p>
                                </div>
                            </div>
                            <div class="grid-x">
                                <div class="medium-8 cell padding-lr">
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
                                        <select class="form-element-margin-btm" @change="displayCreditResourceInfo"  v-model="AllocationFill.caCsId" name="credit" v-validate data-vv-rules="required" :class="{'input': true, 'select-error': errors.has('credit')}">
                                            <option value=""></option>
                                            <option v-for="caCreditSource in caCreditSources" :value="caCreditSource.id">{{ caCreditSource.credit_distribution_title.cdtSubject + ' - ' + caCreditSource.credit_distribution_row.cdSubject + ' - ' + caCreditSource.tiny_season.season_title.season.sSubject + ' - ' + caCreditSource.tiny_season.season_title.cstSubject + ' - ' + caCreditSource.tiny_season.ctsSubject + ' - ' + $parent.calcDispAmount(caCreditSource.ccsAmount) }}</option>
                                        </select>
                                        <span v-show="errors.has('credit')" class="error-font">لطفا اعتبار مصوب را انتخاب کنید!</span>
                                    </label>
                                </div>
                                <div class="medium-6 cell padding-lr">
                                    <label>مبلغ تخصیص <span class="btn-red">(میلیون ریال)</span>
                                        <input :disabled="AllocationFill.isFound" class="form-element-margin-btm" type="text"  v-model="AllocationFill.amount" name="creditCost" v-validate data-vv-rules="required" :class="{'input': true, 'select-error': errors.has('creditCost')}"/>
                                    </label>
                                    <span v-show="errors.has('creditCost')" class="error-font">لطفا مبلغ تخصیص انتخاب کنید!</span>
                                </div>
                            </div>
                            <div style="margin-top: 5px" class="grid-x" v-show="creditSourceInfo.approvedAmount">
                                <div class="medium-12 my-callout-bg-color">
                                    <div class="grid-x">
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
                                    <button v-on:click="deleteCostAllocation" class="my-button my-success"><span class="btn-txt-mrg">   بله   </span></button>
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
                                        <select class="form-element-margin-btm" @change="displayCreditResourceInfo"  v-model="AllocationInput.caCsId" name="credit" v-validate data-vv-rules="required" :class="{'input': true, 'select-error': errors.has('credit')}">
                                            <option value=""></option>
                                            <option v-for="caCreditSource in caCreditSources" :value="caCreditSource.id">{{ caCreditSource.credit_distribution_title.cdtSubject + ' - ' + caCreditSource.credit_distribution_row.cdSubject + ' - ' + caCreditSource.tiny_season.season_title.season.sSubject + ' - ' + caCreditSource.tiny_season.season_title.cstSubject + ' - ' + caCreditSource.tiny_season.ctsSubject + ' - ' + $parent.calcDispAmount(caCreditSource.ccsAmount) }}</option>
                                        </select>
                                        <span v-show="errors.has('credit')" class="error-font">لطفا اعتبار مصوب را انتخاب کنید!</span>
                                    </label>
                                </div>
                            </div>
                            <div style="margin-top: 5px;margin-bottom: 10px" class="grid-x" v-show="creditSourceInfo.approvedAmount">
                                <div class="medium-12 my-callout-bg-color">
                                    <div class="grid-x">
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
                                                    <tr class="tbl-head-style-cell" v-for="exCost in expenseCosts">
                                                        <td>{{ exCost.ecSubject }}</td>
                                                        <td class="text-center">{{ $parent.calcDispAmount(exCost.ecAmount , false) }}</td>
                                                        <td>{{ exCost.ecDescription }}</td>
                                                        <td>
                                                            <input class="auto-margin" v-model="exCost.checked" type="checkbox">
                                                        </td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <span class="error-font" v-show="unSelectedCost">حداقل یک مورد را از لیست هزینه انتخاب کنید!</span>
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
                provCostFounds: [],
                expenseCosts: [],
                selectedCosts: [],
                AllocationInput: {},
                foundInput: {},
                provOrNat: '',
                searchProvValue:'',
                searchNatValue:'',
                showInsertModal: false,
                showUpdateModal: false,
                showDeleteModal: false,
                selectColumn:false,
                showInsertFoundModal: false,
                showConvertToModal: false,
                AllocationFill: {},
                creditSourceInfo: {},
                caIdForDelete: '',
                approvedPlans: {},
                selectedCostAgreement: '',
                costAgreements: {},
                caCreditSources: {},
                dateIsValid_found: true,
                unSelectedCost: false,
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
            this.fetchProvincialFoundData();
            this.fetchNationalData();
        },


        updated: function () {
            $(this.$el).foundation(); //WORKS!
            this.$parent.userIsActive();
        },

        mounted: function () {
            console.log("mounted Cost allocation component");
            this.$parent.myResize();
        },

        components:{
            'vue-pagination' : VuePagination,
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

            fetchProvincialFoundData: function () {
                axios.get('/budget/allocation/cost/found/fetchData')
                    .then((response) => {
                        this.provCostFounds = response.data;
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
                axios.get('/budget/allocation/cost/getCostCreditSourceInfo' , {params:{caCsId: this.AllocationInput.caCsId}})
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
                this.AllocationInput = [];
                this.selectedCostAgreement = '';
                this.provOrNat = type;
                this.getAllCostAgreements(type);
                this.showInsertModal = true;
            },

            createCostAllocation: function () {
                if ($('#datePicker').val() == '')
                    this.AllocationInput.date = '';
                this.$validator.validateAll().then((result) => {
                    if (result) {
                        axios.post('/budget/allocation/cost/register' , {
                            idNumber: this.AllocationInput.idNumber,
                            date: this.AllocationInput.date,
                            caCsId: this.AllocationInput.caCsId,
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
                                this.showInsertModal = false;
                                this.$parent.displayNotif(response.status);
                                console.log(response);
                            },(error) => {
                                console.log(error);

                            });
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

                this.AllocationFill.idNumber = item.caLetterNumber;
                this.AllocationFill.date = item.caLetterDate;
                this.AllocationFill.caCsId = item.caCcsId;
                this.AllocationFill.amount = this.$parent.calcDispAmount(item.caAmount , false);
                this.AllocationFill.description = item.caDescription;
                this.selectedCostAgreement = progId;
                this.showUpdateModal = true;
                this.getCreditSource();
                this.provOrNat = type;
                this.getAllCostAgreements(type);
            },

            updateCostAllocation: function () {
                if ($('#updateDatePicker').val() == '')
                    this.AllocationInput.date = '';
                this.$validator.validateAll().then((result) => {
                    if (result) {
                        axios.post('/budget/allocation/cost/update' , {
                            id: this.AllocationFill.id,
                            idNumber: this.AllocationFill.idNumber,
                            date: this.AllocationFill.date,
                            caCsId: this.AllocationFill.caCsId,
                            amount: this.AllocationFill.amount,
                            description: this.AllocationFill.description,
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
                                this.showUpdateModal = false;
                                this.$parent.displayNotif(response.status);
                                console.log(response);
                            },(error) => {
                                console.log(error);
                                this.errorMessage = 'تخصیص با این مشخصات قبلا ثبت شده است!';
                            });
                    }
                });
            },

            openDeleteModal: function (caId , type) {
                this.provOrNat = type;
                this.caIdForDelete = caId;
                this.showDeleteModal = true;
            },

            deleteCostAllocation: function () {
                axios.post('/budget/allocation/cost/delete' , {
                    id: this.caIdForDelete,
                    pOrN: this.provOrNat
                    })
                    .then((response) => {
                        if (response.status != 204)
                        {
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
            getExpenseCosts: function () {
                axios.get('/budget/allocation/cost/found/getAllExpenseCosts' , {params:{fId: this.foundIdForConvertTo}})
                    .then((response) => {
                        this.expenseCosts = response.data;
                        this.expenseCosts.forEach(cost => {
                            this.$set(cost , 'checked' , true);
                        });
                        console.log(response);
                    },(error) => {
                        console.log(error);
                    });
            },

            openInsertFoundModal:function () {
                this.showInsertFoundModal = true;
            },

            createProvincialFound: function () {
                this.$validator.validateAll().then((result) => {
                    if (result) {
                        if (this.checkValidDate()) {
                            axios.post('/budget/allocation/cost/found/register' , {
                                date: this.foundInput.date,
                                amount: this.foundInput.amount,
                                description: this.foundInput.description,
                                pOrN: 0
                            })
                                .then((response) => {
                                    this.provCostFounds = response.data;
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

            convertToAllocation: function () {
                this.$validator.validateAll().then((result) => {
                    if (result) {
                        if (this.checkSelectedCosts(this.expenseCosts))
                        {
                            this.selectedCosts = [];
                            this.expenseCosts.forEach(cost => {
                                if (cost.checked)
                                    this.selectedCosts.push(cost);
                            });
                            axios.post('/budget/allocation/cost/found/convert_to_allocation' , {
                                id: this.foundIdForConvertTo,
                                caCsId: this.AllocationInput.caCsId,
                                amount: this.AllocationInput.amount,
                                description: this.AllocationInput.description,
                                selectedCosts: this.selectedCosts
                            })
                                .then((response) => {
                                    this.provCostFounds = response.data.found;
                                    this.provCostAllocations = response.data.allocation_prov.data;
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
                this.selectedCostAgreement = '';
                this.AllocationInput = [];
                this.creditSourceInfo = [];
                this.showConvertToModal = true;
                this.foundIdForConvertTo = fId;
                this.getExpenseCosts();
                this.getAllCostAgreements(0);
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
        }
    }
</script>
