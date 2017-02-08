<?php
    require_once  ("Includes/connectDB.php");
    require_once ("Includes/session.php");    

    global $databaseConnection;

        $depart_name = $_POST['depart_name'];
        $code = $_POST['code'];
        $name = $_POST['name'];
        $section = $_POST['section'];
        $level = $_POST['level'];
        $start_date = $_POST['start_date'];
        $end_date = $_POST['end_date'];
        $final_examdate = $_POST['final_examdate'];
        $final_location = $_POST['final_location'];
        $meeting_days = $_POST['meeting_days'];
        $meeting_time = $_POST['meeting_time'];
        $intro = $_POST['intro'];


        $query = "Call admin_add_course ( ? , ? , ? , ? , ? , ? ,  ? ,? , ? , ? , ? , ? )";
        $statement = $databaseConnection->prepare($query);
        $statement->bind_param('ssddssssssss', $code, $name, $section, $level, $end_date, $end_date, $final_examdate,  $final_location,  $meeting_days, $meeting_time, $depart_name, $intro );

        $statement->execute();
         
        if ($statement->errno ) 
        {
          echo "Failure to Add Course!!! ";
        }
        else
        {
            echo "Course Addes Successfully"; 
        }
?>