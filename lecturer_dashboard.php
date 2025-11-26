<?php
require_once __DIR__ . '/init.php';
require_role('lecturer');
$user = current_user();

// Fetch lecturer classes
$stmt = $pdo->prepare('SELECT * FROM classes WHERE lecturer_id = ? ORDER BY created_at DESC');
$stmt->execute([$user['id']]);
$classes = $stmt->fetchAll();

require_once 'header.php';
?>
<div class="row">
  <div class="col">
    <h2>Your Classes</h2>
  </div>
  <div class="col right">
    <a class="btn" href="create_class.php">Create Class</a>
  </div>
</div>

<?php if (empty($classes)): ?>
  <p>No classes yet. Use Create Class to add one.</p>
<?php else: ?>
  <div class="cards">
    <?php foreach ($classes as $c): ?>
      <div class="card">
        <h3><?=htmlspecialchars($c['title'])?> <small>(<?=htmlspecialchars($c['code'])?>)</small></h3>
        <p><?=htmlspecialchars($c['description'])?></p>
        <p><strong>Schedule:</strong> <?=htmlspecialchars($c['schedule'])?></p>
        <p>
          <a href="class_view.php?id=<?=$c['id']?>" class="btn small">View</a>
          <a href="class_view.php?id=<?=$c['id']?>&action=delete" class="btn small danger" onclick="return confirm('Delete this class?')">Delete</a>
        </p>
      </div>
    <?php endforeach; ?>
  </div>
<?php endif; ?>

<?php require_once 'footer.php'; ?>
