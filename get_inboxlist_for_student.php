<?php
    require_once  ("Includes/connectDB.php");
    require_once ("Includes/session.php");
  
    global $databaseConnection;

    $query = "Select subject from messages where course_id = ?;";
    $statement = $databaseConnection->prepare($query);
    $statement->bind_param('d', $_POST['course_id']);

    $statement->execute();
    $statement->store_result();
    $num_row = $statement->num_rows;
    $statement->bind_result($course_name);
 
    for ($i = 1; $i <= $num_row ; $i++)
    {   
       $statement->fetch();
       echo "<li onclick=\"get_message_content();\" > <span>  $course_name  </span></li>";
    } 

?>

