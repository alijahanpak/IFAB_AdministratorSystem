<template>
<!--Body system-->
<div style="padding: 30px;" class="medium-10 border-right-line main-margin">
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
        <div class="medium-6 dashboard-padding ">
            <div style="padding: 10px;" class="medium-12 my-callout-box my-callout-bg-color"><i class="fi-graph-bar"></i> <span class="small-font">تخصیص اعتبارات به تفکیک منابع</span>
                <button type="button" class="my-secondary button tiny float-left" data-open="exampleModal1" onclick="myChartF1('myChartM')">اطلاعات بیشتر</button>
            </div>
            <div class="medium-12 my-callout-box my-callout-bg-color">
                <canvas id="myChart"></canvas>
            </div>
        </div>
        <div class="medium-6 dashboard-padding ">
            <div style="padding: 10px;" class="medium-12 my-callout-box my-callout-bg-color"><i class="fi-graph-bar"></i> <span class="small-font">تخصیص اعتبارات به تفکیک منابع</span>
                <button type="button" class="my-secondary button tiny float-left" data-open="exampleModal1" onclick="myChartF1('myChartM')">اطلاعات بیشتر</button>
            </div>
            <div class="medium-12 my-callout-box my-callout-bg-color">
                <canvas id="myChart1"></canvas>
            </div>
        </div>
    </div>

    <div class="grid-x my-grid-margin">
        <div class="medium-6 dashboard-padding ">
            <div style="padding: 10px;" class="medium-12 my-callout-box my-callout-bg-color"><i class="fi-graph-bar"></i> <span class="small-font">تخصیص اعتبارات به تفکیک منابع</span>
                <button type="button" class="my-secondary button tiny float-left" data-open="exampleModal1" onclick="myChartF1('myChartM')">اطلاعات بیشتر</button>
            </div>
            <div class="medium-12 my-callout-box my-callout-bg-color">
                <canvas id="myChart2"></canvas>
            </div>
        </div>
        <div class="medium-6 dashboard-padding ">
            <div style="padding: 10px;" class="medium-12 my-callout-box my-callout-bg-color"><i class="fi-graph-bar"></i> <span class="small-font">تخصیص اعتبارات به تفکیک منابع</span>
                <button type="button" class="my-secondary button tiny float-left" data-open="exampleModal1" onclick="myChartF1('myChartM')">اطلاعات بیشتر</button>
            </div>
            <div class="medium-12 my-callout-box my-callout-bg-color">
                <canvas id="myChart3"></canvas>
            </div>
        </div>
    </div>
</div>
</template>
<script>
    export default {
        name: 'dashboard',
        mounted() {
            console.log('dashboard Component mounted.')
        }
    }
</script>
