<?php 
session_start();
include('include/db.class.php');
$db = new db();
$conn = $db->connect();
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
include ("./ms_escape_string.php");

# Set a default response
$def    = array('alert'=>true);
# Remove empty values
$email  = trim($_POST['email']);
# First check this is an actual email
if(!filter_var($email,FILTER_VALIDATE_EMAIL))
	die(json_encode($def));
	
# You should bind/prepare $email, not insert variable into string
$sql = "SELECT COUNT(*) as count FROM users WHERE email = :email";
$stmt = $conn->prepare($sql);
$stmt->bindValue(':email', $email);
$stmt->execute();
$count = $stmt->fetch();

if ($count['count'] > 0) // frtch returned an array so you need to get the value of the count key
{ 
	// Email is in the db
	die('email_taking');
 } else {
	// Email was not in the db
	die('email_avaliable');
 }

