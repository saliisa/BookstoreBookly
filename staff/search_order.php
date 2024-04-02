<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Books</title>
    <link rel="stylesheet" href="./css/staff_stylesheet.css">
    <script src="https://kit.fontawesome.com/9eef98da8c.js" crossorigin="anonymous"></script>
    <link href="https://fonts.googleapis.com/css2?family=Hammersmith+One&family=Poppins&display=swap" rel="stylesheet">
</head>
<body>
<?php require_once('../connection.php'); ?>
<?php require_once('staff_protected.php'); ?>
<?php include('staff_header.php'); ?>

<div class="container">
    <a class="toggle" href="staff_order.php"> < Back</a>
    <?php 
    if (isset($_POST["submit"])) {
        $search = htmlspecialchars(strip_tags ($_POST["search"]));
        header('Location: search_order.php?search=' . urlencode($search));
        exit();
    } 
    ?>
    <?php
    if (isset($_GET["search"])) {
        $search = urldecode($_GET["search"]);
        if(!empty($search)){
            $ordersTable = "SELECT * FROM orders_table 
            INNER JOIN customer ON orders_table.customer_id = customer.Customer_id
            WHERE orders_table.Order_id LIKE  ?";
            $stmt = $conn->prepare($ordersTable);
            $searchTerm = "%$search%";
            $stmt->bind_param("s", $searchTerm);
            $stmt->execute();
            $tableResult = $stmt->get_result();
            echo '<h2>Search Results:  </h2> <p>'.htmlspecialchars($search).'</p>'; 
            ?>
            
        <div class="result-container"> 

            <?php
            if ($tableResult->num_rows > 0) { 
                while ($tableRow = $tableResult->fetch_assoc()) {             
                    echo (' 
                    <div class="order">
                        <h3 class="">Order ID: '. htmlspecialchars($tableRow['Order_id']).' </h3>
                        <hr>
                        <div class="order-info">  
                            <p><b>Name:</b> '. htmlspecialchars($tableRow['first_name']).' '. htmlspecialchars($tableRow['last_name']).'</p>   
                            <p><b>Email:</b> '. htmlspecialchars($tableRow['email']) .'</p>
                            <p> <b> Customer ID: </b> '. htmlspecialchars($tableRow['Customer_id']).'</p>
                            <p><b>Order date:</b> '. htmlspecialchars($tableRow['order_date']).'</p>');

                            $ordersDetail = "SELECT * FROM orders_detail
                                    INNER JOIN book ON orders_detail.book_id = book.Book_id 
                                    WHERE orders_detail.order_id = ?";

                            $stmtDetail= $conn->prepare($ordersDetail);
                            $stmtDetail->bind_param("s", $tableRow['Order_id']);
                            $stmtDetail->execute();
                            $detailResult = $stmtDetail->get_result();

                            if ($detailResult->num_rows > 0) { 
                                while ($detailRow = $detailResult->fetch_assoc()) { 
                                echo '<div class="items">';
                                echo '<p>'.htmlspecialchars($detailRow['amount']).'x</p>
                                    <p>'.htmlspecialchars($detailRow['title']).'</p>
                                    <p>'.htmlspecialchars($detailRow['author']).'</p> 
                                    <p>'.htmlspecialchars($detailRow['total_cost']).' €</p>'; 
                                    echo '</div>';
                                }
                            } else {
                                echo '<p>No orders</p>';
                            }

                            echo '
                            <a class="toggle" href="single_order.php?orderID='.htmlspecialchars($tableRow['Order_id']).'&cusID='.htmlspecialchars($tableRow['Customer_id']).'">View more ></a>
                        </div>
                    </div>';
                }
            } else {
                echo '<p>No orders found</p>';
            }
        } 
    } 
   
if (empty($search) || !isset($_GET["search"])) {
    header('Location: staff_order.php');
    exit();
}
    ?>
    </div>
</div>
<?php $conn->close(); ?>
</body>
</html>
