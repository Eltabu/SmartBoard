<?php
    require_once  ("Includes/connectDB.php");
    require_once ("Includes/session.php");
  
    global $databaseConnection;

    $depart_id = $_POST['depart_id'];
    $course_name = "";
    $query = "Select c.name From courses c JOIN departments d 
               ON c.department_id = d.department_id Where c.department_id = ?;";
    $statement = $databaseConnection->prepare($query);
    $statement->bind_param('d', $depart_id);

    $statement->execute();
    $statement->store_result();
    $num_row = $statement->num_rows;
    $statement->bind_result($course_name);
 
    for ($i = 1; $i <= $num_row ; $i++)
    {   
       $statement->fetch();
       echo "<li onclick=\"post_selected_course();\" > <span>  $course_name  </span></li>";
    } 

?>
