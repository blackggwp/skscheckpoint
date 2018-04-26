<?php require 'header.php'; ?>
  <body>
  <br>
<?php
date_default_timezone_set('Asia/Bangkok');
// print_r($_POST);

if (isset($_POST['authen_submit'])) {
  require_once 'conf/conn.php';
  $authenUser = $_POST['authen_user'];
  $authenPass = $_POST['authen_password'];
  $queryUser = " SELECT nUserID, outletcode, expid, expdate, strUserName, position, typeuser, isManager, levelCode, emppassword
  FROM  imp_emp2
  WHERE (nUserID = ?) AND (emppassword = ?) AND ((levelCode = 9) OR (position = 'Operation')) ";
// echo $queryPoint;
// $stmt = $conn->query( $queryPoint );
$stmt = $conn->prepare( $queryUser, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
$stmt->bindParam(1, $authenUser,PDO::PARAM_STR);
$stmt->bindParam(2, $authenPass,PDO::PARAM_STR);
$stmt->execute();
$userRowCount = $stmt->rowCount();
// var_dump($pointRowCount);
if ($userRowCount != 0) {

  $result = $stmt->fetchall(PDO::FETCH_BOTH);
  // var_dump($result);
  echo '<div style="float:right;background-color:silver;">
  <h3>เปลี่ยนรหัสผ่าน</h3>
  <form method="POST" name="changePassword_form">
  <input type="text" id="changepassword_pass" name="changepassword_pass" placeholder="ระบุรหัสที่ต้องการเปลี่ยน">
  <input type="hidden"  name="changepassword_user" value="'.$authenUser.'">
  <button type="submit" name="changePassword_submit">ChangePassword</button>
  </div>';

  
  echo '<div id="authen_panel">';
  echo '<h2>ยินดีต้อนรับ '.$result[0]['strUserName'].'</h2>';
  echo '<form method="POST" name="checkPoint_form">
  <h3>CustomerID</h3>
    <label id="customerid-error" class="error" for="customerid"></label><br>
		<input type="number" id="customerid" name="customerid" placeholder="ระบุรหัสบัตร">
			<br>
			<br>
			<button type="submit" name="checkPoint_submit">checkpoint</button>
		</form>
		</div>
    <br>
    <input action="action" onclick="window.history.go(-1); return false;" type="button" value="Logout" />
    ';
}else{
  echo 'ชื่อผู้ใช้หรือรหัสผ่านไม่ถูกต้อง';
  echo '<br>';
  echo '<input action="action" onclick="window.history.go(-1); return false;" type="button" value="Back" />';
}
}

// change password form
if ((isset($_POST['changePassword_submit'])) && 
($_POST['changepassword_pass'] != '')) {
  // echo $_POST['changepassword_user'];
  require_once 'conf/conn.php';
$SQLChangePass = " UPDATE imp_emp2 SET emppassword = ? WHERE nUserID = ? ";
$stmtChangePass = $conn->prepare( $SQLChangePass, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
$stmtChangePass->bindParam(1, $_POST['changepassword_pass'],PDO::PARAM_STR);
$stmtChangePass->bindParam(2, $_POST['changepassword_user'],PDO::PARAM_STR);
$status = $stmtChangePass->execute();
if($status) {
  echo 'เปลี่ยนรหัสผ่านสำเร็จ';
  echo '<br>';
  echo '<input action="action" onclick="window.history.go(-1); return false;" type="button" value="Back" />';
}else {
  echo 'เปลี่ยนรหัสผ่านไม่สำเร็จ';
  echo '<br>';
  echo '<input action="action" onclick="window.history.go(-1); return false;" type="button" value="Back" />';
}
}

// checkpoint form
$customerID = $_POST['customerid'];
if ((isset($_POST['checkPoint_submit'])) && ($customerID != '') ) {
  require_once 'conf/conn.php';
    // Save log login
    $saveLog = " INSERT INTO log_view_point (username, systemdate, customerid)
    VALUES (?, ?, ?) ";
    $stmtSaveLog = $conn->prepare( $saveLog, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
    $stmtSaveLog->bindParam(1, $_POST['changepassword_user'],PDO::PARAM_STR);
    $systemdate = date("Y-m-d H:i:s");
    $stmtSaveLog->bindParam(2, $systemdate,PDO::PARAM_STR);
    $stmtSaveLog->bindParam(3, $customerID,PDO::PARAM_STR);
    $stmtSaveLog->execute();

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
echo '<input action="action" onclick="window.history.go(-1); return false;" type="button" value="Back" />';
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
  echo 'ไม่พบข้อมูลการใช้บัตรสมาชิก<br>';
  echo '<input action="action" onclick="window.history.go(-1); return false;" type="button" value="Back" />';
}

}else{
  echo 'ไม่พบข้อมูล<br>';
  echo '<input action="action" onclick="window.history.go(-1); return false;" type="button" value="Back" />';
}
}
?>

</table>
</body>
<?php require 'footer.php'; ?>
