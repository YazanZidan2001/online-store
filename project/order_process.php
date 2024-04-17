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
// order_process.php
session_start();
include 'connection.php';

// Make sure only employees can access this script
if (!isset($_SESSION['user_email']) || $_SESSION['user_role'] !== 'employee') {
    header('Location: login.php');
    exit;
}

if (isset($_GET['order_id'])) {
    $order_id = $_GET['order_id'];

    // Update the process_status to 'charged'
    $sql = "UPDATE orders SET process_status = 'charged' WHERE order_id = :order_id AND status = 1";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['order_id' => $order_id]);

    if ($stmt->rowCount() > 0) {
        $_SESSION['message'] = "Order {$order_id} has been processed successfully.";
    } else {
        $_SESSION['error'] = "Order {$order_id} could not be processed.";
    }

    header('Location: view_all_orders.php');
    exit;
}
?>
</body>

</html>