<?php
// php Section
session_start();
if (empty($_SESSION['logged_in'])) {
  header('Location: login.php');
  exit;
}
?>

<!-- HTML Section -->
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>e-RMT Dashboard</title>
  <link rel="stylesheet" href="../CSS/dashboard.css">
</head>
<body>
  <aside class="sidebar">
    <h2>e-RMT</h2>
    <ul>
      <li><a href="view_students.php">Student Data</a></li>
    </ul>
  </aside>

  <main class="main-content">
    <div>
      <h1>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?></h1>
    </div>
  </main>
</body>
</html>
