<?php
    require_once ("/Includes/smartboard_config.php");

    // Create database connection
    $databaseConnection = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
    if ($databaseConnection->connect_error)
    {
        //change die to load a error page
        die("Database selection failed: " . $databaseConnection->connect_error);
    }

?>