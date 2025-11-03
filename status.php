<?php
require 'config.php';
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php');
    exit;
}
$id = intval($_POST['id'] ?? 0);
$status = $_POST['status'] ?? 'a fazer';
$allowed = ['a fazer', 'fazendo', 'pronto'];
if (!in_array($status, $allowed)) $status = 'a fazer';
$conn = db_connect();
$stmt = $conn->prepare('UPDATE tasks SET status=? WHERE id=? AND user_id=?');
$stmt->bind_param('sii', $status, $id, $_SESSION['user_id']);
$stmt->execute();
header('Location: index.php');
exit;
