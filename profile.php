<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link href="https://fonts.googleapis.com/css2?family=Hammersmith+One&family=Poppins&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/stylesheet.css">
    <script src="https://kit.fontawesome.com/9eef98da8c.js" crossorigin="anonymous"></script>
</head>
<body>
<?php include('header.php'); ?>
<?php require_once('connection.php'); ?>
<?php require_once('protected.php'); ?>
<?php 
	if(isset($_GET["out"])){
		session_unset();
		session_destroy();
		header('Location: index.php');
		exit();
	}
?>
<div class="container">
<?php
$cusID = isset($_SESSION['Customer_id']) ? intval($_SESSION['Customer_id']) : 0;
$query = "SELECT * FROM customer WHERE Customer_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('i', $cusID);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
?>
<a class="page" href="profile.php">Profile Page</a>
<a class="page" href="order_history.php">Order History</a>
<hr>
<div class="content">
	<div class="edit">
		<h3 >Your details are below:</h3>
		<?php echo '<a class="toggle"  href="edit_user.php"> Edit  <i class="fa-regular fa-pen-to-square"></i></a>';?>
	</div>
	<div style="clear:both;" class="profile-info">
		<h4>Customer ID:</h4>
		<p><?=  htmlspecialchars($row['Customer_id'])?></p>
	</div>
	<div class="profile-info">
		<h4>First name:</h4>
		<p><?=  htmlspecialchars($row['first_name']) ?></p>
	</div>
	<div class="profile-info">
		<h4>Last name:</h4>
		<p><?=  htmlspecialchars($row['last_name']) ?></p>
	</div>
	<div class="profile-info">
		<h4>Email:</h4>
		<p><?=  htmlspecialchars($row['email'])?></p>
	</div>
	<div class="profile-info">
		<h4>Address:</h4>
		<p><?=  htmlspecialchars($row['address'])?></p>
	</div>
	<div class="profile-info">
		<h4>City:</h4>
		<p><?=  htmlspecialchars($row['city'])?></p>
	</div>
	<div class="profile-info">
		<h4>Country:</h4>
		<p><?=  htmlspecialchars($row['country'])?></p>
	</div>
	<div class="profile-info">
		<h4>Postal Code:</h4>
		<p><?=  htmlspecialchars($row['postal_code'])?></p>
	</div>		
	<br>
	<?php echo '<a class="button" href="change_password.php">Change password</a>';?>
</div>
</div>
<?php include('footer.php'); ?>
<?php $conn->close(); ?>
</body>
</html>