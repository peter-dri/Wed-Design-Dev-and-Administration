<?php
require_once __DIR__ . '/init.php';
require_role('lecturer');
$user = current_user();
if ($_SERVER['REQUEST_METHOD'] !== 'POST') { header('Location: lecturer_dashboard.php'); exit; }
$class_id = intval($_POST['class_id'] ?? 0);
$student_id = intval($_POST['student_id'] ?? 0);
$attended_on = $_POST['attended_on'] ?? date('Y-m-d');
$status = $_POST['status'] ?? 'present';
if (!$class_id || !$student_id) { flash_set('error','Missing data'); header('Location: lecturer_dashboard.php'); exit; }

// Verify ownership
$q = $pdo->prepare('SELECT lecturer_id FROM classes WHERE id = ?'); $q->execute([$class_id]); $c = $q->fetch();
if (!$c || $c['lecturer_id'] != $user['id']) { flash_set('error','Not authorized'); header('Location: lecturer_dashboard.php'); exit; }

$stmt = $pdo->prepare('INSERT INTO attendance (class_id, student_id, attended_on, status) VALUES (?,?,?,?)');
$stmt->execute([$class_id, $student_id, $attended_on, $status]);
flash_set('success','Attendance recorded');
header('Location: class_view.php?id='.$class_id);
exit;
