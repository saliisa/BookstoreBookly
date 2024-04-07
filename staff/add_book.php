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
<a class="toggle" href="javascript:history.back()"> < Back</a>

<h2>Add a Book</h2>
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $isbn = isset($_POST['isbn']) ? filter_var($_POST['isbn'], FILTER_SANITIZE_STRING) : '';
    $title = isset($_POST['title']) ? filter_var($_POST['title'], FILTER_SANITIZE_STRING) : '';
    $author = isset($_POST['author']) ? filter_var($_POST['author'], FILTER_SANITIZE_STRING) : '';
    $pubYear = isset($_POST['published_year']) ? filter_var($_POST['published_year'], FILTER_SANITIZE_NUMBER_INT) : '';
    $price = isset($_POST['price']) ? filter_var($_POST['price'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION) : '';
    $category = isset($_POST['category']) ? filter_var($_POST['category'], FILTER_SANITIZE_STRING) : '';
    $subcategory = isset($_POST['subcategory']) ? filter_var($_POST['subcategory'], FILTER_SANITIZE_STRING) : '';
    $description = isset($_POST['short_description']) ? filter_var($_POST['short_description'], FILTER_SANITIZE_STRING) : '';
    $image = isset($_POST['image']) ? filter_var($_POST['image'], FILTER_SANITIZE_URL) : '';

    if (empty($isbn) || empty($title) || empty($author) || empty($pubYear) || empty($price) || empty($category) || empty($subcategory) || empty($description) || empty($image)) {
       header('Location: add_book.php?error=empty_fields');
       die();

    } else{
        if(!is_numeric($isbn) || strlen($isbn) != 13){
            header('Location: add_book.php?error=invalid_isbn');
            die();       
        }

        if (!preg_match("/^[a-zA-Z\s]+$/", $author)){
            header('Location: add_book.php?error=invalid_author');
            die();  
        }
        
        $stmt = $conn->prepare("INSERT INTO book (isbn, title, author, pub_year, price, category, subcategory, short_description, cover_image) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssdssss", $isbn, $title, $author, $pubYear, $price, $category, $subcategory, $description, $image);

        if ($stmt->execute()) {
            header('Location: staff_book.php');
            exit();
        } else {
            die("Error adding book information. Please try again later.");
        }
        
    }   
}
?>
<?php 
	if(isset($_GET['error'])){
		if($_GET['error'] === 'empty_fields'){
			echo '<p class="error">Please fill in all fields.</p><br>';
		}else if($_GET['error'] === 'invalid_author'){
			echo '<p class="error">Invalid author</p><br>';
		}  else if($_GET['error'] === 'invalid_isbn'){
			echo '<p class="error">Invalid ISBN</p><br>';
		}  
	}  
?>
<form class = "form-book" action="add_book.php" method="post">
    <label for="isbn">ISBN(13):</label>
    <input type="text" id="isbn" name="isbn" maxlength="13" required><br>

    <label for="title">Title:</label>
    <input type="text" id="title" name="title" required><br>

    <label for="author">Author:</label>
    <input type="text" id="author" name="author" required><br>

    <label for="published_year">Published Year:</label>
    <input type="date" id="published_year" name="published_year" required><br>

    <label for="price">Price:</label>
    <input type="number" id="price" name="price" step="0.01"  required><br>

    <label for="category">Category:</label>
    <select name="category" id="categorySelect">
        <option selected disabled>Choose a category </option>
        <option  name="category"  value="Fiction">Fiction</option>
        <option  name="category"  value="Non-Fiction">Non-Fiction</option>
    </select> <br>
    
   <label for="subcategory">Subcategory:</label>
    <select name="subcategory" id="subcategorySelect">
        <option selected disabled>Choose a subcategory</option>
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

    <label for="short_description">Short Description:</label>
    <textarea name="short_description" id="short_description" cols="30" rows="10" required></textarea>

    <label for="image">Cover Image</label>
    <input type="text" id="image" name="image" required><br>

    <input class="toggle" type="submit" value="Add Book">
</form>
</div>
<?php $conn->close(); ?>
</body>
</html>
