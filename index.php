<?php include("config.php") ?>
<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <title>URL Shortener with Tracking</title>
</head>
<body style="background-color: #0b101b" class="container col-7">
    <div class="d-flex justify-content-center align-items-center mt-5">
        <div>
            <h1 class="mb-4" style="color:#6151c4">URL Shortener with Tracking</h1>

            <form action="shorten.php" method="post">
            <div class="row">
                    <div class="col-md-6 mb-3">
                        <input type="text" class="form-control" name="long_url" placeholder="Enter URL">
                    </div>
                    <div class="col-md-3 mb-3">
                        <button class="btn btn-primary btn-block" type="submit">Shorten</button>
                    </div>
                </div>
            </form>

            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">Short URL</th>
                        <th scope="col">Long URL</th>
                        <th scope="col">referrer</th>
                        <th scope="col">clicks</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                     $sql = "SELECT short_code, long_url FROM urls";
                     $query = "SELECT referrer, clicks FROM click_logs";
                     $value = $conn->query($query);
                     $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                        while ($urlRow = $result->fetch_assoc()) {
                            $clickRow = $value->fetch_assoc();
                        
                            if ($clickRow === null) {
                                // Handle the case where there are no more click rows
                                $referrer = "N/A";
                                $clicks = "N/A";
                            } else {
                                $referrer = $clickRow['referrer'];
                                $clicks = $clickRow['clicks'];
                            }
                        
                            $short_code = $urlRow['short_code'];
                            $long_url = $urlRow['long_url'];
                        
                            echo "<tr>";
                            echo "<td><a href='redirect.php?code=$short_code' target = _blank onclick='openRedirect(\"$short_code\")'>$short_code</a></td>";
                            echo "<td>$long_url</td>";
                            echo "<td>$referrer</td>";
                            echo "<td>$clicks</td>";
                            echo "</tr>";
                        }
                        
                        // If there are more click rows than URL rows
                       
                        
                    } else {
                        echo "<tr><td colspan='2'>No data available</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
<script>
    function openRedirect(shortCode) {
        window.open("redirect.php?code=" + shortCode, "_blank");
        refreshPage();
    }

    function refreshPage() {
        setTimeout(function() {
            location.reload();
        }, 100); // Delay of 100 milliseconds
    }
</script>
</html>
