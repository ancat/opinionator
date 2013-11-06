<?php
	//Vote.php
	header( 'Location: http://www.opinionator.com' ) ;
	if(isset( $_POST['vote']) && isset($_POST['sd']) ){
		$pg = pg_connect("host=23.92.21.247 dbname=opinionator user=design password=p0stgr3s_is_really_annoying!!"); //Just use a require for all db needz
		$add = pg_prepare($pg,"vote",'INSERT INTO showdowns (vote_id, showdown_id, ip_address) VALUES ($1, $2, $3)');
		$add = pg_execute($pg, "vote", array( $_POST['vote'],$_POST['sd'], $_SERVER['REMOTE_ADDR'] ) );
	}
?>
