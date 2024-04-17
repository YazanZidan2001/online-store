<?php
include 'connection.php';
session_start();
$product_id = isset($_GET['id']) ? $_GET['id'] : '';

$product = null;
if ($product_id != '') {
    $stmt = $pdo->prepare("SELECT * FROM product WHERE p_id = :product_id");
    $stmt->bindParam(':product_id', $product_id);
    $stmt->execute();
    $product = $stmt->fetch(PDO::FETCH_ASSOC);
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

    <div class="container">

        <nav>
            <form action="search_pro.php" method="get" class="search-form">
                <input type="text" name="product_name" placeholder="Enter product name">
                <input type="number" name="min_price" placeholder="Min price" min="0">
                <input type="number" name="max_price" placeholder="Max price" min="0">
                <button type="submit">Search</button>
            </form>
            <a href="add_product.php" class="button-style">Add Product</a>
            <a href="view_all_orders.php" class="button-style">View an Order</a>
        </nav>


        <main class="product_details">


            <?php if ($product): ?>
            <div class='product-detail'>
                <div class='product-image'>
                    <img src='<?php echo ($product["p_photo"]); ?>' alt='<?php echo ($product["p_name"]); ?>' />
                </div>
                <div class='product-info'>
                    <h1><?php echo ($product["p_name"]); ?></h1>
                    <p>Description: <?php echo ($product["p_description"]); ?></p>
                    <p>Category: <?php echo ($product["p_category"]); ?></p>
                    <p>Price: $<?php echo ($product["p_price"]); ?></p>
                    <p>Remarks: <?php echo ($product["p_remarks"]); ?></p>
                    <p>Quantity Available: <?php echo ($product["p_quantity"]); ?></p>
                    <a href="update_product.php?id=<?php echo ($product["p_id"]); ?>" class="button-style">Update
                        Product</a>

                </div>
            </div>
            <?php else: ?>
            <p><?php echo $product_id != '' ? "Product not found" : "No product specified"; ?></p>
            <?php endif; ?>

        </main>

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