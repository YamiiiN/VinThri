<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Orders Per Month</title>
    <!-- Include Chart.js library -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <h1><center>Order Bar Graph</h1></center>
    <canvas id="ordersChart" width="400" height="400"></canvas>

    <script>
        var ctx = document.getElementById('ordersChart').getContext('2d');
        var months = {!! json_encode(array_keys($months)) !!};
        var ordersData = {!! json_encode(array_values($months)) !!};

        var myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: months,
                datasets: [{
                    label: 'Orders Per Month',
                    data: ordersData,
                    backgroundColor: 'rgba(255, 99, 132, 0.2)',
                    borderColor: 'rgba(255, 99, 132, 1)',
                    borderWidth: 1
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
