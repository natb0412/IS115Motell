<?php

session_start();

if(isset($_POST["logout"]))
{
  unset($_SESSION["user"]);
}


//If user is not signed inn push to login_page
if (!isset($_SESSION["user"]))
{
  header("location: test_login.php");
  exit();
}

?>

<!DOCTYPE html>
<html>
  <head>
    <titel> Home Page  </titel>
</head>

<body>
<h2>Home Page </h2>

<?php 
echo($_SESSION["user"])
?>

<form method="post">
  <input type="hidden" name="logout" value="1"/>
  <input type="submit" value="logout"/>
</form>
</body>
</html>