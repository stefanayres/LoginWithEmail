<?php
session_start();
include('include/db.class.php');
$db = new db();
$conn = $db->connect();
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
 include ("./ms_escape_string.php");

function search($searchVal ,$db){

try{
    
    $searchVal = trim($searchVal);
    $limit = strlen($searchVal);

    if($limit < 9){
        $sql = "SELECT TOP 5 * FROM DriverData WHERE id = :searchVal ORDER BY id DESC"; //ORDER BY id DESC
        $stmt = $db->prepare($sql); 
        $stmt->bindValue(':searchVal', $searchVal, PDO::PARAM_STR);
        $stmt->execute();
        $total = $stmt->rowCount();

        while($data = $stmt->fetch(PDO::FETCH_ASSOC)){
            $id = (int)$data['id'];
            echo '<a href="index.php?ID='.$id.'">Sorry '.$id.' is taking</a></br>';       
        }
        $var = $limit - 8;
        $newLimit = str_replace("-", "", $var);
        if($newLimit > 0){
            echo '<p>You have '.$newLimit.' digits left.</p>';
        }
        
    }
}
    catch (PDOException $e) {
    return 'Connection failed: ' . $e->getMessage();
    }
} 

search($_GET['txt'], $conn);



    