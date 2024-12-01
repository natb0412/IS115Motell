<?php
//Includes functions
require_once "../../public/functions.php";
session_start();

//loads inn user
$users = load_data("users");

//Checks if there is an post
if($_SERVER["REQUEST_METHOD"] == "POST")
{
    if(isset($_POST["login"]))
    {
      //Retrieve form data for login
        $login_username = $_POST["login_username"];
        $login_password = $_POST["login_password"];
        
        //Check if username and passwords match
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

<!--Link to external CSS file-->
<link rel="stylesheet" href="sites/css/main.css">

<!--Container for tabs-->
<?php include BASE_PATH . '/public/sites/includes/header.php'; ?>
<div class="tabs">
  <div class="tab">
    <h2>Log in</h2>
    <form method="post" class="vertical_form">
    
    <!--Input for username and pasword-->
    <input type="text" name="login_username" placeholder="Username" required>
    <input type="password" name="login_password" placeholder="Password" required>
            
    <button type="submit" name="login" value="Login"></button>
    </form>
       
    <!--Displays message with link to register page-->
       <p>Don't have an account? <a href="register_page.php">Register here</a></p>   
       
  </div>
</div>