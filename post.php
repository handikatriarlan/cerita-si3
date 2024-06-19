<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

include "config/connection.php";

// Handle deletion of post
if (isset($_GET['delete'])) {
    $post_id = $_GET['delete'];
    $sql_delete = "DELETE FROM tb_post WHERE post_id = $post_id";
    if ($conn->query($sql_delete) === TRUE) {
        $message = "Post deleted successfully";
    } else {
        $message = "Error deleting post: " . $conn->error;
    }
}

// Fetch posts with category names and photo
$sql_select = "SELECT tb_post.*, tb_category.cat_name, tb_photos.photo_file 
               FROM tb_post 
               JOIN tb_category ON tb_post.post_id_cat = tb_category.cat_id 
               LEFT JOIN tb_photos ON tb_post.post_id = tb_photos.photo_id_post";
$result = $conn->query($sql_select);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cerita SI-3</title>
    <link rel="stylesheet" type="text/css" href="assets/css/style.css">
</head>

<body>
    <header>
        <div id="branding">
            <a href="index.php">
                <h2>Cerita SI-3</h2>
            </a>
        </div>
        <nav>
            <ul>
                <li><a href="index.php">Beranda</a></li>
                <li><a href="post.php">Postingan</a></li>
                <li><a href="category.php">Kategori</a></li>
                <li><a href="album.php">Album</a></li>
                <li><a href="logout.php">Keluar</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <div class="container">
            <h2>Daftar Postingan</h2>
            <a href="add_post.php" class="button">Tambah Postingan</a>
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Gambar</th>
                        <th>Kategori</th>
                        <th>Slug</th>
                        <th>Judul</th>
                        <th>Teks</th>
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
                            } else {
                                echo "No Image";
                            }
                            echo "</td>
                                <td>{$row['cat_name']}</td>
                                <td>{$row['post_slug']}</td>
                                <td>{$row['post_title']}</td>
                                <td>{$row['post_text']}</td>
                                <td>{$formatted_date}</td>
                                <td>
                                    <a href='edit_post.php?id={$row['post_id']}'>Edit</a> |
                                    <a href='post.php?delete={$row['post_id']}' onclick='return confirm(\"Are you sure you want to delete this post?\")'>Hapus</a>
                                </td>
                            </tr>";
                            $number++;
                        }
                    } else {
                        echo "<tr><td colspan='8'>No posts found</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </main>

    <footer>
        <p>SI-3 &copy; 2024</p>
    </footer>
</body>

</html>