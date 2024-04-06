<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="css/stylesheet.css">
    <script src="https://kit.fontawesome.com/9eef98da8c.js" crossorigin="anonymous"></script>
    <link href="https://fonts.googleapis.com/css2?family=Hammersmith+One&family=Poppins&display=swap" rel="stylesheet">
</head>
<body>
<?php session_start(); ?>
<?php require_once('connection.php'); ?>

<div class="logon">
    <h1>Register</h1>
    <a class="back-link" href="index.php"> <i class="fa-solid fa-angle-left"></i> Back</a>

<div class="container">
    <?php
    function generateCustomerID() {
        return rand(10000000000, 99999999999); 
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $firstname = isset($_POST['first_name']) ? filter_var($_POST['first_name'], FILTER_SANITIZE_STRING) : '';
        $lastname = isset($_POST['last_name']) ? filter_var($_POST['last_name'], FILTER_SANITIZE_STRING) : '';
        $email = isset($_POST['email']) ? filter_var($_POST['email'], FILTER_SANITIZE_EMAIL) : '';
        $password = isset($_POST['password']) ? $_POST['password'] : ''; 
        $customerID = generateCustomerID();
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        if (empty($firstname) || empty($lastname) || empty($email) || empty($password)) {
            echo "<p>Please fill in all fields.</p>";
        } else {

            if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
                echo '<p>Invalid email format</p>';
            } else{
                $checkUserQuery = "SELECT * FROM customer WHERE  email = ?";
                $checkUserStmt = $conn->prepare($checkUserQuery);

                if ($checkUserStmt) {
                    $checkUserStmt->bind_param("s",  $email);
                    $checkUserStmt->execute();
                    $result = $checkUserStmt->get_result();
                    $row = $result->fetch_assoc();

                    if ($row['email'] === $email) {
                        echo '<p> Email already exists </p>';
                    } else {
                        $insertUserQuery = "INSERT INTO customer (customer_id, first_name, last_name, email, cus_password) VALUES (?, ?, ?, ?, ?)";
                        $insertUserStmt = $conn->prepare($insertUserQuery);

                        if ($insertUserStmt) {  
                            $insertUserStmt->bind_param("issss", $customerID, $firstname,$lastname, $email, $hashedPassword);
                            if ($insertUserStmt->execute()) {
                                $_SESSION["Customer_id"] = $customerID;
                                header("Location: profile.php");
                                exit();
                            } else {
                                echo "Error: Something went wrong ";
                            }
                            $insertUserStmt->close();
                        } else {
                            echo "Error: Something went wrong ";
                        }
                    }
                    $checkUserStmt->close();
                } else {
                    echo "Error: Something went wrong";
                }
            }
        }
        $conn->close();
    }
    ?>
</div>
    <form action="register.php" method="post">
        <label for="firstname"><i class="fa-solid fa-circle-user"></i></label>
        <input type="text" id="first_name" name="first_name"  placeholder ="First Name"><br>

        <label for="lastname"><i class="fa-solid fa-circle-user"></i></label>
        <input type="text" id="last_name" name="last_name"  placeholder ="Last Name"><br>
        
        <label for="email"><i class="fa-solid fa-at"></i></label>
        <input type="email" id="email" name="email"  placeholder ="Email"><br>

        <label for="password"><i class="fas fa-lock"></i></label>
        <input type="password" id="password" name="password"  placeholder ="Password"><br>
        <button type="submit">Register</button>
        <br>
        <p>Have an account? <a style="color: blue; text-decoration: underline;" href="login.php">Log in</a>.</p>
    </form>
</div>
</body>
</html>
