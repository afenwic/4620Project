<?php 
session_start();

// connect to database
$db = mysqli_connect("mysql1.cs.clemson.edu", "GmRvwDtbs_wklk", "wearein4620", "GameReviewDatabase_4pxs");

// variable declaration
$username = ""; //This holds a username
$email = ""; //This holds an email address
$fName = ""; //This holds a first name
$lName = ""; //This holds a last name
$age = ""; //This holds the user's age
$address = ""; //This holds the first line of the user's mailing address
$city = ""; //This holds the user's city
$state = ""; //This holds the user's state
$zip = ""; //This holds the user's zipcode
$pNumber = ""; //This holds the user's phone number
$errors = array();  //This is an array that holds errors. There is error checking for the login and register pages. This displays each error to the user
$user_type = ""; //This holds a user type (user/admin)

$gID = ""; //This holds a game ID
$name = ""; //This holds a game's name

$_SESSION['game'] = "";
$_SESSION['find'] = "SELECT uName, user_type FROM user";
$_SESSION['uType'] = "";

//These are for queries
$before = ""; //This holds a 'before' date
$after = ""; //This holds an 'after' date
$starts = ""; //This holds the first letter of a game 

if (isset($_POST['register_btn'])) {
	register();
}

if (isset($_POST['login_btn'])) {
	login();
}

if (isset($_POST['review_btn'])) {
	review();
}

if (isset($_POST['leave_btn'])) {
	leave_review();
}

if (isset($_POST['update_btn'])) {
	update_review();
}

if (isset($_POST['change_btn'])) {
	update_user();
}

if (isset($_POST['confirm_btn'])) {
	update2_user();
}
if (isset($_POST['search_btn'])) {
		$_SESSION['find'] = "SELECT gID, gName, rDate, rAge, dlcCount, price FROM game";
}
if (isset($_POST['exe_Search'])) {
	search2();
}
if (isset($_POST['exe_SearchU'])) {
	$_SESSION['find'] = "SELECT uName, user_type FROM user";
	searchU();
}

// REGISTER USER
function register(){
	// call these variables with the global keyword to make them available in function
	global $db, $errors, $username, $email, $fName, $lName, $age, $address, $city, $state, $zip;

	$date = e(date("Y-m-d"));

	// receive all input values from the form. Call the e() function
    // defined below to escape form values
	$username    =  e($_POST['username']);
	$email       =  e($_POST['email']);
	$password_1  =  e($_POST['password_1']);
	$password_2  =  e($_POST['password_2']);
	$fName = e($_POST['fName']);
	$lName = e($_POST['lName']);
	$age = e($_POST['age']);
	$address = e($_POST['address']);
	$city = e($_POST['city']);
	$state = e($_POST['state']);
	$zip = e($_POST['zip']);
	$pNumber = e($_POST['pNumber']);

	// form validation: ensure that the form is correctly filled
	if (empty($username)) { 
		array_push($errors, "Username is required"); 
	}
	if (empty($email)) { 
		array_push($errors, "Email is required"); 
	}
	if (empty($password_1)) { 
		array_push($errors, "Password is required"); 
	}
	if ($password_1 != $password_2) {
		array_push($errors, "The two passwords do not match");
	}
	if (empty($fName)) { 
		array_push($errors, "First Name is required"); 
	}
	if (empty($lName)) { 
		array_push($errors, "Last Name is required"); 
	}
	if (empty($age)) { 
		array_push($errors, "Age is required"); 
	}
	if (empty($address)) { 
		array_push($errors, "Address is required"); 
	}
	if (empty($city)) { 
		array_push($errors, "City is required"); 
	}
	if (empty($state)) { 
		array_push($errors, "State is required"); 
	}
	if (empty($zip)) { 
		array_push($errors, "Zipcode is required"); 
	}
	if (empty($pNumber)) { 
		array_push($errors, "Phone number is required"); 
	}

	if (count($errors) == 0) {
		$query = "SELECT * FROM user WHERE uName='$username' ";
		$results = mysqli_query($db, $query);

		if (mysqli_num_rows($results) >= 1) { // user found
			array_push($errors, "That username is already taken"); 
		}
	}

	// register user if there are no errors in the form
	if (count($errors) == 0) {
		$password = md5($password_1);//encrypt the password before saving in the database

		if (isset($_POST['user_type'])) {
			$user_type = e($_POST['user_type']);
			$query = "INSERT INTO user (uName, pWord, fName, lName, eAddr, age, registered, address, city, state, zip, pNumber, user_type) 
					  VALUES('$username', '$password_1', '$fName', '$lName', '$email', '$age', '$date', '$address', 
					  '$city', '$state', '$zip', '$pNumber', '$user_type')";
			mysqli_query($db, $query);
			$_SESSION['success']  = "New user successfully created!!";
			header('location: home.php');
		}else{
			$query = "INSERT INTO user (uName, pWord, fName, lName, eAddr, age, registered, address, city, state, zip, pNumber, user_type) 
					  VALUES('$username', '$password_1', '$fName', '$lName', '$email', '$age', '$date', '$address', 
					  '$city', '$state', '$zip', '$pNumber', 'user')";
			mysqli_query($db, $query);


			//$_SESSION['user'] = getUserById($logged_in_user_id); // put logged in user in session
			$_SESSION['user'] = $username;
			$_SESSION['success']  = "You are now logged in";
			header('location: table2.php');			
		}
	}
}


// LOGIN USER
function login(){
	global $db, $username, $errors;

	// grap form values
	$username = e($_POST['username']);
	$password = e($_POST['password']);

	// make sure form is filled properly
	if (empty($username)) {
		array_push($errors, "Username is required");
	}
	if (empty($password)) {
		array_push($errors, "Password is required");
	}

	// attempt login if no errors on form
	if (count($errors) == 0) {
		$query = "SELECT * FROM user WHERE uName='$username' AND pWord='$password' LIMIT 1";
		$results = mysqli_query($db, $query);

		if (mysqli_num_rows($results) == 1) { // user found
			// check if user is admin or user
			$logged_in_user = mysqli_fetch_assoc($results);
			if ($logged_in_user['user_type'] == 'admin') {
				$_SESSION['find'] = "SELECT uName, user_type FROM user";
				$_SESSION['user_type'] = "admin";
				$_SESSION['user'] = $username;
				$_SESSION['success']  = "You are now logged in";
				header('location: admin.php');		  
			}else{
				$_SESSION['user'] = $username;
				$_SESSION['success']  = "You are now logged in";
				header('location: table2.php');
				
			}
		}else {
			array_push($errors, "Wrong username/password combination");
		}
	}
}

function review(){
	global $gID, $name;
	$gID = e($_POST['gID']);
	$name = e($_POST['name']);

	$_SESSION['game'] = $name;
	$_SESSION['gID'] = $gID;
}

function leave_review(){
	global $db;

	$gID = e($_POST['gID']);
	$username = e($_POST['uName']);
	$rating = e($_POST['rating']);
	$date = e(date("Y-m-d"));
	$rID = e($_POST['uName']) . e($_POST['gID']);
	$query = "INSERT INTO review (rating_id, uName, gID, rating_date, rating) VALUES ('$rID', '$username', '$gID', '$date', '$rating')";
	mysqli_query($db, $query);
	header('location: table2.php');
}

function update_review(){
	global $db;

	$gID = e($_POST['gID']);
	$username = e($_POST['uName']);
	$rating = e($_POST['rating']);
	$date = e(date("Y-m-d"));
	$rID = e($_POST['uName']) . e($_POST['gID']);
	$query = "UPDATE review SET rating='$rating' WHERE uName = '$username'";
	mysqli_query($db, $query);
	header('location: table2.php');
}

function update_user(){
	global $db;

	$username = e($_POST['uName']);
	$_SESSION['change'] = $username;
	mysqli_query($db, $query);
	header('location: update.php');
 }

 function update2_user(){
	global $db, $username, $email, $fName, $lName, $age, $address, $city, $state, $zip, $user_type;

	$email =  e($_POST['email']);
	$fName = e($_POST['fName']);
	$lName = e($_POST['lName']);
	$age = e($_POST['age']);
	$address = e($_POST['address']);
	$city = e($_POST['city']);
	$state = e($_POST['state']);
	$zip = e($_POST['zip']);
	$pNumber = e($_POST['pNumber']);
	$user_type = e($_POST['type']);
	$username = $_SESSION['change'];

	//These if statements ensure the user data is only changed when the user has put something in the form
	if (!empty($fName)) { 
		$query = "UPDATE user SET fName='$fName' WHERE uName = '$username'";
		mysqli_query($db, $query);
	}
	if (!empty($lName)) { 
		$query = "UPDATE user SET lName='$lName' WHERE uName = '$username'";
		mysqli_query($db, $query);
	}
	if (!empty($email)) { 
		$query = "UPDATE user SET eAddr='$email' WHERE uName = '$username'";
		mysqli_query($db, $query);
	}
	if (!empty($age)) { 
		$query = "UPDATE user SET age='$age' WHERE uName = '$username'";
		mysqli_query($db, $query);
	}
	if (!empty($address)) { 
		$query = "UPDATE user SET address='$address' WHERE uName = '$username'";
		mysqli_query($db, $query);
	}
	if (!empty($city)) { 
		$query = "UPDATE user SET city='$city' WHERE uName = '$username'";
		mysqli_query($db, $query);
	}
	if (!empty($state)) { 
		$query = "UPDATE user SET state='$state' WHERE uName = '$username'";
		mysqli_query($db, $query);
	}
	if (!empty($zip)) { 
		$query = "UPDATE user SET zip='$zip' WHERE uName = '$username'";
		mysqli_query($db, $query);
	}
	if (!empty($pNumber)) { 
		$query = "UPDATE user SET pNumber='$pNumber' WHERE uName = '$username'";
		mysqli_query($db, $query);
	}
	if (!empty($user_type)) { 
		$query = "UPDATE user SET user_type='$user_type' WHERE uName = '$username'";
		mysqli_query($db, $query);
	}
	

	header('location: admin.php');
 }

function search2(){
	global $db, $before, $after, $starts;
	$before = e($_POST['before']);
	$after = e($_POST['after']);
	$starts = e($_POST['starts']);

	$doSearch = False;

	//default game query
	$_SESSION['find'] = "SELECT gID, gName, rDate, rAge, dlcCount, price FROM game";

	//These if statements ensure the user data is only changed when the user has put something in the form
	if (!empty($before)) { 
		if ($doSearch == False){
			$_SESSION['find'] = $_SESSION['find'] . " WHERE rDate <= '$before'";
		}
		else{
			$_SESSION['find'] = $_SESSION['find'] . " AND rDate <= '$before'";
		}
		$doSearch = True;
	}
	if (!empty($after)) { 
		if ($doSearch == False){
			$_SESSION['find'] = $_SESSION['find'] . " WHERE rDate >= '$after'";
		}
		else{
			$_SESSION['find'] = $_SESSION['find'] . " AND rDate >= '$after'";
		}
		$doSearch = True;
	}

	if (!empty($starts)) { 
		if ($doSearch == False){
			$_SESSION['find'] = $_SESSION['find'] . " WHERE gName LIKE '$starts%'";
		}
		else{
			$_SESSION['find'] = $_SESSION['find'] . " AND WHERE gName LIKE '$starts%'";
		}
		$doSearch = True;
	}
}

function searchU(){
	global $db, $starts;
	$starts = e($_POST['starts']);

	$doSearch = False;

	$_SESSION['find'] = "SELECT uName, user_type FROM user";

	//These if statements ensure the user data is only changed when the user has put something in the form
	if (!empty($starts)) { 
		if ($doSearch == False){
			$_SESSION['find'] = $_SESSION['find'] . " WHERE uName LIKE '$starts%'";
		}
		else{
			$_SESSION['find'] = $_SESSION['find'] . " AND WHERE uName LIKE '$starts%'";
		}
		$doSearch = True;
	}
}

// return user array from their id
function getUserById($id){
	global $db;
	$query = "SELECT * FROM user WHERE id=" . $id;
	$result = mysqli_query($db, $query);

	$user = mysqli_fetch_assoc($result);
	return $user;
}

// escape string
function e($val){
	global $db;
	return mysqli_real_escape_string($db, trim($val));
}

function display_error() {
	global $errors;

	if (count($errors) > 0){
		echo '<div class="error">';
			foreach ($errors as $error){
				echo $error .'<br>';
			}
		echo '</div>';
	}
}	
?>