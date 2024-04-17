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

if (!isset($_SESSION['customer_id'])) {
    echo "Please <a href='login.php'>login</a> to view your orders.";
    exit;
}

$customer_id = $_SESSION['customer_id'];
$product_id = $_POST['product_id'];
$quantity = $_POST['quantity'];

try {
    // Begin transaction
    $pdo->beginTransaction();

    // Create a new order
    $stmt = $pdo->prepare("INSERT INTO orders (customer_id, date, status) VALUES (?, NOW(), 0)"); // Assuming status 0 is unconfirmed
    $stmt->execute([$customer_id]);
    $order_id = $pdo->lastInsertId();

    // Add item to order_items
    $stmt = $pdo->prepare("INSERT INTO order_items (order_id, p_id, quantity) VALUES (?, ?, ?)");
    $stmt->execute([$order_id, $product_id, $quantity]);

    // Update product quantity
    $updateProductStmt = $pdo->prepare("UPDATE product SET p_quantity = p_quantity - ? WHERE p_id = ? AND p_quantity >= ?");
    $updateProductStmt->execute([$quantity, $product_id, $quantity]);

    // Check if product quantity update was successful
    if ($updateProductStmt->rowCount() == 0) {
        // If product stock was not enough, rollback transaction and give an error
        $pdo->rollBack();
        $_SESSION['error'] = "Insufficient product stock for product ID: {$product_id}";
        header('Location: product_details.php?id=' . $product_id);
        exit;
    }

    // Commit transaction
    $pdo->commit();

    $_SESSION['success'] = "Item added to order successfully";
    header('Location: product_details.php?id=' . $product_id . '&success=1');
    exit;
    
} catch (Exception $e) {
    $pdo->rollBack();
    $_SESSION['error'] = "An error occurred: " . $e->getMessage();
    header('Location: product_details.php?id=' . $product_id);
    exit;
}
?>


</body>

</html>