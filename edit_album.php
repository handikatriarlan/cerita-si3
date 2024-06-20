<?php
$title = "Cerita SI-3 - Edit Album";
ob_start();

session_start();
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

include "config/connection.php";

if (isset($_GET['id'])) {
    $album_id = $_GET['id'];
    $sql = "SELECT * FROM tb_album WHERE album_id = $album_id";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $album = $result->fetch_assoc();
    } else {
        echo "Album not found";
        exit();
    }
} else {
    echo "Invalid album ID";
    exit();
}

if (isset($_POST['update_album'])) {
    $album_title = $_POST['album_title'];

    $sql_update_album = "UPDATE tb_album SET album_title = '$album_title' WHERE album_id = $album_id";

    if ($conn->query($sql_update_album) === TRUE) {
        header("Location: album.php");
    }
}
?>


<h2>Edit Album</h2>
<form method="POST" action="">
    <label for="album_title">Nama Album:</label>
    <input type="text" id="album_title" name="album_title" value="<?php echo $album['album_title']; ?>" required>
    <input type="submit" name="update_album" value="Update Album">
</form>

<?php
$content = ob_get_clean();
include "layouts/app.php";
?>