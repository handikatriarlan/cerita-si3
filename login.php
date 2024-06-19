<?php
session_start();
include "config/connection.php";

if (isset($_POST['submit'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $username = mysqli_real_escape_string($conn, $username);
    $password = mysqli_real_escape_string($conn, $password);

    $sql = "SELECT * FROM tb_users WHERE username='$username' AND password='$password'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $_SESSION['user'] = $row['username'];
        header("Location: index.php");
        exit();
    } else {
        $error_message = "Username atau password salah.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Cerita SI-3</title>
    <link rel="stylesheet" type="text/css" href="assets/css/style.css">
</head>

<body>
    <main>
        <div class="login-container">
            <div class="login-form">
                <h2>Login</h2>
                <?php if (isset($error_message)) { ?>
                    <p style="color:red; text-align:center; margin: 10px 0;"><?php echo $error_message ?></p>
                <?php } ?>
                <form method="POST" action="">
                    <label for="username">Username:</label>
                    <input type="text" id="username" name="username" required>
                    <label for="password">Password:</label>
                    <input type="password" id="password" name="password" required>
                    <input type="submit" name="submit" value="Login">
                </form>
            </div>
        </div>
    </main>
</body>

</html>