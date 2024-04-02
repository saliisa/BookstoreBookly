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
<a class="toggle" href="staff_book.php"> < Back</a>

<?php 
if (isset($_POST["submit"])) {
    $search = htmlspecialchars(strip_tags($_POST["search"]));
    header('Location: search_book.php?search=' . urlencode($search));
    exit();
}
?>
<?php
if (isset($_GET["search"])) {
    $search = urldecode($_GET["search"]);
    if(!empty($search)){
        $sql = "SELECT * FROM book WHERE title LIKE ? OR author LIKE ? OR isbn LIKE ?";
        $stmt = $conn->prepare($sql);     
        $searchTerm = "%$search%";
        $stmt->bind_param('sss', $searchTerm, $searchTerm, $searchTerm);
        $stmt->execute();
        $result = $stmt->get_result();
        echo '<h2>Search Results:  </h2> <p>'.htmlspecialchars($search).'</p>'; 
        ?>
        
<div class="result-container"> 

    <?php
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo ('<div class="book-info">
                        <a class="" href="single_book.php?bookID='. htmlspecialchars($row["Book_id"]).'"><img class ="" src='.  htmlspecialchars($row["cover_image"]).'></a>
                        <br>
                       <p><b>Title:</b> ' .  htmlspecialchars($row["title"]) . '</p><br>
                       <p><b>Author:</b> ' . htmlspecialchars($row["author"]) . '</p><br>
                       <p><b>ISBN:</b> ' .  htmlspecialchars($row["isbn"]) . '<br>'.'</p><br>
                        <a class="toggle" href="edit_book.php?bookID='. htmlspecialchars($row["Book_id"]).'">Edit <i class="fa-regular fa-pen-to-square"></i></a>
                    </div>');
            }	
        }else {
            echo '<h2 class="no-results">No results</h2><br>';
            echo "<p> Sorry but we don't currently have that </p>";
        }
    }
} 
if (empty($search) || !isset($_GET["search"])) {
    header('Location: staff_book.php');
    exit();
}
?>
</div>
<?php $conn->close(); ?>
</div>
</body>
</html>
