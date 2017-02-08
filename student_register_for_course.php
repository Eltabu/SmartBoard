<?php
    require_once  ("Includes/connectDB.php");
    require_once ("Includes/session.php");    

    global $databaseConnection;

        $course_name = $_POST['course_name'];
        $st_id = $_SESSION['userid'];


        $query = "Call add_cprse_proc (?, ?);";
        $statement = $databaseConnection->prepare($query);
        $statement->bind_param('ds', $st_id,  $course_name);

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

