<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>e-RMT Login</title>
  <link rel="stylesheet" href="../CSS/login.css">
</head>
<body>
  <div class="login-container" role="main">
    <div class="login-header">
      <img src="../Assets/logo.png" alt="SKTPP Re-Logo" class="logo"/>
      <h2>E-RMT System</h2>
      <p>Please log in to continue</p>
    </div>

    <?php
      session_start();
      if (!empty($_SESSION['flash'])) {
        echo '<p style="color:crimson">'.htmlspecialchars($_SESSION['flash']).'</p>';
        unset($_SESSION['flash']);
      }
    ?>

    <form action="authenticate.php" method="POST"> 
      <div class="form-group">
        <label for="username">Username</label>
        <input type="text" id="username" name="username" required />
      </div>
      <div class="form-group">
        <label for="password">Password</label>
        <input type="password" id="password" name="password" required />
        <div class="forgot-password">
          <a href="#" onclick="alert('Password reset feature coming soon.')">Forgot Password?</a>
        </div>
      </div>
      <button type="submit" class="login-button">Login</button>
    </form>

    <div class="language-switch">
      <span>Choose Language:</span>
      <a href="#">English</a>|
      <a href="#">Malay</a>
    </div>
  </div>

  <footer class="page-footer">
    &copy; 2025 Cloud Munch
  </footer>
</body>
</html>
