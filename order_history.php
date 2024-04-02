<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order History</title>
    <link rel="stylesheet" href="./css/stylesheet.css">
    <link href="https://fonts.googleapis.com/css2?family=Hammersmith+One&family=Poppins&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/9eef98da8c.js" crossorigin="anonymous"></script>
</head>
<body>
<?php include('header.php'); ?>
<?php require_once('connection.php'); ?>
<?php require_once('protected.php'); ?>

<div class="container">
<a class="page" href="profile.php">Profile Page</a>
<a class="page" href="order_history.php">Order History</a>
<hr>

<div class="order-container">
<?php
$itemsPerPage = 4; 
$page = isset($_GET['page']) ? intval($_GET['page']): 1; 
$offset = ($page - 1) * $itemsPerPage;

$cusID = isset($_SESSION['Customer_id']) ? intval($_SESSION['Customer_id']) : 0;

$ordersTable = "SELECT * FROM orders_table 
                INNER JOIN customer ON orders_table.customer_id = customer.Customer_id
                WHERE orders_table.customer_id = ?
                LIMIT ? , ?";

$stmt = $conn->prepare($ordersTable);
$stmt->bind_param("sii", $cusID, $offset, $itemsPerPage);
$stmt->execute();
$tableResult = $stmt->get_result();

if ($tableResult->num_rows > 0) { 
    while ($tableRow = $tableResult->fetch_assoc()) {
        echo '<div class="order">
                <h3 class="">Order ID: '. htmlspecialchars($tableRow['Order_id']).' </h3>
                <hr>
                <div class="order-info">  
                    <p><b>Name:</b> '. htmlspecialchars($tableRow['first_name']).' '. htmlspecialchars($tableRow['last_name']).'</p>   
                    <p><b>Email:</b> '. htmlspecialchars($tableRow['email']).'</p>
                    <p><b>Order date:</b> '. htmlspecialchars($tableRow['order_date']).'</p>';

        $ordersDetail = "SELECT * FROM orders_detail
                         INNER JOIN book ON orders_detail.book_id = book.Book_id 
                         WHERE orders_detail.order_id = ?";

        $stmtDetail= $conn->prepare($ordersDetail);
        $stmtDetail->bind_param("s", $tableRow['Order_id']);
        $stmtDetail->execute();
        $detailResult = $stmtDetail->get_result();

        if ($detailResult->num_rows > 0) { 
            while ($detailRow = $detailResult->fetch_assoc()) { 
                echo '<div class="items">
                      <p>'. htmlspecialchars($detailRow['amount']).'x</p>
                      <p>'. html_entity_decode(htmlspecialchars($detailRow['title'])).'</p>
                      <p>'. htmlspecialchars($detailRow['author']).'</p> 
                      <p>'. htmlspecialchars($detailRow['total_cost']).' €</p>
                    </div>';
            }
        } else {
            echo "<p>No orders</p>";
        }
        echo '<a class="toggle" href="order.php?orderID='. htmlspecialchars($tableRow['Order_id']).'">View more ></a>
              </div>
              </div>
              ';
    }
} else {
    echo "<p>No orders found</p>";
}
?>
</div>

<?php
$sql = "SELECT COUNT(*) AS total FROM orders_table WHERE customer_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $cusID);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
$totalItems = $row['total'];
$totalPages = ceil($totalItems / $itemsPerPage);

echo '<div class="pagination">';
    if ($page > 1) {
        echo '<a class="link" href="?page=' . ($page - 1) . '"> < </a>';
    }
    for ($i = 1; $i <= $totalPages; $i++) {
        echo '<a class="link" href="?page=' . $i . '"' . ($i == $page ? ' class="active"' : '') . '>' . $i . '</a>';
    }
    if ($page < $totalPages) {
        echo '<a  class="link" href="?page=' . ($page + 1) . '"> > </a>';
    }
echo '</div>';
?>
</div>
<?php include('footer.php'); ?>
<?php $conn->close(); ?>
</body>
</html>