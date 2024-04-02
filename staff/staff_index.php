<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff Home</title>
    <link rel="stylesheet" href="./css/staff_stylesheet.css">
    <script src="https://kit.fontawesome.com/9eef98da8c.js" crossorigin="anonymous"></script>
    <link href="https://fonts.googleapis.com/css2?family=Hammersmith+One&family=Poppins&display=swap" rel="stylesheet">
</head>
<body>
<?php require_once('../connection.php'); ?>
<?php require_once('staff_protected.php'); ?>
<?php include('staff_header.php'); ?>
<div class="container">
    <div class="index">
        <h3>Add new books</h3>
        <a class="toggle" href="add_book.php">Add books   <i class="fa-solid fa-plus"></i></a>

        <h3>Orders</h3>
        <a class="toggle" href="staff_order.php">View orders   <i class="fa-solid fa-angle-right"></i></a>
    </div>
</div>
</body>
</html>