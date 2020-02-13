<?php 
session_start();
include('include/db.class.php');
$db = new db();
$conn = $db->connect();
include ("./ms_escape_string.php");

if (isset( $_POST["submit"]))
{
	
	$OrgNum = $_GET["Number"];
	$Num1 = substr($OrgNum,5);
	$Num2 = "0{$Num1}";
	$returnPhone = $Num2;
	
	$Phone = $_GET["Number"];	
	$callnotes 		= ms_escape_string($_POST["MyCallNotes"]);

	try {
		// prepared statement to insert user data
		$sql = "UPDATE SalesReps SET Call_Notes = :CallNotes WHERE Phone = :Phone";
		$stmt = $conn->prepare($sql);
		$stmt->bindParam(':CallNotes', $callnotes); 
		$stmt->bindParam(':Phone', $Phone);
		$stmt->execute(); 
		}
		//Exception handling
		catch(PDOException $e)
		{
			$urlError =  $e->getMessage();
		}

			if (!$stmt) {
			echo "\nPDO::errorInfo():\n";
			print_r($pdo->errorInfo());
		}else{
			header("Location: ./index.php?Number=$returnPhone&submit=&message=success");  
			
		}
}else {
	echo 'failed isset: No data was ';	
}
       
