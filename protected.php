<?php
if (!isset($_SESSION['Customer_id']) ) {
    header("Location: login.php");
    exit();
}

$timeOut = 1800; 
if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > $timeOut)) {
    session_unset();
    session_destroy();
    header("Location: login.php"); 
    exit();
}
if (!isset($_SESSION['last_activity'])) {
    $_SESSION['last_activity'] = time();
}
$_SESSION['last_activity'] = time();
?>