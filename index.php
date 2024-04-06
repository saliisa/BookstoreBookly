<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bookly </title>
    <link rel="stylesheet" href="css/stylesheet.css">
    <link href="https://fonts.googleapis.com/css2?family=Hammersmith+One&family=Poppins&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/9eef98da8c.js" crossorigin="anonymous"></script>
</head>
<body>
<?php include('header.php'); ?>
<?php require_once('connection.php'); ?>

<div class="card">
  <h2>Welcome to bookly!</h2>
</div>

<div class="container">
  <div class="book-container">
  <?php
  $itemsPerPage = 8; 
  $page = isset($_GET['page']) ? intval($_GET['page']) : 1; 
  $offset = ($page - 1) * $itemsPerPage;

  $sql = "SELECT *, Year(pub_year) as pub_year FROM book LIMIT ?, ?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("ii", $offset, $itemsPerPage);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {
          $info = '<div class="book-info">
                      <a href="book.php?bookID=' . htmlspecialchars($row["Book_id"]) . '"><img src=' . htmlspecialchars($row["cover_image"]) . '></a>
                      <h4><a class="book-link" href="book.php?bookID=' . htmlspecialchars($row["Book_id"]) . '">' . html_entity_decode(htmlspecialchars($row["title"])) . '</a></h4>
                      <p> ' .htmlspecialchars($row["author"]) . '</p>

                      <form class="addToCart"  action="cart.php" method="post">
                          <input type="hidden" name="action" value="add">
                          <input type="hidden" name="bookID" value="'.htmlspecialchars($row["Book_id"]) .'">
                          <input type="hidden" name="title" value="'. htmlspecialchars($row["title"]) .'">
                          <input type="hidden" name="price" value="'. htmlspecialchars($row["price"]).'">
                          <input type="hidden" name="quantity" min="1" value="1">
                          <br>
                          <button class="toggle" type="submit" name="submit"> ' . htmlspecialchars($row["price"]) . ' € <i class="fa-solid fa-basket-shopping"></i></button>
                      </form>
                  </div>';
          
          if($row["Book_id"] == NULL){
              echo "<p>No books</p>";
          }else {
              echo $info;
          }
      }
  } else {
    echo "<p>No books</p>";
  }
  ?>
  </div>
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

<?php include('footer.php'); ?>
<?php $conn->close(); ?> 
</body>
</html>