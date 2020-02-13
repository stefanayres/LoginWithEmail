<?php
require('include/password.php');
include('include/db.class.php');
$mydb = new db();
$conn = $mydb->connect(); 
session_start();

if (isset($_POST['submit'])) {

    //Retrieve the field values from our login form.
    $email = !empty($_POST['email']) ? trim($_POST['email']) : null;
    $passwordAttempt = !empty($_POST['password']) ? trim($_POST['password']) : null;

    //Retrieve the user account information for the given username.
    $sql = "SELECT id, email, password, name, is_approved FROM users WHERE email = :email";
    $stmt = $conn->prepare($sql);
    $stmt->bindValue(':email', $email);
    $stmt->execute();

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    //If $row is FALSE.
    if($user === false){
      
        die('No user in the database');

    } else {

        $dbHash = $user['password']; // hashed password from the database

            if (password_verify($passwordAttempt, $dbHash)){ 

                if ($user['is_approved'] == 1){

                    //Provide the user with a login session.
                    setcookie("user_id", $user['id'], time()+60*60*24 );
                    setcookie("user_email", $user['email'], time()+60*60*24 ); 
                    setcookie("logged_in", time(), time()+60*60*24 );

                    //Redirect to our protected page, which we called home.php
                    header('Location: index.php');
                    exit;

                }else{
                    echo 'Your account is not verified!';
                }

        } else {
            echo 'Password or email is incorrect!';
        }  
       
    }
}else{
    //No form data sent
    die('Incorrect username / password combination!3');
}
