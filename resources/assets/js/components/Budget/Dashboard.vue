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
            <div style="padding: 10px;" class="medium-12 my-callout-box my-callout-bg-color"><i class="fa fa-area-chart" aria-hidden="true"></i> <span class="small-font">تملک داریی های سرمایه ای</span>
                <a type="button" class="my-secondary button tiny float-left" @click="showCapitalAssetsChartDialog = true">اطلاعات بیشتر</a>
            </div>
            <div class="medium-12 my-callout-box my-callout-bg-color">
            <!-- <canvas id="myChart"></canvas>-->
                <line-chart :chart-data="capitalAssetsChart"   :width="400" :height="200"></line-chart>
            </div>
        </div>
        <div class="medium-6 dashboard-padding ">
            <div style="padding: 10px;" class="medium-12 my-callout-box my-callout-bg-color"><i class="fa fa-area-chart" aria-hidden="true"></i> <span class="small-font">هزینه ای</span>
                <a type="button" class="my-secondary button tiny float-left" @click="showCostChartDialog = true">اطلاعات بیشتر</a>
            </div>
            <div class="medium-12 my-callout-box my-callout-bg-color">
                <line-chart :chart-data="costChart"   :width="400" :height="200"></line-chart>
            </div>
        </div>
    </div>

    <!--<div class="grid-x my-grid-margin">
        <div class="medium-6 dashboard-padding ">
            <div style="padding: 10px;" class="medium-12 my-callout-box my-callout-bg-color"><i class="fa fa-area-chart" aria-hidden="true"></i> <span class="small-font">تخصیص اعتبارات به تفکیک منابع</span>
                <button type="button" class="my-secondary button tiny float-left" data-open="exampleModal1" onclick="myChartF1('myChartM')">اطلاعات بیشتر</button>
            </div>
            <div class="medium-12 my-callout-box my-callout-bg-color">
                <line-chart :chart-data="capitalAssetsApprovedChart"   :width="400" :height="200"></line-chart>
            </div>
        </div>
        <div class="medium-6 dashboard-padding ">
            <div style="padding: 10px;" class="medium-12 my-callout-box my-callout-bg-color"><i class="fa fa-area-chart" aria-hidden="true"></i> <span class="small-font">تخصیص اعتبارات به تفکیک منابع</span>
                <button type="button" class="my-secondary button tiny float-left" data-open="exampleModal1" onclick="myChartF1('myChartM')">اطلاعات بیشتر</button>
            </div>
            <div class="medium-12 my-callout-box my-callout-bg-color">
                <line-chart :chart-data="capitalAssetsApprovedChart"   :width="400" :height="200"></line-chart>
            </div>
        </div>
    </div>-->
    <!--chart1 Modal Start-->
    <!--Insert Modal Start-->
    <modal-large v-if="showCapitalAssetsChartDialog" @close="showCapitalAssetsChartDialog = false">
        <div  slot="body">
            <h6 class="text-center BYekan">تملک داریی های سرمایه</h6>
            <line-chart :chart-data="capitalAssetsChart" :width="400" :height="200"></line-chart>
        </div>
    </modal-large>
    <!--chart1 Modal End-->
    <modal-large v-if="showCostChartDialog" @close="showCapitalAssetsChartDialog = false">
        <div  slot="body">
            <h6 class="text-center BYekan">هزینه ای</h6>
            <line-chart :chart-data="costChart" :width="400" :height="200"></line-chart>
        </div>
    </modal-large>
    <!--chart1 Modal End-->
</div>
</template>
<script>
    import LineChart from '../../charts/lineChart'

    export default {
        components: {
            LineChart
        },
        data () {
            return {
                capitalAssetsChart: null,
                costChart: null,
                showCapitalAssetsChartDialog: false,
                showCostChartDialog: false
            }
        },
        mounted () {

        },

        created: function(){
            this.fetchCapitalAssetsData();
        },

        methods: {
            setData (data) {
                this.capitalAssetsChart = {
                    labels: this.getCountyLabels(data),
                    datasets: [
                        {
                            label: 'مصوب',
                            backgroundColor: 'rgba(45 , 187 , 58 , 0.4)',
                            data: this.getCountyApprovedAmount(data)
                        }, {
                            label: 'تخصیص',
                            backgroundColor: 'rgba(10 , 26 , 174 , 0.4)',
                            data: this.getCountyAllocationAmount(data)
                        }
                    ]
                }
            },

            fetchCapitalAssetsData: function () {
                axios.get('/budget/chart/capitalAssets')
                    .then((response) => {
                        this.setData(response.data);
                        console.log(response);
                    },(error) => {
                        console.log(error);
                    });
            },

            getCountyLabels (data) {
                var temp = [];
                data.forEach(county => {
                    temp.push(county.coName);
                });
                return temp;
            },

            getCountyApprovedAmount (data) {
                var temp = [];
                data.forEach(county => {
                    temp.push(this.$parent.calcDispAmount(county.coSumOfApprovedAmount , false));
                });
                return temp;
            },

            getCountyAllocationAmount (data) {
                var temp = [];
                data.forEach(county => {
                    temp.push(this.$parent.calcDispAmount(county.coSumOfAllocationAmount , false));
                });
                return temp;
            }

        }
    }
</script>
