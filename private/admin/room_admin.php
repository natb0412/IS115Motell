<?php
//inkluderer config og functions
require_once "../../public/config.php";
require_once "../../public/functions.php";
require_login();
require_admin();

//laster inn rom, og bookingstatus
$rooms = load_data("rooms");
$booking = load_data("booking");


//sjekker om det er en post
if ($_SERVER["REQUEST_METHOD"] == "POST")
{
    //sjekker om det er update_room, set_unavailable, eller delete_booking som blir posta.
    //basert på dette endrer den parametere som står
    if(isset($_POST["update_room"]))
    {
        $room_id = $_POST["room_id"];
        $name = $_POST["name"];
        $description = $_POST["description"];
        update_room($room_id, $name, $description);
        $rooms = load_data("rooms");
    }
    elseif(isset($_POST["set_unavailable"]))
    {
        $room_id = $_POST["room_id"];
        $start_date = $_POST["start_date"];
        $end_date = $_POST["end_date"];
        $guest_name = $_SESSION["username"];
        $adults = 0;
        $children = 0;

        $make_unavailable = 
        [
            'id' => uniqid(),
            'room_id' => $room_id,
            'guest_name' => $guest_name,
            'start_date' => $start_date,
            'end_date' => $end_date,
            'adults' => $adults,
            'children' => $children
        ];
        $booking = load_data("booking");
        $booking[] = $make_unavailable;

        save_data("booking", $booking);
    }

    elseif (isset($_POST["delete_booking"]))
    {
        if (isset($_POST["booking_id"]))
        {
        $booking_id = $_POST["booking_id"];
        
        delete_booking($booking_id);

        $rooms = load_data("rooms");
        }
    }
}


//går gjennom hvert eneste rom for å sjekke om det er tilgjengelig eller ikke
foreach ($rooms as &$room)
    {
        $today = date('Y-m-d');
        $one_year = date('Y-m-d', strtotime('+365 day'));
    //is_room_available er en funksjon
        $room['is_available'] = is_room_available($room['id'], $today, $one_year);
    }
    unset($room)

?>

<!DOCTYPE html>
<html lang="no">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - <?php echo MOTEL_NAME; ?></title>
    <link rel="stylesheet" href="css/main.css">
    <?php include BASE_PATH . '/public/sites/includes/header.php'; ?>
</head>
<body>
    <h1>Administrasion - <?php echo MOTEL_NAME; ?></h1>

    <h2>Room administrasion</h2>
    <!-- Overordna loop for fremvisning av rom -->
    <?php foreach ($rooms as $room): ?>
        <div class="room-info">
            <h3>Room <?php echo htmlspecialchars($room['name']); ?></h3>
            <p>Room type: <?php echo htmlspecialchars($room['type']); ?></p>
            <p>Status: <?php echo $room['is_available'] ? 'Tilgjengelig' : 'Ikke tilgjengelig'; ?></p>
            
            <div class="room-description">
                <h4>Description:</h4>
                <p><?php echo htmlspecialchars($room["description"]); ?></p>
            </div>

            <!-- Oppdater rom -->
            <form method="post">
                <input type="hidden" name="room_id" value="<?php echo htmlspecialchars($room['id']); ?>">
                <label>Name:
                    <input type="text" name="name" value="<?php echo htmlspecialchars($room['name']); ?>" required>
                </label>
                <label>Description:
                    <textarea name="description" required><?php echo htmlspecialchars($room['description']); ?></textarea>
                </label>
                <button type="submit" name="update_room">Update room</button>
            </form>

            <!-- Sett rom utilgjengelig -->
            <form method="post">
                <h4>Set room unavailable</h4>
                <input type="hidden" name="room_id" value="<?php echo htmlspecialchars($room['id']); ?>">
                <label>From date:
                    <input type="date" name="start_date" required>
                </label>
                <label>To date:
                    <input type="date" name="end_date" required>
                </label>
                <button type="submit" name="set_unavailable">Set unavailable</button>
            </form>

            <!-- Vis bookinger for rommet -->
            <?php 
            // Filtrer bookinger for rommet
            $current_bookings = array_filter($booking, function($b) use ($room)
            {
                return $b['room_id'] == $room['id'];
            });
            ?>

            <?php if (!empty($current_bookings)): ?>
                <h4>Bookings:</h4>
                <table>
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>From date</th>
                            <th>To date</th>
                            <th>Adults</th>
                            <th>Children</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($current_bookings as $book): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($book['guest_name']); ?></td>
                                <td><?php echo htmlspecialchars($book['start_date']); ?></td>
                                <td><?php echo htmlspecialchars($book['end_date']); ?></td>
                                <td><?php echo htmlspecialchars($book['adults']); ?></td>
                                <td><?php echo htmlspecialchars($book['children']); ?></td>
                                <td>
                                    <form method="post">
                                        <input type="hidden" name="booking_id" value="<?php echo htmlspecialchars($book['id']) ?? 666; ?>">
                                        <button type="submit" name="delete_booking">Delete booking</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>

            <?php else: ?>
                <p>No bookings for this room.</p>
            <?php endif; ?>
        </div>

    <?php endforeach; ?>

</body>
</html>