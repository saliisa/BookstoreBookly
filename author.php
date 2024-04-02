<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Authors</title>
    <link rel="stylesheet" href="css/stylesheet.css">
    <link href="https://fonts.googleapis.com/css2?family=Hammersmith+One&family=Poppins&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/9eef98da8c.js" crossorigin="anonymous"></script>
<body>

<?php include('header.php'); ?>
<?php require_once('connection.php'); ?>

<div class="author-container">
<?php
$itemsPerPage = 5; 
$page = isset($_GET['page']) ?  intval($_GET['page']) : 1;
$offset = ($page - 1) * $itemsPerPage;

$sql = "SELECT * FROM book ORDER BY author ASC LIMIT ?, ?"; 
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $offset, $itemsPerPage);
$stmt->execute();
$result = $stmt->get_result();

$prevAuthor = null;

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {  
        $author = $row["author"];
        $bookInfo = '<div class="author-book">
                        <a href="book.php?bookID=' . htmlspecialchars($row["Book_id"]) . '"><img src=' . htmlspecialchars($row["cover_image"]) . '></a>
                        <a class="book-link" href="book.php?bookID=' . htmlspecialchars($row["Book_id"]) . '"><h4>' . html_entity_decode(htmlspecialchars($row["title"])) . ' </h4></a>
                    </div>';

        if ($author !== $prevAuthor) {
            if ($prevAuthor !== null) {
                echo '</div>'; 
            }
            echo '<div class="author">
                    <h2>' . htmlspecialchars($author) . '</h2> 
                    <hr>
                  </div>'; 
                  
            echo '<div class="author-books-container">';     
                echo $bookInfo;
                $prevAuthor = $author; 
               
        } else{
            echo $bookInfo;
        }
    } echo '</div>';
   
} else {
    echo "<p>No books</p>";
}
?>

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
</div>
<?php include('footer.php'); ?>
<?php $conn->close(); ?>
</body>
</html>