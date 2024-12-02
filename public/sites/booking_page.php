<?php
require_once "../../public/functions.php";
require_login();

if ($_SERVER["REQUEST_METHOD"] === "POST")
  {
    load_data("booking");
    if (isset($_POST["check_dates"]))
      {
        $check_in = $_POST["start_date"];
        $check_out = $_POST["end_date"];
        $adults = $_POST["adults"];
        $children = $_POST["children"];

        $available_rooms = find_available_rooms($check_in, $check_out, $adults, $children);
      }
      elseif (isset($_POST['book_room']))
      {

      }
  }

?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book a Room</title>
    <link rel="stylesheet" href="css/main.css">
</head>

<?php include BASE_PATH . '/public/sites/includes/header.php'; ?>
<!--Container for tabs-->
<div class="tabs">
  <input type="radio" name="tabs" id="tabone" checked="checked">
  
  <div class="tab">
    <h2>Booking</h2>
    <form method="post" class="vertical_form">
    
    <!--Input for check-in date -->    
    <label for="check_in">Check-in Dato:</label>
        <input type="date" id="start_date" name="start_date" required>
        
        <!--Input for check-out date-->
        <label for="check_out">Check-out Dato:</label>
        <input type="date" id="end_date" name="end_date" required>

        </select>
      <!--Input for number of adult guests-->
        <label for="adults">Number of Adult Guests:</label>
        <input type="number" id="adults" name="adults" min="1" max="2" required>

         <!--Input for number of child guests-->
        <label for="children">Number of Child Guests:</label>
        <input type="number" id="children" name="children" min="0" max="3" required>

       <!--Input for guest_name-->
       <input type="hidden" name="guest_name" value="<?php echo htmlspecialchars($_SESSION['username']); ?>">

        <!--Submit button to send form data-->
        <input type="submit" name="check_dates" value="Check available rooms">
    </form>



    <?php
    if (isset($available_rooms) && !empty($available_rooms)):
    ?>

      <h3> Available rooms: </h3>
      <?php
        foreach ($available_rooms as $room): 
      ?>
          <div class="room">
            <h4> <?php echo htmlspecialchars($room["name"]); ?> </h4>
            <p>Type: <?php echo htmlspecialchars($room["type"]); ?> </p>
            <p>Capacity: <?php echo $room["capacity"]["adults"]; ?> adults,
            <?php echo $room["capacity"]["children"]; ?> children </p>
              <form method="post" action="">
                  <input type="hidden" name="room_id" value=" <?php echo $room["id"]; ?>">
                  <input type="hidden" name="start_date" value="<?php echo htmlspecialchars($check_in); ?>">
                  <input type="hidden" name="end_date" value="<?php echo htmlspecialchars($check_out); ?>">
                  <input type="hidden" name="adults" value="<?php echo htmlspecialchars($adults); ?>">
                  <input type="hidden" name="children" value="<?php echo htmlspecialchars($children); ?>">
                  <input type="submit" name="book_room" value="Book Now">
              </form>
        <?php endforeach; ?>
        <?php elseif (isset($available_rooms)): ?>
            <p> No rooms available for the selected dates. </p>

        <?php endif; ?>

        <?php
        if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["book_room"]))
        {
          $room_id = $_POST['room_id'];
          $check_in = $_POST['start_date'];
          $check_out = $_POST['end_date'];
          $adults = $_POST['adults'];
          $children = $_POST['children'];
          ?>

          <h3> Complete your booking </h3>
          <form method="post" action="process_booking.php" class="vertical_form">
                    <input type="hidden" name="room_id" value="<?php echo htmlspecialchars($room_id); ?>">
                    <input type="date" name="start_date" value="<?php echo htmlspecialchars($check_in); ?>" readonly>
                    <input type="date" name="end_date" value="<?php echo htmlspecialchars($check_out); ?>" readonly>
                    <input type="hidden" name="adults" value="<?php echo htmlspecialchars($adults); ?>">
                    <input type="hidden" name="children" value="<?php echo htmlspecialchars($children); ?>">
                    
                    <input type="hidden" name="guest_name" value="<?php echo htmlspecialchars($_SESSION['username']); ?>">

                    <input type="submit" value="Confirm Booking">

          </form>
        <?php
        }
          ?>


  </div>
</div>