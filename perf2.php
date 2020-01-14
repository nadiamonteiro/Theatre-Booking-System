<!DOCTYPE html>
<html>
<body>

<head>
	<link rel="stylesheet" type="text/css" href="mystyles.css" />
	<h1>Westview Theatre Booking</h1><br><br></head>
<?php
	include('dbh.php');
	$conn = connect();
	session_start();    //Starting session.

	if(!isset($_SESSION['username'])){
		echo "You are not logged in!<br><br>";
	} else {
		echo "You are logged in!<br><br>";
	}
	echo "<h2> Our Performances </h2><br> <br>";
	try {
		$sql = "select p.Title, PerfDate, PerfTime, r.BasicTicketPrice from Performance p join Production r on p.Title = r.Title";
		$handle = $conn->prepare($sql);
		$handle->execute();
		$conn=null;
		echo "<table class='content'>
			<thead>
			<tr>
				<th>Title </th>
				<th>Date</th>
				<th>Time</th>
			</tr>
			</thead>";
		$res = $handle->fetchAll();
		foreach ($res as $row) {
			echo "<tr><form method='POST' action='seats.php'>";
			echo "<td>" .$row['Title']. "<input type='hidden' name='title' value = ".$row['Title']."/></td>";
			echo "<td>" .$row['PerfDate']. "<input type='hidden' name='date' value = ".$row['PerfDate']."></td>";
			echo "<td>" .$row['PerfTime']. "<input type='hidden' name='time' value = ".$row['PerfTime']."></td>";
			echo "</tr></form>";
		}	echo "</table>";
	}	catch (PDOException $e) {
		echo "PDOException: ".$e->getMessage();
	}
?>
<br>
<br>
	<div id="footer">
			Copyright &copy; 2019 Westview.
		</div>
</body>
</html>
