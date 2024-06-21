<?php
$title = "Cerita SI-3 - Postingan";
ob_start();

session_start();
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

include "config/connection.php";

if (isset($_GET['delete'])) {
    $post_id = $_GET['delete'];

    $sql_delete_album = "DELETE FROM tb_album WHERE album_id_photo IN (SELECT photo_id FROM tb_photos WHERE photo_id_post = $post_id)";

    $sql_delete_photos = "DELETE FROM tb_photos WHERE photo_id_post = $post_id";

    $sql_delete_post = "DELETE FROM tb_post WHERE post_id = $post_id";

    if ($conn->query($sql_delete_album) === TRUE && $conn->query($sql_delete_photos) === TRUE && $conn->query($sql_delete_post) === TRUE) {
        header("Location: post.php");
    }
}

$sql_select = "SELECT tb_post.*, tb_category.cat_name, tb_photos.photo_file 
               FROM tb_post 
               JOIN tb_category ON tb_post.post_id_cat = tb_category.cat_id 
               LEFT JOIN tb_photos ON tb_post.post_id = tb_photos.photo_id_post";
$result = $conn->query($sql_select);
?>

<div class="menu-title">
    <h2>Postingan</h2>
    <a href="add_post.php" class="button">Tambah Postingan</a>
</div>
<table>
    <thead>
        <tr>
            <th>No.</th>
            <th>Gambar</th>
            <th>Kategori</th>
            <th>Slug</th>
            <th>Judul</th>
            <th>Deskripsi</th>
            <th>Tanggal</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php
        if ($result->num_rows > 0) {
            $number = 1;
            while ($row = $result->fetch_assoc()) {
                $formatted_date = date("d-m-Y", strtotime($row['post_date']));
                echo "<tr>
                    <td>{$number}.</td>
                    <td>";
                    if (!empty($row['photo_file'])) {
                        echo "<img src='assets/images/{$row['photo_file']}' />";
                    }
                    echo   "</td>
                    <td>{$row['cat_name']}</td>
                    <td>{$row['post_slug']}</td>
                    <td>{$row['post_title']}</td>
                    <td>" . substr($row['post_text'], 0, 157) . "...</td>
                    <td>{$formatted_date}</td>
                    <td>
                    <a class='button-edit' href='edit_post.php?id={$row['post_id']}'>Edit</a>
                    <br>
                    <br>
                    <a class='button-delete' href='post.php?delete={$row['post_id']}' onclick='return confirm(\"Apakah Anda yakin ingin menghapus postingan ini? Menghapus postingan ini juga berarti menghapus album dan foto yang terdapat di dalamnya.\")'>Hapus</a>
                    </td>
                </tr>";
                $number++;
            }
        } else {
            echo "<tr><td colspan='8'>Tidak ada postingan yang ditemukan.</td></tr>";
        }
        ?>
    </tbody>
</table>

<?php
$content = ob_get_clean();
include "layouts/app.php";
?>