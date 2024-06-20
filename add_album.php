<?php
$title = "Cerita SI-3 - Tambah Album";
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

    $sql_check = "SELECT * FROM tb_album WHERE album_title = '$album_title'";
    $result = $conn->query($sql_check);

    if ($result->num_rows > 0) {
        $album = $result->fetch_assoc();
        $current_photos = $album['album_id_photo'];
        $new_photos = $current_photos . ',' . $album_id_photo;
        $sql_update = "UPDATE tb_album SET album_id_photo = '$new_photos' WHERE album_title = '$album_title'";
        if ($conn->query($sql_update) === TRUE) {
            $message = "Foto berhasil ditambahkan ke album yang sudah ada.";
        } else {
            $error_message = "Error: " . $conn->error;
        }
    } else {
        $sql_insert = "INSERT INTO tb_album (album_id_photo, album_title, user_id) VALUES ('$album_id_photo', '$album_title', '$user_id')";
        if ($conn->query($sql_insert) === TRUE) {
            header("Location: album.php");
        } else {
            $error_message = "Error: " . $conn->error;
        }
    }
}
?>

<h2>Tambahkan Foto ke Album</h2>
<form method="POST" action="">
    <label for="album_id_photo">Foto:</label>
    <select id="album_id_photo" name="album_id_photo" required>
        <?php
        $sql = "SELECT * FROM tb_photos";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<option value='" . $row['photo_id'] . "'>" . $row['photo_title'] . "</option>";
            }
        } else {
            echo "<option value=''>Tidak ada foto yang tersedia</option>";
        }
        ?>
    </select>
    <label for="album_title">Judul Album:</label>
    <input type="text" id="album_title" name="album_title" required>
    <input type="submit" name="submit" value="Tambahkan" onclick="return validateForm()">
</form>

<?php if (isset($message)) { ?>
    <p style="color: green; text-align: center; margin: 10px 0;"><?php echo $message ?></p>
<?php } ?>
<?php if (isset($error_message)) { ?>
    <p style="color: red; text-align: center; margin: 10px 0;"><?php echo $error_message ?></p>
<?php } ?>

<script>
    function validateForm() {
        var photo = document.getElementById("album_id_photo").value;
        if (photo === "") {
            alert("Harap pilih foto yang ingin dimasukkan ke album.");
            return false;
        }
        return true;
    }
</script>

<?php
$content = ob_get_clean();
include "layouts/app.php";
?>