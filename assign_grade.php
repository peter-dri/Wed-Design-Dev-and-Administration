<?php
require_once __DIR__ . '/init.php';
require_role('lecturer');
$user = current_user();
if ($_SERVER['REQUEST_METHOD'] !== 'POST') { header('Location: lecturer_dashboard.php'); exit; }
$class_id = intval($_POST['class_id'] ?? 0);
$student_id = intval($_POST['student_id'] ?? 0);
$grade = trim($_POST['grade'] ?? '');
if (!$class_id || !$student_id) { flash_set('error','Missing data'); header('Location: lecturer_dashboard.php'); exit; }

// Ensure lecturer owns the class
$q = $pdo->prepare('SELECT lecturer_id FROM classes WHERE id = ?'); $q->execute([$class_id]); $c = $q->fetch();
if (!$c || $c['lecturer_id'] != $user['id']) { flash_set('error','Not authorized'); header('Location: lecturer_dashboard.php'); exit; }

// Upsert grade
$stmt = $pdo->prepare('INSERT INTO grades (class_id, student_id, grade) VALUES (?,?,?) ON DUPLICATE KEY UPDATE grade = VALUES(grade), recorded_at = CURRENT_TIMESTAMP');
$stmt->execute([$class_id, $student_id, $grade]);
flash_set('success','Grade assigned');
header('Location: class_view.php?id='.$class_id);
exit;
