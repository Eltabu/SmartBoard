<?php


switch($_SESSION['role'])
{
    case 1:
         get_student_news();
         get_student_courses();
         get_student_setting();
         get_student_mailbox();
         get_student_registration();
    break;
    
    case 2:
        get_professor_news();
        get_professor_mailbox();
        get_add_announcements();
        get_add_activities();
        professor_register_course();
        professor_setting();
    break;
    
    case 3:
        get_admin_news();
        get_admin_addnews();
        get_add_student();
        get_add_course();
        get_admin_addprofessor();
    break; 
}


/******************************** Professor Main Functions *****************************************/

function get_professor_news()
{
    global $databaseConnection;
    $title = "";
    $content ="";
    $ndate="";
    $query = "Select n.title , n.content , n.date
                From News n  JOIN Departments d On 
                n.department_id = d.department_id 
                JOIN Professors s On s.department_id  = d.department_id
                AND n.department_id IN (Select department_id From Professors Where professor_id = ? ) 
                OR n.department_id = 1
                Where s.professor_id = ?
                ORDER BY n.date DESC LIMIT 15;";
    $statement = $databaseConnection->prepare($query);
    $statement->bind_param('dd',  $_SESSION['userid'], $_SESSION['userid']);

    $statement->execute();
    $statement->store_result();
    $num_row = $statement->num_rows;
    $statement->bind_result($title, $content, $ndate );

    echo "<section id=\"news\" class=\"one\">";
    echo "<div class=\"container\">";
    echo " <header>   <img id=\"new_image\" src=\"images/news-logo.png\" alt=\"News\" />  </header>";
    
    for ($i = 1; $i <= $num_row ; $i++)
    {
       $statement->fetch();
       echo "<div class=\"artical\">";
       echo "<p><span class=\"post-title\"> $title </span>";
       echo $content;
       echo "</p>";
       echo "<p class=\"date\">$ndate</p>";
       echo "</div>";
    }
    echo "</div> </section>";
    
}

function get_professor_mailbox()
{
    echo "<section id=\"milbox\" class=\"seven\">";
    echo "<div class=\"container\">"; 
    echo "<img src=\"images/mailbox.png\" alt=\"Mail Box\" />";
    echo "<select id=\"prof_courses_mailbox\" onchange=\"get_prof_ms();\" >";
    echo "<option value=\"-1\">Select Course </option>";
    get_professor_courses();
    echo "</select>";
    echo "<div id=\"subjectlist\">";
    echo "<ul id=\"ulsubject\" class=\"list\"> ";  
    echo "</ul> </div>";
    echo "<div id=\"messagebody\">";
    echo "<h3> Sent: </h3><p id=\"messagebody_p\"></p> </div>";
    echo "<div id=\"messagereplay\">";
    echo "<h3> Reply: </h3><p id=\"messagebody_pr\"></p> </div>";
    echo " <hr id=\"hr_mailbox\" />";
    echo "<div id=\"sendingmessage\">";
    echo "<p><h3> Selected Message:</h3> <p id=\"prof_selected_ms\" name=\"\"></p></p>";
    echo "<p id=\"prof_mailbox_selectedcourse\"><P>";
    echo "<textarea id=\"replay_message_body\" placeholder=\"Reply\"></textarea>";
    echo "<input type=\"button\" value=\"Send Reply\" name=\"sendbottom\" onclick=\"prof_replay_message();\" />";
    echo "<br/><br/> <lable id=\"error_massegae_mailbox\" required></lable>";
    echo "</div> </div>	</section>";
}

/************<!-- Add Announcements -->**********************/
function get_add_announcements()
{
    echo "<section id=\"add_announcements\" class=\"ten\">";
    echo "<div class=\"container\">";
    echo "<header>	<h2>Add Announcements:</h2>		</header>";
    echo "<select id=\"prof_add_ann\">";
    echo "<option value=\"-1\">Select Course </option>";
    get_professor_courses();
    echo "</select>";
    //echo "<div id=\"message_content\">";
    //echo "<p id=\"message_content_annc\"></p>";
    //echo "</div>";
    echo "<textarea id=\"add_announcements_texterea\" placeholder=\"Announcements\"></textarea>";
    echo "<input type=\"button\" value=\"Add Announcement\" onclick=\"add_announcements();\" />";
    echo "<p id=\"error_message_ancc\" ></p>";
    echo "</div>	</section>";
}

/********************** <!-- Add Activities --> ****************************/
function get_add_activities()
{
    echo "<section id=\"add_activities\" class=\"eleven\">";
    echo "<div class=\"container\">";
    echo "<header>	<h2>Add Activities:</h2>		</header>";
    echo "<select id=\"prof_add_act\">";
    echo "<option value=\"-1\">Select Course </option>";
    get_professor_courses();
    echo "</select>";
    //echo "<div id=\"message_content\">";
    //echo "<p id=\"message_content_act\"></p>";
    //echo "</div>";
    echo "<textarea id=\"add_activities_texterea\" placeholder=\"Activities\"></textarea>";
    echo "<label for=\"activity_duedate\"><b>Due date: </b></label>";
    echo "<input type=\"date\" id=\"activity_duedate\" min=\"2015-01-08\"><br/>";
    echo " <input type=\"button\" value=\"Add Activity\" onclick=\"add_activities();\" />";
    echo " <p id=\"error_message_acti\"></p>";
    echo "</div>	</section>";
}

/************************  Get Professor Courses ***************************/
function get_professor_courses()
{
   global $databaseConnection;

    $query = "Select name, course_id From courses Where  professor_id = ?;";
    $statement = $databaseConnection->prepare($query);
    $statement->bind_param('d', $_SESSION['userid']);

    $statement->execute();
    $statement->store_result();
    $num_row = $statement->num_rows;
    $statement->bind_result($course_name, $course_id);


    for ($i = 1; $i <= $num_row ; $i++)
    {   
       $statement->fetch();
       echo "<option value=\"$course_id\"> $course_name </option>";
    } 

}

/************************  Get Professor Department ***************************/
function get_professor_depart() 
{
   global $databaseConnection;

    $query = "Select name, course_id From courses Where department_id IN ( Select department_id From 
                professors Where  professor_id = ?) AND professor_id IS NULL;";
    $statement = $databaseConnection->prepare($query);
    $statement->bind_param('d', $_SESSION['userid']);

    $statement->execute();
    $statement->store_result();
    $num_row = $statement->num_rows;
    $statement->bind_result($course_name, $course_id);


    for ($i = 1; $i <= $num_row ; $i++)
    {   
       $statement->fetch();
        echo "<li onclick=\"prof_reg_course();\" id=\"$course_id\">  $course_name </li>";
    } 

}

/************************<-------- Register and Drop For A course ---------->*********************/
function professor_register_course()
{
    echo "<section id=\"registration\" class=\"twelve\">";
    echo "<div class=\"container\">";
    echo "<header>	<h2>Registration:</h2>		</header>";
    echo "<ul class=\"courselist\" id=\"courselist_depart\">";
    get_professor_depart();
    echo "</ul>";
    echo "<h3>Selected Course: </h3><p name=\"\" id=\"proff_course_reg\"></p>";
    echo "<input type=\"button\" value=\"Register\" onclick=\"prof_register_course();\"  />";
    echo "<hr />";
    echo "<header>";
    echo "<hr /> <h2>Drop:</h2> </header>";
    echo "<select id=\"prof_drope_course\">";
    echo "<option value=\"-1\">Select Course </option>";
    get_professor_courses();
    echo "</select>";
    echo "<input type=\"button\" value=\"Drop\" onclick=\"prof_drop_course();\"/>";
    echo "<p name=\"\" id=\"depart_drop_course\"></p>";
    echo "</div>	</section>";
}

/************************<-------- Setting ---------->*********************/
function professor_setting()
{
    echo "<section id=\"setting\" class=\"eight\">";
    echo "<div class=\"container\">";
    echo "<header> <h2>Setting:</h2> </header>";
    echo "<input type=\"text\" id=\"username_name\" placeholder=\"User Name\" />";
	echo "<input type=\"password\" id=\"old_password\" placeholder=\"Old Password\" />";
    echo "<input type=\"password\" id=\"new_password\" placeholder=\"New Password\" />"; 
    echo "<input type=\"password\" id=\"re_new_password\" placeholder=\"Retype New Password\" />";
	echo "<input type=\"submit\" id=\"name_submit\" value=\"Update Info\" onclick=\"change_professor_setting();\" />";
    echo "<br/><br/> <lable id=\"error_massegae_setting\" required></lable>";
    echo "</div></section>"; 				 
}







/******************************** Admin Main Functions *****************************************/

function get_admin_news()
{
    global $databaseConnection;
    $title = "";
    $content ="";
    $ndate="";
    $query = "Select n.title , n.content , n.date
                From News n  
                Where n.admin_id = ? OR department_id = 1 
                ORDER BY n.date DESC LIMIT 15;";
    $statement = $databaseConnection->prepare($query);
    $statement->bind_param('d',  $_SESSION['userid']);

    $statement->execute();
    $statement->store_result();
    $num_row = $statement->num_rows;
    $statement->bind_result($title, $content, $ndate );

    echo "<section id=\"news\" class=\"one\">";
    echo "<div class=\"container\">";
    echo " <header>   <img id=\"new_image\" src=\"images/news-logo.png\" alt=\"News\" />  </header>";
    
    for ($i = 1; $i <= $num_row ; $i++)
    {
       $statement->fetch();
       echo "<div class=\"artical\">";
       echo "<p><span class=\"post-title\"> $title </span>";
       echo $content;
       echo "</p>";
       echo "<p class=\"date\">$ndate</p>";
       echo "</div>";
    }
    echo "</div> </section>";
    
}


function admin_get_department_fonews()
{
   global $databaseConnection;

    $query = "Select name  From departments;";
    $statement = $databaseConnection->prepare($query);

    $statement->execute();
    $statement->store_result();
    $num_row = $statement->num_rows;
    $statement->bind_result($depart_name);


    for ($i = 1; $i <= $num_row ; $i++)
    {   
       $statement->fetch();
       echo "<option value=\"$i\">  $depart_name </option>";
    }    
}

function admin_get_department()
{
   global $databaseConnection;

    $query = "Select name  From departments Where department_id != 1;";
    $statement = $databaseConnection->prepare($query);

    $statement->execute();
    $statement->store_result();
    $num_row = $statement->num_rows;
    $statement->bind_result($depart_name);


    for ($i = 1; $i <= $num_row ; $i++)
    {   
       $statement->fetch();
       echo "<option value=\"$i\">  $depart_name </option>";
    }    
}

function get_add_student()
{
    echo "<section id=\"add_student\" class=\"thirteen\">";
    echo "<div class=\"container\">";
    echo "<header>	<h2>Register Student:</h2>		</header>";
    
    echo "<input type=\"text\" id=\"adc_firstname\" placeholder=\"Enter First Name\" />";
    echo "<input type=\"text\" id=\"adc_lastname\" placeholder=\"Enter Last Name\" />";

    echo "<label for=\"adc_semester\"><b>Student Semester: </b></label>";
    echo "<input type=\"number\" value=\"1\" id=\"adc_semester\" />";
    echo "<input type=\"text\" id=\"adc_school\" placeholder=\"Enter School Name\" />";
    echo "<input type=\"text\" id=\"adc_program\" placeholder=\"Enter Program\" />";
    echo "<input type=\"text\" id=\"adc_level\" placeholder=\"Enter Level\" />";

    echo "<select id=\"admin_reg_student\">";
    echo "<option value=\"-1\">Select Department </option>";
    admin_get_department();
    echo "</select>";
    
    echo "<input type=\"button\" value=\"Register Student\" onclick=\"admin_reg_student();\" />";
    
    echo "<p id=\"error_message_registestu\" ></p>";
    echo "</div>	</section>";    
}

function get_add_course()
{
    echo "<section id=\"add_course\" class=\"thirteen\">";
    echo "<div class=\"container\">";
    echo "<header>	<h2>Add Course:</h2>		</header>";
    
    echo "<input type=\"text\" id=\"addc_code\" placeholder=\"Enter Course Code\" />";
    echo "<input type=\"text\" id=\"addc_name\" placeholder=\"Enter Course Name\" />";

    echo "<label for=\"addc_level\"><b>Level: </b></label>";
    echo "<input type=\"number\" id=\"addc_level\" value=\"1\" />";

    echo "<label for=\"addc_section\"><b>Section: </b></label>";
    echo "<input type=\"number\" id=\"addc_section\" value=\"1\" />";

    echo "<label for=\"addc_start_date\"><b>Start Date: </b></label>";
    echo "<input type=\"date\" id=\"addc_start_date\"><br/>";

    echo "<label for=\"addc_end_date\"><b>End Date: </b></label>";
    echo "<input type=\"date\" id=\"addc_end_date\"><br/>";

    echo "<label for=\"addc_final_exam_date\"><b>Final Exam Date: </b></label>";
    echo "<input type=\"date\" id=\"addc_final_exam_date\"><br/>";

    echo "<input type=\"text\" id=\"addc_final_exam_loc\" placeholder=\"Enter Final Exam Location\" />";
    echo "<input type=\"text\" id=\"addc_meeting_days\" placeholder=\"Enter Meeting Days\" />";

    echo "<label for=\"addc_meeting_time\"><b>Meeting Time: </b></label>";
    echo "<input type=\"time\" id=\"addc_meeting_time\"><br/>";

    echo "<select id=\"admin_add_course_list\">";
    echo "<option value=\"-1\">Select Department </option>";
    admin_get_department();
    echo "</select>";

    echo "<label for=\"addc_intrto\"><b>Course Introduction: </b></label>";
    echo "<textarea id=\"addc_intrto\" placeholder=\"Course Introduction\"></textarea>";
    
    echo "<input type=\"button\" value=\"Register Student\" onclick=\"admin_add_course();\" />";
    
    echo "<p id=\"error_message_addcourses\" ></p>";
    echo "</div>	</section>";    
}

function get_admin_addnews()
{
    echo "<section id=\"add_news\" class=\"thirteen\">";
    echo "<div class=\"container\">";
    echo "<header>	<h2>Add News:</h2>		</header>";
    
    echo "<input type=\"text\" id=\"addn_title\" placeholder=\"Enter News Title\" />";

    echo "<select id=\"admin_addn_news\">";
    echo "<option value=\"-1\">Select Department </option>";
    admin_get_department_fonews();
    echo "</select>";

    echo "<label for=\"addn_content\"><b>News Content: </b></label>";
    echo "<textarea id=\"addn_content\" placeholder=\"New Content\"></textarea>";


    
    echo "<input type=\"button\" value=\"Add News\" onclick=\"admin_add_news();\" />";
    
    echo "<p id=\"error_message_addminn\" ></p>";
    echo "</div>	</section>";    
}

function get_admin_addprofessor()
{
    echo "<section id=\"add_professor\" class=\"thirteen\">";
    echo "<div class=\"container\">";
    echo "<header>	<h2>Add Professor:</h2>		</header>";
    
    echo "<label for=\"addpr_firstname\"><b>First Name: </b></label>";
    echo "<input type=\"text\" id=\"addpr_firstname\" placeholder=\"Enter First Name\" />";

    echo "<label for=\"addpr_lastname\"><b>Last Name: </b></label>";
    echo "<input type=\"text\" id=\"addpr_lastname\" placeholder=\"Enter Last Name\" />";

    echo "<label for=\"addpr_depart_list\"><b>Select Department: </b></label>";
    echo "<select id=\"addpr_depart_list\">";
    echo "<option value=\"-1\">Select Department </option>";
    admin_get_department();
    echo "</select>";

    echo "<label for=\"addpr_officeh\"><b>Office Hours: </b></label>";
    echo "<input type=\"time\" id=\"addpr_officeh\"><br/>";

    echo "<label for=\"addpr_officedays\"><b>Office Days: </b></label>";
    echo "<input type=\"text\" id=\"addpr_officedays\" placeholder=\"Enter Office Days\" />";

    echo "<label for=\"addpr_office_location\"><b>Office Location: </b></label>";
    echo "<input type=\"text\" id=\"addpr_office_location\" placeholder=\"Enter Office Location\" />";

    echo "<label for=\"addpr_title\"><b>Professor Title: </b></label>";
    echo "<input type=\"text\" id=\"addpr_title\" placeholder=\"Enter Title\" />";

    
    echo "<input type=\"button\" value=\"Add Professor\" onclick=\"admin_addprofessor();\" />";
    
    echo "<p id=\"error_message_addprofessor\" ></p>";
    echo "</div>	</section>";     
}








/******************************** Student Main Functions *****************************************/


/******************************************
*          Get student's News             *
/*****************************************/
function get_student_news()
{
    global $databaseConnection;
    $title = "";
    $content ="";
    $ndate="";
    $query = "Select n.title , n.content , n.date
                From News n  JOIN Departments d On 
                n.department_id = d.department_id 
                JOIN Students s On s.department_id  = d.department_id
                AND n.department_id IN (Select department_id From Students Where student_id = ? ) OR n.department_id = 1
                Where s.student_id = ?
                ORDER BY n.date DESC LIMIT 15;";
    $statement = $databaseConnection->prepare($query);
    $statement->bind_param('dd',  $_SESSION['userid'], $_SESSION['userid']);

    $statement->execute();
    $statement->store_result();
    $num_row = $statement->num_rows;
    $statement->bind_result($title, $content, $ndate );

    echo "<section id=\"news\" class=\"one\">";
    echo "<div class=\"container\">";
    echo " <header>   <img id=\"new_image\" src=\"images/news-logo.png\" alt=\"News\" />  </header>";
    
    for ($i = 1; $i <= $num_row ; $i++)
    {
       $statement->fetch();
       echo "<div class=\"artical\">";
       echo "<p><span class=\"post-title\"> $title </span>";
       echo $content;
       echo "</p>";
       echo "<p class=\"date\">$ndate</p>";
       echo "</div>";
    }
    echo "</div> </section>";
    
}

function get_student_courses()
{
global $databaseConnection;
    $course_id;
    $course_name ="";
    $introduction="";
    $section="";
    $final_exam_date="";
    $final_location="";
    $meeting="";
    $meeting_day1="";
    $meeting_day2="";    

    $query = "Select c.course_id, c.name, c.section, c.final_exam, c.final_location, c.meeting , c.meeting_time , c.intro
                From Courses c JOIN Registered r
                ON c.course_id = r.course_id
                JOIN Students s 
                ON s.student_id = r.student_id
                Where s.student_id = ?;";
    $statement = $databaseConnection->prepare($query);
    $statement->bind_param('d',  $_SESSION['userid']);

    $statement->execute();
    $statement->store_result();
    $num_row = $statement->num_rows;
    $statement->bind_result($course_id, $course_name, $section, $final_exam_date, $final_location, $meeting, $meeting_day1, $introduction );
        
    for ($i = 1; $i <= $num_row ; $i++)
    {
       $course_class = get_course_class($i);
       $statement->fetch();
       echo "<section id=\"$course_class\" class=\"two\">";
       echo "<div class=\"container\">";
       echo "<header>   <h2>  $course_name  </h2>	</header>";
       echo "<article id=\"container\">";
       echo "<h4>Intoduction: </h4>";
       echo "<p class=\"intoduction\">  $introduction </p>";
       echo "<p class=\"meeting\"> Meeting at " . "$meeting " . "- $meeting_day1  $meeting_day2" . "$final_location </p>";
       get_course_ann($course_id);
       get_course_act($course_id);
       echo " </div> </section>";
    } 
}

function get_student_setting()
{
    echo "<section id=\"setting\" class=\"eight\">";
    echo "<div class=\"container\">";
    echo "<header> <h2>Setting:</h2> </header>";
    echo "<input type=\"text\" id=\"username_name\" placeholder=\"User Name\" />";
	echo "<input type=\"password\" id=\"old_password\" placeholder=\"Old Password\" />";
    echo "<input type=\"password\" id=\"new_password\" placeholder=\"New Password\" />"; 
    echo "<input type=\"password\" id=\"re_new_password\" placeholder=\"Retype New Password\" />";
	echo "<input type=\"submit\" id=\"name_submit\" value=\"Update Info\" onclick=\"get_me();\" />";
    echo "<br/><br/> <lable id=\"error_massegae_setting\" required></lable>";
    echo "</div></section>"; 				 
}

function get_course_class($num)
{
    switch($num)
    {
      case 1:
      return "course_1";
      break; 
      case 2:
      return "course_2";
      break;
      case 3:
      return "course_3";
      break;
      case 4:
      return "course_4";
      break;
      case 5:
      return "course_5";
      break;
    }    
}

function get_course_ann($c_id)
{
global $databaseConnection;
    $content ="";
    $post_date="";
    $query = "Select a.content,  a.adate
                From announcements a JOIN courses c 
                On c.course_id = a.course_id
                Where c.course_id = ?
                Order By a.adate DESC;";
    $statement = $databaseConnection->prepare($query);
    $statement->bind_param('d',  $c_id);

    $statement->execute();
    $statement->store_result();
    $num_row = $statement->num_rows;
    $statement->bind_result($content, $post_date);
     
    echo "<div class=\"announcement\">";
    echo "<h4>Announcements:</h4>";
    echo "<ul>";    
    for ($i = 1; $i <= $num_row ; $i++)
    {   
         $statement->fetch();
        echo "<li> $content " . " ,Posted on " . "$post_date. </li>";
    } 
    echo "</ul> </div>";    
}

function get_course_act($c_id)
{
    global $databaseConnection;
    $content ="";
    $post_date="";
    $due_date="";
    $query = "Select a.content, a.due_date, a.p_date
                From activities a JOIN courses c 
                On c.course_id = a.course_id
                Where c.course_id = ?
                Order By a.p_date DESC";
    $statement = $databaseConnection->prepare($query);
    $statement->bind_param('d',  $c_id);

    $statement->execute();
    $statement->store_result();
    $num_row = $statement->num_rows;
    $statement->bind_result($content, $post_date, $due_date);

    echo "<div class=\"activity\">";
    echo "<h4>Activitys:</h4>";
    echo "<ul>";    
    for ($i = 1; $i <= $num_row ; $i++)
    {   
         $statement->fetch();
        echo "<li> $content " . " ,Due Date: " . "$due_date" . " ,Posted on " . "$post_date. </li>";
    } 
    echo "</ul> </div>";
}

function get_student_mailbox()
{
    echo "<section id=\"milbox\" class=\"seven\">";
    echo "<div class=\"container\">"; 
    echo "<img src=\"images/mailbox.png\" alt=\"Mail Box\" />";
    list_box_courses();
    echo "<div id=\"subjectlist\">";
    echo "<ul id=\"ulsubject\" class=\"list\"> ";  
    echo "</ul> </div>";
    echo "<div id=\"messagebody\">";
    echo "<h3> Sent: </h3><p id=\"messagebody_p\"></p> </div>";
    echo "<div id=\"messagereplay\">";
    echo "<h3> Reply: </h3><p id=\"messagebody_pr\"></p> </div>";
    echo " <hr id=\"hr_mailbox\" />";
    echo "<div id=\"sendingmessage\">";
    echo "<input type=\"text\" id=\"message_subject\" placeholder=\"Subject\"/>";
    get_course_for_student();
    echo "<textarea id=\"send_message_body\" placeholder=\"Message\"></textarea>";
    echo "<input type=\"button\" value=\"Send Message\" name=\"sendbottom\" onclick=\"send_message();\" />";
    echo "<br/><br/> <lable id=\"error_massegae_mailbox\" required></lable>";
    echo "</div> </div>	</section>";
}

function get_course_for_student()
{
   global $databaseConnection;
    $ms_body ="";
    $query = "SELECT c.name, c.course_id
                FROM courses c JOIN registered r
                ON c.course_id = r.course_id 
                JOIN students s ON s.student_id = r.student_id
                WHERE s.student_id = ?;";
    $statement = $databaseConnection->prepare($query);
    $statement->bind_param('d', $_SESSION['userid']);

    $statement->execute();
    $statement->store_result();
    $num_row = $statement->num_rows;
    $statement->bind_result($ms_body, $course_id);

    echo "<select id=\"courses_list\">";
    echo "<option value=\"-1\">Select Course</option>";  
    for ($i = 1; $i <= $num_row ; $i++)
    {   
       $statement->fetch();
       echo "<option value=\"$course_id\"> $ms_body </option>";
    } 
    echo "</select>"; 
}


function get_drop_list()
{
 global $databaseConnection;
        $query = "Select courses.name From courses JOIN registered ON Courses.course_id = registered.course_id
                    JOIN Students ON students.student_id = registered.student_id 
                    Where Students.student_id = ?";
        $statement = $databaseConnection->prepare($query);
        $statement->bind_param('d',  $_SESSION['userid']);

        $statement->execute();
        $statement->store_result();
        $num_row = $statement->num_rows;
        $statement->bind_result($course_name);

        echo "<ul class=\"courselist\">";

        for ($i = 1; $i <= $num_row ; $i++)
        {
            $statement->fetch();
            echo "<li onclick=\"post_drop_course();\" ><span>$course_name </span> </li>";
        }   
        echo "</ul>"; 
}

function get_student_registration()
{
    echo "<section id=\"registration\" class=\"nine\">";
    echo "<div class=\"container\">";
    echo "<header>	<h2>Registration:</h2>	</header>";
    get_department();
    echo "<ul class=\"courselist\" id=\"courselist_depart\">";
    echo "</ul>";
    echo "<h3>Selected Course: </h3><p id=\"depart_add_ms\"></p>";
    echo "<input type=\"button\" value=\"Register\" onclick=\"register_for_course();\"  />";
    echo "<hr />";
    echo "<header>";
    echo "<hr /> <h2>Drop:</h2> </header>";
    get_drop_list();
    echo "<h3>Selected Course For Drop: </h3><p id=\"depart_drop_course\"></p>";
    echo "<input type=\"button\" value=\"Drop\" onclick=\"drop_course();\"/>";
    echo "</div>	</section>";
}

function get_department()
{
   global $databaseConnection;
    $de_name ="";
    $department_id = 0;
    $query = "Select name, department_id From departments Where department_id != 1;";
    $statement = $databaseConnection->prepare($query);

    $statement->execute();
    $statement->store_result();
    $num_row = $statement->num_rows;
    $statement->bind_result($de_name, $department_id);

    echo "<select id=\"depart_list\" onchange=\"get_course_ofdepart();\" >";
    echo "<option value=\"-1\">Select Department </option>";

    for ($i = 1; $i <= $num_row ; $i++)
    {   
       $statement->fetch();
       echo "<option value=\"$department_id\"> $de_name </option>";
    } 
    echo "</select>";   
}

function list_box_courses()
{
   global $databaseConnection;
    $query = "Select c.name, c.course_id From courses c JOIN registered r
                ON  c.course_id = r.course_id JOIN students s
                ON s.student_id = r.student_id
                Where r.student_id = ? AND c.professor_id IS NOT NULL;;";
    $statement = $databaseConnection->prepare($query);
    $statement->bind_param('d',  $_SESSION['userid']);
    $statement->execute();
    $statement->store_result();
    $num_row = $statement->num_rows;
    $statement->bind_result($course_name, $course_id);

    echo "<select id=\"list_box_courses\" onchange=\"fill_listBox_messages();\" >";
    echo "<option value=\"-1\">Select Course </option>";

    for ($i = 1; $i <= $num_row ; $i++)
    {   
       $statement->fetch();
       echo "<option value=\"$course_id\"> $course_name </option>";
    } 
    echo "</select>";   
}

