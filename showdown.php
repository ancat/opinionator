<?php
	//require("dbApi.php") // placeholder for interfacing with database
$pg = pg_connect("host=23.92.21.247 dbname=opinionator user=design password=p0stgr3s_is_really_annoying!!"); 
if(isset($_GET['sd']) /*&& isValidSd($_GET['sd'])*/){
	//isValidSd is another imaginary function
	echo 
"<html>
	<title>Product Showdown</title>
		<body>
			<div align=\"center\">";
	$result = pg_prepare($pg,"query","SELECT * FROM showdowns WHERE showdown_id =$1");
	$result = pg_execute($pg, "query", array($_GET['sd']));
	if(!$result){
		echo"
			<h1><b>showdown_id not found! </b></h1>
			<script>
				settimeout(\"window.location=window.location+'../../../../'\" , 3000);
			</script>
		</body>
	</html>";
	die();
	}
	echo "				<form name=\"Vote!\"  action=\"/vote.php\" method=\"POST\">";
	$list = pg_fetch_row($result);
		echo "				<input type=\"Radio\" name=vote value=0>".$list[1]."<br/><br/><br/>";
		echo "				<input type=\"Radio\" name=vote value=1>".$list[2]."<br/><br/><br/>";
	echo
"				<input type=\"submit\" name=\"Submit\">
			</form>
		</div>
	</body>
</html>";
}
else{
		echo 
	"<html>
		<title> Product Showdown Select</title>
			<body>
			<div align=\"center\">
				<form name=\"Choose Competitors\" action=\"/send.php\" method=\"POST\">";
		echo "<select name=\"product1\">";
		$result = pg_prepare($pg, "query", "SELECT * FROM products");
		$result = pg_execute($pg, "query");
		while($list = pg_fetch_row($result)){
			$opt.="<option value=\"".$list[1]."\">".$list[1]."</option>";
		}
		opt .= "</select>";
		echo opt;
		echo "</br></br></br>";
		echo "<b> VS </b>";
		echo "</br></br></br>";
		echo "<select name=\"product2\">";
		echo opt;
		echo "</br></br></br>";
		echo 
			"	<input value=\"Submit\" type=\"submit\">
			</div>
			</body>
		</title>
	</html>";
}
?>
