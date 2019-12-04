<?php include('functions.php') ?>


<!DOCTYPE html>
<html>
<head>
	<title>Video Game Reviews - Table</title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>

//
<h1> User: <?php echo $_SESSION['user']?></h1>


<div class="header">
	<h2>Video Games</h2>
</div>

<form method="post" class ="" action="search.php">
	<input type="hidden" name="search_type" value="game">
	<input type="submit" name="search_btn" value="Search Games">
</form>

<table>
<tr>
<th>Name</th>
<th>Release Date</th>
<th>Required Age</th>
<th>DLC Count</th>
<th>Price</th>
</tr>

<?php
//querying the game data
$sql = "SELECT gID, gName, rDate, rAge, dlcCount, price FROM game";
$result = $db->query($sql);

if ($result->num_rows > 0) {

// output data of each row
while($row = $result->fetch_assoc()) {
echo "<tr>
	<td> " ?>

	<form method="post" class ="btn2" action="review.php">
	<!-- Instead of simply displaying the value of gName from the game table like the other column. I'm
		using the value from the game table in the value of a button in a form. This conveys the value of gName
		but also provides a means to move to the review page.
	 -->
    <input type="hidden" name="gID" value="<?php echo htmlspecialchars($row["gID"]); ?>">
    <input type="hidden" name="name" value="<?php echo htmlspecialchars($row["gName"]); ?>">
    <input type="submit" name="review_btn" value="<?php echo htmlspecialchars($row["gName"]); ?>" >
	</form>

<?php

//displaying the other values from the game table. 
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

$db->close();
?>

</table>

</body>
</html>