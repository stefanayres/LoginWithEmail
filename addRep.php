<html>
        <head>
            <meta charset="UTF-8">
            <link rel="icon" href="include/img/logo_blog.png"/>
            <title>IT Inbound Call</title>
            <meta name="viewport" content="initial-scale=1.0; maximum-scale=1.0; width=device-width;">
            
			<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
			<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
			<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
			<link href="CSS/main.css" rel="stylesheet" type="text/css"/>
			<script>
				setTimeout(function(){ 
				$('#myData').hide();
			}, 5000);
			</script>
			
        </head>
        <header>
            <img src="include/img/Image.jpg" alt="Logo" style="height: auto; width: 15%; margin: 5px 0px 5px 15px"/>
        </header>

        <body>
		<?php 
		if (isset($_REQUEST['Number'])) {
		$Number = $_REQUEST['Number'];}
			?>
         <div class="container">
          <form class="form-horizontal" action="addRepCode.php" id="form" method="post" name="form">
				
				<h2>Add Reps. Details</h2>
				<hr>
				
				<p>Name:</p><input id="repName" name="repName" class="form-control" placeholder="Name" type="text" value="" required></br>
				
				<p>RSM:</p><input id="RSMname" name="RSMname" class="form-control" placeholder="RSM Name" type="text" value="" ></br>
				
				<p>E-mail:</p><input id="Email" name="Email" class="form-control" placeholder="E-mail" type="text" value="" required></br>
				
				<p>Campaign:</p><input id="Campaign" type="text" class="form-control" name="Campaign" placeholder="Campaign" value=""></br>
				
				<input type="hidden" name="Phone" value="<?php echo $Number;?>" />
				
				<button type="submit" name="submit" value="submit">Submit</button>
				</form>
          
			</div>
				
		<?php   ?>
    </body>
</html>

