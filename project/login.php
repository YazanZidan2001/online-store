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
    <div class="container-login">




        <div class="login">
            <h3>Login</h3>
            <form action="login_process.php" method="POST" class="login-form">

                <label for="user-type">I am a:</label>
                <select id="user-type" name="user_type">
                    <option value="customer">Customer</option>
                    <option value="employee">Employee</option>
                </select>
                <label for="email">Email:</label>
                <input type="email" name="email" required>

                <label for="password">Password:</label>
                <input type="password" name="password" required>

                <button type="submit" name="login">Login</button>
            </form>

        </div>
        <a href="register.php">Don't have an account? Sign in</a>


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