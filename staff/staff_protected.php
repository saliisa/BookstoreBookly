<?php
session_start();

if (!isset($_SESSION['Staff_id'])) {
    header("Location: staff.php");
    exit();
}

$timeOut = 1800; 
if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > $timeOut)) {
    session_unset();
    session_destroy();
    header("Location:staff.php"); 
    exit();
}
if (!isset($_SESSION['last_activity'])) {
    $_SESSION['last_activity'] = time();
}
$_SESSION['last_activity'] = time();
?>
