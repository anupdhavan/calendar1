<?php
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

// Get the event ID from the AJAX request
$id = $_POST['id'];

// Prepare and execute the SQL statement to delete the event
$sql = "DELETE FROM events WHERE id = '$id'";
$result = $conn->query($sql);

if ($result) {
  // Event deleted successfully
  $response = array('status' => 'success', 'message' => 'Event deleted successfully.');
} else {
  // Failed to delete event
  $response = array('status' => 'error', 'message' => 'Failed to delete event.');
}

// Close the database connection
$conn->close();

// Return the JSON response
header('Content-Type: application/json');
echo json_encode($response);
?>
