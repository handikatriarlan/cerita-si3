<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

include "config/connection.php";

if (isset($_GET['delete'])) {
    $album_id = $_GET['delete'];
    $sql_delete = "DELETE FROM tb_album WHERE album_id = $album_id";
    if ($conn->query($sql_delete) === TRUE) {
        header("Location: album.php");
    }
}

$sql = "SELECT * FROM tb_album";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Album - Cerita SI-3</title>
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
            <h2>Daftar Album</h2>
            <a href="add_album.php" class="button">Tambah Album</a>
            <table>
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Nama Album</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($result->num_rows > 0) {
                        $number = 1;
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>
                             <td>{$number}.</td>
                             <td>{$row['album_title']}</td>
                            <td>
                                <a href='edit_album.php?id={$row['album_id']}'>Edit</a> |
                                <a href='album.php?delete={$row['album_id']}' onclick='return confirm(\"Are you sure you want to delete this album?\")'>Hapus</a>
                            </td>
                        </tr>";
                            $number++;
                        }
                    } else {
                        echo "<tr><td colspan='8'>No album found</td></tr>";
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