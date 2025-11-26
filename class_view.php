<?php
require_once __DIR__ . '/init.php';
require_login();
$user = current_user();

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
if (!$id) { header('Location: index.php'); exit; }

// Fetch class
$stmt = $pdo->prepare('SELECT c.*, u.full_name AS lecturer_name FROM classes c JOIN users u ON c.lecturer_id = u.id WHERE c.id = ?');
$stmt->execute([$id]);
$class = $stmt->fetch();
if (!$class) { flash_set('error','Class not found'); header('Location: index.php'); exit; }

// Delete class (only lecturer)
if (isset($_GET['action']) && $_GET['action'] === 'delete') {
    if ($user['role'] !== 'lecturer' || $user['id'] != $class['lecturer_id']) {
        flash_set('error','Not allowed');
        header('Location: index.php'); exit;
    }
    $d = $pdo->prepare('DELETE FROM classes WHERE id = ?');
    $d->execute([$id]);
    flash_set('success','Class deleted');
    header('Location: lecturer_dashboard.php'); exit;
}

// Enrolled students
$s = $pdo->prepare('SELECT u.id,u.username,u.full_name,e.enrolled_at FROM enrollments e JOIN users u ON e.student_id = u.id WHERE e.class_id = ?');
$s->execute([$id]);
$students = $s->fetchAll();

require_once 'header.php';
?>
<h2><?=htmlspecialchars($class['title'])?> <small>(<?=htmlspecialchars($class['code'])?>)</small></h2>
<p><strong>Lecturer:</strong> <?=htmlspecialchars($class['lecturer_name'])?></p>
<p><strong>Schedule:</strong> <?=htmlspecialchars($class['schedule'])?></p>
<p><?=nl2br(htmlspecialchars($class['description']))?></p>

<?php if ($user['role'] === 'lecturer' && $user['id'] == $class['lecturer_id']): ?>
  <h3>Enrolled Students</h3>
  <?php if (empty($students)): ?><p>No students enrolled yet.</p><?php else: ?>
    <table class="table">
      <thead><tr><th>Student</th><th>Enrolled</th><th>Actions</th></tr></thead>
      <tbody>
        <?php foreach ($students as $st): ?>
          <tr>
            <td><?=htmlspecialchars($st['full_name'] ?? $st['username'])?></td>
            <td><?=htmlspecialchars($st['enrolled_at'])?></td>
            <td>
              <form action="assign_grade.php" method="post" style="display:inline">
                <input type="hidden" name="class_id" value="<?=$id?>">
                <input type="hidden" name="student_id" value="<?=$st['id']?>">
                <input name="grade" placeholder="Grade">
                <button class="btn small" type="submit">Assign</button>
              </form>
              <form action="attendance.php" method="post" style="display:inline">
                <input type="hidden" name="class_id" value="<?=$id?>">
                <input type="hidden" name="student_id" value="<?=$st['id']?>">
                <input type="date" name="attended_on" required value="<?=date('Y-m-d')?>">
                <select name="status"><option value="present">Present</option><option value="absent">Absent</option><option value="excused">Excused</option></select>
                <button class="btn small">Mark</button>
              </form>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  <?php endif; ?>
<?php else: ?>
  <p>Students enrolled:</p>
  <ul>
    <?php foreach ($students as $st): ?><li><?=htmlspecialchars($st['full_name'] ?? $st['username'])?></li><?php endforeach; ?>
  </ul>
  <?php if ($user['role'] === 'student'): ?>
    <?php // check if enrolled ?>
    <?php $q = $pdo->prepare('SELECT id FROM enrollments WHERE class_id = ? AND student_id = ?'); $q->execute([$id,$user['id']]); $en = $q->fetch(); ?>
    <?php if ($en): ?>
      <p>You are enrolled in this class.</p>
    <?php else: ?>
      <form method="post" action="enroll.php"><input type="hidden" name="class_id" value="<?=$id?>"><button class="btn" type="submit">Enroll</button></form>
    <?php endif; ?>
  <?php endif; ?>
<?php endif; ?>

<?php require_once 'footer.php'; ?>
