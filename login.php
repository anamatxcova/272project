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
        echo("<br>Page will automatically refresh after 3 seconds");
        header("refresh: 3");
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
    // $conn = new mysqli("localhost", "root", "", "");
    $conn = new mysqli("localhost", "wxldvwmy_cmpe272team", "cmpe272team", "wxldvwmy_marketplaceDB");
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
            $un = sanitize($_POST['username']);
            $query = "SELECT * FROM users WHERE username = '$un'";
            $result = $conn->query($query);

            $row = $result->fetch_array(MYSQLI_NUM);

            if ($un == $row[1] && password_verify(sanitize($_POST['password']), $row[2]))  // Signed In
            {
                setcookie('username', $un, time() + 1500);
                echo("<br>Successfully logged in");
                redirect($url);
            }
            else die(error_Msg("Wrong Credentials"));
        }

           echo <<<_ENDd

            <form action="" method="post">
            <input type="hidden" name="unameL" value="$un">
            <input type="submit" value="Log out" name ="logOut"></form>
            _ENDd;
        else 
        {
                die("Wrong Credentials");
        }
    }
    else if (isset($_POST['logOut'])) // Log out
    {
        // Destroy cookies
        unset($_COOKIE['name']);
        setcookie('name', '', time() - 3600);
        unset($_COOKIE['username']);
        setcookie('username', '', time() - 3600);
        echo "Logged Out";
        echo("<br>Page will automatically refreshed");
        header("refresh: 1");
    }
    else if (isset($_COOKIE['username'])) // User already logged in
    {
        $un = sanitize($_COOKIE['username']);
    }
    else
    {
        echo <<<_END1
        <form action="" method="post"><form><pre>
        Username   <input size = "30" style = "width: 220px" type="text" name="username"> <br>
        Password <input  size = "30" style = "width: 220px" type="password" name="password"> <br>
        <input type="submit" value="Sign In" name="signIn">
        </pre></form>

        _END1;
    }


?>