<?php include 'connection.php'; ?>
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

        <main>



            <?php
$query = "SELECT * FROM product WHERE p_category = 'new arrival'";
$stmt = $pdo->query($query);
$featuredProducts = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

            <section class="category-section">
                <h1 class="category-title">new arrival</h1>
                <div class="products">
                    <?php if (!empty($featuredProducts)): ?>
                    <?php foreach ($featuredProducts as $product): ?>
                    <div class="product">
                        <a href="pro_details.php?id=<?= ($product['p_id']) ?>" class="product-link">
                            <img src="<?= ($product['p_photo']) ?>" alt="<?= ($product['p_name']) ?>" />
                            <h3><?= ($product['p_name']) ?></h3>
                            <p><?= ($product['p_description']) ?></p>
                            <p>Price: $<?= ($product['p_price']) ?></p>
                        </a>
                    </div>
                    <?php endforeach; ?>
                    <?php else: ?>
                    <p>No products found in the 'new arrival' category.</p>
                    <?php endif; ?>
                </div>
            </section>






            <?php
$query = "SELECT * FROM product WHERE p_category = 'on sale'";
$stmt = $pdo->query($query);
$featuredProducts = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

            <section class="category-section">
                <h1 class="category-title">on sale</h1>
                <div class="products">
                    <?php if (!empty($featuredProducts)): ?>
                    <?php foreach ($featuredProducts as $product): ?>
                    <div class="product">
                        <a href="pro_details.php?id=<?= ($product['p_id']) ?>" class="product-link">
                            <img src="<?= ($product['p_photo']) ?>" alt="<?= ($product['p_name']) ?>" />
                            <h3><?= ($product['p_name']) ?></h3>
                            <p><?= ($product['p_description']) ?></p>
                            <p>Price: $<?= ($product['p_price']) ?></p>
                        </a>
                    </div>
                    <?php endforeach; ?>
                    <?php else: ?>
                    <p>No products found in the 'on sale' category.</p>
                    <?php endif; ?>
                </div>
            </section>



            <?php
$query = "SELECT * FROM product WHERE p_category = 'featured'";
$stmt = $pdo->query($query);
$featuredProducts = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

            <section class="category-section">
                <h1 class="category-title">featured</h1>
                <div class="products">
                    <?php if (!empty($featuredProducts)): ?>
                    <?php foreach ($featuredProducts as $product): ?>
                    <div class="product">
                        <a href="pro_details.php?id=<?= ($product['p_id']) ?>" class="product-link">
                            <img src="<?= ($product['p_photo']) ?>" alt="<?= ($product['p_name']) ?>" />
                            <h3><?= ($product['p_name']) ?></h3>
                            <p><?= ($product['p_description']) ?></p>
                            <p>Price: $<?= ($product['p_price']) ?></p>
                        </a>
                    </div>
                    <?php endforeach; ?>
                    <?php else: ?>
                    <p>No products found in the 'featured' category.</p>
                    <?php endif; ?>
                </div>
            </section>


            <?php
$query = "SELECT * FROM product WHERE p_category = 'high demand'";
$stmt = $pdo->query($query);
$featuredProducts = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

            <section class="category-section">
                <h1 class="category-title">high demand</h1>
                <div class="products">
                    <?php if (!empty($featuredProducts)): ?>
                    <?php foreach ($featuredProducts as $product): ?>
                    <div class="product">
                        <a href="pro_details.php?id=<?= ($product['p_id']) ?>" class="product-link">
                            <img src="<?= ($product['p_photo']) ?>" alt="<?= ($product['p_name']) ?>" />
                            <h3><?= ($product['p_name']) ?></h3>
                            <p><?= ($product['p_description']) ?></p>
                            <p>Price: $<?= ($product['p_price']) ?></p>
                        </a>
                    </div>
                    <?php endforeach; ?>
                    <?php else: ?>
                    <p>No products found in the 'high demand' category.</p>
                    <?php endif; ?>
                </div>
            </section>



            <?php
$query = "SELECT * FROM product WHERE p_category = 'normal'";
$stmt = $pdo->query($query);
$featuredProducts = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

            <section class="category-section">
                <h1 class="category-title">normal</h1>
                <div class="products">
                    <?php if (!empty($featuredProducts)): ?>
                    <?php foreach ($featuredProducts as $product): ?>
                    <div class="product">
                        <a href="pro_details.php?id=<?= ($product['p_id']) ?>" class="product-link">
                            <img src="<?= ($product['p_photo']) ?>" alt="<?= ($product['p_name']) ?>" />
                            <h3><?= ($product['p_name']) ?></h3>
                            <p><?= ($product['p_description']) ?></p>
                            <p>Price: $<?= ($product['p_price']) ?></p>
                        </a>
                    </div>
                    <?php endforeach; ?>
                    <?php else: ?>
                    <p>No products found in the 'normal' category.</p>
                    <?php endif; ?>
                </div>
            </section>
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