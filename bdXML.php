<?php
include("bd.php");
$q = $_GET['q'];
$dateToShow=$q;
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
		
		$dom = new DomDocument('1.0', 'UTF-8'); 
		$cars = $dom->createElement('CARS');
		
		if ($dateToShow!=""){
			foreach($availableCar as $id => $status) {
				
				$table=$table."<tr><td>".$arrayCar[$id]."</td><td>";
				$root = $dom->createElement('CAR');
				$child_node_name = $dom->createElement('Name', $arrayCar[$id]);
				$root->appendChild($child_node_name);
				$child_node_text = $dom->createElement('Text', $status);
				if ($status=="Available"){
					$table=$table."<font color='green'>";
					$attr_color_text = new DOMAttr('Color', 'green');
				}
				else if ($status=="Not available"){
					$table=$table."<font color='red'>";
					$attr_color_text = new DOMAttr('Color', 'red');
				}
				else{
					$table=$table."<font color='yellow'>";
					$attr_color_text = new DOMAttr('Color', 'yellow');
				}
				$child_node_text->setAttributeNode($attr_color_text);
				$root->appendChild($child_node_text);
				$cars->appendChild($root);
				$table=$table.$status."</font></td></tr>";
			}
			
		}
    //Creates XML string and XML document using the DOM 



		
		
		
		
		
		
		
		
/*
** insert more nodes
*/
	$dom->appendChild($cars);
    $dom->formatOutput = true; // set the formatOutput attribute of domDocument to true

    // save XML as string or file 
    $test1 = $dom->saveXML(); // put string in test1
    $dom->save('data.xml'); // save as file
		echo $table;
?>