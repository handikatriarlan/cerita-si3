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

    $sql_select_album = "SELECT * FROM tb_album WHERE album_id_photo IN (SELECT photo_id FROM tb_photos WHERE photo_id_post = $post_id)";
    $result_album = $conn->query($sql_select_album);
    if ($result_album->num_rows > 0) {
        while ($album_row = $result_album->fetch_assoc()) {
            $album_id = $album_row['album_id'];
            $sql_select_photos = "SELECT * FROM tb_photos WHERE photo_id_post = $post_id AND photo_id IN (SELECT album_id_photo FROM tb_album WHERE album_id = $album_id)";
            $result_photos = $conn->query($sql_select_photos);

            if ($result_photos->num_rows > 0) {
                while ($photo_row = $result_photos->fetch_assoc()) {
                    $photo_file = $photo_row['photo_file'];
                    $target_dir = "assets/images/";
                    $target_file = $target_dir . $photo_file;

                    if (file_exists($target_file)) {
                        unlink($target_file);
                    }

                    $sql_delete_photo = "DELETE FROM tb_photos WHERE photo_id = {$photo_row['photo_id']}";
                    $conn->query($sql_delete_photo);
                }
            }
            $sql_delete_album = "DELETE FROM tb_album WHERE album_id = $album_id";
            $conn->query($sql_delete_album);
        }
    }

    $sql_select_photos = "SELECT * FROM tb_photos WHERE photo_id_post = $post_id";
    $result_photos = $conn->query($sql_select_photos);
    if ($result_photos->num_rows > 0) {
        while ($photo_row = $result_photos->fetch_assoc()) {
            $photo_file = $photo_row['photo_file'];
            $target_dir = "assets/images/";
            $target_file = $target_dir . $photo_file;

            if (file_exists($target_file)) {
                unlink($target_file);
            }

            $sql_delete_photo = "DELETE FROM tb_photos WHERE photo_id = {$photo_row['photo_id']}";
            $conn->query($sql_delete_photo);
        }
    }

    $sql_delete_post = "DELETE FROM tb_post WHERE post_id = $post_id";
    if ($conn->query($sql_delete_post) === TRUE) {
        header("Location: post.php");
    }
}

$sql_select = "SELECT tb_post.*, tb_category.cat_name, tb_photos.photo_file 
               FROM tb_post 
               JOIN tb_category ON tb_post.post_id_cat = tb_category.cat_id 
               LEFT JOIN tb_photos ON tb_post.post_id = tb_photos.photo_id_post";
$result = $conn->query($sql_select);
?>

<h2>Postingan</h2>
<a href="add_post.php" class="button">Tambah Postingan</a>
<table>
    <thead>
        <tr>
            <th>No</th>
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
                    echo "<img src='assets/images/{$row['photo_file']}' style='max-width: 100px; max-height: 100px;' />";
                }
                echo   "</td>
                        <td>{$row['cat_name']}</td>
                        <td>{$row['post_slug']}</td>
                        <td>{$row['post_title']}</td>
                        <td>{$row['post_text']}</td>
                        <td>{$formatted_date}</td>
                        <td>
                            <a href='edit_post.php?id={$row['post_id']}'>Edit</a> |
                            <a href='post.php?delete={$row['post_id']}' onclick='return confirm(\"Apakah Anda yakin ingin menghapus postingan ini? Menghapus postingan ini juga berarti menghapus album dan foto yang terdapat di dalamnya.\")'>Hapus</a>
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