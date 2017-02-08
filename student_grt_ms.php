<?php
    require_once  ("Includes/connectDB.php");
    require_once ("Includes/session.php");
  
        global $databaseConnection;
        $ms_subject = $_POST['ms_subject'];
        $ms_content="";
        $query = "Select content From Messages Where subject = ? ;";
        $statement = $databaseConnection->prepare($query);
        $statement->bind_param('s',  $ms_subject);

        $statement->execute();
        $statement->store_result();
        $statement->bind_result($ms_content );
        $statement->fetch();
        echo $ms_content;
?>
