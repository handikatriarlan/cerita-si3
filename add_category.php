<?php
$title = "Cerita SI-3 - Tambah Kategori";
ob_start();

session_start();
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

include "config/connection.php";

if (isset($_POST['submit'])) {
    $cat_name = $_POST['cat_name'];
    $cat_text = $_POST['cat_text'];
    $user_id = $_SESSION['user'];

    $sql = "INSERT INTO tb_category (cat_name, cat_text, user_id) VALUES ('$cat_name', '$cat_text', '$user_id')";

    if ($conn->query($sql) === TRUE) {
        header("Location: category.php");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>

<h2>Add Category</h2>
<form method="POST" action="">
    <label for="cat_name">Category Name:</label>
    <input type="text" id="cat_name" name="cat_name" required>
    <label for="cat_text">Category Description:</label>
    <textarea id="cat_text" name="cat_text" required></textarea>
    <input type="submit" name="submit" value="Add Category">
</form>
<?php
$content = ob_get_clean();
include "layouts/app.php";
?>