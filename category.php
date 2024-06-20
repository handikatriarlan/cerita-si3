<?php
$title = "Cerita SI-3 - Kategori";
ob_start();

session_start();
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

include "config/connection.php";

if (isset($_GET['delete'])) {
    $cat_id = $_GET['delete'];

    $sql = "DELETE FROM tb_category WHERE cat_id = $cat_id";

    if ($conn->query($sql) === TRUE) {
        header("Location: category.php");
    } else {
        echo "Error deleting record: " . $conn->error;
    }
}
?>

<h2>Kategori</h2>
<a href="add_category.php" class="button">Tambah Kategori</a>
<table class="category-table">
    <thead>
        <tr>
            <th>No.</th>
            <th>Category Name</th>
            <th>Category Description</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $number = 1;
        $sql = "SELECT * FROM tb_category";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                                <td>{$number}.</td>
                                <td>{$row['cat_name']}</td>
                                <td>{$row['cat_text']}</td>
                                <td>
                                    <a href='edit_category.php?id={$row['cat_id']}'>Edit</a> |
                                    <a href='category.php?delete={$row['cat_id']}' onclick='return confirm(\"Are you sure you want to delete this category?\")'>Hapus</a>
                                </td>
                            </tr>";
                $number++;
            }
        } else {
            echo "<tr><td colspan='4'>No categories found</td></tr>";
        }
        ?>
    </tbody>
</table>

<?php
$content = ob_get_clean();
include "layouts/app.php";
?>