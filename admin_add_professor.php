<?php
    require_once  ("Includes/connectDB.php");
    require_once ("Includes/session.php");    

    global $databaseConnection;

        $depart_name = $_POST['depart_name'];
        $firstname = $_POST['firstname'];
        $lastname = $_POST['lastname'];
        $office_hour = $_POST['office_hour'];
        $office_days = $_POST['office_days'];
        $office_loc = $_POST['office_loc'];
        $pro_title = $_POST['pro_title'];


        $query = "Call admin_register_professor ( ?, ?, ? , ? , ? , ? , ? );";
        $statement = $databaseConnection->prepare($query);
        $statement->bind_param('sssssss', $firstname ,  $lastname, $office_hour , $office_days, $office_loc, $depart_name, $pro_title);

        $statement->execute();
         
        if ($statement->errno ) 
        {
          echo "Failure to Register!!! ";
        }
        else
        {
            echo "Professor Registred Successfully"; 
        }
?>