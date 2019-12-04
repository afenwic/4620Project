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
	<h2>Search Games</h2>
</div>

<!--  
	This form allows for the user to search through the game table.
	It passes the values to query for to the function php file.
-->
<form method="post" class ="btn2" action="search.php">
	<?php echo display_error(); ?>
	<div>
		<label>Search for a game released after:</label>
		<input type="date" name="after" value="<?php echo $after; ?>">
	</div>
	<div>
		<label>Search for a game released before:</label>
		<input type="date" name="before" value="<?php echo $before; ?>">
	</div>
	<div>
		<label>Enter the first letter of the game:</label>
		<input type="text" name="starts" value="<?php echo $starts; ?>" maxlength="1">
	</div>

	<input type="submit" name="exe_Search" value="Search">
</form>

<table>
<tr>
<th>Name</th>
<th>Release Date</th>
<th>Required Age</th>
<th>DLC Count</th>
<th>Price</th>
</tr>

<?php $result = $db->query($_SESSION['find']); 


if ($result->num_rows > 0) {

// output data of each row
while($row = $result->fetch_assoc()) {
echo "<tr>
	<td> "?>
	
	<!-- Instead of simply displaying the value of gName from the game table like the other column. I'm
	using the value from the game table in the value of a button in a form. This conveys the value of gName
	but also provides a means to move to the review page.
	 -->

	<form method="post" class ="btn2" action="review.php">
	<?php echo display_error(); ?>
    <input type="hidden" name="gID" value="<?php echo htmlspecialchars($row["gID"]); ?>">
    <input type="hidden" name="name" value="<?php echo htmlspecialchars($row["gName"]); ?>">
    <input type="submit" name="review_btn" value="<?php echo htmlspecialchars($row["gName"]); ?>" >
	</form>

<?php
//displaying the other values from the game table
echo 
	"</td>
	<td>" . $row["rDate"] . "</td>
	<td>" . $row["rAge"] . "</td>
	<td>" . $row["dlcCount"] . "</td>
	<td>$" . $row["price"] . "</td>
	</tr>";
}

echo "</table>";
}
else
{ echo "0 results"; }

$db->close(); ?>

</body>
</html>