<?php
//Includes functions
require_once "../../public/functions.php";

//loads inn user
$users = load_data("user");

//Checks if there is an post
if($_SERVER["REQUEST_METHOD"] == "POST")
{
    if(isset($_POST["register_user"]))
    {
      // Retrieve form data for user registration
        $username = $_POST["username"];
        $name = $_POST["name"];
        $password = $_POST["password"];
        $confirm_password = $_POST["confirm_password"];
        $user_type = $_POST["user_type"];
        
        // Check if passwords match
        if ($password === $confirm_password) 
        {
          $_SESSION['user_id'] = $username; // Use username as session identifier
          header("Location: booking_page.php");
          exit();
        }
      else 
        {
          echo "Passwords do not match. Please try again.";
        }
}
}
?>

<!--Link to external CSS file-->
<link rel="stylesheet" href="css/main.css">

<!--Container for tabs-->
<div class="tabs">
  <input type="radio" name="tabs" id="tabone" checked="checked">
  <label for="tabone">Register</label>
  
  <div class="tab">
    <h2>Register</h2>
    <form method="post" class="vertical_form">

<!--Input for user information-->
    <input type="text" name="username" placeholder="Username" required>
    <input type="text" name="name" placeholder="Name" required>
      
<!--Input for password and confirmation-->
    <input type="password" name="password" placeholder="Password" required>
    <input type="password" name="confirm_password" placeholder="Confirm Password" required>
           
    <!--Dropdown menu for selecting user type-->
            <select id="user_type" name="user_type" required>
            <option value="guest">Guest User</option>
            <option value="admin">Admin User</option>
            </select>

            <button type="submit" name="register_user">Register</button>
        </form>
         <!--Displays message with link to login page-->
            <p>Already have an account? <a href="../index.php">Login here</a></p>   
    
  </div>
</div>