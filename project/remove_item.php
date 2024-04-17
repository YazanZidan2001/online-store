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

$order_id = filter_input(INPUT_GET, 'order_id', FILTER_SANITIZE_NUMBER_INT);
$p_id = filter_input(INPUT_GET, 'p_id', FILTER_SANITIZE_NUMBER_INT);

try {
    // Begin transaction
    $pdo->beginTransaction();

    // Get the quantity to be returned to stock
    $quantityStmt = $pdo->prepare("SELECT quantity FROM order_items WHERE order_id = :order_id AND p_id = :p_id");
    $quantityStmt->execute(['order_id' => $order_id, 'p_id' => $p_id]);
    $item = $quantityStmt->fetch(PDO::FETCH_ASSOC);
    $quantityToReturn = $item ? $item['quantity'] : 0;

    // Delete the item from order_items
    $deleteStmt = $pdo->prepare("DELETE FROM order_items WHERE order_id = :order_id AND p_id = :p_id");
    $deleteStmt->execute(['order_id' => $order_id, 'p_id' => $p_id]);

    // If the item was successfully deleted, return the quantity to the product stock
    if ($deleteStmt->rowCount()) {
        $returnStockStmt = $pdo->prepare("UPDATE product SET p_quantity = p_quantity + :quantity WHERE p_id = :p_id");
        $returnStockStmt->execute(['quantity' => $quantityToReturn, 'p_id' => $p_id]);
    }

    // Check if the order has any items left, if not, delete the order too
    $checkOrderStmt = $pdo->prepare("SELECT COUNT(*) FROM order_items WHERE order_id = :order_id");
    $checkOrderStmt->execute(['order_id' => $order_id]);
    if ($checkOrderStmt->fetchColumn() == 0) {
        $deleteOrderStmt = $pdo->prepare("DELETE FROM orders WHERE order_id = :order_id");
        $deleteOrderStmt->execute(['order_id' => $order_id]);
    }

    $pdo->commit();

    header('Location: view_orders.php?remove=success'); 
    exit;
    
} catch (PDOException $e) {
    $pdo->rollBack();
    exit("Error removing item: " . $e->getMessage());
}
?>

</body>

</html>