<template xmlns:v-on="http://www.w3.org/1999/xhtml">
    <!--Inner body start-->
    <div class="medium-10 border-right-line inner-body-pad main-margin">
        <div style="padding-top: 15px;" class="grid-x padding-lr">
            <div class="medium-12">
                <div class="grid-x">
                    <nav aria-label="You are here:" role="navigation">
                        <ul class="breadcrumbs">
                            <li><a href="">داشبورد</a></li>
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
                                    <a class="my-button toolbox-btn small" @click="showProjectCostModal= true">گزارش</a>
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
                                <!--Header End-->
                                <div class="table-contain dynamic-height-level2">
                                    <div class="grid-x" v-for="plans in approvedProjects_prov">
                                        <div class="medium-2 table-contain-border cell-vertical-center">
                                            {{ plans.credit_distribution_title.cdtIdNumber }}
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
                                                                 </ul>
                                                            </div>
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
                                    <a class="my-button toolbox-btn small" @click="openApprovedProjectInsertModal(1)">جدید</a>
                                    <a class="my-button toolbox-btn small" @click="showProjectCostModal= true">گزارش</a>
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
                                <!--Header End-->
                                <div class="table-contain dynamic-height-level2">
                                    <div class="grid-x" v-for="plans in approvedProjects_nat">
                                        <div class="medium-2 table-contain-border cell-vertical-center">
                                            {{ plans.credit_distribution_title.cdtIdNumber }}
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
                                                                </ul>
                                                            </div>
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
            <notifications group="aprrovedProjectPm"
                           position="bottom right"
                           animation-type="velocity"
                           :speed="700" />

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
                                            <option v-for="approvedPlan in approvedPlans" :value="approvedPlan.id">{{ approvedPlan.credit_distribution_title.cdtIdNumber + ' - ' + approvedPlan.credit_distribution_title.cdtSubject + ' - ' +  approvedPlan.credit_distribution_title.county.coName}}</option>
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
                                    <span v-show="errors.has('projectTitle')" class="error-font">لطفا کد پروژه انتخاب کنید!</span>
                                </div>
                            </div>
                            <div class="grid-x">
                                <div class="medium-4 cell padding-lr">
                                    <label>سال شروع
                                        <input class="form-element-margin-btm" type="text" name="startYear" v-model="approvedProjectsInput.apStartYear" v-validate="'required'" :class="{'input': true, 'error-border': errors.has('startYear')}">
                                    </label>
                                    <span v-show="errors.has('startYear')" class="error-font">لطفا سال شروع پروژه را وارد کنید!</span>
                                </div>
                                <div class="medium-4 cell padding-lr">
                                    <label>سال خاتمه
                                        <input class="form-element-margin-btm" type="text" name="endYear" v-model="approvedProjectsInput.apEndYear" v-validate="'required|numeric'" :class="{'input': true, 'error-border': errors.has('endYear')}">
                                    </label>
                                    <span v-show="errors.has('endYear')" class="error-font">لطفا سال خاتمه پروژه را وارد کنید!</span>
                                </div>
                                <div class="medium-4 cell padding-lr">
                                    <label> پیشرفت فیزیکی<span class="btn-red small-font"> (درصد) </span>
                                        <input  type="number" min="0" max="100" value="0" name="physicalProgress" v-model="approvedProjectsInput.apPhysicalProgress" v-validate="'required|numeric'" :class="{'input': true, 'error-border': errors.has('physicalProgress')}">
                                        <div style="margin-top: -16px;height:2px;" class="alert progress form-element-margin-btm">
                                            <div class="progress-meter" style="width: 75%"></div>
                                        </div>
                                    </label>
                                    <span v-show="errors.has('physicalProgress')" class="error-font">لطفا پیشرفت فیزیکی را وارد کنید!</span>
                                </div>
                                <div class="medium-4 cell padding-lr">
                                    <label>شهرستان
                                        <select class="form-element-margin-btm" :selected="approvedProjectsInput.apCity" v-model="approvedProjectsInput.apCity" name="city" v-validate data-vv-rules="required" :class="{'input': true, 'select-error': errors.has('city')}">
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

            <!--Project Cost Modal Start-->
            <modal-small v-if="showProjectCostModal" @close="showProjectCostModal = false">
                <div  slot="body">
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
                                <select  class="form-element-margin-btm"  name="row" v-validate data-vv-rules="required" :class="{'input': true, 'select-error': errors.has('row')}">
                                    <option value=""></option>

                                </select>
                                <span v-show="errors.has('row')" class="error-font">لطفا ردیف توزیع را انتخاب کنید!</span>
                            </label>
                        </div>
                        <div class="medium-3 cell padding-lr">
                            <label>نحوه اجرا
                                <select class="form-element-margin-btm" name="howToRun" v-validate data-vv-rules="required" :class="{'input': true, 'select-error': errors.has('howToRun')}">
                                    <option value=""></option>
                                </select>
                                <span v-show="errors.has('howToRun')" class="error-font">لطفا نحوه اجرا را انتخاب کنید!</span>
                            </label>
                        </div>
                    </div>
                    <div class="grid-x">
                        <div class="medium-4 column padding-lr">
                            <label>فصل
                                <select class="form-element-margin-btm"  name="season" v-validate data-vv-rules="required" :class="{'input': true, 'select-error': errors.has('season')}">
                                    <option value=""></option>
                                    <option v-for="season in seasons" :value="season.id"></option>
                                </select>
                                <span v-show="errors.has('season')" class="error-font">لطفا فصل را انتخاب کنید!</span>
                            </label>
                        </div>
                        <div class="medium-8 column padding-lr">
                            <label>عنوان فصل
                                <select class="form-element-margin-btm"  name="seasonTitle" v-validate data-vv-rules="required" :class="{'input': true, 'select-error': errors.has('seasonTitle')}">
                                    <option value=""></option>

                                </select>
                                <span v-show="errors.has('seasonTitle')" class="error-font">لطفا عنوان فصل را انتخاب کنید!</span>
                            </label>
                        </div>
                    </div>
                    <div class="grid-x">
                        <div class="medium-12 column padding-lr">
                            <label>ریز فصل
                                <select class="form-element-margin-btm" name="subSeason" v-validate data-vv-rules="required" :class="{'input': true, 'select-error': errors.has('subSeason')}">
                                    <option value=""></option>

                                </select>
                                <span v-show="errors.has('subSeason')" class="error-font">لطفا ریز فصل را انتخاب کنید!</span>
                            </label>
                        </div>
                    </div>
                    <div class="grid-x">
                        <div class="medium-6 cell padding-lr">
                            <label>مبلغ اعتبار <span class="btn-red">(میلیون ریال)</span>
                                <input class="form-element-margin-btm" type="text" name="cost" v-validate="'required|numeric'" :class="{'input': true, 'error-border': errors.has('cost')}">
                            </label>
                            <span v-show="errors.has('cost')" class="error-font">لطفا مبلغ اعتبار پروژه را وارد کنید!</span>
                        </div>
                    </div>
                    <div class="medium-6 columns padding-lr padding-bottom-modal input-margin-top">
                        <button name="Submit" class="my-button my-success float-left btn-for-load"> <span class="btn-txt-mrg">ثبت</span></button>
                    </div>
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
                approvedProjects_prov: [],
                approvedProjects_nat: [],
                approvedProjectsInput: {apPlan: '' , apProjectTitle: '' , apProjectCode: '' , apStartYear: '', apEndYear: '',
                                        apPhysicalProgress: '', apCity: '' , apDescription: ''},
                showInsertModal: false,
                showProjectCostModal: false,
                showModalUpdate: false,
                showModalDelete: false,
                approvedProjectsFill: {apPlan: '' , apProjectTitle: '' , apProjectCode: '' , apStartYear: '', apEndYear: '',
                    apHowToRun: '', apPhysicalProgress: '', aCity: '', apSubSeason: ''
                    , apLocation: '', apDescription: '',apCredit:''},

                provOrNat: '',
                apIdDelete: {},
                approvedPlans: {},
                counties: {},
                seasons: {},
                tinySeasons: {},
                selectedSeasons: '',
                creditDistributionRows: {},
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
            this.getAllApprovedPlan(0); // 0 = provincial
            this.getHowToRun();
            this.getCounties();
            this.getSeasons();
            this.getCreditDistributionRow();
        },

        updated: function () {
            $(this.$el).foundation(); //WORKS!
        },

        mounted: function () {
            console.log("mounted approved project component");
            res();
        },

        components:{
            'vue-pagination' : VuePagination
        },

        methods:{
            fetchProvincialData: function (page = 1) {
                axios.get('/budget/approved_project/capital_assets/fetchData?page=' + page , {params:{pOrN: 0}})
                    .then((response) => {
                        this.approvedProjects_prov = response.data.data;
                        this.makePagination(response.data , "provincial");
                        console.log(response);
                    },(error) => {
                        console.log(error);
                    });
            },

            fetchNationalData: function () {
                axios.get('/budget/project/capital_assets/projects/fetchData?page=' + page , {params:{pOrN: 1}})
                    .then((response) => {
                        this.approvedProjects_nat = response.data.data;
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
                axios.get('/budget/admin/how_to_run/getAllItems' , {params:{}})
                    .then((response) => {
                        this.howToRuns = response.data;
                        console.log(response);
                    },(error) => {
                        console.log(error);
                    });
            },

            getHowToRun: function () {
                axios.get('/budget/admin/how_to_run/getAllItems' , {params:{}})
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

            getTinySeasons: function () {
                axios.get('/budget/admin/sub_seasons/get_tiny_seasons_whit_season_id' , {params:{sId: this.selectedSeasons , planOrCost: 0}})
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

            openApprovedProjectInsertModal: function (type) {
                this.getAllApprovedPlan(type);
                this.showInsertModal= true;
                this.provOrNat = type;
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
                                this.approvedProjects_prov = response.data.data;
                                this.makePagination(response.data , "provincial");
                                this.showInsertModal = false;
                                this.displayNotif(response.status);
                                console.log(response);
                            },(error) => {
                                console.log(error);
                                //this.errorMessage = 'ریز فصل با این مشخصات قبلا ثبت شده است!';
                            });
                    }
                });
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

            displayNotif: function (httpStatusCode) {
                switch (httpStatusCode){
                    case 204:
                        this.$notify({group: 'aprrovedProjectPm', title: 'پیام سیستم', text: 'با توجه به وابستگی رکورد ها، حذف رکورد امکان پذیر نیست.' , type: 'error'});
                        break;
                    case 200:
                        this.$notify({group: 'aprrovedProjectPm', title: 'پیام سیستم', text: 'درخواست با موفقیت انجام شد.' , type: 'success'});
                        break;
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
