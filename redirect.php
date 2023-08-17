<?php include("config.php") ?>
<?php
// Connect to the database (replace with your database credentials)

$short_code = $_GET['code'];

// Retrieve the original URL from the database
$sql = "SELECT long_url FROM urls WHERE short_code = '$short_code'";
$clicks = "SELECT clicks FROM click_logs WHERE short_code = '$short_code'";
$result = $conn->query($sql);
$clickres = $conn->query($clicks);


if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $original_url = $row['long_url'];

    // Fetch the existing click count for the short_code
    $sql_click = "SELECT clicks FROM click_logs WHERE short_code = '$short_code'";
    $clickres = $conn->query($sql_click);
    
    if ($clickres->num_rows > 0) {
        // Fetch the current click count
        $val = $clickres->fetch_assoc();
        $click_count = ++$val['clicks'];
        
        // Update the click count for the existing row
        $sql_update = "UPDATE click_logs SET clicks = $click_count WHERE short_code = '$short_code'";
        $conn->query($sql_update);
    } else {
        // If no existing row, start click count at 1
        $click_count = 1;
        
        // Insert a new row with the initial click count
        $sql_insert = "INSERT INTO click_logs (short_code, click_time, user_ip, user_agent, referrer, clicks) 
                       VALUES ('$short_code', NOW(), '{$_SERVER['REMOTE_ADDR']}', '{$_SERVER['HTTP_USER_AGENT']}', '{$_SERVER['HTTP_REFERER']}',$click_count)";
        $conn->query($sql_insert);
    }

    $conn->close(); // Close the connection before redirection
    header("Location: $original_url");
    exit; // Terminate the script after redirection
}

 else {
    echo "Invalid URL";
}

$conn->close();
?>
