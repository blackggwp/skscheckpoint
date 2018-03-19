<!DOCTYPE html>
<html lang="">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Title Page</title>

    <!-- Bootstrap CSS -->
    <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous"> -->
    <link rel="stylesheet" type="text/css" href="restable.css" />


  </head>
  <body>

  <h1>RWD List to Table</h1>
<table class="rwd-table">
  <tr>
    <th>Movie Title</th>
    <th>Genre</th>
    <th>Year</th>
    <th>Gross</th>
    <th>Year</th>
    <th>Gross</th>
    <th>Year</th>
    <th>Gross</th>
  </tr>
  <tr>
    <td data-th="Movie Title">Star Wars</td>
    <td data-th="Genre">Adventure, Sci-fi</td>
    <td data-th="Year">1977</td>
    <td data-th="Gross">$460,935,665</td>
    <td data-th="Movie Title">Star Wars</td>
    <td data-th="Genre">Adventure, Sci-fi</td>
    <td data-th="Year">1977</td>
    <td data-th="Gross">$460,935,665</td>
  </tr>
  <tr>
    <td data-th="Movie Title">Howard The Duck</td>
    <td data-th="Genre">"Comedy"</td>
    <td data-th="Year">1986</td>
    <td data-th="Gross">$16,295,774</td>
    <td data-th="Movie Title">Star Wars</td>
    <td data-th="Genre">Adventure, Sci-fi</td>
    <td data-th="Year">1977</td>
    <td data-th="Gross">$460,935,665</td>
  </tr>
  <tr>
    <td data-th="Movie Title">American Graffiti</td>
    <td data-th="Genre">Comedy, Drama</td>
    <td data-th="Year">1973</td>
    <td data-th="Gross">$115,000,000</td>
    <td data-th="Movie Title">Star Wars</td>
    <td data-th="Genre">Adventure, Sci-fi</td>
    <td data-th="Year">1977</td>
    <td data-th="Gross">$460,935,665</td>
  </tr>
</table>

<p>&larr; Drag window (in editor or full page view) to see the effect. &rarr;</p>

<table class="rwd-table">
<tr>
  <th>CustomerID</th>
  <th>CustomerName</th>
  <th>CustomerLast</th>
  <th>CustomerMobile</th>
</tr>

<?php
require_once 'conf/conn.php';
$query = 'select TOP 10 * from T_Customer_Web';  

// simple query  
$stmt = $conn->query( $query );  
while ( $row = $stmt->fetch( PDO::FETCH_ASSOC ) ){  
  echo "<tr>";
   print_r( "<td data-th=\"CusID\">".$row['CustomerID'] ."</td>" );
   print_r( "<td data-th=\"CusName\" class=\"td__textlong\">".$row['CustomerName'] ."</td>" );
   print_r( "<td data-th=\"CusLast\" class=\"td__textlong\">".$row['CustomerLast'] ."</td>" );
   print_r( "<td data-th=\"CusMobile\">".$row['CustomerMobile'] ."</td>" );
   echo "</tr>";
} 

// query for one column  
// $stmt = $conn->query( $query, PDO::FETCH_COLUMN, 1);  
// while ( $row = $stmt->fetch() ){  
//    echo "$row\n";  
// }  
?>

</table>
    <!-- jQuery -->
    <script src="//code.jquery.com/jquery.js"></script>
    <!-- Add respond.js for responsive table-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/respond.js/1.4.2/respond.min.js"></script>

    <!-- Bootstrap JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
  </body>
</html>
