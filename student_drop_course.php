<?php
    require_once  ("Includes/connectDB.php");
    require_once ("Includes/session.php");    

    global $databaseConnection;

        $query = "Call drop_cprse_proc ( ?, ? );";
        $statement = $databaseConnection->prepare($query);
        $statement->bind_param('ds', $_SESSION['userid'] ,  $_POST['course_name']);

        $statement->execute();
         
        if ($statement->errno ) 
        {
          echo "Failure!!! ";
        }
        else
        {
            echo "Successfully " . $statement->affected_rows; 
        }
?>

