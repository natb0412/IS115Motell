<link rel="stylesheet" href="site/css/main.css">
<div class="tabs">
  <input type="radio" name="tabs" id="tabone" checked="checked">
  <label for="tabone">Tab One</label>
  <div class="tab"> 
    <h2>Booking</h2>
    <form method="POST">
    Navn: <input type="text" name="navn" value="<?php echo $navn; ?>"><br><br>
    Mobilnummer: <input type="text" name="mobil" value="<?php echo $mobil; ?>"><br><br>
    E-post: <input type="text" name="epost" value="<?php echo $epost; ?>"><br><br>
    <input type="submit" value="Registrer">
</form>
  </div>
  
  <input type="radio" name="tabs" id="tabtwo">
  <label for="tabtwo">Tab Two</label>
  <div class="tab">
    <h2>Tab Two Content</h2>
    <p>Lorem </p>
  </div>
  
  <input type="radio" name="tabs" id="tabthree">
  <label for="tabthree">Tab Three</label>
  <div class="tab">
    <h2>Tab Three Content</h2>
    <p>Lorem ipsum </p>
  </div>
</div>