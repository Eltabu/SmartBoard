<?php
    session_start();
    require_once  ("Includes/connectDB.php");

    if (isset($_POST['submit']))
    {
        $username = $_POST['username'];
        $password = $_POST['password'];

        $query = "SELECT student_id, CONCAT_WS(' ',firstname,lastname) AS name FROM students WHERE username = ? AND password = ? LIMIT 1";
        $statement = $databaseConnection->prepare($query);
        $statement->bind_param('ss', $username, $password);

        $statement->execute();
        $statement->store_result();

        if ($statement->num_rows == 1)
        {
            $_SESSION['role'] = 1;
            $statement->bind_result($_SESSION['userid'], $_SESSION['username']);
            $statement->fetch();
            header ("Location: home.php");
        }
        else{ /*    if the user is a professor      */
            $username = $_POST['username'];
            $password = $_POST['password'];

            $query = "select professor_id, CONCAT_WS(' ',firstname,lastname) AS name FROM professors WHERE username = ? AND password = (?)                          LIMIT 1";
            $statement = $databaseConnection->prepare($query);
            $statement->bind_param('ss', $username, $password);

            $statement->execute();
            $statement->store_result();

            if ($statement->num_rows == 1)
            {
                $_SESSION['role'] = 2;
                $statement->bind_result($_SESSION['userid'], $_SESSION['username']);
                $statement->fetch();
                header ("Location: home.php");
            }
            else{ /*       if the user is an admin      */
                $username = $_POST['username'];
                $password = $_POST['password'];

                $query = "select admin_id, CONCAT_WS(' ',firstname,lastname) AS name FROM admins WHERE username = ? AND password = (?)                                  LIMIT 1";
                $statement = $databaseConnection->prepare($query);
                $statement->bind_param('ss', $username, $password);

                $statement->execute();
                $statement->store_result();

                if ($statement->num_rows == 1)
                {
                   $_SESSION['role'] = 3;
                   $statement->bind_result($_SESSION['userid'], $_SESSION['username']);
                   $statement->fetch();
                   header ("Location: home.php");
                 }

            }
        }
    }
?>
