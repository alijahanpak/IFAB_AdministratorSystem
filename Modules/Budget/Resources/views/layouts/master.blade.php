<!doctype html>
<html class="no-js" lang="en" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{$pageTitle}}</title>
    <link rel="stylesheet" href="{{ asset('css/foundation.css') }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/font.css') }}">
    <link rel="stylesheet" href="{{ asset('foundation-icons/foundation-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('css/line-spin-clockwise-fade-rotating.css') }}">
    <link rel="stylesheet" href="{{ asset('css/key.css') }}">
    <script src="{{ asset('js/Chart.js') }}"></script>
</head>
<body class="BYekan">

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
    <div style="z-index: 999;" data-sticky-container>
        <div class="top-bar top-menu-color" data-sticky data-margin-top="0">
            <div class="top-bar-left">
                <ul data-dropdown-menu class="dropdown menu user-menu" >
                    <li>
                        <a href="#"><span style="font-size: 14px;"> علی جهان پاک </span></a>
                        <ul style="background-color: #ffffff;" class="menu vertical small-font white-color">
                            <li><a href="#"><i class="fi-torso-business"></i> <span>کارشناس اداری مالی</span></a></li>
                            <li><a href="#"><i class="fi-widget"></i> <span>تنظیمات</span></a></li>
                            <li><a href="{{ url('/logout') }}"><i class="fi-power"></i> <span>خروج</span></a></li>
                        </ul>
                    </li>
                    <li>
                        <a style="margin-top: -1px;" href="#"><img style="color: #337AB7;font-size: 14px;" src="{{ asset('pic\bell-icon.svg') }}" width="18px" height="18px;"></a>
                        <ul style="background-color: #FFFFFF;" class="menu vertical">
                            <li class="border-btm-line">
                                <a style="padding-bottom: -5px;" href="#">
                                    <div>
                                        <strong style="color: #000000;">علیرضا طاهری</strong>
                                        <span style="color: #777;" class="message-time large-offset-7"><i class="fi-calendar size-18"></i>41 دقیقه قبل</span>
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
                                        <span style="color: #777;" class="message-time large-offset-7"><i class="fi-calendar size-18"></i>دو روز پیش</span>
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
                <button class="button dropdown small sm-btn-align"  type="button" data-toggle="example-dropdown-bottom-left">1396</button>
                <div class="dropdown-pane dropdown-pane-sm " data-close-on-click="true"  data-hover="true" data-hover-pane="true"  data-position="bottom" data-alignment="right" id="example-dropdown-bottom-left" data-dropdown data-auto-focus="true">
                    <ul class="my-menu small-font">
                        <li><a  href="#">1395</a></li>
                        <li><a  href="#">1394</a></li>
                        <li><a  href="#">1393</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!--Body system-->
    <div class="grid-x">
        <div style="background-color: #F8F8F8;" class="medium-2 cell small-font">
            <div class="docs-nav">
                <nav class="accordion docs-nav-category" data-sticky  data-margin-top="4.2">
                    <ul class="vertical menu sub-menu accordion-menu" data-accordion-menu >
                        <li>
                            <a class="active-menu right-menu-btm-border" href="#">توزیع اعتبار</a>
                            <ul class="menu vertical nested">
                                <li><a href="#">هزینه ای</a>
                                    <ul class="menu vertical nested">
                                        <li><a href="#">استانی</a></li>
                                        <li><a href="#">ملی</a></li>
                                    </ul>
                                </li>
                                <li><a href="#">تملک دارایی سرمایه ای</a>
                                    <ul class="menu vertical nested">
                                        <li><a href="#">استانی</a></li>
                                        <li><a href="#">ملی</a></li>
                                        <li><a class="right-menu-btm-border" href="#">پیشنهاد دستگاه ها</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </li>

                        <li>
                            <a class="right-mp right-menu-btm-border" href="#">  موافقتنامه</a>
                            <ul class="menu vertical nested">
                                <li><a href="#">هزینه ای</a>
                                <li><a href="#">تملک دارایی سرمایه ای</a></li>
                                <li><a href="#">طرح ها</a></li>
                                <li><a href="#">پروژه ها</a></li>
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
                                <li><a href="{{ url('/budget/admin/fiscal_year') }}">سال مالی</a>
                                <li><a href="{{ url('/budget/admin/deprived_area') }}">مناطق محروم</a></li>
                                <li><a href="{{ url('/budget/admin/credit_distribution_def') }}">توزیع اعتبار</a></li>
                                <li><a href="{{ url('/budget/admin/sub_season') }}">ریز فصول</a></li>
                                <li><a href="{{ url('/budget/admin/credit_distribution_plan') }}">ثبت طرح های توزیع اعتبار</a></li>
                            </ul>
                        </li>


                    </ul>
                </nav>
            </div>
        </div>
        @yield('content')

        {{-- messageDialogPm reveal--}}
        @if (session('messageDialogPm'))
            <div style="z-index: 9999;" class="tiny reveal" id="messageDialogPm" data-reveal>
                <div class="modal-margin small-font">
                    <p>کاربر گرامی</p>
                    <p class="large-offset-1 modal-text">{{ session('messageDialogPm') }}</p>
                    <div class="grid-x">
                        <div class="medium-12 text-center">
                            <a data-close aria-label="Close modal" class="button primary btn-large-w">بله</a>
                        </div>
                    </div>
                </div>
                <button class="close-button" data-close aria-label="Close modal" type="button">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
        {{-- end messageDialogPm reveal--}}
        <!--Modal Preloader Start-->
            <div class="full reveal reveal-overlay" id="preloaderModal" data-reveal>
                <div class="la-line-spin-clockwise-fade-rotating la-2x loader-pos">
                    <div></div>
                    <div></div>
                    <div></div>
                    <div></div>
                    <div></div>
                    <div></div>
                    <div></div>
                    <div></div>
                </div>
            </div>
            <!--Modal Preloader Start-->
    </div>

    <script src="{{ asset('js/vendor/jquery.js') }}"></script>
    <script src="{{ asset('js/vendor/what-input.js') }}"></script>
    <script src="{{ asset('js/vendor/foundation.js') }}"></script>
    <script src="{{ asset('js/app.js') }}"></script>

    <script src="{{ asset('js/modules/budget/admin/credit_distribution_plan.js')  }}"></script>

    @if(isset($requireJsFile))
        @if($requireJsFile == 'deprived_area')
            <script src="{{ asset('js/modules/budget/admin/deprived_area.js') }}"></script>
        @elseif($requireJsFile =='credit_distributed_def')
            <script src="{{ asset('js/modules/budget/admin/credit_distribution_def.js') }}"></script>
        @elseif($requireJsFile =='fiscal_year')
            <script src="{{ asset('js/modules/budget/admin/fiscal_year.js') }}"></script>
        @endif
    @endif
    @if (session('messageDialogPm'))
        <script type="text/javascript">
                $(document).ready(function(){
                    $('#messageDialogPm').foundation('toggle');
                    //setTimeout(function(){ $('#messageDialogPm').foundation('close'); } , 6000);
                });
        </script>
    @endif
</body>
</html>