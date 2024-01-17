<?php 
 
$userID = $_POST['userID']; 
$userPwd = $_POST['userPwd']; 
 
$host = "localhost"; 
$username = "root"; 
$password = ""; 
$dbname = "songs_collection_system"; 
 
$link = new mysqli($host, $username, $password, $dbname); 
if ($link->connect_error) { 
    die("Connection failed: " . $link->connect_error); 
} else { 
    $queryCheck = "SELECT * FROM USERS WHERE UserID = '".$userID."'"; 
    $resultCheck = $link->query($queryCheck); 
 
    if ($resultCheck->num_rows == 0) { 
        echo "<p style='color:red;'>User ID does not exist</p>"; 
        echo "<br>Click <a href='login.html'> here </a> to log-in again"; 
    } else { 
        $row = $resultCheck->fetch_assoc(); 
        $UserStatus = $row["UserStatus"]; 
 
        if ($UserStatus === 'Blocked') { 
            // Redirect to the blocked page 
            header("Location: blocked.php"); 
            exit(); 
        } else { 
            // Proceed with login logic 
            if ($row["UserPwd"] == $userPwd) { 
                session_start(); 
                $_SESSION["UID"] = $userID; 
                $_SESSION["UserType"] = $row["UserType"]; 
                header("Location: menu.php"); 
            } else { 
                echo "<p style='color:red;'>Wrong password!!! </p>"; 
                echo "Click <a href='login.html'> here </a> to login again "; 
            } 
        } 
    } 
} 
 
$link->close(); 
?>