<?php 
session_start();
include('include/db.class.php');
$db = new db();
$conn = $db->connect();
include ("./ms_escape_string.php");

if (isset( $_POST["submit"]))
{
	// taking away 00353 at the start of the number after insert for re-direct to index 
	$OrgNum = $_POST["Phone"];
	$Num1 = substr($OrgNum,5);
	$Num2= "0{$Num1}";
	$returnPhone = $Num2;

	try {
		// prepared statement to insert user data
		$sql = "INSERT INTO SalesReps_SS (Rep_Name, RSM, Phone, Email, Campaign) VALUES (:Name, :RSM, :Phone, :Email, :Campaign)";
		$stmt = $conn->prepare($sql); 
		// binding the values
		$stmt->bindParam(':Name', $Name);
		$stmt->bindParam(':RSM', $RSM);
		$stmt->bindParam(':Phone', $Phone);
		$stmt->bindParam(':Email', $Email);
		$stmt->bindParam(':Campaign', $Campaign);
		//setting the variables 
		$Name 		=  ms_escape_string($_POST["repName"]);
		$RSM 		=  ms_escape_string($_POST["RSMname"]);
		$Email		=  ms_escape_string($_POST["Email"]);
		$Campaign	=  ms_escape_string($_POST["Campaign"]);
		$Phone 		=  ms_escape_string($_POST["Phone"]);
		//execute the query 
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
       