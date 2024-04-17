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
include 'connection.php'; 
session_start();

if (!isset($_SESSION['customer_id'])) {
    echo "Please <a href='login.php'>login</a> to view your orders.";
    exit;
}
$order_id = filter_input(INPUT_POST, 'order_id', FILTER_SANITIZE_NUMBER_INT);
$p_id = filter_input(INPUT_POST, 'p_id', FILTER_SANITIZE_NUMBER_INT);
$quantity = filter_input(INPUT_POST, 'quantity', FILTER_SANITIZE_NUMBER_INT);

if ($quantity < 0) {
    exit('Invalid quantity specified.');
}

try {
    $stmt = $pdo->prepare("UPDATE order_items SET quantity = :quantity WHERE order_id = :order_id AND p_id = :p_id");

    $stmt->execute(['quantity' => $quantity, 'order_id' => $order_id, 'p_id' => $p_id]);

    if ($stmt->rowCount()) {
        header('Location: view_orders.php?update=success'); 
        exit;
    } else {
        exit('Failed to update the item. Make sure the item exists');
    }
} catch (PDOException $e) {
    exit("Error updating item: " . $e->getMessage());
}
?>

</body>

</html>