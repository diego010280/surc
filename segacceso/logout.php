<?php

session_start();
$_SESSION = array();
session_destroy();

header('Location:../../acceso/login.php');
exit;

?>