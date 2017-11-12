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
                                <a class="disabled">موافقتنامه</a>
                            </li>
                            <li>
                                <a class="disabled">تملک دارایی سرمایه ای</a>
                            </li>
                            <li>
                                <span class="show-for-sr">Current: </span>پروژه ها
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
        <div class="grid-x  my-callout-box container-mrg-top dynamic-height-level1">
            <div  class="medium-12 column">
                <ul class="tabs tab-color my-tab-style" data-responsive-accordion-tabs="tabs medium-accordion large-tabs" id="approved_project_tab_view">
                    <li class="tabs-title is-active"><a href="#provincial_tab" aria-selected="true">استانی</a></li>
                    <li class="tabs-title"><a href="#national_tab">ملی</a></li>
                </ul>
                <div class="tabs-content" data-tabs-content="approved_project_tab_view">
                    <div class="tabs-panel is-active table-mrg-btm" id="provincial_tab"
                         xmlns:v-on="http://www.w3.org/1999/xhtml">
                        <div class="medium-12 bottom-mrg">
                            <!--Tab 1-->
                            <div class="clearfix border-btm-line bottom-mrg tool-bar">
                                <div style="margin-top: 2px;" class="button-group float-right report-mrg">
                                    <a class="my-button toolbox-btn small" @click="openApprovedProjectInsertModal(0)">جدید</a>
                                    <div v-if="!selectColumn" class="input-group-button toggle-icon-change">
                                        <button type="button" class="my-button my-icon-brand tiny" @click="showSelectColumn(approvedProjects_prov)"><i class="fa fa-check-square-o size-14" aria-hidden="true"></i></button>
                                    </div>
                                    <div v-if="selectColumn" class="input-group-button toggle-icon-change">
                                        <button type="button" class="my-button my-icon-danger tiny" @click="showSelectColumn(approvedProjects_prov)"><i class="fa fa-times size-14" aria-hidden="true"></i></button>
                                    </div>
                                    <button class="my-button toolbox-btn small dropdown small sm-btn-align"  type="button" data-toggle="reportDropDown1">گزارش</button>
                                    <div  style="width: 113px;" class="dropdown-pane dropdown-pane-sm " data-close-on-click="true"  data-hover="true" data-hover-pane="true"  data-position="bottom" data-alignment="left" id="reportDropDown1" data-dropdown data-auto-focus="true">
                                        <ul class="my-menu small-font ltr-dir">
                                            <li><a @click="openReportModal(0)"><i class="fa fa-file-pdf-o icon-margin-dropdown" aria-hidden="true"></i>PDF</a></li>
                                            <li><a  href="#"><i class="fa fa-file-excel-o icon-margin-dropdown" aria-hidden="true"></i>Excel</a></li>
                                        </ul>
                                    </div>
                                    <button class="my-button toolbox-btn small dropdown small sm-btn-align"  type="button" data-toggle="countDropDown1">تعداد نمایش<span> 20 </span></button>
                                    <div  style="width: 113px;" class="dropdown-pane dropdown-pane-sm " data-close-on-click="true"  data-hover="true" data-hover-pane="true"  data-position="bottom" data-alignment="left" id="countDropDown1" data-dropdown data-auto-focus="true">
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
                                        <col width="100px"/>
                                        <col width="250"/>
                                        <col width="150px"/>
                                        <col width="100px"/>
                                        <col width="250px"/>
                                        <col v-show="selectColumn" width="15px"/>
                                        <col width="12px"/>

                                    </colgroup>
                                    <tbody class="tbl-head-style">
                                    <tr class="tbl-head-style-cell">
                                        <th class="tbl-head-style-cell">کد طرح</th>
                                        <th class="tbl-head-style-cell">کد</th>
                                        <th class="tbl-head-style-cell">عنوان</th>
                                        <th class="tbl-head-style-cell">شهرستان</th>
                                        <th class="tbl-head-style-cell">اعتبار</th>
                                        <th class="tbl-head-style-cell">شرح</th>
                                        <th class="tbl-head-style-checkbox" v-show="selectColumn"><input type="checkbox" @click="toggleSelect(approvedProjects_prov)" :checked="allSelected(approvedProjects_prov)"></th>
                                        <th class="tbl-head-style-cell"></th>
                                    </tr>
                                    </tbody>
                                </table>
                                <!--Table Head End-->
                                <!--Table Body Start-->
                                    <div class="tbl_body_style dynamic-height-level2">
                                        <table class="tbl-body-contain">
                                            <colgroup>
                                                <col width="250px"/>
                                                <col width="100px"/>
                                                <col width="250"/>
                                                <col width="150px"/>
                                                <col width="100px"/>
                                                <col width="250px"/>
                                                <col v-show="selectColumn" width="15px"/>
                                            </colgroup>
                                            <tbody class="tbl-head-style-cell">
                                            <template  v-for="plans in approvedProjects_prov">
                                                <tr>
                                                    <td :rowspan="plans.capital_assets_project.length + (displayParentId_prov == plans.id ? 1 : 0)"> {{ plans.credit_distribution_title.cdtIdNumber + ' - ' + plans.credit_distribution_title.cdtSubject + ' - ' + plans.credit_distribution_title.county.coName }}</td>
                                                    <td>
                                                        {{ plans.capital_assets_project[0].cpCode }}
                                                    </td>
                                                    <td>
                                                        {{ plans.capital_assets_project[0].cpSubject }}
                                                    </td>
                                                    <td>
                                                        {{ plans.capital_assets_project[0].county.coName }}
                                                    </td>
                                                    <td>
                                                        <span @click="openAccordion(0 , plans.capital_assets_project[0].id , plans.id)">{{ $parent.calcDispAmount(sumOfAmount(plans.capital_assets_project[0].credit_source) , false) }}</span>
                                                    </td>
                                                    <td>
                                                        <div class="grid-x">
                                                            <div class="medium-11">
                                                                {{ plans.capital_assets_project[0].capDescription }}
                                                            </div>
                                                            <div class="medium-1 cell-vertical-center text-left auto-margin">
                                                                <a class="dropdown small sm-btn-align"  type="button" :data-toggle="'approvedPlans' + plans.id"><i class="fa fa-ellipsis-v size-18"></i></a>
                                                                <div class="dropdown-pane dropdown-pane-sm auto-margin" data-close-on-click="true"  data-hover="true" data-hover-pane="true"  data-position="bottom" data-alignment="right" :id="'approvedPlans' + plans.id" data-dropdown data-auto-focus="true">
                                                                    <ul class="my-menu small-font text-right">
                                                                        <li><a v-on:click.prevent=""><i class="fa fa-pencil-square-o size-16"></i>  ویرایش</a></li>
                                                                        <li><a v-on:click.prevent=""><i class="fa fa-trash-o size-16"></i>  حذف</a></li>
                                                                        <li><a v-on:click.prevent="openApCreditSourceInsertModal(plans.capital_assets_project[0].id ,0)"><i class="fa fa-money size-16"></i>  اعتبارات</a></li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td  v-show="selectColumn">
                                                        <input class="auto-margin" v-model="plans.capital_assets_project[0].checked" type="checkbox">
                                                    </td>
                                                </tr>
                                                <tr v-show="displayCreditSourceInfo_prov == plans.capital_assets_project[0].id">
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
                                                                <th>توضیحات</th>
                                                            </tr>
                                                            </thead>
                                                            <tbody>
                                                            <tr v-for="creditSource in plans.capital_assets_project[0].credit_source">
                                                                <td>{{ creditSource.credit_distribution_row.cdSubject }}</td>
                                                                <td>{{ creditSource.tiny_season.season_title.season.sSubject }}</td>
                                                                <td>{{ creditSource.tiny_season.season_title.castSubject }}</td>
                                                                <td>{{ creditSource.tiny_season.catsSubject }}</td>
                                                                <td>{{ creditSource.how_to_run.htrSubject }}</td>
                                                                <td>{{ $parent.calcDispAmount(creditSource.ccsAmount , false) }}</td>
                                                                <td>{{ creditSource.ccsDescription }}</td>
                                                            </tr>
                                                            </tbody>
                                                        </table>
                                                    </td>
                                                </tr>
                                                <template v-for="(project , pIndex) in plans.capital_assets_project">
                                                    <tr v-if="pIndex > 0">
                                                        <td>
                                                            {{ project.cpCode }}
                                                        </td>
                                                        <td>
                                                            {{ project.cpSubject }}
                                                        </td>
                                                        <td>
                                                            {{ project.county.coName }}
                                                        </td>
                                                        <td>
                                                            <span @click="openAccordion(0 , project.id , plans.id)">{{ $parent.calcDispAmount(sumOfAmount(project.credit_source) , false) }}</span>
                                                        </td>
                                                        <td>
                                                            <div class="grid-x">
                                                                <div class="medium-11">
                                                                    {{ project.capDescription }}
                                                                </div>
                                                                <div class="medium-1 cell-vertical-center text-left auto-margin">
                                                                    <a class="dropdown small sm-btn-align"  type="button" :data-toggle="'approvedPlans' + plans.id + project.id"><i class="fa fa-ellipsis-v size-18"></i></a>
                                                                    <div class="dropdown-pane dropdown-pane-sm auto-margin" data-close-on-click="true"  data-hover="true" data-hover-pane="true"  data-position="bottom" data-alignment="right" :id="'approvedPlans' + plans.id + project.id" data-dropdown data-auto-focus="true">
                                                                        <ul class="my-menu small-font text-right">
                                                                            <li><a v-on:click.prevent=""><i class="fa fa-pencil-square-o size-16"></i>  ویرایش</a></li>
                                                                            <li><a v-on:click.prevent=""><i class="fa fa-trash-o size-16"></i>  حذف</a></li>
                                                                            <li><a v-on:click.prevent="openApCreditSourceInsertModal(project.id ,0)"><i class="fa fa-money size-16"></i>  اعتبارات</a></li>
                                                                        </ul>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td  v-show="selectColumn">
                                                            <input class="auto-margin" v-model="project.checked" type="checkbox">
                                                        </td>
                                                    </tr>
                                                    <tr v-if="pIndex>0" v-show="displayCreditSourceInfo_prov == project.id">
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
                                                                    <th>توضیحات</th>
                                                                </tr>
                                                                </thead>
                                                                <tbody>
                                                                <tr v-for="creditSource in project.credit_source">
                                                                    <td>{{ creditSource.credit_distribution_row.cdSubject }}</td>
                                                                    <td>{{ creditSource.tiny_season.season_title.season.sSubject }}</td>
                                                                    <td>{{ creditSource.tiny_season.season_title.castSubject }}</td>
                                                                    <td>{{ creditSource.tiny_season.catsSubject }}</td>
                                                                    <td>{{ creditSource.how_to_run.htrSubject }}</td>
                                                                    <td>{{ $parent.calcDispAmount(creditSource.ccsAmount , false) }}</td>
                                                                    <td>{{ creditSource.ccsDescription }}</td>
                                                                </tr>
                                                                </tbody>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                </template>
                                            </template>

                                            </tbody>
                                        </table>
                                    </div>
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
                                        <p> تعداد رکورد های انتخاب شده :<span class="selected-row-style">{{ selectedLength(approvedProjects_prov) }}</span></p>
                                    </div>
                                </div>
                            </div>
                        </div>

                    <!-- national tab -->
                    <div class="tabs-panel table-mrg-btm" id="national_tab" xmlns:v-on="http://www.w3.org/1999/xhtml">
                        <div class="medium-12 bottom-mrg">
                            <!--Tab 2-->
                            <div class="clearfix border-btm-line bottom-mrg tool-bar">
                                <div style="margin-top: 2px;" class="button-group float-right report-mrg">
                                    <a class="my-button toolbox-btn small" @click="openApprovedProjectInsertModal(1)">جدید</a>
                                    <div v-if="!selectColumn" class="input-group-button toggle-icon-change">
                                        <button type="button" class="my-button my-icon-brand tiny" @click="showSelectColumn(approvedProjects_nat)"><i class="fa fa-check-square-o size-14" aria-hidden="true"></i></button>
                                    </div>
                                    <div v-if="selectColumn" class="input-group-button toggle-icon-change">
                                        <button type="button" class="my-button my-icon-danger tiny" @click="showSelectColumn(approvedProjects_nat)"><i class="fa fa-times size-14" aria-hidden="true"></i></button>
                                    </div>
                                    <button class="my-button toolbox-btn small dropdown small sm-btn-align"  type="button" data-toggle="reportDropDown2">گزارش</button>
                                    <div  style="width: 113px;" class="dropdown-pane dropdown-pane-sm " data-close-on-click="true"  data-hover="true" data-hover-pane="true"  data-position="bottom" data-alignment="left" id="reportDropDown2" data-dropdown data-auto-focus="true">
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
                            <div class="tbl-div-container">
                                <table class="tbl-head">
                                    <colgroup>
                                        <col width="250px"/>
                                        <col width="100px"/>
                                        <col width="250"/>
                                        <col width="150px"/>
                                        <col width="100px"/>
                                        <col width="250px"/>
                                        <col v-show="selectColumn" width="15px"/>
                                        <col width="12px"/>

                                    </colgroup>
                                    <tbody class="tbl-head-style">
                                    <tr class="tbl-head-style-cell">
                                        <th class="tbl-head-style-cell">کد طرح</th>
                                        <th class="tbl-head-style-cell">کد</th>
                                        <th class="tbl-head-style-cell">عنوان</th>
                                        <th class="tbl-head-style-cell">شهرستان</th>
                                        <th class="tbl-head-style-cell">اعتبار</th>
                                        <th class="tbl-head-style-cell">شرح</th>
                                        <th class="tbl-head-style-checkbox" v-show="selectColumn"><input type="checkbox" @click="toggleSelect(approvedProjects_nat)" :checked="allSelected(approvedProjects_nat)"></th>
                                        <th class="tbl-head-style-cell"></th>
                                    </tr>
                                    </tbody>
                                </table>
                                <!--Table Head End-->
                                <!--Table Body Start-->
                                <div class="tbl_body_style dynamic-height-level2">
                                    <table class="tbl-body-contain">
                                        <colgroup>
                                            <col width="250px"/>
                                            <col width="100px"/>
                                            <col width="250"/>
                                            <col width="150px"/>
                                            <col width="100px"/>
                                            <col width="250px"/>
                                            <col v-show="selectColumn" width="15px"/>
                                        </colgroup>
                                        <tbody class="tbl-head-style-cell">
                                        <template  v-for="plans in approvedProjects_nat">
                                            <tr>
                                                <td :rowspan="plans.capital_assets_project.length + (displayParentId_nat == plans.id ? 1 : 0)">  {{ plans.credit_distribution_title.cdtIdNumber + ' - ' + plans.credit_distribution_title.cdtSubject }}</td>
                                                <td>
                                                    {{ plans.capital_assets_project[0].cpCode }}
                                                </td>
                                                <td>
                                                    {{ plans.capital_assets_project[0].cpSubject }}
                                                </td>
                                                <td>
                                                    {{ plans.capital_assets_project[0].county.coName }}
                                                </td>
                                                <td>
                                                    <span @click="openAccordion(1 , plans.capital_assets_project[0].id , plans.id)">{{ $parent.calcDispAmount(sumOfAmount(plans.capital_assets_project[0].credit_source) , false) }}</span>
                                                </td>
                                                <td>
                                                    <div class="grid-x">
                                                        <div class="medium-11">
                                                            {{ plans.capital_assets_project[0].capDescription }}
                                                        </div>
                                                        <div class="medium-1 cell-vertical-center text-left auto-margin">
                                                            <a class="dropdown small sm-btn-align"  type="button" :data-toggle="'approvedPlans' + plans.id"><i class="fa fa-ellipsis-v size-18"></i></a>
                                                            <div class="dropdown-pane dropdown-pane-sm auto-margin" data-close-on-click="true"  data-hover="true" data-hover-pane="true"  data-position="bottom" data-alignment="right" :id="'approvedPlans' + plans.id" data-dropdown data-auto-focus="true">
                                                                <ul class="my-menu small-font text-right">
                                                                    <li><a v-on:click.prevent=""><i class="fa fa-pencil-square-o size-16"></i>  ویرایش</a></li>
                                                                    <li><a v-on:click.prevent=""><i class="fa fa-trash-o size-16"></i>  حذف</a></li>
                                                                    <li><a v-on:click.prevent="openApCreditSourceInsertModal(plans.capital_assets_project[0].id ,1)"><i class="fa fa-money size-16"></i>  اعتبارات</a></li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td  v-show="selectColumn">
                                                    <input class="auto-margin" v-model="plans.checked" type="checkbox">
                                                </td>
                                            </tr>
                                            <tr v-show="displayCreditSourceInfo_nat == plans.capital_assets_project[0].id">
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
                                                            <th>توضیحات</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        <tr v-for="creditSource in plans.capital_assets_project[0].credit_source">
                                                            <td>{{ creditSource.credit_distribution_row.cdSubject }}</td>
                                                            <td>{{ creditSource.tiny_season.season_title.season.sSubject }}</td>
                                                            <td>{{ creditSource.tiny_season.season_title.castSubject }}</td>
                                                            <td>{{ creditSource.tiny_season.catsSubject }}</td>
                                                            <td>{{ creditSource.how_to_run.htrSubject }}</td>
                                                            <td>{{ $parent.calcDispAmount(creditSource.ccsAmount , false) }}</td>
                                                            <td>{{ creditSource.ccsDescription }}</td>
                                                        </tr>
                                                        </tbody>
                                                    </table>
                                                </td>
                                            </tr>
                                            <template v-for="(project , pIndex) in plans.capital_assets_project">
                                                <tr v-if="pIndex > 0">
                                                    <td>
                                                        {{ project.cpCode }}
                                                    </td>
                                                    <td>
                                                        {{ project.cpSubject }}
                                                    </td>
                                                    <td>
                                                        {{ project.county.coName }}
                                                    </td>
                                                    <td>
                                                        <span @click="openAccordion(1 , project.id , plans.id)">{{ $parent.calcDispAmount(sumOfAmount(project.credit_source) , false) }}</span>
                                                    </td>
                                                    <td>
                                                        <div class="grid-x">
                                                            <div class="medium-11">
                                                                {{ project.capDescription }}
                                                            </div>
                                                            <div class="medium-1 cell-vertical-center text-left auto-margin">
                                                                <a class="dropdown small sm-btn-align"  type="button" :data-toggle="'approvedPlans' + plans.id + project.id"><i class="fa fa-ellipsis-v size-18"></i></a>
                                                                <div class="dropdown-pane dropdown-pane-sm auto-margin" data-close-on-click="true"  data-hover="true" data-hover-pane="true"  data-position="bottom" data-alignment="right" :id="'approvedPlans' + plans.id + project.id" data-dropdown data-auto-focus="true">
                                                                    <ul class="my-menu small-font text-right">
                                                                        <li><a v-on:click.prevent=""><i class="fa fa-pencil-square-o size-16"></i>  ویرایش</a></li>
                                                                        <li><a v-on:click.prevent=""><i class="fa fa-trash-o size-16"></i>  حذف</a></li>
                                                                        <li><a v-on:click.prevent="openApCreditSourceInsertModal(project.id ,1)"><i class="fa fa-money size-16"></i>  اعتبارات</a></li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td  v-show="selectColumn">
                                                        <input class="auto-margin" v-model="project.checked" type="checkbox">
                                                    </td>
                                                </tr>
                                                <tr v-if="pIndex > 0" v-show="displayCreditSourceInfo_nat == project.id">
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
                                                                <th>توضیحات</th>
                                                            </tr>
                                                            </thead>
                                                            <tbody>
                                                            <tr v-for="creditSource in project.credit_source">
                                                                <td>{{ creditSource.credit_distribution_row.cdSubject }}</td>
                                                                <td>{{ creditSource.tiny_season.season_title.season.sSubject }}</td>
                                                                <td>{{ creditSource.tiny_season.season_title.castSubject }}</td>
                                                                <td>{{ creditSource.tiny_season.catsSubject }}</td>
                                                                <td>{{ creditSource.how_to_run.htrSubject }}</td>
                                                                <td>{{ $parent.calcDispAmount(creditSource.ccsAmount , false) }}</td>
                                                                <td>{{ creditSource.ccsDescription }}</td>
                                                            </tr>
                                                            </tbody>
                                                        </table>
                                                    </td>
                                                </tr>
                                            </template>
                                        </template>

                                        </tbody>
                                    </table>
                                </div>
                            </div>






                            <!--<div class="columns">
                               &lt;!&ndash;Header Start&ndash;&gt;
                                <div class="grid-x table-header">
                                    <div class="medium-2 table-border">
                                        <strong>کد طرح</strong>
                                    </div>
                                    <div class="medium-10">
                                        <div class="grid-x">
                                            <div class="medium-1 table-border">
                                                <strong>کد</strong>
                                            </div>
                                            <div class="medium-3 table-border">
                                                <strong>عنوان</strong>
                                            </div>
                                            <div class="medium-2 table-border">
                                                <strong>شهرستان</strong>
                                            </div>
                                            <div class="medium-2 table-border">
                                                <strong>اعتبار</strong>
                                            </div>
                                            <div class="medium-4  table-border">
                                                <strong>شرح</strong>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                &lt;!&ndash;Header End&ndash;&gt;
                                <div class="table-contain dynamic-height-level2">
                                    <div class="grid-x" v-for="plans in approvedProjects_nat">
                                        <div class="medium-2 table-contain-border cell-vertical-center">
                                            {{ plans.credit_distribution_title.cdtIdNumber + ' - ' + plans.credit_distribution_title.cdtSubject }}
                                        </div>
                                        <div class="medium-10">
                                            <div class="grid-x selectAbleRow" v-for="projects in plans.capital_assets_project">
                                                <div class="medium-1 table-contain-border cell-vertical-center">
                                                    {{ projects.cpCode }}
                                                </div>
                                                <div class="medium-3 table-contain-border cell-vertical-center">
                                                    {{ projects.cpSubject }}
                                                </div>
                                                <div class="medium-2 table-contain-border cell-vertical-center">
                                                    {{ projects.county.coName }}
                                                </div>
                                                <div class="medium-2 table-contain-border cell-vertical-center">
                                                    <span @click="displayCreditSourceInfo_nat == projects.id ? displayCreditSourceInfo_nat = '' : displayCreditSourceInfo_nat = projects.id">{{ $parent.calcDispAmount(sumOfAmount(projects.credit_source) , false) }}</span>
                                                </div>
                                                <div class="medium-4  table-contain-border cell-vertical-center">
                                                    <div class="grid-x">
                                                        <div class="medium-11">
                                                            {{ projects.cpDescription }}
                                                        </div>
                                                        <div class="medium-1 cell-vertical-center text-left">
                                                            <a class="dropdown small sm-btn-align"  type="button" :data-toggle="'apApprovedProjects' + projects.id"><i class="fa fa-ellipsis-v size-18"></i></a>
                                                            <div class="dropdown-pane dropdown-pane-sm " data-close-on-click="true"  data-hover="true" data-hover-pane="true"  data-position="bottom" data-alignment="right" :id="'apApprovedProjects' + projects.id" data-dropdown data-auto-focus="true">
                                                                <ul class="my-menu small-font text-right">
                                                                    <li><a v-on:click.prevent="approvedProjectsUpdateDialog(projects , plans.id)"><i class="fa fa-pencil-square-o size-16"></i>  ویرایش</a></li>
                                                                    <li><a v-on:click.prevent="openDeleteApprovedProjectsConfirm(projects)"><i class="fa fa-trash-o size-16"></i>  حذف</a></li>
                                                                    <li><a v-on:click.prevent="openApCreditSourceInsertModal(projects.id , 1)"><i class="fa fa-money size-16"></i>  اعتبارات</a></li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="medium-12">
                                                    <div class="grid-x" v-show="displayCreditSourceInfo_nat == projects.id">
                                                        <div class="medium-12 table-contain-border cell-vertical-center">
                                                            <table class="unstriped tbl-secondary-mrg small-font">
                                                                <thead class="my-thead">
                                                                <tr style="background-color: #F1F1F1 !important;">
                                                                    <th>ردیف</th>
                                                                    <th>فصل</th>
                                                                    <th>عنوان فصل</th>
                                                                    <th>ریز فصل</th>
                                                                    <th>نحوه اجرا</th>
                                                                    <th>مبلغ</th>
                                                                    <th>توضیحات</th>
                                                                </tr>
                                                                </thead>
                                                                <tbody>
                                                                <tr v-for="creditSource in projects.credit_source">
                                                                    <td>{{ creditSource.credit_distribution_row.cdSubject }}</td>
                                                                    <td>{{ creditSource.tiny_season.season_title.season.sSubject }}</td>
                                                                    <td>{{ creditSource.tiny_season.season_title.castSubject }}</td>
                                                                    <td>{{ creditSource.tiny_season.catsSubject }}</td>
                                                                    <td>{{ creditSource.how_to_run.htrSubject }}</td>
                                                                    <td>{{ $parent.calcDispAmount(creditSource.ccsAmount , false) }}</td>
                                                                    <td>{{ creditSource.ccsDescription }}</td>
                                                                </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>-->
                            <div class="grid-x">
                                <div class="medium-8">
                                    <vue-pagination  v-bind:pagination="national_pagination"
                                                     v-on:click.native="fetchNationalData(national_pagination.current_page)"
                                                     :offset="4">
                                    </vue-pagination>
                                </div>
                                <div style="color: #575962;" v-show="selectColumn" class="medium-4 small-font">
                                    <div class="float-left">
                                        <p> تعداد رکورد های انتخاب شده :<span class="selected-row-style">{{ selectedLength(approvedProjects_nat) }}</span></p>
                                    </div>
                                </div>
                            </div>
                        </div><!--Tab nat End-->
                    </div>
                </div>
            </div>
            </div>
            <!--Forms Start-->
            <!--Insert Modal Start-->
            <!-- use the modal component, pass in the prop -->
            <modal-small v-if="showInsertModal" @close="showInsertModal = false">
                    <div slot="body">
                        <form v-on:submit.prevent="createApprovedProjects">
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
                                        <select class="form-element-margin-btm"  v-model="approvedProjectsInput.apPlan" name="plan" v-validate data-vv-rules="required" :class="{'input': true, 'select-error': errors.has('plan')}">
                                            <option value=""></option>
                                            <option v-for="approvedPlan in approvedPlans" @click="setCountyId(approvedPlan.credit_distribution_title.county.id)" :value="approvedPlan.id">{{ approvedPlan.credit_distribution_title.cdtIdNumber + ' - ' + approvedPlan.credit_distribution_title.cdtSubject + (approvedPlan.credit_distribution_title.county == null ? '' : ' - ' + approvedPlan.credit_distribution_title.county.coName)}}</option>
                                        </select>
                                        <span v-show="errors.has('plan')" class="error-font">لطفا طرح را انتخاب کنید!</span>
                                    </label>
                                </div>
                            </div>
                            <div class="grid-x">
                                <div class="medium-8 cell padding-lr">
                                    <label>عنوان پروژه
                                        <input class="form-element-margin-btm" type="text" name="projectTitle" v-model="approvedProjectsInput.apProjectTitle" v-validate="'required'" :class="{'input': true, 'error-border': errors.has('projectTitle')}">
                                    </label>
                                    <span v-show="errors.has('projectTitle')" class="error-font">لطفا عنوان پروژه انتخاب کنید!</span>
                                </div>
                                <div class="medium-4 cell padding-lr">
                                    <label>کد پروژه
                                        <input class="form-element-margin-btm" type="text" name="projectCode" v-model="approvedProjectsInput.apProjectCode" v-validate="'required|numeric'" :class="{'input': true, 'error-border': errors.has('projectCode')}">
                                    </label>
                                    <span v-show="errors.has('projectCode')" class="error-font">لطفا کد پروژه انتخاب کنید!</span>
                                </div>
                            </div>
                            <div class="grid-x">
                                <div class="medium-4 cell padding-lr">
                                    <label>سال شروع
                                        <input class="form-element-margin-btm datePickerClass" type="text" name="startYear" v-model="approvedProjectsInput.apStartYear" v-validate="'required'" :class="{'input': true, 'error-border': errors.has('startYear')}">
                                    </label>
                                    <span v-show="errors.has('startYear')" class="error-font">لطفا سال شروع پروژه را وارد کنید!</span>
                                </div>
                                <div class="medium-4 cell padding-lr">
                                    <label>سال خاتمه
                                        <input class="form-element-margin-btm datePickerClass" type="text" name="endYear" v-model="approvedProjectsInput.apEndYear" v-validate="'required'" :class="{'input': true, 'error-border': errors.has('endYear')}">
                                    </label>
                                    <span v-show="errors.has('endYear')" class="error-font">لطفا سال خاتمه پروژه را وارد کنید!</span>
                                </div>
                                <div class="medium-4 cell padding-lr">
                                    <label> پیشرفت فیزیکی<span class="btn-red small-font"> (درصد) </span>
                                        <input  type="number" min="0" max="100" value="0" name="physicalProgress" v-model="approvedProjectsInput.apPhysicalProgress" v-validate="'required|numeric'" :class="{'input': true, 'error-border': errors.has('physicalProgress')}">
                                        <div style="margin-top: -16px;height:2px;" class="alert progress form-element-margin-btm">
                                            <div class="progress-meter" style="width: 100%"></div>
                                        </div>
                                    </label>
                                    <span v-show="errors.has('physicalProgress')" class="error-font">لطفا پیشرفت فیزیکی را وارد کنید!</span>
                                </div>
                                <div class="medium-4 cell padding-lr">
                                    <label>شهرستان
                                        <select class="form-element-margin-btm" :disabled="countyState" :selected="approvedProjectsInput.apCity" v-model="approvedProjectsInput.apCity" name="city" v-validate data-vv-rules="required" :class="{'input': true, 'select-error': errors.has('city')}">
                                            <option value=""></option>
                                            <option v-for="county in counties" :value="county.id">{{ county.coName }}</option>
                                        </select>
                                        <span v-show="errors.has('city')" class="error-font">لطفا شهرستان را انتخاب کنید!</span>
                                    </label>
                                </div>
                            </div>
                            <div class="grid-x">
                                <div class="small-12 columns padding-lr">
                                    <label>شرح
                                        <textarea name="apDescription" style="min-height: 150px;" v-model="approvedProjectsInput.apDescription"></textarea>
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
            <modal-small v-if="showModalUpdate" @close="showModalUpdate = false" xmlns:v-on="http://www.w3.org/1999/xhtml">
                <div  slot="body">
                    <div class="grid-x" v-if="errorMessage">
                        <div class="medium-12 columns padding-lr">
                            <div class="alert callout">
                                <p class="BYekan login-alert"><i class="fi-alert"></i>@{{ errorMessage }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="grid-x">
                        <div class="medium-12 cell padding-lr">
                            <label>طرح
                                <select class="form-element-margin-btm"  v-model="approvedProjectsFill.apPlan" name="plan" v-validate data-vv-rules="required" :class="{'input': true, 'select-error': errors.has('plan')}">
                                    <option value=""></option>
                                    <option v-for="approvedPlan in approvedPlans" :value="approvedPlan.id">{{ approvedPlan.credit_distribution_title.cdtIdNumber + ' - ' + approvedPlan.credit_distribution_title.cdtSubject }}</option>
                                </select>
                                <span v-show="errors.has('plan')" class="error-font">لطفا طرح را انتخاب کنید!</span>
                            </label>
                        </div>
                    </div>
                    <div class="grid-x">
                        <div class="medium-8 cell padding-lr">
                            <label>عنوان پروژه
                                <input class="form-element-margin-btm" type="text" name="projectTitle" v-model="approvedProjectsFill.apProjectTitle" v-validate="'required'" :class="{'input': true, 'error-border': errors.has('projectTitle')}">
                            </label>
                            <span v-show="errors.has('projectTitle')" class="error-font">لطفا عنوان پروژه انتخاب کنید!</span>
                        </div>
                        <div class="medium-4 cell padding-lr">
                            <label>کد پروژه
                                <input class="form-element-margin-btm" type="text" name="projectCode" v-model="approvedProjectsFill.apProjectCode" v-validate="'required|numeric'" :class="{'input': true, 'error-border': errors.has('projectCode')}">
                            </label>
                            <span v-show="errors.has('projectTitle')" class="error-font">لطفا کد پروژه انتخاب کنید!</span>
                        </div>
                    </div>
                    <div class="grid-x">
                        <div class="medium-4 cell padding-lr">
                            <label>سال شروع
                                <input class="form-element-margin-btm" type="text" name="startYear" v-model="approvedProjectsFill.apStartYear" v-validate="'required'" :class="{'input': true, 'error-border': errors.has('startYear')}">
                            </label>
                            <span v-show="errors.has('startYear')" class="error-font">لطفا سال شروع پروژه را وارد کنید!</span>
                        </div>
                        <div class="medium-4 cell padding-lr">
                            <label>سال خاتمه
                                <input class="form-element-margin-btm" type="text" name="endYear" v-model="approvedProjectsFill.apEndYear" v-validate="'required|numeric'" :class="{'input': true, 'error-border': errors.has('endYear')}">
                            </label>
                            <span v-show="errors.has('endYear')" class="error-font">لطفا سال خاتمه پروژه را وارد کنید!</span>
                        </div>
                        <div class="medium-4 cell padding-lr">
                            <label> پیشرفت فیزیکی<span class="btn-red small-font"> (درصد) </span>
                                <input  type="number" min="0" max="100" value="0"  name="physicalProgress" v-model="approvedProjectsFill.apPhysicalProgress" v-validate="'required|numeric'" :class="{'input': true, 'error-border': errors.has('physicalProgress')}">
                            </label>
                            <span v-show="errors.has('physicalProgress')" class="error-font">لطفا پیشرفت فیزیکی را وارد کنید!</span>
                        </div>
                        <div class="medium-4 cell padding-lr">
                            <label>شهرستان
                                <select class="form-element-margin-btm" v-model="approvedProjectsFill.apCity" name="city" v-validate data-vv-rules="required" :class="{'input': true, 'select-error': errors.has('city')}">
                                    <option value=""></option>
                                    <option v-for="county in counties" :value="county.id">@{{ county.coName }}</option>
                                </select>
                                <span v-show="errors.has('city')" class="error-font">لطفا شهرستان را انتخاب کنید!</span>
                            </label>
                        </div>
                    </div>
                    <div class="grid-x">
                        <div class="small-12 columns padding-lr">
                            <label>شرح
                                <textarea name="apDescription" style="min-height: 150px;" v-model="approvedProjectsFill.apDescription"></textarea>
                            </label>
                        </div>
                    </div>
                    <div class="medium-6 columns padding-lr padding-bottom-modal">
                        <button name="Submit" class="my-button my-success float-left btn-for-load"> <span class="btn-txt-mrg">ثبت</span></button>
                    </div>
                </div>
            </modal-small>
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

            <!--Project credit source Modal Start-->
            <modal-small v-if="showApCsInsertModal" @close="showApCsInsertModal = false">
                <div  slot="body">
                    <form v-on:submit.prevent="createApprovedProjectCreditSource">
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
                                    <select  class="form-element-margin-btm"  name="row" v-model="apCreditSourceInput.crId" v-validate data-vv-rules="required" :class="{'input': true, 'select-error': errors.has('row')}">
                                        <option value=""></option>
                                        <option v-for="creditDistributionRow in creditDistributionRows" :value="creditDistributionRow.id">{{ creditDistributionRow.cdSubject }}</option>
                                    </select>
                                    <span v-show="errors.has('row')" class="error-font">لطفا ردیف توزیع را انتخاب کنید!</span>
                                </label>
                            </div>
                            <div class="medium-3 cell padding-lr">
                                <label>نحوه اجرا
                                    <select class="form-element-margin-btm" name="howToRun" v-model="apCreditSourceInput.htrId" v-validate data-vv-rules="required" :class="{'input': true, 'select-error': errors.has('howToRun')}">
                                        <option value=""></option>
                                        <option v-for="howToRun in howToRuns" :value="howToRun.id">{{ howToRun.htrSubject }}</option>
                                    </select>
                                    <span v-show="errors.has('howToRun')" class="error-font">لطفا نحوه اجرا را انتخاب کنید!</span>
                                </label>
                            </div>
                        </div>
                        <div class="grid-x">
                            <div class="medium-4 column padding-lr">
                                <label>فصل
                                    <select class="form-element-margin-btm" v-model="selectedSeason" @change="getSeasonTitle"  name="season" v-validate data-vv-rules="required" :class="{'input': true, 'select-error': errors.has('season')}">
                                        <option value=""></option>
                                        <option v-for="season in seasons" :value="season.id">{{ season.sSubject }}</option>
                                    </select>
                                    <span v-show="errors.has('season')" class="error-font">لطفا فصل را انتخاب کنید!</span>
                                </label>
                            </div>
                            <div class="medium-8 column padding-lr">
                                <label>عنوان فصل
                                    <select class="form-element-margin-btm" v-model="selectedSeasonTitle" @change="getTinySeasons" name="seasonTitle" v-validate data-vv-rules="required" :class="{'input': true, 'select-error': errors.has('seasonTitle')}">
                                        <option value=""></option>
                                        <option v-for="seasonTitle in seasonTitles" :value="seasonTitle.id">{{ seasonTitle.castSubject }}</option>
                                    </select>
                                    <span v-show="errors.has('seasonTitle')" class="error-font">لطفا عنوان فصل را انتخاب کنید!</span>
                                </label>
                            </div>
                        </div>
                        <div class="grid-x">
                            <div class="medium-12 column padding-lr">
                                <label>ریز فصل
                                    <select class="form-element-margin-btm" v-model="apCreditSourceInput.tsId" name="subSeason" v-validate data-vv-rules="required" :class="{'input': true, 'select-error': errors.has('subSeason')}">
                                        <option value=""></option>
                                        <option v-for="tinySeason in tinySeasons" :value="tinySeason.id">{{ tinySeason.catsSubject }}</option>
                                    </select>
                                    <span v-show="errors.has('subSeason')" class="error-font">لطفا ریز فصل را انتخاب کنید!</span>
                                </label>
                            </div>
                        </div>
                        <div class="grid-x">
                            <div class="medium-6 cell padding-lr">
                                <label>مبلغ اعتبار <span class="btn-red">{{ '(' + $parent.getAmountBaseLabel() + ')' }}</span>
                                    <input class="form-element-margin-btm" type="text" name="amount" v-model="apCreditSourceInput.csAmount" v-validate="'required|decimal'" :class="{'input': true, 'error-border': errors.has('amount')}">
                                </label>
                                <span v-show="errors.has('amount')" class="error-font">لطفا مبلغ اعتبار پروژه را وارد کنید!</span>
                            </div>
                        </div>
                        <div class="grid-x">
                            <div class="small-12 columns padding-lr">
                                <label>شرح
                                    <textarea name="csDescription" style="min-height: 150px;" v-model="apCreditSourceInput.csDescription"></textarea>
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
            <!--Report Modal Start-->
            <modal-tiny v-if="showModalReport" @close="showModalReport= false">
                <div  slot="body">
                    <div class="small-font">
                        <form v-on:submit.prevent="openPdfFile">
                            <div class="grid-x padding-lr">
                                <div class="medium-12">
                                    <label>عنوان
                                        <input type="text" v-model="reportOptions.title">
                                    </label>
                                </div>
                            </div>
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
                            <div class="medium-12 columns padding-lr padding-bottom-modal input-margin-top">
                                <button name="Submit" class="my-button my-success float-left btn-for-load"> <span class="btn-txt-mrg">مشاهده</span></button>
                            </div>
                        </form>
                    </div>
                </div>
            </modal-tiny>
            <!--Report Modal End-->

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
                approvedProjects_prov: [],
                approvedProjects_nat: [],
                approvedProjectsInput: {apPlan: '' , apProjectTitle: '' , apProjectCode: '' , apStartYear: '', apEndYear: '',
                                        apPhysicalProgress: '', apCity: '' , apDescription: ''},
                showInsertModal: false,
                showApCsInsertModal: false,
                showModalUpdate: false,
                showModalDelete: false,
                showModalReport:false,
                approvedProjectsFill: {apPlan: '' , apProjectTitle: '' , apProjectCode: '' , apStartYear: '', apEndYear: '',
                    apHowToRun: '', apPhysicalProgress: '', aCity: '', apSubSeason: ''
                    , apLocation: '', apDescription: '',apCredit:''},

                apCreditSourceInput: {},
                capIdForInsertCreditSource: '',
                displayCreditSourceInfo_prov: '',
                displayParentId_prov: '',
                displayCreditSourceInfo_nat: '',
                displayParentId_nat: '',
                provOrNat: '',
                apIdDelete: {},
                approvedPlans: {},
                counties: {},
                countyState: false,
                selectColumn:false,
                seasons: {},
                seasonTitles: {},
                tinySeasons: {},
                selectedSeasons: '',
                selectedSeasonTitle: '',
                creditDistributionRows: {},
                selectedItems: [],
                selectedCount: 0,
                reportOptions: {title:'' , withReporterName: true , withFiscalYear: true , withReportDate: true , orientation: true},
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
            //
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
                axios.get('/budget/approved_project/capital_assets/fetchData?page=' + page , {params:{pOrN: 0}})
                    .then((response) => {
                        this.approvedProjects_prov = response.data.data;
                        this.selectAll(this.approvedProjects_prov);
                        this.makePagination(response.data , "provincial");
                        console.log(response);
                    },(error) => {
                        console.log(error);
                    });
            },

            fetchNationalData: function (page = 1) {
                axios.get('/budget/approved_project/capital_assets/fetchData?page=' + page , {params:{pOrN: 1}})
                    .then((response) => {
                        this.approvedProjects_nat = response.data.data;
                        this.selectAll(this.approvedProjects_nat);
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

            getHowToRun: function () {
                axios.get('/budget/admin/how_to_run/getAllItems')
                    .then((response) => {
                        this.howToRuns = response.data;
                        console.log(response);
                    },(error) => {
                        console.log(error);
                    });
            },

            getCounties: function () {
                axios.get('/admin/get_all_counties' , {params:{}})
                    .then((response) => {
                        this.counties = response.data;
                        console.log(response);
                    },(error) => {
                        console.log(error);
                    });
            },

            getSeasons: function () {
                axios.get('/admin/get_all_seasons' , {params:{}})
                    .then((response) => {
                        this.seasons = response.data;
                        console.log(response);
                    },(error) => {
                        console.log(error);
                    });
            },

            getSeasonTitle: function () {
                axios.get('/budget/admin/season_title/capital_assets/getWithSeasonId' , {params:{sId: this.selectedSeason}}).then((response) => {
                this.seasonTitles = response.data;
                console.log(response);
            },(error) => {
                    console.log(error);
                });
            },

            getTinySeasons: function () {
                axios.get('/budget/admin/sub_seasons/capital_assets/getAllItem' , {params:{castId: this.selectedSeasonTitle}})
                    .then((response) => {
                        this.tinySeasons = response.data;
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

            sumOfAmount: function (items) {
                var sum = 0;
                items.forEach(item => {
                    sum += item.ccsAmount;
                });
                return sum;
            },

            openApprovedProjectInsertModal: function (type) {
                this.getAllApprovedPlan(type);
                this.getCounties();
                this.showInsertModal= true;
                this.provOrNat = type;
                if (type == 0)
                {
                    this.countyState = true;
                }
                else
                {
                    this.countyState = false;
                }
            },

            openApCreditSourceInsertModal: function (capId , type) {
                this.showApCsInsertModal = true;
                this.capIdForInsertCreditSource = capId;
                this.provOrNat = type;
                this.getHowToRun();
                this.getSeasons();
                this.getCreditDistributionRow();
            },

            createApprovedProjects: function () {
                this.$validator.validateAll().then((result) => {
                    if (result) {
                        axios.post('/budget/approved_project/capital_assets/register' , {
                            pId: this.approvedProjectsInput.apPlan,
                            subject: this.approvedProjectsInput.apProjectTitle,
                            code: this.approvedProjectsInput.apProjectCode,
                            startYear: this.approvedProjectsInput.apStartYear,
                            endYear: this.approvedProjectsInput.apEndYear,
                            pProgress: this.approvedProjectsInput.apPhysicalProgress,
                            coId: this.approvedProjectsInput.apCity,
                            description: this.approvedProjectsInput.apDescription,
                            pOrN: this.provOrNat
                        }).then((response) => {
                                if (this.provOrNat == 0)
                                {
                                    this.approvedProjects_prov = response.data.data;
                                    this.makePagination(response.data , "provincial");
                                }
                                else
                                {
                                    this.approvedProjects_nat = response.data.data;
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
                });
            },

            createApprovedProjectCreditSource: function () {
                this.$validator.validateAll().then((result) => {
                    if (result) {
                        axios.post('/budget/approved_project/capital_assets/credit_source/register' , {
                            capId: this.capIdForInsertCreditSource,
                            crId: this.apCreditSourceInput.crId,
                            htrId: this.apCreditSourceInput.htrId,
                            tsId: this.apCreditSourceInput.tsId,
                            amount: this.apCreditSourceInput.csAmount,
                            description: this.apCreditSourceInput.csDescription,
                            pOrN: this.provOrNat
                        }).then((response) => {
                            if (this.provOrNat == 0)
                            {
                                this.approvedProjects_prov = response.data.data;
                                this.makePagination(response.data , "provincial");
                            }
                            else
                            {
                                this.approvedProjects_nat = response.data.data;
                                this.makePagination(response.data , "national");
                            }
                            this.showApCsInsertModal = false;
                            this.$parent.displayNotif(response.status);
                            console.log(response);
                        },(error) => {
                            console.log(error);
                            //this.errorMessage = 'ریز فصل با این مشخصات قبلا ثبت شده است!';
                        });
                    }
                });
            },

            setCountyId: function (coId) {
                if (this.provOrNat == 0)
                {
                    this.approvedProjectsInput.apCity = coId;
                }
            },

            getProjectAmount: function (cdrCp) {
                var sum = 0;
                cdrCp.forEach(cdr => {
                    "use strict";
                    sum += cdr.ccAmount;
                });
                return sum;
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
            openReportModal: function (proOrNat) {
                this.provOrNat = proOrNat;
                this.selectedItems = [];
                if (proOrNat == 0)
                {
                    if (this.selectedLength(this.approvedProjects_prov) != 0)
                    {
                        this.showModalReport = true;
                        this.approvedProjects_prov.forEach(plan => {
                            if (plan.checked == true)
                                this.selectedItems.push(plan);
                        });
                        this.reportOptions.title = 'پروژه های مصوب تملک داریی های سرمایه ای استانی';
                    }
                    else{
                        this.$parent.displayNotif(800);
                    }
                }
                else {
                    if (this.selectedLength(this.approvedProjects_nat) != 0)
                    {
                        this.showModalReport = true;
                        this.approvedProjects_nat.forEach(plan => {
                            if (plan.checked == true)
                                this.selectedItems.push(plan);
                        });
                        this.reportOptions.title = 'پروژه های مصوب تملک داریی های سرمایه ای ملی';
                    }
                    else{
                        this.$parent.displayNotif(800);
                    }
                }

                console.log(JSON.stringify(this.selectedItems));
            },

            openPdfFile: function () {
                axios.get('/budget/approved_project/capital_assets/report' , {params:{pOrN: this.provOrNat ,options: this.reportOptions , selectedItems: this.selectedItems}})
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
                    plan.capital_assets_project.forEach(project => {
                        if (project.checked)
                            temp = true;

                    });
                });
                plans.forEach(plan => {
                    if(temp){
                        plan.capital_assets_project.forEach(project => {
                            project.checked = false;

                        });
                    } else {
                        plan.capital_assets_project.forEach(project => {
                            project.checked = true;
                        });
                    }
                });
                console.log(JSON.stringify(this.approvedProjects_prov));
            },

            allSelected: function(plans) {
                var temp = true;
                console.log(JSON.stringify(this.approvedProjects_prov));
                plans.forEach(plan => {
                    plan.capital_assets_project.forEach(project => {
                        if (project.checked == false)
                            temp = false;
                    });
                });
                return temp;
            },

            selectAll: function (plans) {
                plans.forEach(plan => {
                    plan.capital_assets_project.forEach(project => {
                        this.$set(project, 'checked' , true);
                    });
                });
            },

            selectedLength: function (plans) {
                return plans.filter(function (value) {
                    return value.checked === true;
                }).length;
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

            openAccordion:function (type,id,pId) {
                if(type == 0)
                {
                    if(this.displayCreditSourceInfo_prov == id)
                    {
                        this.displayCreditSourceInfo_prov = '';
                        this.displayParentId_prov = '';
                    }
                    else
                    {
                        this.displayCreditSourceInfo_prov = id;
                        this.displayParentId_prov = pId;
                    }

                }
                else if (type==1)
                {
                    if(this.displayCreditSourceInfo_nat == id)
                    {
                        this.displayCreditSourceInfo_nat= '';
                        this.displayParentId_nat = '';
                    }
                    else
                    {
                        this.displayCreditSourceInfo_nat = id;
                        this.displayParentId_nat = pId;
                    }
                }
            }
        }
    }

</script>
