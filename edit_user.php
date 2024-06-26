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

<div class="container">
	<?php
	if (isset($_SESSION['Customer_id'])) {
		$cusID = isset($_SESSION['Customer_id']) ? intval($_SESSION['Customer_id']) : 0;     
		$sql= "SELECT * FROM customer WHERE Customer_id = ?";
		$stmt = $conn->prepare($sql);
		$stmt->bind_param("s", $cusID);
		$stmt->execute();
		$result = $stmt->get_result();

		if ($result) {
			$row = $result->fetch_assoc();
		} else {
			die('Something went wrong.');
		}
	} else {
		die("Invalid Request");
	}
	?>
	<a class="toggle" href="profile.php" onclick="return confirm('Are you sure you want to leave without saving?')"> <i class="fa-solid fa-angle-left"></i> Back</a>
	<h2>Edit information</h2>
	<?php
    if(isset($_GET['error'])){
        if($_GET['error'] === 'empty_fields'){
            echo '<p class="error">Please fill in all fields.</p><br>';
        }else if($_GET['error'] === 'invalid_firstname'){
            echo '<p class="error">Invalid first name</p><br>';
        } else if($_GET['error'] === 'invalid_lastname'){
            echo '<p class="error">Invalid last name</p><br>';
        }  else if($_GET['error'] === 'invalid_email'){
            echo '<p class="error">Invalid email format</p><br>';
        }  else if($_GET['error'] === 'invalid_city'){
            echo '<p class="error">Invalid city</p><br>';
        } else if($_GET['error'] === 'invalid_country'){
            echo '<p class="error">Invalid country</p><br>';
        }else if ($_GET['error'] === 'invalid_postalcode'){
            echo '<p class="error">Invalid postal code</p><br>';
        }
    }   
    ?>
    <form class="content" action="update_user.php" method="post">
        <h4>Your details are below:</h4>
        <div class="profile-info">
			<h4>Customer ID:</h4>
			<p><?php echo htmlspecialchars($row['Customer_id']); ?></p>
		</div>
		<div class="profile-info">
			<h4>First name:</h4>
			<input type="text" name="fname" value="<?php echo htmlspecialchars($row['first_name']); ?>"  required><br>
		</div>
		<div class="profile-info">
			<h4>Last name:</h4>
			<input type="text" name="lname" value="<?php echo htmlspecialchars($row['last_name']); ?>" required><br>
		</div>
		<div class="profile-info">
			<h4>Email:</h4>
			<input type="email" name="email" value="<?php echo htmlspecialchars($row['email']); ?>" required><br>
		</div>
		<div class="profile-info">
			<h4>Address:</h4>
			<textarea name="address" cols="40" rows="4"  required><?php echo htmlspecialchars($row['address']); ?></textarea>
		</div>
		<div class="profile-info">
			<h4>City:</h4>
			<input type="text" name="city" value="<?php echo htmlspecialchars($row['city']); ?>"  required><br>
		</div>
		<div class="profile-info">
			<h4>Country:</h4>
			<input type="text" name="country" value="<?php echo htmlspecialchars($row['country']); ?>" required><br>
		</div>
		<div class="profile-info">
			<h4>Postal Code:</h4>
			<input type="text" name="postal_code" maxlength=5 value="<?php echo htmlspecialchars($row['postal_code']); ?>" required><br>
		</div>
		<div class="submit">
			<input class="toggle" type="submit" value="Save & Update">   
		</div>
    </form>
</div>
<?php include('footer.php'); ?>
<?php $conn->close(); ?>
</body>
</html>