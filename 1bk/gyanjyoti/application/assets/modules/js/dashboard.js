function piechartdata(){
    yearly = $("#yearly").val();
    monthly = $("#monthly").val();
    ajaxPostRequest('home/pie_chart_js',{'yearly': yearly,'monthly': monthly}, function(data) {
        
        // $("#pie-chart").empty();
        var cData = JSON.parse(data.chart_data);
          var ctx = $("#pie-chart");
        var modifiedArray = $.map(cData.label, function(value) {
          return value.replace(/_/g, "");
        });
            //pie chart data
            var data = {
                labels: modifiedArray,
                datasets: [
                {
                label: "Users Count",
                data: cData.data,
                backgroundColor: [
                "#DEB887",
                "#A9A9A9",
                "#DC143C",
                "#F4A460",
                "#2E8B57",
                "#1D7A46",
                "#CDA776",
                ],
                borderColor: [
                "#CDA776",
                "#989898",
                "#CB252B",
                "#E39371",
                "#1D7A46",
                "#F4A460",
                "#CDA776",
                ],
                borderWidth: [1, 1, 1, 1, 1,1,1]
            }
            ]
        };
    
        //options
        var options = {
            responsive: true,
            title: {
            display: true,
            position: "top",
            text: "",
            fontSize: 18,
            fontColor: "#111"
            },
            legend: {
            display: true,
            position: "bottom",
            labels: {
                fontColor: "#333",
                fontSize: 16
            }
            }
        };
    
        //create Pie Chart class object
        var chart1 = new Chart(ctx, {
            type: "pie",
            data: data,
            options: options
        });
        
    });
}

//Added by Suhrid Sarkar || suhrid.developer@gmail.com on August 28, 2023
//For generate Apex chart
function generateApexChart(){
    yearly = $("#yearly").val();
    monthly = $("#monthly").val();

    ajaxPostRequest('home/pie_chart_js',{'yearly': yearly,'monthly': monthly}, function(data) {
        console.log(data);
        var options = {
                series: data.values,
                chart: {
                width: 380,
                type: 'pie',
            },
            labels: data.lavels,
            responsive: [{
                breakpoint: 480,
                options: {
                    chart: {
                        width: 200
                    },
                    legend: {
                        position: 'bottom'
                    }
                }
            }]
        };

        var chart = new ApexCharts(document.querySelector("#chart"), options);
        chart.render();
    });
}

function filterChartData(){
    piechartdata();
    generateApexChart();
}