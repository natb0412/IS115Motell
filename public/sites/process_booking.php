<?php
require_once '../functions.php';

//sjekker POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $room_id = $_POST['room_id'];
    $check_in = $_POST['start_date'];
    $check_out = $_POST['end_date'];
    $adults = $_POST['adults'];
    $children = $_POST['children'];
    $guest_name = $_SESSION['username'];

//loader eksisterende bookinger
    $bookings = load_data('booking');


//lag ny booking
    $new_booking = 
    [
        'id' => uniqid(),
        'room_id' => $room_id,
        'guest_name' => $guest_name,
        'start_date' => $check_in,
        'end_date' => $check_out,
        'adults' => $adults,
        'children' => $children
    ];



//legger til den nye bookingen i listen over bookinger
   $bookings[] = $new_booking; 

 //lagrer den nye bookingen i booking arrayen
    save_data('booking', $bookings);

//loader inn rooms
    $rooms = load_data("rooms");
    $room = null;
//loop gjennom rom for å finne det booka rommet
    foreach($rooms as $r)
    {
        if ($r["id"] == $room_id)
            {    
                $room = $r;
                break;
            }
    }
}
?>

<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Booking Confirmed</title>
        <link rel="stylesheet" href="css/main.css">
        <?php include BASE_PATH . '/public/sites/includes/header.php'; ?>
    </head>
    <body>
        <h1>Booking Confirmed</h1>
        <table>
            <tr>
                <th>Booking ID</th>
                <td><?php echo htmlspecialchars($new_booking['id']); ?></td>
            </tr>
            <tr>
                <th>Guest Name</th>
                <td><?php echo htmlspecialchars($guest_name); ?></td>
            </tr>
            <tr>
                <th>Room</th>
                <td><?php echo htmlspecialchars($room['name'] . ' (' . $room['type'] . ')'); ?></td>
            </tr>
            <tr>
                <th>Check-in Date</th>
                <td><?php echo htmlspecialchars($check_in); ?></td>
            </tr>
            <tr>
                <th>Check-out Date</th>
                <td><?php echo htmlspecialchars($check_out); ?></td>
            </tr>
            <tr>
                <th>Number of Adults</th>
                <td><?php echo htmlspecialchars($adults); ?></td>
            </tr>
            <tr>
                <th>Number of Children</th>
                <td><?php echo htmlspecialchars($children); ?></td>
            </tr>
        </table>
        <a href="booking_page.php">Back to Bookings</a>
    </body>
    </html>
    <?php
    exit;
?>