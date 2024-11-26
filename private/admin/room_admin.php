<?php
//inkluderer config og functions
require_once "../../public/config.php";
require_once "../../public/functions.php";

//laster inn rom, og bookingstatus
$rooms = load_data("rooms");
$bookings = load_data("booking");


//sjekker om det er en post
if($_SERVER["REQUEST_METHOD"] == "POST")
{
    //sjekker om det er update_room, eller set_unavailable som blir posta.
    //basert på dette endrer den parametere som står
    if(isset($_POST["update_room"]))
    {
        $room_id = $_POST["room_id"];
        $name = $_POST["name"];
        $description = $_POST["description"];
        update_room($room_id, $name, $description);
    }
    elseif(isset($_POST["set_unavailable"]))
    {
        $room_id = $_POST["room_id"];
        $start_date = $_POST["start_date"];
        $end_date = $_POST["end_date"];
        //setter rom som utilgjengelig i gitt periode(lager en booking)
        set_room_unavailable($room_id, $start_date, $end_date);
    }
}


//går gjennom hvert eneste rom for å sjekke om det er tilgjengelig eller ikke
foreach ($rooms as &$room)
    {
        $today = date('Y-m-d');
        $tomorrow = date('Y-m-d', strtotime('+1 day'));
    //is_room_available ligger i functions
        $room['is_available'] = is_room_available($room['id'], $today, $tomorrow);
    }

?>

<!DOCTYPE html>
<html lang="no">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - <?php echo MOTEL_NAME; ?></title>
</head>
<body>
    <h1>Administrasjon - <?php echo MOTEL_NAME; ?></h1>

    <h2>Rom administrasjon</h2>
    <!--Looper gjennom alle rom -->
    <?php foreach ($rooms as &$room): ?>
        <form method="post">
            <h3>Rom <?php echo htmlspecialchars($room['name']); ?></h3>
            <input type="hidden" name="room_id" value="<?php echo $room['id']; ?>">
            <label>
                Navn:
                <input type="text" name="name" value="<?php echo htmlspecialchars($room['name']); ?>" required>
            </label>
            <label>
                <br>
                Romtype: <?php echo $room['type']; ?>
                <br>
                <!-- Setter tilgjengelig eller ikke tilgjengelig basert på om is_available er true eller false -->
                <p>Status: <?php echo $room['is_available'] ? 'Tilgjengelig' : 'Ikke tilgjengelig'; ?></p>
            </label>
            <label>
                Beskrivelse:
                <textarea name="description"><?php echo htmlspecialchars($room["description"]); ?></textarea>
            </label>
            <button type="submit" name="update_room">Oppdater rom</button>
        </form>
        <!-- Form for å gjøre rom utilgegjengelige i en gitt periode -->
        <form method="post">
            <h4>Sett rom utilgjengelig</h4>
            <input type="hidden" name="room_id" value="<?php echo $room['id']; ?>">
            <label>
                Fra dato:
                <input type="date" name="start_date" required value="<?php echo $booking["start_date"]; ?>">
            </label>
            <label>
                Til dato:
                <input type="date" name="end_date" required>
            </label>
            <button type="submit" name="set_unavailable">Sett utilgjengelig</button>
        </form>
        <hr>
    <?php endforeach; ?>
</body>
</html>   