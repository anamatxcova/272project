<?php

    // Function to refresh the page in 3 seconds
    function refresh_page() {
        echo("<br>Page will automatically refresh after 3 seconds");
        header("refresh: 5");
    }

    // Print error message
    function error_Msg($msg)
    {
        if ($msg != NULL)
            echo $msg;
        else {
            echo <<< _END
            We are sorry, but it was not possible to complete
            the requested task.
            _END;
        }
        refresh_page();
    }

    // Function to sanituze input
    function sanitize($conn, $string) {
        return $conn->real_escape_string(strip_tags(htmlentities(stripslashes($string))));
    }

    // Sign-up

    // Connect to MySQL
    // $conn = new mysqli("localhost", "root", "", "project");
    $conn = new mysqli("marketplace272.space", "wxldvwmy_cmpe272team", "cmpe272team", "wxldvwmy_marketplaceDB");
    if ($conn->connect_error)
        die(error_Msg());

    $error = false;
    // Handle user sign up
    if (isset($_POST['signUp']))
    {
        if ($_POST['username'] == NULL || $_POST['password'] == NULL) // Check for empty inputs
        { 
            $error = true;
            die(error_msg("Email or Password is empty"));
        }
        else
        {
            $un = sanitize($conn , $_POST['username']);
            $query = "SELECT * FROM users WHERE username = '$un'";
            $result = $conn->query($query);
            $row = $result->fetch_array(MYSQLI_NUM);
            $result->close();

            if ($row > 0) //Check if this username is already in DB
            {
                $error = true;
                die("User with this Username already exists.");
            }
            else
            {
                $pw = $_POST['password'];
                $query = "INSERT INTO users VALUES(NULL, '$un', '$pw')";
                $result = $conn->query($query);
                if (!$result)
                    echo error_Msg();
                else 
                    echo '<span style="color: green">'."Successfully signed up<br><br>".'</span>'; 
                refresh_page();   
            }
        }
    }
    else
    {
        echo <<<_END
        <!DOCTYPE html>
        <html><head><title>Users</title>
            <style>
            .form {
            border:1px solid #999999; font: normal 20px helvetica; color: #444444;
            display: flex; padding: 20px;
            }
            body, html {
                height: 100%;
                margin: 0;
                display: flex;
                justify-content: center;
                align-items: center;
            }   
            .container {
                display: flex;
                justify-content: center;
                align-items: center;
                height: 100%;
                width: 100%;
            }
            </style>
        </head>
        <body>
            <table border="0" cellpadding="2" cellspacing="5" bgcolor="#eeeeee">
            <th colspan="2" align="center">Sign Up</th>
            <form action="" method="post"><form>
            <tr><td>Username</td>
            <td><input type="text" maxlength="32" name="username"></td></tr>
            <tr><td>Password</td>
            <td><input type="password" maxlength="64" name="password"></td></tr>
            <tr><td colspan="2" align="center"><input type="submit"
            value="Sign Up" name="signUp"></td></tr>
            </form>
            </table>

            </br></br></br>
        </body></html>
        _END;
    }

    //Close connection
    $conn->close();

?>