<!DOCTYPE html>
<html>
<head>
  <title>CSV Upload</title>
  
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f2f2f2;
      margin: 0;
      padding: 20px;
    }

    h1 {
      text-align: center;
    }

    .container {
      max-width: 800px;
      margin: 0 auto;
      background-color: #fff;
      padding: 20px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    table {
      width: 100%;
      border-collapse: collapse;
    }

    th, td {
      padding: 10px;
      text-align: left;
      border-bottom: 1px solid #ddd;
    }

    th {
      background-color: #f2f2f2;
    }

    .btn {
      display: inline-block;
      padding: 10px 20px;
      background-color: #4CAF50;
      color: #fff;
      text-decoration: none;
      border-radius: 4px;
      transition: background-color 0.3s;
    }

    .btn:hover {
      background-color: #45a049;
    }
    .sales{
      cursor: pointer;
    }
  </style>
</head>
<body>
  <div class="container">
    <h1>Rannlab Project</h1>
    <form method="post" action="func.php" enctype="multipart/form-data">
      <input type="file" name="csv_file" id="csv_file" accept=".csv" />
      <input type="submit" name="import" value="CSV Import" class="btn" />
    </form>
    <h2>CSV Data Import</h2>
    <a href="total_sales.php"><button class="btn sales" >Show Sales Data</button></a>
    <a href="sales_report.php"><button class="btn sales" >Show Sales Report</button></a>
    <a href="sales_chart.php"><button class="btn sales" >Show Sales Chart</button></a>
  </div>
  
 
  
  <div id="totalSalesData">
    <!-- Existing table code goes here -->
    <?php include "func.php"; ?>
    
</div>

</body>

</html>

