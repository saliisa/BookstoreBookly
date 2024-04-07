<?php require_once('../connection.php'); ?>
<?php require_once('staff_protected.php'); ?>
<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['bookID'])) {
        $bookID = isset($_POST['bookID']) ? filter_var($_POST['bookID'], FILTER_SANITIZE_STRING) : '';
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
            header('Location: edit_book.php?bookID=' . urlencode($bookID) . '&error=empty_fields');
            die();
        } else{

            if(!is_numeric($isbn) || strlen($isbn) != 13){
                header('Location: edit_book.php?bookID=' . urlencode($bookID) . '&error=invalid_isbn');
                die();
            }
    
            if (!preg_match("/^[a-zA-Z\s]+$/", $author)) {
                header('Location: edit_book.php?bookID=' . urlencode($bookID) . '&error=invalid_author');
                die();
            }
    
            $updateQuery = "UPDATE book SET isbn = ?,title = ?, author = ?, pub_year = ?,
            price = ?, category = ?, subcategory = ?, short_description = ?, cover_image = ?  
            WHERE Book_id = ?";
            $stmt = $conn->prepare($updateQuery);
            $stmt->bind_param("sssssssssi", $isbn, $title, $author, $pubYear, $price, $category, $subcategory, $description, $image, $bookID);
                        
            if ($stmt->execute()) {
                header('Location: staff_book.php');
                    exit;
            } else { 
                die("Error updating book information. Please try again later.");
            }
        }
    } else { 
        die("Invalid request.");
    }
} else {
    die("Invalid request.");
}
?>
<?php $conn->close(); ?>


