<!DOCTYPE HTML>
<html>
<body>
<head>
	<link rel="stylesheet" type="text/css" href="mystyles.css" />
	<h1>Westview Theatre Booking</h1><br><br>
</head>
<div id="bookings">
	<p id="checked"></p>
	<p id="total"> </p>
<script>
	var total = "global";
	function getTotal(){
		var isCheckedPrice = [];			//Declare array to store price of checked seats
		var isCheckedSeats = [];			//Declare array to store checked seats
		var checkboxes = document.querySelectorAll('input[type=checkbox]:checked');
		total = 0;
		for(var i=0; i<checkboxes.length; i++) {
			isCheckedPrice.push(checkboxes[i].value); 		
			isCheckedSeats.push(checkboxes[i].id);
		}
		document.getElementById("checked").innerHTML = "<h3>Your selected seat is: " + isCheckedSeats + "</h3>";

		var money = 0;
		for(var i in isCheckedPrice) {
			money = parseInt(isCheckedPrice[i]); //Calculate total
			total += money;
		}
		document.getElementById("total").innerHTML = "<h3>Your Total: £" + total + "</h3>";
		document.form1.totalPrice.value = total;
		document.form1.checkedSeats.value = isCheckedSeats;
	}

 function validation() { 				//Function to validate that at least one checkbox has been checked
	 var inputElems = document.getElementsByTagName("input");
       var count = 0;
       for (var i=0; i<inputElems.length; i++) {
         if (inputElems[i].type === "checkbox" && inputElems[i].checked === true) {
           count++;
         }
       }
			 if (count == 0) {
			 	alert("Please select a checkbox");
				event.preventDefault(); }
 }
</script>

<form name = 'form1' action="book.php" method = "POST">
	<input type='hidden' name="totalPrice" value= "total" />
	<input type='hidden' name="checkedSeats" value= 'isCheckedSeats' />
<p><button type="submit" value="confirm" id="button1" onClick="validation()"/> Proceed</button></p> <!--Button calls 'book.php' -->

</form>
</div>

<?php
	include('dbh.php');
	$conn = connect();
	session_start();

	echo "Hello ".$_SESSION['username'].", please select one or more seats and click 'Proceed'.<br> <br> <br>";

	$_SESSION['title'] = $_GET['title'];
	$_SESSION['date'] = $_GET['date'];
	$_SESSION['time'] = $_GET['time'];
	$_SESSION['ticketPrice'] = $_GET['ticketPrice'];

	echo "<h2>Seats for ".$_GET['title']." at ".$_GET['time']." on ".$_GET['date'].".<h2><br><br>";
	try {
			$sql = "SELECT Seat.RowNumber, ROUND(Zone.PriceMultiplier * '".$_SESSION['ticketPrice']."') as 'calculated price'
					FROM Seat JOIN Zone ON Seat.Zone=Zone.Name
					WHERE Seat.RowNumber NOT IN
					(SELECT Booking.RowNumber FROM Booking
					WHERE Booking.PerfDate='".$_SESSION['date']."' AND Booking.PerfTime='".$_SESSION['time']."')" ;
											//Retrieve available seats from database
			$info = $conn->prepare($sql);
			$info->execute();
			$result = $info->fetchAll();

			echo "<table class='performances'><thead>
			<tr>
			<th>Seat </th>
			<th>Price &nbsp</th>
			<th>Selection</th>
			</tr>
			</thead>";

			foreach ($result as $rows) {
				echo "<tr>";
				echo "<td>" .$rows['RowNumber']."</td>";
				echo "<td> £" .$rows['calculated price']. "</td>";
				$price = $rows['calculated price'];
				$seat = $rows['RowNumber'];
				echo "<td><input type = 'checkbox' class = 'check' id = '$seat' value = '$price' onclick = 'getTotal()' ></td>";
				echo "</tr>";
			} echo "</table>";
		 } catch (PDOException $e) {
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
