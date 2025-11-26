<?php
// Simple seed script to create sample users and a sample class.
require_once __DIR__ . '/init.php';

try {
    // Create sample lecturer
    $pw = password_hash('lecturerpass', PASSWORD_DEFAULT);
    $stmt = $pdo->prepare('INSERT IGNORE INTO users (username,password,full_name,role) VALUES (?,?,?,?)');
    $stmt->execute(['lecturer1', $pw, 'Dr. Alice Lecturer', 'lecturer']);

    // Create sample student
    $pw2 = password_hash('studentpass', PASSWORD_DEFAULT);
    $stmt->execute(['student1', $pw2, 'Bob Student', 'student']);

    // Create class if lecturer exists
    $lecturer = $pdo->prepare('SELECT id FROM users WHERE username = ?');
    $lecturer->execute(['lecturer1']);
    $l = $lecturer->fetch();
    if ($l) {
        $stmt = $pdo->prepare('INSERT IGNORE INTO classes (lecturer_id, code, title, description, schedule) VALUES (?,?,?,?,?)');
        $stmt->execute([$l['id'], 'CS101', 'Intro to Computer Science', 'Basic course', 'Mon/Wed 10:00-11:30']);
    }

    echo "Seeding complete. Users: lecturer1/lecturerpass, student1/studentpass\n";
} catch (Exception $e) {
    echo 'Seed error: ' . $e->getMessage();
}
