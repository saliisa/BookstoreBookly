<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Books</title>
    <link rel="stylesheet" href="./css/staff_stylesheet.css">
    <script src="https://kit.fontawesome.com/9eef98da8c.js" crossorigin="anonymous"></script>
    <link href="https://fonts.googleapis.com/css2?family=Hammersmith+One&family=Poppins&display=swap" rel="stylesheet">
</head>
<body>
<?php require_once('../connection.php'); ?>
<?php require_once('staff_protected.php'); ?>
<?php include('staff_header.php'); ?>

<div class="container">
<a class="toggle" href="javascript:history.back()"> < Back</a>
<?php
if (isset($_GET['bookID'])) {
    $bookID = isset($_GET["bookID"]) ? intval($_GET["bookID"]) : 0;
    $sql = "SELECT * FROM book WHERE Book_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $bookID);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result) {
      $row = $result->fetch_assoc();
    } else {
        die("Something went wrong.");
    }
} else {
    die("Book ID not provided.");
}
?>
<h2>Edit Book</h2> 
<?php 
	if(isset($_GET['error'])){
		if($_GET['error'] === 'empty_fields'){
			echo '<p class="error">Please fill in all fields.</p>';
		}else if($_GET['error'] === 'invalid_author'){
			echo '<p class="error">Invalid author</p>';
		}  else if($_GET['error'] === 'invalid_isbn'){
			echo '<p class="error">Invalid ISBN</p>';
		}  
	}  
?>
    <form class="form-book" action="update_book.php" method="post">
        <input type="text" name="bookID" value="<?php echo htmlspecialchars($bookID); ?>" hidden ><br> 

        <label for="isbn">ISBN(13):</label>
        <input type="text" name="isbn" value="<?php echo htmlspecialchars($row['isbn']); ?>"  maxlength="13" ><br> 

        <label for="title">Title:</label>
        <input type="text" name="title" value="<?php echo  html_entity_decode(htmlspecialchars($row['title'])); ?>" ><br>

        <label for="author">Author:</label>
        <input type="text" name="author" value="<?php echo htmlspecialchars($row['author']); ?>" ><br>

        <label for="published_year">Published Year:</label>
        <input type="date" name="published_year" value="<?php echo htmlspecialchars($row['pub_year']); ?>" ><br>

        <label for="price">Price:</label>
        <input type="number" name="price"  value="<?php echo htmlspecialchars($row['price']); ?>"step="0.01" ><br>

        <label for="category">Category:</label>
        <select name="category" id="categorySelect">
            <option selected ><?php echo htmlspecialchars($row['category']);?> </option>
            <?php 
                if($row['category'] == 'Fiction'){
                    echo '<option  name="category"  value="Non-Fiction">Non-Fiction</option>';
                } else{
                    echo '<option  name="category"  value="Fiction">Fiction</option>';
                }
            ?>
        </select> <br>
       
        <label for="subcategory">Subcategory:</label>
        <select name="subcategory" id="subcategorySelect">
            <option selected ><?php echo htmlspecialchars($row['subcategory']);?> </option>
            <?php 
                $selectedCategory = htmlspecialchars($row['category']);
                $selectedSubcategory = htmlspecialchars($row['subcategory']);
            
                if ($selectedCategory == 'Fiction') {
                    $fictionSubcategories = array("Fantasy", "Sci Fi", "Romance");
                    foreach ($fictionSubcategories as $subcategory) {
                        if ($subcategory != $selectedSubcategory) {
                            echo '<option value="'.$subcategory.'">'.$subcategory.'</option>';
                        } 
                    }
                } else {
                    $nonFictionSubcategories = array("History", "Crime", "Self-Help");
                    foreach ($nonFictionSubcategories as $subcategory) {
                        if ($subcategory != $selectedSubcategory) {
                            echo '<option value="'.$subcategory.'">'.$subcategory.'</option>';
                        } 
                    }
                }
            ?>
        </select><br>

        <script>
            const categorySelect = document.getElementById('categorySelect');
            const subcategorySelect = document.getElementById('subcategorySelect');

            const subcategories = {
                Fiction: ['Fantasy', 'Sci Fi', 'Romance'],
                'Non-Fiction': ['History', 'Crime', 'Self-Help']
            };

            categorySelect.addEventListener('change', function() {
                const selectedCategory = categorySelect.value;
                subcategorySelect.innerHTML = '<option selected disabled>Choose a subcategory</option>';
                if (selectedCategory !== '') {
                    subcategories[selectedCategory].forEach(function(subcategory) {
                        const option = document.createElement('option');
                        option.textContent = subcategory;
                        option.value = subcategory;
                        subcategorySelect.appendChild(option);
                    });
                }
            });
        </script>
       
        <label for="short_description">Description:</label>
        <textarea name="short_description" cols="30" rows="10"><?php echo  html_entity_decode(htmlspecialchars($row['short_description'])); ?></textarea><br>

        <label for="image">Cover Image:</label>
        <input type="text" name="image" value="<?php echo htmlspecialchars($row['cover_image']); ?>" required><br>

        <div class="submit">
        <input class="toggle" type="submit" value="Update Book"> 
        </div>
    </form>
<?php $conn->close(); ?>
</div>
</body>
</html>