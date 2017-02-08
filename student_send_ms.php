<?php
    require_once  ("Includes/connectDB.php");
    require_once ("Includes/session.php");    

    global $databaseConnection;

        $message_body = $_POST['message_body'];
        $message_subject = $_POST['message_subject'];
        $ms_from = $_SESSION['userid'];
        $ms_go = $_POST['mesage_to'];
        $course_id = $_POST['course_id'];

        $query = "CALL send_message ( ? , ? , ? , ? , ?)";
        $statement = $databaseConnection->prepare($query);
        $statement->bind_param('sssdd', $message_body,  $message_subject, $ms_go , $ms_from, $course_id);

        $statement->execute();
         
        if ($statement->errno ) 
        {
          echo "Failure to Sent!!! ";
        }
        else
        {
            echo "Message Sent Successfully"; 
        }


?>
