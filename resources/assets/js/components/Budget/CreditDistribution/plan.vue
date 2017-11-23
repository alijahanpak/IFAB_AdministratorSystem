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
                            <div class="clearfix tool-bar">
                                <div class="button-group float-right report-mrg">
                                    <a class="my-button toolbox-btn small" @click="openInsertModal(0)">جدید</a>
                                    <div v-if="!selectColumn" class="input-group-button toggle-icon-change">
                                        <button type="button" class="my-button my-icon-brand tiny" @click="showSelectColumn(cdPlans)"><i class="fa fa-check-square-o size-14" aria-hidden="true"></i></button>
                                    </div>
                                    <div v-if="selectColumn" class="input-group-button toggle-icon-change">
                                        <button type="button" class="my-button my-icon-danger tiny" @click="showSelectColumn(cdPlans)"><i class="fa fa-times size-14" aria-hidden="true"></i></button>
                                    </div>
                                    <button class="my-button toolbox-btn small dropdown small sm-btn-align"  type="button" data-toggle="reportDropDownPlan">گزارش</button>
                                    <div  style="width: 113px;" class="dropdown-pane dropdown-pane-sm " data-close-on-click="true"  data-hover="true" data-hover-pane="true"  data-position="bottom" data-alignment="left" id="reportDropDownPlan" data-dropdown data-auto-focus="true">
                                        <ul class="my-menu small-font ltr-dir">
                                            <li><a @click="openReportModal('pdf')"><i class="fa fa-file-pdf-o icon-margin-dropdown" aria-hidden="true"></i>PDF</a></li>
                                            <li><a @click="openReportModal('excel')"><i class="fa fa-file-excel-o icon-margin-dropdown" aria-hidden="true"></i>Excel</a></li>
                                        </ul>
                                    </div>
                                    <button class="my-button toolbox-btn small dropdown small sm-btn-align"  type="button" data-toggle="assetsDropDownPlan">تعداد نمایش<span> 20 </span></button>
                                    <div  style="width: 113px;" class="dropdown-pane dropdown-pane-sm " data-close-on-click="true"  data-hover="true" data-hover-pane="true"  data-position="bottom" data-alignment="left" id="assetsDropDownPlan" data-dropdown data-auto-focus="true">
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
                                            <i v-if="searchPlanValue == ''" class="fa fa-search purple-color"  aria-hidden="true"></i>
                                            <i v-if="searchPlanValue != ''" class="fa fa-close btn-red"  aria-hidden="true"></i>
                                            <input v-model="searchPlanValue" class="search" type="text" placeholder="جستوجو">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="tbl-div-container">
                                <table class="tbl-head">
                                    <colgroup>
                                        <col width="200px"/>
                                        <col width="200px"/>
                                        <col width="150px"/>
                                        <col width="100px"/>
                                        <col width="200px"/>
                                        <col v-show="selectColumn" width="15px"/>
                                        <col width="12px"/>
                                    </colgroup>
                                    <tbody class="tbl-head-style">
                                    <tr class="tbl-head-style-cell">
                                        <th class="tbl-head-style-cell">طرح</th>
                                        <th class="tbl-head-style-cell">ردیف</th>
                                        <th class="tbl-head-style-cell">شهرستان</th>
                                        <th class="tbl-head-style-cell">مبلغ اعتبار</th>
                                        <th class="tbl-head-style-cell">شرح</th>
                                        <th class="tbl-head-style-checkbox" v-show="selectColumn"><input type="checkbox" @click="toggleSelect(cdPlans)" :checked="allSelected(cdPlans)"></th>
                                        <th class="tbl-head-style-cell"></th>
                                    </tr>
                                    </tbody>
                                </table>

                                <div class="tbl_body_style dynamic-height-level2">
                                    <table class="tbl-body-contain">
                                        <colgroup>
                                            <col width="200px"/>
                                            <col width="200px"/>
                                            <col width="150px"/>
                                            <col width="100px"/>
                                            <col width="200px"/>
                                            <col v-show="selectColumn" width="15px"/>
                                        </colgroup>
                                        <tbody class="tbl-head-style-cell">
                                            <template v-for="plans in cdPlans">
                                                <tr class="tbl-head-style-cell" >
                                                    <td :rowspan="plans.credit_distribution_plan.length">{{ plans.cdtIdNumber + ' - ' + plans.cdtSubject }}</td>
                                                    <td>{{ plans.credit_distribution_plan[0].credit_distribution_row.cdSubject }}</td>
                                                    <td>{{ plans.credit_distribution_plan[0].county.coName }}</td>
                                                    <td>{{ $parent.calcDispAmount(plans.credit_distribution_plan[0].cdpCredit , false)  }}</td>
                                                    <td>
                                                        <div class="grid-x">
                                                            <div class="medium-11">
                                                                {{ plans.credit_distribution_plan[0].cdpDescription }}
                                                            </div>
                                                            <div class="medium-1 cell-vertical-center text-left">
                                                                <a class="dropdown small sm-btn-align"  type="button" :data-toggle="'cdPlan' + plans.id"><i class="fa fa-ellipsis-v size-18"></i></a>
                                                                <div class="dropdown-pane dropdown-pane-sm " data-close-on-click="true"  data-hover="true" data-hover-pane="true"  data-position="bottom" data-alignment="right" :id="'cdPlan' + plans.id" data-dropdown data-auto-focus="true">
                                                                    <ul class="my-menu small-font text-right">
                                                                        <li><a v-on:click.prevent="openUpdateModal(plans.credit_distribution_plan[0] , plans.cdtBsId)"><i class="fa fa-pencil-square-o size-16"></i>  ویرایش</a></li>
                                                                        <li><a v-on:click.prevent="openDeleteModal(plans.credit_distribution_plan[0].id)"><i class="fa fa-trash-o size-16"></i>  حذف</a></li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td  v-show="selectColumn">
                                                        <input class="auto-margin" v-model="plans.credit_distribution_plan[0].checked" type="checkbox">
                                                    </td>
                                                </tr>
                                                <template v-for="(cdPlan , cdIndex) in plans.credit_distribution_plan">
                                                    <tr class="tbl-head-style-cell" v-if="cdIndex > 0">
                                                        <td>{{ cdPlan.credit_distribution_row.cdSubject }}</td>
                                                        <td>{{ cdPlan.county.coName }}</td>
                                                        <td>{{ $parent.calcDispAmount(cdPlan.cdpCredit , false)  }}</td>
                                                        <td>
                                                            <div class="grid-x">
                                                                <div class="medium-11">
                                                                    {{ cdPlan.cdpDescription }}
                                                                </div>
                                                                <div class="medium-1 cell-vertical-center text-left">
                                                                    <a class="dropdown small sm-btn-align"  type="button" :data-toggle="'cdPlan' + plans.id + cdPlan.id"><i class="fa fa-ellipsis-v size-18"></i></a>
                                                                    <div class="dropdown-pane dropdown-pane-sm " data-close-on-click="true"  data-hover="true" data-hover-pane="true"  data-position="bottom" data-alignment="right" :id="'cdPlan' + plans.id + cdPlan.id" data-dropdown data-auto-focus="true">
                                                                        <ul class="my-menu small-font text-right">
                                                                            <li><a v-on:click.prevent="openUpdateModal(cdPlan , plans.cdtBsId)"><i class="fa fa-pencil-square-o size-16"></i>  ویرایش</a></li>
                                                                            <li><a v-on:click.prevent="openDeleteModal(cdPlan.id)"><i class="fa fa-trash-o size-16"></i>  حذف</a></li>
                                                                        </ul>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td  v-show="selectColumn">
                                                            <input class="auto-margin" v-model="cdPlan.checked" type="checkbox">
                                                        </td>
                                                    </tr>
                                                </template>
                                            </template>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="grid-x">
                                <div class="medium-8">
                                    <vue-pagination  v-bind:pagination="plan_pagination"
                                                     v-on:click.native="fetchData(plan_pagination.current_page)"
                                                     :offset="4">
                                    </vue-pagination>
                                </div>
                                <div style="color: #575962;" v-show="selectColumn" class="medium-4 small-font">
                                    <div class="float-left">
                                        <p> تعداد رکورد های انتخاب شده :<span class="selected-row-style">{{ selectedLength(cdPlans) }}</span></p>
                                    </div>
                                </div>
                            </div>
                            <!--Table Start-->
                        </div>
                    </div>
                    <!--Tab 1-->
                    <!--Tab 2-->
                    <div class="tabs-panel table-mrg-btm" id="row" xmlns:v-on="http://www.w3.org/1999/xhtml">
                        <div class="medium-12 bottom-mrg">
                            <div class="clearfix tool-bar">
                                <div class="button-group float-right report-mrg">
                                    <a class="my-button toolbox-btn small" @click="openInsertModal(1)">جدید</a>
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
                                        <div class="inner-addon right-addon">
                                            <i v-if="searchRowValue == ''" class="fa fa-search purple-color"  aria-hidden="true"></i>
                                            <i v-if="searchRowValue != ''" class="fa fa-close btn-red"  aria-hidden="true"></i>
                                            <input v-model="searchRowValue" class="search" type="text" placeholder="جستوجو">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--Table Start-->
                            <div class="tbl-div-container">
                                <table class="tbl-head">
                                    <colgroup>
                                        <col width="200px"/>
                                        <col width="200px"/>
                                        <col width="150px"/>
                                        <col width="100px"/>
                                        <col width="200px"/>
                                        <col width="12px"/>
                                    </colgroup>
                                    <tbody class="tbl-head-style">
                                    <tr class="tbl-head-style-cell">
                                        <th class="tbl-head-style-cell">ردیف</th>
                                        <th class="tbl-head-style-cell">طرح</th>
                                        <th class="tbl-head-style-cell">شهرستان</th>
                                        <th class="tbl-head-style-cell">مبلغ اعتبار</th>
                                        <th class="tbl-head-style-cell">شرح</th>
                                        <th class="tbl-head-style-cell"></th>
                                    </tr>
                                    </tbody>
                                </table>

                                <div class="tbl_body_style dynamic-height-level2">
                                    <table class="tbl-body-contain">
                                        <colgroup>
                                            <col width="200px"/>
                                            <col width="200px"/>
                                            <col width="150px"/>
                                            <col width="100px"/>
                                            <col width="200px"/>
                                        </colgroup>
                                        <tbody class="tbl-head-style-cell">
                                        <template v-for="rows in cdPlansOrderByRow">
                                            <tr class="tbl-head-style-cell" >
                                                <td :rowspan="rows.credit_distribution_plan.length">{{ rows.cdSubject }}</td>
                                                <td>{{ rows.credit_distribution_plan[0].credit_distribution_title.cdtIdNumber + ' - ' + rows.credit_distribution_plan[0].credit_distribution_title.cdtSubject }}</td>
                                                <td>{{ rows.credit_distribution_plan[0].county.coName }}</td>
                                                <td>{{ $parent.calcDispAmount(rows.credit_distribution_plan[0].cdpCredit , false)  }}</td>
                                                <td>
                                                    <div class="grid-x">
                                                        <div class="medium-11">
                                                            {{ rows.credit_distribution_plan[0].cdpDescription }}
                                                        </div>
                                                        <div class="medium-1 cell-vertical-center text-left">
                                                            <a class="dropdown small sm-btn-align"  type="button" :data-toggle="'cdPlanRows' + rows.id"><i class="fa fa-ellipsis-v size-18"></i></a>
                                                            <div class="dropdown-pane dropdown-pane-sm " data-close-on-click="true"  data-hover="true" data-hover-pane="true"  data-position="bottom" data-alignment="right" :id="'cdPlanRows' + rows.id" data-dropdown data-auto-focus="true">
                                                                <ul class="my-menu small-font text-right">
                                                                    <li><a v-on:click.prevent="openUpdateModal(rows.credit_distribution_plan[0] , rows.credit_distribution_plan[0].credit_distribution_title.cdtBsId)"><i class="fa fa-pencil-square-o size-16"></i>  ویرایش</a></li>
                                                                    <li><a v-on:click.prevent="openDeleteModal(rows.credit_distribution_plan[0].id)"><i class="fa fa-trash-o size-16"></i>  حذف</a></li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <template v-for="(cdPlan , cdIndex) in rows.credit_distribution_plan">
                                                <tr class="tbl-head-style-cell" v-if="cdIndex > 0">
                                                    <td>{{ cdPlan.credit_distribution_title.cdtIdNumber + ' - ' + cdPlan.credit_distribution_title.cdtSubject }}</td>
                                                    <td>{{ cdPlan.county.coName }}</td>
                                                    <td>{{ $parent.calcDispAmount(cdPlan.cdpCredit , false)  }}</td>
                                                    <td>
                                                        <div class="grid-x">
                                                            <div class="medium-11">
                                                                {{ cdPlan.cdpDescription }}
                                                            </div>
                                                            <div class="medium-1 cell-vertical-center text-left">
                                                                <a class="dropdown small sm-btn-align"  type="button" :data-toggle="'cdPlanRows' + rows.id + cdPlan.id"><i class="fa fa-ellipsis-v size-18"></i></a>
                                                                <div class="dropdown-pane dropdown-pane-sm " data-close-on-click="true"  data-hover="true" data-hover-pane="true"  data-position="bottom" data-alignment="right" :id="'cdPlanRows' + rows.id + cdPlan.id" data-dropdown data-auto-focus="true">
                                                                    <ul class="my-menu small-font text-right">
                                                                        <li><a v-on:click.prevent="openUpdateModal(cdPlan , cdPlan.credit_distribution_title.cdtBsId)"><i class="fa fa-pencil-square-o size-16"></i>  ویرایش</a></li>
                                                                        <li><a v-on:click.prevent="openDeleteModal(cdPlan.id)"><i class="fa fa-trash-o size-16"></i>  حذف</a></li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                            </template>
                                        </template>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="grid-x">
                                <div class="medium-12">
                                    <vue-pagination  v-bind:pagination="row_pagination"
                                                     v-on:click.native="fetchData(row_pagination.current_page)"
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
                            <div class="clearfix tool-bar">
                                <div class="button-group float-right report-mrg">
                                    <a class="my-button toolbox-btn small" @click="openInsertModal(1)">جدید</a>
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
                                        <div class="inner-addon right-addon">
                                            <i v-if="searchSeasonValue == ''" class="fa fa-search purple-color"  aria-hidden="true"></i>
                                            <i v-if="searchSeasonValue != ''" class="fa fa-close btn-red"  aria-hidden="true"></i>
                                            <input v-model="searchSeasonValue" class="search" type="text" placeholder="جستوجو">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--Table Start-->
                            <div class="tbl-div-container">
                                <table class="tbl-head">
                                    <colgroup>
                                        <col width="100px"/>
                                        <col width="150px"/>
                                        <col width="150px"/>
                                        <col width="150px"/>
                                        <col width="100px"/>
                                        <col width="200px"/>
                                        <col width="12px"/>
                                    </colgroup>
                                    <tbody class="tbl-head-style">
                                    <tr class="tbl-head-style-cell">
                                        <th class="tbl-head-style-cell">فصل بودجه</th>
                                        <th class="tbl-head-style-cell">طرح</th>
                                        <th class="tbl-head-style-cell">ردیف</th>
                                        <th class="tbl-head-style-cell">شهرستان</th>
                                        <th class="tbl-head-style-cell">مبلغ اعتبار</th>
                                        <th class="tbl-head-style-cell">شرح</th>
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
                                        </colgroup>
                                        <tbody class="tbl-head-style-cell">
                                        <template v-for="bs in cdPlansOrderByBudget">
                                            <tr class="tbl-head-style-cell" >
                                                <td :rowspan="getBsPlanCount(bs.cdp_title_has_credit_distribution_plan)">{{ bs.bsSubject }}</td>
                                                <td :rowspan="bs.cdp_title_has_credit_distribution_plan[0].credit_distribution_plan.length">{{ bs.cdp_title_has_credit_distribution_plan[0].credit_distribution_plan[0].credit_distribution_title.cdtIdNumber + ' - ' + bs.cdp_title_has_credit_distribution_plan[0].credit_distribution_plan[0].credit_distribution_title.cdtSubject }}</td>
                                                <td>{{ bs.cdp_title_has_credit_distribution_plan[0].credit_distribution_plan[0].credit_distribution_row.cdSubject }}</td>
                                                <td>{{ bs.cdp_title_has_credit_distribution_plan[0].credit_distribution_plan[0].county.coName }}</td>
                                                <td>{{ $parent.calcDispAmount(bs.cdp_title_has_credit_distribution_plan[0].credit_distribution_plan[0].cdpCredit , false)  }}</td>
                                                <td>
                                                    <div class="grid-x">
                                                        <div class="medium-11">
                                                            {{ bs.cdp_title_has_credit_distribution_plan[0].credit_distribution_plan[0].cdpDescription }}
                                                        </div>
                                                        <div class="medium-1 cell-vertical-center text-left">
                                                            <a class="dropdown small sm-btn-align"  type="button" :data-toggle="'cdPlanBudget' + bs.id"><i class="fa fa-ellipsis-v size-18"></i></a>
                                                            <div class="dropdown-pane dropdown-pane-sm " data-close-on-click="true"  data-hover="true" data-hover-pane="true"  data-position="bottom" data-alignment="right" :id="'cdPlanBudget' + bs.id" data-dropdown data-auto-focus="true">
                                                                <ul class="my-menu small-font text-right">
                                                                    <li><a v-on:click.prevent="openUpdateModal(bs.cdp_title_has_credit_distribution_plan[0].credit_distribution_plan[0] , bs.cdp_title_has_credit_distribution_plan[0].credit_distribution_plan[0].credit_distribution_title.cdtBsId)"><i class="fa fa-pencil-square-o size-16"></i>  ویرایش</a></li>
                                                                    <li><a v-on:click.prevent="openDeleteModal(bs.cdp_title_has_credit_distribution_plan[0].id)"><i class="fa fa-trash-o size-16"></i>  حذف</a></li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <template v-for="(cdTitle , cdtIndex) in bs.cdp_title_has_credit_distribution_plan">
                                                <tr class="tbl-head-style-cell" v-if="cdtIndex > 0">
                                                    <td :rowspan="cdTitle.credit_distribution_plan.length">{{ cdTitle.credit_distribution_plan[0].credit_distribution_title.cdtIdNumber + ' - ' + cdTitle.credit_distribution_plan[0].credit_distribution_title.cdtSubject }}</td>
                                                    <td>{{ cdTitle.credit_distribution_plan[0].credit_distribution_row.cdSubject }}</td>
                                                    <td>{{ cdTitle.credit_distribution_plan[0].county.coName }}</td>
                                                    <td>{{ $parent.calcDispAmount(cdTitle.credit_distribution_plan[0].cdpCredit , false)  }}</td>
                                                    <td>
                                                        <div class="grid-x">
                                                            <div class="medium-11">
                                                                {{ cdTitle.credit_distribution_plan[0].cdpDescription }}
                                                            </div>
                                                            <div class="medium-1 cell-vertical-center text-left">
                                                                <a class="dropdown small sm-btn-align"  type="button" :data-toggle="'cdPlanBudget' + bs.id + cdTitle.id"><i class="fa fa-ellipsis-v size-18"></i></a>
                                                                <div class="dropdown-pane dropdown-pane-sm " data-close-on-click="true"  data-hover="true" data-hover-pane="true"  data-position="bottom" data-alignment="right" :id="'cdPlanBudget' + bs.id + cdTitle.id" data-dropdown data-auto-focus="true">
                                                                    <ul class="my-menu small-font text-right">
                                                                        <li><a v-on:click.prevent="openUpdateModal(cdTitle.credit_distribution_plan[0] , cdTitle.credit_distribution_plan[0].credit_distribution_title.cdtBsId)"><i class="fa fa-pencil-square-o size-16"></i>  ویرایش</a></li>
                                                                        <li><a v-on:click.prevent="openDeleteModal(cdTitle.credit_distribution_plan[0].id)"><i class="fa fa-trash-o size-16"></i>  حذف</a></li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <template v-for="(cdPlan , cdIndex) in cdTitle.credit_distribution_plan">
                                                    <tr class="tbl-head-style-cell" v-if="cdIndex > 0">
                                                        <td>{{ cdPlan.credit_distribution_row.cdSubject }}</td>
                                                        <td>{{ cdPlan.county.coName }}</td>
                                                        <td>{{ $parent.calcDispAmount(cdPlan.cdpCredit , false)  }}</td>
                                                        <td>
                                                            <div class="grid-x">
                                                                <div class="medium-11">
                                                                    {{ cdPlan.cdpDescription }}
                                                                </div>
                                                                <div class="medium-1 cell-vertical-center text-left">
                                                                    <a class="dropdown small sm-btn-align"  type="button" :data-toggle="'cdPlanBudget' + bs.id + cdTitle.id + cdPlan.id"><i class="fa fa-ellipsis-v size-18"></i></a>
                                                                    <div class="dropdown-pane dropdown-pane-sm " data-close-on-click="true"  data-hover="true" data-hover-pane="true"  data-position="bottom" data-alignment="right" :id="'cdPlanBudget' + bs.id + cdTitle.id + cdPlan.id" data-dropdown data-auto-focus="true">
                                                                        <ul class="my-menu small-font text-right">
                                                                            <li><a v-on:click.prevent="openUpdateModal(cdPlan , cdTitle.credit_distribution_plan[0].credit_distribution_title.cdtBsId)"><i class="fa fa-pencil-square-o size-16"></i>  ویرایش</a></li>
                                                                            <li><a v-on:click.prevent="openDeleteModal(cdPlan.id)"><i class="fa fa-trash-o size-16"></i>  حذف</a></li>
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
                            </div>
                            <div class="grid-x">
                                <div class="medium-12">
                                    <vue-pagination  v-bind:pagination="budget_pagination"
                                                     v-on:click.native="fetchData(budget_pagination.current_page)"
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
                            <div class="clearfix tool-bar">
                                <div class="button-group float-right report-mrg">
                                    <a class="my-button toolbox-btn small" @click="openInsertModal(1)">جدید</a>
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
                                        <div class="inner-addon right-addon">
                                            <i v-if="searchCityValue == ''" class="fa fa-search purple-color"  aria-hidden="true"></i>
                                            <i v-if="searchCityValue != ''" class="fa fa-close btn-red"  aria-hidden="true"></i>
                                            <input v-model="searchCityValue" class="search" type="text" placeholder="جستوجو">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--Table Start-->
                            <div class="tbl-div-container">
                                <table class="tbl-head">
                                    <colgroup>
                                        <col width="150px"/>
                                        <col width="200px"/>
                                        <col width="200px"/>
                                        <col width="100px"/>
                                        <col width="200px"/>
                                        <col width="12px"/>
                                    </colgroup>
                                    <tbody class="tbl-head-style">
                                    <tr class="tbl-head-style-cell">
                                        <th class="tbl-head-style-cell">شهرستان</th>
                                        <th class="tbl-head-style-cell">طرح</th>
                                        <th class="tbl-head-style-cell">ردیف</th>
                                        <th class="tbl-head-style-cell">مبلغ اعتبار</th>
                                        <th class="tbl-head-style-cell">شرح</th>
                                        <th class="tbl-head-style-cell"></th>
                                    </tr>
                                    </tbody>
                                </table>

                                <div class="tbl_body_style dynamic-height-level2">
                                    <table class="tbl-body-contain">
                                        <colgroup>
                                            <col width="150px"/>
                                            <col width="200px"/>
                                            <col width="200px"/>
                                            <col width="100px"/>
                                            <col width="200px"/>
                                        </colgroup>
                                        <tbody class="tbl-head-style-cell">
                                        <template v-for="county in cdPlansOrderByCounty">
                                            <tr class="tbl-head-style-cell" >
                                                <td :rowspan="county.credit_distribution_plan.length">{{ county.coName }}</td>
                                                <td>{{ county.credit_distribution_plan[0].credit_distribution_title.cdtIdNumber + ' - ' + county.credit_distribution_plan[0].credit_distribution_title.cdtSubject }}</td>
                                                <td>{{ county.credit_distribution_plan[0].credit_distribution_row.cdSubject }}</td>
                                                <td>{{ $parent.calcDispAmount(county.credit_distribution_plan[0].cdpCredit , false)  }}</td>
                                                <td>
                                                    <div class="grid-x">
                                                        <div class="medium-11">
                                                            {{ county.credit_distribution_plan[0].cdpDescription }}
                                                        </div>
                                                        <div class="medium-1 cell-vertical-center text-left">
                                                            <a class="dropdown small sm-btn-align"  type="button" :data-toggle="'cdPlanCounty' + county.id"><i class="fa fa-ellipsis-v size-18"></i></a>
                                                            <div class="dropdown-pane dropdown-pane-sm " data-close-on-click="true"  data-hover="true" data-hover-pane="true"  data-position="bottom" data-alignment="right" :id="'cdPlanCounty' + county.id" data-dropdown data-auto-focus="true">
                                                                <ul class="my-menu small-font text-right">
                                                                    <li><a v-on:click.prevent="openUpdateModal(county.credit_distribution_plan[0] , county.credit_distribution_plan[0].credit_distribution_title.cdtBsId)"><i class="fa fa-pencil-square-o size-16"></i>  ویرایش</a></li>
                                                                    <li><a v-on:click.prevent="openDeleteModal(county.credit_distribution_plan[0].id)"><i class="fa fa-trash-o size-16"></i>  حذف</a></li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <template v-for="(cdPlan , cdIndex) in county.credit_distribution_plan">
                                                <tr class="tbl-head-style-cell" v-if="cdIndex > 0">
                                                    <td>{{ cdPlan.credit_distribution_title.cdtIdNumber + ' - ' + cdPlan.credit_distribution_title.cdtSubject }}</td>
                                                    <td>{{ cdPlan.credit_distribution_row.cdSubject }}</td>
                                                    <td>{{ $parent.calcDispAmount(cdPlan.cdpCredit , false)  }}</td>
                                                    <td>
                                                        <div class="grid-x">
                                                            <div class="medium-11">
                                                                {{ cdPlan.cdpDescription }}
                                                            </div>
                                                            <div class="medium-1 cell-vertical-center text-left">
                                                                <a class="dropdown small sm-btn-align"  type="button" :data-toggle="'cdPlanCounty' + county.id + cdPlan.id"><i class="fa fa-ellipsis-v size-18"></i></a>
                                                                <div class="dropdown-pane dropdown-pane-sm " data-close-on-click="true"  data-hover="true" data-hover-pane="true"  data-position="bottom" data-alignment="right" :id="'cdPlanCounty' + county.id + cdPlan.id" data-dropdown data-auto-focus="true">
                                                                    <ul class="my-menu small-font text-right">
                                                                        <li><a v-on:click.prevent="openUpdateModal(cdPlan , cdPlan.credit_distribution_title.cdtBsId)"><i class="fa fa-pencil-square-o size-16"></i>  ویرایش</a></li>
                                                                        <li><a v-on:click.prevent="openDeleteModal(cdPlan.id)"><i class="fa fa-trash-o size-16"></i>  حذف</a></li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                            </template>
                                        </template>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="grid-x">
                                <div class="medium-12">
                                    <vue-pagination  v-bind:pagination="county_pagination"
                                                     v-on:click.native="fetchData(county_pagination.current_page)"
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
                <modal-small v-if="showInsertModal" @close="showInsertModal = false" xmlns:v-on="http://www.w3.org/1999/xhtml">
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
                                <div class="medium-6 column padding-lr">
                                    <label>فصل بودجه
                                        <select class="form-element-margin-btm" v-model="selectedBs" @change="getAllCdTitle" name="bsId" v-validate data-vv-rules="required" :class="{'input': true, 'select-error': errors.has('bsId')}">
                                            <option value=""></option>
                                            <option v-for="bSeason in bSeasons" :value="bSeason.id">{{ bSeason.bsSubject }}</option>
                                        </select>
                                        <span v-show="errors.has('bsId')" class="error-font">فصل بودجه را انتخاب کنید!</span>
                                    </label>
                                </div>
                                <div class="medium-6 cell padding-lr">
                                    <label>ردیف توزیع اعتبار
                                        <select  class="form-element-margin-btm"  name="row" v-model="CdPlanInput.cdrId" v-validate data-vv-rules="required" :class="{'input': true, 'select-error': errors.has('row')}">
                                            <option value=""></option>
                                            <option v-for="creditDistributionRow in creditDistributionRows" :value="creditDistributionRow.id">{{ creditDistributionRow.cdSubject }}</option>
                                        </select>
                                        <span v-show="errors.has('row')" class="error-font">لطفا ردیف توزیع را انتخاب کنید!</span>
                                    </label>
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
                                    <label>شهرستان
                                        <select  class="form-element-margin-btm"  name="county" v-model="CdPlanInput.coId" v-validate data-vv-rules="required" :class="{'input': true, 'select-error': errors.has('county')}">
                                            <option value=""></option>
                                            <option v-for="county in counties" :value="county.id">{{ county.coName }}</option>
                                        </select>
                                        <span v-show="errors.has('county')" class="error-font">لطفا شهرستان را انتخاب کنید!</span>
                                    </label>
                                </div>
                            </div>
                            <div class="grid-x">
                                <div class="medium-4 cell padding-lr">
                                    <label><span class="padding-lr">مبلغ</span><span style="color: #D9534F;">{{ '(' + $parent.getAmountBaseLabel() + ')' }}</span>
                                        <input class="form-element-margin-btm" type="text"  v-model="CdPlanInput.amount" name="amount" v-validate data-vv-rules="required|decimal" :class="{'input': true, 'select-error': errors.has('amount')}"/>
                                    </label>
                                    <span v-show="errors.has('amount')" class="error-font">مبلغ فراموش شده است!</span>
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
                <!--update Modal Start-->
                <modal-small v-if="showUpdateModal" @close="showUpdateModal = false" xmlns:v-on="http://www.w3.org/1999/xhtml">
                    <div  slot="body">
                        <form v-on:submit.prevent="updateCreditDistributionPlan">
                            <div class="grid-x" v-if="errorMessage">
                                <div class="medium-12 columns padding-lr">
                                    <div class="alert callout">
                                        <p class="BYekan login-alert"><i class="fi-alert"></i>{{ errorMessage }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="grid-x">
                                <div class="medium-6 column padding-lr">
                                    <label>فصل بودجه
                                        <select class="form-element-margin-btm" v-model="selectedBs" @change="getAllCdTitle" name="bsId" v-validate data-vv-rules="required" :class="{'input': true, 'select-error': errors.has('bsId')}">
                                            <option value=""></option>
                                            <option v-for="bSeason in bSeasons" :value="bSeason.id">{{ bSeason.bsSubject }}</option>
                                        </select>
                                        <span v-show="errors.has('bsId')" class="error-font">فصل بودجه را انتخاب کنید!</span>
                                    </label>
                                </div>
                                <div class="medium-6 cell padding-lr">
                                    <label>ردیف توزیع اعتبار
                                        <select  class="form-element-margin-btm"  name="row" v-model="CdPlanFill.cdrId" v-validate data-vv-rules="required" :class="{'input': true, 'select-error': errors.has('row')}">
                                            <option value=""></option>
                                            <option v-for="creditDistributionRow in creditDistributionRows" :value="creditDistributionRow.id">{{ creditDistributionRow.cdSubject }}</option>
                                        </select>
                                        <span v-show="errors.has('row')" class="error-font">لطفا ردیف توزیع را انتخاب کنید!</span>
                                    </label>
                                </div>
                            </div>
                            <div class="grid-x">
                                <div class="medium-8 cell padding-lr">
                                    <label>عنوان طرح
                                        <select class="form-element-margin-btm"  v-model="CdPlanFill.cdtId" name="plan" v-validate data-vv-rules="required" :class="{'input': true, 'select-error': errors.has('plan')}">
                                            <option value=""></option>
                                            <option v-for="creditDistributionTitle in creditDistributionTitles" :value="creditDistributionTitle.id">{{ creditDistributionTitle.cdtIdNumber + ' - ' + creditDistributionTitle.cdtSubject + (creditDistributionTitle.county == null ? '' : ' - ' + creditDistributionTitle.county.coName)}}</option>
                                        </select>
                                        <span v-show="errors.has('plan')" class="error-font">لطفا طرح را انتخاب کنید!</span>
                                    </label>
                                    <span class="form-error error-font" data-form-error-for="cdpTitle">طرح توزیع اعتبار را انتخاب کنید!</span>
                                </div>
                                <div class="medium-4 cell padding-lr">
                                    <label>شهرستان
                                        <select  class="form-element-margin-btm"  name="county" v-model="CdPlanFill.coId" v-validate data-vv-rules="required" :class="{'input': true, 'select-error': errors.has('county')}">
                                            <option value=""></option>
                                            <option v-for="county in counties" :value="county.id">{{ county.coName }}</option>
                                        </select>
                                        <span v-show="errors.has('county')" class="error-font">لطفا شهرستان را انتخاب کنید!</span>
                                    </label>
                                </div>
                            </div>
                            <div class="grid-x">
                                <div class="medium-4 cell padding-lr">
                                    <label><span class="padding-lr">مبلغ</span><span style="color: #D9534F;">{{ '(' + $parent.getAmountBaseLabel() + ')' }}</span>
                                        <input class="form-element-margin-btm" type="text"  v-model="CdPlanFill.amount" name="amount" v-validate data-vv-rules="required|decimal" :class="{'input': true, 'select-error': errors.has('amount')}"/>
                                    </label>
                                    <span v-show="errors.has('amount')" class="error-font">مبلغ فراموش شده است!</span>
                                </div>
                            </div>
                            <div class="grid-x">
                                <div class="small-12 columns padding-lr">
                                    <label>شرح
                                        <textarea name="csDescription" style="min-height: 150px;" v-model="CdPlanFill.description"></textarea>
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
                                    <button v-on:click="deleteSelectedPlan" class="my-button my-success"><span class="btn-txt-mrg">   بله   </span></button>
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
                searchPlanValue:'',
                searchRowValue:'',
                searchSeasonValue:'',
                searchCityValue:'',
                cdPlans: [],
                cdPlansOrderByRow: [],
                cdPlansOrderByBudget: [],
                cdPlansOrderByCounty: [],
                CdPlanInput: {},
                CdPlanFill: {},
                showInsertModal: false,
                showUpdateModal: false,
                showDeleteModal: false,
                showModalReport:false,
                selectColumn:false,
                creditDistributionTitles: {},
                creditDistributionRows: {},
                counties: {},
                bSeasons: {},
                selectedBs: '',
                selectedItems: [],
                selectedCount: 0,
                reportOptions: {title:'' , withReporterName: true , withFiscalYear: true , withReportDate: true , orientation: true ,costLabel: true},
                selectedPlanIdForDelete: '',

                plan_pagination: {
                    total: 0,
                    to: 0,
                    current_page: 1,
                    last_page: ''
                },

                row_pagination: {
                    total: 0,
                    to: 0,
                    current_page: 1,
                    last_page: ''
                },

                budget_pagination: {
                    total: 0,
                    to: 0,
                    current_page: 1,
                    last_page: ''
                },

                county_pagination: {
                    total: 0,
                    to: 0,
                    current_page: 1,
                    last_page: ''
                },
            }
        },
        created: function () {
            this.fetchData();
        },

        updated: function () {
            $(this.$el).foundation(); //WORKS!
            this.$parent.userIsActive();
        },

        mounted: function () {
            console.log("mounted credit distribution plans component");
            this.$parent.myResize();
        },

        components:{
            'vue-pagination' : VuePagination
        },

        methods:{
            fetchData: function (page = 1) {
                axios.get('/budget/credit_distribution/capital_assets/provincial/plans/fetchData?page=' + page)
                    .then((response) => {
                        this.cdPlans = response.data.byPlan.data;
                        this.makePagination(response.data.byPlan , "plan");
                        this.cdPlansOrderByRow = response.data.byRow.data;
                        this.makePagination(response.data.byRow , "row");
                        this.cdPlansOrderByBudget = response.data.byBudget.data;
                        this.makePagination(response.data.byBudget , "budget");
                        this.cdPlansOrderByCounty = response.data.byCounty.data;
                        this.makePagination(response.data.byCounty , "county");
                        console.log(response);
                    },(error) => {
                        console.log(error);
                    });
            },

            setData: function (data) {
                    this.cdPlans = response.data.byPlan.data;
                    this.cdPlansOrderByRow = response.data.byRow.data;
                    this.cdPlansOrderByBudget = response.data.byBudget.data;
                    this.cdPlansOrderByCounty = response.data.byCounty.data;
                    this.selectAll(this.cdPlans);
                    //console.log(JSON.stringify(this.cdPlans));
            },

            getBudgetSeason: function () {
                axios.get('/budget/admin/credit_distribution_def/budget_season/fetchData')
                    .then((response) => {
                        this.bSeasons = response.data;
                        console.log(response);
                    },(error) => {
                        console.log(error);
                    });
            },

            getAllCdTitle: function () {
                if (this.selectedBs != '')
                {
                    axios.get('/budget/admin/credit_distribution_def/plan_cost_title/getAllItem' , {params:{pOrN: 1 , bsId: this.selectedBs}})
                        .then((response) => {
                            this.creditDistributionTitles = response.data;
                            console.log(response);
                        },(error) => {
                            console.log(error);
                        });
                }
                else
                    this.creditDistributionTitles = [];
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

            getBsPlanCount: function (cdpTitle) {
                var count = 0;
                cdpTitle.forEach(cdpT => {
                    count += cdpT.credit_distribution_plan.length;
                });
                return count;
            },

            openInsertModal: function (type) {
                this.CdPlanInput = [];
                this.selectedBs = '';
                this.getBudgetSeason();
                this.getCreditDistributionRow();
                this.getCounties();
                this.showInsertModal = true;
            },

            createCreditDistributionPlan: function () {
                this.$validator.validateAll().then((result) => {
                    if (result) {
                        axios.post('/budget/credit_distribution/capital_assets/provincial/plans/register' , {
                            cdtId: this.CdPlanInput.cdtId,
                            cdrId: this.CdPlanInput.cdrId,
                            coId: this.CdPlanInput.coId,
                            description: this.CdPlanInput.description,
                            amount: this.CdPlanInput.amount,
                        })
                            .then((response) => {
                                this.cdPlans = response.data.byPlan.data;
                                this.makePagination(response.data.byPlan , "plan");
                                this.cdPlansOrderByRow = response.data.byRow.data;
                                this.makePagination(response.data.byRow , "row");
                                this.cdPlansOrderByBudget = response.data.byBudget.data;
                                this.makePagination(response.data.byBudget , "budget");
                                this.cdPlansOrderByCounty = response.data.byCounty.data;
                                this.makePagination(response.data.byCounty , "county");
                                this.$parent.displayNotif(response.status);
                                console.log(response);
                            },(error) => {
                                console.log(error);
                                this.$parent.displayNotif(error.response.status);
                            });
                    }
                });
            },

            openUpdateModal: function (item , bsId) {
                this.getBudgetSeason();
                this.CdPlanFill.id = item.id
                this.CdPlanFill.cdtId = item.cdpCdtId;
                this.CdPlanFill.cdrId = item.cdpCdrId;
                this.CdPlanFill.coId = item.cdpCoId;
                this.CdPlanFill.description = item.cdpDescription;
                this.CdPlanFill.amount = this.$parent.calcDispAmount(item.cdpCredit , false);
                this.selectedBs = bsId;
                this.errorMessage = '';
                this.getCreditDistributionRow();
                this.getCounties();
                this.getAllCdTitle();
                this.showUpdateModal = true;
            },

            updateCreditDistributionPlan: function () {
                this.$validator.validateAll().then((result) => {
                    if (result) {
                        axios.post('/budget/credit_distribution/capital_assets/provincial/plans/update' , {
                            id: this.CdPlanFill.id,
                            cdtId: this.CdPlanFill.cdtId,
                            cdrId: this.CdPlanFill.cdrId,
                            coId: this.CdPlanFill.coId,
                            description: this.CdPlanFill.description,
                            amount: this.CdPlanFill.amount,
                        })
                            .then((response) => {
                                this.cdPlans = response.data.byPlan.data;
                                this.makePagination(response.data.byPlan , "plan");
                                this.cdPlansOrderByRow = response.data.byRow.data;
                                this.makePagination(response.data.byRow , "row");
                                this.cdPlansOrderByBudget = response.data.byBudget.data;
                                this.makePagination(response.data.byBudget , "budget");
                                this.cdPlansOrderByCounty = response.data.byCounty.data;
                                this.makePagination(response.data.byCounty , "county");

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
                this.selectedPlanIdForDelete = pId;
                this.showDeleteModal = true;
            },

            deleteSelectedPlan: function () {
                axios.post('/budget/credit_distribution/capital_assets/provincial/plans/delete' , {id: this.selectedPlanIdForDelete})
                    .then((response) => {
                        if (response.status != 204)
                        {
                            this.cdPlans = response.data.byPlan.data;
                            this.makePagination(response.data.byPlan , "plan");
                            this.cdPlansOrderByRow = response.data.byRow.data;
                            this.makePagination(response.data.byRow , "row");
                            this.cdPlansOrderByBudget = response.data.byBudget.data;
                            this.makePagination(response.data.byBudget , "budget");
                            this.cdPlansOrderByCounty = response.data.byCounty.data;
                            this.makePagination(response.data.byCounty , "county");
                        }
                        this.showDeleteModal = false;
                        this.$parent.displayNotif(response.status);
                        console.log(response);
                    },(error) => {
                        console.log(error);
                        this.showDeleteModal = false;
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

            openReportModal: function (type) {
                this.reportType = type;
                this.selectedItems = [];
                var isSelected=false;
                if (this.selectedLength(this.cdPlans) != 0)
                {
                    this.showModalReport = true;
                    this.cdPlans.forEach(plan => {
                        plan.credit_distribution_plan.forEach(cdPlan => {
                            if (cdPlan.checked == true)
                                isSelected=true;
                        });
                        if (isSelected) {
                            this.selectedItems.push(plan);
                            isSelected = false;
                        }
                    });
                    this.reportOptions.title = ' طرح های توزیع اعتبار تملک دارایی های سرمایه ای استانی';
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

            toggleSelect: function(plans) {
                var temp = false;
                plans.forEach(plan => {
                    plan.credit_distribution_plan.forEach(cdPlan => {
                        if (cdPlan.checked)
                            temp = true;

                    });
                });
                plans.forEach(plan => {
                    if(temp){
                        plan.credit_distribution_plan.forEach(cdPlan => {
                            cdPlan.checked = false;

                        });
                    } else {
                        plan.credit_distribution_plan.forEach(cdPlan => {
                            cdPlan.checked = true;
                        });
                    }
                });
                //console.log(JSON.stringify(this.approvedProjects_prov));
            },

            allSelected: function(plans) {
                var temp = true;
                //console.log(JSON.stringify(this.approvedProjects_prov));
                plans.forEach(plan => {
                    plan.credit_distribution_plan.forEach(cdPlan => {
                        if (cdPlan.checked == false)
                            temp = false;
                    });
                });
                return temp;
            },

            selectAll: function (plans) {
                plans.forEach(plan => {
                    plan.credit_distribution_plan.forEach(cdPlan => {
                        this.$set(cdPlan, 'checked' , true);
                    });
                });
                console.log(JSON.stringify(this.approvedProjects_prov));
            },

            selectedLength: function (plans) {
                var counter=0;
                plans.forEach(plan => {
                    plan.credit_distribution_plan.forEach(cdPlan => {
                        counter+=cdPlan.checked;
                    });
                });
                return counter;
                },

            makePagination: function(data , type){
                if (type == "plan")
                {
                    this.plan_pagination.current_page = data.current_page;
                    this.plan_pagination.to = data.to;
                    this.plan_pagination.last_page = data.last_page;
                }else if (type == "row")
                {
                    this.row_pagination.current_page = data.current_page;
                    this.row_pagination.to = data.to;
                    this.row_pagination.last_page = data.last_page;
                }else if (type == "budget")
                {
                    this.budget_pagination.current_page = data.current_page;
                    this.budget_pagination.to = data.to;
                    this.budget_pagination.last_page = data.last_page;
                }else if (type == "county")
                {
                    this.county_pagination.current_page = data.current_page;
                    this.county_pagination.to = data.to;
                    this.county_pagination.last_page = data.last_page;
                }
            },
        }
    }
</script>

