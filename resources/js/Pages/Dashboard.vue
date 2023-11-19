<script setup>
import Menu from '@/Layouts/Menu.vue';
import { Head } from '@inertiajs/vue3';
import {onMounted} from 'vue';
const props =defineProps({ 
  all: {
        type: Number,
    },
    sin: {
        type: Number,
    },
    pro: {
        type: Number,
    },
    finexito: {
        type: Number,
    },
    finerror: {
        type: Number,
    }
 
});
onMounted(async () => {  
    if ($("#north-america-chart").length) {
      var areaData = {
        labels: ["sin proceso", "en proceso", "exitoso", "con error"],
        datasets: [{
            data: [parseInt(props.sin), parseInt(props.pro), parseInt(props.finexito),parseInt(props.finerror)],
            backgroundColor: [
               "#248AFD","#FFC100", "#25ba5e  ","#fd242b",
            ],
            borderColor: "rgba(0,0,0,0)"
          }
        ]
      };
      var areaOptions = {
        responsive: true,
        maintainAspectRatio: true,
        segmentShowStroke: false,
        cutoutPercentage: 78,
        elements: {
          arc: {
              borderWidth: 4
          }
        },      
        legend: {
          display: false
        },
        tooltips: {
          enabled: true
        },
        legendCallback: function(chart) { 
          var text = [];
          text.push('<div class="report-chart">');
            text.push('<div class="d-flex justify-content-between mx-4 mx-xl-5 mt-3"><div class="d-flex align-items-center"><div class="mr-3" style="width:20px; height:20px; border-radius: 50%; background-color: ' + chart.data.datasets[0].backgroundColor[0] + '"></div><p class="mb-0">Sin procesar</p></div>');
            text.push('<p class="mb-0">'+props.sin+'</p>');
            text.push('</div>');
            text.push('<div class="d-flex justify-content-between mx-4 mx-xl-5 mt-3"><div class="d-flex align-items-center"><div class="mr-3" style="width:20px; height:20px; border-radius: 50%; background-color: ' + chart.data.datasets[0].backgroundColor[1] + '"></div><p class="mb-0">En atencion</p></div>');
            text.push('<p class="mb-0">'+props.pro+'</p>');
            text.push('</div>');
            text.push('<div class="d-flex justify-content-between mx-4 mx-xl-5 mt-3"><div class="d-flex align-items-center"><div class="mr-3" style="width:20px; height:20px; border-radius: 50%; background-color: ' + chart.data.datasets[0].backgroundColor[2] + '"></div><p class="mb-0">Registrados con exitos</p></div>');
            text.push('<p class="mb-0">'+props.finexito+'</p>');
            text.push('</div>');
            text.push('<div class="d-flex justify-content-between mx-4 mx-xl-5 mt-3"><div class="d-flex align-items-center"><div class="mr-3" style="width:20px; height:20px; border-radius: 50%; background-color: ' + chart.data.datasets[0].backgroundColor[3] + '"></div><p class="mb-0">Registrados con problemas</p></div>');
            text.push('<p class="mb-0">'+props.finerror+'</p>');
            text.push('</div>');
          text.push('</div>');
          return text.join("");
        },
      }
      var northAmericaChartPlugins = {
        beforeDraw: function(chart) {
          var width = chart.chart.width,
              height = chart.chart.height,
              ctx = chart.chart.ctx;
      
          ctx.restore();
          var fontSize = 3.125;
          ctx.font = "500 " + fontSize + "em sans-serif";
          ctx.textBaseline = "middle";
          ctx.fillStyle = "#13381B";
      
          var text = "Call",
              textX = Math.round((width - ctx.measureText(text).width) / 2),
              textY = height / 2;
      
          ctx.fillText(text, textX, textY);
          ctx.save();
        }
      }
      var northAmericaChartCanvas = $("#north-america-chart").get(0).getContext("2d");
      var northAmericaChart = new Chart(northAmericaChartCanvas, {
        type: 'doughnut',
        data: areaData,
        options: areaOptions,
        plugins: northAmericaChartPlugins
      });
      document.getElementById('north-america-legend').innerHTML = northAmericaChart.generateLegend();
    }
})
</script>

<template>
    <Head title="Dashboard" /> 
    <Menu>  
          <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
              <div class="card position-relative">
                <div class="card-body">
                    <div class="row">
                          <div class="col-md-12 col-xl-3 d-flex flex-column justify-content-start">
                            <div class="ml-xl-4 mt-3"> 
                            <h3 class=" font-weight-bold mb-3">Bienvenido {{ $page.props.auth.user.name }}</h3> 
                              <h1 class="text-primary">{{all}}</h1>
                              <h3 class="font-weight-500 mb-xl-4 text-primary">Registros</h3>
                            </div>  
                            </div>
                          <div class="col-md-12 col-xl-9">
                            <div class="row"> 
                              <div class="col-md-12 mt-3  row">
                                <div class="col-md-6 border-right">
                                  <canvas id="north-america-chart"></canvas>
                                </div>
                                <div class="col-md-6"  id="north-america-legend"></div>
                              </div>
                            </div>
                          </div>
                        </div>
                </div>
              </div>
            </div>
          </div>
         
    </Menu>
</template>
