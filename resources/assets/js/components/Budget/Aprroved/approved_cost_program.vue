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
                                    <a class="my-button toolbox-btn small" @click="">گزارش</a>
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
                                        <strong>شماره مبادله</strong>
                                    </div>
                                    <div class="medium-2 table-border">
                                        <strong>تاریخ مبادله</strong>
                                    </div>
                                    <div class="medium-2 table-border">
                                        <strong>شماره ابلاغ</strong>
                                    </div>
                                    <div class="medium-2 table-border">
                                        <strong>تاریخ ابلاغ</strong>
                                    </div>
                                    <div class="medium-2 table-border">
                                        <strong>اعتبار</strong>
                                    </div>
                                    <div class="medium-2  table-border">
                                        <strong>شرح</strong>
                                    </div>
                                </div>
                                <!--Header End-->
                                <div class="table-contain dynamic-height-level2">
                                    <div class="grid-x" v-for="cAp in costAgreement_prov">
                                        <div class="medium-2 table-contain-border cell-vertical-center">
                                            {{ cAp.caLetterNumber }}
                                        </div>
                                        <div class="medium-2 table-contain-border cell-vertical-center">
                                            {{ cAp.caLetterDate }}
                                        </div>
                                        <div class="medium-2 table-contain-border cell-vertical-center">
                                            {{ cAp.caExchangeDate }}
                                        </div>
                                        <div class="medium-2 table-contain-border cell-vertical-center">
                                            {{ cAp.caExchangeIdNumber }}
                                        </div>
                                        <div class="medium-2 table-contain-border cell-vertical-center">
                                            <span @click="displayCreditSourceInfo_prov == cAp.id ? displayCreditSourceInfo_prov = '' : displayCreditSourceInfo_prov = cAp.id">{{ $parent.calcDispAmount(sumOfAmount(cAp.ca_credit_source) , false) }}</span>
                                        </div>
                                        <div class="medium-2  table-contain-border cell-vertical-center">
                                            <div class="grid-x">
                                                <div class="medium-11">
                                                    {{ cAp.caDescription }}
                                                </div>
                                                <div class="medium-1 cell-vertical-center text-left">
                                                    <a class="dropdown small sm-btn-align"  type="button" :data-toggle="'costAgreement' + cAp.id"><i class="fa fa-ellipsis-v size-18"></i></a>
                                                    <div class="dropdown-pane dropdown-pane-sm " data-close-on-click="true"  data-hover="true" data-hover-pane="true"  data-position="bottom" data-alignment="right" :id="'costAgreement' + cAp.id" data-dropdown data-auto-focus="true">
                                                        <ul class="my-menu small-font text-right">
                                                            <li><a v-on:click.prevent=""><i class="fa fa-pencil-square-o size-16"></i>  ویرایش</a></li>
                                                            <li><a v-on:click.prevent=""><i class="fa fa-trash-o size-16"></i>  حذف</a></li>
                                                            <li><a v-on:click.prevent="openCreditSourceInsertModal(cAp.id , 0)"><i class="fa fa-money size-16"></i>  اعتبارات</a></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="medium-12">
                                            <div class="grid-x" v-show="displayCreditSourceInfo_prov == cAp.id">
                                                <div class="medium-12 table-contain-border cell-vertical-center">
                                                    <table class="unstriped tbl-secondary-mrg small-font">
                                                        <thead class="my-thead">
                                                        <tr style="background-color: #F1F1F1 !important;">
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
                                                            <td>{{ creditSource.credit_distribution_row.cdSubject }}</td>
                                                            <td>{{ creditSource.tiny_season.season_title.season.sSubject }}</td>
                                                            <td>{{ creditSource.tiny_season.season_title.castSubject }}</td>
                                                            <td>{{ creditSource.tiny_season.catsSubject }}</td>
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
                                    <a class="my-button toolbox-btn small" @click="">گزارش</a>
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
                                        <strong>شماره مبادله</strong>
                                    </div>
                                    <div class="medium-2 table-border">
                                        <strong>تاریخ مبادله</strong>
                                    </div>
                                    <div class="medium-2 table-border">
                                        <strong>شماره ابلاغ</strong>
                                    </div>
                                    <div class="medium-2 table-border">
                                        <strong>تاریخ ابلاغ</strong>
                                    </div>
                                    <div class="medium-2 table-border">
                                        <strong>اعتبار</strong>
                                    </div>
                                    <div class="medium-2  table-border">
                                        <strong>شرح</strong>
                                    </div>
                                </div>
                                <!--Header End-->
                                <div class="table-contain dynamic-height-level2">
                                    <div class="grid-x" v-for="cAp in costAgreement_nat">
                                        <div class="medium-2 table-contain-border cell-vertical-center">
                                            {{ cAp.caLetterNumber }}
                                        </div>
                                        <div class="medium-2 table-contain-border cell-vertical-center">
                                            {{ cAp.caLetterDate }}
                                        </div>
                                        <div class="medium-2 table-contain-border cell-vertical-center">
                                            {{ cAp.caExchangeDate }}
                                        </div>
                                        <div class="medium-2 table-contain-border cell-vertical-center">
                                            {{ cAp.caExchangeIdNumber }}
                                        </div>
                                        <div class="medium-2 table-contain-border cell-vertical-center">
                                            <span @click="displayCreditSourceInfo_nat == cAp.id ? displayCreditSourceInfo_nat = '' : displayCreditSourceInfo_nat = cAp.id">{{ $parent.calcDispAmount(sumOfAmount(cAp.ca_credit_source) , false) }}</span>
                                        </div>
                                        <div class="medium-2  table-contain-border cell-vertical-center">
                                            <div class="grid-x">
                                                <div class="medium-11">
                                                    {{ cAp.caDescription }}
                                                </div>
                                                <div class="medium-1 cell-vertical-center text-left">
                                                    <a class="dropdown small sm-btn-align"  type="button" :data-toggle="'costAgreement' + cAp.id"><i class="fa fa-ellipsis-v size-18"></i></a>
                                                    <div class="dropdown-pane dropdown-pane-sm " data-close-on-click="true"  data-hover="true" data-hover-pane="true"  data-position="bottom" data-alignment="right" :id="'costAgreement' + cAp.id" data-dropdown data-auto-focus="true">
                                                        <ul class="my-menu small-font text-right">
                                                            <li><a v-on:click.prevent=""><i class="fa fa-pencil-square-o size-16"></i>  ویرایش</a></li>
                                                            <li><a v-on:click.prevent=""><i class="fa fa-trash-o size-16"></i>  حذف</a></li>
                                                            <li><a v-on:click.prevent="openCreditSourceInsertModal(cAp.id , 1)"><i class="fa fa-money size-16"></i>  اعتبارات</a></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="medium-12">
                                            <div class="grid-x" v-show="displayCreditSourceInfo_nat == cAp.id">
                                                <div class="medium-12 table-contain-border cell-vertical-center">
                                                    <table class="unstriped tbl-secondary-mrg small-font">
                                                        <thead class="my-thead">
                                                        <tr style="background-color: #F1F1F1 !important;">
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
                                                            <td>{{ creditSource.credit_distribution_row.cdSubject }}</td>
                                                            <td>{{ creditSource.tiny_season.season_title.season.sSubject }}</td>
                                                            <td>{{ creditSource.tiny_season.season_title.castSubject }}</td>
                                                            <td>{{ creditSource.tiny_season.catsSubject }}</td>
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
                        <div class="grid-x" v-if="errorMessage">
                            <div class="medium-12 columns padding-lr">
                                <div class="alert callout">
                                    <p class="BYekan login-alert"><i class="fi-alert"></i>{{ errorMessage }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="grid-x">
                            <div class="medium-6 columns padding-lr">
                                <label>شماره
                                    <input class="form-element-margin-btm" type="text" name="caLetterNumber" v-model="costAgreementInput.idNumber" v-validate data-vv-rules="required" :class="{'input': true, 'select-error': errors.has('caLetterNumber')}">
                                </label>
                                <span v-show="errors.has('caLetterNumber')" class="error-font">شماره فراموش شده است!</span>
                            </div>
                            <div class="medium-6 columns padding-lr">
                                <label>تاریخ
                                    <input class="form-element-margin-btm" type="text" name="caLetterDate"  v-model="costAgreementInput.date" v-validate data-vv-rules="required" :class="{'input': true, 'select-error': errors.has('caLetterDate')}">
                                </label>
                                <span v-show="errors.has('caLetterDate')" class="error-font">تاریخ فراموش شده است!</span>
                            </div>
                            <div class="medium-6 columns padding-lr">
                                <label>شماره مبادله
                                    <input class="form-element-margin-btm" type="text" name="caExLetterNumber" v-model="costAgreementInput.exIdNumber" v-validate data-vv-rules="required" :class="{'input': true, 'select-error': errors.has('caExLetterNumber')}">
                                </label>
                                <span v-show="errors.has('caExLetterNumber')" class="error-font">شماره فراموش شده است!</span>
                            </div>
                            <div class="medium-6 columns padding-lr">
                                <label>تاریخ مبادله
                                    <input class="form-element-margin-btm" type="text" name="caExLetterDate"  v-model="costAgreementInput.exDate" v-validate data-vv-rules="required" :class="{'input': true, 'select-error': errors.has('caExLetterDate')}">
                                </label>
                                <span v-show="errors.has('caExLetterDate')" class="error-font">تاریخ فراموش شده است!</span>
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
                                    <option v-for="approvedPlan in approvedPlans" :value="approvedPlan.id">@{{ approvedPlan.credit_distribution_title.cdtIdNumber + ' - ' + approvedPlan.credit_distribution_title.cdtSubject }}</option>
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
            <modal-small v-if="showCaCsInsertModal" @close="showCaCsInsertModal = false">
                <div  slot="body">
                    <form v-on:submit.prevent="createCaCreditSource">
                        <div class="grid-x" v-if="errorMessage">
                            <div class="medium-12 columns padding-lr">
                                <div class="alert callout">
                                    <p class="BYekan login-alert"><i class="fi-alert"></i>{{ errorMessage }}</p>
                                </div>
                            </div>
                        </div>
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
                                        <option v-for="seasonTitle in seasonTitles" :value="seasonTitle.id">{{ seasonTitle.castSubject }}</option>
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
                                        <option v-for="tinySeason in tinySeasons" :value="tinySeason.id">{{ tinySeason.catsSubject }}</option>
                                    </select>
                                    <span v-show="errors.has('subSeason')" class="error-font">لطفا ریز فصل را انتخاب کنید!</span>
                                </label>
                            </div>
                        </div>
                        <div class="grid-x">
                            <div class="medium-6 cell padding-lr">
                                <label>مبلغ اعتبار <span class="btn-red">(میلیون ریال)</span>
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
                costAgreement_prov: [],
                costAgreement_nat: [],
                costAgreementInput: {},
                showInsertModal: false,
                showCaCsInsertModal: false,
                showModalUpdate: false,
                showModalDelete: false,
                costAgreementFill: {},

                caCreditSourceInput: {},
                caIdForInsertCreditSource: '',
                displayCreditSourceInfo_prov: '',
                displayCreditSourceInfo_nat: '',
                provOrNat: '',
                apIdDelete: {},
                approvedPlans: {},
                counties: {},
                countyState: false,
                seasons: {},
                seasonTitles: {},
                tinySeasons: {},
                selectedSeasons: '',
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
        },

        mounted: function () {
            console.log("mounted approved cost_program component");
            this.$parent.myResize();
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
                this.provOrNat = type;
                this.showInsertModal= true;

            },

            openCreditSourceInsertModal: function (caId , type) {
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
                        axios.post('/budget/approved_plan/cost/register' , {
                            idNumber: this.costAgreementInput.idNumber,
                            date: this.costAgreementInput.date,
                            exIdNumber: this.costAgreementInput.exIdNumber,
                            exDate: this.costAgreementInput.exDate,
                            description: this.costAgreementInput.description,
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
