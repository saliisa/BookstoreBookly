<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="css/stylesheet.css">
    <script src="https://kit.fontawesome.com/9eef98da8c.js" crossorigin="anonymous"></script>
    <link href="https://fonts.googleapis.com/css2?family=Hammersmith+One&family=Poppins&display=swap" rel="stylesheet">
</head>
<body>
<?php session_start(); ?>
<?php require_once('connection.php'); ?>
<div class="logon">
    <h1>Login</h1>
    <a class="back-link" href="index.php"> <i class="fa-solid fa-angle-left"></i> Back</a>
    <div class="container">
    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $email = isset($_POST['email']) ? filter_var($_POST['email'], FILTER_SANITIZE_EMAIL) : '';
        $password = isset($_POST['password']) ? $_POST['password'] : ''; 

        if (empty($email) || empty($password)) {
            echo '<p>Please fill in all fields</p>';
        } else  {

            if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
                echo '<p>Invalid email format</p>';

            } else{
                $sql = "SELECT * FROM customer WHERE email = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("s", $email);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    $hashedPassword = $row['cus_password'];

                    if($email === $row['email']){
                        if (password_verify($password, $hashedPassword)) {
                            $_SESSION["Customer_id"] = $row['Customer_id'];
                            $_SESSION["email"] = $email;
                            header("Location: profile.php"); 
                            exit();
                        } else {
                            echo '<br>';
                            echo '<p>Invalid email or password</p>';
                        }
                    }else {
                        echo '<br>';
                        echo '<p>Invalid email or password</p>';
                    }
                }else {
                    echo '<br>';
                    echo '<p>Invalid email or password</p>';
                }
                $stmt->close();
            }
            
        }
        $conn->close();
    }
    ?>
    </div>
    <form action="login.php" method="post">
        <label for="email"><i class="fa-solid fa-at"></i></label>
        <input type="email" id="email" name="email" placeholder ="Email" required><br>
        <label for="password"><i class="fas fa-lock"></i></label>
        <input type="password" id="password" name="password"  placeholder ="Password" required><br> 
        <a style="color: blue; text-decoration: underline;" href="forgot_password.php">Forgot password?</a>
        <button type="submit">Login</button>
        <br>
        <p>Don't have an account? <a style="color: blue; text-decoration: underline;" href="register.php">Sign up now</a>.</p>
    </form>
</div>
</body>
</html>