 <head>
            <meta charset="UTF-8">
            <title>Inbound Call</title>
            <meta name="viewport" content="initial-scale=1.0; maximum-scale=1.0; width=device-width;">
    
			 <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <style>
	.Stable {
		  border-right: 2px #ddd solid;
		  padding-right: .2px;
	  }
  </style>
</head>
<header>
	<img src="include/img/Company.jpg" alt="Logo" style="height: auto; width: 15%; margin: 5px 0px 5px 15px"/>	
</header>
 
<?php 
session_start();
include('include/db.class.php');
$db = new db();
$conn = $db->connect();
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
include ("./ms_escape_string.php");

if(isset($_COOKIE['logged_in']) && !empty($_COOKIE['logged_in'])){

	if (isset( $_POST["submit"])){

		//echo $orgNum	= $_POST['Number1'];
		
		try {
			
			if(!empty($_POST["search"])){ 
				$query = $_POST["search"];
				$query = ms_escape_string($query);
				
				// prepared statement to insert user data
				$sql = "SELECT * FROM DriverData WHERE public_id LIKE :q ORDER BY id DESC";
				$stmt = $conn->prepare($sql); 
				$stmt->bindValue(':q', '%' .$query. '%', PDO::PARAM_STR);
				$stmt->execute();
				$total = $stmt->rowCount();

			if($total != Null){
			echo "<div class='container'>";
				
		while ($row = $stmt->fetchObject()) {

				$id = $row->id;
			
			echo "<div class='table-responsive'>";
			echo "<table class='table'>";
			echo "<thead>
					<tr>
						<th class='Stable'>Driver Name</th>
						<th class='Stable'>Phone No.</th>
						<th class='Stable'>Driver Public Id</th>
						<th class='Stable'>E-Mail</th>
						<th class='Stable'>Address</th>
						<th class='Stable'>Status</th>
						</tr>
					</thead>";
					echo "<tbody>";
					echo "<tr>";
					echo "<td class='Stable'><a href='index.php?ID=". (int)$id."'>". $row->Firstname ." ". $row->Lastname . " </a></td>";
					echo "<td class='Stable'><a href=tel:". floor($row->Phone_Number) . "'>". floor($row->Phone_Number) . " </a></td>";
					echo "<td class='Stable'>". $row->public_id . " </td>";
					echo "<td class='Stable'><a href=mailto:". $row->email . "'>". $row->email . "</a></td>";
					echo "<td class='Stable'>". $row->address . " </td>";
					echo "<td>". $row->Status . " </td>";
					echo "</tr>
						<br/>
					</tbody>
					</table>
					</div>
					";
				}

			echo" 
			<button type='button' class='btn btn-info btn-lg' onclick='history.go(-1);'>Back</button>
			</div>";
			}else{	

			echo "<p> No matches found. </p>";
			echo" 
				<button type='button' class='btn btn-info btn-lg' onclick='history.go(-1);'>Back</button>
				</div>";
			}
			
		}else{
			echo '<h1>Noting entered </h1>';
			echo" 
				<button type='button' class='btn btn-info btn-lg' onclick='history.go(-1);'>Back</button>
				</div>";
			}
		}
			//Exception handling
			catch(PDOException $e)
		{
				$urlError =  $e->getMessage();
		}

	}else {
		echo 'failed isset: No data was found! ';	
	}
	   

}else{
	header('Location: login.php');
}
