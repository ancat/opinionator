<?php
	//Send.php
	//Send votes to item
	$pg = pg_connect("host=23.92.21.247 dbname=opinionator user=design password=p0stgr3s_is_really_annoying!!"); 
	if(isset($_POST['product1']) && isset($_POST['product2'])){
			$add = pg_prepare($pg,"query",'INSERT INTO showdowns (product_id_1, product_id_2) VALUES ($1, $2)');
			$add = pg_execute($pg, "query", array($_POST['product1'], $POST['product2']) );
			$result = pg_prepare($pg, "query", "SELECT showdown_id FROM showdowns WHERE product_id_1= $1 AND product_id_2= $2");
			$result = pg_execute($pg, "query",array($_POST['product1'], $POST['product2']));
			$test = pg_prepare($pg, "test", "SELECT url_id FROM urls WHERE showdown_id = $1 AND url_active= 1");
			while($list = pg_fetch_row($result)){
				$r = pg_execute($pg, "test", $list);
				if($r){
					$r = pg_fetch_result($r, 0, 0);
					echo "<script> settimeout(\"window.location=window.location+'../showdown.php?sd=".$r."'\" , 3000); ";
				}
			}
			echo "error :c"
	}
	else{
		echo "<b> error </b>"
		echo "<script> window.location += ../../../../../; </script>";
	}
?>
