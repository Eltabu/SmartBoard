<?php
    session_start();
    require_once  ("Includes/connectDB.php");
    


    function logged_on()
    {
        return isset($_SESSION['role']);
    }

    function get_role() {
        return $_SESSION['role'];
    }

    function get_id() {
        return $_SESSION['userid'];
    }

    function get_name() {
        return ucfirst($_SESSION['username']) ;
    }

    if(!logged_on())
    {
     header ("Location: index.php");
    }
?>