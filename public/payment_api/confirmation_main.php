<?php
    // including db connection handler
    include("con_db.php");

    //getting response
    $postData = file_get_contents('php://input');
    file_put_contents('confiramtiondata.php', $postData. ";\n\n", FILE_APPEND);

    $postString  = json_decode($postData,true);
    $record = array();

    //preparing records for insertion
    foreach ($postString  as $key => $value) {
        $record[$key] = $value;
    }

    if (!empty($record)) {            
        // $record["CreatedBy"] = "admin";
        $table  = "mpesaconfirmation";
        $action = "INSERT";
        //using pdo to insert record
        $db->AutoExecute($table,$record,$action);
    }


    

   
?>