<!DOCTYPE html>
<html lang="en">
<head>
    <title> </title>
    <script src="https://kit.fontawesome.com/9eef98da8c.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="./css/staff_stylesheet.css">
</head>
<body>
<?php require_once('../connection.php'); ?>
<?php require_once('staff_protected.php'); ?>
<div class="header">
   <h1>Bookly Staff</h1>
    <?php
    if(isset($_GET["out"])){
        session_unset();
        session_destroy();
        header('Location: staff.php');
        exit();
    }?>
    <p><a class="logout" href="staff_index.php?out">Log out <i class="fa-solid fa-arrow-right-from-bracket"></i></a></p>
</div>
<div class="nav-bar">
    <ul>
        <li> <a class="nav" href="staff_index.php">Home</a> </li>
        <li>  <a class="nav" href="staff_book.php" >Books</a> </li>
        <li> <a class="nav" href="staff_order.php">Orders</a></li>
    </ul>  
</div>
<hr>
</body>
</html>