<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Top 5 Products/Services Section</title>
  </head>
  <body>
	<h1>Top 5 Products/Services Section</h1>

<?php
$servername = "localhost";
$username = "wxldvwmy_cmpe272team";
$password = "cmpe272team";
$dbname = "wxldvwmy_marketplaceDB";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT productName, vendorName, AVG(rating) AS avg_rating
FROM review
GROUP BY productName
ORDER BY avg_rating DESC
LIMIT 5";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
  echo("<h2>TOP 5 PRODUCTS/SERVICES IN THE WHOLE MARKETPLACE BASED ON AVERAGE RATING</h2>");
  $count = 1;
  while($row = $result->fetch_assoc()) {
    echo $count."."."<br>";
    echo "Product Name: ".$row['productName']."<br>";
    echo "Vendor Name: ".$row['vendorName']."<br>";
    echo "Average Rating: ".$row['avg_rating']."<br>";
    echo("<br><br>");
    $count = $count+1;
  }
} else 
{
  echo "No results";
}

echo("<h2>TOP 5 PRODUCTS/SERVICES BY INDIVIDUAL VENDOR BASED ON AVERAGE RATING</h2>");




$sql = "SELECT t1.vendorName, t1.productName, t1.avg_rating FROM ( SELECT vendorName, productName, AVG(rating) AS avg_rating FROM review GROUP BY vendorName, productName ) t1 WHERE ( SELECT COUNT(*) FROM ( SELECT vendorName, productName, AVG(rating) AS avg_rating FROM review GROUP BY vendorName, productName ) t2 WHERE t2.vendorName = t1.vendorName AND t2.avg_rating > t1.avg_rating ) < 5 ORDER BY t1.vendorName, t1.avg_rating DESC";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
  $count = 1;
  $vendorName = " ";
  while($row = $result->fetch_assoc()) {
    if ($count == 1)
    {
        echo "<h3>"."Vendor: ".$row['vendorName']."</h3>";
    }
    echo $count."."."<br>";
    echo "Product Name: ".$row['productName']."<br>";
    echo "Vendor Name: ".$row['vendorName']."<br>";
    echo "Average Rating: ".$row['avg_rating']."<br>";
    echo("<br><br>");
    $count = $count+1;
    if ($count == 6)
    {
        echo "<br>----------------------------------------<br>";
        $count = 1;
    }
  }
} else {
  echo "No results";
}

$conn->close();
?>




  </body>
</html>