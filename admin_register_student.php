<?php
    require_once  ("Includes/connectDB.php");
    require_once ("Includes/session.php");    

    global $databaseConnection;

        $depart_name = $_POST['depart_name'];
        $firstname = $_POST['firstname'];
        $lastname = $_POST['lastname'];
        $semester = $_POST['semester'];
        $level = $_POST['level'];
        $school = $_POST['school'];
        $program = $_POST['program'];

        $query = "Call admin_register_student ( ?, ?, ? , ? , ? , ? ,  ? )";
        $statement = $databaseConnection->prepare($query);
        $statement->bind_param('ssdsssd', $firstname ,  $lastname, $semester, $school, $program, $depart_name, $level);

        $statement->execute();
         
        if ($statement->errno ) 
        {
          echo "Failure to Register!!! ";
        }
        else
        {
            echo "Student Registred Successfully"; 
        }

?>
