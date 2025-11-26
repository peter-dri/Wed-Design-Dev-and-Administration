<?php
require_once __DIR__ . '/init.php';
require_login();
$user = current_user();

// List all classes
$stmt = $pdo->query('SELECT c.*, u.full_name AS lecturer_name FROM classes c JOIN users u ON c.lecturer_id = u.id ORDER BY c.created_at DESC');
$classes = $stmt->fetchAll();

require_once 'header.php';
?>
<h2>Available Classes</h2>
<?php if (empty($classes)): ?>
  <p>No classes available.</p>
<?php else: ?>
  <div class="cards">
    <?php foreach ($classes as $c): ?>
      <div class="card">
        <h3><?=htmlspecialchars($c['title'])?> <small>(<?=htmlspecialchars($c['code'])?>)</small></h3>
        <p><?=htmlspecialchars($c['description'])?></p>
        <p><strong>Lecturer:</strong> <?=htmlspecialchars($c['lecturer_name'])?></p>
        <p><strong>Schedule:</strong> <?=htmlspecialchars($c['schedule'])?></p>
        <p>
          <a class="btn small" href="class_view.php?id=<?=$c['id']?>">View</a>
          <?php if ($user['role'] === 'student'): ?>
            <form action="enroll.php" method="post" style="display:inline">
              <input type="hidden" name="class_id" value="<?=$c['id']?>">
              <button class="btn small">Enroll</button>
            </form>
          <?php endif; ?>
        </p>
      </div>
    <?php endforeach; ?>
  </div>
<?php endif; ?>

<?php require_once 'footer.php'; ?>
