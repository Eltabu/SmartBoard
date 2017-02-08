<?php
    require_once  ("Includes/connectDB.php");
    require_once ("Includes/session.php");
  
        global $databaseConnection;
        $username = $_POST['username_name'];
        $new_password = $_POST['new_password'];
        $old_password = $_POST['old_password'];
       $query = "Update Professors Set username = ? , password = ? WHERE  professor_id = ? AND password = ?; ";
        $statement = $databaseConnection->prepare($query);
        $statement->bind_param('ssds',$username,  $new_password, $_SESSION['userid'], $old_password);

        $statement->execute();
         
        if ($statement->errno ) 
        {
          echo "Failure to Update!!! ";
        }
        elseif ($statement->affected_rows == 0 )
        {
           echo "Invalid Old Password Field";           
        }
        else
        {
            echo "Updated Successfully"; 
        }
?>
