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

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['login'])) {
    $userType = $_POST['user_type'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    if ($userType == 'customer') {
        $sql = "SELECT * FROM customers WHERE email = :email";
    } elseif ($userType == 'employee') {
        $sql = "SELECT * FROM employees WHERE email = :email";
    }

    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        if ($password === $user['password']) {
            $_SESSION['user_role'] = $userType; 
            $_SESSION['user_email'] = $user['email'];


            if ($userType == 'customer') {
                 $_SESSION['customer_id'] = $user['customer_id'];
                $_SESSION['customer_name'] = $user['c_name'];
        
                // var_dump($_SESSION);
                // exit;

                
                header('Location: home.php'); 
                exit;
            } elseif ($userType == 'employee') {
                // $_SESSION['employee_id'] = $user['employee_id']; 

                header('Location: employee_page.php'); 
                exit;
            }
        } else {
            echo "Incorrect password";
        }
    } else {
        echo "Email not found";
    }
} else {
    echo "Form not submitted correctly";
}
?>


</body>

</html>