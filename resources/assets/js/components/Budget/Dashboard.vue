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
                <div class="panel-heading" style="min-height: 140px;">
                    <div class="grid-x" style="min-height: 68px;">
                        <div class="medium-8">
                            <p class="BTitrBold" style="margin-top: 10px">{{ prov_approvedPlanExchangedCount }}</p>
                        </div>
                        <div class="medium-4 text-center">
                            <i class="fa fa-line-chart size-48" aria-hidden="true"></i>
                        </div>
                    </div>
                    <div class="grid-x">
                        <div class="medium-12">
                            <p style="margin-bottom: 0">موافقت نامه مبادله شده</p>
                            <span class="size-10">تملک داریی های سرمایه ای استانی</span>
                        </div>
                    </div>
                </div>
                <div class="btn-red">
                    <router-link to="/budget/approved/capital_assets/approved/plan">
                        <div class="panel-footer panel-footer-red small-font">
                            <i class="fa fa-arrow-left size-18 float-left" aria-hidden="true"></i>مشاهده جزئیات
                        </div>
                    </router-link>
                </div>
            </div>
        </div>
        <div class="medium-3">
            <div class="notification-panel panel-yellow">
                <div class="panel-heading" style="min-height: 140px;">
                    <div class="grid-x" style="min-height: 68px;">
                        <div class="medium-8">
                            <p class="BTitrBold" style="margin-top: 10px">{{ $parent.calcDispAmount(sumOfCapAllocation , false) }}</p>
                        </div>
                        <div class="medium-4 text-center">
                            <i class="fa fa-pie-chart size-48" aria-hidden="true"></i>
                        </div>
                    </div>
                    <div class="grid-x">
                        <div class="medium-12">
                            <p style="margin-bottom: 0">تخصیص اعتبار <span class="size-10">({{ $parent.getAmountBaseLabel() }})</span></p>
                            <span class="size-10">تملک داریی های سرمایه ای</span>
                        </div>
                    </div>
                </div>
                <div class="btn-yellow">
                    <router-link to="/budget/allocation/capital_assets">
                        <div class="panel-footer panel-footer-yellow small-font">
                            <i class="fa fa-arrow-left size-18 float-left" aria-hidden="true"></i>مشاهده جزئیات
                        </div>
                    </router-link>
                </div>
            </div>
        </div>

        <div class="medium-3">
            <div class="notification-panel panel-green">
                <div class="panel-heading" style="min-height: 140px;">
                    <div class="grid-x" style="min-height: 68px;">
                        <div class="medium-8">
                            <p class="BTitrBold" style="margin-top: 10px">{{ $parent.calcDispAmount(sumOfCaAllocation , false) }}</p>
                        </div>
                        <div class="medium-4 text-center">
                            <i class="fa fa-money size-48" aria-hidden="true"></i>
                        </div>
                    </div>
                    <div class="grid-x">
                        <div class="medium-12">
                            <p style="margin-bottom: 0">تخصیص اعتبار <span class="size-10">({{ $parent.getAmountBaseLabel() }})</span></p>
                            <span class="size-10">هزینه ای</span>
                        </div>
                    </div>
                </div>
                <div class="btn-green">
                    <router-link to="/budget/Allocation/cost">
                        <div class="panel-footer panel-footer-green small-font">
                            <i class="fa fa-arrow-left size-18 float-left" aria-hidden="true"></i>مشاهده جزئیات
                        </div>
                    </router-link>
                </div>
            </div>
        </div>

        <div class="medium-3">
            <div class="notification-panel panel-primary">
                <div class="panel-heading" style="min-height: 140px;">
                    <div class="grid-x" style="min-height: 68px;">
                        <div class="medium-8">
                            <p class="BTitrBold" style="margin-top: 10px">0</p>
                        </div>
                        <div class="medium-4 text-center">
                            <i class="fa fa-comments size-48" aria-hidden="true"></i>
                        </div>
                    </div>
                    <div class="grid-x">
                        <div class="medium-12">
                            <p>تعداد پیام ها</p>
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
            <div style="padding: 10px;" class="medium-12 my-callout-box my-callout-bg-color"><i class="fa fa-area-chart" aria-hidden="true"></i> <span class="small-font">تملک داریی های سرمایه ای استانی</span>
                <a type="button" class="my-secondary button tiny float-left" @click="showCapitalAssetsChartDialog = true">اطلاعات بیشتر</a>
            </div>
            <div class="medium-12 my-callout-box my-callout-bg-color text-center">
                <line-chart :chart-data="capitalAssetsChart"   :width="400" :height="200"></line-chart>
                <small>مبالغ: <span class="btn-red">{{ $parent.getAmountBaseLabel()}}</span></small>
            </div>
        </div>
        <div class="medium-6 dashboard-padding ">
            <div style="padding: 10px;" class="medium-12 my-callout-box my-callout-bg-color"><i class="fa fa-area-chart" aria-hidden="true"></i> <span class="small-font">هزینه ای استانی</span>
                <a type="button" class="my-secondary button tiny float-left" @click="showCostChartDialog = true">اطلاعات بیشتر</a>
            </div>
            <div class="medium-12 my-callout-box my-callout-bg-color text-center">
                <line-chart :chart-data="costChart"   :width="400" :height="200"></line-chart>
                <small>مبالغ: <span class="btn-red">{{ $parent.getAmountBaseLabel()}}</span></small>
            </div>
        </div>
    </div>

    <div class="grid-x my-grid-margin">
        <div class="medium-6 dashboard-padding ">
            <div style="padding: 10px;" class="medium-12 my-callout-box my-callout-bg-color"><i class="fa fa-area-chart" aria-hidden="true"></i> <span class="small-font">تملک داریی های سرمایه ای ملی</span>
                <a type="button" class="my-secondary button tiny float-left" @click="showNatCapitalAssetsChartDialog = true">اطلاعات بیشتر</a>
            </div>
            <div class="medium-12 my-callout-box my-callout-bg-color text-center">
                <line-chart :chart-data="natCapitalAssetsChart"   :width="400" :height="200"></line-chart>
                <div class="grid-x">
                    <div class="medium-12 text-center">
                        <small>مبالغ: <span class="btn-red">{{ $parent.getAmountBaseLabel()}}</span></small>
                    </div>
                </div>
            </div>
        </div>
        <div class="medium-6 dashboard-padding ">
            <div style="padding: 10px;" class="medium-12 my-callout-box my-callout-bg-color"><i class="fa fa-area-chart" aria-hidden="true"></i> <span class="small-font">هزینه ای ملی</span>
                <a type="button" class="my-secondary button tiny float-left" @click="showNatCostChartDialog = true">اطلاعات بیشتر</a>
            </div>
            <div class="medium-12 my-callout-box my-callout-bg-color text-center">
                <line-chart :chart-data="natCostChart"   :width="400" :height="200"></line-chart>
                <div class="grid-x">
                    <div class="medium-12 text-center">
                        <small>مبالغ: <span class="btn-red">{{ $parent.getAmountBaseLabel()}}</span></small>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--Insert Modal Start-->
    <modal-large v-if="showCapitalAssetsChartDialog" @close="showCapitalAssetsChartDialog = false">
        <div  slot="body">
            <h6 class="text-center BYekan">تملک داریی های سرمایه استانی</h6>
            <line-chart :chart-data="capitalAssetsChart" :width="400" :height="200"></line-chart>
            <div class="grid-x">
                <div class="medium-12 text-center">
                    <small>مبالغ: <span class="btn-red">{{ $parent.getAmountBaseLabel()}}</span></small>
                </div>
            </div>
        </div>
    </modal-large>
    <!--chart1 Modal End-->
    <modal-large v-if="showCostChartDialog" @close="showCostChartDialog = false">
        <div  slot="body">
            <h6 class="text-center BYekan">هزینه ای استانی</h6>
            <line-chart :chart-data="costChart" :width="400" :height="200"></line-chart>
            <div class="grid-x">
                <div class="medium-12 text-center">
                    <small>مبالغ: <span class="btn-red">{{ $parent.getAmountBaseLabel()}}</span></small>
                </div>
            </div>
        </div>
    </modal-large>
    <!--chart1 Modal End-->
    <!--Insert Modal Start-->
    <modal-large v-if="showNatCapitalAssetsChartDialog" @close="showNatCapitalAssetsChartDialog = false">
        <div  slot="body">
            <h6 class="text-center BYekan">تملک داریی های سرمایه استانی</h6>
            <line-chart :chart-data="natCapitalAssetsChart" :width="400" :height="200"></line-chart>
            <small>مبالغ: <span class="btn-red">{{ $parent.getAmountBaseLabel()}}</span></small>
        </div>
    </modal-large>
    <!--chart1 Modal End-->
    <modal-large v-if="showNatCostChartDialog" @close="showNatCostChartDialog = false">
        <div  slot="body">
            <h6 class="text-center BYekan">هزینه ای استانی</h6>
            <line-chart :chart-data="natCostChart" :width="400" :height="200"></line-chart>
            <small>مبالغ: <span class="btn-red">{{ $parent.getAmountBaseLabel()}}</span></small>
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
                natCapitalAssetsChart: null,
                natCostChart: null,
                showCapitalAssetsChartDialog: false,
                showCostChartDialog: false,
                showNatCapitalAssetsChartDialog: false,
                showNatCostChartDialog: false,
                prov_approvedPlanExchangedCount: 0,
                sumOfCapAllocation: 0,
                sumOfCaAllocation: 0,
            }
        },
        mounted () {

        },

        created: function(){
            this.fetchCapitalAssetsData();
            this.fetchCostsData();
            this.getStatisticsData();
        },

        methods: {
            setCostsChartData (data) {
                this.costChart = {
                    labels: this.getSeasonLabels(data),
                    datasets: [
                        {
                            label: 'مصوب',
                            backgroundColor: 'rgba(45 , 187 , 58 , 0.4)',
                            data: this.getSeasonApprovedAmount(data)
                        }, {
                            label: 'تخصیص',
                            backgroundColor: 'rgba(10 , 26 , 174 , 0.4)',
                            data: this.getSeasonAllocationAmount(data)
                        }
                    ]
                }
            },

            setCapitalAssetsChartData (data) {
                this.capitalAssetsChart = {
                    labels: this.getCountyLabels(data),
                    datasets: [
                        {
                            label: 'پیشنهاد دستگاه',
                            backgroundColor: 'rgba(240 , 173 , 78 , 0.4)',
                            data: this.getCountyProposalAmount(data)
                        }, {
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
                    this.setCapitalAssetsChartData(response.data);
                    this.setNatCapitalAssetsChartData(response.data);
                        console.log(response);
                    },(error) => {
                        console.log(error);
                    });
            },

            fetchCostsData: function () {
                axios.get('/budget/chart/costs').then((response) => {
                    this.setCostsChartData(response.data);
                    this.setNatCostsChartData(response.data);
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

            getCountyProposalAmount (data) {
                var temp = [];
                data.forEach(county => {
                    temp.push(this.$parent.calcDispAmount(county.coSumOfProposalAmount , false , false));
                });
                return temp;
            },

            getCountyApprovedAmount (data) {
                var temp = [];
                data.forEach(county => {
                    temp.push(this.$parent.calcDispAmount(county.coSumOfApprovedAmount , false , false));
            });
                return temp;
            },

            getCountyAllocationAmount (data) {
                var temp = [];
                data.forEach(county => {
                    temp.push(this.$parent.calcDispAmount(county.coSumOfAllocationAmount , false , false));
            });
                return temp;
            },

            getSeasonLabels (data) {
                var temp = [];
                data.forEach(season => {
                    temp.push(season.sSubject);
            });
                return temp;
            },

            getSeasonApprovedAmount (data) {
                var temp = [];
                data.forEach(season => {
                    temp.push(this.$parent.calcDispAmount(season.coSumOfApprovedAmount , false , false));
            });
                return temp;
            },

            getSeasonAllocationAmount (data) {
                var temp = [];
                data.forEach(season => {
                    temp.push(this.$parent.calcDispAmount(season.coSumOfAllocationAmount , false , false));
            });
                return temp;
            },
            /////////////////////////////////////////////////////////,
            setNatCostsChartData (data) {
                this.natCostChart = {
                    labels: this.getSeasonLabels(data),
                    datasets: [
                        {
                            label: 'مصوب',
                            backgroundColor: 'rgba(45 , 187 , 58 , 0.4)',
                            data: this.getNatSeasonApprovedAmount(data)
                        }, {
                            label: 'تخصیص',
                            backgroundColor: 'rgba(10 , 26 , 174 , 0.4)',
                            data: this.getNatSeasonAllocationAmount(data)
                        }
                    ]
                }
            },

            setNatCapitalAssetsChartData (data) {
                this.natCapitalAssetsChart = {
                    labels: this.getCountyLabels(data),
                    datasets: [
                        {
                            label: 'مصوب',
                            backgroundColor: 'rgba(45 , 187 , 58 , 0.4)',
                            data: this.getNatCountyApprovedAmount(data)
                        }, {
                            label: 'تخصیص',
                            backgroundColor: 'rgba(10 , 26 , 174 , 0.4)',
                            data: this.getNatCountyAllocationAmount(data)
                        }
                    ]
                }
            },

            getNatCountyApprovedAmount (data) {
                var temp = [];
                data.forEach(county => {
                    temp.push(this.$parent.calcDispAmount(county.coSumOfNatApprovedAmount , false , false));
            });
                return temp;
            },

            getNatCountyAllocationAmount (data) {
                var temp = [];
                data.forEach(county => {
                    temp.push(this.$parent.calcDispAmount(county.coSumOfNatAllocationAmount , false , false));
            });
                return temp;
            },

            getNatSeasonApprovedAmount (data) {
                var temp = [];
                data.forEach(season => {
                    temp.push(this.$parent.calcDispAmount(season.coSumOfNatApprovedAmount , false , false));
            });
                return temp;
            },

            getNatSeasonAllocationAmount (data) {
                var temp = [];
                data.forEach(season => {
                    temp.push(this.$parent.calcDispAmount(season.coSumOfNatAllocationAmount , false , false));
            });
                return temp;
            },

            getStatisticsData: function () {
                axios.post('/budget/statistics/getAllData').then((response) => {
                    this.prov_approvedPlanExchangedCount = response.data.approvedPlanExchangedCount;
                    this.sumOfCapAllocation = response.data.sumOfCapAllocation;
                    this.sumOfCaAllocation = response.data.sumOfCaAllocation
                    console.log(response);
                },(error) => {
                    console.log(error);
                });
            }
        }
    }
</script>
