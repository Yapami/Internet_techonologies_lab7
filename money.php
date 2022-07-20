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
				var table="";
				let newLine=0;
				JSON.parse(this.responseText, function(k, v) {
					if (v.toString().indexOf(',')==-1){
					 	if (newLine==0){
							newLine = 1;
							table += "<tr><td>" +v+"</td>";
						}else{
							newLine = 0;
							table += "<td>" +v+"</td></tr>";
						}
						console.log("k="+k);
						console.log("v="+v);
					}

				}); 
                document.getElementById("myTable").innerHTML = table;
            }
        };
        xmlhttp.open("GET","bdJson.php?q="+str,true);
        xmlhttp.send();
    }
}
</script>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <title>ЛБ 3(Прибыль)</title>
  <link href="external.css" rel="stylesheet">
 </head>
 <body>

<div class="navigation">
<form action="money.php" method="post">
<a style="margin-left: 50px;">Выберите дату:</a><br><br>
<input name="dateToShow" onchange="showUser(this.value)" style="background-color: #2980b9; border-radius: 10px;margin-left: 75px;" type=date>

</form>
<br><br>
<table id="myTable" class="table_dark">
</table><br>
<div id="txtHint"><b></b></div>
<br>
</div>

 </body>
</html>
