<?php
$title = "Cerita SI-3 - Beranda";
ob_start();

session_start();
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

include "config/connection.php";

$sql = "SELECT p.*, ph.photo_file
                FROM tb_post p
                LEFT JOIN tb_photos ph ON p.post_id = ph.photo_id_post";

$result = $conn->query($sql);
?>

<h2>Kegiatan Kelas SI-3</h2>
<div class="posts-container">
    <?php
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<div class='post'>";
            echo "<a href='detail_post.php?post_id=" . $row['post_id'] . "'><h3>" . $row['post_title'] . "</h3></a>";
            echo "<a href='detail_post.php?post_id=" . $row['post_id'] . "'><img src='assets/images/" . $row['photo_file'] . "'></a>";
            echo "<p>" . substr($row['post_text'], 0, 100) . "...</p>";
            echo "<span>Tanggal Upload: " . $row['post_date'] . "</span>";
            echo "</div>";
        }
    } else {
        echo "<p>Tidak ada kegiatan yang ditemukan.</p>";
    }
    ?>
</div>
<?php
$content = ob_get_clean();
include "layouts/app.php";
?>