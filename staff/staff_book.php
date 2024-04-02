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
<div class="top">
    <a class="toggle"href="add_book.php">Add books <i class="fa-solid fa-plus"></i></a> 
    <div class="search-bar">
        <form action="search_book.php" method="post">
            <input type="text" placeholder="Search by Title, Author or ISBN" name="search"> 
            <input type="submit" class="search-btn" value="Search" name="submit" /> 
        </form>
        
    </div>
</div>

<div class="book-container">
<?php
$itemsPerPage = 8; 
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$offset = ($page - 1) * $itemsPerPage;
    
$sql ="SELECT  *, Year(pub_year) as pub_year FROM book LIMIT ?, ?" ;
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $offset, $itemsPerPage);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows> 0 ) { 
    while($row = $result->fetch_assoc()) {
        $info =('
        <div class="book-info">
            <a href="single_book.php?bookID='.htmlspecialchars($row["Book_id"]).'"><img src='. htmlspecialchars($row["cover_image"]).'></a>
            <h4><a class="book-link" href="single_book.php?bookID='.htmlspecialchars($row["Book_id"]).'">'. html_entity_decode(htmlspecialchars($row["title"])).'</a></h4>
            <p> '.htmlspecialchars($row["author"]).'</p>
            <br>
            <a class="toggle" href="edit_book.php?bookID='.htmlspecialchars($row["Book_id"]).'">Edit  <i class="fa-regular fa-pen-to-square"></i></a>
        </div>');
        if($row["Book_id"] == NULL){
            echo "<p>No books</p>";
        }else {
            echo $info;
        }
    }     
} else{
    echo "<h3>No books</h3>";
}
?>
</div>
<?php
$sql = "SELECT COUNT(*) AS total FROM book";
$result = $conn->query($sql);
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
        echo '<a  class="link"href="?page=' . ($page + 1) . '"> > </a>';
    }
echo '</div>';
?>
<?php $conn->close(); ?>
</body>
</html>