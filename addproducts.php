<?php
session_start();
if (!isset($_SESSION['Username']) && !isset($_SESSION['RolesID']) && !isset($_SESSION['PermissionID'])) {
    // User is not logged in, redirect to the login page
    header('Location: login.php');
    exit;
}
$error = '';
require_once 'config.php';
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Retrieve the product information
    $productName = $_POST["ProductName"];
    $productbarcode = $_POST["ProductBarcode"];
    $productreferencenumber = $_POST["ProductReferenceNum"];
    $price = $_POST["ProductPrice"];
    $productwholesaleprice = $_POST["ProductWholesalePrice"];
    $productquantity = $_POST["ProductQuantity"];
    $target_dir = "imgs/";
    $target_file = $target_dir . basename($_FILES["ProductImage"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    $check = getimagesize($_FILES["ProductImage"]["tmp_name"]);
    if ($check !== false) {
        $error = "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        $error = "File is not an image.";
        $uploadOk = 0;
    }

    // Check if file already exists
    if (file_exists($target_file)) {
        $error = "Sorry, file already exists.";
        $uploadOk = 0;
    }
    // Check file size
    if ($_FILES["ProductImage"]["size"] > 500000) {
        $error = "Sorry, your file is too large.";
        $uploadOk = 0;
    }
    // Allow certain file formats
    if (
        $imageFileType != "jpg" &&
        $imageFileType != "png" &&
        $imageFileType != "jpeg" &&
        $imageFileType != "gif"
    ) {
        $error = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }
    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        $error ="Sorry, your file was not uploaded.";
    } else {
        if (move_uploaded_file($_FILES["ProductImage"]["tmp_name"], $target_file)) {
            echo "The file " . htmlspecialchars(basename($_FILES["ProductImage"]["name"])) . " has been uploaded.";
            // Set the $productImage variable to the uploaded file name
            $productImage = basename($_FILES["ProductImage"]["name"]);

            // Perform the database insertion
            $sql = "INSERT INTO products (ProductName, ProductBarcode, ProductReferenceNum, ProductImage, ProductPrice, ProductWholesalePrice, ProductQuantity) 
                    VALUES ('$productName', '$productbarcode', '$productreferencenumber', '$productImage', '$price', '$productwholesaleprice', '$productquantity')";
            $conn->query($sql);
        } else {
            $error = "Sorry, there was an error uploading your file.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!----======== CSS ======== -->
    <link rel="stylesheet" href="lib\product.css">
    <!----===== Iconscout CSS ===== -->
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    <!----======== JavaScript ======== -->
    <script src="script.js"></script>
    <title>Registration Form</title>
</head>
<style>
        /* Slide-in animation */
        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateX(-100%);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }
        .container {
            animation: slideIn 0.5s ease;
        }
    </style>
<body  style="background-image: url('pexels-laura-tancredi-7078666 (2).jpg');">
    <div class="container">
        <header>Add Product</header>
        <form action="" method="POST" onsubmit="return validateForm(event)" enctype="multipart/form-data">
            <div class="form first">
                <div class="details personal">

                    <div class="fields">
                        <div class="input-field">
                            <label>Product Name</label>
                            <input type="text" name="ProductName" id="ProductName" placeholder="Enter Product Name" required>
                        </div>
                        <div class="input-field">
                            <label>Product Barcode</label>
                            <input type="text" name="ProductBarcode" id="ProductBarcode" placeholder="Enter Product Barcode" required>
                        </div>
                        <div class="input-field">
                            <label>Product Reference Number</label>
                            <input type="text" name="ProductReferenceNum" placeholder="Enter Product Reference Number" required>
                        </div>
                        <div class="input-field">
                            <label>Product Image</label>
                            <input type="file" name="ProductImage" placeholder="Enter Product Image" required>
                        </div>
                        <div class="input-field">
                            <label>Product WholeSale Price</label>
                            <input type="text" name="ProductWholesalePrice" placeholder="Enter Product WholeSale Price" required>
                        </div>
                        <div class="input-field">
                            <label>Product Price</label>
                            <input type="text" name="ProductPrice" placeholder="Enter Product Price" required>
                        </div>
                        <div class="input-field">
                            <label>Product Quantity</label>
                            <input type="text" name="ProductQuantity" placeholder="Enter Product Quantity" required>
                        </div>
                        <!-- add category -->
                        <!-- Add currency -->
                        <!-- Permissions checkboxes section -->
                        <button type="submit">Add Product</button>
                    </div>
                </div>
            </div>
        </form>
        <script src="script.js"></script>
    </div>
</body>
</html>
