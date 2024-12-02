<?php
require_once "../public/functions.php";

//loads inn user
$users = load_data("users");

echo '<pre>';
print_r($users);
echo '</pre>';
$error_message = null;

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
          if ($user["username"] === $login_username && $user["password"] === $login_password)
          {
            $_SESSION["user_id"] = $user["id"];
            $_SESSION["username"] = $user["username"];
            $_SESSION["is_admin"] = $user["is_admin"] ?? false;
            $user_found = true;

            if ($_SESSION["is_admin"])
            {
              header("Location: ../private/admin/room_admin.php");
            }
            else
            {
            header("Location: sites/booking_page.php");
            }
            exit();
          }


        }
        if (!$user_found)
        {
          $error_message = "Invalid username or password";
           // Print session IDs for testing purposes
           echo "User ID: " . $_SESSION["user_id"] . "<br>";
           echo "Username: " . $_SESSION["username"] . "<br>";
           echo "Is Admin: " . ($_SESSION["is_admin"] ? 'Yes' : 'No') . "<br>";
        }
      }    
}
?>

<?php include BASE_PATH . '/public/sites/includes/header.php'; ?>

<!--Link to external CSS file-->
<link rel="stylesheet" href="sites/css/main.css">

<!--Container for tabs-->
<div class="tabs">
  <input type="radio" name="tabs" id="tabone" checked="checked">

  <?php if ($error_message): ?>
        <p style="color: red;"><?php echo htmlspecialchars($error_message); ?></p>
  <?php endif; ?>
  
  <div class="tab">
    <h2>Log in</h2>
    <form method="post" class="vertical_form">
    
    <!--Input for username and pasword-->
    <input type="text" name="login_username" placeholder="Username" required>
    <input type="password" name="login_password" placeholder="Password" required>
            
    <button type="submit" name="login" value="Login">Log in</button>
    </form>
       
    <!--Displays message with link to register page-->
       <p>Don't have an account? <a href="sites/register_page.php">Register here</a></p>   
       
  </div>
</div>