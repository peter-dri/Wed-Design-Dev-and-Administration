<?php
// Initialize a SQLite database for quick demo runs (Gitpod-friendly)
$dir = __DIR__ . '/data';
if (!is_dir($dir)) mkdir($dir, 0755, true);
$dbFile = $dir . '/database.sqlite';
if (file_exists($dbFile)) {
    echo "SQLite DB already exists at $dbFile\n";
    exit(0);
}

$pdo = new PDO('sqlite:' . $dbFile);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$schema = <<<'SQL'
PRAGMA foreign_keys = ON;
CREATE TABLE users (
  id INTEGER PRIMARY KEY AUTOINCREMENT,
  username TEXT NOT NULL UNIQUE,
  password TEXT NOT NULL,
  full_name TEXT,
  role TEXT NOT NULL,
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);
CREATE TABLE classes (
  id INTEGER PRIMARY KEY AUTOINCREMENT,
  lecturer_id INTEGER NOT NULL,
  code TEXT NOT NULL,
  title TEXT NOT NULL,
  description TEXT,
  schedule TEXT,
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (lecturer_id) REFERENCES users(id) ON DELETE CASCADE
);
CREATE TABLE enrollments (
  id INTEGER PRIMARY KEY AUTOINCREMENT,
  class_id INTEGER NOT NULL,
  student_id INTEGER NOT NULL,
  enrolled_at DATETIME DEFAULT CURRENT_TIMESTAMP,
  UNIQUE (class_id, student_id),
  FOREIGN KEY (class_id) REFERENCES classes(id) ON DELETE CASCADE,
  FOREIGN KEY (student_id) REFERENCES users(id) ON DELETE CASCADE
);
CREATE TABLE attendance (
  id INTEGER PRIMARY KEY AUTOINCREMENT,
  class_id INTEGER NOT NULL,
  student_id INTEGER NOT NULL,
  attended_on DATE NOT NULL,
  status TEXT DEFAULT 'present',
  recorded_at DATETIME DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (class_id) REFERENCES classes(id) ON DELETE CASCADE,
  FOREIGN KEY (student_id) REFERENCES users(id) ON DELETE CASCADE
);
CREATE TABLE grades (
  id INTEGER PRIMARY KEY AUTOINCREMENT,
  class_id INTEGER NOT NULL,
  student_id INTEGER NOT NULL,
  grade TEXT,
  comment TEXT,
  recorded_at DATETIME DEFAULT CURRENT_TIMESTAMP,
  UNIQUE (class_id, student_id),
  FOREIGN KEY (class_id) REFERENCES classes(id) ON DELETE CASCADE,
  FOREIGN KEY (student_id) REFERENCES users(id) ON DELETE CASCADE
);
SQL;

$pdo->exec($schema);

// Seed demo users and a class (passwords hashed)
$pw1 = password_hash('lecturerpass', PASSWORD_DEFAULT);
$pw2 = password_hash('studentpass', PASSWORD_DEFAULT);
$stmt = $pdo->prepare('INSERT INTO users (username,password,full_name,role) VALUES (?,?,?,?)');
$stmt->execute(['lecturer1', $pw1, 'Dr. Alice Lecturer', 'lecturer']);
$stmt->execute(['student1', $pw2, 'Bob Student', 'student']);

$lecturerId = $pdo->lastInsertId();

$stmt = $pdo->prepare('INSERT INTO classes (lecturer_id, code, title, description, schedule) VALUES (?,?,?,?,?)');
$stmt->execute([$lecturerId, 'CS101', 'Intro to Computer Science', 'Basic course', 'Mon/Wed 10:00-11:30']);

echo "Initialized SQLite DB at $dbFile with demo users (lecturer1/student1).\n";
<?php
// Initialize a SQLite database for quick demo runs (Gitpod-friendly)
$dir = __DIR__ . '/data';
if (!is_dir($dir)) mkdir($dir, 0755, true);
$dbFile = $dir . '/database.sqlite';
if (file_exists($dbFile)) {
    echo "SQLite DB already exists at $dbFile\n";
    exit(0);
}

$pdo = new PDO('sqlite:' . $dbFile);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$schema = <<<'SQL'
PRAGMA foreign_keys = ON;
CREATE TABLE users (
  id INTEGER PRIMARY KEY AUTOINCREMENT,
  username TEXT NOT NULL UNIQUE,
  password TEXT NOT NULL,
  full_name TEXT,
  role TEXT NOT NULL,
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);
CREATE TABLE classes (
  id INTEGER PRIMARY KEY AUTOINCREMENT,
  lecturer_id INTEGER NOT NULL,
  code TEXT NOT NULL,
  title TEXT NOT NULL,
  description TEXT,
  schedule TEXT,
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (lecturer_id) REFERENCES users(id) ON DELETE CASCADE
);
CREATE TABLE enrollments (
  id INTEGER PRIMARY KEY AUTOINCREMENT,
  class_id INTEGER NOT NULL,
  student_id INTEGER NOT NULL,
  enrolled_at DATETIME DEFAULT CURRENT_TIMESTAMP,
  UNIQUE (class_id, student_id),
  FOREIGN KEY (class_id) REFERENCES classes(id) ON DELETE CASCADE,
  FOREIGN KEY (student_id) REFERENCES users(id) ON DELETE CASCADE
);
CREATE TABLE attendance (
  id INTEGER PRIMARY KEY AUTOINCREMENT,
  class_id INTEGER NOT NULL,
  student_id INTEGER NOT NULL,
  attended_on DATE NOT NULL,
  status TEXT DEFAULT 'present',
  recorded_at DATETIME DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (class_id) REFERENCES classes(id) ON DELETE CASCADE,
  FOREIGN KEY (student_id) REFERENCES users(id) ON DELETE CASCADE
);
CREATE TABLE grades (
  id INTEGER PRIMARY KEY AUTOINCREMENT,
  class_id INTEGER NOT NULL,
  student_id INTEGER NOT NULL,
  grade TEXT,
  comment TEXT,
  recorded_at DATETIME DEFAULT CURRENT_TIMESTAMP,
  UNIQUE (class_id, student_id),
  FOREIGN KEY (class_id) REFERENCES classes(id) ON DELETE CASCADE,
  FOREIGN KEY (student_id) REFERENCES users(id) ON DELETE CASCADE
);
SQL;

$pdo->exec($schema);

// Seed demo users and a class (passwords hashed)
$pw1 = password_hash('lecturerpass', PASSWORD_DEFAULT);
$pw2 = password_hash('studentpass', PASSWORD_DEFAULT);
$stmt = $pdo->prepare('INSERT INTO users (username,password,full_name,role) VALUES (?,?,?,?)');
$stmt->execute(['lecturer1', $pw1, 'Dr. Alice Lecturer', 'lecturer']);
$stmt->execute(['student1', $pw2, 'Bob Student', 'student']);

$lecturerId = $pdo->lastInsertId();

$stmt = $pdo->prepare('INSERT INTO classes (lecturer_id, code, title, description, schedule) VALUES (?,?,?,?,?)');
$stmt->execute([$lecturerId, 'CS101', 'Intro to Computer Science', 'Basic course', 'Mon/Wed 10:00-11:30']);

echo "Initialized SQLite DB at $dbFile with demo users (lecturer1/student1).\n";
