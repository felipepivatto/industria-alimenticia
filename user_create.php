<?php
require 'config.php';
$conn = db_connect();
$msg = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = trim($_POST['nome'] ?? '');
    $email = trim($_POST['email'] ?? '');
    if ($nome === '' || $email === '') {
        $msg = 'Preencha todos os campos.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $msg = 'E-mail inválido.';
    } else {
        $stmt = $conn->prepare('INSERT INTO users (nome,email) VALUES (?,?)');
        $stmt->bind_param('ss', $nome, $email);
        if ($stmt->execute()) {
            $msg = 'cadastro concluído com sucesso';
            // limpar campos
            $nome = '';
            $email = '';
        } else {
            $msg = 'Erro: ' . $stmt->error;
        }
    }
}
?>
<!doctype html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <title>Cadastrar usuário</title>
    <link rel="stylesheet" href="css/styles.css">
</head>

<body>
    <header>
        <h1>Cadastrar Usuário</h1>
        <nav><a href="index.php">Voltar</a></nav>
    </header>
    <main>
        <?php if ($msg): ?><div class="alert"><?= htmlspecialchars($msg) ?></div><?php endif; ?>
        <form method="post" action="" class="form">
            <label>Nome
                <input type="text" name="nome" required value="<?= htmlspecialchars($nome ?? '') ?>">
            </label>
            <label>E-mail
                <input type="email" name="email" required value="<?= htmlspecialchars($email ?? '') ?>">
            </label>
            <button type="submit">Cadastrar</button>
        </form>
    </main>
</body>

</html>