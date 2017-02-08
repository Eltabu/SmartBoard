<?php
    require_once  ("Includes/connectDB.php");
    require_once ("Includes/session.php");    

    global $databaseConnection;

        $acti_body = $_POST['content'];
        $course_id = $_POST['course_id'];
        $duedate = $_POST['duedate'];

        $query = "Call professor_add_activ ( ? , ? , ? )";
        $statement = $databaseConnection->prepare($query);
        $statement->bind_param('dss', $course_id , $acti_body, $duedate);

        $statement->execute();
         
        if ($statement->errno ) 
        {
          echo "Failure to Add!!! ";
        }
        else
        {
            echo "Activities added Successfully"; 
        }
?>