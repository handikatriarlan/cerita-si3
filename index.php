<?php
include "config/connection.php"
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
        <div class="container">
            <div id="branding">
                <h1>Cerita SI-3</h1>
            </div>
            <nav>
                <ul>
                    <li><a href="index.php">Home</a></li>
                    <li><a href="add_story.php">Tambah Cerita</a></li>
                    <li><a href="logout.php">Keluar</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <main class="container">
        <h2>Kegiatan Kelas SI-3</h2>
        <?php
        $sql = "SELECT * FROM tb_post";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<div class='post'>";
                echo "<h3><a href='show.php?post_id=" . $row['post_id'] . "'>" . $row['post_title'] . "</a></h3>";
                echo "<p>" . substr($row['post_text'], 0, 100) . "...</p>";
                echo "<p><strong>Date: </strong>" . $row['post_date'] . "</p>";
                echo "</div>";
            }
        } else {
            echo "No activities found.";
        }
        ?>
    </main>

    <footer>
        <p>Cerita SI-3 &copy; 2024</p>
    </footer>
</body>

</html>