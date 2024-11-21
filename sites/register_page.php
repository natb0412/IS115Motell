<!--Link to an external stylesheet-->
<link rel="stylesheet" href="css/main.css">

<!--Container for tabbed content-->
<div class="tabs">
  <input type="radio" name="tabs" id="tabone" checked="checked">
  <label for="tabone">Register</label>
  
  <div class="tab">
    <h2>Register</h2>
    <form method="post" class="vertical-form">
    
    <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <input type="password" name="confirm_password" placeholder="Confirm Password" required>
           
            <select id="user_type" name="user_type" required>
            <option value="guest">Guest User</option>
            <option value="admin">Admin User</option>
          
        </select>
            <button type="submit">Register</button>
        </form>
            <p>Already have an account? <a href="../index.php">Login here</a></p>   
    
  </div>
</div>