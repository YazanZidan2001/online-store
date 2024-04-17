<?php
include 'connection.php';

$product_name = isset($_GET['product_name']) ? $_GET['product_name'] : '';
$min_price = isset($_GET['min_price']) ? floatval($_GET['min_price']) : 0;
$max_price = isset($_GET['max_price']) ? floatval($_GET['max_price']) : PHP_INT_MAX;
$selectedIds = isset($_GET['shortlist']) ? $_GET['shortlist'] : [];

$query = "SELECT * FROM product WHERE 1 = 1"; // easy to add another option

// $query .= " AND p_name LIKE :product_name";
// $query .= " AND p_price >= :min_price";
// $query .= " AND p_price <= :max_price";
// $query .= " AND p_id IN (" . implode(',', array_map('intval', $selectedIds)) . ")";


if (!empty($product_name)) {
    $query .= " AND p_name LIKE :product_name";
}

if (!empty($_GET['min_price'])) {
    $query .= " AND p_price >= :min_price";
}

if (!empty($_GET['max_price'])) {
    $query .= " AND p_price <= :max_price";
}
if (isset($_GET['filter']) && !empty($selectedIds)) {
    $query .= " AND p_id IN (" . implode(',', array_map('intval', $selectedIds)) . ")";
}

$stmt = $pdo->prepare($query);

if (!empty($product_name)) {
    $product_name = "%".$product_name."%";
    $stmt->bindParam(':product_name', $product_name);
}

if (!empty($_GET['min_price'])) {
    $stmt->bindParam(':min_price', $min_price);
}

if (!empty($_GET['max_price'])) {
    $stmt->bindParam(':max_price', $max_price);
}

$stmt->execute();

$products = $stmt->fetchAll(PDO::FETCH_ASSOC);


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
            <a href="logout.php">Login/Register</a>
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
            <section class="product_search">
                <form action="search_product.php" method="get" class="product-filter-form">
                    <button type="submit" name="filter">Filter</button>
                    <table>
                        <thead>
                            <tr>
                                <th></th>
                                <th>Photo</th>
                                <th>Reference Number</th>
                                <th>Price</th>
                                <th>Category</th>
                                <th>Quantity</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($products): ?>
                            <?php foreach ($products as $product): ?>
                            <tr class="<?php echo ($product['p_category']); ?>">
                                <td><input type="checkbox" name="shortlist[]" value="<?php echo ($product['p_id']); ?>">
                                </td>
                                <td><img src="<?php echo ($product['p_photo']); ?>" alt="Product Image"
                                        style="width: 70px; height: auto;"></td>
                                <td><a
                                        href="pro_details.php?id=<?php echo ($product['p_id']); ?>"><?php echo ($product['p_id']); ?></a>
                                </td>
                                <td><?php echo ($product['p_price']); ?></td>
                                <td><?php echo ($product['p_category']); ?></td>
                                <td><?php echo ($product['p_quantity']); ?></td>
                            </tr>
                            <?php endforeach; ?>
                            <?php else: ?>
                            <tr>
                                <td colspan="6">No products found.</td>
                            </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>

                </form>

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