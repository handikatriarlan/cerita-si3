<?php
$title = "Cerita SI-3 - Tambah Postingan";
ob_start();

session_start();
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

include "config/connection.php";

if (isset($_POST['submit'])) {
    $post_id_cat = $_POST['post_id_cat'];
    $post_slug = $_POST['post_slug'];
    $post_title = $_POST['post_title'];
    $post_text = $_POST['post_text'];
    $post_date = $_POST['post_date'];
    $user_id = $_SESSION['user'];

    $sql = "INSERT INTO tb_post (post_id_cat, post_slug, post_title, post_text, post_date, user_id) VALUES ('$post_id_cat', '$post_slug', '$post_title', '$post_text', '$post_date', '$user_id')";

    if ($conn->query($sql) === TRUE) {
        $post_id = $conn->insert_id;

        if (!empty($_FILES['photo_file']['name'][0])) {
            $total = count($_FILES['photo_file']['name']);
            $target_dir = "assets/images/";

            for ($i = 0; $i < $total; $i++) {
                $photo_file = $_FILES['photo_file']['name'][$i];
                $target_file = $target_dir . basename($photo_file);

                if (move_uploaded_file($_FILES['photo_file']['tmp_name'][$i], $target_file)) {
                    $sql = "INSERT INTO tb_photos (photo_id_post, photo_title, photo_file) VALUES ('$post_id', '$post_title', '$photo_file')";
                }
            }
        }

        header("Location: post.php");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>

<h2>Tambah Postingan</h2>
<form method="POST" action="" enctype="multipart/form-data">
    <label for="post_id_cat">Kategori:</label>
    <select id="post_id_cat" name="post_id_cat" required>
        <?php
        $sql = "SELECT * FROM tb_category";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<option value='" . $row['cat_id'] . "'>" . $row['cat_name'] . "</option>";
            }
        } else {
            echo "<option value=''>Tidak ada kategori yang tersedia</option>";
        }
        ?>
    </select>
    <label for="post_slug">Slug:</label>
    <input type="text" id="post_slug" name="post_slug" required>
    <label for="post_title">Judul:</label>
    <input type="text" id="post_title" name="post_title" required>
    <label for="post_text">Deskripsi:</label>
    <textarea id="post_text" name="post_text" required></textarea>
    <label for="post_date">Tanggal:</label>
    <input type="date" id="post_date" name="post_date" required>
    <label for="photo_file">Foto:</label>
    <input type="file" id="photo_file" name="photo_file[]" accept="image/jpeg, image/png, image/jpeg">
    <label for="photo_title">Judul Foto:</label>
    <input type="text" id="photo_title" name="photo_title" required>
    <input type="submit" name="submit" value="Tambahkan" onclick="return validateForm()">
</form>

<script>
    function validateForm() {
        var category = document.getElementById("post_id_cat").value;
        if (category === "") {
            alert("Harap pilih kategori.");
            return false;
        }
        return true;
    }
</script>


<?php
$content = ob_get_clean();
include "layouts/app.php";
?>