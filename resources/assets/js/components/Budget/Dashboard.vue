<template>
<!--Body system-->
<div style="padding: 30px;" class="medium-10 border-right-line">
    <div style="padding-right: 15px;padding-left: 15px;" class="grid-x">
        <div class="medium-12 border-btm-line">
            <h5 class="BYekan black-color">داشبورد</h5>
        </div>
    </div>
    <div class="container-vh">
        <div style="height: 75vh" class="inner-vh-unsize">
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
                <div class="large-6 medium-6 small-12 dashboard-padding ">
                    <div class="grid-x">
                        <div style="padding: 10px;" class="large-12 medium-12 small-12 my-callout-box my-callout-bg-color"><i class="fa fa-area-chart" aria-hidden="true"></i> <span class="small-font">تملک داریی های سرمایه ای استانی</span>
                            <a style="margin-bottom: 0px;" type="button" class="my-secondary button small float-left" @click="showCapitalAssetsChartDialog = true">اطلاعات بیشتر</a>
                        </div>
                        <div class="large-12 medium-12 small-12 my-callout-box my-callout-bg-color text-center">
                            <lineChart
                                    v-bind:chartOptions="capitalAssetsChartOptions"
                                    v-bind:series="capitalAssetsChart"

                            ></lineChart>
                            <small>مبالغ: <span class="btn-red">{{ $parent.getAmountBaseLabel()}}</span></small>
                        </div>
                    </div>
                </div>
                <div class="large-6 medium-6 small-12 dashboard-padding ">
                    <div class="grid-x">
                        <div style="padding: 10px;" class="large-12 medium-12 small-12 my-callout-box my-callout-bg-color"><i class="fa fa-area-chart" aria-hidden="true"></i> <span class="small-font">هزینه ای استانی</span>
                            <a style="margin-bottom: 0px;" type="button" class="my-secondary button small float-left" @click="showCostChartDialog = true">اطلاعات بیشتر</a>
                        </div>
                        <div class="large-12 medium-12 small-12 my-callout-box my-callout-bg-color text-center">
                            <lineChart
                                    v-bind:chartOptions="costsChartOptions"
                                    v-bind:series="costsChart"

                            ></lineChart>
                            <small>مبالغ: <span class="btn-red">{{ $parent.getAmountBaseLabel()}}</span></small>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid-x my-grid-margin">
                <div class="large-6 medium-6 small-12 dashboard-padding ">
                    <div class="grid-x">
                        <div style="padding: 10px;" class="medium-12 my-callout-box my-callout-bg-color"><i class="fa fa-area-chart" aria-hidden="true"></i> <span class="small-font">تملک داریی های سرمایه ای ملی</span>
                            <a style="margin-bottom: 0px;" type="button" class="my-secondary button small float-left" @click="showNatCapitalAssetsChartDialog = true">اطلاعات بیشتر</a>
                        </div>
                        <div class="medium-12 my-callout-box my-callout-bg-color text-center">
                            <lineChart
                                    v-bind:chartOptions="natCapitalAssetsChartOptions"
                                    v-bind:series="natCapitalAssetsChart"

                            ></lineChart>
                            <div class="grid-x">
                                <div class="medium-12 text-center">
                                    <small>مبالغ: <span class="btn-red">{{ $parent.getAmountBaseLabel()}}</span></small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="large-6 medium-6 small-12 dashboard-padding ">
                    <div class="grid-x">
                        <div style="padding: 10px;" class="medium-12 my-callout-box my-callout-bg-color"><i class="fa fa-area-chart" aria-hidden="true"></i> <span class="small-font">هزینه ای ملی</span>
                            <a style="margin-bottom: 0px;" type="button" class="my-secondary button small float-left" @click="showNatCostChartDialog = true">اطلاعات بیشتر</a>
                        </div>
                        <div class="medium-12 my-callout-box my-callout-bg-color text-center">
                            <!--<line-chart :chart-data="natCostChart"   :width="400" :height="200"></line-chart>-->
                            <lineChart
                                    v-bind:chartOptions="natCostChartOptions"
                                    v-bind:series="natCostsChart"

                            ></lineChart>
                            <div class="grid-x">
                                <div class="medium-12 text-center">
                                    <small>مبالغ: <span class="btn-red">{{ $parent.getAmountBaseLabel()}}</span></small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--Insert Modal Start-->
    <modal-large v-if="showCapitalAssetsChartDialog" @close="showCapitalAssetsChartDialog = false">
        <div  slot="body">
            <h6 class="text-center BYekan">تملک داریی های سرمایه استانی</h6>
            <lineChart
                    v-bind:chartOptions="capitalAssetsChartOptions"
                    v-bind:series="capitalAssetsChart"

            ></lineChart>
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
            <lineChart
                    v-bind:chartOptions="costsChartOptions"
                    v-bind:series="costsChart"

            ></lineChart>
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
            <lineChart
                    v-bind:chartOptions="natCapitalAssetsChartOptions"
                    v-bind:series="natCapitalAssetsChart"

            ></lineChart>
            <small>مبالغ: <span class="btn-red">{{ $parent.getAmountBaseLabel()}}</span></small>
        </div>
    </modal-large>
    <!--chart1 Modal End-->
    <modal-large v-if="showNatCostChartDialog" @close="showNatCostChartDialog = false">
        <div  slot="body">
            <h6 class="text-center BYekan">هزینه ای استانی</h6>
            <lineChart
                    v-bind:chartOptions="natCostChartOptions"
                    v-bind:series="natCostsChart"

            ></lineChart>
            <small>مبالغ: <span class="btn-red">{{ $parent.getAmountBaseLabel()}}</span></small>
        </div>
    </modal-large>
    <!--chart1 Modal End-->
</div>
</template>
<script>
    import lineChart from '../../charts/lineChart.vue';
    export default {
        components: {
            lineChart,
        },
        data () {
            return {

                showCapitalAssetsChartDialog: false,
                showCostChartDialog: false,
                showNatCapitalAssetsChartDialog: false,
                showNatCostChartDialog: false,
                prov_approvedPlanExchangedCount: 0,
                sumOfCapAllocation: 0,
                sumOfCaAllocation: 0,
                updateDataThreadNowPlaying: null,
                singletonUpdateDataThreadNowPlaying: null,
                costsChart:[],
                capitalAssetsChart:[],
                natCostsChart:[],
                natCostChartOptions:{},
                natCapitalAssetsChart:[],
                natCapitalAssetsChartOptions:{},


            }
        },

        created: function(){
            this.setUpdateDataThread();
            this.fetchCapitalAssetsData();
            this.fetchCostsData();
            this.getStatisticsData();
        },

        beforeDestroy: function () {
            clearInterval(this.updateDataThreadNowPlaying);
            clearInterval(this.singletonUpdateDataThreadNowPlaying);
            console.log('...................................... kill update data thread');
        },

        updated: function () {
            $(this.$el).foundation(); //WORKS!
        },

        mounted: function () {

        },

        methods: {
            setCostsChartData (data) {
                this.costsChartOptions={
                    xaxis: {
                        categories:  this.getSeasonLabels(data),
                    },
                };
                this.costsChart= [
                    {
                        name: "تخصیص",
                        data: this.getSeasonApprovedAmount(data)
                    },
                    {
                        name: "مصوب",
                        data: this.getSeasonAllocationAmount(data)
                    }
                ];

            },

            setCapitalAssetsChartData (data) {
                this.capitalAssetsChartOptions={
                    xaxis: {
                        categories:  this.getCountyLabels(data),
                    },
                };
                this.capitalAssetsChart= [
                    {
                        name: 'پیشنهاد دستگاه',
                        data: this.getCountyProposalAmount(data)
                    }, {
                        name: 'مصوب',
                        data: this.getCountyApprovedAmount(data)
                    }, {
                        name: 'تخصیص',
                        data: this.getCountyAllocationAmount(data)
                    }
                ]

            },

            fetchCapitalAssetsData: function () {
                axios.get('/budget/chart/capitalAssets' , {params:{test: Math.random()}})
                    .then((response) => {
                    this.setCapitalAssetsChartData(response.data);
                    this.setNatCapitalAssetsChartData(response.data);
                        console.log(response);
                    },(error) => {
                        console.log(error);
                    }).catch(error => {
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
                    temp.push(parseFloat(this.$parent.calcDispAmount(county.coSumOfProposalAmount , false , false)));
                });
                return temp;
            },

            getCountyApprovedAmount (data) {
                var temp = [];
                data.forEach(county => {
                    temp.push(parseFloat(this.$parent.calcDispAmount(county.coSumOfApprovedAmount , false , false)));
            });
                return temp;
            },

            getCountyAllocationAmount (data) {
                var temp = [];
                data.forEach(county => {
                    temp.push(parseFloat(this.$parent.calcDispAmount(county.coSumOfAllocationAmount , false , false)));
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
                    temp.push(parseFloat(this.$parent.calcDispAmount(season.coSumOfApprovedAmount , false , false)));
            });
                return temp;
            },

            getSeasonAllocationAmount (data) {
                var temp = [];
                data.forEach(season => {
                    temp.push(parseFloat(this.$parent.calcDispAmount(season.coSumOfAllocationAmount , false , false)));
            });
                return temp;
            },
            /////////////////////////////////////////////////////////,
            setNatCostsChartData (data) {
                this.natCostChartOptions={
                    xaxis: {
                        categories:  this.getSeasonLabels(data),
                    },
                };
                this.natCostsChart= [
                    {
                        name: 'مصوب',
                        data: this.getNatSeasonApprovedAmount(data)
                    }, {
                        name: 'تخصیص',
                        data:this.getNatSeasonAllocationAmount(data)
                    }
                ]
            },

            setNatCapitalAssetsChartData (data) {
                this.natCapitalAssetsChartOptions={
                    xaxis: {
                        categories: this.getCountyLabels(data),
                    },
                };
                this.natCapitalAssetsChart= [
                    {
                        name: 'مصوب',
                        data:  this.getNatCountyApprovedAmount(data)
                    }, {
                        name: 'تخصیص',
                        data:  this.getNatCountyAllocationAmount(data)
                    }
                ]
            },

            getNatCountyApprovedAmount (data) {
                var temp = [];
                data.forEach(county => {
                    temp.push(parseFloat(this.$parent.calcDispAmount(county.coSumOfNatApprovedAmount , false , false)));
            });
                return temp;
            },

            getNatCountyAllocationAmount (data) {
                var temp = [];
                data.forEach(county => {
                    temp.push(parseFloat(this.$parent.calcDispAmount(county.coSumOfNatAllocationAmount , false , false)));
            });
                return temp;
            },

            getNatSeasonApprovedAmount (data) {
                var temp = [];
                data.forEach(season => {
                    temp.push(parseFloat(this.$parent.calcDispAmount(season.coSumOfNatApprovedAmount , false , false)));
            });
                return temp;
            },

            getNatSeasonAllocationAmount (data) {
                var temp = [];
                data.forEach(season => {
                    temp.push(parseFloat(this.$parent.calcDispAmount(season.coSumOfNatAllocationAmount , false , false)));
                });
                return temp;
            },

            getStatisticsData: function () {
                axios.post('/budget/statistics/getAllData').then((response) => {
                    this.prov_approvedPlanExchangedCount = response.data.approvedPlanExchangedCount;
                    this.sumOfCapAllocation = response.data.sumOfCapAllocation;
                    this.sumOfCaAllocation = response.data.sumOfCaAllocation;
                    console.log(response);
                },(error) => {
                    console.log(error);
                });
            },

            setUpdateDataThread: function () {
                console.log("...................................................... set budget dashboard update thread");

                this.singletonUpdateDataThreadNowPlaying = setInterval(this.updateDataThread, 1000);
                if (this.updateDataThreadNowPlaying)
                    clearInterval(this.updateDataThreadNowPlaying);
                this.updateDataThreadNowPlaying = setInterval(this.updateDataThread, 120000);
            },

            updateDataThread: function () {
                console.log("...................................................... budget dashboard update thread");
                this.fetchCapitalAssetsData();
                this.fetchCostsData();
                this.getStatisticsData();
                if (this.singletonUpdateDataThreadNowPlaying)
                    clearInterval(this.singletonUpdateDataThreadNowPlaying);
            },
        }
    }
</script>
