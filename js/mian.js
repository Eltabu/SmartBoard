function get_me()
{
    var username = $.trim($('#username_name').val());
    var old_password = $('#old_password').val();
    var new_password = $('#new_password').val();
    var re_new_password = $('#re_new_password').val();
    var status = false;


    if (username != '' && old_password != '' && new_password != ''  && re_new_password != '' )
    {
        status = true;
    }
    if (new_password != re_new_password) 
    {
         status = false;
    }

    if (status)
    {
        $.post("student_setting.php", { username_name: username, new_password: new_password, old_password: old_password }, function (data)
        {
            document.getElementById('error_massegae_setting').innerHTML = data;
        });
    }
    else 
    {
        document.getElementById('error_massegae_setting').innerHTML = 'One or More Fields are Empty';
    }

}

function send_message() 
{
     var message_body = $.trim($('#send_message_body').val());
     var message_subject = $.trim($('#message_subject').val());
     var mesage_to = $.trim($('#courses_list option:selected').text());

     var myselect = document.getElementById("courses_list");
     var course_id  = (myselect.options[myselect.selectedIndex].value);



     if (message_body != '' && message_subject != '' && mesage_to != 'Select Course')
     {
         $.post("student_send_ms.php", { message_body: message_body, message_subject: message_subject, mesage_to: mesage_to, course_id: course_id }, function (result)
         {
             document.getElementById('error_massegae_mailbox').innerHTML = result;
         });
     }
     else 
     {
        document.getElementById('error_massegae_mailbox').innerHTML = 'One or More Fields are Empty'; 
     }
     
    
}

function get_message_content() 
{
    var target = event.target;
    var ms_subject =$.trim(target.innerHTML);

     $.post("student_grt_ms.php", { ms_subject: ms_subject }, function (result)
         {
             document.getElementById('messagebody_p').innerHTML  = result;
         });

      $.post("student_get_replay_ms.php", { ms_subject: ms_subject }, function (info)
         {
             document.getElementById('messagebody_pr').innerHTML  = info;
         });

}

function get_course_ofdepart()
 {
    var myselect = document.getElementById("depart_list");
    var depart_id  = (myselect.options[myselect.selectedIndex].value);

    if (depart_id == -1)
    {
        $("#courselist_depart").empty();
        document.getElementById("depart_add_ms").innerHTML = "";
        return;
    } 
    else 
    {
        $.post("fill_course_depart.php", { depart_id: depart_id }, function (data)
         {
             $( "#courselist_depart" ).empty().append( data );
         }
         );        
    }
 }

 function post_selected_course()
 {
    var target = event.target;
    var course_name =$.trim(target.innerHTML);
    document.getElementById("depart_add_ms").innerHTML = course_name;
 }

 function register_for_course()
 {
    var course_name = $.trim(document.getElementById("depart_add_ms").innerHTML);

    if (course_name != "")
    {
        $.post("student_register_for_course.php", { course_name: course_name }, function (data)
        {
            document.getElementById("depart_add_ms").innerHTML = "";
        });
    }

 }

 function drop_course()
 {
     var course_name = $.trim(document.getElementById("depart_drop_course").innerHTML);

    if (course_name != "")
    {
        $.post("student_drop_course.php", { course_name: course_name }, function (data)
        {
            document.getElementById("depart_drop_course").innerHTML = "";
        });
    }    
 }

function post_drop_course()
 {
    var target = event.target;
    var course_name =$.trim(target.innerHTML);
    document.getElementById("depart_drop_course").innerHTML = course_name;
 }

 function fill_listBox_messages()
 {
    var myselect = document.getElementById("list_box_courses");
    var course_id  = (myselect.options[myselect.selectedIndex].value);

    if (course_id == -1)
    {
        $("#ulsubject").empty();
        return;
    } 
    else 
    {
        $.post("get_inboxlist_for_student.php", { course_id: course_id }, function (data)
         {
             $( "#ulsubject" ).empty().append( data );
         }
         );        
    }
 }



 /************************ Professor ***********************************/
 
function professor_message_content()
{
    var ms_id = event.target.id;
    var ms_subject =$.trim(event.target.innerHTML);
     $.post("professor_get_ms.php", { ms_id: ms_id }, function (result)
         {
             document.getElementById('messagebody_p').innerHTML  = result;
         });

      $.post("professor_get_replay_ms.php", { ms_id: ms_id }, function (info)
         {
             document.getElementById('messagebody_pr').innerHTML  = info;
         });
    $("#prof_selected_ms").empty().append( ms_subject  );
    $("#prof_selected_ms").attr('name', ms_id );
}

function prof_replay_message()
{
     var message_body = $.trim($('#replay_message_body').val());
     var message_id = document.getElementById("prof_selected_ms").getAttribute("name");

     //alert(message_body);

     if (message_body  != '' && message_id != null )
     {
         $("#error_massegae_mailbox").empty();
         $.post("professor_reply_ms.php", { message_body: message_body, message_id: message_id }, function (result)
         {
             document.getElementById('error_massegae_mailbox').innerHTML = result;
         });
     }
     else 
     {
        $( "#error_massegae_mailbox" ).empty().append( 'One or More Fields are Empty' );
     }   
}

function get_prof_ms()
{
    var myselect = document.getElementById("prof_courses_mailbox");
    var course_id  = (myselect.options[myselect.selectedIndex].value);
    if (course_id == -1)
    {
        $("#ulsubject").empty();
        return;
    } 
    else 
    {
        $.post("professor_ms_list.php", { course_id: course_id }, function (data)
         {
             $( "#ulsubject" ).empty().append( data );
         }
         );      
                 
    }
}

 function change_professor_setting()
{
    var username = $.trim($('#username_name').val());
    var old_password = $('#old_password').val();
    var new_password = $('#new_password').val();
    var re_new_password = $('#re_new_password').val();
    var status = false;


    if (username != '' && old_password != '' && new_password != ''  && re_new_password != '' )
    {
        status = true;
    }
    if (new_password != re_new_password) 
    {
         status = false;
    }

    if (status)
    {
        $.post("professor_setting.php", { username_name: username, new_password: new_password, old_password: old_password }, function (data)
        {
            document.getElementById('error_massegae_setting').innerHTML = data;
        });
    }
    else 
    {
        document.getElementById('error_massegae_setting').innerHTML = 'One or More Fields are Empty';
    }

}

function add_announcements()
{
    var myselect = document.getElementById("prof_add_ann");
    var course_id  = (myselect.options[myselect.selectedIndex].value);
    var content = document.getElementById("add_announcements_texterea").value;

    if (course_id != -1 && content != "") 
    {
        $.post("professor_add_announcement.php", { content: content , course_id: course_id}, function (data)
        {
            document.getElementById('error_message_ancc').innerHTML = data;
        });
    }
}

function add_activities()
{
    var myselect = document.getElementById("prof_add_act");
    var course_id  = (myselect.options[myselect.selectedIndex].value);
    var duedate = document.getElementById("activity_duedate").value;
    var content = document.getElementById("add_activities_texterea").value;
    if (course_id != -1 && duedate != "" && content != "")
    {
        $.post("professor_add_activity.php", { course_id: course_id, duedate: duedate, content: content }, function (data)
        {
            document.getElementById('error_message_acti').innerHTML = data;
        });
    }
}


function prof_register_course()
{
    var course_id  = $("#proff_course_reg").attr('name');
    $.post("professor_reg_for_course.php", { course_id: course_id}, function (data)
        {
            document.getElementById('proff_course_reg').innerHTML = data;
        });
}

function prof_drop_course()
{
    var myselect = document.getElementById("prof_drope_course");
    var course_id  = (myselect.options[myselect.selectedIndex].value);

    if (course_id != -1)
    {
        $.post("professor_drop_course.php", { course_id: course_id}, function (data)
        {
            document.getElementById('depart_drop_course').innerHTML = data;
        });
    }
}
/* OnClick Event list of courses available ***/
function prof_reg_course()
{
    var ms_id = event.target.id;
    var course_name =$.trim(event.target.innerHTML);
    document.getElementById("proff_course_reg").innerHTML = course_name;
    $("#proff_course_reg").attr('name', ms_id );
}


 /************************ Admins ***********************************/

 function admin_reg_student()
 {
    var myselect = document.getElementById("admin_reg_student");
    var depart_name  = $.trim((myselect.options[myselect.selectedIndex].innerHTML));
    var firstname = $.trim($('#adc_firstname').val());
    var lastname = $.trim($('#adc_lastname').val());
    var semester = $.trim($('#adc_semester').val());
    var level = $.trim($('#adc_level').val());
    var school = $.trim($('#adc_school').val());
    var program = $.trim($('#adc_program').val());

    if (depart_name != "Select Department" && firstname != "" && lastname != "" && semester > 0 && semester < 9 && level != "" && school != "" & program != "")
    {
        $.post("admin_register_student.php", { depart_name: depart_name, firstname: firstname, lastname: lastname, semester: semester, level: level, school: school, program: program }, function (data)
        {
            document.getElementById('error_message_registestu').innerHTML = data;
        });
    }
    else
    {
        document.getElementById('error_message_registestu').innerHTML = "One ore More Field  are Empty";
    }

 }

 function admin_add_course()
 {

    var myselect = document.getElementById("admin_add_course_list");
    var depart_name  = $.trim((myselect.options[myselect.selectedIndex].innerHTML));

    var code = $.trim($('#addc_code').val());
    var name = $.trim($('#addc_name').val());
    var section = $.trim($('#addc_section').val());
    var start_date = $.trim($('#addc_start_date').val());
    var end_date = $.trim($('#addc_end_date').val());
    var final_examdate = $.trim($('#addc_final_exam_date').val());
    var final_location = $.trim($('#addc_final_exam_loc').val());
    var meeting_days = $.trim($('#addc_meeting_days').val());
    var meeting_time = $.trim($('#addc_meeting_time').val());
    var intro = $.trim($('#addc_intrto').val());
    var level = $.trim($('#addc_level').val());

    if (depart_name != "Select Department" && code != "" && name != "" && section > 0 && level < 7 && level > 0 && start_date != "" & end_date != "" && final_examdate  != "" && final_location != ""  && meeting_days != ""   &&  meeting_time != ""  && intro != "" )
    {
        
        $.post("admin_add_course.php", { depart_name: depart_name, code: code, name: name, section: section, level: level, start_date: start_date, end_date: end_date  , final_examdate: final_examdate, final_location: final_location, meeting_days: meeting_days, meeting_time: meeting_time,  intro:intro  }, function (data)
        {
            document.getElementById('error_message_addcourses').innerHTML = data;
        });
    }
    else
    {
        document.getElementById('error_message_addcourses').innerHTML = "One ore More Field  are Empty";
    }
 }

  function admin_add_news()
 {
    var myselect = document.getElementById("admin_addn_news");
    var depart_name  = $.trim((myselect.options[myselect.selectedIndex].innerHTML));

    var title = $.trim($('#addn_title').val());
    var content = $.trim($('#addn_content').val());

    if (depart_name != "Select Department" && title != "" && content != "")
    {
        $.post("admin_addn_news.php", { depart_name: depart_name, title:title , content:content }, function (data)
        {
            document.getElementById('error_message_addminn').innerHTML = data;
        });
    }
    else
    {
        document.getElementById('error_message_addminn').innerHTML = "One ore More Field  are Empty";
    }

 }

 function admin_addprofessor()
 {
    var myselect = document.getElementById("addpr_depart_list");
    var depart_name  = $.trim((myselect.options[myselect.selectedIndex].innerHTML));

    var firstname = $.trim($('#addpr_firstname').val());
    var lastname = $.trim($('#addpr_lastname').val());
    var office_hour = $.trim($('#addpr_officeh').val());
    var office_days = $.trim($('#addpr_officedays').val());
    var office_loc = $.trim($('#addpr_office_location').val());
    var pro_title = $.trim($('#addpr_title').val());
    
    if (depart_name != "Select Department" && firstname != "" && lastname != "" && office_hour != "" && office_days != "" && office_loc != "" && pro_title != "")
    {
        alert("0");
        $.post("admin_add_professor.php", { depart_name: depart_name, firstname: firstname, lastname: lastname, office_hour: office_hour, office_days: office_days, office_loc: office_loc, pro_title: pro_title }, function (data)
        {
            document.getElementById('error_message_addprofessor').innerHTML = data;
        });
        alert(1);
    }
    else
    {
        document.getElementById('error_message_addprofessor').innerHTML = "One ore More Field  are Empty";
    }

 }

