    <!-- <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Graph Selector</title>
    
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    </head>
    <body>
        <h1><center>Graph Selector</center></h1>

        <div id="graphSelecterDiv">
            <center><label for="graphSelector">Select Graph:</label>
        <select id="graphSelector" onchange="updateChart()">
            <option value="orders">Orders Per Month</option>
            <option value="customers">Customers Per Month</option>
            <option value="sales">Sales Per Month</option>
        </select>
    </center>
        <div id="chartContainer">
        
        </div>

        <script>
            var selectedGraph = 'orders';
            var chart; 
            var ordersData = {!! json_encode($orders) !!};
            var customersData = {!! json_encode($customers) !!};
            var salesData = {!! json_encode($sales) !!};

        
            function updateChart() {
                var selectedValue = document.getElementById('graphSelector').value;
                selectedGraph = selectedValue;
                renderChart();
            }

            
            function renderChart() {
                var chartContainer = document.getElementById('chartContainer');
                chartContainer.innerHTML = ''; 

                switch (selectedGraph) {
                    case 'orders':
                        chartContainer.innerHTML = `<canvas id="ordersChart" width="400" height="400"></canvas>`;
                        renderOrdersChart();
                        break;
                    case 'customers':
                        chartContainer.innerHTML = `<canvas id="customersChart" width="400" height="400"></canvas>`;
                        renderCustomersChart();
                        break;
                    case 'sales':
                        chartContainer.innerHTML = `<canvas id="salesChart" width="400" height="400"></canvas>`;
                        renderSalesChart();
                        break;
                    default:
                        break;
                }
            }

            
            function renderOrdersChart() {
                var ctx = document.getElementById('ordersChart').getContext('2d');
                var months = Object.keys(ordersData);
                var ordersPerMonthData = Object.values(ordersData);

                chart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: months,
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
            }

            
            function renderCustomersChart() {
                var ctx = document.getElementById('customersChart').getContext('2d');
                var months = Object.keys(customersData);
                var customersPerMonthData = Object.values(customersData);

                chart = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: months,
                        datasets: [{
                            label: 'Customers Per Month',
                            data: customersPerMonthData,
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
            }

            
            function renderSalesChart() {
                var ctx = document.getElementById('salesChart').getContext('2d');
                var months = Object.keys(salesData);
                var salesPerMonthData = Object.values(salesData);

                chart = new Chart(ctx, {
                    type: 'pie',
                    data: {
                        labels: months,
                        datasets: [{
                            label: 'Sales Per Month',
                            data: salesPerMonthData,
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
            }

        
            renderChart();
        </script>
    </body>
    </html> -->
    @extends('layouts.app')

@section('title', 'Analytics Dashboard')

@section('contents')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h1 class="text-center">Graph Selector</h1>
                </div>
                <div class="card-body">
                    <div class="text-center mb-4">
                        <label for="graphSelector">Select Graph:</label>
                        <select id="graphSelector" class="form-control d-inline-block w-auto ml-2" onchange="updateChart()">
                            <option value="orders">Orders Per Month</option>
                            <option value="customers">Customers Per Month</option>
                            <option value="sales">Sales Per Month</option>
                        </select>
                    </div>
                    
                    <div id="chartContainer" class="mt-4">
                        <!-- Chart will be rendered here -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Chart.js Script -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    var selectedGraph = 'orders'; // Default selected graph
    var chart; // Variable to hold the chart instance
    var ordersData = {!! json_encode($orders) !!};
    var customersData = {!! json_encode($customers) !!};
    var salesData = {!! json_encode($sales) !!};

    // Function to update the chart based on the selected graph
    function updateChart() {
        var selectedValue = document.getElementById('graphSelector').value;
        selectedGraph = selectedValue;
        renderChart();
    }

    // Function to render the selected chart
    function renderChart() {
        var chartContainer = document.getElementById('chartContainer');
        chartContainer.innerHTML = ''; // Clear previous chart

        switch (selectedGraph) {
            case 'orders':
                chartContainer.innerHTML = `
                    <h2 class="text-center mb-3">Orders Per Month</h2>
                    <canvas id="ordersChart" width="400" height="400"></canvas>
                `;
                renderOrdersChart();
                break;
            case 'customers':
                chartContainer.innerHTML = `
                    <h2 class="text-center mb-3">Customer Line Graph</h2>
                    <canvas id="customersChart" width="400" height="400"></canvas>
                `;
                renderCustomersChart();
                break;
            case 'sales':
                chartContainer.innerHTML = `
                    <h2 class="text-center mb-3">Sales Pie Graph</h2>
                    <canvas id="salesChart" width="400" height="400"></canvas>
                `;
                renderSalesChart();
                break;
            default:
                break;
        }
    }

    // Function to render Orders chart
    function renderOrdersChart() {
        var ctx = document.getElementById('ordersChart').getContext('2d');
        
        // Check if we're using the month numbers approach
        if (Array.isArray(ordersData)) {
            // This is for the format in the second example (numbered months)
            var months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
            var ordersPerMonthData = [];
            
            // Fill orders data for each month
            for (var i = 0; i < 12; i++) {
                if (i < ordersData.length) {
                    ordersPerMonthData.push(ordersData[i]);
                } else {
                    ordersPerMonthData.push(0);
                }
            }
            
            chart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: months,
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
        } else {
            // This is for the format from the first example (object with month keys)
            var months = Object.keys(ordersData);
            var ordersPerMonthData = Object.values(ordersData);
            
            chart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: months,
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
        }
    }

    // Function to render Customers chart
    function renderCustomersChart() {
        var ctx = document.getElementById('customersChart').getContext('2d');
        
        // Handling both data formats
        if (Array.isArray(customersData)) {
            var months = {!! json_encode(array_keys($months ?? [])) !!};
            var customersPerMonthData = {!! json_encode(array_values($months ?? [])) !!};
        } else {
            var months = Object.keys(customersData);
            var customersPerMonthData = Object.values(customersData);
        }

        chart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: months,
                datasets: [{
                    label: 'Customers Per Month',
                    data: customersPerMonthData,
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
    }

    // Function to render Sales chart
    function renderSalesChart() {
        var ctx = document.getElementById('salesChart').getContext('2d');
        
        // Handling both data formats
        if (Array.isArray(salesData)) {
            var months = {!! json_encode(array_keys($months ?? [])) !!};
            var salesPerMonthData = {!! json_encode(array_values($months ?? [])) !!};
        } else {
            var months = Object.keys(salesData);
            var salesPerMonthData = Object.values(salesData);
        }

        chart = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: months,
                datasets: [{
                    label: 'Sales Per Month',
                    data: salesPerMonthData,
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
    }

    // Initialize the chart when the document is loaded
    document.addEventListener('DOMContentLoaded', function() {
        renderChart();
    });
</script>
@endsection