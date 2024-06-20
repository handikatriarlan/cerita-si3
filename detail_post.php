<?php
$title = "Cerita SI-3 - Detail Postingan";
ob_start();

session_start();
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

include "config/connection.php";

if (isset($_GET['post_id'])) {
    $post_id = $_GET['post_id'];
    $sql = "SELECT * FROM tb_post WHERE post_id='$post_id'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $post = $result->fetch_assoc();
        echo "<h2>" . $post['post_title'] . "</h2>";
        echo "<p><strong>Date: </strong>" . $post['post_date'] . "</p>";
        echo "<p>" . $post['post_text'] . "</p>";

        $photo_sql = "SELECT * FROM tb_photos WHERE photo_id_post='$post_id'";
        $photo_result = $conn->query($photo_sql);

        if ($photo_result->num_rows > 0) {
            echo "<h3>Photos:</h3>";
            echo "<div class='photo-grid'>";
            while ($photo = $photo_result->fetch_assoc()) {
                echo "<div class='photo'>";
                echo "<h4>" . $photo['photo_title'] . "</h4>";
                echo "<img src='assets/images/" . $photo['photo_file'] . "' alt='" . $photo['photo_title'] . "'>";
                echo "</div>";
            }
            echo "</div>";
        } else {
            echo "<p>No photos available for this post.</p>";
        }
    } else {
        echo "No post found.";
    }
} else {
    echo "No post selected.";
}

$content = ob_get_clean();
include "layouts/app.php";
