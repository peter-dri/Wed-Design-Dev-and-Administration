<?php
require_once __DIR__ . '/init.php';
require_role('student');
$user = current_user();
if ($_SERVER['REQUEST_METHOD'] !== 'POST') { header('Location: classes.php'); exit; }
$class_id = intval($_POST['class_id'] ?? 0);
if (!$class_id) { flash_set('error','Missing class'); header('Location: classes.php'); exit; }

try {
    $stmt = $pdo->prepare('INSERT INTO enrollments (class_id, student_id) VALUES (?,?)');
    $stmt->execute([$class_id, $user['id']]);
    flash_set('success','Enrolled successfully');
} catch (Exception $e) {
    flash_set('error','Already enrolled or error');
}
header('Location: my_classes.php');
exit;
