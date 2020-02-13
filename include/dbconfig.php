<?php

	$db_username = '******';
	$db_password = '**********';
	$db_name = '***********';
	$db_host = '**********';
	$item_per_page = 7;
	
	
	try
	{
		$dbcon = new PDO("sqlsrv:Server={$db_host};dbname={$db_name}",$db_username,$db_password);
		$dbcon->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	}
	catch(PDOException $e)
	{
		echo $e->getMessage();
	}

?>