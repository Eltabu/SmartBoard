<?php
    require_once  ("Includes/connectDB.php");
    require_once ("Includes/session.php");    

    global $databaseConnection;



    //Call admin_add_news (  'Upgrading mySuccess',  'The Student',  1002,        'Faculty Science'       )

        $depart_name = $_POST['depart_name'];
        $title = $_POST['title'];
        $content = $_POST['content'];

        $query = "Call admin_add_news( ?, ? , ? , ? )";
        $statement = $databaseConnection->prepare($query);
        $statement->bind_param('ssds', $title ,  $content , $_SESSION['userid'] , $depart_name);

        $statement->execute();
         
        if ($statement->errno ) 
        {
          echo "Failure to Sent!!! ";
        }
        else
        {
            echo "News Sent Successfully"; 
        }
?>

