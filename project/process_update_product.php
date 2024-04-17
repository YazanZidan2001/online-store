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

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_product'])) {
    $p_id = $_POST['p_id'];
    $p_name = $_POST['p_name'];
    $p_description = $_POST['p_description'];
    $p_category = $_POST['p_category'];
    $p_price = $_POST['p_price'];
    $p_quantity = $_POST['p_quantity'];
    $p_remarks = $_POST['p_remarks'] ?? '';
    $p_photo_path = '';

    if (isset($_FILES['p_photo']) && $_FILES['p_photo']['error'] == UPLOAD_ERR_OK) {
        $uploadDir = 'itemsImages/';

        // Extract the photo extension and generate a new photoname
        $imageFileType = strtolower(pathinfo($_FILES['p_photo']['name'], PATHINFO_EXTENSION));
        $newFilename = "item" . $p_id . "img." . $imageFileType;

        // path for the new photo
        $p_photo_path = $uploadDir . $newFilename;

        // Move the file to the new location
        if (!move_uploaded_file($_FILES['p_photo']['tmp_name'], $p_photo_path)) {
            echo "Error uploading file.";
            exit;
        }
    } else {
     // return old photo , if the is no new photo
        $stmt = $pdo->prepare("SELECT p_photo FROM product WHERE p_id = :p_id");
        $stmt->execute(['p_id' => $p_id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $p_photo_path = $result['p_photo'];
    }

    $sql = "UPDATE product SET p_name = :p_name, p_description = :p_description, p_category = :p_category, p_price = :p_price, p_quantity = :p_quantity, p_remarks = :p_remarks, p_photo = :p_photo WHERE p_id = :p_id";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        'p_name' => $p_name,
        'p_description' => $p_description,
        'p_category' => $p_category,
        'p_price' => $p_price,
        'p_quantity' => $p_quantity,
        'p_remarks' => $p_remarks,
        'p_photo' => $p_photo_path,
        'p_id' => $p_id
    ]);





    if ($stmt->rowCount() > 0) {
        $_SESSION['confirmation_up'] = "Product updated successfully!";
        header('Location: update_product.php?id=' . $p_id); 
        exit;
    } else {
        echo "Error updating the product";
    }
} else {
    echo "Form not submitted correctly";
    exit;
}
?>



</body>

</html>