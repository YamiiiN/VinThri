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
    <canvas id="ordersChart" width="400" height="400"></canvas>

    <script>
        var ctx = document.getElementById('ordersChart').getContext('2d');
        var months = {!! json_encode(range(1, 12)) !!}; // Array of all months (1 to 12)
        var ordersData = {!! json_encode(array_values($months)) !!};
        var ordersPerMonthData = [];

        // Fill orders data for each month
        for (var i = 0; i < 12; i++) {
            var monthIndex = months.indexOf(i + 1);
            if (monthIndex !== -1) {
                ordersPerMonthData.push(ordersData[monthIndex]);
            } else {
                ordersPerMonthData.push(0); // If no orders for the month, set count to 0
            }
        }

        var myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
                datasets: [{
                    label: 'Orders Per Month',
                    data: ordersPerMonthData,
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
