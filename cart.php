<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart</title>
    <link rel="stylesheet" href="css/stylesheet.css">
    <link href="https://fonts.googleapis.com/css2?family=Hammersmith+One&family=Poppins&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/9eef98da8c.js" crossorigin="anonymous"></script>
</head>
<body>
<?php include('header.php'); ?>
<?php require_once('connection.php'); ?>
<?php require_once('protected.php'); ?>

<div class="container">                                       
<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST'){
    if (isset($_POST['action']) && isset($_POST['bookID'])  ) { 
        $action = $_POST['action'];
        $bookID = isset($_POST['bookID']) ? filter_var($_POST['bookID'], FILTER_SANITIZE_STRING) : '';
        $cusID = isset($_SESSION['Customer_id']) ? filter_var($_SESSION['Customer_id'], FILTER_SANITIZE_STRING) : '';
        $title = isset($_POST['title']) ? filter_var($_POST['title'], FILTER_SANITIZE_STRING) : '';
        $originalPrice = isset($_POST['price']) ? filter_var($_POST['price'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION) : '';
        $totalPrice = $originalPrice;
        $quantity = isset($_POST['quantity']) ? filter_var($_POST['quantity'], FILTER_SANITIZE_STRING) : '';

        if ($quantity < 1){
            $quantity = 1;
        } else if ($quantity > 1){ 
            $totalPrice = $originalPrice * $quantity; 
            $quantity = $_POST['quantity'];
        } 
    
        if($action == 'add'){
            $checkQuery = "SELECT * FROM cart WHERE book_id = ? AND customer_id = ?";
            $stmtCheck = $conn->prepare($checkQuery);
            $stmtCheck->bind_param("is", $bookID, $cusID);
            $stmtCheck->execute();
            $checkResult = $stmtCheck->get_result();

            if ($checkResult->num_rows > 0) {
                $updateQuery = "UPDATE cart SET cart_quantity = cart_quantity + ?, total_price = ? * cart_quantity WHERE book_id = ? AND customer_id = ?";
                $stmtUpdate = $conn->prepare($updateQuery);
                $stmtUpdate->bind_param("idsi", $quantity, $originalPrice,  $bookID, $cusID);

                if ($stmtUpdate->execute()) {
                    header('Location: cart.php');
                    exit();
                } else {
                    echo "Error: Update Failed";
                }
        
            } else {
                $insertQuery = "INSERT INTO cart (customer_id, title, original_price, total_price, book_id, cart_quantity) VALUES (?,?,?,?,?,?)"; 
                $stmtInsert =$conn->prepare($insertQuery);
                $stmtInsert->bind_param("ssddii",$cusID, $title, $originalPrice, $totalPrice , $bookID, $quantity);

                if ($stmtInsert->execute()) {
                    header('Location: cart.php');
                    exit();
                } else {
                    echo "Error: Insert Failed" . $conn->error;
                }
            }

        } else if($action  == 'delete'){
            $deleteQuery = "DELETE FROM cart WHERE book_id = ? AND customer_id = ? ";
            $stmtDelete = $conn->prepare($deleteQuery);
            $stmtDelete->bind_param("is", $bookID, $cusID);

            if ($stmtDelete->execute()) {
                header('Location: cart.php');
                exit();
            } else {
                echo "Error: Delete Failed" . $conn->error;
            }

        }else if ($action  == 'increase') { 
            $increaseQuery = "UPDATE cart SET cart_quantity = cart_quantity + 1, total_price = total_price + ? WHERE book_id = ? AND customer_id = ?"; 
            $stmtIncrease = $conn->prepare($increaseQuery);
            $stmtIncrease->bind_param("dis", $originalPrice, $bookID, $cusID);

            if ($stmtIncrease->execute()) {
                header('Location: cart.php');
                exit();
            } else {
                echo "Error: Increase Failed" .  $conn->error;
            }

        } else if ($action == 'decrease') { 
            $decreaseQuery = "UPDATE cart SET cart_quantity = cart_quantity - 1, total_price = total_price - ? WHERE book_id = ? AND customer_id = ? AND cart_quantity > 1"; 
            $stmtDecrease = $conn->prepare( $decreaseQuery);
            $stmtDecrease->bind_param("dis", $originalPrice, $bookID, $cusID);

            if ($stmtDecrease->execute()) {
                header('Location: cart.php');
                exit();
            } else {
                echo "Error: Decrease Failed " .  $conn->error;
            }
        }
    } else{
        echo error_log("Error: " . $conn->error);
    }
}
?>

<!-- shopping cart view -->		
<h2>Shopping Cart</h2>
<div class="cart-content">
    <?php
    $total = 0;
    $cusID = $_SESSION['Customer_id']; 
    $sql = "SELECT * FROM cart 
    INNER JOIN book ON book.Book_id = cart.book_id
    WHERE customer_id =?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $cusID);
    $stmt->execute();
    $result = $stmt->get_result();
    $count = 1;

    if ($result->num_rows > 0) { ?>
       <div class="cart-item">
            <div class="cart-header">
                <p class="col"> Cart: </p>
            </div>
           
            <?php
            while ($row = $result->fetch_assoc()) { ?>
                <div class="item">
                    <?php
                    echo ('<p class="col"><img src='. htmlspecialchars($row["cover_image"]).'></p>
                            <p class="col">' . html_entity_decode(htmlspecialchars($row["title"])) . '</p>  
                            <p class="col">' . htmlspecialchars($row["author"]) . '</p>
                            <p class="col">' . htmlspecialchars($row["total_price"]) .' €</p>

                            <div class="col">
                                <div class="quantity-container">
                                    <form  action="cart.php" method="post">
                                        <input type="hidden" name="action" value="decrease">
                                        <input type="hidden" name="bookID" value="'. htmlspecialchars($row["book_id"]) .'">
                                        <input type="hidden" name="title" value="'. htmlspecialchars($row['title'])  .'"> 
                                        <input type="hidden" name="price" value="'. htmlspecialchars($row['original_price'])  .'"> 
                                        <input type="hidden" name="quantity" value="1"> 
                                        <button class="action" name="decrease" type="submit"> <i class="fa-solid fa-minus-circle"> </i></button>
                                    </form>

                                    <input class="quantity" type="number" name="quantity" min="1" value="' . htmlspecialchars($row["cart_quantity"]) . '" required>

                                    <form  action="cart.php" method="post">
                                        <input type="hidden" name="action" value="increase">
                                        <input type="hidden" name="bookID" value="'.htmlspecialchars($row["book_id"]) .'">
                                        <input type="hidden" name="title" value="'. htmlspecialchars($row['title'])  .'"> 
                                        <input type="hidden" name="price" value="'. htmlspecialchars($row['original_price'])  .'"> 
                                        <input type="hidden" name="quantity"  value="1"> 
                                        <button class="action" name="increase" type="submit"> <i class="fa-solid fa-plus-circle"> </i></button>
                                    </form>
                                    </div>
                                    </div>

                                    <div class="col">
                                    <form action="cart.php" method="post">
                                        <input type="hidden" name="action" value="delete">
                                        <input type="hidden" name="bookID" value="'.htmlspecialchars($row["book_id"]) .'">
                                        <input type="hidden" name="title" value="'. htmlspecialchars($row['title'])  .'"> 
                                        <input type="hidden" name="price" value="'. htmlspecialchars($row['original_price'])  .'"> 
                                        <input type="hidden" name="quantity"  value="1"> 
                                        <button class="toggle" name="delete" type="submit"> <i class="fa-solid fa-trash-can"></i></button>
                                    </form>
                                </div>
                            </div>
                            
                        ');
                
                    $total += $row['total_price'];
            }?>
                </div>
                <hr>
            <?php
            if($total == 0){
                echo '<p>Total: </p> ';
            } else {
                echo '<p class="total"><b>Total:</b> ' . htmlspecialchars($total) . ' €</p>';
            }
            echo('<form class="order-all" action="create_order.php" method="post">
                    <input type="hidden" name="total_prices_all_books" value="'. htmlspecialchars($total) .'">
                    <button class="toggle" type="submit">Order All Books</button>
                  </form>');
                ?>
        </div>
        <?php
    } else {
        echo "<p>Cart is empty.</p>";
    }
    ?>
</div>
</div>
<?php include('footer.php'); ?>
<?php $conn->close(); ?>
</body>
</html>