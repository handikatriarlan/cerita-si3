<?php
$title = "Cerita SI-3 - Detail Postingan";
ob_start();

session_start();
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

include "config/connection.php";

$post_id = isset($_GET['post_id']) ? $_GET['post_id'] : null;

if ($post_id) {
    $sql = "SELECT p.*, c.cat_name 
            FROM tb_post p 
            JOIN tb_category c ON p.post_id_cat = c.cat_id 
            WHERE p.post_id = '$post_id'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $post = $result->fetch_assoc();
        $title = "Cerita SI-3 - " . $post['post_title'];
?>

<article class="post-detail">
    <h1><?php echo $post['post_title']; ?></h1>
    <p class="post-category">Kategori: <?php echo $post['cat_name']; ?></p>
    <p class="post-date">Tanggal Upload: <?php echo $post['post_date']; ?></p>
    <div class="post-content">
        <?php
        $photo_sql = "SELECT * FROM tb_photos WHERE photo_id_post='$post_id'";
        $photo_result = $conn->query($photo_sql);

        if ($photo_result->num_rows > 0) {
            $photo = $photo_result->fetch_assoc();
            echo "<div class='photo'>";
            echo "<img src='assets/images/" . $photo['photo_file'] . "' alt='" . $photo['photo_title'] . "'>";
            echo "</div>";
        }
        ?>
        <div class="post-text">
            <?php echo $post['post_text']; ?>
        </div>
    </div>
</article>

<?php
    } else {
        echo "Tidak ada postingan yang ditemukan.";
    }
} else {
    echo "Parameter post_id tidak valid.";
}

$content = ob_get_clean();
include "layouts/app.php";
?>