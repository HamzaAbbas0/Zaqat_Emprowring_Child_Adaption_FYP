// Demo Pie Chart
// 
// The style configurations in this demo are
// intended to match the Material Design styling.
// Use this demo chart as a starting point and for
// reference when creating charts within an app.
// 
// Chart.js v3 is being used, which is currently
// in beta. For the v3 docs, visit
// https://www.chartjs.org/docs/master/


if (elem = document.getElementById('myPieChart')) {
    var ctx = elem.getContext('2d');
    
    var myPieChart = new Chart(ctx, {
        type: 'pie',
        data: {
            labels: chartData.map(a => a.name),
            datasets: [{
                data: chartData.map(a => a.service_count),
                backgroundColor: [successColor, dangerColor, primaryColor, warningColor],
            }],
        },
    });
}