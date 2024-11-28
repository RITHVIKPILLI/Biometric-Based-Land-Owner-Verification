<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
	<div class="frame">
		<h1>Land Details</h1>
	</div>
	<style>
		table {
			border-collapse: collapse;
			width: 100%;
			font-family: Arial, sans-serif;
			font-size: 14px;
			text-align: center;
			margin: 0 auto;
		}
		th, td {
			padding: 8px;
			border: 1px solid #ddd;
		}
		th {
			background-color: #f2f2f2;
			font-weight: bold;
		}
		
		.frame {
			border: 1px solid #ddd;
			padding: 20px;
			border-radius: 10px;
			box-shadow: 0px 0px 10px #ddd;
		}
		
		h1 {
			margin-top: 0;
			text-align: center;
		}
		
		.verify-btn {
			background-color: #4CAF50;
			border: none;
			color: white; 
			padding: 10px 16px;
			text-align: center;
			text-decoration: none; 
			display: inline-block;
			font-size: 16px;
			margin: 4px 2px;
			cursor: pointer; 
			border-radius: 4px;
			float: right;
		}
	
		.verify-btn:hover {
			background-color: #3e8e41; /* Set background color on hover */
		}
	</style>
</head>
<body>
	<?php
		// Database credentials
		$servername = "localhost";
		$username = "root";
		$password = "";
		$dbname = "data";

		// Create connection
		$conn = new mysqli($servername, $username, $password, $dbname);

		// Check connection
		if ($conn->connect_error) {
			die("Connection failed: " . $conn->connect_error);
		}
		// Retrieve survey number from form submission
		$surveyNo = $_POST["surveyNo"];

		// Query the database for data with matching survey number
		$sql = "SELECT * FROM details WHERE SERVEYNo='$surveyNo'";
		$result = $conn->query($sql);

		// Display the data in an HTML table
		if ($result->num_rows > 0) {
			echo "<table>";
			echo "<tr><th>SERVEYNo</th><th>PERSON</th><th>DISTRICT</th><th>MANDAL</th><th>VILLAGE</th><th>KHATANO</th><th>CASTE</th><th>GENDER</th><th>FP</th></tr>";
		
			while($row = $result->fetch_assoc()) {
				echo "<tr><td>" . $row["SERVEYNo"] . "</td><td>" . $row["PERSON"] . "</td><td>" . $row["DISTRICT"] . "</td><td>" . $row["MANDAL"] . "</td><td>" . $row["VILLAGE"] . "</td><td>" . $row["KHATANO"] . "</td><td>" . $row["CASTE"] . "</td><td>" . $row["GENDER"] . "</td><td> "; 
				?>
				<img id="image1" src="data:image/jpg;charset=utf8;base64,<?php echo base64_encode($row['fp']); ?>">
				<?php echo"</td></tr>";
			}
			echo "</table>";
		} else {
   	 		echo "No records found for survey number $surveyNo";
		}
		
		// Close the database connection
		$conn->close();
	?>

	<div style="text-align: right;">
		<form method="post" action="compare.php">
			<input type="hidden" name="surveyNo" value="<?php echo $surveyNo ?>">
			<button class="verify-btn" type="submit">Verify</button>
		</form>
	</div>

</body>
</html>