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
<a class="toggle" href="javascript:history.back()">< Back</a> 
<?php 
$bookID = isset($_GET["bookID"]) ? intval($_GET["bookID"]) : 0;
$sql = "SELECT *, YEAR(pub_year) as pub_year FROM book WHERE Book_id = ? ";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $bookID);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        if(isset( $_GET["bookID"])){
            $info =('
            <div class="book-page">
                <img src='. htmlspecialchars($row["cover_image"]).'>
                <div class="book-contents">
                    <h4 class="book-title">'. html_entity_decode(htmlspecialchars($row["title"])).'</h4>
                    <p class="book-author">by '.htmlspecialchars($row["author"]).'</p>
                    <br><br><hr><br>
                    <a class="toggle" href="edit_book.php?bookID='.htmlspecialchars($row["Book_id"]).'">Edit <i class="fa-regular fa-pen-to-square"></i></a>
                    <br><hr>
                    <div class="book-description"> 
                        <h3>Description:</h3>
                        <p >'. html_entity_decode(htmlspecialchars($row["short_description"])).'</p>
                    </div>
                    <br><hr>
                    <div class="product-info"> 
                        <h3>Product Infomation:</h3>
                        <p><b> Title: </b>'. html_entity_decode(htmlspecialchars($row["title"])).'</p>
                        <p><b> Author: </b>'.htmlspecialchars($row["author"]).'</p>
                        <p><b> Year: </b>'.htmlspecialchars($row["pub_year"]).'</p>
                        <p><b> ISBN: </b>'.htmlspecialchars($row["isbn"]).'</p>
                        <p><b> Category: </b>'.htmlspecialchars($row["category"]).'</p>
                        <p><b> Sub-category: </b>'.htmlspecialchars($row["subcategory"]).'</p>
                        <p><b> Price: </b>'.htmlspecialchars($row["price"]).' €</p>
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
} else{
    echo "<p>No books</p>";
}
?>
<?php $conn->close(); ?>
</div>
</body>
</html>

