<?php
require_once('app/config.php');
$user->logout();
header('Location: '.$BASE_URL.'/login.php');

?>