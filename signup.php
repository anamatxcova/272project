<?php

    // Function to sanituze input
    function sanitize($conn, $string) {
        return $conn->real_escape_string(strip_tags(htmlentities(stripslashes($string))));
    }

    // Sign-up

    // Connect to MySQL
    // $conn = new mysqli("localhost", "root", "", "pet");
    $conn = new mysqli("localhost", "wxldvwmy_cmpe272team", "cmpe272team", "wxldvwmy_marketplaceDB");
    if ($conn->connect_error)
        die(error_Msg());

    // Handle user sign up
    if (isset($_POST['signUp']))
    {
        if ($_POST['username'] == NULL || $_POST['password'] == NULL) // Check for empty inputs
        { 
            die(error_msg("Email or Password is empty"));
        }
        else
        {
            $un = sanitize($_POST['username']);
            $query = "SELECT * FROM users WHERE username = '$un'";
            $result = $conn->query($query);

            // Check if user with this username already exists
            if ($result)
            {
                $pw = password_hash($_POST['password'], PASSWORD_DEFAULT);
                $query = "INSERT INTO users VALUES(NULL, '$un', '$pw')";
                $result = $conn->query($query);
                if (!$result) 
                    echo error_Msg();
                else 
                    echo '<span style="color: green">'."Successfully signed up<br><br>".'</span>'; 
                refresh_page();
            }
            else {
                die(error_Msg("Error signing up"));
            }
        }

        $query = "SELECT * FROM users WHERE username = '$une'";
        $result = $conn->query($query);
        $row = $result->fetch_array(MYSQLI_NUM);
        $result->close();

        if ($row > 0) //Check if this email is already in DB
        {
            die("User with this email already exists.");
        }
        else
        {
            if (!$error) {
            $query = "INSERT INTO users" .
        "(username, password) " .
        "VALUES ( '$un', '$pw')";
        }
         else { header("refresh: 3;"); }
            $result = $conn->query($query);
            if (!$result) 
                echo error_Msg();
            else 
                echo '<span style="color: green">'."Successfully signed up<br><br>".'</span>'; 
                header("refresh: 3;");
        }
    }
    // Handle user search
    else if (isset($_POST['search']))
    {

        $fname = sanitize($conn, $_POST['fname2']);
        $lname = sanitize($conn, $_POST['lname2']);
        $em = sanitize($conn, $_POST['email2']);
        $hp = sanitize($conn, $_POST['hp2']);
        $cp = sanitize($conn, $_POST['cp2']);

        $query = "SELECT * FROM users WHERE ";
        $prevQuery = false;

        if(!empty($fname)){
            $prevQuery = true;
            $fnameQuery = "firstname='". $fname . "' ";
            $query = $query . $fnameQuery;
        }
        if(!empty($lname)){
            $lnameQuery = "lastname='" . $lname. "' ";
            if ($prevQuery) {
                $query = $query . "AND " . $lnameQuery;
            }
            else {
                $prevQuery = true;
                $query = $query . $lnameQuery;
            }
        }
        if(!empty($em)){
            $emailQuery = "email='" . $em. "'";
            if ($prevQuery) {
                $query = $query . "AND " . $emailQuery;
            }
            else {
                $prevQuery = true;
                $query = $query . $emailQuery;
            }
        }
        if(!empty($hp)){
            $hphoneQuery = "homephone='" . $hp. "' ";
            if ($prevQuery) {
                $query = $query . "AND " . $hphoneQuery;
            }
            else {
                $prevQuery = true;
                $query = $query . $hphoneQuery;
            }
        }
        if(!empty($cp)){
            $cphoneQuery = "cellphone='" . $cp. "' ";
            if ($prevQuery) {
                $query = $query . "AND " . $cphoneQuery;
            }
            else {
                $prevQuery = true;
                $query = $query . $cphoneQuery;
            }
        }
       

        $result = $conn->query($query);

        if (!$result) 
            echo error_Msg("Search error.");
        else
        {
            echo "<h1>Search Results:</h1><br>";
            $rows = $result->num_rows;

            if (mysqli_num_rows($result) > 0) {
                while($row = mysqli_fetch_assoc($result)) {
                    echo "Name: " . $row["firstname"]. " " . $row["lastname"]. "<br> Home Phone: " . $row["homephone"] . "<br>Cell Phone: " . $row["cellphone"] .  "<br> Email: " . $row["email"] . "<br>Address: " . $row["address"] . "<br><br>";
                }
            } else {
                echo "No Matching Users Found";
                header("refresh: 3;");
            }
        }
    
        $result->close(); 
    }
    else
    {
        echo <<<_END
        <!DOCTYPE html>
        <html><head><title>Users</title>
            <style>
            .form {
            border:1px solid #999999; font: normal 14px helvetica; color: #444444;
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