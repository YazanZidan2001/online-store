<?php
include 'connection.php';
session_start();


if (isset($_SESSION['confirmation_up'])) {
    echo "<div class='confirmation-msg'>" . $_SESSION['confirmation_up'] . "</div>";
    unset($_SESSION['confirmation_up']);
}


$product_id = isset($_GET['id']) ? $_GET['id'] : '';

$product = null;
if ($product_id != '') {
    $stmt = $pdo->prepare("SELECT * FROM product WHERE p_id = :product_id");
    $stmt->bindParam(':product_id', $product_id);
    $stmt->execute();
    $product = $stmt->fetch(PDO::FETCH_ASSOC);
}

if (!$product) {
    echo "Product not found.";
    exit;
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






<body>
    <div class="add-product">
        <h2>Update Product</h2>
        <form action="process_update_product.php" method="post" enctype="multipart/form-data" class="add-product-form">
            <input type="hidden" name="p_id" value="<?php echo ($product['p_id']); ?>">

            <label for="pname">Product Name:</label>
            <input type="text" id="pname" name="p_name" required value="<?php echo ($product['p_name']); ?>">

            <label for="pdesc">Product Description:</label>
            <textarea id="pdesc" name="p_description" required><?php echo ($product['p_description']); ?></textarea>

            <label for="pcategory">Category:</label>
            <select id="pcategory" name="p_category" required>
                <option value="new arrival" <?php echo $product['p_category'] == 'new arrival' ? 'selected' : ''; ?>>New
                    Arrival</option>
                <option value="on sale" <?php echo $product['p_category'] == 'on sale' ? 'selected' : ''; ?>>On Sale
                </option>
                <option value="featured" <?php echo $product['p_category'] == 'featured' ? 'selected' : ''; ?>>
                    Featured
                </option>
                <option value="high demand" <?php echo $product['p_category'] == 'high demand' ? 'selected' : ''; ?>>
                    High Demand</option>
                <option value="normal" <?php echo $product['p_category'] == 'normal' ? 'selected' : ''; ?>>Normal
                </option>
            </select>

            <label for="pprice">Price:</label>
            <input type="number" id="pprice" name="p_price" required value="<?php echo ($product['p_price']); ?>">

            <label for="pquantity">Quantity:</label>
            <input type="number" id="pquantity" name="p_quantity" required
                value="<?php echo ($product['p_quantity']); ?>">

            <label for="premarks">Remarks (optional):</label>
            <input type="text" id="premarks" name="p_remarks" value="<?php echo ($product['p_remarks']); ?>">

            <label for="pimage">Product Image (optional):</label>
            <input type="file" id="pimage" name="p_photo">
            <small>Current Image: <?php echo ($product['p_photo']); ?></small>

            <button type="submit" name="update_product">Update Product</button>
        </form>
    </div>
</body>




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

</html>