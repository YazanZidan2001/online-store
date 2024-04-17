<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="st.css">

</head>

<body>

</body>


</html>








<?php
// sweets.php
try {
    // Connect to the database using PDO
    $pdo = new PDO('mysql:host=localhost;dbname=sweetShop', 'abuali', 'anter123');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Initialize an array to store order details
    $orderDetails = [];
    $total = 0;

    // Check if the form was submitted
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Process each item
        foreach ($_POST['items'] as $itemId) {
            // Retrieve item details from the database
            $stmt = $pdo->prepare("SELECT description, price, photo FROM items WHERE itemID = :item_id");
            $stmt->bindParam(':item_id', $itemId, PDO::PARAM_INT);
            $stmt->execute();
            $item = $stmt->fetch(PDO::FETCH_ASSOC);
            
            // Get the quantity from the form
            $quantity = $_POST['qty'][$itemId];
            
            // Calculate the subtotal
            $subtotal = $item['price'] * $quantity;
            $total += $subtotal;

            // Add to the order details
            $orderDetails[] = [
                'item' => $item['description'],
                'price' => $item['price'],
                'quantity' => $quantity,
                'subtotal' => $subtotal,
                'photo' => $item['photo']
            ];
        }
        
        // Add shipping cost
        $shippingCost = ($_POST['shipping'] == 'express') ? 15 : 10;
        $total += $shippingCost;
    }
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
    exit;
}