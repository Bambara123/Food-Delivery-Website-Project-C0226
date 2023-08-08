<!DOCTYPE html>
<html>
<head>

  <link rel="stylesheet" type="text/css" href="shop_reg.css">

</head>
<body>

 
  <header>
    <h1>Register Your Shop</h1>
  </header>

  
  <?php
    if (isset($_GET['value'])) {
        $printedValue = $_GET['value']; // Retrieve the value from the query parameter
    } else {
        $printedValue = "";
    }
    ?>


  <div id="content">
    <section>
      <form id="registration-form" action="http://localhost/project/shop_reg.php" method="POST">
        <div class="form-group">
          <label for="name">Shop Name:</label>
          <input type="text" id="shopname" name="shopname" value="<?php echo $printedValue; ?>" required>
        </div>
        <div class="form-group">
          <label for="email">Email:</label>
          <input type="email" id="email" name="email" required>
        </div>
        <div class="form-group">
          <label for="password">Password:</label>
          <input type="password" id="password" name="password" required>
        </div>
        <div class="form-group">
          <button type="submit">Create Account</button>
        </div>
      </form>
    </section>
  </div>
</body>
</html>
