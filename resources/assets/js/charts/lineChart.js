// LineChart.js
import { Line } from 'vue-chartjs'

export default {
    extends: Line,
    props: ['data'],
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
        this.renderChart(this.data , this.options);
    }
}
