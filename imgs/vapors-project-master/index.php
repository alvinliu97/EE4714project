<!DOCTYPE html>
<html lang="en-GB">
<?php include './php/head.php'; ?>

<body>
    <?php
    session_start();
    $conn = new mysqli("localhost", "f32ee", "f32ee", "f32ee");
    include './php/navbar.php';
    if ($conn->connect_error) {
        exit();
    }
    include './php/hero.php';
    include './php/footer.php';
    echo '<script type="text/javascript" src="./js/script.js"></script>';
    ?>
</body>

</html>