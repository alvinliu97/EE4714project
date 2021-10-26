<?php
ob_start();
setcookie("uid", "", time() - 3600);
setcookie("fitstName", "", time() - 3600);
setcookie("lastName", "", time() - 3600);
echo "<script type='text/javascript'>alert('Logout!');window.location.href='index.php';</script>";
