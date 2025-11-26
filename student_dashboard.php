<?php
require_once __DIR__ . '/init.php';
require_role('student');
$user = current_user();

// Fetch enrolled classes
$stmt = $pdo->prepare('SELECT c.*, e.enrolled_at FROM enrollments e JOIN classes c ON e.class_id = c.id WHERE e.student_id = ? ORDER BY c.created_at DESC');
$stmt->execute([$user['id']]);
$classes = $stmt->fetchAll();

require_once 'header.php';
?>
<h2>Your Enrolled Classes</h2>
<?php if (empty($classes)): ?>
  <p>You are not enrolled in any classes. Browse <a href="classes.php">available classes</a>.</p>
<?php else: ?>
  <div class="cards">
    <?php foreach ($classes as $c): ?>
      <div class="card">
        <h3><?=htmlspecialchars($c['title'])?> <small>(<?=htmlspecialchars($c['code'])?>)</small></h3>
        <p><strong>Enrolled:</strong> <?=htmlspecialchars($c['enrolled_at'])?></p>
        <p><a class="btn small" href="class_view.php?id=<?=$c['id']?>">View</a></p>
      </div>
    <?php endforeach; ?>
  </div>
<?php endif; ?>

<?php require_once 'footer.php'; ?>
