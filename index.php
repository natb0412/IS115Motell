<!--Link to an external stylesheet-->
<link rel="stylesheet" href="css/main.css">

<!--Container for tabbed content-->
<div class="tabs">
  <input type="radio" name="tabs" id="tabone" checked="checked">
  <label for="tabone">Booking</label>
  
  <div class="tab">
    <h2>Booking</h2>
    <form method="post" class="vertical-form">
    
    <!--Input for check-in date -->    
    <label for="check_in">Check-in Dato:</label>
        <input type="date" id="check_in" name="check_in" required>
        
        <!--Input for check-out date-->
        <label for="check_out">Check-out Dato:</label>
        <input type="date" id="check_out" name="check_out" required>

        <!--Dropdown menu to select room type-->
        <label for="room_type">Rom Type:</label>
        <select id="room_type" name="room_type" required>
            <option value="single">Single Room</option>
            <option value="double">Double Room</option>
            <option value="suite">Suite</option>
        </select>
      <!--Input for number of adult guests-->
        <label for="adult_guests">Number of Adult Guests:</label>
        <input type="number" id="adult_guests" name="adult_guests" min="1" max="4" required>

         <!--Input for number of child guests-->
        <label for="child_guests">Number of Child Guests:</label>
        <input type="number" id="child_guests" name="child_guests" min="0" max="4" required>

        <!--Submit button to send form data-->
        <input type="submit" value="Book Now">
    </form>
  </div>
</div>