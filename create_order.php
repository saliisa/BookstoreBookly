<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Order</title>
    <link rel="stylesheet" href="css/stylesheet.css">
    <link href="https://fonts.googleapis.com/css2?family=Hammersmith+One&family=Poppins&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/9eef98da8c.js" crossorigin="anonymous"></script>
</head>
<body>
<?php include('header.php'); ?>
<?php require_once('connection.php'); ?>
<?php require_once('protected.php'); ?>   

<div class="container">
    <h2>Fill in below:</h2>
    <?php
    if(isset($_GET['error'])){
        if($_GET['error'] === 'empty_fields'){
            echo '<div class="error">Please fill in all fields.</div>';
        }else if($_GET['error'] === 'invalid_firstname'){
            echo '<p class="error">Invalid first name</p>';
        } else if($_GET['error'] === 'invalid_lastname'){
            echo '<p class="error">Invalid last name</p>';
        }  else if($_GET['error'] === 'invalid_email'){
            echo '<p class="error">Invalid email format</p>';
        }  else if($_GET['error'] === 'invalid_city'){
            echo '<p class="error">Invalid city</p>';
        } else if($_GET['error'] === 'invalid_country'){
            echo '<p class="error">Invalid country</p>';
        }else if ($_GET['error'] === 'invalid_postalcode'){
            echo '<p class="error">Invalid postal code</p>';
        }
    }   
    ?>
    <div class="create-order">
        <div class="cart-review"> 
            <h3>Review</h3>
            <?php
                $cusID = isset($_SESSION['Customer_id']) ? intval($_SESSION['Customer_id']) : 0;     
                $totalPriceAllBooks=0;
                        
                $selectReview = "SELECT * FROM cart WHERE customer_id = ?";
                $stmt = $conn->prepare($selectReview);
                $stmt->bind_param("s", $cusID);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $bookID = $row['book_id'];
                        $title= $row['title'];
                        $amount = $row['cart_quantity'];
                        $total_price =$row['total_price'];
                        $totalPriceAllBooks += $total_price;
                                    
                        echo('  
                            <div class="cart-review-item">
                                <p>'.htmlspecialchars($amount).'x</p>
                                <p>'.html_entity_decode(htmlspecialchars($title)).' </p>
                                <p>'.htmlspecialchars($total_price).' €</p>
                            </div>');
                    }
                }
                echo '<hr>
                    <p><b>Total:</b> ' . htmlspecialchars($totalPriceAllBooks) . ' €</p>
                    '; 
            ?>
        </div>
        <div class="info">
            <form class="" action="order_status.php" method="POST">
                <label for="firstname">First Name:</label><br> 
                <input type="text" id="firstname" name="firstname" required><br>

                <label for="lastname">Last Name:</label><br>
                <input type="text" id="lastname" name="lastname"  required><br>
                    
                <label for="email">Email:</label><br>
                <input type="email" id="email" name="email"  required><br>

                <label for="address">Address:</label><br>
                <textarea name="address" id="address" cols="50" rows="5"  required></textarea><br>

                <label for="city">City:</label><br>
                <input type="text" id="city" name="city"  required ><br>

                <label for="country">Country:</label><br>
                <input type="text" id="country" name="country"  required><br>

                <label for="postal_code">Postal Code:</label><br>
                <input type="text" id="postal_code" name="postal_code" maxlength="5" required ><br><br>

                <input type="hidden" id="cusID" name="cusID" ><br><br>

                <div class="submit">
                    <a class="toggle" href="cart.php">Cancel</a>
                    <button class="toggle" type="submit">Confirm Order</button>
                </div>
            </form>
            <br>
            <br>
        </div> 
    </div>
</div> 
<?php include('footer.php'); ?>
<?php $conn->close(); ?>
</body>
</html>