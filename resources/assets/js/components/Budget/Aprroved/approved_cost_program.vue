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
                                <a class="disabled">هزینه ای</a>
                            </li>
                            <li>
                                <span class="show-for-sr">Current: </span>برنامه ها
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
        <div class="grid-x  my-callout-box container-mrg-top dynamic-height-level1">
            <div  class="medium-12 column">
                <ul class="tabs tab-color my-tab-style" data-responsive-accordion-tabs="tabs medium-accordion large-tabs" id="approved_cost_program_tab_view">
                    <li class="tabs-title is-active"><a href="#provincial_tab" aria-selected="true">استانی</a></li>
                    <li class="tabs-title"><a href="#national_tab">ملی</a></li>
                </ul>
                <div class="tabs-content" data-tabs-content="approved_cost_program_tab_view">
                    <div class="tabs-panel is-active table-mrg-btm" id="provincial_tab"
                         xmlns:v-on="http://www.w3.org/1999/xhtml">
                        <div class="medium-12 bottom-mrg">
                            <!--Tab 1-->
                            <div class="clearfix border-btm-line bottom-mrg tool-bar">
                                <div style="margin-top: 2px;" class="button-group float-right report-mrg">
                                    <a class="my-button toolbox-btn small" @click="openCostAgreementInsertModal(0)">جدید</a>
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
                                        <col width="150px"/>
                                        <col width="100px"/>
                                        <col width="100px"/>
                                        <col width="100px"/>
                                        <col width="150px"/>
                                        <col v-show="selectColumn" width="15px"/>
                                        <col width="12px"/>

                                    </colgroup>
                                    <tbody class="tbl-head-style">
                                    <tr class="tbl-head-style-cell">
                                        <th class="tbl-head-style-cell">شماره مبادله</th>
                                        <th class="tbl-head-style-cell">تاریخ مبادله</th>
                                        <th class="tbl-head-style-cell">شماره ابلاغ</th>
                                        <th class="tbl-head-style-cell">تاریخ ابلاغ</th>
                                        <th class="tbl-head-style-cell">اعتبار</th>
                                        <th class="tbl-head-style-cell">اصلاحیه</th>
                                        <th class="tbl-head-style-cell">شرح</th>
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
                                            <col width="150px"/>
                                            <col width="100px"/>
                                            <col width="100px"/>
                                            <col width="100px"/>
                                            <col width="150px"/>
                                            <col v-show="selectColumn" width="15px"/>
                                        </colgroup>
                                        <tbody class="tbl-head-style-cell">
                                        <template  v-for="cAp in costAgreement_prov">
                                            <tr>
                                                <td class="text-center">{{ cAp.caLetterNumber }}</td>
                                                <td class="text-center">{{ cAp.caLetterDate }}</td>
                                                <td class="text-center">{{ cAp.caExchangeIdNumber }}</td>
                                                <td class="text-center">{{ cAp.caExchangeDate }}</td>
                                                <td class="text-center"><span @click="displayCreditSourceInfo_prov == cAp.id ? displayCreditSourceInfo_prov = '' : displayCreditSourceInfo_prov = cAp.id">{{ $parent.calcDispAmount(sumOfAmount(cAp.ca_credit_source) , false) }}</span></td>
                                                <td class="text-center">
                                                    <span @click="displayAmendmentInfo_prov == cAp.id ? (displayAmendmentInfo_prov = '') : (displayAmendmentInfo_prov = cAp.id)" v-show="cAp.amendments.length > 0" class="info-badage change-pointer">تاریخچه</span>
                                                </td>
                                                <td>
                                                    <div class="grid-x">
                                                        <div class="medium-11">
                                                            {{ cAp.caDescription }}
                                                        </div>
                                                        <div class="medium-1 cell-vertical-center text-left">
                                                            <a class="dropdown small sm-btn-align"  type="button" :data-toggle="'costAgreement' + cAp.id"><i class="fa fa-ellipsis-v size-18"></i></a>
                                                            <div class="dropdown-pane dropdown-pane-sm " data-close-on-click="true"  data-hover="true" data-hover-pane="true"  data-position="bottom" data-alignment="right" :id="'costAgreement' + cAp.id" data-dropdown data-auto-focus="true">
                                                                <ul class="my-menu small-font text-right">
                                                                    <li><a v-on:click.prevent="openUpdateModal(cAp)"><i class="fa fa-pencil-square-o size-16"></i>  ویرایش</a></li>
                                                                    <li><a v-on:click.prevent="openDeleteModal(cAp.id , 0)"><i class="fa fa-trash-o size-16"></i>  حذف</a></li>
                                                                    <li><a v-on:click.prevent="openCreditSourceInsertModal(cAp.id , 0)"><i class="fa fa-money size-16"></i>  اعتبارات</a></li>
                                                                    <li><a v-on:click.prevent="openAmendmentTempModal(cAp)"><i class="fa fa-newspaper-o size-16"></i>  اصلاحیه</a></li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td  v-show="selectColumn">
                                                    <input class="auto-margin" id="checkboxProv" type="checkbox">
                                                </td>
                                            </tr>
                                            <tr v-show="displayCreditSourceInfo_prov == cAp.id">
                                                <td colspan="7">
                                                    <table class="unstriped tbl-secondary-mrg small-font">
                                                        <thead class="my-thead">
                                                        <tr style="background-color: #F1F1F1 !important;">
                                                            <th>برنامه</th>
                                                            <th>ردیف</th>
                                                            <th>فصل</th>
                                                            <th>عنوان فصل</th>
                                                            <th>ریز فصل</th>
                                                            <th>مبلغ</th>
                                                            <th>توضیحات</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        <tr v-for="creditSource in cAp.ca_credit_source">
                                                            <td>{{ creditSource.credit_distribution_title.cdtIdNumber + ' - ' + creditSource.credit_distribution_title.cdtSubject }}</td>
                                                            <td>{{ creditSource.credit_distribution_row.cdSubject }}</td>
                                                            <td class="text-center">{{ creditSource.tiny_season.season_title.season.sSubject }}</td>
                                                            <td>{{ creditSource.tiny_season.season_title.cstSubject }}</td>
                                                            <td>{{ creditSource.tiny_season.ctsSubject }}</td>
                                                            <td class="text-center">{{ $parent.calcDispAmount(creditSource.ccsAmount , false) }}</td>
                                                            <td>
                                                                <div class="grid-x">
                                                                    <div class="medium-11">
                                                                        {{ creditSource.ccsDescription }}
                                                                    </div>
                                                                    <div class="medium-1 cell-vertical-center text-left">
                                                                        <a class="dropdown small sm-btn-align"  type="button" :data-toggle="'costAgreement_cs' + cAp.id + creditSource.id"><i class="fa fa-ellipsis-v size-18"></i></a>
                                                                        <div class="dropdown-pane dropdown-pane-sm " data-close-on-click="true"  data-hover="true" data-hover-pane="true"  data-position="bottom" data-alignment="right" :id="'costAgreement_cs' + cAp.id + creditSource.id" data-dropdown data-auto-focus="true">
                                                                            <ul class="my-menu small-font text-right">
                                                                                <li><a v-on:click.prevent="openCaCsUpdateModal(creditSource , 0)"><i class="fa fa-pencil-square-o size-16"></i>  ویرایش</a></li>
                                                                                <li><a v-on:click.prevent="openCaCsDeleteModal(creditSource.id , 0)"><i class="fa fa-trash-o size-16"></i>  حذف</a></li>
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
                                            <tr v-if="cAp.amendments.length > 0" v-show="displayAmendmentInfo_prov == cAp.id">
                                                <td colspan="7">
                                                    <table class="unstriped tbl-secondary-mrg small-font">
                                                        <thead class="my-thead">
                                                        <tr style="background-color: #F1F1F1 !important;">
                                                            <th>شماره مبادله</th>
                                                            <th>تاریخ مبادله</th>
                                                            <th>شماره ابلاغ</th>
                                                            <th>تاریخ ابلاغ</th>
                                                            <th>اعتبار</th>
                                                            <th>شرح</th>
                                                            <th></th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        <tr v-for="amendment in cAp.amendments">
                                                            <td class="text-center">{{ amendment.caExchangeIdNumber }}</td>
                                                            <td class="text-center">{{ amendment.caExchangeDate }}</td>
                                                            <td class="text-center">{{ amendment.caLetterNumber }}</td>
                                                            <td class="text-center">{{ amendment.caLetterDate }}</td>
                                                            <td class="text-center">{{ $parent.calcDispAmount(sumOfAmount(amendment.ca_credit_source) , false) }}</td>
                                                            <td>
                                                                {{ amendment.caDescription }}
                                                            </td>
                                                            <td class="text-center">
                                                                <a @click="openAmendmentProgInfoModal(amendment)">جزئیات</a>
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
                                    <a class="my-button toolbox-btn small" @click="openCostAgreementInsertModal(1)">جدید</a>
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
                                    <button class="my-button toolbox-btn small dropdown small sm-btn-align"  type="button" data-toggle="nationalDropDown">تعداد نمایش<span> 20 </span></button>
                                    <div  style="width: 113px;" class="dropdown-pane dropdown-pane-sm " data-close-on-click="true"  data-hover="true" data-hover-pane="true"  data-position="bottom" data-alignment="left" id="nationalDropDown" data-dropdown data-auto-focus="true">
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
                                        <col width="150px"/>
                                        <col width="100px"/>
                                        <col width="200px"/>
                                        <col v-show="selectColumn" width="15px"/>
                                        <col width="12px"/>

                                    </colgroup>
                                    <tbody class="tbl-head-style">
                                    <tr class="tbl-head-style-cell">
                                        <th class="tbl-head-style-cell">شماره ابلاغ</th>
                                        <th class="tbl-head-style-cell">تاریخ ابلاغ</th>
                                        <th class="tbl-head-style-cell">اعتبار</th>
                                        <th class="tbl-head-style-cell">اصلاحیه</th>
                                        <th class="tbl-head-style-cell">شرح</th>
                                        <th class="tbl-head-style-checkbox" v-show="selectColumn"><input id="checkboxColumnNational" type="checkbox"></th>
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
                                            <col width="150px"/>
                                            <col width="100px"/>
                                            <col width="200px"/>
                                            <col v-show="selectColumn" width="15px"/>
                                        </colgroup>
                                        <tbody class="tbl-head-style-cell">
                                        <template  v-for="cAp in costAgreement_nat">
                                            <tr>
                                                <td class="text-center">{{ cAp.caLetterNumber }}</td>
                                                <td class="text-center">{{ cAp.caLetterDate }}</td>
                                                <td class="text-center"><span @click="displayCreditSourceInfo_nat == cAp.id ? displayCreditSourceInfo_nat = '' : displayCreditSourceInfo_nat = cAp.id">{{ $parent.calcDispAmount(sumOfAmount(cAp.ca_credit_source) , false) }}</span></td>
                                                <td class="text-center">
                                                    <span @click="displayAmendmentInfo_nat == cAp.id ? (displayAmendmentInfo_nat = '') : (displayAmendmentInfo_nat = cAp.id)" v-show="cAp.amendments.length > 0" class="info-badage change-pointer">تاریخچه</span>
                                                </td>
                                                <td>
                                                    <div class="grid-x">
                                                        <div class="medium-11">
                                                            {{ cAp.caDescription }}
                                                        </div>
                                                        <div class="medium-1 cell-vertical-center text-left">
                                                            <a class="dropdown small sm-btn-align"  type="button" :data-toggle="'costAgreement' + cAp.id"><i class="fa fa-ellipsis-v size-18"></i></a>
                                                            <div class="dropdown-pane dropdown-pane-sm " data-close-on-click="true"  data-hover="true" data-hover-pane="true"  data-position="bottom" data-alignment="right" :id="'costAgreement' + cAp.id" data-dropdown data-auto-focus="true">
                                                                <ul class="my-menu small-font text-right">
                                                                    <li><a v-on:click.prevent="openUpdateModal(cAp)"><i class="fa fa-pencil-square-o size-16"></i>  ویرایش</a></li>
                                                                    <li><a v-on:click.prevent="openDeleteModal(cAp.id , 1)"><i class="fa fa-trash-o size-16"></i>  حذف</a></li>
                                                                    <li><a v-on:click.prevent="openCreditSourceInsertModal(cAp.id , 1)"><i class="fa fa-money size-16"></i>  اعتبارات</a></li>
                                                                    <li><a v-on:click.prevent="openAmendmentTempModal(cAp)"><i class="fa fa-newspaper-o size-16"></i>  اصلاحیه</a></li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td  v-show="selectColumn">
                                                    <input class="auto-margin" id="checkboxNational" type="checkbox">
                                                </td>
                                            </tr>
                                            <tr v-show="displayCreditSourceInfo_nat == cAp.id">
                                                <td colspan="7">
                                                    <table class="unstriped tbl-secondary-mrg small-font">
                                                        <thead class="my-thead">
                                                        <tr style="background-color: #F1F1F1 !important;">
                                                            <th>برنامه</th>
                                                            <th>ردیف</th>
                                                            <th>فصل</th>
                                                            <th>عنوان فصل</th>
                                                            <th>ریز فصل</th>
                                                            <th>مبلغ</th>
                                                            <th>توضیحات</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        <tr v-for="creditSource in cAp.ca_credit_source">
                                                            <td>{{ creditSource.credit_distribution_title.cdtIdNumber + ' - ' + creditSource.credit_distribution_title.cdtSubject }}</td>
                                                            <td>{{ creditSource.credit_distribution_row.cdSubject }}</td>
                                                            <td>{{ creditSource.tiny_season.season_title.season.sSubject }}</td>
                                                            <td>{{ creditSource.tiny_season.season_title.cstSubject }}</td>
                                                            <td>{{ creditSource.tiny_season.ctsSubject }}</td>
                                                            <td class="text-center">{{ $parent.calcDispAmount(creditSource.ccsAmount , false) }}</td>
                                                            <td>
                                                                <div class="grid-x">
                                                                    <div class="medium-11">
                                                                        {{ creditSource.ccsDescription }}
                                                                    </div>
                                                                    <div class="medium-1 cell-vertical-center text-left">
                                                                        <a class="dropdown small sm-btn-align"  type="button" :data-toggle="'costAgreement_cs' + cAp.id + creditSource.id"><i class="fa fa-ellipsis-v size-18"></i></a>
                                                                        <div class="dropdown-pane dropdown-pane-sm " data-close-on-click="true"  data-hover="true" data-hover-pane="true"  data-position="bottom" data-alignment="right" :id="'costAgreement_cs' + cAp.id + creditSource.id" data-dropdown data-auto-focus="true">
                                                                            <ul class="my-menu small-font text-right">
                                                                                <li><a v-on:click.prevent="openCaCsUpdateModal(creditSource , 1)"><i class="fa fa-pencil-square-o size-16"></i>  ویرایش</a></li>
                                                                                <li><a v-on:click.prevent="openCaCsDeleteModal(creditSource.id , 1)"><i class="fa fa-trash-o size-16"></i>  حذف</a></li>
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
                                            <tr v-if="cAp.amendments.length > 0" v-show="displayAmendmentInfo_nat == cAp.id">
                                                <td colspan="5">
                                                    <table class="unstriped tbl-secondary-mrg small-font">
                                                        <thead class="my-thead">
                                                        <tr style="background-color: #F1F1F1 !important;">
                                                            <th>شماره ابلاغ</th>
                                                            <th>تاریخ ابلاغ</th>
                                                            <th>اعتبار</th>
                                                            <th>شرح</th>
                                                            <th></th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        <tr v-for="amendment in cAp.amendments">
                                                            <td class="text-center">{{ amendment.caLetterNumber }}</td>
                                                            <td class="text-center">{{ amendment.caLetterDate }}</td>
                                                            <td class="text-center">{{ $parent.calcDispAmount(sumOfAmount(amendment.ca_credit_source) , false) }}</td>
                                                            <td>
                                                                {{ amendment.caDescription }}
                                                            </td>
                                                            <td class="text-center">
                                                                <a @click="openAmendmentProgInfoModal(amendment)">جزئیات</a>
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
                        </div>
                    </div>
                </div>
            </div>
            <!--Forms Start-->
            <!--Insert Modal Start-->
            <!-- use the modal component, pass in the prop -->
            <modal-small v-if="showInsertModal" @close="showInsertModal = false">
                <div slot="body">
                    <form v-on:submit.prevent="createCostAgreement">
                        <div class="grid-x">
                            <div class="medium-6 columns padding-lr">
                                <label>شماره ابلاغ
                                    <input class="form-element-margin-btm" type="text" name="caLetterNumber" v-model="costAgreementInput.idNumber" v-validate data-vv-rules="required" :class="{'input': true, 'select-error': errors.has('caLetterNumber')}">
                                </label>
                                <span v-show="errors.has('caLetterNumber')" class="error-font">شماره فراموش شده است!</span>
                            </div>
                            <div class="medium-4 padding-lr">
                                <p class="date-picker-lbl">تاریخ ابلاغ
                                    <pdatepicker v-model="costAgreementInput.date" v-on:closed="checkValidDate('delivery' , costAgreementInput)" errMessage="تاریخ ابلاغ فراموش شده است!" :isValid="dateIsValid_delivery" open-transition-animation="left-slide-fade"></pdatepicker>
                                </p>
                            </div>
                            <div class="medium-6 columns padding-lr" v-if="provOrNat == 0">
                                <label>شماره مبادله
                                    <input class="form-element-margin-btm" type="text" name="caExLetterNumber" v-model="costAgreementInput.exIdNumber" v-validate data-vv-rules="required" :class="{'input': true, 'select-error': errors.has('caExLetterNumber')}">
                                </label>
                                <span v-show="errors.has('caExLetterNumber')" class="error-font">شماره فراموش شده است!</span>
                            </div>
                            <div class="medium-4 padding-lr" v-if="provOrNat == 0">
                                <p class="date-picker-lbl">تاریخ مبادله
                                    <pdatepicker v-model="costAgreementInput.exDate" v-on:closed="provOrNat == 0 ? checkValidDate('exchange' , costAgreementInput) : null" errMessage="تاریخ مبادله فراموش شده است!" :isValid="provOrNat == 0 ? dateIsValid_exchange : true" open-transition-animation="left-slide-fade"></pdatepicker>
                                </p>
                            </div>
                        </div>
                        <div class="grid-x">
                            <div class="small-12 columns padding-lr">
                                <label>شرح
                                    <textarea name="apDescription" style="min-height: 150px;" v-model="costAgreementInput.description"></textarea>
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
            <modal-small v-if="showUpdateModal" @close="showUpdateModal = false" xmlns:v-on="http://www.w3.org/1999/xhtml">
                <div  slot="body">
                    <form v-on:submit.prevent="updateCostAgreement">
                        <div class="grid-x">
                            <div class="medium-6 columns padding-lr">
                                <label>شماره ابلاغ
                                    <input class="form-element-margin-btm" type="text" name="caLetterNumber" v-model="costAgreementFill.idNumber" v-validate data-vv-rules="required" :class="{'input': true, 'select-error': errors.has('caLetterNumber')}">
                                </label>
                                <span v-show="errors.has('caLetterNumber')" class="error-font">شماره فراموش شده است!</span>
                            </div>
                            <div class="medium-4 padding-lr">
                                <p class="date-picker-lbl">تاریخ ابلاغ
                                    <pdatepicker v-model="costAgreementFill.date" v-on:closed="checkValidDate('delivery' , costAgreementFill)" errMessage="تاریخ ابلاغ فراموش شده است!" :isValid="dateIsValid_delivery" open-transition-animation="left-slide-fade"></pdatepicker>
                                </p>
                            </div>
                            <div class="medium-6 columns padding-lr" v-if="provOrNat == 0">
                                <label>شماره مبادله
                                    <input class="form-element-margin-btm" type="text" name="caExLetterNumber" v-model="costAgreementFill.exIdNumber" v-validate data-vv-rules="required" :class="{'input': true, 'select-error': errors.has('caExLetterNumber')}">
                                </label>
                                <span v-show="errors.has('caExLetterNumber')" class="error-font">شماره فراموش شده است!</span>
                            </div>
                            <div class="medium-4 padding-lr" v-if="provOrNat == 0">
                                <p class="date-picker-lbl">تاریخ مبادله
                                    <pdatepicker v-model="costAgreementFill.exDate" v-on:closed="provOrNat == 0 ? checkValidDate('exchange' , costAgreementFill) : null" errMessage="تاریخ مبادله فراموش شده است!" :isValid="provOrNat == 0 ? dateIsValid_exchange : true" open-transition-animation="left-slide-fade"></pdatepicker>
                                </p>
                            </div>
                        </div>
                        <div class="grid-x">
                            <div class="small-12 columns padding-lr">
                                <label>شرح
                                    <textarea name="apDescription" style="min-height: 150px;" v-model="costAgreementFill.description"></textarea>
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
                                <button v-on:click="deleteCostAgreement" class="my-button my-success"><span class="btn-txt-mrg">   بله   </span></button>
                            </div>
                        </div>
                    </div>
                </div>
            </modal-tiny>
            <!-- Delete Modal End -->

            <!-- credit source Modal Start-->
            <modal-small v-if="showCaCsInsertModal" @close="showCaCsInsertModal = false">
                <div  slot="body">
                    <form v-on:submit.prevent="createCaCreditSource">
                        <div class="grid-x">
                            <div class="medium-6 cell padding-lr">
                                <label>برنامه
                                    <select class="form-element-margin-btm" name="cdTitle" v-model="caCreditSourceInput.cdtId" v-validate data-vv-rules="required" :class="{'input': true, 'select-error': errors.has('howToRun')}">
                                        <option value=""></option>
                                        <option v-for="creditDistributionTitle in creditDistributionTitles" :value="creditDistributionTitle.id">{{ creditDistributionTitle.cdtIdNumber + ' - ' + creditDistributionTitle.cdtSubject + (creditDistributionTitle.county == null ? '' : ' - ' + creditDistributionTitle.county.coName)}}</option>
                                    </select>
                                    <span v-show="errors.has('howToRun')" class="error-font">لطفا عنوان برنامه را انتخاب کنید!</span>
                                </label>
                            </div>
                            <div class="medium-6 cell padding-lr">
                                <label>ردیف توزیع اعتبار
                                    <select  class="form-element-margin-btm"  name="row" v-model="caCreditSourceInput.crId" v-validate data-vv-rules="required" :class="{'input': true, 'select-error': errors.has('row')}">
                                        <option value=""></option>
                                        <option v-for="creditDistributionRow in creditDistributionRows" :value="creditDistributionRow.id">{{ creditDistributionRow.cdSubject }}</option>
                                    </select>
                                    <span v-show="errors.has('row')" class="error-font">لطفا ردیف توزیع را انتخاب کنید!</span>
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
                                        <option v-for="seasonTitle in seasonTitles" :value="seasonTitle.id">{{ seasonTitle.cstSubject }}</option>
                                    </select>
                                    <span v-show="errors.has('seasonTitle')" class="error-font">لطفا عنوان فصل را انتخاب کنید!</span>
                                </label>
                            </div>
                        </div>
                        <div class="grid-x">
                            <div class="medium-12 column padding-lr">
                                <label>ریز فصل
                                    <select class="form-element-margin-btm" v-model="caCreditSourceInput.tsId" name="subSeason" v-validate data-vv-rules="required" :class="{'input': true, 'select-error': errors.has('subSeason')}">
                                        <option value=""></option>
                                        <option v-for="tinySeason in tinySeasons" :value="tinySeason.id">{{ tinySeason.ctsSubject }}</option>
                                    </select>
                                    <span v-show="errors.has('subSeason')" class="error-font">لطفا ریز فصل را انتخاب کنید!</span>
                                </label>
                            </div>
                        </div>
                        <div class="grid-x">
                            <div class="medium-6 cell padding-lr">
                                <label>مبلغ اعتبار <span class="btn-red">{{ '(' + $parent.getAmountBaseLabel() + ')' }}</span>
                                    <input class="form-element-margin-btm" type="text" name="amount" v-model="caCreditSourceInput.amount" v-validate="'required|decimal'" :class="{'input': true, 'error-border': errors.has('amount')}">
                                </label>
                                <span v-show="errors.has('amount')" class="error-font">لطفا مبلغ اعتبار را وارد کنید!</span>
                            </div>
                        </div>
                        <div class="grid-x">
                            <div class="small-12 columns padding-lr">
                                <label>شرح
                                    <textarea name="csDescription" style="min-height: 150px;" v-model="caCreditSourceInput.description"></textarea>
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

            <!-- credit source Modal Start-->
            <modal-small v-if="showCaCsUpdateModal" @close="showCaCsUpdateModal = false">
                <div  slot="body">
                    <form v-on:submit.prevent="updateCaCreditSource">
                        <div class="grid-x">
                            <div class="medium-6 cell padding-lr">
                                <label>برنامه
                                    <select class="form-element-margin-btm" name="cdTitle" v-model="caCreditSourceFill.cdtId" v-validate data-vv-rules="required" :class="{'input': true, 'select-error': errors.has('howToRun')}">
                                        <option value=""></option>
                                        <option v-for="creditDistributionTitle in creditDistributionTitles" :value="creditDistributionTitle.id">{{ creditDistributionTitle.cdtIdNumber + ' - ' + creditDistributionTitle.cdtSubject + (creditDistributionTitle.county == null ? '' : ' - ' + creditDistributionTitle.county.coName)}}</option>
                                    </select>
                                    <span v-show="errors.has('howToRun')" class="error-font">لطفا عنوان برنامه را انتخاب کنید!</span>
                                </label>
                            </div>
                            <div class="medium-6 cell padding-lr">
                                <label>ردیف توزیع اعتبار
                                    <select  class="form-element-margin-btm"  name="row" v-model="caCreditSourceFill.crId" v-validate data-vv-rules="required" :class="{'input': true, 'select-error': errors.has('row')}">
                                        <option value=""></option>
                                        <option v-for="creditDistributionRow in creditDistributionRows" :value="creditDistributionRow.id">{{ creditDistributionRow.cdSubject }}</option>
                                    </select>
                                    <span v-show="errors.has('row')" class="error-font">لطفا ردیف توزیع را انتخاب کنید!</span>
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
                                        <option v-for="seasonTitle in seasonTitles" :value="seasonTitle.id">{{ seasonTitle.cstSubject }}</option>
                                    </select>
                                    <span v-show="errors.has('seasonTitle')" class="error-font">لطفا عنوان فصل را انتخاب کنید!</span>
                                </label>
                            </div>
                        </div>
                        <div class="grid-x">
                            <div class="medium-12 column padding-lr">
                                <label>ریز فصل
                                    <select class="form-element-margin-btm" v-model="caCreditSourceFill.tsId" name="subSeason" v-validate data-vv-rules="required" :class="{'input': true, 'select-error': errors.has('subSeason')}">
                                        <option value=""></option>
                                        <option v-for="tinySeason in tinySeasons" :value="tinySeason.id">{{ tinySeason.ctsSubject }}</option>
                                    </select>
                                    <span v-show="errors.has('subSeason')" class="error-font">لطفا ریز فصل را انتخاب کنید!</span>
                                </label>
                            </div>
                        </div>
                        <div class="grid-x">
                            <div class="medium-6 cell padding-lr">
                                <label>مبلغ اعتبار <span class="btn-red">{{ '(' + $parent.getAmountBaseLabel() + ')' }}</span>
                                    <input class="form-element-margin-btm" type="text" name="amount" v-model="caCreditSourceFill.amount" v-validate="'required|decimal'" :class="{'input': true, 'error-border': errors.has('amount')}">
                                </label>
                                <span v-show="errors.has('amount')" class="error-font">لطفا مبلغ اعتبار را وارد کنید!</span>
                            </div>
                        </div>
                        <div class="grid-x">
                            <div class="small-12 columns padding-lr">
                                <label>شرح
                                    <textarea name="csDescription" style="min-height: 150px;" v-model="caCreditSourceFill.description"></textarea>
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

            <!-- Delete Modal Start -->
            <modal-tiny v-if="showCaCsDeleteModal" @close="showCaCsDeleteModal = false">
                <div  slot="body">
                    <div class="small-font">
                        <p>کاربر گرامی</p>
                        <p class="large-offset-1 modal-text">آیا برای حذف این رکورد اطمینان دارید؟</p>
                        <div class="grid-x">
                            <div class="medium-12 column text-center">
                                <button v-on:click="deleteCaCsCostAgreement" class="my-button my-success"><span class="btn-txt-mrg">   بله   </span></button>
                            </div>
                        </div>
                    </div>
                </div>
            </modal-tiny>
            <!-- Delete Modal End -->

            <!--Amendment Modal Start-->
            <modal-small v-if="showAmendmentModal" @close="showAmendmentModal= false">
                <div slot="body">
                    <form v-on:submit.prevent="createCaAmendmentTemp">
                        <div class="grid-x">
                            <div class="medium-6 columns padding-lr">
                                <label>شماره ابلاغ
                                    <input class="form-element-margin-btm" v-model="caAmendmentInput.idNumber" type="text" name="caLetterNumber" v-validate data-vv-rules="required" :class="{'input': true, 'select-error': errors.has('caLetterNumber')}">
                                </label>
                                <span v-show="errors.has('caLetterNumber')" class="error-font">شماره فراموش شده است!</span>
                            </div>
                            <div class="medium-4 columns padding-lr">
                                <p class="date-picker-lbl">تاریخ مبادله
                                    <pdatepicker  v-on:closed="checkValidDate('delivery_amendment' , caAmendmentInput)" v-model="caAmendmentInput.date" errMessage="تاریخ ابلاغ فراموش شده است!" :isValid="dateIsValid_delivery_amendment" open-transition-animation="left-slide-fade"></pdatepicker>
                                </p>
                            </div>
                            <div class="medium-6 columns padding-lr" v-if="provOrNat == 0">
                                <label>شماره مبادله
                                    <input class="form-element-margin-btm" type="text" name="caExLetterNumber" v-model="caAmendmentInput.exIdNumber" v-validate data-vv-rules="required" :class="{'input': true, 'select-error': errors.has('caExLetterNumber')}">
                                </label>
                                <span v-show="errors.has('caExLetterNumber')" class="error-font">شماره مبادله فراموش شده است!</span>
                            </div>
                            <div class="medium-4 padding-lr">
                                <p class="date-picker-lbl">تاریخ مبادله
                                    <pdatepicker v-model="caAmendmentInput.exDate" v-on:closed="checkValidDate('exchange_amendment' , caAmendmentInput)" errMessage="تاریخ مبادله فراموش شده است!" :isValid="dateIsValid_exchange_amendment" open-transition-animation="left-slide-fade"></pdatepicker>
                                </p>
                            </div>
                        </div>
                        <div class="grid-x">
                            <div class="small-12 columns padding-lr">
                                <label>شرح
                                    <textarea name="apDescription" v-model="caAmendmentInput.description" style="min-height: 150px;"></textarea>
                                </label>
                            </div>
                        </div>
                        <div class="medium-6 columns padding-lr padding-bottom-modal">
                            <div class="button-group float-left report-mrg">
                                <button class="my-button my-success float-left btn-for-load"> <span class="btn-txt-mrg">تایید</span></button>
                            </div>
                        </div>
                    </form>
                </div>
            </modal-small>
            <!--Amendment Modal End-->

            <!--Amendment Modal Start-->
            <modal-small v-if="showNatAmendmentModal" @close="showNatAmendmentModal= false">
                <div slot="body">
                    <form v-on:submit.prevent="createCaAmendmentTemp">
                        <div class="grid-x">
                            <div class="medium-6 columns padding-lr">
                                <label>شماره ابلاغ
                                    <input class="form-element-margin-btm" v-model="caAmendmentInput.idNumber" type="text" name="caLetterNumber" v-validate data-vv-rules="required" :class="{'input': true, 'select-error': errors.has('caLetterNumber')}">
                                </label>
                                <span v-show="errors.has('caLetterNumber')" class="error-font">شماره فراموش شده است!</span>
                            </div>
                            <div class="medium-4 columns padding-lr">
                                <p class="date-picker-lbl">تاریخ مبادله
                                    <pdatepicker  v-on:closed="checkValidDate('delivery_amendment' , caAmendmentInput)" v-model="caAmendmentInput.date" errMessage="تاریخ ابلاغ فراموش شده است!" :isValid="dateIsValid_delivery_amendment" open-transition-animation="left-slide-fade"></pdatepicker>
                                </p>
                            </div>
                        </div>
                        <div class="grid-x">
                            <div class="small-12 columns padding-lr">
                                <label>شرح
                                    <textarea name="apDescription" v-model="caAmendmentInput.description" style="min-height: 150px;"></textarea>
                                </label>
                            </div>
                        </div>
                        <div class="medium-6 columns padding-lr padding-bottom-modal">
                            <div class="button-group float-left report-mrg">
                                <button class="my-button my-success float-left btn-for-load"> <span class="btn-txt-mrg">تایید</span></button>
                            </div>
                        </div>
                    </form>
                </div>
            </modal-small>
            <!--Amendment Modal End-->

            <!--Amendment Of The Agreement Modal Start-->
            <modal-full-screen v-if="showModalAmendmentCost" @close="showModalAmendmentCost= false">
                <div slot="body">
                    <div style="padding:0px;" class="grid-x border-btm-line">
                        <div class="medium-12 cell padding-lr">
                            <div class="grid-x">
                                <div class="medium-1">
                                    <p>شماره ابلاغ : </p>
                                </div>
                                <div class="medium-3">
                                    <strong class="btn-red">{{ costAmendmentCreditSource.caLetterNumber }}</strong>
                                </div>
                                <div class="medium-1">
                                    <p>تاریخ ابلاغ : </p>
                                </div>
                                <div class="medium-3">
                                    <strong class="btn-red">{{ costAmendmentCreditSource.caLetterDate }}</strong>
                                </div>
                            </div>
                        </div>
                        <div class="medium-12 cell padding-lr">
                            <div class="grid-x">
                                <div class="medium-12 padding-bottom-modal">
                                    <strong>شرح: </strong><span style="display: inline">{{ costAmendmentCreditSource.caDescription }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div style="margin-top: 17px;" class="grid-x">
                        <div class="medium-12 button-group float-right">
                            <a class="medium-1 my-button toolbox-btn small" @click="openACaCsCostInsertModal">اعتبار جدید</a>
                        </div>
                    </div>
                    <div class="grid-x">
                        <!--Table Start-->
                        <!--Table Head Start-->
                        <div class="tbl-div-container">
                            <table class="tbl-head">
                                <colgroup>
                                    <col width="150px"/>
                                    <col width="100px"/>
                                    <col width="70px"/>
                                    <col width="200px"/>
                                    <col width="200"/>
                                    <col width="100px"/>
                                    <col width="160px"/>
                                    <col width="12px"/>
                                </colgroup>
                                <tbody class="tbl-head-style ">
                                <tr class="tbl-head-style-cell">
                                    <th class="tbl-head-style-cell">برنامه</th>
                                    <th class="tbl-head-style-cell">ردیف</th>
                                    <th class="tbl-head-style-cell">فصل</th>
                                    <th class="tbl-head-style-cell">عنوان فصل</th>
                                    <th class="tbl-head-style-cell">ریز فصل</th>
                                    <th class="tbl-head-style-cell">مبلغ</th>
                                    <th class="tbl-head-style-cell">شرح</th>
                                    <th class="tbl-head-style-cell"></th>
                                </tr>
                                </tbody>
                            </table>
                            <!--Table Head End-->
                            <!--Table Body Start-->
                            <div class="tbl_body_style dynamic-height-level-modal1">
                                <table class="tbl-body-contain">
                                    <colgroup>
                                        <col width="150px"/>
                                        <col width="100px"/>
                                        <col width="70px"/>
                                        <col width="200px"/>
                                        <col width="200"/>
                                        <col width="100px"/>
                                        <col width="160px"/>
                                    </colgroup>
                                    <tbody class="tbl-head-style-cell">
                                        <tr v-for="creditSource in costAmendmentCreditSource.ca_credit_source">
                                            <td>{{ creditSource.credit_distribution_title.cdtIdNumber + ' - ' + creditSource.credit_distribution_title.cdtSubject }}
                                                <span v-show="creditSource.ccsDeleted" class="comlpleted-badage float-left">حذف شده</span>
                                            </td>
                                            <td>{{ creditSource.credit_distribution_row.cdSubject }}</td>
                                            <td>{{ creditSource.tiny_season.season_title.season.sSubject }}</td>
                                            <td>{{ creditSource.tiny_season.season_title.cstSubject }}</td>
                                            <td>{{ creditSource.tiny_season.ctsSubject }}</td>
                                            <td>{{ $parent.calcDispAmount(creditSource.ccsAmount , false) }}</td>
                                            <td>
                                                <div class="grid-x">
                                                    <div class="medium-11">
                                                        {{ creditSource.ccsDescription }}
                                                    </div>
                                                    <div class="medium-1 cell-vertical-center text-left">
                                                        <a class="dropdown small sm-btn-align" :data-toggle="'creditSource' + creditSource.id"  type="button"><i class="fa fa-ellipsis-v size-18"></i></a>
                                                        <div class="dropdown-pane dropdown-pane-sm " data-close-on-click="true"  data-hover="true" data-hover-pane="true"  data-position="bottom" data-alignment="right" :id="'creditSource' + creditSource.id" data-dropdown data-auto-focus="true">
                                                            <ul class="my-menu small-font text-right">
                                                                <li><a v-on:click.prevent="openDeleteTempCreditSourceModal(creditSource.id)"><i class="fa fa-trash-o size-16"></i>  حذف</a></li>
                                                                <li><a v-on:click.prevent="openACaCsCostCreditEditModal(creditSource)"><i class="fa fa-newspaper-o size-16"></i>  اصلاح</a></li>
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
                        <!--Table Body End-->
                    </div>
                    <div class="grid-x">
                        <div class="medium-12 columns padding-bottom-modal">
                            <div class="button-group float-left report-mrg">
                                <a class="my-button my-danger float-left btn-for-load" @click="cancelCostAmendmentTemp"> <span class="btn-txt-mrg">لغو</span></a>
                                <a class="my-button my-success float-left btn-for-load" @click="acceptCostAmendment"> <span class="btn-txt-mrg">تایید</span></a>
                            </div>
                        </div>
                    </div>
                </div>
            </modal-full-screen>
            <!--Amendment Of The Agreement Modal End-->

            <!--Amendment Project credit source Modal Insert Start-->
            <modal-small v-if="showACaCsInsertModal" @close="showACaCsInsertModal = false">
                <div  slot="body">
                    <form v-on:submit.prevent="insertNewTempCreditSource">
                        <div class="grid-x">
                            <div class="medium-6 cell padding-lr">
                                <label>برنامه
                                    <select class="form-element-margin-btm" name="cdTitle" v-model="acaCreditSourceInput.cdtId" v-validate data-vv-rules="required" :class="{'input': true, 'select-error': errors.has('howToRun')}">
                                        <option value=""></option>
                                        <option v-for="creditDistributionTitle in creditDistributionTitles" :value="creditDistributionTitle.id">{{ creditDistributionTitle.cdtIdNumber + ' - ' + creditDistributionTitle.cdtSubject + (creditDistributionTitle.county == null ? '' : ' - ' + creditDistributionTitle.county.coName)}}</option>
                                    </select>
                                    <span v-show="errors.has('howToRun')" class="error-font">لطفا عنوان برنامه را انتخاب کنید!</span>
                                </label>
                            </div>
                            <div class="medium-6 cell padding-lr">
                                <label>ردیف توزیع اعتبار
                                    <select  class="form-element-margin-btm"  name="row" v-model="acaCreditSourceInput.crId" v-validate data-vv-rules="required" :class="{'input': true, 'select-error': errors.has('row')}">
                                        <option value=""></option>
                                        <option v-for="creditDistributionRow in creditDistributionRows" :value="creditDistributionRow.id">{{ creditDistributionRow.cdSubject }}</option>
                                    </select>
                                    <span v-show="errors.has('row')" class="error-font">لطفا ردیف توزیع را انتخاب کنید!</span>
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
                                        <option v-for="seasonTitle in seasonTitles" :value="seasonTitle.id">{{ seasonTitle.cstSubject }}</option>
                                    </select>
                                    <span v-show="errors.has('seasonTitle')" class="error-font">لطفا عنوان فصل را انتخاب کنید!</span>
                                </label>
                            </div>
                        </div>
                        <div class="grid-x">
                            <div class="medium-12 column padding-lr">
                                <label>ریز فصل
                                    <select class="form-element-margin-btm" v-model="acaCreditSourceInput.tsId" name="subSeason" v-validate data-vv-rules="required" :class="{'input': true, 'select-error': errors.has('subSeason')}">
                                        <option value=""></option>
                                        <option v-for="tinySeason in tinySeasons" :value="tinySeason.id">{{ tinySeason.ctsSubject }}</option>
                                    </select>
                                    <span v-show="errors.has('subSeason')" class="error-font">لطفا ریز فصل را انتخاب کنید!</span>
                                </label>
                            </div>
                        </div>
                        <div class="grid-x">
                            <div class="medium-6 cell padding-lr">
                                <label>مبلغ اعتبار <span class="btn-red">{{ '(' + $parent.getAmountBaseLabel() + ')' }}</span>
                                    <input class="form-element-margin-btm" type="text" name="amount" v-model="acaCreditSourceInput.amount" v-validate="'required|decimal'" :class="{'input': true, 'error-border': errors.has('amount')}">
                                </label>
                                <span v-show="errors.has('amount')" class="error-font">لطفا مبلغ اعتبار را وارد کنید!</span>
                            </div>
                        </div>
                        <div class="grid-x">
                            <div class="small-12 columns padding-lr">
                                <label>شرح
                                    <textarea name="csDescription" style="min-height: 150px;" v-model="acaCreditSourceInput.description"></textarea>
                                </label>
                            </div>
                        </div>
                        <div class="medium-6 columns padding-lr padding-bottom-modal input-margin-top">
                            <button name="Submit" class="my-button my-success float-left btn-for-load"> <span class="btn-txt-mrg">ثبت</span></button>
                        </div>
                    </form>
                </div>
            </modal-small>
            <!--Amendment Project Cost Modal Insert End-->

            <!--Amendment Project credit source Modal Edit Start-->
            <modal-small v-if="showACaCsEditModal" @close="showACaCsEditModal = false">
                <div  slot="body">
                    <form v-on:submit.prevent="updateTempCreditSource">
                        <div class="grid-x">
                            <div class="medium-6 cell padding-lr">
                                <label>برنامه
                                    <select class="form-element-margin-btm" name="cdTitle" v-model="acaCreditSourceFill.cdtId" v-validate data-vv-rules="required" :class="{'input': true, 'select-error': errors.has('howToRun')}">
                                        <option value=""></option>
                                        <option v-for="creditDistributionTitle in creditDistributionTitles" :value="creditDistributionTitle.id">{{ creditDistributionTitle.cdtIdNumber + ' - ' + creditDistributionTitle.cdtSubject + (creditDistributionTitle.county == null ? '' : ' - ' + creditDistributionTitle.county.coName)}}</option>
                                    </select>
                                    <span v-show="errors.has('howToRun')" class="error-font">لطفا عنوان برنامه را انتخاب کنید!</span>
                                </label>
                            </div>
                            <div class="medium-6 cell padding-lr">
                                <label>ردیف توزیع اعتبار
                                    <select  class="form-element-margin-btm"  name="row" v-model="acaCreditSourceFill.crId" v-validate data-vv-rules="required" :class="{'input': true, 'select-error': errors.has('row')}">
                                        <option value=""></option>
                                        <option v-for="creditDistributionRow in creditDistributionRows" :value="creditDistributionRow.id">{{ creditDistributionRow.cdSubject }}</option>
                                    </select>
                                    <span v-show="errors.has('row')" class="error-font">لطفا ردیف توزیع را انتخاب کنید!</span>
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
                                        <option v-for="seasonTitle in seasonTitles" :value="seasonTitle.id">{{ seasonTitle.cstSubject }}</option>
                                    </select>
                                    <span v-show="errors.has('seasonTitle')" class="error-font">لطفا عنوان فصل را انتخاب کنید!</span>
                                </label>
                            </div>
                        </div>
                        <div class="grid-x">
                            <div class="medium-12 column padding-lr">
                                <label>ریز فصل
                                    <select class="form-element-margin-btm" v-model="acaCreditSourceFill.tsId" name="subSeason" v-validate data-vv-rules="required" :class="{'input': true, 'select-error': errors.has('subSeason')}">
                                        <option value=""></option>
                                        <option v-for="tinySeason in tinySeasons" :value="tinySeason.id">{{ tinySeason.ctsSubject }}</option>
                                    </select>
                                    <span v-show="errors.has('subSeason')" class="error-font">لطفا ریز فصل را انتخاب کنید!</span>
                                </label>
                            </div>
                        </div>
                        <div class="grid-x">
                            <div class="medium-6 cell padding-lr">
                                <label>مبلغ اعتبار <span class="btn-red">{{ '(' + $parent.getAmountBaseLabel() + ')' }}</span>
                                    <input class="form-element-margin-btm" type="text" name="amount" v-model="acaCreditSourceFill.amount" v-validate="'required|decimal'" :class="{'input': true, 'error-border': errors.has('amount')}">
                                </label>
                                <span v-show="errors.has('amount')" class="error-font">لطفا مبلغ اعتبار را وارد کنید!</span>
                            </div>
                        </div>
                        <div class="grid-x">
                            <div class="small-12 columns padding-lr">
                                <label>شرح
                                    <textarea name="csDescription" style="min-height: 150px;" v-model="acaCreditSourceFill.description"></textarea>
                                </label>
                            </div>
                        </div>
                        <div class="medium-6 columns padding-lr padding-bottom-modal input-margin-top">
                            <button name="Submit" class="my-button my-success float-left btn-for-load"> <span class="btn-txt-mrg">ثبت</span></button>
                        </div>
                    </form>
                </div>
            </modal-small>
            <!--Amendment Project Cost Modal Edit End-->
            <!-- Delete Modal Start -->
            <modal-tiny v-if="showDeleteTempCreditSourceModal" @close="showDeleteTempCreditSourceModal = false">
                <div  slot="body">
                    <div class="small-font">
                        <p>کاربر گرامی</p>
                        <p class="large-offset-1 modal-text">با حذف منبع اعتبار انتخاب شده، تخصیص های اعتبار صفر می گردد و لازم است محل های هزینه کرد اصلاح شود.</p>
                        <div class="grid-x">
                            <div class="medium-12 column text-center">
                                <button v-on:click="deleteTempCreditSource" class="my-button my-success"><span class="btn-txt-mrg">   بله   </span></button>
                            </div>
                        </div>
                    </div>
                </div>
            </modal-tiny>
            <!-- Delete Modal End -->
            <!--Forms End-->
            <!--amendment plan info-->
            <modal-large v-if="showAmendmentProgInfoModal" @close="showAmendmentProgInfoModal = false">
                <div  slot="body">
                    <div style="padding:0px;" class="grid-x border-btm-line">
                        <div class="medium-12 cell padding-lr">
                            <div class="grid-x" v-show="amendmentProgInfo.caProvinceOrNational == 0">
                                <div class="medium-1">
                                    <p>شماره مبادله : </p>
                                </div>
                                <div class="medium-3">
                                    <strong class="btn-red">{{ amendmentProgInfo.caExchangeIdNumber }}</strong>
                                </div>
                                <div class="medium-1">
                                    <p>تاریخ مبادله : </p>
                                </div>
                                <div class="medium-3">
                                    <strong class="btn-red">{{ amendmentProgInfo.caExchangeDate }}</strong>
                                </div>
                            </div>
                            <div class="grid-x">
                                <div class="medium-1">
                                    <p>شماره ابلاغ : </p>
                                </div>
                                <div class="medium-3">
                                    <strong class="btn-red">{{ amendmentProgInfo.caLetterNumber }}</strong>
                                </div>
                                <div class="medium-1">
                                    <p>تاریخ ابلاغ : </p>
                                </div>
                                <div class="medium-3">
                                    <strong class="btn-red">{{ amendmentProgInfo.caLetterDate }}</strong>
                                </div>
                            </div>
                        </div>
                        <div class="medium-12 cell padding-lr">
                            <div class="grid-x">
                                <div class="medium-12 padding-bottom-modal">
                                    <strong>شرح: </strong><span style="display: inline">{{ amendmentProgInfo.caDescription }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="grid-x">
                        <!--Table Start-->
                        <!--Table Head Start-->
                        <div class="tbl-div-container">
                            <table class="tbl-head">
                                <colgroup>
                                    <col width="150px"/>
                                    <col width="100px"/>
                                    <col width="70px"/>
                                    <col width="200px"/>
                                    <col width="200"/>
                                    <col width="100px"/>
                                    <col width="160px"/>
                                    <col width="12px"/>
                                </colgroup>
                                <tbody class="tbl-head-style ">
                                <tr class="tbl-head-style-cell">
                                    <th class="tbl-head-style-cell">برنامه</th>
                                    <th class="tbl-head-style-cell">ردیف</th>
                                    <th class="tbl-head-style-cell">فصل</th>
                                    <th class="tbl-head-style-cell">عنوان فصل</th>
                                    <th class="tbl-head-style-cell">ریز فصل</th>
                                    <th class="tbl-head-style-cell">مبلغ</th>
                                    <th class="tbl-head-style-cell">شرح</th>
                                    <th class="tbl-head-style-cell"></th>
                                </tr>
                                </tbody>
                            </table>
                            <!--Table Head End-->
                            <!--Table Body Start-->
                            <div class="tbl_body_style dynamic-height-level-modal1">
                                <table class="tbl-body-contain">
                                    <colgroup>
                                        <col width="150px"/>
                                        <col width="100px"/>
                                        <col width="70px"/>
                                        <col width="200px"/>
                                        <col width="200"/>
                                        <col width="100px"/>
                                        <col width="160px"/>
                                    </colgroup>
                                    <tbody class="tbl-head-style-cell">
                                    <tr v-for="creditSource in amendmentProgInfo.ca_credit_source">
                                        <td>{{ creditSource.credit_distribution_title.cdtIdNumber + ' - ' + creditSource.credit_distribution_title.cdtSubject }}
                                            <span v-show="creditSource.ccsDeleted" class="comlpleted-badage float-left">حذف شده</span>
                                        </td>
                                        <td>{{ creditSource.credit_distribution_row.cdSubject }}</td>
                                        <td>{{ creditSource.tiny_season.season_title.season.sSubject }}</td>
                                        <td>{{ creditSource.tiny_season.season_title.cstSubject }}</td>
                                        <td>{{ creditSource.tiny_season.ctsSubject }}</td>
                                        <td>{{ $parent.calcDispAmount(creditSource.ccsAmount , false) }}</td>
                                        <td>
                                            {{ creditSource.ccsDescription }}
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!--Table Body End-->
                    </div>
                </div>
            </modal-large>
            <!--amendment plan info-->
        </div>
    </div>
</template>

<script>
    import VuePagination from '../../../public_component/pagination.vue';
    export default {
        data(){
            return {
                searchProvValue:'',
                searchNatValue:'',
                costAgreement_prov: [],
                costAgreement_nat: [],
                costAgreementInput: {},
                costAgreementFill: {},
                acaCreditSourceInput: {},
                caAmendmentInput: {},
                amendmentProgInfo: {},
                showInsertModal: false,
                showCaCsInsertModal: false,
                showCaCsUpdateModal: false,
                showCaCsDeleteModal: false,
                showUpdateModal: false,
                showDeleteModal: false,
                showAmendmentModal:false,
                showNatAmendmentModal: false,
                showModalAmendmentCost:false,
                showACaCsInsertModal:false,
                showDeleteTempCreditSourceModal: false,
                showACaCsEditModal: false,
                showAmendmentProgInfoModal: false,
                dateIsValid_delivery: true,
                dateIsValid_exchange: true,
                dateIsValid_delivery_amendment: true,
                dateIsValid_exchange_amendment: true,
                costAmendmentCreditSource: [],
                selectColumn:false,
                tempCreditSourceSelectedId_delete: '',
                costAgreementFill: {},
                acaCreditSourceFill: {},

                caCreditSourceInput: {},
                caCreditSourceFill: {},
                caIdForInsertCreditSource: '',
                displayCreditSourceInfo_prov: '',
                displayCreditSourceInfo_nat: '',
                displayAmendmentInfo_prov: '',
                displayAmendmentInfo_nat: '',
                provOrNat: '',
                caIdForDelete: '',
                selectedCaCsIdForDelete: '',
                approvedPlans: {},
                counties: {},
                countyState: false,
                seasons: {},
                seasonTitles: {},
                tinySeasons: {},
                selectedSeason: '',
                selectedSeasonTitle: '',
                creditDistributionRows: {},
                creditDistributionTitles: {},
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
            this.myResizeModal();
        },

        mounted: function () {
            console.log("mounted approved cost_program component");
            this.$parent.myResize();
        },

        beforeDestroy: function () {
            console.log("destroy approved cost_program component");
            this.cleanCostAmendmentTemp(); //clean all remaining cost amendment record
        },

        components:{
            'vue-pagination' : VuePagination
        },

        methods:{
            fetchProvincialData: function (page = 1) {
                axios.get('/budget/approved_plan/cost/fetchData?page=' + page , {params:{pOrN: 0}})
                    .then((response) => {
                        this.costAgreement_prov = response.data.data;
                        this.makePagination(response.data , "provincial");
                        console.log(response);
                    },(error) => {
                        console.log(error);
                    });
            },

            fetchNationalData: function (page = 1) {
                axios.get('/budget/approved_plan/cost/fetchData?page=' + page , {params:{pOrN: 1}})
                    .then((response) => {
                        this.costAgreement_nat = response.data.data;
                        this.makePagination(response.data , "national");
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
                axios.get('/budget/admin/season_title/cost/getWithSeasonId' , {params:{sId: this.selectedSeason}}).then((response) => {
                this.seasonTitles = response.data;
                console.log(response);
            },(error) => {
                    console.log(error);
                });
            },

            getTinySeasons: function () {
                axios.get('/budget/admin/sub_seasons/cost/getAllItem' , {params:{cstId: this.selectedSeasonTitle}})
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

            openCostAgreementInsertModal: function (type) {
                this.costAgreementInput = [];
                this.provOrNat = type;
                this.showInsertModal= true;

            },

            openCreditSourceInsertModal: function (caId , type) {
                this.caCreditSourceInput = [];
                this.selectedSeasonTitle = '';
                this.selectedSeason = '';
                this.showCaCsInsertModal = true;
                this.caIdForInsertCreditSource = caId;
                this.provOrNat = type;
                this.getCreditDistributionTitle(1); //all item should be national type => county = null
                this.getSeasons();
                this.getCreditDistributionRow();
            },

            createCostAgreement: function () {
                this.$validator.validateAll().then((result) => {
                    if (result) {
                        if (this.checkValidDate('delivery' , this.costAgreementInput) && this.checkValidDate('exchange' , this.costAgreementInput)) {
                            axios.post('/budget/approved_plan/cost/register', {
                                idNumber: this.costAgreementInput.idNumber,
                                date: this.costAgreementInput.date,
                                exIdNumber: this.costAgreementInput.exIdNumber,
                                exDate: this.costAgreementInput.exDate,
                                description: this.costAgreementInput.description,
                                pOrN: this.provOrNat
                            }).then((response) => {
                                if (this.provOrNat == 0) {
                                    this.costAgreement_prov = response.data.data;
                                    this.makePagination(response.data, "provincial");
                                }
                                else {
                                    this.costAgreement_nat = response.data.data;
                                    this.makePagination(response.data, "national");
                                }
                                this.showInsertModal = false;
                                this.$parent.displayNotif(response.status);
                                console.log(response);
                            }, (error) => {
                                console.log(error);
                                this.$parent.displayNotif(error.response.status);
                            });
                        }
                    }
                });
            },

            createCaCreditSource: function () {
                this.$validator.validateAll().then((result) => {
                    if (result) {
                        axios.post('/budget/approved_plan/cost/credit_source/register' , {
                            caId: this.caIdForInsertCreditSource,
                            crId: this.caCreditSourceInput.crId,
                            cdtId: this.caCreditSourceInput.cdtId,
                            tsId: this.caCreditSourceInput.tsId,
                            amount: this.caCreditSourceInput.amount,
                            description: this.caCreditSourceInput.description,
                            pOrN: this.provOrNat
                        }).then((response) => {
                            if (this.provOrNat == 0)
                            {
                                this.costAgreement_prov = response.data.data;
                                this.makePagination(response.data , "provincial");
                            }
                            else
                            {
                                this.costAgreement_nat = response.data.data;
                                this.makePagination(response.data , "national");
                            }
                            this.showCaCsInsertModal = false;
                            this.$parent.displayNotif(response.status);
                            console.log(response);
                        },(error) => {
                            console.log(error);
                            this.$parent.displayNotif(error.response.status);
                        });
                    }
                });
            },

            openCaCsUpdateModal: function (cs , type) {
                this.getCreditDistributionTitle(1); //all item should be national type => county = null
                this.getSeasons();
                this.getCreditDistributionRow();
                this.caCreditSourceFill.id = cs.id;
                this.caCreditSourceFill.crId = cs.ccsCdrId;
                this.selectedSeason = cs.tiny_season.season_title.cstSId;
                this.getSeasonTitle();
                this.selectedSeasonTitle = cs.tiny_season.ctsCstId;
                this.getTinySeasons();
                this.caCreditSourceFill.tsId = cs.ccsTsId;
                this.caCreditSourceFill.cdtId = cs.ccsCdtId;
                this.caCreditSourceFill.amount = this.$parent.calcDispAmount(cs.ccsAmount , false);
                this.caCreditSourceFill.description = cs.ccsDescription;
                this.provOrNat = type;
                this.showCaCsUpdateModal = true;
            },

            updateCaCreditSource: function () {
                this.$validator.validateAll().then((result) => {
                    if (result) {
                        axios.post('/budget/approved_plan/cost/credit_source/update' , {
                            id: this.caCreditSourceFill.id,
                            crId: this.caCreditSourceFill.crId,
                            cdtId: this.caCreditSourceFill.cdtId,
                            tsId: this.caCreditSourceFill.tsId,
                            amount: this.caCreditSourceFill.amount,
                            description: this.caCreditSourceFill.description,
                            pOrN: this.provOrNat
                        }).then((response) => {
                            if (this.provOrNat == 0)
                            {
                                this.costAgreement_prov = response.data.data;
                                this.makePagination(response.data , "provincial");
                            }
                            else
                            {
                                this.costAgreement_nat = response.data.data;
                                this.makePagination(response.data , "national");
                            }
                            this.showCaCsUpdateModal = false;
                            this.$parent.displayNotif(response.status);
                            console.log(response);
                        },(error) => {
                            console.log(error);
                            this.$parent.displayNotif(error.response.status);
                        });
                    }
                });
            },

            openCaCsDeleteModal: function (csId , type) {
                this.selectedCaCsIdForDelete = csId;
                this.provOrNat = type;
                this.showCaCsDeleteModal = true;
            },

            deleteCaCsCostAgreement: function () {
                axios.post('/budget/approved_plan/cost/credit_source/delete' , {
                    id: this.selectedCaCsIdForDelete,
                    pOrN: this.provOrNat
                }).then((response) => {
                    if (this.provOrNat == 0 && response.status != 204)
                    {
                        this.costAgreement_prov = response.data.data;
                        this.makePagination(response.data , "provincial");
                    }
                    else if (this.provOrNat == 1 && response.status != 204)
                    {
                        this.costAgreement_nat = response.data.data;
                        this.makePagination(response.data , "national");
                    }
                    this.showCaCsDeleteModal = false;
                    this.$parent.displayNotif(response.status);
                    console.log(response);
                },(error) => {
                    console.log(error);
                    this.$parent.displayNotif(error.response.status);
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

            openUpdateModal: function (item) {
                this.costAgreementFill.id = item.id;
                this.costAgreementFill.idNumber = item.caLetterNumber;
                this.costAgreementFill.date = item.caLetterDate;
                this.costAgreementFill.exDate = item.caExchangeDate;
                this.costAgreementFill.exIdNumber = item.caExchangeIdNumber;
                this.costAgreementFill.description = item.caDescription;
                this.provOrNat = item.caProvinceOrNational;
                this.showUpdateModal = true;
            },

            updateCostAgreement: function () {
                this.$validator.validateAll().then((result) => {
                    if (result) {
                        if (this.checkValidDate('delivery' , this.costAgreementFill) && this.checkValidDate('exchange' , this.costAgreementFill)) {
                            axios.post('/budget/approved_plan/cost/update', {
                                id: this.costAgreementFill.id,
                                idNumber: this.costAgreementFill.idNumber,
                                date: this.costAgreementFill.date,
                                exIdNumber: this.costAgreementFill.exIdNumber,
                                exDate: this.costAgreementFill.exDate,
                                description: this.costAgreementFill.description,
                                pOrN: this.provOrNat
                            }).then((response) => {
                                if (this.provOrNat == 0) {
                                    this.costAgreement_prov = response.data.data;
                                    this.makePagination(response.data, "provincial");
                                }
                                else {
                                    this.costAgreement_nat = response.data.data;
                                    this.makePagination(response.data, "national");
                                }
                                this.showUpdateModal = false;
                                this.$parent.displayNotif(response.status);
                                console.log(response);
                            }, (error) => {
                                console.log(error);
                                this.$parent.displayNotif(error.response.status);
                            });
                        }
                    }
                });
            },

            openDeleteModal: function (caId , type) {
                this.caIdForDelete = caId;
                this.provOrNat = type;
                this.showDeleteModal = true;
            },

            deleteCostAgreement: function () {
                axios.post('/budget/approved_plan/cost/delete', {
                    id: this.caIdForDelete,
                    pOrN: this.provOrNat
                }).then((response) => {
                    if (this.provOrNat == 0 && response.status != 204) {
                        this.costAgreement_prov = response.data.data;
                        this.makePagination(response.data, "provincial");
                    }
                    else if (this.provOrNat == 1 && response.status != 204){
                        this.costAgreement_nat = response.data.data;
                        this.makePagination(response.data, "national");
                    }
                    this.showDeleteModal = false;
                    this.$parent.displayNotif(response.status);
                    console.log(response);
                }, (error) => {
                    console.log(error);
                    this.showDeleteModal = false;
                });
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
                var x = $.w.outerHeight();
                $('.dynamic-height-level-modal1').css('height', (x-350) + 'px');
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
            /////////////////////////// temp ///////////////////////////////////////////
            openACaCsCostInsertModal:function () {
                this.showACaCsInsertModal=true;
                this.getCreditDistributionTitle(1); //all item should be national type => county = null
                this.getSeasons();
                this.getCreditDistributionRow();

            },

            openAmendmentTempModal:function (ca) {
                this.caAmendmentInput = [];
                this.provOrNat = ca.caProvinceOrNational
                this.caAmendmentInput.parentId = ca.id;
                this.caAmendmentInput.pOrN = ca.caProvinceOrNational;
                this.caAmendmentInput.description = ca.caDescription;
                if (this.provOrNat == 0)
                {
                    this.showAmendmentModal=true;
                }
                else
                    this.showNatAmendmentModal = true;

            },

            openDeleteTempCreditSourceModal: function (csId) {
                this.tempCreditSourceSelectedId_delete = csId;
                this.showDeleteTempCreditSourceModal = true;
            },

            openACaCsCostCreditEditModal: function (cs) {
                this.getCreditDistributionTitle(1); //all item should be national type => county = null
                this.getSeasons();
                this.getCreditDistributionRow();
                this.selectedSeason = cs.tiny_season.season_title.season.id;
                this.getSeasonTitle();
                this.selectedSeasonTitle = cs.tiny_season.season_title.id;
                this.getTinySeasons();
                this.acaCreditSourceFill.csId = cs.id;
                this.acaCreditSourceFill.crId = cs.ccsCdrId;
                this.acaCreditSourceFill.tsId = cs.ccsTsId;
                this.acaCreditSourceFill.cdtId = cs.ccsCdtId;
                this.acaCreditSourceFill.amount = this.$parent.calcDispAmount(cs.ccsAmount , false);
                this.acaCreditSourceFill.description = cs.ccsDescription;
                this.showACaCsEditModal=true;
            },

            openAmendmentProgInfoModal: function (amendment) {
                this.amendmentProgInfo = amendment;
                this.showAmendmentProgInfoModal = true;
            },

            createCaAmendmentTemp: function () {
                this.$validator.validateAll().then((result) => {
                    if (result) {
                        if (this.checkValidDate('delivery_amendment' , this.caAmendmentInput))
                        {
                            axios.post('/budget/approved_plan/cost/amendment/temp/register' , {
                                idNumber: this.caAmendmentInput.idNumber,
                                date: this.caAmendmentInput.date,
                                description: this.caAmendmentInput.description,
                                caId: this.caAmendmentInput.parentId
                            }).then((response) => {
                                this.costAmendmentCreditSource = response.data;
                                if (this.provOrNat == 0)
                                    this.showAmendmentModal = false;
                                else
                                    this.showNatAmendmentModal = false;
                                this.showModalAmendmentCost = true;
                                console.log(response);
                            },(error) => {
                                console.log(error);
                                this.$parent.displayNotif(error.response.status);
                            });
                        }
                    }
                });
            },

            cancelCostAmendmentTemp: function () {
                axios.post('/budget/approved_plan/cost/amendment/temp/cancel' , {
                    caId: this.costAmendmentCreditSource.id
                }).then((response) => {
                    this.showModalAmendmentCost = false;
                    this.$parent.displayNotif(200);
                    console.log(response);
                },(error) => {
                    console.log(error);
                });
            },

            cleanCostAmendmentTemp: function () {
                axios.post('/budget/approved_plan/cost/amendment/temp/cancel')
                    .then((response) => {
                        console.log('pallas: clean cleanCostAmendmentTemp table');
                        console.log(response);
                    },(error) => {
                        console.log(error);
                    });
            },

            insertNewTempCreditSource: function () {
                this.$validator.validateAll().then((result) => {
                    if (result) {
                        axios.post('/budget/approved_plan/cost/amendment/temp/credit_source/register' , {
                            caId: this.costAmendmentCreditSource.id,
                            crId: this.acaCreditSourceInput.crId,
                            cdtId: this.acaCreditSourceInput.cdtId,
                            tsId: this.acaCreditSourceInput.tsId,
                            amount: this.acaCreditSourceInput.amount,
                            description: this.acaCreditSourceInput.description,
                            pOrN: this.provOrNat
                        }).then((response) => {
                            this.costAmendmentCreditSource = response.data;
                            this.showACaCsInsertModal=false;
                            console.log(response);
                        },(error) => {
                            console.log(error);
                            this.$parent.displayNotif(error.response.status);
                        });
                    }
                });
            },

            deleteTempCreditSource: function () {
                axios.post('/budget/approved_plan/cost/amendment/temp/credit_source/delete' , {
                    caId: this.costAmendmentCreditSource.id,
                    csId: this.tempCreditSourceSelectedId_delete,
                }).then((response) => {
                    this.costAmendmentCreditSource = response.data;
                    this.showDeleteTempCreditSourceModal = false;
                    console.log(response);
                },(error) => {
                    console.log(error);
                });
            },

            updateTempCreditSource: function () {
                this.$validator.validateAll().then((result) => {
                    if (result) {
                        axios.post('/budget/approved_plan/cost/amendment/temp/credit_source/update' , {
                            caId: this.costAmendmentCreditSource.id,
                            csId: this.acaCreditSourceFill.csId,
                            crId: this.acaCreditSourceFill.crId,
                            cdtId: this.acaCreditSourceFill.cdtId,
                            tsId: this.acaCreditSourceFill.tsId,
                            amount: this.acaCreditSourceFill.amount,
                            description: this.acaCreditSourceFill.description,
                        }).then((response) => {
                            this.costAmendmentCreditSource = response.data;
                            this.showACaCsEditModal=false;
                            console.log(response);
                        },(error) => {
                            console.log(error);
                            this.$parent.displayNotif(error.response.status);
                        });
                    }
                });
            },

            acceptCostAmendment: function () {
                axios.post('/budget/approved_plan/cost/amendment/accept' , {
                    caId: this.costAmendmentCreditSource.id,
                    parentId: this.caAmendmentInput.parentId
                }).then((response) => {
                    if (this.provOrNat == 0)
                    {
                        this.costAgreement_prov = response.data.data;
                        this.makePagination(response.data , "provincial");
                    }else{
                        this.costAgreement_nat = response.data.data;
                        this.makePagination(response.data , "national");
                    }
                    this.showModalAmendmentCost = false;
                    this.$parent.displayNotif(response.status);
                    console.log(response);
                },(error) => {
                    console.log(error);
                });
            },

            checkValidDate: function (type , input) {
                switch (type)
                {
                    case 'delivery':
                        if (input.date == null || input.date == '')
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
                        if (this.provOrNat == 0)
                        {
                            if (input.exDate == null || input.exDate == '')
                            {
                                this.dateIsValid_exchange = false;
                                return false;
                            }
                            else
                            {
                                this.dateIsValid_exchange = true;
                                return true;
                            }
                        }else{
                            return true;
                        }

                        break;
                    case 'delivery_amendment':
                        if (input.date == null || input.date == '')
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
                    case 'exchange_amendment':
                        if (input.date == null || input.date == '')
                        {
                            this.dateIsValid_exchange_amendment = false;
                            return false;
                        }
                        else
                        {
                            this.dateIsValid_exchange_amendment = true;
                            return true;
                        }
                        break;
                }
            },
        }
    }

</script>
