// LineChart.js
import { Line , mixins } from 'vue-chartjs'
const { reactiveProp } = mixins

export default {
    extends: Line,
    mixins: [reactiveProp],
    data(){
        return {
            options:{
                scales: {
                    yAxes: [{
                        gridLines: {
                            display: true
                        }
                    }],
                    xAxes: [ {
                        gridLines: {
                            display: true
                        }
                    }]
                }
            }
        }
    },
    mounted () {
        console.log("mounted line chart");
        this.renderChart(this.chartData , this.options);
    }
}
