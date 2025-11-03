<?php
require 'config.php';
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}
$conn = db_connect();
$msg = '';
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$editing = false;
$data = ['descricao' => '', 'setor' => '', 'prioridade' => 'baixa'];
if ($id) {
    $editing = true;
    $stmt = $conn->prepare('SELECT * FROM tasks WHERE id=? AND user_id=? LIMIT 1');
    $stmt->bind_param('ii', $id, $_SESSION['user_id']);
    $stmt->execute();
    $res = $stmt->get_result();
    if ($row = $res->fetch_assoc()) $data = $row;
    else {
        header('Location: index.php');
        exit;
    }
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $descricao = trim($_POST['descricao'] ?? '');
    $setor = trim($_POST['setor'] ?? '');
    $prioridade = $_POST['prioridade'] ?? 'baixa';
    if ($descricao === '' || $setor === '') $msg = 'Preencha todos os campos.';
    else {
        if ($editing) {
            $stmt = $conn->prepare('UPDATE tasks SET descricao=?, setor=?, prioridade=? WHERE id=? AND user_id=?');
            $stmt->bind_param('sssii', $descricao, $setor, $prioridade, $id, $_SESSION['user_id']);
            if ($stmt->execute()) {
                header('Location: index.php');
                exit;
            } else $msg = 'Erro: ' . $stmt->error;
        } else {
            $stmt = $conn->prepare('INSERT INTO tasks (user_id,descricao,setor,prioridade) VALUES (?,?,?,?)');
            $stmt->bind_param('isss', $_SESSION['user_id'], $descricao, $setor, $prioridade);
            if ($stmt->execute()) {
                header('Location: index.php');
                exit;
            } else $msg = 'Erro: ' . $stmt->error;
        }
    }
}
?>
<!doctype html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <title><?= $editing ? 'Editar' : 'Cadastrar' ?> Tarefa</title>
    <link rel="stylesheet" href="css/styles.css">
</head>

<body>
    <header>
        <h1><?= $editing ? 'Editar' : 'Cadastrar' ?> Tarefa</h1>
        <nav><a href="index.php">Voltar</a></nav>
    </header>
    <main>
        <?php if ($msg): ?><div class="alert"><?= htmlspecialchars($msg) ?></div><?php endif; ?>
        <form method="post" action="" class="form" id="taskForm">
            <label>Descrição
                <textarea name="descricao" id="descricao" required><?= htmlspecialchars($data['descricao'] ?? '') ?></textarea>
            </label>
            <button type="button" id="suggestBtn">Sugerir descrição (API)</button>
            <label>Setor
                <input type="text" name="setor" id="setor" required value="<?= htmlspecialchars($data['setor'] ?? '') ?>">
            </label>
            <label>Prioridade
                <select name="prioridade" required>
                    <option value="baixa" <?= ($data['prioridade'] == 'baixa') ? 'selected' : '' ?>>Baixa</option>
                    <option value="media" <?= ($data['prioridade'] == 'media') ? 'selected' : '' ?>>Média</option>
                    <option value="alta" <?= ($data['prioridade'] == 'alta') ? 'selected' : '' ?>>Alta</option>
                </select>
            </label>
            <button type="submit"><?= $editing ? 'Atualizar' : 'Cadastrar' ?></button>
        </form>
        <script src="js/api_fetch.js"></script>
    </main>
</body>

</html>