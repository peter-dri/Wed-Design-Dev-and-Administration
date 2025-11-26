<?php
// Database configuration - defaults can be overridden via environment variables
define('DB_DRIVER', getenv('DB_DRIVER') ?: 'mysql'); // 'mysql' or 'sqlite'
define('DB_HOST', getenv('DB_HOST') ?: '127.0.0.1');
define('DB_NAME', getenv('DB_NAME') ?: 'class_management');
define('DB_USER', getenv('DB_USER') ?: 'root');
define('DB_PASS', getenv('DB_PASS') ?: '');
define('SQLITE_PATH', getenv('SQLITE_PATH') ?: __DIR__ . '/data/database.sqlite');

// Base URL (optional) - set if you serve from a subfolder
define('BASE_URL', getenv('BASE_URL') ?: '');

// Common settings
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Create PDO connection
try {
	if (DB_DRIVER === 'sqlite') {
		$dsn = 'sqlite:' . SQLITE_PATH;
		$pdo = new PDO($dsn);
	} else {
		$dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8mb4';
		$pdo = new PDO($dsn, DB_USER, DB_PASS);
	}
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch (Exception $e) {
	http_response_code(500);
	echo 'Database connection error: ' . htmlspecialchars($e->getMessage());
	exit;
}

?>
