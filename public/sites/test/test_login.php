<!DOCTYPE html>
<html>
  <head>
    <titel> TEST Login Page  </titel>
</head>

<body>
<h2>TEST Login Page </h2>

<?php 
require "test_check.php";
?>

<form method="post">
  <input type="text" name="users" require/>
  <input type="password" name="password" require/>
  <input type="submit" value="Login"/>
</form>
</body>
</html>