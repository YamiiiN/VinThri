<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sales Per Month</title>
    <!-- Include Chart.js library -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <h1><center>Sales Pie Graph</h1></center>
    <canvas id="salesChart" width="400" height="400"></canvas>

    <script>
        var ctx = document.getElementById('salesChart').getContext('2d');
        var months = {!! json_encode(array_keys($months)) !!};

        var myChart = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: months,
                datasets: [{
                    label: 'Sales Per Month',
                    data: {!! json_encode(array_values($months)) !!},
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(255, 159, 64, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                plugins: {
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                var label = context.label || '';
                                var value = context.raw ? context.raw.toFixed(0) : '';
                                var sum = context.dataset.data.reduce((a, b) => a + b, 0);
                                var percentage = Math.round((value / sum) * 100) + '%';
                                return label + (label ? ': ' + value + ' ' + 'Percentage: ' + percentage : '');
                            }
                        }
                    }
                }
            }
        });
    </script>
</body>
</html>
