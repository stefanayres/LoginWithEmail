<?php
require('include/password.php');
include('include/db.class.php');

// use PHPMailer\PHPMailer\PHPMailer;
// use PHPMailer\PHPMailer\Exception;

// require 'include/PHPMailer/src/Exception.php';
// require 'include/PHPMailer/src/PHPMailer.php';
// require 'include/PHPMailer/src/SMTP.php';


$mydb = new db();
$conn = $mydb->connect(); 
session_start();

    //Retrieve the field values from our login form.
    $name       = !empty($_POST['name']) ? trim($_POST['name']) : null;
    $email      = !empty($_POST['email']) ? trim($_POST['email']) : null;
    $password   = !empty($_POST['password']) ? trim($_POST['password']) : null;

    // check if data is set from the form
    if($name === null || $email === null || $password === null){

        echo 'failedFormData';
        die();

    } else {
        
       // Validate password strength
        $validatePass = preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{6,}$/', $password);

        if(!$validatePass) {
            echo 'failedPasswordValidate';
            die();
        }


        //if the user is set take the password attempt and hash the string 
        $passwordHashed = password_hash($password, PASSWORD_BCRYPT);

        // check hash did not fail
        if ($passwordHashed != FALSE || $passwordHashed != null) {
            $timestamp = date('Y-m-d G:i:s');

        try {

            $sql = "INSERT INTO dbo.users (email, password, name, created) VALUES (:email, :passwords, :names, :dates)";
            $stmt = $conn->prepare($sql);

            $stmt->bindValue(':email', $email);
            $stmt->bindValue(':passwords', $passwordHashed);
            $stmt->bindValue(':names', $name);
            $stmt->bindValue(':dates', $timestamp); 
            $stmt->execute();

        }
            //Exception handling
            catch(PDOException $e)
		{
			$urlError =  $e->getMessage();
        }
            if (!$stmt) {
                echo 'failedDatabase';
                die();
                //echo "\nPDO::errorInfo():\n"; 
                //print_r($pdo->errorInfo());
            }else{
                $result = file_get_contents('https://therian-gulf.000webhostapp.com?name='.$name.'&email='.$email.'');
                echo 'success'; 
                exit; 
            }
       
        } else {
            /* Invalid - hashed password failed*/
            echo 'failedHashed';
            die();
        }
    }