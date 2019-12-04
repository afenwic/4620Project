<?php include('functions.php') ?>

<!DOCTYPE html>
<html>
<head>
	<title>Video Game Reviews - Review</title>
	<link rel="stylesheet" href="style.css">
</head>
<body>
 
<h1> User: <?php echo $_SESSION['user']?></h1> <!-- This echoes the user name for the current user in the corner of the screen-->
<div class="header">
	<h2><?php echo $_SESSION['game']?></h2> <!-- This echoes the name of the game the review page is for-->
</div>

<?php
//$sql = "SELECT uName, rating_date, rating FROM review WHERE gID = $gID";

$result = $db->query("SELECT uName, rating_date, rating FROM review WHERE gID = $gID"); ?>

<!-- 
Formatting for the review table
-->
<table>
<tr>
<th>User</th>
<th>Rating Date</th>
<th>Rating (1-5)</th>
</tr>

<?php
$row_cnt = $result->num_rows;
if ($result->num_rows > 0) {

// output data of each row columns are: username, rating date and rating
while($row = $result->fetch_assoc()) {
echo "<tr>
	<td>" . $row["uName"] . "</td> 
	<td>" . $row["rating_date"] . "</td>
	<td>" . $row["rating"] . "</td>
	</tr>";
}

echo "</table>";
}
else
{ 
	echo "</table>";
	echo "<h3>There are no reviews yet.</h3>";  //This is here so you aren't just looking at a blank table
}

//This is the query to populate the table
$check1 = $_SESSION['user'];
$check2 = $_SESSION['gID'];
$result = $db->query("SELECT * FROM review WHERE uName ='$check1' AND gID = '$check2'");

//This is the result of a query for a review for the game page done by the current user
//If this is the case, they are prompted to change their current review
if ($result->num_rows > 0) {
?>

	<h3>Would you like to change your review?</h3>
	
	<form method="post" class ="btn2" action="review.php">
	<?php echo display_error(); ?>
    <input type="hidden" name="gID" value="<?php echo $_SESSION['gID']?>">
    <input type="hidden" name="uName" value="<?php echo $_SESSION['user']?>">
    <input type="number" name="rating" min="1" max="5">
    <input type="submit" name="update_btn" value="<?php echo "Update"?>" >
	</form>
	<?php
}
else {
	?>
	<!-- This is if the user has not left a review yet, they are prompted to leave a review  -->
	<h3>Would you like to leave a review?</h3>
	<form method="post" class ="btn2" action="review.php">
	<?php echo display_error(); ?>
    <input type="hidden" name="gID" value="<?php echo $_SESSION['gID']?>">
    <input type="hidden" name="uName" value="<?php echo $_SESSION['user']?>">
    <input type="number" name="rating" min="1" max="5">
    <input type="submit" name="leave_btn" value="<?php echo "Rate"?>" >
	</form>
	<?php
}

?>
	<?php

$db->close();
?>

</body>
</html>