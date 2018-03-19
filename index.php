<!DOCTYPE html>
<html lang="">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Checkpoint</title>
		<!-- Bootstrap CSS -->
		<!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous"> -->
    <link rel="stylesheet" type="text/css" href="medium.css" />
    <!-- <link rel="stylesheet" type="text/css" href="restable.css" /> -->
    <link rel="stylesheet" href="restable.css?<?php echo '?ver=' . filemtime('restable.css'); ?>" type="text/css" media="screen, projection" />
	
	</head>
	<body>
		<h1 class="text-center">Sukishi Checkpoint Online</h1>
		<br>
		<form action="checkpoint.php" name="authen_form" method="post">
		<input type="password" name="authen_password">
		<button type="submit" name="authen_submit">Authen</button>
		</form>
		<br>
<?php
// print_r($_POST);
$customerID = $_POST['customerid'];
if ((isset($_POST['checkPoint_submit'])) && ($customerID != '') ) {
	require_once 'conf/conn.php';
// $query = "select TOP 10 * from T_Customer_Web WHERE customerid = '$customerID' ";
$queryPoint = " SELECT customerid, SUM(addpoint - delpoint) AS point
FROM tcustomerlog_cal
WHERE (customerid = '$customerID')
GROUP BY customerid ";
// echo $queryPoint;

echo '<table class="rwd-table">
<tr>
  <th>CustomerID</th>
  <th>CustomerPoint</th>
</tr>';

$stmt = $conn->query( $queryPoint );  
while ( $row = $stmt->fetch( PDO::FETCH_ASSOC ) ){  
  echo "<tr>";
   print_r( "<td data-th=\"ID\">".$row['customerid'] ."</td>" );
   print_r( "<td data-th=\"Point\" class=\"td__textlong\">".$row['point'] ."</td>" );
   echo "</tr>";
} 
}
echo '</table>';
?>
	</body>
	<footer>
	    <!-- jQuery -->
		<script src="//code.jquery.com/jquery.js"></script>
		<script src="main.js"></script>
    <!-- Add respond.js for responsive table-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/respond.js/1.4.2/respond.min.js"></script>

    <!-- Bootstrap JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
	</footer>
</html>