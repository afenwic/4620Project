<?php include('functions.php') ?>

<!DOCTYPE html>
<html>
<head>
	<title>Video Game Reviews - Table</title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>

<!-- This echoes the current user in the corner of the screen -->
<h1> User: <?php echo $_SESSION['user']?></h1>

<table>
	<tr>
		<td>

			<form method="post" class ="btn3" action="table2.php">
				<?php echo display_error(); ?>
			    <input type="submit" value="Go to table">
			</form>
		</td>
		<td>
			<form method="post" class ="btn3" action="searchU.php">
				<?php echo display_error(); ?>
			    <input type="submit" value="Search Users">
			</form>
		</td>

<!-- Table structure for the user table-->
<table>
<tr>
<th>Username</th>
<th>User Type</th>
<th>Update Acount</th>
</tr>

<?php

$sql = "SELECT uName, user_type FROM user";
$result = $db->query($sql);

if ($result->num_rows > 0) {

// echoing the user data
while($row = $result->fetch_assoc()) {
echo "<tr>
	<td>" . $row["uName"] . "</td>
	<td>" . $row["user_type"] . "</td>
	
	<td>"  
	?>

	<!-- This is a button that take an admin to a page to update user data-->
	<form method="post" class ="btn2" action="update.php">
	<?php echo display_error(); ?>
    <input type="hidden" name="uName" value="<?php echo htmlspecialchars($row["uName"]); ?>">
    <input type="submit" name="change_btn" value="Update" >
	</form>
	<?php
	echo 
	"</td>
	</tr>";
}

echo "</table>";
}
else
{ echo "0 results"; }

$db->close();
?>

</body>
</html>
