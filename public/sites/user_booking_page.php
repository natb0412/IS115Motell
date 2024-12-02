<?php
require_once "../../public/functions.php";
require_login(); // Sikkrer at user er logged in

// Henter nåverende user's ID
$guest_name = $_SESSION['username'];

// Laster inn alle bookings
$all_bookings = load_data('booking');

// Filtrerer bookings for nåverende user
$user_bookings = array_filter($all_bookings, function($booking) use ($guest_name) {
    return $booking['guest_name'] == $guest_name;
});

// Laster inn room data for å få room navn
$rooms = load_data('rooms');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Bookings</title>
    <link rel="stylesheet" href="css/main.css">
    <?php include BASE_PATH . '/public/sites/includes/header.php'; ?>
</head>
<body>
    <h1>Your Bookings</h1>

    <?php if (empty($user_bookings)): ?>
        <p>You have no bookings at the moment.</p>
    <?php else: ?>
        <table>
            <thead>
                <tr>
                    <th>Booking ID</th>
                    <th>Room</th>
                    <th>Check-in Date</th>
                    <th>Check-out Date</th>
                    <th>Adults</th>
                    <th>Children</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($user_bookings as $booking): ?>
                    <?php
                    // Finn room navn
                    $room_name = 'Unknown Room';
                    foreach ($rooms as $room) {
                        if ($room['id'] == $booking['room_id']) {
                            $room_name = $room['name'];
                            break;
                        }
                    }
                    ?>
                    <tr>
                        <td><?php echo htmlspecialchars($booking['id']); ?></td>
                        <td><?php echo htmlspecialchars($room_name); ?></td>
                        <td><?php echo htmlspecialchars($booking['start_date']); ?></td>
                        <td><?php echo htmlspecialchars($booking['end_date']); ?></td>
                        <td><?php echo htmlspecialchars($booking['adults']); ?></td>
                        <td><?php echo htmlspecialchars($booking['children']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>

    <a href="booking_page.php">Make a New Booking</a>
</body>
</html>