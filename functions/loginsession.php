<?php
session_start();
require_once ("Includes/connectDB.php");

/************* check if the user is a student ***************/
function is_student(){
if (isset($_POST['submit']))
  {
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    $query = "SELECT student_id, firstname FROM students WHERE username = ? AND password = ? LIMIT 1";
    $statement = $databaseConnection->prepare($query);
    $statement->bind_param('ss', $username, $password);

    $statement->execute();
    $statement->store_result();
    
    if ($statement->num_rows == 1)
    {
       $_SESSION['role'] = '1';
       $statement->bind_result($_SESSION['userid'], $_SESSION['username']);
       $statement->fetch();
       return TRUE;
     }
     else{
       return FALSE;
     } 
 }
 else{
    return FALSE;
 }
}// end function

/************* check if the user is a professor ***************/
function is_professor(){
if (isset($_POST['submit']))
  {
    $query = "select professor_id, CONCAT_WS(' ',firstname,lastname) AS name FROM professors WHERE username = ? AND password = (?) LIMIT 1";
    $statement = $databaseConnection->prepare($query);
    $statement->bind_param('ss', $username, $password);

    $statement->execute();
    $statement->store_result();

    if ($statement->num_rows == 1)
    {
      $_SESSION['role'] = 2;
      $statement->bind_result($_SESSION['userid'], $_SESSION['username']);
      $statement->fetch();
      return TRUE;
     }
     else{
      return FALSE;
     } 
  }
  else{
    return FALSE;
  }
}// end function

/************* check if the user is an admin ***************/
function is_admin(){

if (isset($_POST['submit']))
{
    $username = $_POST['username'];
    $password = $_POST['password'];

    $query = "select admin_id, CONCAT_WS(' ',firstname,lastname) AS name FROM admins WHERE username = ? AND password = (?) LIMIT 1";
    $statement = $databaseConnection->prepare($query);
    $statement->bind_param('ss', $username, $password);

    $statement->execute();
    $statement->store_result();

    if ($statement->num_rows == 1)
    {
       $_SESSION['role'] = 3;
       $statement->bind_result($_SESSION['userid'], $_SESSION['username']);
       $statement->fetch();
       return TRUE;
     }
     else{
         return FALSE;
     } 
}// end if
else{
    return FALSE;
}
}// end function
?>
