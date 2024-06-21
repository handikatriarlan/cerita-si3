<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($title) ? $title : 'Default Title'; ?></title>
    <link rel="stylesheet" type="text/css" href="assets/css/style.css">
</head>

<body>
    <?php include "app/header.php"; ?>
    <main>
        <div class="container">
            <?php echo isset($content) ? $content : ''; ?>
        </div>
    </main>
    <?php include "app/footer.php"; ?>
</body>

</html>