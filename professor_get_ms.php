<?php
    require_once  ("Includes/connectDB.php");
    require_once ("Includes/session.php");
  
        global $databaseConnection;
        $ms_id = $_POST['ms_id'];
        $query = "Select content From Messages Where message_id = ? ;";
        $statement = $databaseConnection->prepare($query);
        $statement->bind_param('d',  $ms_id);

        $statement->execute();
        $statement->store_result();
        $statement->bind_result($ms_content );
        $statement->fetch();
        echo $ms_content;
?>

