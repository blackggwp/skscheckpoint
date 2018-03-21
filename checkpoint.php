<?php require 'header.php'; ?>
  <body>
  <br>
<?php
// print_r($_POST);
$authenPass = $_POST['authen_password'];
if (((isset($_POST['authen_submit'])) && ($authenPass == '7852899')) || 
((isset($_POST['checkPoint_submit']))) ) {
  echo '<div id="authen_panel">
  <form method="POST" name="checkPoint_form">
  <h3>CustomerID</h3>
    <label id="customerid-error" class="error" for="customerid"></label><br>
		<input type="number" id="customerid" name="customerid" placeholder="ระบุรหัสบัตร" required>
			<br>
			<br>
			<button type="submit" name="checkPoint_submit">checkpoint</button>
		</form>
		</div>
		<br>';
}

// print_r($_POST);

$customerID = $_POST['customerid'];

if ((isset($_POST['checkPoint_submit'])) && ($customerID != '') ) {
	require_once 'conf/conn.php';
$queryPoint = " SELECT     tcustomerlog_cal.customerid, 
SUM(tcustomerlog_cal.addpoint - tcustomerlog_cal.delpoint) AS point, 
T_Customer.CustomerName, T_Customer.CustomerLast, 
CONVERT(varchar, T_Customer.CustomerStartdate, 103) as CustomerStartdate, 
CONVERT(varchar, T_Customer.CustomerEnddate, 103) as CustomerEnddate
FROM tcustomerlog_cal INNER JOIN
  T_Customer ON tcustomerlog_cal.customerid = T_Customer.CustomerID
WHERE     (tcustomerlog_cal.customerid = ?)
GROUP BY tcustomerlog_cal.customerid, T_Customer.CustomerName, 
T_Customer.CustomerLast, T_Customer.CustomerStartdate, T_Customer.CustomerEnddate ";
// echo $queryPoint;

// $stmt = $conn->query( $queryPoint );
$stmt = $conn->prepare( $queryPoint, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
$stmt->bindParam(1, $customerID,PDO::PARAM_STR);
$stmt->execute();  
$pointRowCount = $stmt->rowCount();
// var_dump($pointRowCount);

if ($pointRowCount != 0) {

  echo '<h3>ข้อมูลบัตรสมาชิก</h3>
<table class="rwd-table">
<tr>
  <th>CustomerID</th>
  <th>CustomerPoint</th>
  <th>Name</th>
  <th>Last</th>
  <th>StartDate</th>
  <th>EndDate</th>
  
</tr>';

while ( $row = $stmt->fetch( PDO::FETCH_ASSOC ) ){  
  echo "<tr>";
   print_r( "<td data-th=\"ID\">".$row['customerid'] ."</td>" );
   print_r( "<td data-th=\"Point\" class=\"td__textlong\">".$row['point'] ."</td>" );
   print_r( "<td data-th=\"Name\" class=\"td__textlong\">".$row['CustomerName'] ."</td>" );
   print_r( "<td data-th=\"Last\" class=\"td__textlong\">".$row['CustomerLast'] ."</td>" );
   print_r( "<td data-th=\"Start\" class=\"td__textlong\">".$row['CustomerStartdate'] ."</td>" );
   print_r( "<td data-th=\"End\" class=\"td__textlong\">".$row['CustomerEnddate'] ."</td>" );
   echo "</tr>";
} 
echo '</table>
<hr>';

$queryLog =" SELECT  CONVERT(varchar, scprogramdate, 103) as scprogramdate,
outletcode, addpoint, delpoint, scinvoice, totalcharge
FROM tcustomerlog_cal
WHERE (customerid = ?) 
ORDER BY convert(datetime, scprogramdate, 103) ASC ";
// echo $queryLog;
// $stmt = $conn->query( $queryLog );
$stmt = $conn->prepare( $queryLog );
$stmt->bindParam(1, $customerID,PDO::PARAM_STR);
$stmt->execute();
$logRowCount = $stmt->rowCount();

if($logRowCount != 0) {

echo '<h3>ข้อมูลการใช้บัตรสมาชิก</h3>
<table class="rwd-table">
<tr>
  <th>Date</th>
  <th>OutletCode</th>
  <th>AddPoint</th>
  <th>DelPoint</th>
  <th>Invoice</th>
  <th>TotalCharge</th>
  
</tr>';
while ( $row = $stmt->fetch( PDO::FETCH_ASSOC ) ){  
  echo "<tr>";
   print_r( "<td data-th=\"Date\">".$row['scprogramdate'] ."</td>" );
   print_r( "<td data-th=\"Outlet\" class=\"td__textlong\">".$row['outletcode'] ."</td>" );
   print_r( "<td data-th=\"AddPoint\" class=\"td__textlong\">".$row['addpoint'] ."</td>" );
   print_r( "<td data-th=\"DelPoint\" class=\"td__textlong\">".$row['delpoint'] ."</td>" );
   print_r( "<td data-th=\"Inv\" class=\"td__textlong\">".$row['scinvoice'] ."</td>" );
   print_r( "<td data-th=\"Total\" class=\"td__textlong\">".$row['totalcharge'] ."</td>" );
   echo "</tr>";
} 
echo '</table>';

}
else{
  echo 'ไม่พบข้อมูลการใช้บัตรสมาชิก';
}

}else{
  echo 'ไม่พบข้อมูล';
}
}elseif($authenPass != '7852899') {
  echo 'รหัสผ่านไม่ถูกต้อง';
}


?>

</table>
</body>
<?php require 'footer.php'; ?>
