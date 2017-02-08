<?php
    require_once  ("Includes/connectDB.php");
    require_once ("Includes/session.php");    

    global $databaseConnection;

        $course_id = $_POST['course_id'];
        $professor_id = $_SESSION['userid'];

        $query = "Call professor_register_for_course ( ? , ? );";
        $statement = $databaseConnection->prepare($query);
        $statement->bind_param('dd', $course_id , $professor_id);

        $statement->execute();
         
        if ($statement->errno ) 
        {
          echo "Failure to Register!!! ";
        }
        else
        {
            echo "Registered Successfully"; 
        }
?>
