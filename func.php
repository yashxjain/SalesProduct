<?php
include "db.php";
$con = getdb();

if (isset($_POST["import"])) {
    if (
        isset($_FILES["csv_file"]) &&
        $_FILES["csv_file"]["error"] === UPLOAD_ERR_OK
    ) {
        $fileTmpPath = $_FILES["csv_file"]["tmp_name"];
        $fileName = $_FILES["csv_file"]["name"];

        $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        $allowedExtensions = ["csv"];

        if (in_array($fileExtension, $allowedExtensions)) {
            $uploadDir = "uploads/";
            $destPath = $uploadDir . $fileName;

            if (move_uploaded_file($fileTmpPath, $destPath)) {

                $csvData = file_get_contents($destPath);

                $csvRows = explode(PHP_EOL, $csvData);
                foreach ($csvRows as $row) {
                    $rowData = str_getcsv($row);
                    $Segment = $rowData[0];
                    $Country = $rowData[1];
                    $Product = $rowData[2];
                    $Discount_Band = $rowData[3];
                    $Units_Sold = $rowData[4];
                    $Manufacturing_Price = $rowData[5];
                    $Sale_Price = $rowData[6];
                    $Gross_Sales = $rowData[7];
                    $Discounts = $rowData[8];
                    $Sales = $rowData[9];
                    $COGS = $rowData[10];
                    $Profit = $rowData[11];
                    $Date = $rowData[12];
                    $Month_Number = $rowData[13];
                    $Month_Name = $rowData[14];
                    $Year = $rowData[15];

                    $sql = "INSERT INTO sales (Segment, Country, Product, Discount_Band, Units_Sold, Manufacturing_Price, Sale_Price, Gross_Sales, Discounts, Sales, COGS, Profit, Date, Month_Number, Month_Name, Year)
                    VALUES
                         ('$Segment', '$Country', '$Product', '$Discount_Band', '$Units_Sold', '$Manufacturing_Price', '$Sale_Price', '$Gross_Sales', '$Discounts', '$Sales','$COGS', '$Profit', '$Date', '$Month_Number', '$Month_Name', '$Year' )";
                    mysqli_query($con, $sql);
                }

                header("Location: index.php");
                exit();
            } else {
                echo "Error moving the uploaded file.";
            }
        } else {
            echo "Invalid file format. Only CSV files are allowed.";
        }
    } else {
        echo "Error uploading the file.";
    }
}

$sql = "SELECT * FROM sales";
$result = mysqli_query($con, $sql);

mysqli_close($con);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Rannlab Project</title>
    <style>
        table {
            border-collapse: collapse;
        }

        table, th, td {
            border: 1px solid black;
            padding: 5px;
        }
    </style>
</head>
<body>

    <table>
        <tr>
            <th>Segment</th>
            <th>Country</th>
            <th>Product</th>
            <th>Discount Band</th>
            <th>Units Sold</th>
            <th>Manufacturing Price</th>
            <th>Sale Price</th>
            <th>Gross Sales</th>
            <th>Discounts</th>
            <th>Sales</th>
            <th>COGS</th>
            <th>Profit</th>
            <th>Date</th>
            <th>Month Number</th>
            <th>Month Name</th>
            <th>Year</th>
        </tr>
        <?php while ($row = mysqli_fetch_assoc($result)): ?>
            <tr>
                <td><?php echo $row["Segment"]; ?></td>
                <td><?php echo $row["Country"]; ?></td>
                <td><?php echo $row["Product"]; ?></td>
                <td><?php echo $row["Discount_Band"]; ?></td>
                <td><?php echo $row["Units_Sold"]; ?></td>
                <td><?php echo $row["Manufacturing_Price"]; ?></td>
                <td><?php echo $row["Sale_Price"]; ?></td>
                <td><?php echo $row["Gross_Sales"]; ?></td>
                <td><?php echo $row["Discounts"]; ?></td>
                <td><?php echo $row["Sales"]; ?></td>
                <td><?php echo $row["COGS"]; ?></td>
                <td><?php echo $row["Profit"]; ?></td>
                <td><?php echo $row["Date"]; ?></td>
                <td><?php echo $row["Month_Number"]; ?></td>
                <td><?php echo $row["Month_Name"]; ?></td>
                <td><?php echo $row["Year"]; ?></td>
            </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>
<?php
