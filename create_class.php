<?php
require_once __DIR__ . '/init.php';
require_role('lecturer');
$user = current_user();

$error = null;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $code = trim($_POST['code'] ?? '');
    $title = trim($_POST['title'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $schedule = trim($_POST['schedule'] ?? '');
    if (!$code || !$title) {
        $error = 'Code and title are required';
    } else {
        $stmt = $pdo->prepare('INSERT INTO classes (lecturer_id, code, title, description, schedule) VALUES (?,?,?,?,?)');
        $stmt->execute([$user['id'], $code, $title, $description, $schedule]);
        flash_set('success','Class created');
        header('Location: lecturer_dashboard.php');
        exit;
    }
}

require_once 'header.php';
?>
<h2>Create Class</h2>
<form method="post" class="card form-card">
  <label>Code
    <input name="code" required>
  </label>
  <label>Title
    <input name="title" required>
  </label>
  <label>Schedule
    <input name="schedule">
  </label>
  <label>Description
    <textarea name="description"></textarea>
  </label>
  <div>
    <button class="btn" type="submit">Create</button>
    <a class="btn" href="lecturer_dashboard.php">Cancel</a>
  </div>
  <?php if ($error): ?><div class="error"><?=htmlspecialchars($error)?></div><?php endif; ?>
</form>

<?php require_once 'footer.php'; ?>
