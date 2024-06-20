<?php
$title = "Cerita SI-3 - Beranda";
ob_start();

session_start();
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

include "config/connection.php";

if (isset($_POST['submit'])) {
    $album_id_photo = $_POST['album_id_photo'];
    $album_title = $_POST['album_title'];
    $user_id = $_SESSION['user'];

    $sql = "INSERT INTO tb_album (album_id_photo, album_title, user_id) VALUES ('$album_id_photo', '$album_title', '$user_id')";

    if ($conn->query($sql) === TRUE) {
        header("Location: album.php");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>


<h2>Add Album</h2>
<form method="POST" action="">
    <label for="album_id_photo">Photo:</label>
    <select id="album_id_photo" name="album_id_photo" required>
        <?php
        $sql = "SELECT * FROM tb_photos";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<option value='" . $row['photo_id'] . "'>" . $row['photo_title'] . "</option>";
            }
        } else {
            echo "<option>No photos available</option>";
        }
        ?>
    </select>
    <label for="album_title">Title:</label>
    <input type="text" id="album_title" name="album_title" required>
    <input type="submit" name="submit" value="Add Album">
</form>

<?php
$content = ob_get_clean();
include "layouts/app.php";
?>