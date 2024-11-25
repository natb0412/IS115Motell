<?php

require_once "../../public/config.php";
require_once "../../public/functions.php";


$rooms = load_data("rooms");
var_dump($rooms);



if($_SERVER["REQUEST_METHOD"] == "POST")
{
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
        set_room_unavailable($room_id, $start_date, $end_date);
    }
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
    <?php foreach ($rooms as &$room): ?>
        <form method="post">
            <h3>Rom <?php echo htmlspecialchars($room['name']); ?></h3>
            <input type="hidden" name="room_id" value="<?php echo $room['id']; ?>">
            <label>
                Navn:
                <input type="text" name="name" value="<?php echo htmlspecialchars($room['name']); ?>" required>
            </label>
            <label>
                Beskrivelse:
                <textarea name="description"><?php echo htmlspecialchars($room['description']); ?></textarea>
            </label>
            <button type="submit" name="update_room">Oppdater rom</button>
        </form>

        <form method="post">
            <h4>Sett rom utilgjengelig</h4>
            <input type="hidden" name="room_id" value="<?php echo $room['id']; ?>">
            <label>
                Fra dato:
                <input type="date" name="start_date" required>
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