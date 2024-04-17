<?php
include 'connection.php';
session_start();



function generateCustomerId($pdo) {
    do {
        $customer_id = mt_rand(1000000000, 9999999999); // Generate a random 10-digit number
        $stmt = $pdo->prepare("SELECT customer_id FROM customers WHERE customer_id = :customer_id");
        $stmt->execute([':customer_id' => $customer_id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
    } while ($row); // Continue if the ID already exists
    return $customer_id;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Step 1n
    if (isset($_POST['register_info'])) {
        // Store
        $_SESSION['customer_info'] = $_POST;
        $_SESSION['step'] = 2;
    }
    
    // Step 2
    elseif (isset($_POST['create_account'])) {
        // Store
        $_SESSION['account_info'] = $_POST;
        $_SESSION['step'] = 3;
    }
    
    // Step 3: Confirmation
    elseif (isset($_POST['confirm_registration'])) {
        // Insert data 
        $customer_id = generateCustomerId($pdo);
        $stmt = $pdo->prepare("INSERT INTO customers (customer_id, c_name, email, id_number, address, Date_of_Birth, phone, card_id, card_expirationdate, card_name, bank_name, username, password) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([
            $customer_id,
            $_SESSION['customer_info']['c_name'],
            $_SESSION['customer_info']['email'],
            $_SESSION['customer_info']['id_number'],
            $_SESSION['customer_info']['address'],
            $_SESSION['customer_info']['Date_of_Birth'],
            $_SESSION['customer_info']['phone'],
            $_SESSION['customer_info']['card_id'],
            $_SESSION['customer_info']['card_expirationdate'],
            $_SESSION['customer_info']['card_name'],
            $_SESSION['customer_info']['bank_name'],
            $_SESSION['account_info']['username'],
            $_SESSION['account_info']['password']
        ]);
        
        echo "Registration successful. Your customer ID is: " . $customer_id;
        echo "<a href='login.php'>Click here to login</a>";
        
        session_destroy();
        exit;
    }
}

//defult step
if (!isset($_SESSION['step'])) {
    $_SESSION['step'] = 1;
}
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
            <a href="login.php">Login/Register</a>
        </div>
    </header>





    <div class="container-register">
        <?php if ($_SESSION['step'] === 1): ?>
        <form action="register.php" method="post">
            Name: <input type="text" name="c_name" required><br>
            Email: <input type="email" name="email" required><br>
            ID Number: <input type="text" name="id_number" required><br>
            Address: <input type="text" name="address" required><br>
            Date of Birth: <input type="date" name="Date_of_Birth" required><br>
            Phone: <input type="text" name="phone" required><br>
            Card ID: <input type="text" name="card_id" required><br>
            Card Expiration Date: <input type="month" name="card_expirationdate" required><br>
            Card Name: <input type="text" name="card_name" required><br>
            Bank Name: <input type="text" name="bank_name" required><br>
            <button type="submit" name="register_info">Next Step</button>
        </form>
        <?php endif; ?>

        <?php if ($_SESSION['step'] === 2): ?>
        <form action="register.php" method="post">
            Username: <input type="text" name="username" pattern=".{6,13}" required><br>
            Password: <input type="password" name="password" pattern=".{8,12}" required><br>
            Confirm Password: <input type="password" name="confirm_password" pattern=".{8,12}" required><br>
            <button type="submit" name="create_account">Next Step</button>
        </form>
        <?php endif; ?>

        <?php if ($_SESSION['step'] === 3): ?>
        <form action="register.php" method="post">
            <p>Please confirm your details:</p>
            Name: <?php echo ($_SESSION['customer_info']['c_name']); ?><br>
            Email: <?php echo ($_SESSION['customer_info']['email']); ?><br>
            ID Number: <?php echo ($_SESSION['customer_info']['id_number']); ?><br>
            Address: <?php echo ($_SESSION['customer_info']['address']); ?><br>
            Date of Birth: <?php echo ($_SESSION['customer_info']['Date_of_Birth']); ?><br>
            Card ID: <?php echo ($_SESSION['customer_info']['card_id']); ?><br>
            Card Name: <?php echo ($_SESSION['customer_info']['card_name']); ?><br>
            Bank Name: <?php echo ($_SESSION['customer_info']['bank_name']); ?><br>
            Phone: <?php echo ($_SESSION['customer_info']['phone']); ?><br>
            Username: <?php echo ($_SESSION['account_info']['username']); ?><br>
            Password: <?php echo ($_SESSION['account_info']['password']); ?><br>
            <input type="hidden" name="confirm_registration" value="1">
            <button type="submit" name="confirm_registration">Confirm Registration</button>
        </form>
        <?php endif; ?>
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