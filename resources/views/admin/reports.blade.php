<!DOCTYPE html>
<html>
<head>
    <title>Reports</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>

<h2>Business Reports Summary</h2>

<table border="1" cellpadding="10">

<tr>
    <td>Total Sales Revenue</td>
    <td>{{ $totalSales->total ?? 0 }}</td>
</tr>

<tr>
    <td>Total Paid Expenses</td>
    <td>{{ $totalExpenses }}</td>
</tr>

<tr>
    <td>Total Orders</td>
    <td>{{ $totalOrders }}</td>
</tr>

<tr>
    <td>Total Products</td>
    <td>{{ $totalProducts }}</td>
</tr>

<tr>
    <td>Total Customers</td>
    <td>{{ $totalCustomers }}</td>
</tr>

<tr>
    <td>Total Employees</td>
    <td>{{ $totalEmployees }}</td>
</tr>

<tr>
    <td>Estimated Profit</td>
    <td>{{ ($totalSales->total ?? 0) - $totalExpenses }}</td>
</tr>

</table>

<h2>Yearly Sales</h2>
<canvas id="yearlySalesChart" width="400" height="200"></canvas>

<h2>Sales by Date Range</h2>
<form method="GET" action="/admin/reports">
    <p>
        Start Date: <input type="date" name="start_date" value="{{ $startDate }}">
        End Date: <input type="date" name="end_date" value="{{ $endDate }}">
        <button type="submit">Apply</button>
    </p>
</form>
<canvas id="rangeSalesChart" width="400" height="200"></canvas>

<h2>Sales by Product (Percentage)</h2>
<canvas id="productPieChart" width="400" height="200"></canvas>

<br>
<a href="/admin/dashboard">Back</a>

<script>
    (function () {
        var yearlyLabels = {!! json_encode($yearlySalesLabels) !!};
        var yearlyData = {!! json_encode($yearlySalesData) !!};

        if (yearlyLabels.length > 0 && document.getElementById('yearlySalesChart')) {
            var ctx1 = document.getElementById('yearlySalesChart').getContext('2d');
            new Chart(ctx1, {
                type: 'bar',
                data: {
                    labels: yearlyLabels,
                    datasets: [{
                        label: 'Yearly Sales',
                        data: yearlyData,
                        backgroundColor: 'rgba(54, 162, 235, 0.5)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: { beginAtZero: true }
                    }
                }
            });
        }

        var rangeLabels = {!! json_encode($rangeLabels) !!};
        var rangeData = {!! json_encode($rangeData) !!};

        if (rangeLabels.length > 0 && document.getElementById('rangeSalesChart')) {
            var ctx2 = document.getElementById('rangeSalesChart').getContext('2d');
            new Chart(ctx2, {
                type: 'bar',
                data: {
                    labels: rangeLabels,
                    datasets: [{
                        label: 'Sales',
                        data: rangeData,
                        backgroundColor: 'rgba(75, 192, 192, 0.5)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: { beginAtZero: true }
                    }
                }
            });
        }

        var productLabels = {!! json_encode($productLabels) !!};
        var productData = {!! json_encode($productData) !!};

        if (productLabels.length > 0 && document.getElementById('productPieChart')) {
            var ctx3 = document.getElementById('productPieChart').getContext('2d');
            var baseColors = [
                '#3366CC', '#DC3912', '#FF9900', '#109618', '#990099',
                '#3B3EAC', '#0099C6', '#DD4477', '#66AA00', '#B82E2E',
                '#316395', '#994499', '#22AA99', '#AAAA11', '#6633CC'
            ];
            var bgColors = productLabels.map(function (_, index) {
                return baseColors[index % baseColors.length];
            });

            new Chart(ctx3, {
                type: 'pie',
                data: {
                    labels: productLabels,
                    datasets: [{
                        data: productData,
                        backgroundColor: bgColors
                    }]
                }
            });
        }
    })();
</script>

</body>
</html>