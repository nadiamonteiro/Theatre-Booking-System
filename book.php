<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="mystyles.css" />
	<h1>Westview Theatre Booking</h1><br><br>
</head>
<body>


<div id="header"><h2> Booking Confirmation </h2></div><br><br>
<div id="confirm"><h3>Confirm Your Booking Details </h3><br>			<!-- Confirmation of Purchase -->

<?php
	include('dbh.php');
	$conn = connect();
	session_start();


	echo "Hello ".$_SESSION['username'].", thank you for booking with us! <br><br>";

	echo "Your tickets have been sent to ".$_SESSION['email']."<br><br>";

	echo "<h3>Seats for ".$_SESSION['title']." at ".$_SESSION['time']." on ".$_SESSION['date'].".<h3><br><br>";

	$_SESSION["totalPrice"] = $_POST['totalPrice'];
	$_SESSION["checkedSeats"] = $_POST['checkedSeats'];

	$_seatsArray = explode(',', $_SESSION["checkedSeats"]);
	echo "Your booked seats: </h3><br>";
	echo "-".$_SESSION['checkedSeats']." successfully booked.<br>";
	echo "<br><h3> Your total is: £".$_SESSION['totalPrice']."</h3><br><br>";

  try {
	$seats = $_SESSION["checkedSeats"];
	$trimmed = explode(',', $_SESSION['checkedSeats']);
	foreach ($trimmed as $seat){

	$sql  = "INSERT INTO Booking VALUES
						(:email, '".$_SESSION['date']."', '".$_SESSION['time']."', '$seat');"; //Query updates database with users booking
	$handle = $conn->prepare($sql);
	$handle->execute(array('email' => $_SESSION['email']));

	}
	$conn=null;
		echo "Please click 'Logout' to end your session and return to the home page.";
		echo "<br><br><form><td><input type='submit' value='Logout' onClick='session_destroy()' formaction='index.html'><td></form>";
		//Button destroys session and returns user to home page
	} catch (PDOException $e) {
		echo "PDOException: ".$e->getMessage();
	}
?>
</div>
<br>
<br>
<div id="footer">
	Copyright &copy; 2019 Westview.
</div>
</body>
</html>
