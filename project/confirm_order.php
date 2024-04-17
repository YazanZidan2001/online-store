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
    <?php
session_start();
include 'connection.php';

// Ensure the user is logged in
if (!isset($_SESSION['customer_id'])) {
    echo "Please <a href='login.php'>login</a> to view your orders.";
    exit;
}

if (!empty($_POST['order_id'])) {
    $order_id = $_POST['order_id'];
    $customer_id = $_SESSION['customer_id'];

    // Check current order status
    $stmt = $pdo->prepare("SELECT status FROM orders WHERE order_id = :order_id AND customer_id = :customer_id");
    $stmt->execute(['order_id' => $order_id, 'customer_id' => $customer_id]);
    $order = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($order && $order['status'] == 0) {
        // Update the status to 1 (confirmed)
        $updateStmt = $pdo->prepare("UPDATE orders SET status = 1 WHERE order_id = :order_id");
        $updateStmt->execute(['order_id' => $order_id]);
        $_SESSION['message'] = "Order {$order_id} has been confirmed successfully.";
    } elseif ($order && $order['status'] == 1) {
        $_SESSION['message'] = "Order {$order_id} was already confirmed.";
    } else {
        $_SESSION['message'] = "Order not found or you do not have permission to confirm this order.";
    }
} else {
    $_SESSION['message'] = "Invalid request.";
}

header('Location: view_orders.php');
exit;
?>

</body>

</html>