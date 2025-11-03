<?php
require 'config.php';
session_start();
if (isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit;
}
$msg = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $senha = $_POST['senha'] ?? '';
    if ($email === '' || $senha === '') $msg = 'Preencha todos os campos.';
    else {
        $conn = db_connect();
        $stmt = $conn->prepare('SELECT id, nome, senha FROM users WHERE email=? LIMIT 1');
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $res = $stmt->get_result();
        if ($row = $res->fetch_assoc()) {
            if (password_verify($senha, $row['senha'])) {
                // login ok
                $_SESSION['user_id'] = $row['id'];
                $_SESSION['user_name'] = $row['nome'];
                header('Location: index.php');
                exit;
            } else {
                $msg = 'Credenciais incorretas.';
            }
        } else {
            $msg = 'Credenciais incorretas.';
        }
    }
}
?>
<!doctype html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <title>Login</title>
    <link rel="stylesheet" href="css/styles.css">
</head>

<body>
    <header>
        <h1>Login</h1>
    </header>
    <main>
        <?php if ($msg): ?><div class="alert"><?= htmlspecialchars($msg) ?></div><?php endif; ?>
        <form method="post" action="" class="form">
            <label>E-mail
                <input type="email" name="email" required>
            </label>
            <label>Senha
                <input type="password" name="senha" required>
            </label>
            <button type="submit">Entrar</button>
        </form>
        <p>Não tem conta? <a href="user_create.php">Cadastre-se</a></p>
    </main>
</body>

</html>