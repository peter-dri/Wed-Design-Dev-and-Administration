<?php
require_once __DIR__ . '/init.php';
$user = current_user();
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Class Management</title>
  <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
<header class="site-header">
  <div class="container">
    <div class="brand">
      <span class="logo" aria-hidden="true"></span>
      <a href="index.php">Class Management</a>
    </div>
    <nav aria-label="Main Navigation">
      <?php if ($user): ?>
        <span class="nav-item">Hello, <?=htmlspecialchars($user['full_name'] ?? $user['username'])?></span>
        <?php if ($user['role'] === 'lecturer'): ?>
          <a class="nav-item" href="lecturer_dashboard.php">Dashboard</a>
        <?php else: ?>
          <a class="nav-item" href="student_dashboard.php">Dashboard</a>
        <?php endif; ?>
        <a class="nav-item" href="classes.php">Classes</a>
        <a class="nav-item" href="logout.php">Logout</a>
      <?php else: ?>
        <a class="nav-item" href="login.php">Login</a>
      <?php endif; ?>
    </nav>
  </div>
</header>
<main class="container">
<?php $flash = flash_get(); if ($flash): ?>
  <div class="flash <?=htmlspecialchars($flash['type'])?>"><?=htmlspecialchars($flash['message'])?></div>
<?php endif; ?>
