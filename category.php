<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Category</title>
    <link rel="stylesheet" href="css/stylesheet.css">
    <link href="https://fonts.googleapis.com/css2?family=Hammersmith+One&family=Poppins&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/9eef98da8c.js" crossorigin="anonymous"></script>
</head>
<body>
<?php include('header.php'); ?>
<?php require_once('connection.php'); ?>

<div class="container">
<?php
$fiction = 'Fiction';
$nonFiction = 'Non-Fiction';

$sqlFiction = "SELECT DISTINCT subcategory FROM book WHERE category = ?";
$stmtFiction = $conn->prepare($sqlFiction);
$stmtFiction->bind_param("s", $fiction);
$stmtFiction->execute();
$resultFiction = $stmtFiction->get_result();

$sqlNonFiction = "SELECT DISTINCT subcategory FROM book WHERE category = ?";
$stmtNonFiction = $conn->prepare($sqlNonFiction);
$stmtNonFiction->bind_param("s", $nonFiction);
$stmtNonFiction->execute();
$resultNonFiction = $stmtNonFiction->get_result();

if (($resultFiction->num_rows > 0) || ($resultNonFiction->num_rows > 0)) {
   ?>
        <div class="category-container">
            <div class="fiction">
                <h2>Fiction</h2>
                <hr>
                <div class="sub-category">
                    <h3><a href="fiction.php">All Fiction <i class="fa-solid fa-angle-right"></i></a></h3>  
                    <?php 
                    while($rowFiction = $resultFiction->fetch_assoc()) {
                        echo '<h3><a href="fiction.php?subcategory=' . htmlspecialchars($rowFiction['subcategory']) . '">' . htmlspecialchars($rowFiction['subcategory']) . ' <i class="fa-solid fa-angle-right"></i></a></h3>';
                        
                    }
                    ?>
                </div>
            </div>
    
            <div class="non-fiction">
                <h2>Non-Fiction</h2>
                <hr>
                <div class="sub-category">
                    <h3><a href="non_fiction.php">All Non-Fiction <i class="fa-solid fa-angle-right"></i></a></h3> 
                    <?php 
                        while ($rowNonFiction = $resultNonFiction->fetch_assoc()) {
                            echo '<h3><a href="non_fiction.php?subcategory=' . htmlspecialchars($rowNonFiction['subcategory']) . '">' . htmlspecialchars($rowNonFiction['subcategory']) . ' <i class="fa-solid fa-angle-right"></i></a></h3>';
                        }
                    ?>
                </div>
            </div>
        </div>
    <?php 
} else {
    echo "<p>No results</p>";
}
?>
</div>
<?php include('footer.php'); ?>
<?php $conn->close(); ?>
</body>
</html>