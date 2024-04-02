<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Results</title>
    <link rel="stylesheet" href="css/stylesheet.css">
    <link href="https://fonts.googleapis.com/css2?family=Hammersmith+One&family=Poppins&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/9eef98da8c.js" crossorigin="anonymous"></script>
</head>
<body>
<?php include('header.php'); ?>
<?php require_once('connection.php'); ?>

<div class="container">
    <a class="toggle" href="index.php"> <i class="fa-solid fa-angle-left"></i> Back</a>
    <?php 
        if(isset($_POST["submit"])){
            $search = htmlspecialchars(strip_tags($_POST["search"]));
            header('Location: search_results.php?search=' . urlencode($search));
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
                echo '<div class="book-info"> 
                            <a class ="" href="book.php?bookID='.htmlspecialchars($row["Book_id"]).'"><img src='. htmlspecialchars($row["cover_image"]).'></a>
                            <br>
                            <b>Title:</b> ' . htmlspecialchars($row["title"]) . '<br>
                            <b>Author:</b> ' . htmlspecialchars($row["author"]) . '<br>
                            <b>ISBN:</b> ' . htmlspecialchars($row["isbn"]) . '<br><br>
                            <a class="toggle" href="book.php?bookID='.htmlspecialchars($row["Book_id"]).'">View more</a>
                        </div>';
                }	
            }else {
                echo '<h2 class="no-results">No results</h2>';
                echo "<p> Sorry but we don't currently have that </p>";
            }
        } 
    }
    if (empty($search) || !isset($_GET["search"])) {
        header('Location: index.php');
        exit();
    }
?>
    </div>
</div>
<?php include('footer.php'); ?>
<?php $conn->close(); ?>
</body>
</html>