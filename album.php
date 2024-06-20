<?php
$title = "Cerita SI-3 - Album";
ob_start();

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


<h2>Album</h2>
<a href="add_album.php" class="button">Tambahkan Foto ke Album</a>
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
                                <a href='album.php?delete={$row['album_id']}' onclick='return confirm(\"Apakah Anda yakin ingin menghapus album ini?\")'>Hapus</a>
                            </td>
                        </tr>";
                $number++;
            }
        } else {
            echo "<tr><td colspan='8'>Tidak ada album yang ditemukan.</td></tr>";
        }
        ?>
    </tbody>
</table>

<?php
$content = ob_get_clean();
include "layouts/app.php";
?>