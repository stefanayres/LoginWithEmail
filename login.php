<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<!--=======Font Open Sans======-->
    <link href='https://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
	<!--StyleSheet-->
	<link rel="stylesheet" href="css/loginCss.css">
</head>
<body>
<div class="forms">
	<ul class="tab-group">
		<li id='test1' class="tab active"><a href="#login">Log In</a></li>
		<li id='test2' class="tab"><a href="#signup">Sign Up</a></li>
	</ul>
	<form action="loginCode.php" id="login" method="POST">
	      <h1>Login</h1>
	      <div class="input-field">
	        <label for="email">Email</label>
	        <input type="email" name="email" required="email"/>
	        <label for="password">Password</label> 
	        <input type="password" name="password" pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{6,}$" required/>
	        <input type="submit" name="submit" value="Login" class="button"/>
	        <p class="text-p"> <a href="#">Forgot password?</a> </p>
	      </div>
	  </form>
	  <form id="signup" name="signup" method="POST">
	      <h1>Sign Up</h1>
	      <div class="input-field">
            <label for="name">Name</label> 
	        <input type="name" name="name" required="name"/>
	        <label for="email">Email</label> 
	        <input type="email" id="email" name="email" required="email"/>
	        <label for="password">Password (6 characters minimum, at least one number, one lowercase and one uppercase letter)</label> 
	        <input type="password" name="password" id="password" pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{6,}$" required/>
	        <label for="password">Confirm Password</label> 
	        <input type="password" name="password" id="confirm_password" required/>
	        <input id="signUpBtn" type="submit" name="submit" value="Sign up" class="button" />
	      </div>
      </form>
</div>

<div class='popUp'>
    <span id="success">Thank's for submitting the form - An admin will get back to you shortly.</span>
    <span id="fail">Oop's something went wrong. Try again later.</span>
</div>


<script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
<script type="text/javascript">

$(document).ready(function(){

        $("#success").hide(); // hide success message 
        $("#fail").hide(); // hide fail message 
        
        // function for swapping tabs
        $('.tab a').on('click', function (e) {
            e.preventDefault();
            $(this).parent().addClass('active');
            $(this).parent().siblings().removeClass('active');
            
            var href = $(this).attr('href');
            $('.forms > form').hide();
            $(href).fadeIn(500);
        }); // end of tab click




// check if the email is in the database plus more 
    $('#email').blur(function(){ 
            var email = $(this).val();
            $.ajax({
                type: 'POST',
                url: 'checkEmail.php',
                data: 'email='+email,
                success: function(response){
                    let myJSON = JSON.stringify(response);
                    console.log(myJSON);
                    if(myJSON === '"email_avaliable"') {
                        $('#email').css('outline', 'none');
                        $('#email').css('box-shadow', '0 0 10px green');
                        $('#signUpBtn').attr("disabled", false);
                        $('#signUpBtn').css('background', '#73cf41');
                        
                    }else {
                        $('#email').css('outline', 'none');
                        $('#email').css('box-shadow', '0 0 10px red');
                        $('#signUpBtn').attr("disabled", true);
                        $('#signUpBtn').css('background', 'gray');
                    }
                },
            });
        }); // end of check email 
        
    // Pop up on success register
    $("#signup").submit(function (e) {
        e.preventDefault();
        $.ajax({
            type: "POST",
            url: "regCode.php",
            data: $("#signup").serialize(),
            success: function( response ) {
                console.log(response);
                 if (response == "success")  {
                     
                    $("#signup")[0].reset();
                    $( "#success" ).show( "fast").delay(8000).fadeOut('fast', function() {
                    $(this).remove();
                });
                } else {
                   
                    $( "#fail" ).show( "fast").delay(5000).fadeOut('fast', function() {
                    $(this).remove();
                });
                }
            }
        });
    }); // end of signup submit


});// end function


// check if passwords match
var password = document.getElementById("password")
  , confirm_password = document.getElementById("confirm_password");

function validatePassword(){
  if(password.value != confirm_password.value) {
    confirm_password.setCustomValidity("Passwords Don't Match");
  } else {
    confirm_password.setCustomValidity('');
  }
}

password.onchange = validatePassword;
confirm_password.onkeyup = validatePassword;

</script>
</body>
</html>