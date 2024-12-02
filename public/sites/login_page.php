<?php
//Inkluder functions
require_once "../../public/functions.php";
session_start();

//Laster inn user
$users = load_data("users");

//Sjekker om tdet er en post
if($_SERVER["REQUEST_METHOD"] == "POST")
{
    if(isset($_POST["login"]))
    {
      //Får form data for login
        $login_username = $_POST["login_username"];
        $login_password = $_POST["login_password"];
        
        //Sjekker om username og passwords matcher
        $user_found = false;
        foreach($users as $user)
        {
          if ($user["username"] === $login_username && password_verify($login_password, $user["password"]))
          {
            $_SESSION["user_id"] = $user["id"];
            $_SESSION["username"] = $user["username"];
            $_SESSION["is_admin"] = $user["is_admin"] ?? false;
            $user_found = true;
            exit();
          }

          
        }

        if (!$user_found)
            {
              $error_message = "Invalid username or password";
            }
      }    
}
?>

<!--Link til ekstern CSS file-->
<link rel="stylesheet" href="sites/css/main.css">

<!--Container for tabs-->
<?php include BASE_PATH . '/public/sites/includes/header.php'; ?>
<div class="tabs">
  <div class="tab">
    <h2>Log in</h2>
    <form method="post" class="vertical_form">
    
    <!--Input for username og pasword-->
    <input type="text" name="login_username" placeholder="Username" required>
    <input type="password" name="login_password" placeholder="Password" required>
            
    <button type="submit" name="login" value="Login"></button>
    </form>
       
    <!--Melding med lenke til register page-->
       <p>Don't have an account? <a href="register_page.php">Register here</a></p>   
       
  </div>
</div>