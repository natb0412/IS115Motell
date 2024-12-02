<?php
//Inkluderer functions
require_once "../../public/functions.php";

//Laster inn user
$users = load_data("users");

//Sjekker om det er en post
if($_SERVER["REQUEST_METHOD"] == "POST")
{
    if(isset($_POST["register_user"]))
    {
      // Henter data fra form for user registrering
        $username = $_POST["username"];
        $name = $_POST["name"];
        $password = $_POST["password"];
        $confirm_password = $_POST["confirm_password"];
        $user_type = $_POST["user_type"];
        
        // Sjekker om passwords matcher
        if ($password === $confirm_password) 
        {

          // Oppretter en ny user med unik ID og detaljer
          $new_user =
          [
            "id" => uniqid(),
            "username" => $username,
            "name" => $name,
            "password" => $password,
            "user_type" => $user_type,
            "is_admin" => ($user_type === "admin")
          ];

          // Legger den nye user til listen over users
          $users[] = $new_user;
          
          save_data("users", $users);

          $_SESSION["username"] = $username;
          $_SESSION["is_admin"] = $new_user["is_admin"];

          // Videresender til booking_page etter vellykket registrering
          header("Location: booking_page.php");
          exit();
        }
        // Viser feilmelding hvis Passwords ikke matcher
      else 
        {
          echo "Passwords do not match. Please try again.";
        }
}
}
?>


<?php include BASE_PATH . '/public/sites/includes/header.php'; ?>
<!--Link til ekstern CSS file-->
<link rel="stylesheet" href="css/main.css">

<!--Container for tabs-->
<div class="tabs">
  <input type="radio" name="tabs" id="tabone" checked="checked">
  
  <div class="tab">
    <h2>Register</h2>
    <form method="post" class="vertical_form">

<!--Input for user information-->
    <input type="text" name="username" placeholder="Username" required>
    <input type="text" name="name" placeholder="Name" required>
      
<!--Input for password and confirmation-->
    <input type="password" name="password" placeholder="Password" required>
    <input type="password" name="confirm_password" placeholder="Confirm Password" required>
           
    <!--Dropdown meny for valg av bruker type-->
            <select id="user_type" name="user_type" required>
            <option value="guest">Guest User</option>
            <option value="admin">Admin User</option>
            </select>

            <button type="submit" name="register_user">Register</button>
        </form>
         <!--Melding med lenke til påloggingssiden-->
            <p>Already have an account? <a href="../index.php">Login here</a></p>   
    
  </div>
</div>