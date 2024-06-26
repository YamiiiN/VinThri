<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customers Per Month</title>
    <!-- Include Chart.js library -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <h1><center>Customer Line Graph</h1></center>
    <canvas id="customersChart" width="400" height="400"></canvas>

    <script>
        var months = {!! json_encode(array_keys($months)) !!};
        var ctx = document.getElementById('customersChart').getContext('2d');

        var myChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: months,
                datasets: [{
                    label: 'Customers Per Month',
                    data: {!! json_encode(array_values($months)) !!},
                    fill: false,
                    borderColor: 'rgb(75, 192, 192)',
                    tension: 0.1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
</body>
</html>
