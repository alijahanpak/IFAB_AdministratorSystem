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
                            <p>موافقت نامه مبادله شده</p>
                        </div>
                        <div class="medium-4 text-center">
                            <i class="fa fa-line-chart size-48" aria-hidden="true"></i>
                        </div>
                    </div>
                </div>
                <div class="btn-red">
                    <a href="#">
                        <div class="panel-footer panel-footer-red small-font">
                            <i class="fa fa-arrow-left size-18 float-left" aria-hidden="true"></i>مشاهده جزئیات
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
                        <div class="medium-4 text-center">
                            <i class="fa fa-bullhorn size-60" aria-hidden="true"></i>
                        </div>
                    </div>
                </div>
                <div class="btn-yellow">
                    <a href="#">
                        <div class="panel-footer panel-footer-yellow small-font">
                            <i class="fa fa-arrow-left size-18 float-left" aria-hidden="true"></i>مشاهده جزئیات
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
                        <div class="medium-4 text-center">
                            <i class="fa fa-server size-60" aria-hidden="true"></i>
                        </div>
                    </div>
                </div>
                <div class="btn-green">
                    <a href="#">
                        <div class="panel-footer panel-footer-green small-font">
                            <i class="fa fa-arrow-left size-18 float-left" aria-hidden="true"></i>مشاهده جزئیات
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
                        <div class="medium-4 text-center">
                            <i class="fa fa-comments size-60" aria-hidden="true"></i>
                        </div>
                    </div>
                </div>
                <div class="btn-primary">
                    <a href="#">
                        <div class="panel-footer panel-footer-primary small-font">
                            <i class="fa fa-arrow-left size-18 float-left" aria-hidden="true"></i>مشاهده جزئیات
                        </div>
                    </a>
                </div>
            </div>
        </div>

    </div>

    <div class="grid-x my-grid-margin">
        <div class="medium-6 dashboard-padding ">
            <div style="padding: 10px;" class="medium-12 my-callout-box my-callout-bg-color"><i class="fa fa-area-chart" aria-hidden="true"></i> <span class="small-font">تخصیص اعتبارات به تفکیک منابع</span>
                <a type="button" class="my-secondary button tiny float-left" @click="showChartDialog = true">اطلاعات بیشتر</a>
            </div>
            <div class="medium-12 my-callout-box my-callout-bg-color">
            <!-- <canvas id="myChart"></canvas>-->
                <line_chart :data="chart1"   :width="400" :height="200"></line_chart>
            </div>
        </div>
        <div class="medium-6 dashboard-padding ">
            <div style="padding: 10px;" class="medium-12 my-callout-box my-callout-bg-color"><i class="fa fa-area-chart" aria-hidden="true"></i> <span class="small-font">تخصیص اعتبارات به تفکیک منابع</span>
                <a type="button" class="my-secondary button tiny float-left" @click="showChartDialog = true">اطلاعات بیشتر</a>
            </div>
            <div class="medium-12 my-callout-box my-callout-bg-color">
                <line_chart :data="chart1"   :width="400" :height="200"></line_chart>
            </div>
        </div>
    </div>

    <!--<div class="grid-x my-grid-margin">
        <div class="medium-6 dashboard-padding ">
            <div style="padding: 10px;" class="medium-12 my-callout-box my-callout-bg-color"><i class="fa fa-area-chart" aria-hidden="true"></i> <span class="small-font">تخصیص اعتبارات به تفکیک منابع</span>
                <button type="button" class="my-secondary button tiny float-left" data-open="exampleModal1" onclick="myChartF1('myChartM')">اطلاعات بیشتر</button>
            </div>
            <div class="medium-12 my-callout-box my-callout-bg-color">
                <line_chart :data="chart1"   :width="400" :height="200"></line_chart>
            </div>
        </div>
        <div class="medium-6 dashboard-padding ">
            <div style="padding: 10px;" class="medium-12 my-callout-box my-callout-bg-color"><i class="fa fa-area-chart" aria-hidden="true"></i> <span class="small-font">تخصیص اعتبارات به تفکیک منابع</span>
                <button type="button" class="my-secondary button tiny float-left" data-open="exampleModal1" onclick="myChartF1('myChartM')">اطلاعات بیشتر</button>
            </div>
            <div class="medium-12 my-callout-box my-callout-bg-color">
                <line_chart :data="chart1"   :width="400" :height="200"></line_chart>
            </div>
        </div>
    </div>-->
    <!--chart1 Modal Start-->
    <!--Insert Modal Start-->
    <modal-large v-if="showChartDialog" @close="showChartDialog = false">
        <div  slot="body">
            <h6 class="text-center BYekan">نمودار تخصیص اعتبارات بر اساس منابع</h6>
            <line_chart :data="chart1" :width="400" :height="200"></line_chart>
            <button type="button" class="my-secondary small button float-left"><i class="fi-archive"></i> دریافت </button>
        </div>
    </modal-large>
    <!--chart1 Modal End-->
</div>
</template>
<script>
    import line_chart from '../../charts/lineChart'
    export default {
        name: 'dashboard',
        components:{
            line_chart
        },
        data(){
            return{
                chart1:{
                    labels: ['همدان', 'ملایر', 'تویسرکان', 'نهاوند', 'رزن', 'فامنین', 'اسدآباد', 'کبودراهنگ', 'بهار'],
                    datasets: [
                        {
                            label: 'مصوب',
                            backgroundColor: 'rgba(45,187,58,0.4)',
                            data: [13, 35, 16, 23, 22, 61, 12, 20, 29]
                        },
                        {
                            label: 'تخصیص',
                            backgroundColor: 'rgba(10,26,174,0.4)',
                            data: [1, 15, 26, 3, 47, 6, 9, 20, 29]
                        },
                        {
                            label: 'هزینه کرد',
                            backgroundColor: 'rgba(20,187,39,0.4)',
                            data: [10, 25, 36, 30, 17, 16, 19, 2, 21]
                        }
                    ]
                },
                showChartDialog: false,
            }
        },

        mounted() {
            console.log('dashboard Component mounted.')
        },

        updated: function () {
            this.$parent.userIsActive();
        }
    }
</script>
