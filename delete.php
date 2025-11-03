<?php
require 'config.php';
$conn = db_connect();
if (!isset($_GET['id'])) {
    header('Location: index.php');
    exit;
}
$id = intval($_GET['id']);
$stmt = $conn->prepare('DELETE FROM tasks WHERE id=?');
$stmt->bind_param('i', $id);
$stmt->execute();
header('Location: index.php');
exit;
