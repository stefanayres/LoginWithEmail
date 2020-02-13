<?php 
session_start();
include('include/db.class.php');
$db = new db();
$conn = $db->connect();
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
include ("./ms_escape_string.php");

if(isset($_POST['update_button'])) {

	$id        		= trim(filter_var($_POST['DriverID'], FILTER_SANITIZE_NUMBER_INT)); // trim white space and sanitize int or string 
	$id 			= (int)$id; // convert float to string
	$nameF     		= strip_tags(trim(filter_var($_POST['DriverNameF'], FILTER_SANITIZE_STRING)));
	$nameL     		= strip_tags(trim(filter_var($_POST['DriverNameL'], FILTER_SANITIZE_STRING)));
	$email 			= trim(filter_var($_POST['DriverEmail'], FILTER_SANITIZE_EMAIL));
	$Office  		= strip_tags(trim(filter_var($_POST['Office'], FILTER_SANITIZE_STRING)));
	$address    	= strip_tags(trim(filter_var($_POST['DriverAddress'], FILTER_SANITIZE_STRING)));
	$publicId   	= strip_tags( trim(filter_var($_POST['PublicID'], FILTER_SANITIZE_STRING)));
	$DOB1        	= $_POST['DOB'];
	$DOB 			= date('Y-m-d', strtotime($DOB1)); // convert date string to datatime type
	$status     	= strip_tags(trim(filter_var($_POST['Status'], FILTER_SANITIZE_STRING)));
	$areaCode 		= trim(filter_var($_POST['areaCode'], FILTER_SANITIZE_NUMBER_INT));
	$Phone      	= trim(filter_var($_POST['DriverNo'], FILTER_SANITIZE_NUMBER_INT));
	//check if user entered a leeding zero on the number, if so delete the zero
	if (preg_match('/^(?:0)\d+$/', $Phone)) 
		{
			$Phone = substr($Phone, 1); // delete leeding zero
		}
   else 
		{
			$Phone = $Phone; // do notting
		}
	// concat area-code and phone number 
	$PhoneNumber	= $areaCode . $Phone;
	echo 'edit function';

try {

	 $sql = "UPDATE	
	 			dbo.DriverData 
			SET 
				Phone_Number 	= :phone,
				email 			= :email,
				Firstname		= :nameF,
				Lastname		= :nameL,
				office			= :Office,
				public_id 		= :publicId,
				address 		= :address,
				dob 			= :DOB,
				Status 			= :status,
				Date_of_Birth	= :NewDOB
			WHERE
				id 				= :id ";
				
		$stmt= $conn->prepare($sql);

		$stmt->bindParam(':phone', $PhoneNumber, PDO::PARAM_STR);
		$stmt->bindParam(':email', $email, PDO::PARAM_STR);
		$stmt->bindParam(':nameF', $nameF, PDO::PARAM_STR);
		$stmt->bindParam(':nameL', $nameL, PDO::PARAM_STR);
		$stmt->bindParam(':Office', $Office, PDO::PARAM_STR);
		$stmt->bindParam(':address', $address, PDO::PARAM_STR);
		$stmt->bindParam(':publicId', $publicId, PDO::PARAM_STR);   
		$stmt->bindParam(':DOB', $DOB, PDO::PARAM_STR);
		$stmt->bindParam(':status', $status, PDO::PARAM_STR);
		$stmt->bindParam(':NewDOB', $DOB, PDO::PARAM_STR);
		$stmt->bindParam(':id', $id, PDO::PARAM_INT);
		$stmt->execute(); 
		

		}
		//Exception handling
		catch(PDOException $e)
		{
			$urlError =  $e->getMessage();
		}

			if ( !$stmt) {  //$stmt->rowCount() > 0
			echo "\nPDO::errorInfo():\n";
			print_r($conn->errorInfo());
			var_dump($stmt);
			var_dump($urlError);
		}else{
			header("Location: ./index.php?ID=$id");  
			
		}
	} elseif (isset($_POST['insert_button'])) {

		$id        		= trim(filter_var($_POST['DriverID'], FILTER_SANITIZE_NUMBER_INT)); // trim white space and sanitize int or string 
		$id 			= (int)$id; // convert float to string
		$nameF     		= strip_tags(trim(filter_var($_POST['DriverNameF'], FILTER_SANITIZE_STRING)));
		$nameL     		= strip_tags(trim(filter_var($_POST['DriverNameL'], FILTER_SANITIZE_STRING)));
		$email 			= trim(filter_var($_POST['DriverEmail'], FILTER_SANITIZE_EMAIL));
		$Office  		= strip_tags(trim(filter_var($_POST['Office'], FILTER_SANITIZE_STRING)));
		$address    	= strip_tags(trim(filter_var($_POST['DriverAddress'], FILTER_SANITIZE_STRING)));
		$publicId   	= strip_tags( trim(filter_var($_POST['PublicID'], FILTER_SANITIZE_STRING)));
		$DOB1        	= $_POST['DOB'];
		$DOB 			= date('Y-m-d', strtotime($DOB1)); // convert date string to datatime type
		$status     	= strip_tags(trim(filter_var($_POST['Status'], FILTER_SANITIZE_STRING)));
		$areaCode 		= trim(filter_var($_POST['areaCode'], FILTER_SANITIZE_NUMBER_INT));
		$Phone      	= trim(filter_var($_POST['DriverNo'], FILTER_SANITIZE_NUMBER_INT));
		//check if user entered a leeding zero on the number, if so delete the zero
		if (preg_match('/^(?:0)\d+$/', $Phone)) 
			{
				$Phone = substr($Phone, 1); // delete leeding zero
			}
	else 
			{
				$Phone = $Phone; // do notting
			}
		// concat area-code and phone number 
		$PhoneNumber	= $areaCode . $Phone;
		// echo 'add function';

	try { 

		$sql = "INSERT INTO
		 			dbo.DriverData 
				(
					id, 
					Phone_Number, 
					email, 
					Firstname, 
					Lastname, 
					office, 
					public_id, 
					address, 
					Status, 
					Date_of_Birth
				) 
			VALUES 
				(
					:id, 
					:phone, 
					:email, 
					:nameF, 
					:nameL, 
					:Office, 
					:publicId, 
					:address, 
					:status, 
					:NewDOB
				)";
					
			$stmt= $conn->prepare($sql);

			$stmt->bindParam(':phone', $PhoneNumber, PDO::PARAM_STR);
			$stmt->bindParam(':email', $email, PDO::PARAM_STR);
			$stmt->bindParam(':nameF', $nameF, PDO::PARAM_STR);
			$stmt->bindParam(':nameL', $nameL, PDO::PARAM_STR);
			$stmt->bindParam(':Office', $Office, PDO::PARAM_STR);
			$stmt->bindParam(':address', $address, PDO::PARAM_STR);
			$stmt->bindParam(':publicId', $publicId, PDO::PARAM_STR); 
			$stmt->bindParam(':status', $status, PDO::PARAM_STR);
			$stmt->bindParam(':NewDOB', $DOB, PDO::PARAM_STR);
			$stmt->bindParam(':id', $id, PDO::PARAM_INT);
			$stmt->execute(); 
			

			}
			//Exception handling
			catch(PDOException $e)
			{
				$urlError =  $e->getMessage();
			}

				if (!$stmt) {  //$stmt->rowCount() > 0
				echo "\nPDO::errorInfo():\n";
				print_r($conn->errorInfo());
				var_dump($stmt);
				var_dump($urlError);
			}else{
				header("Location: ./index.php?ID=$id");  
				
			}
	}else {
		echo 'failed isset: No data was sent';	
	}
		
		