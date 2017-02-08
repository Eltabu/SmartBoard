<?php 
 require_once ("Includes/session.php");
 

$num_row = NULL;
$role = (int) get_role();

 /* get the school of the user in case of stutudent   */
 function get_title()
 { 
     global $databaseConnection;
     $title = " ";
     $query = "";
     
     if( get_role() == 1 ){
        $query = "Select school From students WHERE student_id = ? LIMIT 1";
    }

    elseif( get_role() == 2){ // professor
        $query = "Select title From professors WHERE professor_id = ? LIMIT 1";
    }

    elseif( get_role() == 3){ // admin
        $query = "Select title From admins WHERE admin_id = ? LIMIT 1";
    }

    $statement = $databaseConnection->prepare($query);
    $statement->bind_param('d',  $_SESSION['userid']);

    $statement->execute();
    $statement->store_result();

    if ($statement->num_rows == 1)
    {
       $statement->bind_result($title);
       $statement->fetch();        
    }
     return ucfirst($title);
 }
 
/* generate the content of a nav list items   */
function get_list(){
    global $databaseConnection;

    if(get_role() == 1) /*********** Student ***************/
    {
        $query = "Select courses.code From courses JOIN registered ON Courses.course_id = registered.course_id
                    JOIN Students ON students.student_id = registered.student_id Where Students.student_id = ?";
        $statement = $databaseConnection->prepare($query);
        $statement->bind_param('d',  $_SESSION['userid']);

        $statement->execute();
        $statement->store_result();
        $num_row = $statement->num_rows;
        $statement->bind_result($row);

        for ($i = 1; $i <= $num_row ; $i++)
        {
            $statement->fetch();
            echo "<li><a href=\"#course_$i\"><span >$row </span></a></li>";
        }
		echo "<li><a href=\"#milbox\"><span >Milbox</span></a></li>";
        echo "<li><a href=\"#setting\"><span >Setting</span></a></li>";
		echo "<li class=\"last\"><a href=\"#registration\"><span>Registration</span></a></li>";                     
    } 
    elseif(get_role() == 2)  /*********** Professor ***************/
    {
		echo "<li><a href=\"#milbox\"><span >Milbox</span></a></li>";
        echo "<li><a href=\"#add_announcements\"><span >Add Announcements</span></a></li>";
        echo "<li><a href=\"#add_activities\"><span >Add Activities</span></a></li>";
        echo "<li><a href=\"#registration\"><span>Registration</span></a></li>";   
        echo "<li class=\"last\" ><a href=\"#setting\"><span >Setting</span></a></li>";
		     
    }
    elseif(get_role() == 3)  /*********** Admin ***************/
    {
        echo "<li ><a href=\"#add_news\"><span >Add News</span></a></li>";
        echo "<li><a href=\"#add_student\"><span >Add Student</span></a></li>";
        echo "<li><a href=\"#add_course\"><span>Add Course</span></a></li>"; 
        echo "<li class=\"last\"  ><a href=\"#add_professor\"><span>Add Professor</span></a></li>";
               
    }
      
}
?>
