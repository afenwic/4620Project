<?php include('functions.php') ?>

<!DOCTYPE html>
<html>
<head>
	<title>Video Game Reviews - Registration</title>
	<link rel="stylesheet" href="style.css">
</head>
<body>
<div class="header">
	<h2>Register</h2>
</div>
<form method="post" action="register.php">
	<?php echo display_error(); ?>

	<div class="input-group">
		<label>Username</label>
		<input type="text" name="username" value="<?php echo $username; ?>">
	</div>
	<div class="input-group">
		<label>Email</label>
		<input type="email" name="email" value="<?php echo $email; ?>">
	</div>
	<div class="input-group">
		<label>Password</label>
		<input type="password" name="password_1">
	</div>
	<div class="input-group">
		<label>Confirm password</label>
		<input type="password" name="password_2">
	</div>
	<div class="input-group">
		<label>First Name</label>
		<input type="text" name="fName" value="<?php echo $fName; ?>">
	</div>
	<div class="input-group">
		<label>Last Name</label>
		<input type="text" name="lName" value="<?php echo $lName; ?>">
	</div>
	<div class="input-group">
		<label>Age</label>
		<input type="text" name="age" value="<?php echo $age; ?>">
	</div>
	<div class="input-group">
		<label>Street Address</label>
		<input type="text" name="address" value="<?php echo $address; ?>">
	</div>
	<div class="input-group">
		<label>City</label>
		<input type="text" name="city" value="<?php echo $city; ?>">
	</div>
	<div class="input-group">
		<label>State</label>
		<input type="text" name="state" value="<?php echo $state; ?>">
	</div>
	<div class="input-group">
		<label>Zipcode</label>
		<input type="text" name="zip" value="<?php echo $zip; ?>">
	</div>
	<div class="input-group">
		<label>Phone Number</label>
		<input type="text" name="pNumber" value="<?php echo $pNumber; ?>">
	</div>
	<div class="input-group">
		<button type="submit" class="btn" name="register_btn">Register</button>
	</div>

	<p>
		Already a member? <a href="login.php">Sign in</a>
	</p>
</form>
</body>
</html>