@extends('budget::layouts.master')
@section('content')

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

<!--Body system-->
    <div style="padding: 30px;" class="medium-10 border-right-line">
        <div style="padding-right: 15px;padding-left: 15px;" class="grid-x">
            <div class="medium-12 border-btm-line">
                <h5 class="BYekan black-color">داشبورد مدیریت بودجه</h5>
            </div>
        </div>

        <div class="grid-x my-grid-margin">
            <div class="medium-3">
                <div class="notification-panel panel-red">
                    <div class="panel-heading">
                        <div class="grid-x">
                            <div class="medium-8">
                                <h4>13</h4>
                                <p>تعداد موافقت نامه مبادله شده</p>
                            </div>
                            <div class="medium-4">
                                <i class="fi-graph-trend size-72"></i>
                            </div>
                        </div>
                    </div>
                    <div class="btn-red">
                        <a href="#">
                            <div class="panel-footer panel-footer-red small-font">
                                <i class="fi-arrow-left size-18 float-left"></i>مشاهده جزئیات
                            </div>
                        </a>
                    </div>
                </div>
            </div>

            <div class="medium-3">
                <div class="notification-panel panel-yellow">
                    <div class="panel-heading">
                        <div class="grid-x">
                            <div class="medium-8">
                                <h4>13</h4>
                                <p>تعداد پیام ها</p>
                            </div>
                            <div class="medium-4">
                                <i class="fi-megaphone size-72"></i>
                            </div>
                        </div>
                    </div>
                    <div class="btn-yellow">
                        <a href="#">
                            <div class="panel-footer panel-footer-yellow small-font">
                                <i class="fi-arrow-left size-18 float-left"></i>مشاهده جزئیات
                            </div>
                        </a>
                    </div>
                </div>
            </div>

            <div class="medium-3">
                <div class="notification-panel panel-green">
                    <div class="panel-heading">
                        <div class="grid-x">
                            <div class="medium-8">
                                <h4>13</h4>
                                <p>تعداد پیام ها</p>
                            </div>
                            <div class="medium-4">
                                <i class="fi-database size-72"></i>
                            </div>
                        </div>
                    </div>
                    <div class="btn-green">
                        <a href="#">
                            <div class="panel-footer panel-footer-green small-font">
                                <i class="fi-arrow-left size-18 float-left"></i>مشاهده جزئیات
                            </div>
                        </a>
                    </div>
                </div>
            </div>

            <div class="medium-3">
                <div class="notification-panel panel-primary">
                    <div class="panel-heading">
                        <div class="grid-x">
                            <div class="medium-8">
                                <h4>13</h4>
                                <p>تعداد پیام ها</p>
                            </div>
                            <div class="medium-4">
                                <i class="fi-comments size-72"></i>
                            </div>
                        </div>
                    </div>
                    <div class="btn-primary">
                        <a href="#">
                            <div class="panel-footer panel-footer-primary small-font">
                                <i class="fi-arrow-left size-18 float-left"></i>مشاهده جزئیات
                            </div>
                        </a>
                    </div>
                </div>
            </div>

        </div>

        <div class="grid-x my-grid-margin">
            <div class="medium-6 dashboard-padding">
                <div class="medium-12 panel-heading"><i class="fi-graph-bar"></i> <span class="small-font">تخصیص اعتبارات به تفکیک منابع</span>
                    <button type="button" class="my-secondary button tiny float-left" data-open="exampleModal1" onclick="myChartF1('myChartM')">اطلاعات بیشتر</button>
                </div>
                <div class="medium-12 my-callout">
                    <canvas id="myChart"></canvas>
                </div>
            </div>
            <div class="medium-6 dashboard-padding">
                <div class="medium-12 panel-heading"><i class="fi-graph-bar"></i> <span class="small-font">تخصیص اعتبارات به تفکیک فصول</span>
                    <button type="button" class="my-secondary button tiny float-left">اطلاعات بیشتر</button>
                </div>
                <div class="medium-12 my-callout">
                    <canvas id="myChart1"></canvas>
                </div>
            </div>
        </div>

        <div class="grid-x my-grid-margin">
            <div class="medium-6 dashboard-padding">
                <div class="medium-12 panel-heading"><i class="fi-graph-pie"></i> <span class="small-font">بودجه مصوب جاری و عمرانی </span>
                    <button type="button" class="my-secondary button tiny float-left" data-open="exampleModal1">اطلاعات بیشتر</button>
                </div>
                <div class="medium-12 my-callout" style="padding: 20px;">
                    <canvas id="myChart2"></canvas>
                </div>
            </div>
            <div class="medium-6 dashboard-padding" style="padding: 20px;">
                <div class="medium-12 panel-heading"><i class="fi-graph-bar"></i> <span class="small-font">نمودار بودجه مصوب جاری و عمرانی</span>
                    <button type="button" class="my-secondary button tiny float-left">اطلاعات بیشتر</button>
                </div>
                <div class="medium-12 my-callout">
                    <canvas id="myChart3"></canvas>
                </div>
            </div>
        </div>

    </div>
</div>

<script>

    function myChartF1(cid) {
        var ctx = document.getElementById(cid).getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'line',
            title: {
                display: true,
                text: 'چارت توزیع اعتبار بر اساس منابع'
            },
            data: {
                labels: ['همدان', 'ملایر', 'نهاوند', 'تویسرکان', 'اسدآباد', 'کبودرآهنگ', 'فامنین', 'بهار', 'رزن'],
                datasets: [{
                    label: 'توزیع اعتبار',
                    data: [23, 19, 12, 17, 18, 16, 10, 13, 14],
                    borderWidth: 1,
                    borderColor: "rgba(74,87,142,0.4)",
                    backgroundColor: "rgba(51,122,183,0.4)"
                }, {
                    label: 'تخصیص اعتبار',
                    data: [16, 14, 9, 13, 11, 12, 7, 8, 11],
                    borderWidth: 1,
                    borderColor: "rgba(66,139,61,0.4)",
                    backgroundColor: "rgba(92,184,92,0.4)"

                }]
            }
        });

    }



    var ctx = document.getElementById('myChart1').getContext('2d');
    var myChart1 = new Chart(ctx, {
        type: 'bar',
        title: {
            display: true,
            text: 'چارت توزیع اعتبار بر اساس منابع'
        },
        data: {
            labels: ['همدان', 'ملایر', 'نهاوند', 'تویسرکان', 'اسدآباد', 'کبودرآهنگ','فامنین','بهار','رزن'],
            datasets: [{
                label: 'توزیع اعتبار',
                data: [23, 19, 12, 17, 18, 16, 10,13,14],
                borderWidth: 1,
                borderColor:"rgba(74,87,142,0.4)",
                backgroundColor: "rgba(51,122,183,0.4)"
            }, {
                label: 'تخصیص اعتبار',
                data: [16, 14, 9, 13, 11, 12, 7,8,11],
                borderWidth: 1,
                borderColor:"rgba(66,139,61,0.4)",
                backgroundColor: "rgba(92,184,92,0.4)"

            }]
        }
    });
    var ctx = document.getElementById('myChart2').getContext('2d');
    var myChart2 = new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: ['بودجه عمرانی مصوب','بودجه جاری مصوب'],
            datasets: [{
                label: 'توزیع اعتبار',
                data: [23, 14,],
                borderWidth: 1,
                borderColor:"rgba(227,138,26,0.4)",
                backgroundColor: [
                    "rgba(240,173,78,0.4)",
                    "rgba(255,157,178,0.4)"
                ]
            }]
        }
    });
    var ctx = document.getElementById('myChart3').getContext('2d');
    var myChart3 = new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['سال مالی 1394', 'سال مالی 1395', 'سال مالی 1396'],
            datasets: [{
                label: 'تخصیص اعتبار عمرانی',
                data: [18, 24, 31],
                borderWidth: 1,
                borderColor:"rgba(227,138,26,0.4)",
                backgroundColor: "rgba(240,173,78,0.4)",
                options:{
                    fill:false,

                },
            }, {
                label: 'تخصیص اعتبار جاری',
                data: [9, 12, 17],
                borderWidth: 1,
                borderColor:"rgba(181,55,116,0.4)",
                backgroundColor: "rgba(255,157,178,0.4)"

            }]
        }
    });

</script>

<script src="js/vendor/jquery.js"></script>
<script src="js/vendor/what-input.js"></script>
<script src="js/vendor/foundation.js"></script>
<script src="js/app.js"></script>
<script>
    $(document).ready(function(){
        myChartF1('myChart');

    });
</script>
@stop
