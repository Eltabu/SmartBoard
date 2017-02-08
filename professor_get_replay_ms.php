<?php
    require_once  ("Includes/connectDB.php");
    require_once ("Includes/session.php");
  
        global $databaseConnection;
        $ms_id = $_POST['ms_id'];
        $ms_content="";
        $ms_replay = NULL;

        $query = "Select reply_ms, reply  From Messages Where message_id = ? ;";
        $statement = $databaseConnection->prepare($query);
        $statement->bind_param('d', $ms_id);

        $statement->execute();
        $statement->store_result();
        $statement->bind_result($ms_content, $ms_replay );
        $statement->fetch();

        if ($ms_replay)
        {
            echo $ms_content;
        }
        else
        { 
            echo "No Reply Yet ........";
        }
?>
