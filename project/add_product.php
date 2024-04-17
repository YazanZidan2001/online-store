<?php
session_start(); 

if (isset($_SESSION['confirmation'])) {
    echo "<div class='confirmation-msg'>" . $_SESSION['confirmation'] . "</div>";
    unset($_SESSION['confirmation']);
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="shortcut icon" href="img/logo.png" type="image/x-icon">
    <title>web project</title>
</head>

<body>
    <header>
        <div class="header-logo">
            <img src="img/logo.png" alt="E-Store Logo">
        </div>
        <div class="header-links">
            <a href="employee_page.php">Home</a>
            <a href="about.php">About Us</a>
            <a href="logout.php">logout</a>
        </div>
    </header>




    <div class="add-product">
        <h2>Add New Product</h2>
        <form action="process_add_product.php" method="post" enctype="multipart/form-data" class="add-product-form">
            <label for="pname">Product Name:</label>
            <input type="text" id="pname" name="p_name" required>

            <label for="pdesc">Product Description:</label>
            <textarea id="pdesc" name="p_description" required></textarea>


            <label for="pcategory">Category:</label>
            <select id="pcategory" name="p_category" required>
                <option value="new arrival">New Arrival</option>
                <option value="on sale">On Sale</option>
                <option value="featured">Featured</option>
                <option value="high demand">High Demand</option>
                <option value="normal">Normal</option>
            </select>

            <label for="pprice">Price:</label>
            <input type="number" id="pprice" name="p_price" required>

            <label for="pquantity">Quantity:</label>
            <input type="number" id="pquantity" name="p_quantity" required>

            <label for="premarks">Remarks:</label>
            <input type="text" id="premarks" name="p_remarks">

            <label for="pimage">Product Image:</label>
            <input type="file" id="pimage" name="p_photo" required>

            <button type="submit" name="submit">Add Product</button>
        </form>
    </div>


    <footer>
        <div class="footer-logo">
            <img src="img/logo.png" alt="E-Store Logo">
        </div>
        <div class="footer-info">
            <p>nablus</p>
            <p>Email: contact@yazanstore.com | Tel: 0599050309</p>
        </div>
        <div class="footer-links">
            <a href="contact.php">Contact Us</a>
        </div>
    </footer>

</body>

</html>