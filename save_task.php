<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Connect to the database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "anup";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the event data from the AJAX request
$type= $_POST['type'];
$title = $_POST['title'];
$start = $_POST['start'];
$end = $_POST['end'];
$desciption = $_POST['desciption'];
$reminder = $_POST['reminder'];
$guestEmail = $_POST['guestEmail'];
$location = $_POST['location'];


// Prepare and execute the SQL statement to insert the event data
$sql = "INSERT INTO `events` ( `type`,`title`, `start_date`, `end_date`, `description`, `remindar`, `guest_mail`, `location`)
 VALUES ( '$type ','$title ', '$start', '$end', '$desciption', '$reminder', '$guestEmail', '$location')";
$result = $conn->query($sql);

if ($result) {
    // Event saved successfully
    $response = array('status' => 'success', 'message' => 'Event saved successfully.');
} else {
    // Failed to save event
    $response = array('status' => 'error', 'message' => 'Failed to save event.');
}

// Close the database connection
$conn->close();

// Return the JSON response
header('Content-Type: application/json');
echo json_encode($response);
?>
