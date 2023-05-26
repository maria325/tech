<?php
require('config.php');
// Check if the delete button is clicked
if (isset($_GET['delete_id'])) {
    $deleteID = $_GET['delete_id'];
    // Query to delete the product
    $deleteQuery = "DELETE FROM products WHERE ProductID = $deleteID";
    mysqli_query($conn, $deleteQuery);
}
// Search functionality
if (isset($_POST['search'])) {
    $searchTerm = $_POST['searchTerm'];  
    // Query to search for products
    $query = "SELECT * FROM Products WHERE 
              ProductName LIKE '%$searchTerm%' OR
              ProductBarcode LIKE '%$searchTerm%' OR
              ProductReferenceNum LIKE '%$searchTerm%'";
    $result = mysqli_query($conn, $query);
} else {
    // Query to retrieve all products records
    $query = "SELECT * FROM products";
    $result = mysqli_query($conn, $query);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="lib/table.css">
    <title>Users</title>
    <style>
        .active {
            color: green;
        }
        
        .inactive {
            color: red;
        }
        .view-button {
            background-color: blue;
            color: white;
            padding: 5px 10px;
            border-radius: 5px;
            text-decoration: none;
        }
    </style>
    </style>
</head>
<body>
    <h2>Users</h2>
    <div class="search-form">
        <form method="POST" action="">
            <input type="text" name="searchTerm" placeholder="Search">
            <button type="submit" name="search">Search</button>
        </form>
    </div>
    <div class="table-wrapper">
        <table class="fl-table">
            <thead>
                <tr>
                    <th>Product ID</th>
                    <th>Product Name</th>
                    <th>Product Barcode</th>
                    <th>Product Reference Number</th>
                    <th>Product Price</th>
                    <th>Product Wholesale Price</th>
                    <th>Product Quantity</th>
                    <th>Category ID</th>
                    <th>Currency ID</th>
                    <th>Sold this month</th>
                    <th>Operations</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Fetch and display product data
                while ($product = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>" . $product['ProductID'] . "</td>";
                    echo "<td>" . $product['ProductName'] . "</td>";
                    echo "<td>" . $product['ProductBarcode'] . "</td>";
                    echo "<td>" . $product['ProductReferenceNum'] . "</td>";
                    echo "<td>" . $product['ProductPrice'] . "</td>";
                    echo "<td>" . $product['ProductWholesalePrice'] . "</td>";
                    echo "<td>" . $product['ProductQuantity'] . "</td>";
                    echo "<td>" . $product['CategoryID'] . "</td>";
                    echo "<td>" . $product['CurrencyID'] . "</td>";
                    echo "<td>" . $product['Sold_This_Month'] . "</td>";
                    echo "<td>
                            <a href='editproducts.php?id=" . $product['ProductID'] . "' class='edit-button'>Edit</a>
                            <a href='?delete_id=" . $product['ProductID'] . "' class='delete-button'>Delete</a>
                            <a  href='" . $product['ProductImage'] . "' target='_blank' class='view-button'>View Product</a>
                        </td>";
                    echo "</tr>";
                }
                // Display a message if no products are found
                if (mysqli_num_rows($result) === 0 && isset($_POST['search'])) {
                    echo "<tr><td colspan='8'>No products found.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>
