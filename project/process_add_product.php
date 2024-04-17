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

function getNextItemID($pdo) {
    $stmt = $pdo->query("SELECT MAX(p_id) AS max_id FROM product");
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    return $row['max_id'] + 1; 
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])) {
    $nextItemID = getNextItemID($pdo);

    $p_name = $_POST['p_name'];
    $p_description = $_POST['p_description'];
    $p_category = $_POST['p_category'];
    $p_price = $_POST['p_price'];
    $p_quantity = $_POST['p_quantity'];
    $p_remarks = $_POST['p_remarks'] ?? ''; 

    if (isset($_FILES['p_photo']) && $_FILES['p_photo']['error'] == UPLOAD_ERR_OK) {
        $uploadDir = 'itemsImages/'; 
        $imageFileType = strtolower(pathinfo($_FILES['p_photo']['name'], PATHINFO_EXTENSION));
        $baseFilename = "item" . $nextItemID . "img";
        $targetFile = $uploadDir . $baseFilename . "." . $imageFileType;

        if (move_uploaded_file($_FILES['p_photo']['tmp_name'], $targetFile)) {
            $p_photo = $targetFile;
        } else {
            echo 'Error uploading file.';
            exit; 
        }
    } else {
        echo 'Invalid file upload.';
        exit; 
    }

    $sql = "INSERT INTO product (p_name, p_description, p_category, p_price, p_quantity, p_remarks, p_photo) 
            VALUES (:p_name, :p_description, :p_category, :p_price, :p_quantity, :p_remarks, :p_photo)";

    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':p_name', $p_name);
    $stmt->bindParam(':p_description', $p_description);
    $stmt->bindParam(':p_category', $p_category);
    $stmt->bindParam(':p_price', $p_price);
    $stmt->bindParam(':p_quantity', $p_quantity);
    $stmt->bindParam(':p_remarks', $p_remarks);
    $stmt->bindParam(':p_photo', $p_photo);

    if ($stmt->execute()) {
        $_SESSION['confirmation'] = "Product added successfully";
        header('Location: add_product.php');
        exit;
    } else {
        echo "Error adding the product";
    }
} else {
    echo "Form not submitted correctly";
}

?>

</body>

</html>