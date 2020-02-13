<?php
// ini_set('display_errors', 1); //php errors
include('include/db.class.php');
$mydb = new db();
$conn = $mydb->connect(); 
session_start();

if(isset($_COOKIE['logged_in']) && !empty($_COOKIE['logged_in'])){

    if (isset($_GET['submit'])) {

        $OrgNum     = $_GET['Number'];
        $results = substr($OrgNum, 0, 4);

        if (strpos($results, '08') !== false){
            $Num1       = substr($OrgNum,1);
            $Num2       = "353{$Num1}";

        }else if (strpos($results, '0044') !== false){
            $Num1       = substr($OrgNum,2);
            $Num2       = $Num1;
        }else if (strpos($results, '44') !== false){
            $Num2       = $OrgNum;
        }else{
        }


        $query = $conn->prepare("SELECT Phone_Number FROM DriverData WHERE Phone_Number = :phone");
        $query->execute(array(':phone' => $Num2));
        $result = $query->fetch();

        if ($result > 0) {
            $sql = ("
                SELECT *
                FROM DriverData  
                    where Phone_Number = :number
        ");

            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':number', $Num2, PDO::PARAM_STR);
            $stmt->execute();
            $total = $stmt->rowCount();

                while ($row = $stmt->fetchObject()) {
                    $id = $row->id; // float
                }
        }else{
            $id = NULL;
        }
        
    }else if (isset($_GET['ID'])) {
        
        $id = $_GET['ID'];
        $id = (int)$id;

    }else {
        $id = NULL;
    }


    if ($id != NULL) {
        $sql = ("
            SELECT *
            FROM DriverData  
                where id = :id
    ");

        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $total = $stmt->rowCount();

            while ($row = $stmt->fetchObject()) {

                $id         = $row->id; // float
                $PhoneOrg   = $row->Phone_Number; 
                $email      = $row->email;
                $Lname      = $row->Lastname;
                $Fname      = $row->Firstname;
                $Office     = $row->office;
                $publicId   = $row->public_id;
                $date       = $row->dob; // Y/m/d H:i:s -- string 
                $address    = $row->address;
                $status     = $row->Status;
                $photo      = $row->Photo;
                $newDOB     = $row->Date_of_Birth;

                $Phone = floor($PhoneOrg);
                $Phone = (string)$Phone;
                $result = substr($Phone, 0, 4);

                if (strpos($result, '353') !== false){
                    $areaCode   = '353';
                    $Phone      = substr($Phone, 3);
                    $Phone      = $Phone;
                }else if (strpos($result, '44') !== false){
                    $areaCode   = '0044';
                    $Phone      = substr($Phone, 2);
                    $Phone      = $Phone;
                }else{
                
                }
                
                if ($date != NULL){
                    $date   = str_replace('/', '-', $date);
                    $DOB    = date('Y-m-d', strtotime($date));
                }else{
                    echo $DOB    = $newDOB;
                }
            }	
        

        }else{
                $placeH = ' - Please Enter New Drivers Details.' ;
                $placeHiD = ' - Please Enter a 8 digit ID number.';
                $id;
                $Phone; 
                $email;
                $Lname;
                $Fname ;
                $Office;
                $publicId;
                $date; 
                $address;
                $status;
                $photo;
        }

        ?>

        <html>
            <head>
                <meta charset="UTF-8">
                <link rel="icon" href="include/img/Company.jpg"/>
                <title>IT Inbound Call</title>
                <meta name="viewport" content="initial-scale=1.0; maximum-scale=1.0; width=device-width;">
                
                <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
                <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
                <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
                <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
                <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
                <link href="CSS/main.css" rel="stylesheet" type="text/css"/>
                <script>
                    setTimeout(function(){ 
                    $('#myData').hide();
                }, 5000);
                </script>
                
            </head>
            
            <header>
            <div class="topnav">
                <img src="include/img/Company.jpg" alt="logo" style="height: auto; width: 15%; margin: 5px 0px 5px 15px"/>	
                    <div class="search-container">
                        <form action="search_page.php" method="POST">
                            <input type="text" placeholder="Search...." name="search" required>
                            
                            <button type="submitSearch" id="submitSearch" name="submit"><i class="fa fa-search"></i></button>
                        </form>
                    </div> 
            </header>

            <body>
            
                <div class="table-title">
                    <h3 class="formTitle">MyTaxi Drivers</h3>
                </div>
                
                <table class="table-fill" style='margin-bottom: 2rem;'>
                    <thead>
                        <tr>
                            <th class="text-left">Driver Details <?php echo $placeH; ?></th>
                            <form action="editrep.php?Number=<?php echo $OrgNum; ?>" id="form" method="POST" name="form">
                        </tr>
                    </thead>
                
                    <tbody class="table-hover">
                        
                                <tr>
                                    <td><p>Driver ID: <?php echo $placeHiD; ?></p>
                                    
                                        <input name="DriverID" id="searchID" class="form-control" placeholder="Driver ID" type="number" value="<?php if ($id>0){echo (int)$id;} ?>" required autocomplete="off" >
                                        <div id="show_up"></div>
                                    </div>
                                    </td>
                                </tr>   
                                    <td><p>Driver First Name:</p>
                                        <input id="DriverName" name="DriverNameF" class="form-control" placeholder="Driver Name" type="text" value="<?php echo $Fname; ?>" required autocomplete="off">
                                        <p>Driver Last Name:</p>
                                        <input id="DriverName" name="DriverNameL" class="form-control" placeholder="Driver Name" type="text" value="<?php echo $Lname; ?>" required autocomplete="off">
                                    </td>
                                <tr>
                                    <td><p>Driver Phone No.</p>
                                        <div class='form-inline'>
                                            <select name="areaCode" class="form-control" required>
                                                <option value="">Please Select AreaCode</option>
                                                <option value="353" <?php if($areaCode=="353") echo 'selected="selected"'; ?> >353</option>
                                                <option value="0044" <?php if($areaCode=="0044") echo 'selected="selected"'; ?> >0044</option>
                                            </select>
                                            
                                            <input id="DriverNo" name="DriverNo"  class="form-control" placeholder="Driver Phone Number" type="text" pattern="\d*" value="<?php echo $Phone; ?>" maxlength="10" required>
                                        </div>    
                                    </td>
                                </tr>
                                <tr>
                                    <td><p>Driver E-mail:</p>
                                    <input id="DriverEmail" name="DriverEmail" class="form-control" placeholder="Driver E-mail" type="email" value="<?php echo $email; ?>" required autocomplete="off">
                                    </td>
                                </tr>
                                <tr>
                                    <td><p>Driver Zone:</p>
                                        <input id="Office" name="Office" class="form-control" placeholder="Office " type="text" value="<?php echo $Office; ?>" required>
                                    </td>
                                </tr> 
                                <tr> 
                                    <td><p>Driver Address:</p>
                                        <input id="DriverAddress" type="text" class="form-control" name="DriverAddress" placeholder="Driver Address" value="<?php echo $address; ?>" autocomplete="off">
                                    </td>
                                </tr>
                                <tr>
                                    <td><p>Public ID:</p>
                                        <input id="PublicID" type="text" class="form-control" name="PublicID" placeholder="Driver PublicID" value="<?php echo $publicId; ?>" required autocomplete="off">
                                    </td>
                                </tr>
                                <tr>
                                    <td><p>DOB:</p>
                                        <input id="DOB" type="date" class="form-control" name="DOB" placeholder="DOB" value="<?php echo $DOB; ?>" required>
                                    </td>
                                </tr>
                                <tr>
                                    <td><p>Status:</p>
                                        <select name="Status" class="form-control" required>
                                            <option value="">Please Select Option</option>
                                            <option value="ACTIVE" <?php if($status=="ACTIVE") echo 'selected="selected"'; ?> >ACTIVE</option>
                                            <option value="ABUSE" <?php if($status=="ABUSE") echo 'selected="selected"'; ?> >ABUSE</option>
                                            <option value="DELETED" <?php if($status=="DELETED") echo 'selected="selected"'; ?> >DELETED</option>
                                            <option value="ACTIVE" <?php if($status=="CONTACT_NOT_ACCEPTED") echo 'selected="selected"'; ?> >CONTACT NOT ACCEPTED</option>
                                            <option value="ACTIVE" <?php if($status=="INACTIVE") echo 'selected="selected"'; ?> >INACTIVE</option>
                                        </select>

                                    </td>
                                </tr>
                                <tr>
                                    <td><p>Driver Photo:</p></br>
                                        <img style='height: 200px;' src="<?php echo $photo; ?>" alt="">
                                    </td>
                                </tr>       
                                <tr> 
                                    <td> <button class="btn btn-success" type="submit" name="update_button" value="update_button">Update User</button></td>
                                </tr>
                                <tr>
                                    <td> <button class="btn btn-success" type="submit" name="insert_button" value="insert_button">Insert New User</button>
                                    <button type="button" class="btn btn-danger" id="logout" >Log Out</button>
                                </td>
                                </tr>
                            </form>
                    </tbody>
                </table>

        </body>
        <script type="text/javascript">
        
        $(document).ready(function(e){

            $("#searchID").keyup(function(){ // live search by ID 
                $("#show_up").show();
                let text = $(this).val();
                $.ajax({
                    type: 'GET',
                    url: 'ID-search.php',
                    data: 'txt=' + text,
                    success: function(data){
                        $("#show_up").html(data);
                    }
                });
            })
        });

        $("#logout").click(function(){ // logout script call

                $.ajax({
                    type: 'POST',
                    url: 'logout.php',
                    success: function(){
                        location.reload();
                }
            });
        });

        </script>
    </html>

<?php
    }else{
        header('Location: login.php');
    }
 ?>
