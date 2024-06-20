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

    $sql_get_posts = "SELECT post_id FROM tb_post WHERE post_id_cat = $cat_id";
    $result_posts = $conn->query($sql_get_posts);

    if ($result_posts->num_rows > 0) {
        while ($post = $result_posts->fetch_assoc()) {
            $post_id = $post['post_id'];

            $sql_delete_album = "DELETE FROM tb_album WHERE album_id_photo IN (SELECT photo_id FROM tb_photos WHERE photo_id_post = $post_id)";
            $conn->query($sql_delete_album);

            $sql_delete_photos = "DELETE FROM tb_photos WHERE photo_id_post = $post_id";
            $conn->query($sql_delete_photos);

            $sql_delete_post = "DELETE FROM tb_post WHERE post_id = $post_id";
            $conn->query($sql_delete_post);
        }
    }

    $sql_delete_category = "DELETE FROM tb_category WHERE cat_id = $cat_id";
    if ($conn->query($sql_delete_category) === TRUE) {
        header("Location: category.php");
    } else {
        $error_message = "Error deleting category: " . $conn->error;
    }
}
?>

<h2>Kategori</h2>
<?php if (isset($error_message)) { ?>
    <p style="color: red; text-align: center; margin: 10px 0;"><?php echo $error_message ?></p>
<?php } ?>
<table class="category-table">
    <thead>
        <tr>
            <th>No.</th>
            <th>Nama Kategori</th>
            <th>Deskripsi Kategori</th>
            <th>Aksi</th>
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
                <a class='button-edit' href='edit_category.php?id={$row['cat_id']}'>Edit</a>
                <br>
                <br>
                <a class='button-delete' href='category.php?delete={$row['cat_id']}' onclick='return confirm(\"Apakah Anda yakin ingin menghapus kategori ini? Menghapus kategori ini juga berarti menghapus seluruh data postingan apabila postingan tersebut terhubung dengan kategori ini.\")'>Hapus</a>
                </td>
                </tr>";
                $number++;
            }
        } else {
            echo "<tr><td colspan='4'>Tidak ada kategori yang ditemukan.</td></tr>";
        }
        ?>
    </tbody>
</table>
<a href="add_category.php" class="button">Tambah Kategori</a>

<?php
$content = ob_get_clean();
include "layouts/app.php";
?>