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
            <a href="home.php">Home</a>
            <a href="about.php">About Us</a>
            <a href="view_orders.php">Shopping Basket</a>
        </div>

        <?php
        if (isset($_SESSION['customer_name'])) {
            echo "<span>Welcome " . ($_SESSION['customer_name']) . "</span>";
            echo "<a href='logout.php'>Logout</a>";
        } else {
            echo "<a href='login.php'>Login/Register</a>";
        }
        ?>
    </header>


    <div class="container">

        <nav>
            <form action="search_product.php" method="get" class="search-form">
                <input type="text" name="product_name" placeholder="Enter product name">
                <input type="number" name="min_price" placeholder="Min price" min="0">
                <input type="number" name="max_price" placeholder="Max price" min="0">
                <button type="submit">Search</button>
            </form>
            <a href="view_orders.php" class="button-style">view orders</a>

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

                    <form action='add_to_order.php' method='post'>
                        <input type="hidden" name="product_id" value="<?php echo $product['p_id']; ?>">
                        <label for='quantity'>Quantity:</label>
                        <input type='number' id='quantity' name='quantity' min='1'
                            max='<?php echo ($product["p_quantity"]); ?>' value='1' required />
                        <!-- <input type='hidden' name='product_id' value='<?php echo ($product["p_id"]); ?>' /> -->
                        <button type='submit' class='add-to-order-button'>Add to Order</button>
                    </form>
                </div>
            </div>
            <?php else: ?>
            <p><?php echo $product_id != '' ? "Product not found" : "No product specified"; ?></p>
            <?php endif; ?>

            <?php if (isset($_GET['success'])): ?>
            <p>Item added to order successfully</p>
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