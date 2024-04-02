<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fiction</title>
    <link rel="stylesheet" href="css/stylesheet.css">
    <link href="https://fonts.googleapis.com/css2?family=Hammersmith+One&family=Poppins&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/9eef98da8c.js" crossorigin="anonymous"></script>
</head>
<body>
<?php include('header.php'); ?>
<?php require_once('connection.php'); ?>

<div class="container">
<?php 
$subcategory = isset($_GET["subcategory"]) ? $_GET["subcategory"] : '';

function displayBooksByCategory($conn, $category, $subcategory = null) {
    $sql = "SELECT * FROM book ";
    if ($subcategory) {
        $sql .= " WHERE book.subcategory = ? ";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $subcategory);
    } else {
        $sql .= " WHERE category = ? ";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $category);
    }
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        echo '
            <a class="toggle" href="./category.php"> <i class="fa-solid fa-angle-left"></i> Back</a>
            <h1 class="book-subcategory-title">' . htmlspecialchars($category) . '</h1>
            <div class="book-container"> 
        ';

        while($row = $result->fetch_assoc()) {
            $info = '
                <div class="book-info">
                    <a href="book.php?bookID='.htmlspecialchars($row["Book_id"]).'"><img src='. htmlspecialchars($row["cover_image"]).'></a>
                    <h4><a class="book-link" href="book.php?bookID='.htmlspecialchars($row["Book_id"]).'">'.html_entity_decode(htmlspecialchars($row["title"])).'</a></h4>
                    <p>'.htmlspecialchars($row["author"]).'</p>
                    <br>
                    <form class="addToCart"  action="cart.php" method="post">
                        <input type="hidden" name="action" value="add">
                        <input type="hidden" name="bookID" value="'.htmlspecialchars($row["Book_id"]) .'">
                        <input type="hidden" name="title" value="'. htmlspecialchars($row["title"]) .'">
                        <input type="hidden" name="price" value="'.htmlspecialchars($row["price"]).'">
                        <input type="hidden" name="quantity" min="1" value="1" >
                        <br>
                        <button class="toggle" type="submit" name="submit"> ' . htmlspecialchars($row["price"]) . ' € <i class="fa-solid fa-basket-shopping"></i></button>
                    </form>
                </div>
            ';
            echo $info;
        }
        echo '</div>';
    } else {
        echo "<p>No books in this category</p>";
    }
    $stmt->close();
}

if (empty($subcategory)) {
    displayBooksByCategory($conn, 'Fiction');
} else{
    displayBooksByCategory($conn, $subcategory, $subcategory);
}
?>
</div>
<?php include('footer.php'); ?>
<?php $conn->close(); ?>
</body>
</html>