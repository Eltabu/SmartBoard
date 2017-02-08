
/*---------- Simple validation Check if the user Enter Info ----------------*/
function check_info() 
{
    var username = document.getElementById('username').value;
    var password = document.getElementById("password").value;
    if (username == "" || password == "")
    {
        document.getElementById("alart_message").value = "Blank Field";
        return false;
    }
    else {   return true; }

}
