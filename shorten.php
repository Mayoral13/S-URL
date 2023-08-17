<?php include("config.php") ?>
<?php
// Connect to the database (replace with your database credentials)
// Function to generate a short code from the original URL
function generateShortCode($url) {
    return substr(md5($url), 0, 6);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $long_url = $conn->real_escape_string($_POST['long_url']);
    $short_code = generateShortCode($long_url);

    // Insert the original URL and shortened URL into the database
    $sql = "INSERT INTO urls (long_url, short_code) VALUES ('$long_url', '$short_code')";
    if ($conn->query($sql) === TRUE) {
        $short_url = "http://your_domain.com/$short_code";
        header("Location: index.php");
    } else {
        echo "Error: " . $conn->error;
    }
}

$conn->close();
?>
