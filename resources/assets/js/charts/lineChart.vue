<template xmlns:v-on="http://www.w3.org/1999/xhtml">
    <div class="grid-x">
        <div class="large-12 medium-12 small-12">
            <apexchart type=line height=350 :options="chartOptions" :series="series" />
        </div>
    </div>
</template>
<script>
    import VueApexCharts from 'vue-apexcharts';
    export default{
        components: {
            apexchart: VueApexCharts,
        },
        props:['chartOptions','series'],
        data () {
            return {
                chartOptions: {
                    chart: {
                        shadow: {
                            enabled: true,
                            color: '#000',
                            top: 18,
                            left: 7,
                            blur: 10,
                            opacity: 1
                        },
                        toolbar: {
                            show: false
                        }
                    },
                    colors: ['#77B6EA', '#545454'],
                    dataLabels: {
                        enabled: true,
                    },
                    stroke: {
                        curve: 'smooth'
                    },
                    title: {
                        text: 'Average High & Low Temperature',
                        align: 'left'
                    },
                    grid: {
                        borderColor: '#e7e7e7',
                        row: {
                            colors: ['#f3f3f3', 'transparent'], // takes an array which will be repeated on columns
                            opacity: 0.5
                        },
                    },
                    markers: {
                        style: 'inverted',
                        size: 6
                    },
                    xaxis: {
                        categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul'],
                        title: {
                            text: 'Month'
                        }
                    },
                    yaxis: {
                        title: {
                            text: 'Temperature'
                        },
                        min: 5,
                        max: 40
                    },
                    legend: {
                        position: 'top',
                        horizontalAlign: 'right',
                        floating: true,
                        offsetY:0,
                        offsetX: 0
                    }
                }

            }

        },

        created: function () {
            $(this.$el).foundation(); //WORKS!

        },
        updated: function () {
            $(this.$el).foundation(); //WORKS!

        },

        mounted: function () {
            //this.testUpdate();
        },

        methods : {
            testUpdate:function () {
                /*this.$refs.demoUptions.updateOptions({
                    chartOptions:{
                        xaxis: {
                            categories:  ['یک','دو','سه','چهار','پنج','شش','هفت'],
                        },
                    }
                })*/
                this.chartOptions={
                    xaxis: {
                        categories:  ['یک','دو','سه','چهار','پنج','شش','هفت'],
                    },
                }
            }

        }
    }
</script>
