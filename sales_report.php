<?php
// Assuming you have already established a database connection
include "db.php";
$con = getdb();

// Calculate the total sales amount for each product
$sqlTotalSales =
    "SELECT Product, SUM(CAST(REPLACE(REPLACE(Sales, '$', ''), ',', '') AS DECIMAL(10,2))) AS TotalSales FROM sales GROUP BY Product";
$resultTotalSales = mysqli_query($con, $sqlTotalSales);

// Determine the highest-selling product and the corresponding sales amount
$sqlHighestSelling =
    "SELECT Product, TotalSales FROM (SELECT Product, SUM(CAST(REPLACE(REPLACE(Sales, '$', ''), ',', '') AS DECIMAL(10,2))) AS TotalSales FROM sales GROUP BY Product) AS t ORDER BY TotalSales DESC LIMIT 1";
$resultHighestSelling = mysqli_query($con, $sqlHighestSelling);
$rowHighestSelling = mysqli_fetch_assoc($resultHighestSelling);
$highestSellingProduct = $rowHighestSelling["Product"];
$highestSalesAmount = $rowHighestSelling["TotalSales"];

// Calculate the average sales amount across all products
$sqlAverageSales =
    "SELECT AVG(CAST(REPLACE(REPLACE(Sales, '$', ''), ',', '') AS DECIMAL(10,2))) AS AverageSales FROM sales";
$resultAverageSales = mysqli_query($con, $sqlAverageSales);
$rowAverageSales = mysqli_fetch_assoc($resultAverageSales);
$averageSalesAmount = $rowAverageSales["AverageSales"];

// Identify the month with the highest sales and the total sales amount for that month
$sqlHighestSalesMonth =
    "SELECT Month_Name, SUM(CAST(REPLACE(REPLACE(Sales, '$', ''), ',', '') AS DECIMAL(10,2))) AS TotalSales FROM sales GROUP BY Month_Name ORDER BY TotalSales DESC LIMIT 1";
$resultHighestSalesMonth = mysqli_query($con, $sqlHighestSalesMonth);
$rowHighestSalesMonth = mysqli_fetch_assoc($resultHighestSalesMonth);
$highestSalesMonth = $rowHighestSalesMonth["Month_Name"];
$highestSalesMonthTotal = $rowHighestSalesMonth["TotalSales"];

// Fetch sales information including product name, quantity sold, and total sales amount
$sqlSalesReport =
    "SELECT Product, Units_Sold, REPLACE(REPLACE(Sales, '$', ''), ',', '') AS SalesAmount FROM sales";
$resultSalesReport = mysqli_query($con, $sqlSalesReport);

// Close the database connection
mysqli_close($con);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Sales Data</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }

        table, th, td {
            border: 1px solid black;
        }
    </style>
</head>
<body>
 
    <h2>Sales Report</h2>
    <table>
        <tr>
            <th>Product</th>
            <th>Quantity Sold</th>
            <th>Total Sales</th>
        </tr>
        <?php while ($rowSalesReport = mysqli_fetch_assoc($resultSalesReport)) {
            echo "<tr>";
            echo "<td>" . $rowSalesReport["Product"] . "</td>";
            echo "<td>" . $rowSalesReport["Units_Sold"] . "</td>";
            echo "<td>$" .
                number_format((float) $rowSalesReport["SalesAmount"], 2) .
                "</td>";
            echo "</tr>";
        } ?>
    </table>
</body>
</html>
