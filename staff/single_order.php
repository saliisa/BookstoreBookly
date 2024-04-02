<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Books</title>
    <script src="https://kit.fontawesome.com/9eef98da8c.js" crossorigin="anonymous"></script>
    <link href="https://fonts.googleapis.com/css2?family=Hammersmith+One&family=Poppins&display=swap" rel="stylesheet">
</head>
<body>
<?php require_once('../connection.php'); ?>
<?php require_once('staff_protected.php'); ?>
<?php include('staff_header.php'); ?>

<div class="container">
<a class="toggle" href="javascript:history.back()">< Back</a> 
<?php 
$orderID = isset($_GET["orderID"]) ? intval($_GET["orderID"]) : 0;
$cusID = isset($_GET["cusID"]) ? intval($_GET["cusID"]) : 0;

$ordersTable ="SELECT * from orders_table 
INNER JOIN customer 
ON orders_table.customer_id = customer.Customer_id
WHERE orders_table.customer_id = ?  AND orders_table.Order_id  = ? ";

$stmt = $conn->prepare($ordersTable);
$stmt->bind_param("ss", $cusID, $orderID);
$stmt->execute();
$tableResult = $stmt->get_result();

if ($tableResult->num_rows > 0) { 
    if ($tableRow = $tableResult->fetch_assoc()) {
        if(isset( $_GET["orderID"]) && isset( $_GET["cusID"]) ){
            echo ('
            <div class="order">
                <h3 class="">Order ID: '. htmlspecialchars($tableRow['Order_id']) .' </h3>
                <hr>
                <div class="order-info">  
                    <div class="cus-info">
                        <p><b>Name:</b> '. htmlspecialchars($tableRow['first_name']) .' '. htmlspecialchars($tableRow['last_name']) .'</p>   
                        <p><b>Email:</b> '. htmlspecialchars($tableRow['email']) .'</p>
                        <p> <b> Customer ID: </b> '. htmlspecialchars($tableRow['Customer_id']) .'</p>
                    </div>
                        
                    <div class="cus-info">  
                        <p> <b> Address: </b> '. htmlspecialchars($tableRow['address']) .'</p>
                        <p> <b> City: </b> '. htmlspecialchars($tableRow['city']) .'</p>
                        <p> <b> Country: </b> '. htmlspecialchars($tableRow['country']) .'</p>
                        <p> <b> Postal Code: </b> '. htmlspecialchars($tableRow['postal_code']) .'</p>  
                    </div> 
                        
                    <p><b>Order date:</b> '. htmlspecialchars($tableRow['order_date']) .'</p>
                    <p><b>Delivery date: </b>'. htmlspecialchars($tableRow['delivery_date']) .'</p>');

                    $ordersDetail = "SELECT * FROM orders_detail
                                    INNER JOIN book ON orders_detail.book_id = book.Book_id 
                                    INNER JOIN orders_table ON orders_table.Order_id = orders_detail.order_id
                                    WHERE  orders_detail.order_id =  ? ";

                    $stmtDetail= $conn->prepare($ordersDetail);
                    $stmtDetail->bind_param("s", $orderID);
                    $stmtDetail->execute();
                    $detailResult = $stmtDetail->get_result();
                    $totalCostAllBooks=0;

                    if ($detailResult->num_rows > 0) { 
                        while ($detailRow = $detailResult->fetch_assoc()) { 
                            $totalCostAllBooks += htmlspecialchars($detailRow['total_cost']);

                            echo ('<div class="items">
                                    <p>'. htmlspecialchars($detailRow['amount']) .'x</p>
                                    <img src='. htmlspecialchars($detailRow["cover_image"]) .'> 
                                    <p>'. htmlspecialchars($detailRow['title']) .'</p>
                                    <p>'. htmlspecialchars($detailRow['author']) .'</p> 
                                    <p>'. htmlspecialchars($detailRow['total_cost']) .' €</p>
                                </div>');
                        }
                    } else {
                        echo '<p>No orders</p>';
                    }

                    echo( '
                    <p><b> Total: </b> '. htmlspecialchars($totalCostAllBooks).' €</p>
                </div>  
            </div>');
        }
    }
} else {
    echo "<p>No orders found</p>";
}
?>
<?php $conn->close(); ?>
</div>
</body>
</html>
