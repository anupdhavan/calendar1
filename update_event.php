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
// Check if the request is a POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Check if the event ID, title, start date, and end date are provided
  if (
    isset($_POST['id']) 
    // && isset($_POST['type']) && isset($_POST['title']) && isset($_POST['start'])
    // && isset($_POST['end']) && isset($_POST['description']) && isset($_POST['reminder'])
    // && isset($_POST['guestemail']) && isset($_POST['location'])
  ) {
    // Get the event ID, title, start date, and end date from the request
    $eventId = $_POST['id'];
    $type = $_POST['type'];
    $eventTitle = $_POST['title'];
    $eventStart = $_POST['start'];
    $eventEnd = $_POST['end'];
    $eventdesc = $_POST['desciption'];
    $eventreminder = $_POST['reminder'];
    $eventguestemail = $_POST['guestEmail'];
    $eventlocation = $_POST['location'];

    $sql = "UPDATE `events` SET  `type` = '$type',`title` = '$eventTitle', 
        `start_date` = '$eventStart', `end_date` = '$eventEnd', `description` = '$eventdesc', 
         `remindar` = '$eventreminder', `guest_mail` = ' $eventguestemail', `location` = ' $eventlocation'
          WHERE `events`.`id` = $eventId;";

    $result = $conn->query($sql);

    if ($result) {
      // Event deleted successfully
      $response = array('status' => 'success', 'message' => 'Event  updated successfully.');
    } else {
      // Failed to delete event
      $response = array('status' => 'error', 'message' => 'Failed to update event.');
    }

    // Return a response indicating the success or failure of the update operation
    // You can return a JSON response, for example:
    // $response = array('success' => true, 'message' => 'Event updated successfully');
    echo json_encode($response);
    $conn->close();
    exit;
  }
}

// If the request does not meet the required conditions, return an error response
$response = array('success' => false, 'message' => 'Invalid request');
echo json_encode($response);