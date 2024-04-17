<?php
session_start();
include 'connection.php';

if (!isset($_SESSION['customer_id'])) {
    echo "Please <a href='login.php'>login</a> to view your orders.";
    exit;
}

$customer_id = $_SESSION['customer_id'];

$stmt = $pdo->prepare("SELECT o.order_id, o.date, o.status, oi.p_id, p.p_name, p.p_price, oi.quantity FROM orders o
JOIN order_items oi ON o.order_id = oi.order_id
JOIN product p ON oi.p_id = p.p_id
WHERE o.customer_id = :customer_id
ORDER BY o.order_id DESC");
$stmt->execute(['customer_id' => $customer_id]);
$orders = $stmt->fetchAll(PDO::FETCH_ASSOC);

$totalPriceConfirmedItems = 0; // Initialize the total price of confirmed items
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

        <main>
            <h1>Your Orders</h1>
            <?php if (!empty($orders)): ?>
            <table>
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Date</th>
                        <th>Status</th>
                        <th>Product ID</th>
                        <th>Title</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Update</th>
                        <th>Remove</th>
                        <th>Confirm</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($orders as $order): ?>
                    <?php 
                        // If the order is confirmed, add the price * quantity to the total
                        if ($order['status']) {
                            $totalPriceConfirmedItems += $order['p_price'] * $order['quantity'];
                        }
                        ?>
                    <tr>
                        <td><?= ($order['order_id']); ?></td>
                        <td><?= ($order['date']); ?></td>
                        <td><?= $order['status'] ? 'Confirmed' : 'Unconfirmed'; ?></td>
                        <td><?= ($order['p_id']); ?></td>
                        <td><?= ($order['p_name']); ?></td>
                        <td>$<?= ($order['p_price']); ?></td>
                        <td><?= ($order['quantity']); ?></td>
                        <td>
                            <?php if (!$order['status']): ?>
                            <form action="update_order.php" method="post">
                                <input type="hidden" name="order_id" value="<?= $order['order_id']; ?>">
                                <input type="hidden" name="p_id" value="<?= $order['p_id']; ?>">
                                <input type="number" name="quantity" value="<?= $order['quantity']; ?>" min="0">
                                <button type="submit">Update</button>
                            </form>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if (!$order['status']): ?>
                            <a
                                href="remove_item.php?order_id=<?= $order['order_id']; ?>&p_id=<?= $order['p_id']; ?>">Remove</a>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if (!$order['status']): ?>
                            <form action="confirm_order.php" method="post">
                                <input type="hidden" name="order_id" value="<?= $order['order_id']; ?>">
                                <button type="submit" name="confirm_order">Confirm</button>
                            </form>
                            <?php else: ?>
                            Confirmed
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <p>Total Price of Confirmed Items: $<?= number_format($totalPriceConfirmedItems, 2); ?></p>

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
            <?php else: ?>
            <p>You have no orders.</p>
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