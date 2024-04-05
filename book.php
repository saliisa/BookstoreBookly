<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book</title> 
    <link rel="stylesheet" href="css/stylesheet.css">
    <script src="https://kit.fontawesome.com/9eef98da8c.js" crossorigin="anonymous"></script>
    <link href="https://fonts.googleapis.com/css2?family=Hammersmith+One&family=Poppins&display=swap" rel="stylesheet">
</head>
<body>
<?php include('header.php'); ?>
<?php require_once('connection.php'); ?>

<div class="container">
<a class="toggle"  href="javascript:history.back()">< Back</a> 
<?php 
$bookID = isset($_GET["bookID"]) ? intval($_GET["bookID"]) : 0;
$sql = "SELECT *, YEAR(pub_year) as pub_year FROM book WHERE book.Book_id = ? ";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $bookID);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        if(isset( $_GET["bookID"])){
            $info =('<div class="book-page">
                        <img src='.  htmlspecialchars($row["cover_image"]).'>
                        <div class="book-contents">
                            <h4 class="title">'. html_entity_decode(htmlspecialchars($row["title"])).'</h4>
                            <p class="book-author">by '. htmlspecialchars($row["author"]).'</p>
                            <br>
                            <p class="">'. htmlspecialchars($row["price"]).' €</p>
                            <br><hr>   
                            <label for="quantity">Quantity:</label>
                            <form class="addtocart"  action="cart.php" method="post">
                                <input type="hidden" name="action" value="add">
                                <input type="hidden" name="bookID" value="'. htmlspecialchars($row["Book_id"]) .'">
                                <input type="hidden" name="title" value="'.  htmlspecialchars($row["title"]) .'">
                                <input type="hidden" name="price" value="'.  htmlspecialchars($row["price"]) .'">
                                <input type="number" name="quantity" min="1" value="1" required>
                                <br>
                                <input class="toggle" type="submit" name="submit"  value="Add to cart">
                            </form>
                            <br><hr>
                            <div class="book-description"> 
                                <h3>Description:</h3>
                                <p>'.  html_entity_decode(htmlspecialchars($row["short_description"])) .'</p>
                            </div>
                            <br><hr>
                            <div class="product-info"> 
                                <h3>Product Infomation:</h3>
                                <p><b> Title: </b>'.  html_entity_decode(htmlspecialchars($row["title"])) .'</p>
                                <p><b> Author: </b>'.  htmlspecialchars($row["author"]) .'</p>
                                <p><b> Published Year: </b>'.  htmlspecialchars($row["pub_year"]) .'</p>
                                <p><b> ISBN: </b>'.  htmlspecialchars($row["isbn"]) .'</p>
                                <p><b> Category: </b>'.  htmlspecialchars($row["category"]) .'</p>
                                <p><b> Sub-category: </b>'.  htmlspecialchars($row["subcategory"]) .'</p>
                                <p><b> Price: </b>'.  htmlspecialchars($row["price"]) .' €</p>
                            </div>
                        </div>
                    </div>');
            if($row["Book_id"] == NULL){
                echo "<p>No books</p>";
            }else{
                echo $info;
            }
        }
    }
}else{
    echo "<p>No books</p>";
}
?>
</div>
<?php include('footer.php'); ?>
<?php $conn->close(); ?>
</div>
</body>
</html>