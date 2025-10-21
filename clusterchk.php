<?php

error_reporting(E_ERROR);
$servername = "localhost";
$username = "checkuser";
$password = "";
// Create connection
$conn = new mysqli($servername, $username, $password);
// Check connection
if ($conn->connect_error) {
    header('HTTP/1.1 503 Service Temporarily Unavailable');
    header('Status: 503 Service Temporarily Unavailable');
    echo "Connection failed: " . $conn->connect_error . PHP_EOL;
} else {
    $message = 'OK';
    $status = "200 OK";
    $sql = "show status like 'wsrep_local_state_comment'";
    if ($result = $conn->query($sql)) {
        while ($obj = $result->fetch_object()) {
            if ($obj->Value !== 'Synced') $status = "503 Service Temporarily Unavailable";
            $message = $obj->Value;
        }
    }
    $result->close();
    header('HTTP/1.1 ' . $status);
    header('Status: ' . $status);
    echo $conn->get_server_info() . PHP_EOL;
    echo $message . PHP_EOL;
    echo PHP_EOL;
}
