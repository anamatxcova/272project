    
            <?php
    
require_once 'dbconf.php';
    //header('Access-Control-Allow-Origin: *');
    //header('Access-Control-Allow-Methods: GET, POST');
    //header("Access-Control-Allow-Headers: X-Requested-With");
    //connect to db
    $conn = mysqli_connect($servername, $username, $password, $database);
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
 
    }

    if (isset($_POST['productName']) && isset($_POST['vendorName'])){
        $product = $_POST['productName'];
        $vendor = $_POST['vendorName'];
        $query = '';
        //$product = 'Peach Oolong Tea';
        //$vendor = 'Cup of Ice Tea';
        $query = "SELECT * FROM review WHERE productName = '$product' AND vendorName = '$vendor'";
        
        $result = mysqli_query($conn, $query);
        if(!$result) die("Database access failed:" .$conn->error);
        if ($result){
            while($row = mysqli_fetch_assoc($result)){
                $json_array[] = $row;
            }
            if (!$json_array) echo "No review";
            else{
                echo json_encode($json_array);
            } 
        }
        $result->close();
    }
    //close connection
    mysqli_close($conn);
?>

        
  