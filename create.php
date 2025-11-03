<?php
require 'config.php';
$conn = db_connect();
$msg = '';

$users = [];
$res = $conn->query("SELECT id,nome FROM users ORDER BY nome");
while ($r = $res->fetch_assoc()) $users[$r['id']] = $r['nome'];

$id = $_GET['id'] ?? null;
$editing = false;
$data = ['user_id' => '', 'descricao' => '', 'setor' => '', 'prioridade' => 'baixa'];
if ($id) {
    $editing = true;
    $stmt = $conn->prepare('SELECT * FROM tasks WHERE id=?');
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $res = $stmt->get_result();
    $row = $res->fetch_assoc();
    if ($row) $data = $row;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_POST['user_id'] ?? '';
    $descricao = trim($_POST['descricao'] ?? '');
    $setor = trim($_POST['setor'] ?? '');
    $prioridade = $_POST['prioridade'] ?? 'baixa';
    if ($user_id === '' || $descricao === '' || $setor === '') $msg = 'Preencha todos os campos.';
    else {
        if ($editing) {
            $stmt = $conn->prepare('UPDATE tasks SET user_id=?, descricao=?, setor=?, prioridade=? WHERE id=?');
            $stmt->bind_param('isssi', $user_id, $descricao, $setor, $prioridade, $id);
            if ($stmt->execute()) {
                $msg = 'cadastro concluído com sucesso';
                header('Location: index.php');
                exit;
            } else $msg = 'Erro: ' . $stmt->error;
        } else {
            $stmt = $conn->prepare('INSERT INTO tasks (user_id,descricao,setor,prioridade) VALUES (?,?,?,?)');
            $stmt->bind_param('isss', $user_id, $descricao, $setor, $prioridade);
            if ($stmt->execute()) {
                $msg = 'cadastro concluído com sucesso';
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
        <form method="post" action="" class="form">
            <label>Usuário
                <select name="user_id" required>
                    <option value="">-- selecione --</option>
                    <?php foreach ($users as $uid => $uname): ?>
                        <option value="<?= $uid ?>" <?= ($data['user_id'] == $uid) ? 'selected' : '' ?>><?= htmlspecialchars($uname) ?></option>
                    <?php endforeach; ?>
                </select>
            </label>
            <label>Descrição
                <textarea name="descricao" required><?= htmlspecialchars($data['descricao'] ?? '') ?></textarea>
            </label>
            <label>Setor
                <input type="text" name="setor" required value="<?= htmlspecialchars($data['setor'] ?? '') ?>">
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
    </main>
</body>

</html>