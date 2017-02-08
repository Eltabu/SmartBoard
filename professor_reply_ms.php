<?php
    require_once  ("Includes/connectDB.php");
    require_once ("Includes/session.php");    

    global $databaseConnection;

        $message_body = $_POST['message_body'];
        $message_id = $_POST['message_id'];
        $professor_id = $_SESSION['userid'];

        $query = "Call professor_send_replay (? , ?)";
        $statement = $databaseConnection->prepare($query);
        $statement->bind_param('ds', $message_id , $message_body);

        $statement->execute();
         
        if ($statement->errno ) 
        {
          echo "Failure to Sent!!! ";
        }
        else
        {
            echo "Reply Sent Successfully"; 
        }
?>