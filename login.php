<?php
require_once __DIR__ . '/init.php';
if (is_logged_in()) {
    header('Location: index.php');
    exit;
}

$error = null;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    if (!$username || !$password) {
        $error = 'Provide username and password';
    } else {
          $stmt = $pdo->prepare('SELECT * FROM users WHERE username = ? LIMIT 1');
          $stmt->execute([$username]);
          $user = $stmt->fetch();
          if ($user) {
            $stored = $user['password'];
            $ok = false;
            if (password_verify($password, $stored)) {
              $ok = true;
            } elseif ($stored === $password) {
              // seeded plaintext password: accept and upgrade to hashed value
              $newHash = password_hash($password, PASSWORD_DEFAULT);
              $u = $pdo->prepare('UPDATE users SET password = ? WHERE id = ?');
              $u->execute([$newHash, $user['id']]);
              $ok = true;
            }

            if ($ok) {
              $_SESSION['user_id'] = $user['id'];
              flash_set('success', 'Logged in successfully');
              header('Location: index.php');
              exit;
            } else {
              $error = 'Invalid credentials';
            }
          } else {
            $error = 'Invalid credentials';
          }
    }
}
require_once 'header.php';
?>
<h2>Login</h2>
<form method="post" class="card form-card">
  <label>Username
    <input type="text" name="username" required>
  </label>
  <label>Password
    <input type="password" name="password" required>
  </label>
  <div>
    <button type="submit" class="btn">Login</button>
  </div>
  <?php if ($error): ?>
    <div class="error"><?=htmlspecialchars($error)?></div>
  <?php endif; ?>
</form>
<?php require_once 'footer.php'; ?>
