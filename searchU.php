<?php include('functions.php') ?>

<!DOCTYPE html>
<html>
<head>
	<title>Video Game Reviews - Table</title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>

<!-- Displays the name of the current user in the corner of the screen-->
<h1> User: <?php echo $_SESSION['user']?></h1>

<div class="header">
	<h2>Search Users</h2>
</div>

<form method="post" class ="btn2" action="searchU.php">
	<div>
		<label>Enter the first letter of the user:</label>
		<input type="text" name="starts" value="<?php echo $starts; ?>" maxlength="1">
	</div>
	<input type="submit" name="exe_SearchU" value="Search">
</form>

<table>
<tr>
<th>Username</th>
<th>User Type</th>
<th>Update Acount</th>
</tr>

<?php $result = $db->query($_SESSION['find']); 

if ($result->num_rows > 0) {

// output data of each row
while($row = $result->fetch_assoc()) {
echo "<tr>
	<td>" . $row["uName"] . "</td>
	<td>" . $row["user_type"] . "</td>
	
	<td>"  
	?>
	<form method="post" class ="btn2" action="update.php">
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