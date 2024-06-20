<?php
$title = "Cerita SI-3 - Edit Kategori";
ob_start();

session_start();
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

include "config/connection.php";

if (isset($_GET['id'])) {
    $cat_id = $_GET['id'];

    $sql = "SELECT * FROM tb_category WHERE cat_id = $cat_id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    } else {
        echo "Category not found.";
        exit();
    }
} else {
    echo "Category ID not specified.";
    exit();
}

if (isset($_POST['submit'])) {
    $cat_name = $_POST['cat_name'];
    $cat_text = $_POST['cat_text'];

    $sql = "UPDATE tb_category SET cat_name = '$cat_name', cat_text = '$cat_text' WHERE cat_id = $cat_id";

    if ($conn->query($sql) === TRUE) {
        header("Location: category.php");
    } else {
        echo "Error updating record: " . $conn->error;
    }
}
?>

<h2>Edit Category</h2>
<form method="POST" action="">
    <label for="cat_name">Category Name:</label>
    <input type="text" id="cat_name" name="cat_name" value="<?php echo $row['cat_name']; ?>" required>
    <label for="cat_text">Category Description:</label>
    <textarea id="cat_text" name="cat_text" required><?php echo $row['cat_text']; ?></textarea>
    <input type="submit" name="submit" value="Update Category">
</form>

<?php
$content = ob_get_clean();
include "layouts/app.php";
?>