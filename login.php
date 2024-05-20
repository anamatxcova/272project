<?php
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

    // Function to refresh the page in 3 seconds
    function refresh_page() {
        echo("<br>Page will automatically refresh after 5 seconds");
        header("refresh: 5");
    }

    function redirect($url) {
        header('Location: '.$url);
        die();
    }

    // Function to sanituze input
    function sanitize($conn, $string) {
        return $conn->real_escape_string(strip_tags(htmlentities(stripslashes($string))));
    }

    // Connect to MySQL
    // $conn = new mysqli("localhost", "root", "", "project");
    $conn = new mysqli("marketplace272.space", "wxldvwmy_cmpe272team", "cmpe272team", "wxldvwmy_marketplaceDB");
    if ($conn->connect_error)
        die(error_Msg());
    
    echo <<<_END
        <html><head><title>LogIn</title></head><body>
    _END;

    if (isset($_POST['signIn'])) // User sign in
    {
        $un = $_POST['username'];
        $pw = $_POST['password'];
        $userVerified = 0;

        if (!$un || !$pw) // Check for empty inputs
        { 
            die("Username or Password is empty");
        } else {
            $un = sanitize($conn, $_POST['username']);
            $pw = sanitize($conn, $_POST['password']);
            $query = "SELECT * FROM users WHERE username = '$un'";
            $result = $conn->query($query);

            $row = $result->fetch_array(MYSQLI_NUM);
            if ($un == $row[1] && $pw == $row[2])  // Signed In
            {
                $info = [];
                setcookie('username', $un, time() + 86400);
                setcookie('visited', json_encode($info), time()+86400);
                echo("<br>Successfully logged in");
                redirect("http://localhost/272project/home.php");
            }
            else die(error_Msg("Wrong Credentials"));
        }
    }
    else if (isset($_POST['logOut'])) // Log out
    {
        // Destroy cookies
        unset($_COOKIE['username']);
        setcookie('username', '', time() - 86400);
        echo "Logged Out";
        echo("<br>Page will automatically refreshed");
        header("refresh: 1");
    }
    else if (isset($_COOKIE['username'])) // User already logged in
    {
        redirect("http://localhost/272project/home.php");
        $un = sanitize($conn, $_COOKIE['username']);
    }
    else
    {
        echo <<<_END1

        <!DOCTYPE html>
        <html><head><title>Log In</title>
            <style>
            .form {
            border:1px solid #999999; font: normal 20px helvetica; color: #444444;
            display: flex; padding: 20px; font-size: 10px;
            }
            body, html {
                height: 100%;
                margin: 0;
                display: flex;
                justify-content: center;
                align-items: center;
                font-size: 1.5em;
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
        <div class="container">
            <table border="0" cellpadding="2" cellspacing="5" bgcolor="#eeeeee">
            <th colspan="2" align="center">Sign In</th>
            <form action="" method="post"><form>
            <tr><td>Username</td>
            <td><input type="text" maxlength="32" name="username"></td></tr>
            <tr><td>Password</td>
            <td><input type="password" maxlength="64" name="password"></td></tr>
            <tr><td colspan="2" align="center"><input type="submit"
            value="Sign In" name="signIn"></td></tr>
            </form>
            </table>
            </div>
            </br></br></br>
        </body></html>

        _END1;
    }


?>