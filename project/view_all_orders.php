<?php
session_start();
include 'connection.php'; 

// Check if the user is an employee
// if (!isset($_SESSION['user_email']) || $_SESSION['user_role'] !== 'employee') {
//     header('Location: login.php');
//     exit;
// }

$sql = "SELECT o.order_id, o.date, o.status, o.process_status, c.c_name, c.email,
               GROUP_CONCAT(p.p_name SEPARATOR ', ') AS product_names,
               GROUP_CONCAT(oi.quantity SEPARATOR ', ') AS product_quantities,
               SUM(p.p_price * oi.quantity) AS total_amount
        FROM orders o
        JOIN customers c ON o.customer_id = c.customer_id
        JOIN order_items oi ON o.order_id = oi.order_id
        JOIN product p ON oi.p_id = p.p_id
        GROUP BY o.order_id
        ORDER BY o.date DESC";
$stmt = $pdo->query($sql);
$all_orders = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
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
            <h1>All Orders</h1>
            <table class="orders-table">
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Date</th>
                        <th>Customer Name</th>
                        <th>Customer Email</th>
                        <th>Products</th>
                        <th>Total Amount</th>
                        <th>Status</th>
                        <th>click to process</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($all_orders as $order): ?>
                    <tr>
                        <td><?= ($order['order_id']) ?></td>
                        <td><?= ($order['date']) ?></td>
                        <td><?= ($order['c_name']) ?></td>
                        <td><?= ($order['email']) ?></td>
                        <td><?= ($order['product_names']) ?>
                            (<?= ($order['product_quantities']) ?>)</td>
                        <td>$<?= ($order['total_amount']) ?></td>
                        <td><?= $order['status'] == 1 ? 'Confirmed' : ($order['status'] == 'charged' ? 'Charged' : 'Not Confirmed') ?>
                        </td>

                        <td>

                            <?php if ($order['status'] == 1 && $order['process_status'] != 'charged'): ?>
                            <a href="order_process.php?order_id=<?= $order['order_id'] ?>">Process</a>
                            <?php elseif ($order['status'] == 1 && $order['process_status'] == 'charged'): ?>
                            Charged
                            <?php else: ?>
                            Pending
                            <?php endif; ?>
                        </td>


                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <?php if (isset($_SESSION['message'])): ?>
            <div class="message">
                <?= $_SESSION['message']; ?>
            </div>
            <?php unset($_SESSION['message']); ?>
            <?php endif; ?>

            <?php if (isset($_SESSION['error'])): ?>
            <div class="error">
                <?= $_SESSION['error']; ?>
            </div>
            <?php unset($_SESSION['error']); ?>
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