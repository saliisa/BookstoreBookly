<!DOCTYPE html>
<html lang="en">
<head>
<script src="https://kit.fontawesome.com/9eef98da8c.js" crossorigin="anonymous"></script>
</head>
<body>
<?php require_once('connection.php'); ?>
<?php session_start() ?>

<div class="header">
   <a href="index.php"><img class="logo" src="logo/bookly_logo.png" alt=""></a> 
   <?php 
   $cusID = 0;
    if(isset($_SESSION['Customer_id'])) {
        $cusID = $_SESSION['Customer_id'];
        echo '<a class="logout" href="profile.php?out"> Log out <i class="fa-solid fa-arrow-right-from-bracket"></i></a>';
    } else {
        echo ' <div class="links" >
                <p><a href="login.php">Login</a> / <a href="register.php">Register</a></p>
                </div> ';
    }

    $sql = "SELECT COUNT(cart_quantity) as total FROM cart WHERE customer_id = ? ";
    $stmt = $conn->prepare($sql);     
    $stmt->bind_param('s', $cusID);
    $stmt->execute();
    $result = $stmt->get_result();

    if($result->num_rows>0){
        while($row = $result->fetch_assoc()) {
            echo('<div class="cart">
                    <a href="cart.php"><i class="fa-solid fa-cart-shopping"></i></a>
                    <p>shopping cart ('. htmlspecialchars($row['total']).')</p>
                </div>');
        }
    } else {
        $row['total'] = 0;
    }
    ?>

    <div class="profile">
        <a href="profile.php"><i class="fa-solid fa-user"></i></a>
        <p>profile</p>
    </div>
</div>

<div class="nav-bar">
    <ul>
        <li> <a class="nav" href="index.php">Home</a> </li>
        <li>  <a class="nav" href="category.php" >Category</a> </li>
        <li> <a class="nav" href="author.php">Authors</a></li>
    </ul>  
</div>

<div class="search-bar">
    <form action="search_results.php" method="post">
        <input type="text" placeholder="Search by Title, Author or ISBN" name="search"> 
        <input type="submit" class="search-btn" value="Search" name="submit"> 
    </form>
</div>
</body>
</html>