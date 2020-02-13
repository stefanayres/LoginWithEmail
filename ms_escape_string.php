<?php
// this fuction was made to clean the string before being uploaded to the database. 
function ms_escape_string($data){
    if (!isset($data) or empty($data)){ 
        return '';
    }
    if (is_numeric($data)){
        return $data;
    }
    $non_displayables = array(
        '/%0[0-8bcef]/',
        '/%1[0-9a-f]/',
        '/[\x00-\x08]/',
        '/\x0b/',
        '/\x0c/',
        '/[\x0e-\x1f]/',
    );
    foreach ($non_displayables as $regex){
        $data = preg_replace ($regex, '', $data); // does regex check on the string 
    $data = str_replace("'", '"',$data); // swaps the single quote with double quote. this is becuase MS SQL Server will not insert data with a single quote mark.  
    }
    $data = htmlspecialchars($data);
	
	return $data;
}