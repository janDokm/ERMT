<?php
session_start();
require __DIR__ . '/db.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  header('Location: login.php');
  exit;
}

$username = trim($_POST['username'] ?? '');
$password = $_POST['password'] ?? '';

if ($username === '' || $password === '') {
  $_SESSION['flash'] = 'Please enter both username and password.';
  header('Location: login.php');
  exit;
}

$stmt = $pdo->prepare('SELECT id, username, password_hash, role, is_active FROM users WHERE username = ? LIMIT 1');
$stmt->execute([$username]);
$user = $stmt->fetch();

if (!$user || !$user['is_active']) {
  $_SESSION['flash'] = 'Invalid credentials.';
  header('Location: login.php');
  exit;
}

if (!password_verify($password, $user['password_hash'])) {
  $_SESSION['flash'] = 'Invalid credentials.';
  header('Location: login.php');
  exit;
}

$_SESSION['user_id'] = (int)$user['id'];
$_SESSION['username'] = $user['username'];
$_SESSION['role'] = $user['role'];
$_SESSION['logged_in'] = true;

$pdo->prepare('UPDATE users SET last_login_at = NOW() WHERE id = ?')->execute([$user['id']]);

header('Location: ../Dashboard/dashboard.php');
exit;
