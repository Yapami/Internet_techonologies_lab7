<!DOCTYPE html>
<html>
<head>
<link href="external.css" rel="stylesheet">
</head>
<body>

<?php
$q = $_GET['q'];
//echo $q;
$con = mysqli_connect('localhost','root','ddeenn16102001','iteh2lb1var7');
if (!$con) {
    die('Could not connect: ' . mysqli_error($con));
}

mysqli_select_db($con,"iteh2lb1var7");
$sql="SELECT * FROM vendors WHERE Name = '".$q."'";

$result = mysqli_query($con,$sql);
$row = mysqli_fetch_array($result);
$sql1="SELECT * FROM cars WHERE FID_Vendors=".$row['ID_Vendors'];
$res1 = mysqli_query($con,$sql1);
echo "<table id='myTable' class='table_dark'>
<tr>
<th>Машина</th>
<th>Производитель</th>
</tr>";
while($row1 = mysqli_fetch_array($res1)) {
    echo "<tr>";
    echo "<td>" . $row1['Name'] . "</td>";
    echo "<td>" . $q . "</td>";
    echo "</tr>";
}
echo "</table>";
mysqli_close($con);
?>
</body>
</html>