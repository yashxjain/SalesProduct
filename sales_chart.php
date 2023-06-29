<?php
// Assuming you have already established a database connection
include "db.php";
$con = getdb();

// Calculate the total sales amount for each product
$sqlTotalSales =
    "SELECT Product, SUM(CAST(REPLACE(REPLACE(Sales, '$', ''), ',', '') AS DECIMAL(10,2))) AS TotalSales FROM sales GROUP BY Product";
$resultTotalSales = mysqli_query($con, $sqlTotalSales);

// Prepare data for the chart
$labels = [];
$data = [];

while ($rowTotalSales = mysqli_fetch_assoc($resultTotalSales)) {
    $labels[] = $rowTotalSales["Product"];
    $data[] = $rowTotalSales["TotalSales"];
}

// Close the database connection
mysqli_close($con);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Sales Chart</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <h1>Sales Chart</h1>

    <canvas id="salesChart"></canvas>

    <script>
        var ctx = document.getElementById('salesChart').getContext('2d');
        var chart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: <?php echo json_encode($labels); ?>,
                datasets: [{
                    label: 'Total Sales',
                    data: <?php echo json_encode($data); ?>,
                    backgroundColor: 'rgba(54, 162, 235, 0.5)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            precision: 0,
                            callback: function(value, index, values) {
                                return '$' + value;
                            }
                        }
                    }
                }
            }
        });
    </script>
</body>
</html>
