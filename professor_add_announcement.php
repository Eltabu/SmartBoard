<?php
    require_once  ("Includes/connectDB.php");
    require_once ("Includes/session.php");    

    global $databaseConnection;

        $annc_body = $_POST['content'];
        $course_id = $_POST['course_id'];
        $professor_id = $_SESSION['userid'];

        $query = "Call professor_add_annc (? , ? );";
        $statement = $databaseConnection->prepare($query);
        $statement->bind_param('ds', $course_id , $annc_body);

        $statement->execute();
         
        if ($statement->errno ) 
        {
          echo "Failure to Add!!! ";
        }
        else
        {
            echo "Announcements added Successfully"; 
        }
?>
