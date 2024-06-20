<?php
$title = "Cerita SI-3 - Beranda";
ob_start();

session_start();


if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

include "config/connection.php";
?>

<h2>Kegiatan Kelas SI-3</h2>
<?php
$sql = "SELECT * FROM tb_post";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<div class='post'>";
        echo "<h3><a href='detail_post.php?post_id=" . $row['post_id'] . "'>" . $row['post_title'] . "</a></h3>";
        echo "<p>" . substr($row['post_text'], 0, 100) . "...</p>";
        echo "<p><strong>Date: </strong>" . $row['post_date'] . "</p>";
        echo "</div>";
    }
} else {
    echo "No activities found.";
}

$content = ob_get_clean();
include "layouts/app.php";
?>