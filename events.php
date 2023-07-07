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

// Check if the request is for fetching events, saving an event, or updating an event
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Fetch events from the database
    $sql = "SELECT * FROM events";
    $result = $conn->query($sql);

    // Prepare an array to hold the events
    $events = array();

    if ($result->num_rows > 0) {
        // Loop through the result set
        while ($row = $result->fetch_assoc()) {
            $event = array(
                'id' => $row['id'],
                'type' => $row['type'],
                'title' => $row['title'],
                'description' => $row['description'],
                'start' => $row['start_date'],
                'end' => $row['end_date'],
                'remindar' => $row['remindar'],
                'guetemail' => $row['guest_mail'],
                'location' => $row['location']



            );

            // Add the event to the events array
            $events[] = $event;
        }
    }

    // Return the events as JSON
    header('Content-Type: application/json');
    echo json_encode($events);
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if the request is for saving or updating an event
    if (isset($_POST['id'])) {
        // Get the event ID and updated event data from the AJAX request
        $eventId = $_POST['id'];
        $type = $_POST['type'];
        $eventTitle = $_POST['title'];
        $eventStart = $_POST['start'];
        $eventEnd = $_POST['end'];
        $eventdesc = $_POST['description'];
        $eventreminder = $_POST['reminder'];
        $eventguestemail = $_POST['guestEmail'];
        $eventlocation = $_POST['location'];

        // Prepare and execute the SQL statement to update the event data
        $sql = "UPDATE `events` SET `title` = '$eventTitle', 
        `start_date` = '$eventStart', `end_date` = '$eventEnd', `description` = '$eventdesc', 
         `remindar` = '$eventreminder', `guest_mail` = ' $eventguestemail', `location` = ' $eventlocation'
          WHERE `events`.`id` = $eventId;";

        $result = $conn->query($sql);

        if ($result) {
            // Event updated successfully
            $response = array('status' => 'success', 'message' => 'Event updated successfully.');
        } else {
            // Failed to update event
            $response = array('status' => 'error', 'message' => 'Failed to update event.');
        }
    } else {
        // Get the event data from the AJAX request
        $title = $_POST['title'];
        $start = $_POST['start_date'];
        $end = $_POST['end_date'];

        // Prepare and execute the SQL statement to insert the event data
        $sql = "INSERT INTO events (title, start_date, end_date) VALUES ('$title', '$start', '$end')";
        $result = $conn->query($sql);

        if ($result) {
            // Event saved successfully
            $response = array('status' => 'success', 'message' => 'Event saved successfully.');
        } else {
            // Failed to save event
            $response = array('status' => 'error', 'message' => 'Failed to save event.');
        }
    }

    // Return the JSON response
    header('Content-Type: application/json');
    echo json_encode($response);
}

// Close the database connection
$conn->close();
?>