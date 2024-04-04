
<?php include('header.php'); ?>
<?php require_once('connection.php'); ?>
<?php require_once('protected.php'); ?>
<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cusID = isset($_SESSION['Customer_id']) ? filter_var($_SESSION['Customer_id'], FILTER_SANITIZE_STRING) : '';
    $firstname = isset($_POST['fname']) ? filter_var($_POST['fname'], FILTER_SANITIZE_STRING) : '';
    $lastname = isset($_POST['lname']) ? filter_var($_POST['lname'], FILTER_SANITIZE_STRING) : '';
    $email = isset($_POST['email']) ? filter_var($_POST['email'], FILTER_SANITIZE_EMAIL) : '';
    $address = isset($_POST['address']) ? filter_var($_POST['address'], FILTER_SANITIZE_STRING) : '';
    $city = isset($_POST['city']) ? filter_var($_POST['city'], FILTER_SANITIZE_STRING) : '';
    $country = isset($_POST['country']) ? filter_var($_POST['country'], FILTER_SANITIZE_STRING) : '';
    $postalCode = isset($_POST['postal_code']) ? filter_var($_POST['postal_code'], FILTER_SANITIZE_STRING) : '';
    
    if (empty($firstname) || empty($lastname) || empty($email) ||empty($address) || empty($city)|| empty($country)|| empty($postalCode)){
      header('Location: edit_user.php?error=empty_fields');
      die();
    }else {
        $updateQuery = "UPDATE customer SET first_name = ?, last_name = ?, email= ?, 
        address= ?, city= ?, country = ?, postal_code= ? WHERE Customer_id = ?";
        $stmt = $conn->prepare($updateQuery);
        $stmt->bind_param("ssssssss", $firstname, $lastname, $email, $address,  $city, $country, $postalCode, $cusID);

        if ($stmt->execute()) {
            header('Location: profile.php');
            exit;
        } else {
            die("Error: " . $stmt->error);
        }
    }
} else {
    die("Invalid request.");
}
?>
<?php $conn->close(); ?>

