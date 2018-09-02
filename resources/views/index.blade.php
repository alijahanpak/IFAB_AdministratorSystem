<!doctype html>
<html class="no-js" lang="en" dir="rtl" xmlns:v-on="http://www.w3.org/1999/xhtml"
      xmlns:v-bind="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>سامانه یک پارچه اداری مالی</title>
    <link rel="icon" type="image/png" href="{{ asset('pic\tablogo.png') }}">
    <link rel="stylesheet" href="{{ asset('css/foundation.css') }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/font.css') }}">
    <link rel="stylesheet" href="{{ asset('foundation-icons/foundation-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('fontawesome-free-5.1.1-web/css/all.css') }}">
    <link rel="stylesheet" href="{{ asset('font-awesome-4.7.0/css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/line-spin-clockwise-fade-rotating.css') }}">
    <link rel="stylesheet" href="{{ asset('css/persian-datepicker.min.css') }}">

   {{-- <link rel="stylesheet" href="{{ asset('css/jquery.scrollbar.css') }}">--}}
    <link rel="stylesheet" href="{{ asset('css/key.css') }}">
    {{--<script src="{{ asset('js/Chart.js') }}"></script>--}}
</head>
<body  class="BYekan body-color">
    <passport-clients></passport-clients>
    <passport-authorized-clients></passport-authorized-clients>
    <passport-personal-access-tokens></passport-personal-access-tokens>
    <div id="container" @mouseover="userIsActive()">
        <!--Modal Login Start-->
        <modal-login v-if="showModalLogin" @close="showModalLogin = false" v-cloak>
            <div slot="body">
                <div class="login-frame">
                    <div class="grid-x">
                        <div class="medium-12">
                            <img class="float-center" src="{{ asset('pic\logom.jpg') }}" width="74px" height="74px">
                        </div>
                    </div>
                    <div class="grid-x">
                        <div class="medium-12">
                            <h5 class="BYekan text-center  login-txt">سامانه یکپارچه اداری، مالی و بودجه</h5>
                        </div>
                    </div>
                    <div style="margin-top:20px;" class="grid-x">
                        <div style="margin:0 auto;" class="large-3 cell callout ">
                            <form v-on:submit.prevent="login" v-cloak>
                                <div class="columns padding-lr">
                                    <label>نام کاربری
                                        <input style="font-family: FontAwesome;" class="form-element-margin-btm" type="text" placeholder="&#xf2c0;" autofocus name="user" v-model="authInfo.email" v-validate="'required'" :class="{'input': true, 'error-border': errors.has('user')}">
                                    </label>
                                    <span v-show="errors.has('user')" class="error-font">لطفا نام کاربری را وارد کنید!</span>
                                </div>
                                <div style="margin-top: 20px;" class="medium-12 columns padding-lr">
                                    <label>رمز عبور
                                        <input style="font-family: FontAwesome;" class="form-element-margin-btm" type="password" placeholder="&#xf09c;" name="pass" v-model="authInfo.password"  v-validate="'required'" :class="{'input': true, 'error-border': errors.has('pass')}">
                                    </label>
                                    <span v-show="errors.has('pass')" class="error-font">لطفا رمز عبور را وارد کنید!</span>
                                </div>
                                <div class="medium-12 padding-lr top-margin-element">
                                    <button style="margin-top: 20px;"  name="submit" class="my-button my-success expanded">ورود</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="grid-x">
                        <div class="large-12">
                            <ul class="menu small-font align-center ul-margin">
                                <li><a class="footer-menu" href="{{ url('/help_center') }}" target="_blank">راهنمای سامانه</a></li>
                                <li><a class="footer-menu" href="#">درباره ما</a></li>
                                <li><a class="footer-menu" href="#">دیدگاه</a></li>
                            </ul>
                        </div>
                        <div class="large-12">
                            <p class="small-font footer-txt-size">تمامی حقوق این وب سایت متعلق یه اداره کل میراث فرهنگی، صنایع دستی و گردشگری استان همدان می باشد</p>
                        </div>
                        <div style="margin-top: 20px;" class="large-12">
                            <img class="float-center" src="{{ asset('pic\keylogo.png') }}" width="130px" height="20px">
                        </div>
                    </div>
                </div>
            </div>
        </modal-login>
        <!--Modal Login End-->

        <!--Modal User Setting Start-->
        <modal-large v-if="showModalUserSetting" @close="showModalUserSetting = false" v-cloak>
            <div slot="body">
                <div class="grid-x">
                    <div  class="medium-12 profile-background-image-loading">
                        <div style="position: relative; width: 150px; height: 150px; top:50px;" class="float-center">
                            <img class="profile-image-cover" :src="imgDataUrl">
                            <a @click="toggleShow" style="right: 13%;top: 120px; position: absolute" class="center-pos profile-photo-edit-icon">
                                <i class="fa fa fa-pencil size-18" aria-hidden="true"></i>
                            </a>
                        </div>
                        <my-upload field="avatar_img"
                                   @crop-success="cropSuccess"
                                   @crop-upload-success="cropUploadSuccess"
                                   @crop-upload-fail="cropUploadFail"
                                   v-model="showUploadFile"
                                   :width="200"
                                   :height="200"
                                   :url="uploadUrl"
                                   :params="params"
                                   :headers="headers"
                                   langType="en"
                                   img-format="png">
                        </my-upload>
                    </div>
                    <div style="margin-top:60px; " class="medium-12">
                        <h4 class="BYekan center-pos">@{{ userInfo.name }}</h4>
                        <p class="center-pos gray-color">@{{ userInfo.role.rSubject }}</p>
                    </div>
                    <div class="medium-12">
                        <div class="align-center">
                            <div class="medium-12">
                            <div class="medium-2 center-pos">
                                <p class="gray-color size-14">نمایش مبالغ به:</p>
                            </div>
                            <div class="medium-2 center-pos">
                                <button style="width: 150px;" class="center-pos my-button toolbox-btn small dropdown small sm-btn-align"  type="button" data-toggle="costDropDownProv">@{{ amountBase.in_put_amount_unit.auSubject }}</button>
                                <div  style="width: 150px;" class="dropdown-pane dropdown-pane-sm " data-close-on-click="true"  data-hover="true" data-hover-pane="true"  data-position="bottom" data-alignment="left" id="costDropDownProv" data-dropdown data-auto-focus="true">
                                    <ul class="my-menu small-font">
                                        <li v-for="allAmountBases in allAmountBase"><a  @click="changeAllAmountBase(allAmountBases.id)">@{{ allAmountBases.auSubject }}</a></li>
                                    </ul>
                                </div>
                            </div>
                            </div>
                        </div>
                    </div>
                    <div class="medium-12 center-pos">
                        <transition name="fade">
                            <div v-if="!show">
                               <form v-on:submit.prevent="changePassword">
                                   <div style="margin-top: 20px;" class="medium-12 columns padding-lr">
                                       <label>رمز عبور فعلی
                                           <input style="font-family: FontAwesome;" class="form-element-margin-btm" type="password" placeholder="&#xf09c;" name="currentPass" v-model="changePassInput.password" v-validate="'required'" :class="{'input': true, 'error-border': errors.has('currentPass')}">
                                       </label>
                                       <span v-show="errors.has('newPass')" class="error-font">لطفا رمز عبور فعلی را وارد کنید!</span>
                                   </div>
                                   <div style="margin-top: 20px;" class="medium-12 columns padding-lr">
                                       <label>رمز عبور جدید
                                           <input style="font-family: FontAwesome;" class="form-element-margin-btm" type="password" placeholder="&#xf09c;" name="newPass" v-model="changePassInput.newPassword"  v-validate="'required'" :class="{'input': true, 'error-border': errors.has('newPass')}">
                                       </label>
                                       <span v-show="errors.has('newPass')" class="error-font">لطفا رمز عبور جدید را وارد کنید!</span>
                                   </div>
                                   <div style="margin-top: 20px;" class="medium-12 columns padding-lr">
                                       <label>تکرار رمز عبور جدید
                                           <input style="font-family: FontAwesome;" class="form-element-margin-btm" type="password" placeholder="&#xf09c;" name="reNewPass" v-model="changePassInput.reNewPassword"  v-validate="'required|confirmed:newPass'" :class="{'input': true, 'error-border': errors.has('reNewPass')}">
                                       </label>
                                       <span v-show="errors.has('reNewPass')" class="error-font">در وارد کردن کلمه عبور دقت کنید!</span>
                                   </div>
                                   <div v-show="(changePassInput.password != '' && changePassInput.password != null ) && (changePassInput.newPassword != '' && changePassInput.newPassword != null) && (changePassInput.reNewPassword != '' && changePassInput.reNewPassword != null)" class="medium-12 columns padding-lr">
                                       <button style="margin-top: 20px;" class="my-button my-success expanded">ثبت</button>
                                   </div>
                               </form>
                            </div>
                        </transition>
                    </div>
                    <div class="medium-12 center-pos">
                        <a v-on:click="show = !show" style="margin-top: 20px;">تغییر رمز عبور</a>
                    </div>
                </div>
            </div>
        </modal-large>
        <!--Modal User Setting End-->

        <!--Body system-->
        <div class="grid-x">
            <div id="leftmenuinner" style="background-color: #2C2E3E;z-index: 10;" class="medium-2 cell small-font">
                <div  id="leftmenuinnerinner ">
                    <div class="large-12">
                        <img class="float-center" src="{{ asset('pic\pallas.png') }}" width="150px" height="15px">
                    </div>
                    <nav class="accordion"  data-margin-top="4.2" v-cloak>
                        <ul style="background-color: #2C2E3E;" class="vertical menu sub-menu accordion-menu" data-accordion-menu data-multi-open="false" >
                            <li v-show='$can("BUDGET_CREDIT_DISTRIBUTION_PLAN_DISPLAY|BUDGET_CREDIT_DISTRIBUTION_PROPOSAL_DISPLAY")'>
                                <a class="right-menu-btm-border">توزیع اعتبار</a>
                                <ul class="menu vertical nested">
                                    <li v-show='$can("BUDGET_CREDIT_DISTRIBUTION_PLAN_DISPLAY|BUDGET_CREDIT_DISTRIBUTION_PROPOSAL_DISPLAY")'><a>تملک دارایی سرمایه ای</a>
                                        <ul class="menu vertical nested">
                                            <li><a>استانی</a>
                                                <ul class="menu vertical nested">
                                                    <li v-show='$can("BUDGET_CREDIT_DISTRIBUTION_PLAN_DISPLAY")'><router-link to="/budget/admin/credit_distribution/plan">طرح های توزیع اعتبار</router-link></li>
                                                    <li v-show='$can("BUDGET_CREDIT_DISTRIBUTION_PROPOSAL_DISPLAY")'><router-link to="/budget/admin/credit_distribution/proposal">پیشنهاد دستگاه</router-link></li>
                                                </ul>
                                            </li>
                                        </ul>
                                    </li>
                                </ul>
                            </li>
                            <li v-show='$can("BUDGET_CAPITAL_ASSETS_APPROVED_PLAN_DISPLAY|BUDGET_CAPITAL_ASSETS_APPROVED_PROJECT_DISPLAY|BUDGET_COST_APPROVED_PROG_DISPLAY")'>
                                <a class="right-mp right-menu-btm-border">  موافقتنامه</a>
                                <ul class="menu vertical nested">
                                    <li v-show='$can("BUDGET_COST_APPROVED_PROG_DISPLAY")'><a>هزینه ای</a>
                                        <ul class="menu vertical nested">
                                            <li v-show='$can("BUDGET_COST_APPROVED_PROG_DISPLAY")'><router-link to="/budget/approved/capital_assets/approved/program">برنامه ها</router-link></li>
                                        </ul>
                                    </li>
                                    <li v-show='$can("BUDGET_CAPITAL_ASSETS_APPROVED_PLAN_DISPLAY|BUDGET_CAPITAL_ASSETS_APPROVED_PROJECT_DISPLAY")'><a>تملک دارایی سرمایه ای</a>
                                        <ul class="menu vertical nested">
                                            <li v-show='$can("BUDGET_CAPITAL_ASSETS_APPROVED_PLAN_DISPLAY")'><router-link to="/budget/approved/capital_assets/approved/plan">طرح ها</router-link></li>
                                            <li v-show='$can("BUDGET_CAPITAL_ASSETS_APPROVED_PROJECT_DISPLAY")'><router-link to="/budget/approved/capital_assets/approved/project">پروژه ها</router-link></li>
                                        </ul>
                                    </li>

                                </ul>
                            </li>
                            <li v-show='$can("BUDGET_CAPITAL_ASSETS_ALLOCATION_DISPLAY|BUDGET_COST_ALLOCATION_DISPLAY|BUDGET_CAPITAL_ASSETS_FOUND_DISPLAY|BUDGET_COST_FOUND_DISPLAY")'>
                                <a class="right-mp right-menu-btm-border">تخصیص اعتبار</a>
                                <ul class="menu vertical nested">
                                    <li v-show='$can("BUDGET_COST_ALLOCATION_DISPLAY|BUDGET_COST_FOUND_DISPLAY")'><router-link to="/budget/Allocation/cost">هزینه ای</router-link></li>
                                    <li v-show='$can("BUDGET_CAPITAL_ASSETS_ALLOCATION_DISPLAY|BUDGET_CAPITAL_ASSETS_FOUND_DISPLAY")'><router-link to="/budget/allocation/capital_assets">تملک دارایی سرمایه ای</router-link></li>
                                </ul>
                            </li>
                            <li v-show='$can("BUDGET_ADMIN_FISCAL_YEARS_DISPLAY|BUDGET_ADMIN_DEPRIVED_AREA_DISPLAY|BUDGET_ADMIN_BUDGET_SEASON_DISPLAY|BUDGET_ADMIN_CREDIT_DISTRIBUTION_ROW_DISPLAY|BUDGET_ADMIN_PLAN_RO_COST_TITLE_DISPLAY|BUDGET_ADMIN_SEASON_TITLE_DISPLAY|BUDGET_ADMIN_TINY_SEASON_DISPLAY")'>
                                <a class="right-mp right-menu-btm-border">مدیریت</a>
                                <ul class="menu vertical nested">
                                    <li v-show='$can("BUDGET_ADMIN_FISCAL_YEARS_DISPLAY")'><router-link to="/budget/admin/fiscal_year">سال مالی</router-link></li>
                                    <li v-show='$can("BUDGET_ADMIN_DEPRIVED_AREA_DISPLAY")'><router-link to="/budget/admin/deprived_area">مناطق محروم</router-link></li>
                                    <li v-show='$can("BUDGET_ADMIN_BUDGET_SEASON_DISPLAY|BUDGET_ADMIN_CREDIT_DISTRIBUTION_ROW_DISPLAY|BUDGET_ADMIN_PLAN_RO_COST_TITLE_DISPLAY")'>
                                        <a>توزیع اعتبار</a>
                                        <ul class="menu vertical nested">
                                            <li v-show='$can("BUDGET_ADMIN_BUDGET_SEASON_DISPLAY")'><router-link to="/budget/admin/credit_distribution_def/budget_season">فصل بودجه</router-link></li>
                                            <li v-show='$can("BUDGET_ADMIN_CREDIT_DISTRIBUTION_ROW_DISPLAY")'><router-link to="/budget/admin/credit_distribution_def/row">ردیف توزیع اعتبار</router-link></li>
                                            <li v-show='$can("BUDGET_ADMIN_PLAN_RO_COST_TITLE_DISPLAY")'><router-link to="/budget/admin/credit_distribution_def/plan_cost_title">عنوان طرح / برنامه</router-link></li>
                                        </ul>
                                    </li>
                                    <li v-show='$can("BUDGET_ADMIN_SEASON_TITLE_DISPLAY|BUDGET_ADMIN_TINY_SEASON_DISPLAY")'>
                                        <a>فصول</a>
                                        <ul class="menu vertical nested">
                                            <li v-show='$can("BUDGET_ADMIN_SEASON_TITLE_DISPLAY")'><router-link to="/budget/admin/season/season_title">عنوان فصل</router-link></li>
                                            <li v-show='$can("BUDGET_ADMIN_TINY_SEASON_DISPLAY")'><router-link to="/budget/admin/season/tiny_seasons">ریز فصل</router-link></li>
                                        </ul>
                                    </li>
                                </ul>
                            </li>
                            <!--Financial Department Start-->
                            <li>
                                <a class="right-mp right-menu-btm-border">کارتابل</a>
                                <ul class="menu vertical nested is-active">
                                    <li><router-link to="/financial_department/submissions">درخواست های ارسالی</router-link></li>
                                    <li><router-link to="/financial_department/received_requests">درخواست های دریافتی (@{{ unReadRequestCount }})</router-link></li>
                                    <li><router-link to="/financial_department/search_requests">جستجو</router-link></li>
                                </ul>
                            </li>
                            <!--Financial Department End-->
                        </ul>
                    </nav>
                </div>
                <div class="grid-x">
                    <div class="medium-12">
                        <p style="margin-bottom: 5px;"  class="version-software text-center small-font">V:2576.1</p>
                    </div>
                </div>
            </div>
            <div class="medium-10 main-margin my-callout-box">
                <!--Top Menu Start-->
                <div style="z-index: 11;" data-sticky-container>
                    <div style="background-color: #FFFFFF;" class="top-bar top-menu-color" data-sticky data-margin-top="0">
                        <div class="top-bar-left"  v-cloak>
                            <button style="margin-bottom: 0;font-size: 0.9em;" class="my-button my-drop-down-btn-clear dropdown small sm-btn-align"  type="button" data-toggle="example-dropdown-bottom-left">سال مالی<span class="comlpleted-badage">@{{ currentFyLabel }}</span></button>
                            <div style="width: 120px;" class="dropdown-pane dropdown-pane-sm " data-close-on-click="true"  data-hover="true" data-hover-pane="true"  data-position="bottom" data-alignment="right" id="example-dropdown-bottom-left" data-dropdown data-auto-focus="true">
                                <ul class="my-menu small-font ltr-dir">
                                    <li v-for="fiscalYear in fiscalYears"><a @click="changeFiscalYear(fiscalYear.id)">@{{ fiscalYear.fyLabel }} <span v-show="fiscalYear.id == currentFyId()" class="fi-check checked-color size-14"></span></a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="top-bar-right"  v-cloak>
                            <ul style="background-color: #FFFFFF;" data-dropdown-menu class="dropdown  menu user-menu">
                                <li>
                                    <a style="margin-top: -3px;"><i class="fa fa-bell-o size-20 icon-gradient" aria-hidden="true"></i></a>
                                    <ul style="background-color:#FFFFFF;" class="top-menu-style menu vertical">
                                        <li>
                                            <div class="top-menu-bg">
                                                <div class="grid-x cover-color">
                                                    <div class="medium-12">
                                                        <h5 class="text-center BYekan">9 پیام جدید</h5>
                                                    </div>
                                                    <div class="medium-12">
                                                        <p class="text-center">پیام های کاربر</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="border-btm-line-dash">
                                            <a style="padding-bottom: -5px;">
                                                <div>
                                                    <strong style="color: #000000;">علیرضا طاهری</strong>
                                                    <span style="color: #777;" class="message-time large-offset-7">41 دقیقه قبل</span>
                                                </div>
                                                <div>
                                                    <p style="color:  #333;margin-top: 12px;"> موافقت نامه سال 1396 در مورد پروژه های عمرانی در دست اقدام پیگیری از سازمان</p>
                                                </div>
                                            </a>
                                        </li>
                                        <li class="border-btm-line">
                                            <a style="padding-bottom: -5px;">
                                                <div>
                                                    <strong style="color: #000000;">علیرضا طاهری</strong>
                                                    <span style="color: #777;" class="message-time large-offset-7">دو روز پیش</span>
                                                </div>
                                                <div>
                                                    <p style="color:  #333;margin-top: 12px;"> موافقت نامه سال 1396 در مورد پروژه های عمرانی در دست اقدام پیگیری از سازمان</p>
                                                </div>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                                <li>
                                    <a><span style="font-size: 14px;color: #666;"> @{{ userInfo.name }} </span></a>
                                    <ul style="background-color: #ffffff;" class="top-menu-style menu menu vertical small-font white-color">
                                        <li>
                                            <div class="top-menu-bg">
                                                <div class="grid-x cover-color">
                                                    <div class="medium-12">
                                                        <img style="width: 60px;height: 60px;margin-top: 10px;margin-bottom: 10px;" class="profile-image-cover-index profile-image-cover-pos float-center" :src="imgDataUrl">
                                                        <h5 class="text-center BYekan">@{{ userInfo.name }}</h5>
                                                    </div>
                                                    <div class="medium-12">
                                                        <p class="text-center" style="margin-bottom: 0">@{{ userInfo.role.rSubject }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="menu-top"><a v-on:click="openModalUserSetting"><i class="tbl-menu fa fa-sliders"></i> <span>تنظیمات</span></a></li>
                                        <li class="menu-top"><a v-on:click="logout"><i class="tbl-menu fa fa-sign-out"></i> <span>خروج</span></a></li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <!--Top Menu End-->
            </div>
            <router-view></router-view>
            <!-- set progressbar -->
            <vue-progress-bar></vue-progress-bar>
            <audio ref="successAlarm" src="{{ asset('alarms/success.mp3') }}"></audio>
            <audio ref="errorAlarm" src="{{ asset('alarms/error.mp3') }}"></audio>
            <div class="medium-12 my-footer">
                <div class="grid-x">
                    <div style="padding-top: 4px;" class="medium-12">
                        <div class="small button-group float-left footer-menu">
                            <a class="clear button menu-color" href="{{ url('/help_center') }}" target="_blank">راهنمای سامانه</a>
                            <a class="clear button menu-color">درباره ما</a>
                            <a class="clear button menu-color">ارتباط با ما</a>
                            <a class="clear button menu-color">دیدگاه</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <notifications position="bottom right"
                       animation-type="velocity"
                       :speed="700" />
    </div>
    <script type="text/x-template" id="modal-tiny-template">
        <transition name="modal-tiny">
            <div class="modal-mask">
                <div class="modal-wrapper">
                    <div class="my-tiny">
                        <div class="modal-header">
                            <slot name="header">
                                <button class="change-pointer" @click="$emit('close')" type="button">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                <a class="float-left" style="margin-top: 2px;" href="{{ url('/help_center') }}" target="_blank"><i class="fa fa-question size-18 icon-gradient" aria-hidden="true"></i></a>
                            </slot>
                        </div>
                        <div class="modal-body">
                            <slot name="body">
                            </slot>
                        </div>
                    </div>
                </div>
            </div>
        </transition>
    </script>
    <script type="text/x-template" id="modal-small-template">
        <transition name="modal-small">
            <div class="modal-mask">
                <div class="modal-wrapper">
                    <div class="my-small">
                        <div class="modal-header">
                            <slot name="header">
                                <button class="change-pointer" @click="$emit('close')" type="button">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                <a class="float-left" style="margin-top: 2px;" href="{{ url('/help_center') }}" target="_blank"><i class="fa fa-question size-18 icon-gradient" aria-hidden="true"></i></a>
                            </slot>
                        </div>
                        <div class="modal-body">
                            <slot name="body">
                            </slot>
                        </div>
                    </div>
                </div>
            </div>
        </transition>
    </script>
    <script type="text/x-template" id="modal-large-template">
        <transition name="modal-large">
            <div class="modal-mask">
                <div class="modal-wrapper">
                    <div class="my-large">
                        <div class="modal-header">
                            <slot name="header">
                                <button class="change-pointer" @click="$emit('close')" type="button">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                <a class="float-left" style="margin-top: 2px;" href="{{ url('/help_center') }}" target="_blank"><i class="fa fa-question size-18 icon-gradient" aria-hidden="true"></i></a>
                            </slot>
                        </div>
                        <div class="modal-body">
                            <slot name="body">
                            </slot>
                        </div>
                    </div>
                </div>
            </div>
        </transition>
    </script>
    <script type="text/x-template" id="modal-full-screen-template">
        <transition name="modal-full-screen">
            <div class="modal-mask">
                <div class="modal-wrapper">
                    <div class="my-full-screen">
                        <div class="modal-header">
                            <slot name="header">
                                <button class="change-pointer" @click="$emit('close')" type="button">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                <a class="float-left" style="margin-top: 2px;" href="{{ url('/help_center') }}" target="_blank"><i class="fa fa-question size-18 icon-gradient" aria-hidden="true"></i></a>
                            </slot>
                        </div>
                        <div class="modal-body">
                            <slot name="body">
                            </slot>
                        </div>
                    </div>
                </div>
            </div>
        </transition>
    </script>
    <script type="text/x-template" id="modal-login-template">
        <transition name="modal-login">
            <div class="modal-mask-login">
                <div class="modal-wrapper">
                    <div style="padding: 0;" class="my-full-screen-login">
                        <div class="modal-header">
                            <slot name="header">

                            </slot>
                        </div>
                        <div style="margin: 0;" class="modal-body">
                            <slot name="body">
                            </slot>
                        </div>
                    </div>
                </div>
            </div>
        </transition>
    </script>
    <script type="text/x-template" id="modal-access-denied-template">
        <transition name="modal-access-denied">
            <div class="modal-mask-assess-denied">
                <div class="modal-wrapper">
                    <div style="padding: 0;" class="my-full-screen-login">
                        <div class="modal-header">
                            <slot name="header">

                            </slot>
                        </div>
                        <div style="margin: 0;" class="modal-body">
                            <slot name="body">
                            </slot>
                        </div>
                    </div>
                </div>
            </div>
        </transition>
    </script>

    <script src="{{ asset('js/vendor/jquery.js') }}"></script>
    <script src="{{ asset('js/vendor/what-input.js') }}"></script>
    <script src="{{ asset('js/vendor/foundation.js') }}"></script>
{{--<script src="{{ asset('js/persian-date.min.js') }}"></script>
    <script src="{{ asset('js/persian-datepicker.min.js') }}"></script>
    <script src="{{ asset('js/jquery.scrollbar.min.js') }}"></script>--}}
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/key.js') }}"></script>


</body>
</html>