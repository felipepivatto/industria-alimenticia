<?php
require 'config.php';
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}
if (!isset($_GET['id'])) {
    header('Location: index.php');
    exit;
}
$id = intval($_GET['id']);
$conn = db_connect();
$stmt = $conn->prepare('DELETE FROM tasks WHERE id=? AND user_id=?');
$stmt->bind_param('ii', $id, $_SESSION['user_id']);
$stmt->execute();
header('Location: index.php');
exit;
