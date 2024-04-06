<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff Login</title>
    <link rel="stylesheet" href="./css/staff_stylesheet.css">
    <script src="https://kit.fontawesome.com/9eef98da8c.js" crossorigin="anonymous"></script>
    <link href="https://fonts.googleapis.com/css2?family=Hammersmith+One&family=Poppins&display=swap" rel="stylesheet">
</head>
<body>
<?php require_once('../connection.php'); ?>
<?php session_start();?>

</div>
<div class="login">
    <h1>Staff Login</h1>
    <br>

<div class="container">
    <?php
    if ($_SERVER['REQUEST_METHOD'] == "POST") {
       $email = isset($_POST['email']) ? filter_var($_POST['email'], FILTER_SANITIZE_EMAIL) : '';
       $password = isset($_POST['password']) ? $_POST['password'] : '';

        if (empty($email) || empty($password)) {
            echo '<p><b>Please fill in all fields</b></p>';
        } else {
            if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
                echo '<p>Invalid email format</p>';
            }else {
                $sql = "SELECT * FROM staff WHERE staff_email = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("s", $email);
                $stmt->execute();
                $result = $stmt->get_result();
                
                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    $hashedPassword = $row['staff_password'];

                    if($email === $row['staff_email']){
                        
                        if (password_verify($password, $hashedPassword)) {
                            $_SESSION['Staff_id'] = $row['Staff_id'];
                            $_SESSION['staff_email'] = $email;
                            header("Location: staff_index.php"); 
                            exit();
                        } else {
                            echo '<br>';
                            echo '<p><b>Invalid email or password </b></p>';
                        }
                    }else {
                        echo '<br>';
                        echo '<p><b>Invalid email or password </b></p>';
                    }
                
                } else {
                    echo '<br>';
                    echo '<p><b>Invalid email or password</b></p>';
                }
                $stmt->close();
            }
           
        }
        $conn->close();
    }
    ?>
</div>
    <form action="staff.php" method="post">
        <label for="email"><i class="fa-solid fa-at"></i></label>
        <input type="email" id="email" name="email" required placeholder ="Email"><br>
        <label for="password"><i class="fas fa-lock"></i></label>
        <input type="password" id="password" name="password" required placeholder ="Password"><br>
        <button type="submit">Login</button>
        <br>
    </form>
</body>
</html>


