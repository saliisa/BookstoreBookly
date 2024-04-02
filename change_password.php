<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    <link rel="stylesheet" href="css/stylesheet.css">
    <script src="https://kit.fontawesome.com/9eef98da8c.js" crossorigin="anonymous"></script>
    <link href="https://fonts.googleapis.com/css2?family=Hammersmith+One&family=Poppins&display=swap" rel="stylesheet">
</head>
<body>
<?php include('header.php'); ?>
<?php require_once('connection.php'); ?>
<?php require_once('protected.php'); ?>
<div class="container">
    <a class="back-link" href="javascript:history.back()"> <i class="fa-solid fa-angle-left"></i> Back</a> 
    <div class="logon">
    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") { 
        $email = isset($_POST['email']) ? filter_var($_POST['email'], FILTER_SANITIZE_EMAIL) : '';
        if (empty($email)) {
            echo '<p>Please fill in all fields</p>';
        } else {
            $sql = "SELECT * FROM customer WHERE email = ?";
            $stmt = $conn->prepare($sql);
            if($stmt){
                $stmt->bind_param("s", $email);
                $stmt->execute();
                $result = $stmt->get_result(); 
                if($result->num_rows == 0){
                    echo '<p> Email does not exist</p>'; 
                }else{
                   header('Location: change_password.php?reset=success');
                }
            }
            $stmt->close();
        }
    }

    if(isset($_GET['reset'])){
        if ($_GET['reset'] == 'success') {
            die(' <div class="status"><h2>Password Reset Link Sent </h2>
                    <p>We have sent you a password reset link, please check your email </p>
                    <br>
                     ');
            exit();
        } else {
            die('<div class="status">
            <h2>Oops something went wrong</h2>
            <p>Please try again later</p>
            <br>
           
            <div>');
            exit(); 
        }
    }
    ?>
 <h2>Password Reset</h2>
    <form action="change_password.php" method="post">
       
        <label for="email"><i class="fa-solid fa-at"></i></label>
        <input type="email" id="email" name="email" placeholder ="Email" required><br>
        <button type="submit">Continue</button>
    </form> 
</div>
</div>
<?php $conn->close(); ?>
<?php include('footer.php'); ?>
</body>
</html>