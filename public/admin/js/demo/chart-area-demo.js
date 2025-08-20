// Set new default font family and font color to mimic Bootstrap's default styling
Chart.defaults.global.defaultFontFamily = 'Nunito', '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
Chart.defaults.global.defaultFontColor = '#858796';

function number_format(number, decimals, dec_point, thousands_sep) {
  // *     example: number_format(1234.56, 2, ',', ' ');
  // *     return: '1 234,56'
  number = (number + '').replace(',', '').replace(' ', '');
  var n = !isFinite(+number) ? 0 : +number,
    prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
    sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
    dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
    s = '',
    toFixedFix = function(n, prec) {
      var k = Math.pow(10, prec);
      return '' + Math.round(n * k) / k;
    };
  // Fix for IE parseFloat(0.55).toFixed(0) = 0;
  s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
  if (s[0].length > 3) {
    s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
  }
  if ((s[1] || '').length < prec) {
    s[1] = s[1] || '';
    s[1] += new Array(prec - s[1].length + 1).join('0');
  }
  return s.join(dec);
}

// Area Chart Example

$.get("get_chart_data", function(data){
  var naira ='\u20A6'; 
  var months = JSON.parse(data).map(item => item.month);
  var stationaries = JSON.parse(data).map(item => item.stationaries);
  var school_fees = JSON.parse(data).map(item => item.school_fees);
  var party_excursion = JSON.parse(data).map(item => item.party_excursion);
  var ctx = document.getElementById("myAreaChart");
  var myLineChart = new Chart(ctx, {
    type: 'line',
    data: {
      labels: months,
      datasets: [
            {
                label: 'Stationaries',
                data: stationaries,
                borderColor: '#1cc88a',
                backgroundColor: '#1cc88a',
                fill: true,
                tension: 0.3
            },
            {
                label: 'School Fees',
                data: school_fees,
                borderColor: '#4e73df',
                backgroundColor: '#4e73df',
                fill: true,
                tension: 0.3
            },
            {
                label: 'Party Excursion',
                data: party_excursion,
                borderColor: '#23abf4',
                backgroundColor: '#23abf4',
                fill: true,
                tension: 0.3
            }
        ]
    },
    /*options: {
        responsive: true,
        plugins: {
            title: {
                display: true,
                text: 'Monthly Financial Overview'
            }
        },
        scales: {
            y: {
                beginAtZero: true
            }
        },
    }*/

  options: {
    maintainAspectRatio: false,
    layout: {
      padding: {
        left: 10,
        right: 25,
        top: 25,
        bottom: 0
      }
    },
    scales: {
      xAxes: [{
        time: {
          unit: 'date'
        },
        gridLines: {
          display: false,
          drawBorder: false
        },
        ticks: {
          maxTicksLimit: 7
        }
      }],
      yAxes: [{
        ticks: {
          maxTicksLimit: 5,
          padding: 10,
          // Include a dollar sign in the ticks
          callback: function(value, index, values) {
            return '₦' + number_format(value);
          }
        },
        gridLines: {
          color: "rgb(234, 236, 244)",
          zeroLineColor: "rgb(234, 236, 244)",
          drawBorder: false,
          borderDash: [2],
          zeroLineBorderDash: [2]
        }
      }],
    },
    legend: {
      display: false
    },
    tooltips: {
      backgroundColor: "rgb(255,255,255)",
      bodyFontColor: "#858796",
      titleMarginBottom: 10,
      titleFontColor: '#6e707e',
      titleFontSize: 14,
      borderColor: '#dddfeb',
      borderWidth: 1,
      xPadding: 15,
      yPadding: 15,
      displayColors: false,
      intersect: false,
      mode: 'index',
      caretPadding: 10,
      callbacks: {
        label: function(tooltipItem, chart) {
          var datasetLabel = chart.datasets[tooltipItem.datasetIndex].label || '';
          return datasetLabel + ': ₦' + number_format(tooltipItem.yLabel);
        }
      }
    }
  }
  });
});

 $.get('/deschool/get-chart', function(datas){

    for(var j in datas){
      
      var total = 0;

      labels = myLineChart.data.labels;
      //myvalues =myLineChart.data.datasets[0].data
      for(var k in labels){
        //for(var i in myvalues){
          if(labels[k] ==j){
            //total = datas[j]
            myLineChart.data.datasets[0].data.push(datas[j]); 
            //myvalues[i] = datas.values[j].value;
          }else{
            myLineChart.data.datasets[0].data.push(0);  
          }
        
        //}

      }
    }
    
  }); 