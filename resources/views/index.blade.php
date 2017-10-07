<!doctype html>
<html class="no-js" lang="en" dir="rtl" xmlns:v-on="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>سامانه یک پارچه اداری مالی</title>
    <link rel="icon" type="image/png" href="{{ asset('pic\logom.jpg') }}">
    <link rel="stylesheet" href="{{ asset('css/foundation.css') }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/font.css') }}">
    <link rel="stylesheet" href="{{ asset('foundation-icons/foundation-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('css/line-spin-clockwise-fade-rotating.css') }}">
    <link rel="stylesheet" href="{{ asset('css/persian-datepicker.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/key.css') }}">
    <script src="{{ asset('js/Chart.js') }}"></script>
</head>
<body  class="BYekan body-color">
    <passport-clients></passport-clients>
    <passport-authorized-clients></passport-authorized-clients>
    <passport-personal-access-tokens></passport-personal-access-tokens>
    <!--chart1 Modal Start-->
    <div style="z-index: 9999;" class="large reveal" id="exampleModal1" data-reveal>
        <h6 class="text-center BYekan">نمودار تخصیص اعتبارات بر اساس منابع</h6>

        <canvas id="myChartM"></canvas>
        <button class="close-button" data-close aria-label="Close modal" type="button">
            <span aria-hidden="true">&times;</span>
        </button>
        <button type="button" class="my-secondary small button float-left" data-open="exampleModal1"><i class="fi-archive"></i> دریافت </button>
    </div>
    <!--chart1 Modal End-->
    <div id="container">

        <!--Top Menu Start-->
        <div style="z-index: 999;" data-sticky-container>
            <div style="background-color: #FFFFFF;" class="top-bar top-menu-color" data-sticky data-margin-top="0">
                <div class="top-bar-left">
                    <ul style="background-color: #FFFFFF;" data-dropdown-menu class="dropdown  menu user-menu" >
                        <li>
                            <a href="#"><span style="font-size: 14px;color: #666;"> علی جهان پاک </span></a>
                            <ul style="background-color: #ffffff;" class="top-menu-style menu vertical small-font white-color">
                                <li>
                                    <div class="top-menu-bg">
                                        <div class="grid-x cover-color">
                                            <div class="medium-12">
                                                <h5 class="text-center BYekan">علی جهان پاک</h5>
                                            </div>
                                            <div class="medium-12">
                                                <p class="text-center">کارشناس بودجه</p>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li><a href="#"><i class="tbl-menu fi-torso-business"></i> <span>کارشناس اداری مالی</span></a></li>
                                <li><a href="#"><i class="tbl-menu fi-widget"></i> <span>تنظیمات</span></a></li>
                                <li><a v-on:click="logout"><i class="fi-power"></i> <span>خروج</span></a></li>
                            </ul>
                        </li>
                        <li>
                            <a style="margin-top: -1px;" href="#"><img style="color: #337AB7;font-size: 14px;" src="{{ asset('pic\bell-icon666.svg') }}" width="18px" height="18px;"></a>
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
                                    <a style="padding-bottom: -5px;" href="#">
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
                                    <a style="padding-bottom: -5px;" href="#">
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

                    </ul>
                </div>
                <div class="top-bar-right">
                    <button style="margin-bottom: 0;font-size: 0.9em;" class="my-button my-drop-down-btn-clear dropdown small sm-btn-align"  type="button" data-toggle="example-dropdown-bottom-left">سال مالی<span class="comlpleted-badage">1396</span></button>
                    <div style="width: 120px;" class="dropdown-pane dropdown-pane-sm " data-close-on-click="true"  data-hover="true" data-hover-pane="true"  data-position="bottom" data-alignment="right" id="example-dropdown-bottom-left" data-dropdown data-auto-focus="true">
                        <ul class="my-menu small-font ltr-dir">
                            <li><a  href="#">1395</a></li>
                            <li><a  href="#">1394</a></li>
                            <li><a  href="#">1393</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <!--Top Menu End-->

        <!--Modal Login Start-->
        <modal-login v-if="showModalLogin" @close="showModalLogin = false">
        <div slot="body">
            <div class="grid-x">
                <div style="background-color:#716aca;color: #FFFFFF;" class="medium-4">
                    <div class="grid-x">
                        <div class="medium-12">
                            <img  class="text-center large-offset-4" src="{{ asset('pic\logom1.png') }}" width="74px" height="74px">
                        </div>
                    </div>
                    <div class="grid-x">
                        <div class="medium-12">
                            <h6 class="BYekan  text-center">سامانه یکپارچه اداری-مالی و بودجه</h6>
                        </div>
                    </div>
                    <div class="grid-x modal-bottom">
                        <div class="medium-12 ">
                            <div class="small button-group float-left">
                                <a class="clear button primary-login">راهنمای سامانه</a>
                                <a class="clear button primary-login">درباره ما</a>
                                <a class="clear button primary-login">ارتباط با ما</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div style="margin: auto;padding: 20px 50px 20px 50px"  class="medium-8">
                    <form v-on:submit.prevent="login">
                        <div class="grid-x" v-show="errorMessage">
                            <div class="medium-12 columns padding-lr">
                                <div class="alert callout">
                                    <p class="BYekan login-alert"><i class="fi-alert"></i>@{{ errorMessage }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="grid-x">
                            <div class="medium-12 columns padding-lr">
                                <label>نام کاربری
                                    <input class="form-element-margin-btm" type="text" name="user" v-model="authInfo.email" v-validate="'required'" :class="{'input': true, 'error-border': errors.has('user')}">
                                </label>
                                <span v-show="errors.has('user')" class="error-font">لطفا نام کاربری را وارد کنید!</span>
                            </div>
                            <div class="medium-12 columns padding-lr">
                                <label>رمز عبور
                                    <input class="form-element-margin-btm" type="password" name="pass" v-model="authInfo.password"  v-validate="'required'" :class="{'input': true, 'error-border': errors.has('pass')}">
                                </label>
                                <span v-show="errors.has('pass')" class="error-font">لطفا رمز عبور را وارد کنید!</span>
                            </div>
                            <div class="medium-12 padding-lr top-margin-element">
                                <button name="submit" class="button my-button-master expanded">ورود</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        </modal-login>
        <!--Modal Login End-->
        <!--Body system-->
        <div class="grid-x">
            <div id="leftmenuinner" style="background-color: #212529;z-index: 995;" class="medium-2 cell small-font">
                <div  id="leftmenuinnerinner ">
                    <nav class="accordion"  data-margin-top="4.2">
                        <ul style="background-color: #212529;" class="vertical menu sub-menu accordion-menu" data-accordion-menu data-multi-open="false" >
                            <li>
                                <a class="right-menu-btm-border" href="#">توزیع اعتبار</a>
                                <ul class="menu vertical nested">
                                    <li><a href="#">هزینه ای</a>
                                        <ul class="menu vertical nested">
                                            <li><a href="#">استانی</a></li>
                                            <li><a href="#">ملی</a></li>
                                        </ul>
                                    </li>
                                    <li><a href="#">تملک دارایی سرمایه ای</a>
                                        <ul class="menu vertical nested">
                                            <li><a href="#">استانی</a>
                                                <ul class="menu vertical nested">
                                                    <li><a href="{{ url('/budget/credit_distribution/capital_assets/provincial/plans') }}">طرح های توزیع اعتبار</a></li>
                                                    <li><a href="{{ url('/budget/credit_distribution/capital_assets/provincial/proposal') }}">پیشنهاد دستگاه</a></li>
                                                </ul>
                                            </li>
                                            <li><a href="#">ملی</a></li>
                                        </ul>
                                    </li>
                                </ul>
                            </li>

                            <li>
                                <a class="right-mp right-menu-btm-border" href="#">  موافقتنامه</a>
                                <ul class="menu vertical nested">
                                    <li><a href="#">هزینه ای</a>
                                    <li><a href="#">تملک دارایی سرمایه ای</a>
                                        <ul class="menu vertical nested">
                                            <li><a href="{{ url('/budget/plan/capital_assets/plans') }}">طرح ها</a></li>
                                            <li><a href="#">پروژه ها</a></li>
                                        </ul>
                                    </li>

                                </ul>
                            </li>
                            <li>
                                <a class="right-mp right-menu-btm-border" href="#">تخصیص اعتبار</a>
                                <ul class="menu vertical nested">
                                    <li><a href="#">هزینه ای</a>
                                        <ul class="menu vertical nested">
                                            <li><a href="#">بند و</a></li>
                                            <li><a href="#">سایر</a></li>
                                        </ul>
                                    </li>
                                    <li><a href="#">تملک دارایی سرمایه ای</a>
                                        <ul class="menu vertical nested">
                                            <li><a href="#">پروژه ها</a></li>
                                        </ul>
                                    </li>
                                </ul>
                            </li>
                            <li>
                                <a class="right-mp right-menu-btm-border" href="#">مدیریت</a>
                                <ul class="menu vertical nested">
                                    <li><router-link to="/budget/admin/fiscal_year">سال مالی</router-link></li>
                                    <li><router-link to="/budget/admin/deprived_area">مناطق محروم</router-link></li>
                                    <li>
                                        <a href="">توزیع اعتبار</a>
                                        <ul class="menu vertical nested">
                                            <li><router-link to="/budget/admin/credit_distribution_def/budget_season">فصل بودجه</router-link></li>
                                            <li><router-link to="">ردیف توزیع اعتبار</router-link></li>
                                            <li><router-link to="">عنوان طرح / برنامه</router-link></li>
                                        </ul>
                                    </li>
                                    <li><router-link to="/budget/admin/tiny_seasons">ریز فصول</router-link></li>
                                    <li><a href="">ردیف توزیع اعتبار</a></li>
                                </ul>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
            <router-view></router-view>
            <!-- set progressbar -->
            <vue-progress-bar></vue-progress-bar>
            <div class="medium-12 my-footer">
                <div class="grid-x">
                    <div class="medium-12">
                        <div class="small button-group float-left footer-menu">
                            <a class="clear button menu-color">راهنمای سامانه</a>
                            <a class="clear button menu-color">درباره ما</a>
                            <a class="clear button menu-color">ارتباط با ما</a>
                            <a class="clear button menu-color">دیدگاه</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
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
            <div class="modal-mask">
                <div class="modal-wrapper">
                    <div style="padding: 0;" class="my-small">
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
    <script src="{{ asset('js/persian-date.min.js') }}"></script>
    <script src="{{ asset('js/persian-datepicker.min.js') }}"></script>
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/key.js') }}"></script>
</body>
</html>