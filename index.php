<?php
require 'config.php';
$conn = db_connect();

$users = [];
$res = $conn->query("SELECT id, nome FROM users ORDER BY nome");
while ($r = $res->fetch_assoc()) $users[$r['id']] = $r['nome'];

$tasks = ['a fazer' => [], 'fazendo' => [], 'pronto' => []];
$res = $conn->query("SELECT t.*, u.nome as usuario FROM tasks t JOIN users u ON u.id = t.user_id ORDER BY t.data_cadastro DESC");
while ($r = $res->fetch_assoc()) {
    $tasks[$r['status']][] = $r;
}
?>
<!doctype html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Industria Alimentícia</title>
    <link rel="stylesheet" href="css/styles.css">
</head>

<body>
    <header>
        <h1>Industria Alimentícia</h1>
        <nav>
            <a href="user_create.php">Cadastrar usuário</a> |
            <a href="create.php">Cadastrar tarefa</a>
        </nav>
    </header>
    <main>
        <div class="board">
            <?php foreach (['a fazer' => 'A Fazer', 'fazendo' => 'Fazendo', 'pronto' => 'Pronto'] as $key => $label): ?>
                <section class="column">
                    <h2><?= htmlspecialchars($label) ?></h2>
                    <?php if (count($tasks[$key]) == 0): ?>
                        <div class="empty">Nenhuma tarefa</div>
                    <?php endif; ?>
                    <?php foreach ($tasks[$key] as $t): ?>
                        <article class="card">
                            <p class="desc"><?= nl2br(htmlspecialchars($t['descricao'])) ?></p>
                            <p><strong>Setor:</strong> <?= htmlspecialchars($t['setor']) ?></p>
                            <p><strong>Prioridade:</strong> <?= htmlspecialchars($t['prioridade']) ?></p>
                            <p><strong>Usuário:</strong> <?= htmlspecialchars($t['usuario']) ?></p>
                            <div class="card-actions">
                                <a class="btn" href="create.php?id=<?= $t['id'] ?>">Editar</a>
                                <a class="btn btn-danger" href="delete.php?id=<?= $t['id'] ?>" onclick="return confirm('Confirma exclusão?')">Excluir</a>
                            </div>
                            <form method="post" action="status.php" class="status-form">
                                <input type="hidden" name="id" value="<?= $t['id'] ?>">
                                <select name="status">
                                    <option value="a fazer" <?= $t['status'] == 'a fazer' ? 'selected' : '' ?>>A fazer</option>
                                    <option value="fazendo" <?= $t['status'] == 'fazendo' ? 'selected' : '' ?>>Fazendo</option>
                                    <option value="pronto" <?= $t['status'] == 'pronto' ? 'selected' : '' ?>>Pronto</option>
                                </select>
                                <button type="submit">Alterar status</button>
                            </form>
                        </article>
                    <?php endforeach; ?>
                </section>
            <?php endforeach; ?>
        </div>
    </main>
    <footer>
    </footer>
</body>

</html>