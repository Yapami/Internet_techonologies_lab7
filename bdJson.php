<?php
include("bd.php");
$arrayMoney = array();
$q = $_GET['q'];
$dateToShow=$q;
//$dateToShow="2014-11-15";
//echo strtotime("2014-09-02")-strtotime("2014-09-03");
//echo strtotime("2014-09-03");
//echo $dateToShow;
$res = $mysqli->query("SELECT * FROM rent");
		$res->data_seek(0);
		$allCost=0;
		while ($myrow = $res->fetch_assoc())
		{
			//echo myrow['Date_start'];
			if ($dateToShow!=""){
				if (($myrow['Date_start']<=$dateToShow)&&($myrow['Date_end']>=$dateToShow)){
					$res1 = $mysqli->query("SELECT * FROM cars WHERE ID_Cars=".$myrow['FID_Car']);
					$res1->data_seek(0);
					$myrow1 = $res1->fetch_assoc();
					
					
					
					$allRentTime=strtotime($myrow['Date_end'])-strtotime($myrow['Date_start'])."<br>";
					//echo strtotime($myrow['Time_end'])-strtotime($myrow['Time_start']);
					$allRentTime=$allRentTime+ strtotime($myrow['Time_end'])-strtotime($myrow['Time_start'])."<br>";
					$allRentTime=$allRentTime*1.0;
					$costPerSec=$myrow['Cost']/$allRentTime;
					//echo $costPerSec."<br>";
					$moneyPerDay=$costPerSec*60*60*24;
					//echo 86400-strtotime($myrow['Time_end'])+strtotime("00:00:00");
					if ($dateToShow==$myrow['Date_start']){
						$moneyPerDay=$moneyPerDay-((strtotime($myrow['Time_start'])-strtotime("00:00:00"))*$costPerSec);
					}else if ($dateToShow==$myrow['Date_end']){
						$moneyPerDay=$moneyPerDay-((86400-strtotime($myrow['Time_end'])+strtotime("00:00:00"))*$costPerSec);
						
					}
					array_push($arrayMoney, $myrow1['Name'], $moneyPerDay);
					$table=$table."<tr><td>".$myrow1['Name']."</td><td>".$moneyPerDay."</td></tr>";
					$allCost=$allCost+$moneyPerDay;
					//echo $myrow['Date_start']."-".$myrow['Date_end']."=".($myrow['Date_end']-$myrow['Date_start'])."<br>";
				}
				
			}
		}
		if ($dateToShow!=""){
			array_push($arrayMoney, "All", $allCost);
			$table="<tr><th>All</th><th>".$allCost."</th></tr>".$table;
		}
		//var_dump($arrayMoney)
		echo json_encode($arrayMoney);
//echo 1;
?>
