<?php
$title = "Cerita SI-3 - Tambah Kategori";
ob_start();

session_start();
if (!isset($_SESSION['user'])) {
    header("Location: auth/login.php");
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

<div class="form-section">
    <h2>Tambah Kategori</h2>
    <form method="POST" action="">
        <label for="cat_name">Nama Kategori:</label>
        <input type="text" id="cat_name" name="cat_name" required>
        <label for="cat_text">Deskripsi Kategori:</label>
        <textarea id="cat_text" name="cat_text" required></textarea>
        <input type="submit" name="submit" value="Tambahkan">
    </form>
</div>
<?php
$content = ob_get_clean();
include "layouts/app.php";
?>