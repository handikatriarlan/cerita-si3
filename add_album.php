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
        $error_message = "Judul album sudah ada. Silakan gunakan judul album yang lain.";
    } else {
        $sql_insert = "INSERT INTO tb_album (album_id_photo, album_title, user_id) VALUES ('$album_id_photo', '$album_title', '$user_id')";
        if ($conn->query($sql_insert) === TRUE) {
            header("Location: album.php");
            exit();
        }
    }
}

$sql_photos = "SELECT * FROM tb_photos WHERE photo_id NOT IN (SELECT album_id_photo FROM tb_album WHERE album_id_photo IS NOT NULL)";
$result_photos = $conn->query($sql_photos);
?>

<div class="form-section">
    <h2>Tambahkan Foto ke Album</h2>

    <?php if (isset($error_message)) { ?>
        <p style="color: red; text-align: center; margin: 10px 0;"><?php echo $error_message ?></p>
    <?php } ?>
    
    <form method="POST" action="" onsubmit="return validateAlbumForm()">
        <label for="album_id_photo">Foto:</label>
        <select id="album_id_photo" name="album_id_photo" required>
            <?php
            if ($result_photos->num_rows > 0) {
                while ($row = $result_photos->fetch_assoc()) {
                    echo "<option value='" . $row['photo_id'] . "'>" . $row['photo_title'] . "</option>";
                }
            } else {
                echo "<option value=''>Tidak ada foto yang tersedia untuk ditambahkan ke album.</option>";
            }
            ?>
        </select>
        <label for="album_title">Judul Album:</label>
        <input type="text" id="album_title" name="album_title" required>
        <input type="submit" name="submit" value="Tambahkan">
    </form>
</div>

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