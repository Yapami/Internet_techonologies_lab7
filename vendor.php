<?php
include("bd.php");

$res = $mysqli->query("SELECT * FROM vendors");
		$res->data_seek(0);
		while ($myrow = $res->fetch_assoc())
		{
			$vendors=$vendors."<option value='".$myrow['Name']."'>".$myrow['Name']."</option>";
		}

		//echo $table;
?>
<!DOCTYPE HTML>
<html>
 <head>
 <script>
function showUser(str) {
	//document.write(str+"q");
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
                document.getElementById("txtHint").innerHTML = this.responseText;
            }
        };
        xmlhttp.open("GET","bdAjax.php?q="+str,true);
        xmlhttp.send();
    }
}
</script>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <title>ЛБ 3(Производитель)</title>
  <link href="external.css" rel="stylesheet">
 </head>
 <body>

<div class="navigation">
<form action="vendor.php" method="post">
<a style="margin-left: 50px;">Выберите производителя:</a><br>
<span class="custom-dropdown big">
    <select style="margin-left: 135px;" name="vendorToShow" onchange="showUser(this.value)">    
        <option selected="selected"  disabled value="">Производитель</option>
		<?php echo $vendors ?>
    </select>
</span>
</form>
<div id="txtHint"><b></b></div>
<br>
</div>

 </body>
</html>
