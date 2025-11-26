<?php
require_once __DIR__ . '/init.php';
require_role('student');
$user = current_user();

// List enrolled classes with attendance and grades
$stmt = $pdo->prepare('SELECT c.*, e.enrolled_at FROM enrollments e JOIN classes c ON e.class_id = c.id WHERE e.student_id = ? ORDER BY c.created_at DESC');
$stmt->execute([$user['id']]);
$classes = $stmt->fetchAll();

require_once 'header.php';
?>
<h2>My Classes</h2>
<?php if (empty($classes)): ?><p>No classes yet.</p><?php else: ?>
  <?php foreach ($classes as $c): ?>
    <div class="card">
      <h3><?=htmlspecialchars($c['title'])?> <small>(<?=htmlspecialchars($c['code'])?>)</small></h3>
      <p><strong>Schedule:</strong> <?=htmlspecialchars($c['schedule'])?></p>
      <p>
        <a class="btn small" href="class_view.php?id=<?=$c['id']?>">View</a>
      </p>
      <h4>Grades</h4>
      <?php $g = $pdo->prepare('SELECT grade,comment FROM grades WHERE class_id = ? AND student_id = ?'); $g->execute([$c['id'],$user['id']]); $grade = $g->fetch(); ?>
      <p><?= $grade ? htmlspecialchars($grade['grade']) . ' - ' . htmlspecialchars($grade['comment']) : 'No grade yet' ?></p>
      <h4>Attendance</h4>
      <?php $a = $pdo->prepare('SELECT attended_on,status FROM attendance WHERE class_id = ? AND student_id = ? ORDER BY attended_on DESC'); $a->execute([$c['id'],$user['id']]); $att = $a->fetchAll(); ?>
      <?php if (empty($att)): ?><p>No attendance records.</p><?php else: ?><ul><?php foreach($att as $r): ?><li><?=htmlspecialchars($r['attended_on'])?> - <?=htmlspecialchars($r['status'])?></li><?php endforeach; ?></ul><?php endif; ?>
    </div>
  <?php endforeach; ?>
<?php endif; ?>

<?php require_once 'footer.php'; ?>
