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
                                <a class="disabled">تملک دارایی سرمایه ای</a>
                            </li>
                            <li>
                                <span class="show-for-sr">Current: </span>طرح ها
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
        <div class="grid-x  my-callout-box container-mrg-top dynamic-height-level1">
            <div  class="medium-12 column">
                <ul class="tabs tab-color my-tab-style" data-responsive-accordion-tabs="tabs medium-accordion large-tabs" id="approved_plan_tab_view">
                    <li class="tabs-title is-active"><a href="#provincial_tab" aria-selected="true">استانی</a></li>
                    <li class="tabs-title"><a href="#national_tab">ملی</a></li>
                </ul>
                <div class="tabs-content" data-tabs-content="approved_plan_tab_view">
                    <div class="tabs-panel is-active table-mrg-btm" id="provincial_tab"
                         xmlns:v-on="http://www.w3.org/1999/xhtml">
                        <div class="medium-12 bottom-mrg">
                            <!--Tab 1-->
                            <div class="clearfix border-btm-line bottom-mrg tool-bar">
                                <div style="margin-top: 2px;" class="button-group float-right report-mrg">
                                    <a class="my-button toolbox-btn small" @click="openApprovedPlanInsertModal(0)">جدید</a>
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
                                    <div class="medium-3  table-border">
                                        <strong>طرح</strong>
                                    </div>
                                    <div class="medium-2  table-border">
                                        <strong>مبادله شده</strong>
                                    </div>
                                    <div class="medium-2 table-border">
                                        <strong>ابلاغی</strong>
                                    </div>
                                    <div class="medium-2  table-border">
                                        <strong>شهرستان</strong>
                                    </div>
                                    <div class="medium-3  table-border">
                                        <strong>شرح</strong>
                                    </div>
                                </div>
                                <!--Header End-->
                                <div class="table-contain dynamic-height-level2">
                                    <div class="grid-x" v-for="plans in approvedPlan_prov">
                                        <div class="medium-3 table-contain-border cell-vertical-center">
                                            {{ plans.credit_distribution_title.cdtIdNumber + ' - ' + plans.credit_distribution_title.cdtSubject }}
                                        </div>
                                        <div class="medium-2 table-contain-border cell-vertical-center text-center">
                                            <div>{{ plans.capExchangeIdNumber }}</div>
                                            <div>{{ plans.capExchangeDate }}</div>
                                        </div>
                                        <div class="medium-2 table-contain-border cell-vertical-center text-center">
                                            <div>{{ plans.capLetterNumber }}</div>
                                            <div>{{ plans.capLetterDate }}</div>
                                        </div>
                                        <div class="medium-2 table-contain-border cell-vertical-center">
                                            {{ plans.credit_distribution_title.county.coName }}
                                        </div>
                                        <div class="medium-3  table-contain-border cell-vertical-center">
                                            <div class="grid-x">
                                                <div class="medium-11">
                                                    {{ plans.capDescription }}
                                                </div>
                                                <div class="medium-1 cell-vertical-center text-left">
                                                    <a class="dropdown small sm-btn-align"  type="button" :data-toggle="'approvedPlans' + plans.id"><i class="fa fa-ellipsis-v size-18"></i></a>
                                                    <div class="dropdown-pane dropdown-pane-sm " data-close-on-click="true"  data-hover="true" data-hover-pane="true"  data-position="bottom" data-alignment="right" :id="'approvedPlans' + plans.id" data-dropdown data-auto-focus="true">
                                                        <ul class="my-menu small-font text-right">
                                                            <li><a v-on:click.prevent="approvedPlanUpdateDialog(plans)"><i class="fa fa-pencil-square-o size-16"></i>  ویرایش</a></li>
                                                            <li><a v-on:click.prevent="openDeleteApprovedPlanConfirm(plans)"><i class="fa fa-trash-o size-16"></i>  حذف</a></li>
                                                            <li><a v-on:click.prevent="openApprovedAmendmentModal"><i class="fa fa-newspaper-o size-16"></i>  اصلاحیه</a></li>
                                                         </ul>
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
                                    <a class="my-button toolbox-btn small" @click="openApprovedPlanInsertModal(1)">جدید</a>
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
                                    <div class="medium-3  table-border">
                                        <strong>طرح</strong>
                                    </div>
                                    <div class="medium-2  table-border">
                                        <strong>مبادله شده</strong>
                                    </div>
                                    <div class="medium-2 table-border">
                                        <strong>ابلاغی</strong>
                                    </div>
                                    <div class="medium-5  table-border">
                                        <strong>شرح</strong>
                                    </div>
                                </div>
                                <!--Header End-->
                                <div class="table-contain dynamic-height-level2">
                                    <div class="grid-x" v-for="plans in approvedPlan_nat">
                                        <div class="medium-3 table-contain-border cell-vertical-center">
                                            {{ plans.credit_distribution_title.cdtIdNumber + ' - ' + plans.credit_distribution_title.cdtSubject }}
                                        </div>
                                        <div class="medium-2 table-contain-border cell-vertical-center text-center">
                                            <div>{{ plans.capExchangeIdNumber }}</div>
                                            <div>{{ plans.capExchangeDate }}</div>
                                        </div>
                                        <div class="medium-2 table-contain-border cell-vertical-center text-center">
                                            <div>{{ plans.capLetterNumber }}</div>
                                            <div>{{ plans.capLetterDate }}</div>
                                        </div>
                                        <div class="medium-5  table-contain-border cell-vertical-center">
                                            <div class="grid-x">
                                                <div class="medium-11">
                                                    {{ plans.capDescription }}
                                                </div>
                                                <div class="medium-1 cell-vertical-center text-left">
                                                    <a class="dropdown small sm-btn-align"  type="button" :data-toggle="'approvedPlans' + plans.id"><i class="fa fa-ellipsis-v size-18"></i></a>
                                                    <div class="dropdown-pane dropdown-pane-sm " data-close-on-click="true"  data-hover="true" data-hover-pane="true"  data-position="bottom" data-alignment="right" :id="'approvedPlans' + plans.id" data-dropdown data-auto-focus="true">
                                                        <ul class="my-menu small-font text-right">
                                                            <li><a v-on:click.prevent="approvedPlanUpdateDialog(plans)"><i class="fa fa-pencil-square-o size-16"></i>  ویرایش</a></li>
                                                            <li><a v-on:click.prevent="openDeleteApprovedPlanConfirm(plans)"><i class="fa fa-trash-o size-16"></i>  حذف</a></li>
                                                        </ul>
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
            <!--Forms Start-->
            <!--Insert Modal Start-->
            <!-- use the modal component, pass in the prop -->
            <modal-small v-if="showInsertModal" @close="showInsertModal = false">
                    <div slot="body">
                        <form v-on:submit.prevent="createApprovedPlan">
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
                                        <select class="form-element-margin-btm"  v-model="approvedPlanInput.cdtId" name="plan" v-validate data-vv-rules="required" :class="{'input': true, 'select-error': errors.has('plan')}">
                                            <option value=""></option>
                                            <option v-for="creditDistributionTitle in creditDistributionTitles" :value="creditDistributionTitle.id">{{ creditDistributionTitle.cdtIdNumber + ' - ' + creditDistributionTitle.cdtSubject + (creditDistributionTitle.county == null ? '' : ' - ' + creditDistributionTitle.county.coName)}}</option>
                                        </select>
                                        <span v-show="errors.has('plan')" class="error-font">لطفا طرح را انتخاب کنید!</span>
                                    </label>
                                </div>
                            </div>
                            <div class="grid-x">
                                <div class="medium-6 columns padding-lr">
                                    <label>شماره
                                        <input class="form-element-margin-btm" type="text" name="capLetterNumber" v-model="approvedPlanInput.idNumber" v-validate data-vv-rules="required" :class="{'input': true, 'select-error': errors.has('capLetterNumber')}">
                                    </label>
                                    <span v-show="errors.has('capLetterNumber')" class="error-font">شماره فراموش شده است!</span>
                                </div>
                                <div class="medium-6 columns padding-lr">
                                    <label>تاریخ
                                        <input class="form-element-margin-btm" type="text" name="capLetterDate"  v-model="approvedPlanInput.date" v-validate data-vv-rules="required" :class="{'input': true, 'select-error': errors.has('capLetterDate')}">
                                    </label>
                                    <span v-show="errors.has('capLetterDate')" class="error-font">تاریخ فراموش شده است!</span>
                                </div>
                                <div class="medium-6 columns padding-lr">
                                    <label>شماره مبادله
                                        <input class="form-element-margin-btm" type="text" name="capExLetterNumber" v-model="approvedPlanInput.exIdNumber" v-validate data-vv-rules="required" :class="{'input': true, 'select-error': errors.has('capExLetterNumber')}">
                                    </label>
                                    <span v-show="errors.has('capExLetterNumber')" class="error-font">شماره فراموش شده است!</span>
                                </div>
                                <div class="medium-6 columns padding-lr">
                                    <label>تاریخ مبادله
                                        <input class="form-element-margin-btm" type="text" name="capExLetterDate"  v-model="approvedPlanInput.exDate" v-validate data-vv-rules="required" :class="{'input': true, 'select-error': errors.has('capExLetterDate')}">
                                    </label>
                                    <span v-show="errors.has('capExLetterDate')" class="error-font">تاریخ فراموش شده است!</span>
                                </div>
                            </div>
                            <div class="grid-x">
                                <div class="small-12 columns padding-lr">
                                    <label>شرح
                                        <textarea name="apDescription" style="min-height: 150px;" v-model="approvedPlanInput.apDescription"></textarea>
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
            <!--Amendment Modal Start-->
            <modal-small v-if="showModalAmendment" @close="showModalAmendment = false">
                <div slot="body">
                    <form v-on:submit.prevent="">
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
                                    <select disabled="true" name="plan">
                                        <option value=""></option>
                                        <option></option>
                                    </select>
                                </label>
                            </div>
                        </div>
                        <div class="grid-x">
                            <div class="medium-6 columns padding-lr">
                                <label>شماره
                                    <input class="form-element-margin-btm" type="text" name="capLetterNumber" v-model="approvedPlanInput.idNumber" v-validate data-vv-rules="required" :class="{'input': true, 'select-error': errors.has('capLetterNumber')}">
                                </label>
                                <span v-show="errors.has('capLetterNumber')" class="error-font">شماره فراموش شده است!</span>
                            </div>
                            <div class="medium-6 columns padding-lr">
                                <label>تاریخ
                                    <input class="form-element-margin-btm" type="text" name="capLetterDate"  v-model="approvedPlanInput.date" v-validate data-vv-rules="required" :class="{'input': true, 'select-error': errors.has('capLetterDate')}">
                                </label>
                                <span v-show="errors.has('capLetterDate')" class="error-font">تاریخ فراموش شده است!</span>
                            </div>
                            <div class="medium-6 columns padding-lr">
                                <label>شماره مبادله
                                    <input disabled="true" type="text" name="capExLetterNumber" v-model="approvedPlanInput.exIdNumber">
                                </label>
                            </div>
                            <div class="medium-6 columns padding-lr">
                                <label>تاریخ مبادله
                                    <input disabled="true" type="text" name="capExLetterDate"  v-model="approvedPlanInput.exDate">
                                </label>
                            </div>
                        </div>
                        <div class="grid-x">
                            <div class="small-12 columns padding-lr">
                                <label>شرح
                                    <textarea name="apDescription" style="min-height: 150px;" v-model="approvedPlanInput.apDescription"></textarea>
                                </label>
                            </div>
                        </div>
                        <div class="medium-6 columns padding-lr padding-bottom-modal">
                            <div class="button-group float-left report-mrg">
                                <button class="my-button my-danger float-left btn-for-load"> <span class="btn-txt-mrg">لغو</span></button>
                                <button @click="openApprovedAmendmentOfAgreementModal" class="my-button my-success float-left btn-for-load"> <span class="btn-txt-mrg">تایید</span></button>
                            </div>
                        </div>
                    </form>
                </div>
            </modal-small>
            <!--Amendment Modal End-->

            <!--Amendment Of The Agreement Modal Start-->
            <modal-full-screen v-if="showModalAmendmentOfAgreement" @close="showModalAmendmentOfAgreement = false">
                <div slot="body">
                        <div class="grid-x" v-if="errorMessage">
                            <div class="medium-12 columns padding-lr">
                                <div class="alert callout">
                                    <p class="BYekan login-alert"><i class="fi-alert"></i>{{ errorMessage }}</p>
                                </div>
                            </div>
                        </div>
                        <div style="padding:0px;" class="grid-x border-btm-line">
                            <div class="medium-12 cell padding-lr">
                               <div class="grid-x">
                                   <div class="medium-4">
                                       <strong>اصلاحیه موافقت نامه: </strong>
                                   </div>
                                   <div class="medium-2">
                                       <p>شماره ابلاغ : </p>
                                   </div>
                                   <div class="medium-2">
                                       <strong class="btn-red">---- </strong>
                                   </div>
                                   <div class="medium-2">
                                       <p>تاریخ ابلاغ : </p>
                                   </div>
                                   <div class="medium-2">
                                       <strong class="btn-red">---- </strong>
                                   </div>
                               </div>
                            </div>
                            <div class="medium-12 cell padding-lr">
                                <div class="grid-x">
                                    <div class="medium-2">
                                        <strong>شرح موافقت نامه: </strong>
                                    </div>
                                    <div class="medium-10 padding-bottom-modal">
                                        <p style="display: inline">شماره ابلاغ :dfsdf df df dfssdsadsdsa sdasdasdasd asdasd as dasd dfdfdsfdsfsdf ffsdf df df dfdfdfdfsdfsdfsd sdf sdfds sdfsd fsdf sdf d fsdfdfsdfsdf sdf df dfsdfsdfsdfsdfsdfsdf sdf sdf d </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <div style="margin-top: 15px;" class="grid-x border-btm-line">
                        <div style="margin-top: 2px;" class="button-group float-right">
                            <a class="my-button toolbox-btn small" @click="openInsertProjectModal">پروژه جدید</a>
                        </div>
                    </div>
                    <div style="margin-top: 10px;" class="grid-x">
                        <!--Table Start-->
                        <!--Table Head Start-->
                        <div class="tbl-div-container">
                            <table class="tbl-head">
                                <colgroup>
                                    <col width="200px"/>
                                    <col width="150px"/>
                                    <col width="100px"/>
                                    <col width="100px"/>
                                    <col width="100"/>
                                    <col width="150px"/>
                                    <col width="150px"/>
                                    <col width="12px"/>
                                </colgroup>
                                <tbody class="tbl-head-style ">
                                <tr class="tbl-head-style-cell">
                                    <th class="tbl-head-style-cell">عنوان پروژه</th>
                                    <th class="tbl-head-style-cell">کد پروژه</th>
                                    <th class="tbl-head-style-cell">سال شروع </th>
                                    <th class="tbl-head-style-cell">سال خاتمه</th>
                                    <th class="tbl-head-style-cell">پیشرفت فیزیکی</th>
                                    <th class="tbl-head-style-cell">شهرستان</th>
                                    <th class="tbl-head-style-cell">شرح</th>
                                    <th class="tbl-head-style-cell"></th>
                                </tr>
                                </tbody>
                            </table>
                            <!--Table Head End-->
                            <!--Table Body Start-->
                            <div class="tbl_body_style dynamic-height-level1">
                                <table class="tbl-body-contain">
                                    <colgroup>
                                        <col width="200px"/>
                                        <col width="150px"/>
                                        <col width="100px"/>
                                        <col width="100px"/>
                                        <col width="100"/>
                                        <col width="150px"/>
                                        <col width="150px"/>
                                    </colgroup>
                                    <tbody class="tbl-head-style-cell">
                                    <td>مرمت مسجد جامع همدان</td>
                                    <td>14242</td>
                                    <td>42</td>
                                    <td>424</td>
                                    <td>424</td>
                                    <td>424</td>
                                    <td>
                                        <div class="grid-x">
                                            <div class="medium-11">
                                                42
                                            </div>
                                            <div class="medium-1 cell-vertical-center text-left">
                                                <a class="dropdown small sm-btn-align" data-toggle="tblRow"  type="button"><i class="fa fa-ellipsis-v size-18"></i></a>
                                                <div class="dropdown-pane dropdown-pane-sm " data-close-on-click="true"  data-hover="true" data-hover-pane="true"  data-position="bottom" data-alignment="right" id="tblRow" data-dropdown data-auto-focus="true">
                                                    <ul class="my-menu small-font text-right">
                                                        <li><a v-on:click.prevent=""><i class="fa fa-pencil-square-o size-16"></i>  ویرایش</a></li>
                                                        <li><a v-on:click.prevent=""><i class="fa fa-trash-o size-16"></i>  حذف</a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </td>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                            <!--Table Body End-->
                    </div>
                </div>
            </modal-full-screen>
            <!--Amendment Of The Agreement Modal End-->

            <!--Insert Project Modal Start-->
            <modal-small v-if="showInsertModalProject" @close="showInsertModalProject = false">
                <div slot="body">
                    <form v-on:submit.prevent="">
                        <div class="grid-x" v-if="errorMessage">
                            <div class="medium-12 columns padding-lr">
                                <div class="alert callout">
                                    <p class="BYekan login-alert"><i class="fi-alert"></i>{{ errorMessage }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="grid-x">
                            <div class="medium-8 cell padding-lr">
                                <label>عنوان پروژه
                                    <input class="form-element-margin-btm" type="text" name="projectTitle"  v-validate="'required'" :class="{'input': true, 'error-border': errors.has('projectTitle')}">
                                </label>
                                <span v-show="errors.has('projectTitle')" class="error-font">لطفا عنوان پروژه انتخاب کنید!</span>
                            </div>
                            <div class="medium-4 cell padding-lr">
                                <label>کد پروژه
                                    <input class="form-element-margin-btm" type="text" name="projectCode" v-validate="'required|numeric'" :class="{'input': true, 'error-border': errors.has('projectCode')}">
                                </label>
                                <span v-show="errors.has('projectCode')" class="error-font">لطفا کد پروژه انتخاب کنید!</span>
                            </div>
                        </div>
                        <div class="grid-x">
                            <div class="medium-4 cell padding-lr">
                                <label>سال شروع
                                    <input class="form-element-margin-btm datePickerClass" type="text" name="startYear"  v-validate="'required'" :class="{'input': true, 'error-border': errors.has('startYear')}">
                                </label>
                                <span v-show="errors.has('startYear')" class="error-font">لطفا سال شروع پروژه را وارد کنید!</span>
                            </div>
                            <div class="medium-4 cell padding-lr">
                                <label>سال خاتمه
                                    <input class="form-element-margin-btm datePickerClass" type="text" name="endYear"  v-validate="'required'" :class="{'input': true, 'error-border': errors.has('endYear')}">
                                </label>
                                <span v-show="errors.has('endYear')" class="error-font">لطفا سال خاتمه پروژه را وارد کنید!</span>
                            </div>
                            <div class="medium-4 cell padding-lr">
                                <label> پیشرفت فیزیکی<span class="btn-red small-font"> (درصد) </span>
                                    <input  type="number" min="0" max="100" value="0" name="physicalProgress" v-validate="'required|numeric'" :class="{'input': true, 'error-border': errors.has('physicalProgress')}">
                                    <div style="margin-top: -16px;height:2px;" class="alert progress form-element-margin-btm">
                                        <div class="progress-meter" style="width: 100%"></div>
                                    </div>
                                </label>
                                <span v-show="errors.has('physicalProgress')" class="error-font">لطفا پیشرفت فیزیکی را وارد کنید!</span>
                            </div>
                            <div class="medium-4 cell padding-lr">
                                <label>شهرستان
                                    <select class="form-element-margin-btm" name="city" v-validate data-vv-rules="required" :class="{'input': true, 'select-error': errors.has('city')}">
                                        <option value=""></option>
                                        <option></option>
                                    </select>
                                    <span v-show="errors.has('city')" class="error-font">لطفا شهرستان را انتخاب کنید!</span>
                                </label>
                            </div>
                        </div>
                        <div class="grid-x">
                            <div class="small-12 columns padding-lr">
                                <label>شرح
                                    <textarea name="apDescription" style="min-height: 150px;" ></textarea>
                                </label>
                            </div>
                        </div>
                        <div class="medium-6 columns padding-lr padding-bottom-modal">
                            <button name="Submit" class="my-button my-success float-left btn-for-load"> <span class="btn-txt-mrg">ثبت</span></button>
                        </div>
                    </form>
                </div>
            </modal-small>
            <!--Insert Project Modal End-->

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
                approvedPlan_prov: [],
                approvedPlan_nat: [],
                approvedPlanInput: {},
                showInsertModal: false,
                showModalUpdate: false,
                showModalDelete: false,
                showModalAmendment:false,
                showModalAmendmentOfAgreement:false,
                showInsertModalProject:false,
                approvedPlanFill: {},
                creditDistributionTitles: [],

                provOrNat: '',
                apIdDelete: {},
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
            console.log("mounted approved project component");
            this.$parent.myResize();
        },

        components:{
            'vue-pagination' : VuePagination
        },

        methods:{
            fetchProvincialData: function (page = 1) {
                axios.get('/budget/approved_plan/capital_assets/fetchData?page=' + page , {params:{pOrN: 0}})
                    .then((response) => {
                        this.approvedPlan_prov = response.data.data;
                        this.makePagination(response.data , "provincial");
                        console.log(response);
                    },(error) => {
                        console.log(error);
                    });
            },

            fetchNationalData: function (page = 1) {
                axios.get('/budget/approved_plan/capital_assets/fetchData?page=' + page , {params:{pOrN: 1}})
                    .then((response) => {
                        this.approvedPlan_nat = response.data.data;
                        this.makePagination(response.data , "national");
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

            openApprovedPlanInsertModal: function (type) {
                this.getCreditDistributionTitle(type);
                this.provOrNat = type;
                this.showInsertModal= true;
            },

            createApprovedPlan: function () {
                this.$validator.validateAll().then((result) => {
                    if (result) {
                        axios.post('/budget/approved_plan/capital_assets/register' , {
                            cdtId: this.approvedPlanInput.cdtId,
                            idNumber: this.approvedPlanInput.idNumber,
                            date: this.approvedPlanInput.date,
                            exIdNumber: this.approvedPlanInput.exIdNumber,
                            exDate: this.approvedPlanInput.exDate,
                            description: this.approvedPlanInput.apDescription,
                            pOrN: this.provOrNat
                        }).then((response) => {
                                if (this.provOrNat == 0)
                                {
                                    this.approvedPlan_prov = response.data.data;
                                    this.makePagination(response.data , "provincial");
                                }
                                else
                                {
                                    this.approvedPlan_nat= response.data.data;
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
            openApprovedAmendmentModal: function () {
                this.showModalAmendment= true;
            },
            openApprovedAmendmentOfAgreementModal: function () {
                this.showModalAmendmentOfAgreement= true;
                this.$parent.myResize();
            },
            openInsertProjectModal: function () {
                this.showInsertModalProject= true;
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
