<?php
require 'config.php';
$conn = db_connect();
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php');
    exit;
}
$id = intval($_POST['id'] ?? 0);
$status = $_POST['status'] ?? 'a fazer';
$allowed = ['a fazer', 'fazendo', 'pronto'];
if (!in_array($status, $allowed)) $status = 'a fazer';
$stmt = $conn->prepare('UPDATE tasks SET status=? WHERE id=?');
$stmt->bind_param('si', $status, $id);
$stmt->execute();
header('Location: index.php');
exit;
