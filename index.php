<?php
$title = "Cerita SI-3 - Beranda";
ob_start();

include "config/connection.php";

$sql = "SELECT p.*, ph.photo_file
        FROM tb_post p
        LEFT JOIN tb_photos ph ON p.post_id = ph.photo_id_post
        ORDER BY p.post_date ASC";

$result = $conn->query($sql);
?>

<h2>Kegiatan Kelas SI-3</h2>
<div class="posts-container">
    <?php
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $formatted_date = date("d-m-Y", strtotime($row['post_date']));
            echo "<div class='post'>";
            echo "<a href='detail_post.php?post_id=" . $row['post_id'] . "'><h3>" . $row['post_title'] . "</h3></a>";
            echo "<a href='detail_post.php?post_id=" . $row['post_id'] . "'><img src='assets/images/" . $row['photo_file'] . "'></a>";
            echo "<p>" . substr($row['post_text'], 0, 157) . "...</p>";
            echo "<span class='posts-date'>Tanggal Upload: " . $formatted_date . "</span>";
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