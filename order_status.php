<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Status</title>
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
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $firstname = isset($_POST['firstname']) ? filter_var($_POST['firstname'], FILTER_SANITIZE_STRING) : '';
    $lastname = isset($_POST['lastname']) ? filter_var($_POST['lastname'], FILTER_SANITIZE_STRING) : '';
    $email = isset($_POST['email']) ? filter_var($_POST['email'], FILTER_SANITIZE_EMAIL) : '';
    $address = isset($_POST['address']) ? filter_var($_POST['address'], FILTER_SANITIZE_STRING) : '';
    $city = isset($_POST['city']) ? filter_var($_POST['city'], FILTER_SANITIZE_STRING) : '';
    $country = isset($_POST['country']) ? filter_var($_POST['country'], FILTER_SANITIZE_STRING) : '';
    $postalCode = isset($_POST['postal_code']) ? filter_var($_POST['postal_code'], FILTER_SANITIZE_STRING) : '';
    $cusID = isset($_SESSION['Customer_id']) ? filter_var($_SESSION['Customer_id'], FILTER_SANITIZE_STRING) : '';
    
    if (empty($firstname) || empty($lastname) || empty($email) || empty($address) || empty($city)|| empty($country)|| empty($postalCode) ){
        header('Location: create_order.php?error=empty_fields');
        die(); 
    } else{

        if(!is_string($firstname) || !is_string($lastname) || !is_string($city) || !is_string($country)){
            header('Location: create_order.php?error=invalid_format');
            die();
        }

        if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
            header('Location: create_order.php?error=invalid_email');
            die();
        } 

        if(!is_numeric($postalCode)){
            header('Location: create_order.php?error=invalid_postalcode');
            die();
        }
        
        if (strlen($postalCode)  > 5 || strlen($postalCode)  < 5){
            header('Location: create_order.php?error=invalid_postalcode');
            die();
        }

        $orderDate = date('Y-m-d');
        $deliveryDate = date('Y-m-d', strtotime($orderDate . ' + 3 days'));

        $updateAddress = $conn->prepare("UPDATE customer SET address = ?, city = ?, country = ?, postal_code = ? WHERE Customer_id = ?");
        $updateAddress->bind_param("sssss", $address, $city, $country, $postalCode, $cusID);
        $addressSuccess = $updateAddress->execute();

        $insertOrderTable = $conn->prepare("INSERT INTO orders_table (order_date, delivery_date, customer_id) VALUES (?, ?, ?)");
        $insertOrderTable->bind_param("sss", $orderDate, $deliveryDate, $cusID);
        $orderTableSuccess = $insertOrderTable->execute();
        $lastOrderID = $conn->insert_id;

        if ($orderTableSuccess) {
            $selectCartItems = "SELECT * FROM cart WHERE customer_id = ?";
            $stmt = $conn->prepare($selectCartItems);
            $stmt->bind_param("s", $cusID);
            $stmt->execute();
            $cartResult = $stmt->get_result();

            if ($cartResult->num_rows > 0) {
                while ($row = $cartResult->fetch_assoc()) {
                    $bookID = $row['book_id'];
                    $amount = $row['cart_quantity'];
                    $totalCost = $row['total_price'];
                    $insertOrderDetail = $conn->prepare("INSERT INTO orders_detail (order_id, book_id, amount, total_cost) VALUES (?, ?, ?, ?)");
                    $insertOrderDetail->bind_param("iiid", $lastOrderID, $bookID, $amount, $totalCost);
                    $orderDetailSuccess = $insertOrderDetail->execute();

                    if (!$orderDetailSuccess) {
                        echo "Error adding book details.";
                        $conn->rollback();
                        echo "Error inserting into order_detail: " . $conn->error;
                        header('Location: order_status.php?status=fail');
                        exit();
                    }
                }
            }
            $clearCartQuery = "DELETE FROM cart WHERE customer_id = ?";
            $stmtClear = $conn->prepare($clearCartQuery);
            $stmtClear->bind_param("s", $cusID);
            $stmtClear->execute();

            if ($stmtClear->affected_rows > 0) {
                header("Location: order_status.php?status=success");
                exit();
            } else {
                header('Location: order_status.php?status=fail');
                exit();
            }
        } else {
            echo "Error inserting into order_table: " . $conn->error;
            header('Location: order_status.php?status=fail');
            exit();
        }
    }   
}
?>
<?php
if (isset($_GET['status'])) {
    if ($_GET['status'] == 'success') {
        echo '<div class="status"> <h3>Order was successful! </h3> <p>You can view your order in your order history.</p> </div>';
    } elseif ($_GET['status'] == 'fail') {
        die('<div class="status"><h3>Order failed. :(</h3> <p>Try again later.</p></div>');
    } else {
        exit(); 
    }
} else {
    exit(); 
}
?>
</div>
<?php include('footer.php'); ?>
<?php $conn->close(); ?>
</body>
</html>