<?php
require_once __DIR__ . '/init.php';
if (is_logged_in()) {
    $u = current_user();
    if ($u['role'] === 'lecturer') header('Location: lecturer_dashboard.php');
    else header('Location: student_dashboard.php');
    exit;
}
header('Location: login.php');
exit;
