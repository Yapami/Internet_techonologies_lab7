<?php
include("bd.php");
$dateToShow=$_POST['dateToShow'];
//$dateToShow="2014-09-01";
//echo strtotime("2014-09-02")-strtotime("2014-09-03");
//echo strtotime("2014-09-03");
//echo $dateToShow;

$res = $mysqli->query("SELECT * FROM cars");
$res->data_seek(0);
while ($myrow = $res->fetch_assoc())
{
	$arrayCar[$myrow["ID_Cars"]]=$myrow["Name"];
	$availableCar[$myrow["ID_Cars"]]="Available";
}

$res = $mysqli->query("SELECT * FROM rent");
		$res->data_seek(0);
		$allCost=0;
		while ($myrow = $res->fetch_assoc())
		{
			//echo myrow['Date_start'];
			if ($dateToShow!=""){
				if (($myrow['Date_start']<=$dateToShow)&&($myrow['Date_end']>=$dateToShow)){

					
					
					if ($dateToShow==$myrow['Date_start']){
						if ($availableCar[$myrow["FID_Car"]]=="Available"){
							$availableCar[$myrow["FID_Car"]]="Available till ".$myrow['Time_start'];
						}else{
							$availableCar[$myrow["FID_Car"]]=$availableCar[$myrow["FID_Car"]]." till"+$myrow['Time_start'];
						}
					}else if ($dateToShow==$myrow['Date_end']){
						if ($availableCar[$myrow["FID_Car"]]=="Available"){
							$availableCar[$myrow["FID_Car"]]="Available after ".$myrow['Time_end'];
						}else{
							$availableCar[$myrow["FID_Car"]]=$availableCar[$myrow["FID_Car"]]." after"+$myrow['Time_end'];
						}
					}else{
						$availableCar[$myrow["FID_Car"]]="Not available";
					}
				}
				
			}
		}
		if ($dateToShow!=""){
			foreach($availableCar as $id => $status) {
				
				$table=$table."<tr><td>".$arrayCar[$id]."</td><td>";
				if ($status=="Available"){
					$table=$table."<font color='green'>";
				}
				else if ($status=="Not available"){
					$table=$table."<font color='red'>";
				}
				else{
					$table=$table."<font color='yellow'>";
				}
				$table=$table.$status."</font></td></tr>";
			}
			
		}

		//echo $table;
?>
<!DOCTYPE HTML>
<html>
 <head>
 <script>
function loadDoc(str) {
	if (str == "") {
        document.getElementById("txtHint").innerHTML = "";
        return;
    } else {
        if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                var xhttp = new XMLHttpRequest();
				xhttp.onreadystatechange = function() {
					if (this.readyState == 4 && this.status == 200) {
						myFunction(this);
					}
				};
				xhttp.open("GET", "data.xml", true);
				xhttp.send();
            }
        };
        xmlhttp.open("GET","bdXML.php?q="+str,true);
        xmlhttp.send();
    }

}
function myFunction(xml) {
  var i;
  var xmlDoc = xml.responseXML;
  var table="<tr><th>Name</th><th>Avaliability</th></tr>";
  var x = xmlDoc.getElementsByTagName("CAR");
  for (i = 0; i <x.length; i++) { 
    table += "<tr><td>" +
    x[i].getElementsByTagName("Name")[0].childNodes[0].nodeValue +
    "</td><td>";
	if (x[i].getElementsByTagName("Text")[0].getAttribute('Color')=="red"){
		table +="<font color='red'>";
	}else if (x[i].getElementsByTagName("Text")[0].getAttribute('Color')=="green"){
		
		table +="<font color='green'>";
	}else if (x[i].getElementsByTagName("Text")[0].getAttribute('Color')=="yellow"){
		
		table +="<font color='yellow'>";
	}
    table +=x[i].getElementsByTagName("Text")[0].childNodes[0].nodeValue+"</font></td></tr>";
  }
  document.getElementById("myTable").innerHTML = table;
}
</script>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <title>ЛБ 3(Свободные машины)</title>
  <link href="external.css" rel="stylesheet">
 </head>
 <body>

<div class="navigation">
<form action="avaliable_car.php" method="post">
<a style="margin-left: 50px;">Выберите дату:</a><br><br>
<input name="dateToShow" onchange="loadDoc(this.value)" style="background-color: #2980b9; border-radius: 10px;margin-left: 75px;" type=date>

</form>
<br><br>

<table id="myTable" class="table_dark">
   <?php //echo $table; ?>
</table><br>
<?php echo $out;?>
</div>

 </body>
</html>
