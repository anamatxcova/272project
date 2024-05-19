<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CMPE 272 Marketplace</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        .container {
            max-width: 800px;
            margin: 20px auto;
            padding: 0 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            color: #333;
            padding-top: 20px;
        }

        .tabs {
            display: flex;
            justify-content: center;
            margin-bottom: 20px;
        }

        .tab {
            padding: 10px 20px;
            background-color: #f0f0f0;
            border: 1px solid #ccc;
            border-bottom: none;
            cursor: pointer;
        }

        .tab:hover {
            background-color: #e0e0e0;
        }

        .tab.active {
            background-color: #fff;
            border-bottom: 1px solid #fff;
        }

        .product-list {
            list-style-type: none;
            padding: 0;
            margin: 0;
        }

        .product {
            background-color: #fafafa;
            padding: 20px;
            margin-bottom: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .product h3 {
            margin-top: 0;
            color: #333;
        }

        .product p {
            margin: 10px 0;
            color: #666;
        }

        .product a {
            text-decoration: none;
            color: #007bff;
            font-weight: bold;
        }

        .product a:hover {
            text-decoration: underline;
        }

        /* Navbar styles */
        .navbar {
            background-color: #333;
            color: #fff;
            padding: 10px 0;
        }

        .container .logo {
            margin: 0 auto;
            text-align: center;
            font-size: 24px;
            font-weight: bold;
        }

        .container .nav-links {
            list-style: none;
            padding: 0;
            margin: 0;
            text-align: center;
        }

        .container .nav-links li {
            display: inline-block;
            margin-left: 20px;
        }

        .container .nav-links li:first-child {
            margin-left: 0;
        }

        .container .nav-links li a {
            color: #000; /* changed to black */
            text-decoration: none;
            font-size: 18px;
        }

        .container .nav-links li a:hover {
            text-decoration: underline;
        }

        .logout-btn {
            background-color: #ff0000;
            color: #fff;
            padding: 8px 16px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .logout-btn:hover {
            background-color: #cc0000;
        }
    </style>
</head>
<body>

<nav class="navbar">
    <div class="container">
        <h1 class="logo">CMPE 272 Marketplace</h1>
        <ul class="nav-links">
            <li><a href="home.php">Homepage</a></li>
            <li><a href="top5.php">Top 5</a></li>
            <li><a href="login.php">Login</a></li>
            <li><a href="signup.php">Sign Up</a></li>
            <li><a href="products.php">Products</a></li>
            <li><button class="logout-btn">Logout</button></li>
        </ul>
    </div>
</nav>

<div class="container">
    <h1>Product List</h1>

    <!-- Tabs -->
    <div class="tabs">
        <div class="tab active" data-category="all">All Products</div>
        <!-- Add more tabs here if needed -->
    </div>

    <!-- Product List -->
    <?php
    $conn = new mysqli("marketplace272.space", "wxldvwmy_cmpe272team", "cmpe272team", "wxldvwmy_marketplaceDB");
    if ($conn->connect_error) {
        die(error_Msg());
    }

    $sql = "SELECT name, vendorName, link FROM product LIMIT 40"; // assuming 'product' is the table name
    $result = $conn->query($sql);
    $counter = 1; // Counter for generating unique IDs

    if ($result->num_rows > 0) {
        // output data of each row
        while($row = $result->fetch_assoc()) {
            echo "<div class='product' id='product_" . $counter . "'>";
            echo "<h3>" . $row["name"] . "</h3>";
            echo "<p>Vendor: " . $row["vendorName"] . "</p>";
            echo "<p><a href='" . $row["link"] . "'>View Details</a></p>";
            echo "</div>";
            $counter++;
        }
    } else {
        echo "<p>No products found</p>";
    }

    $conn->close();

    function error_Msg() {
        return "Connection failed: " . $conn->connect_error;
    }
    ?>
</div>

</body>
</html>
