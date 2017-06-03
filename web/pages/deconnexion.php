<?php

session_start();
unset($_SESSION['MAIL_USER']);
unset($_COOKIE);
header ('Location: login.php');

?>