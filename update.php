<?php include('functions.php') ?>

<!DOCTYPE html>
<html>
<head>
	<title>Video Game Reviews - Table</title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>

<h1> User: <?php echo $_SESSION['user']?></h1>

<div class="header">
	<h2>Make Changes to: <?php echo $_SESSION['change']; ?></h2>
</div>

<?php
$change = $_SESSION['change'];
$sql = "SELECT fName, lName, eAddr, age, address, city, state, zip, pNumber, user_type FROM user WHERE uName = '$change' LIMIT 1";
$result = $db->query($sql);
$row = $result->fetch_assoc();
?>

<!-- This form takes in admin input so function.php can write the query to update a user-->
<form method="post" action="update.php">
	<div class="input-group">
		<label>Change First Name '<?php echo $row['fName'];?>' to:</label>
		<input type="text" name="fName" value="<?php echo $fName; ?>">
	</div>
	<div class="input-group">
		<label>Change Last Name '<?php echo $row['lName'];?>' to:</label>
		<input type="text" name="lName" value="<?php echo $lName; ?>">
	</div>
	<div class="input-group">
		<label>Change Email Address '<?php echo $row['eAddr'];?>' to:</label>
		<input type="email" name="email" value="<?php echo $email; ?>">
	</div>
	<div class="input-group">
		<label>Change Age '<?php echo $row['age'];?>' to:</label>
		<input type="text" name="age" value="<?php echo $age; ?>">
	</div>
	<div class="input-group">
		<label>Change Address '<?php echo $row['address'];?>' to:</label>
		<input type="text" name="address" value="<?php echo $address; ?>">
	</div>
	<div class="input-group">
		<label>Change City '<?php echo $row['city'];?>' to:</label>
		<input type="text" name="city" value="<?php echo $city; ?>">
	</div>
	<div class="input-group">
		<label>Change State '<?php echo $row['state'];?>' to:</label>
		<input type="text" name="state" value="<?php echo $state; ?>">
	</div>
	<div class="input-group">
		<label>Change Zip Code'<?php echo $row['zip'];?>' to:</label>
		<input type="text" name="zip" value="<?php echo $zip; ?>">
	</div>
	<div class="input-group">
		<label>Change Phone Number '<?php echo $row['pNumber'];?>' to:</label>
		<input type="text" name="pNumber" value="<?php echo $pNumber; ?>">
	</div>

	<div >
		<label>Change User Type '<?php echo $row['user_type'];?>' to:</label>
		<input type="radio" name="type" value="user">User
		<input type="radio" name="type" value="admin">Admin
	</div>
	
	<div class="input-group">
		<button type="submit" class="btn" name="confirm_btn">Update</button>
	</div>
</form>

</body>
</html>
