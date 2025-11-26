<?php
require_once __DIR__ . '/init.php';
session_unset();
session_destroy();
session_start();
flash_set('success', 'Logged out');
header('Location: login.php');
exit;
