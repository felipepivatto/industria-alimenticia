<?php
require 'config.php';
session_start();
// allow registration even if not logged in
$msg = '';
if($_SERVER['REQUEST_METHOD']==='POST'){
    $nome = trim($_POST['nome'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $senha = $_POST['senha'] ?? '';
    if($nome==='' || $email==='' || $senha===''){
        $msg = 'Preencha todos os campos.';
    } elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        $msg = 'E-mail inválido.';
    } else {
        $conn = db_connect();
        $stmt = $conn->prepare('SELECT id FROM users WHERE email=? LIMIT 1');
        $stmt->bind_param('s',$email);
        $stmt->execute();
        $res = $stmt->get_result();
        if($res->fetch_assoc()){
            $msg = 'E-mail já cadastrado.';
        } else {
            $hash = password_hash($senha, PASSWORD_DEFAULT);
            $stmt = $conn->prepare('INSERT INTO users (nome,email,senha) VALUES (?,?,?)');
            $stmt->bind_param('sss',$nome,$email,$hash);
            if($stmt->execute()){
                $msg = 'cadastro concluído com sucesso';
                header('Location: login.php'); exit;
            } else {
                $msg = 'Erro: ' . $stmt->error;
            }
        }
    }
}
?>
<!doctype html>
<html lang="pt-br">
<head><meta charset="utf-8"><title>Cadastrar usuário</title><link rel="stylesheet" href="css/styles.css"></head>
<body>
<header><h1>Cadastrar Usuário</h1><nav><a href="login.php">Voltar</a></nav></header>
<main>
<?php if($msg): ?><div class="alert"><?=htmlspecialchars($msg)?></div><?php endif; ?>
<form method="post" action="" class="form">
  <label>Nome
    <input type="text" name="nome" required value="<?=htmlspecialchars($nome ?? '')?>">
  </label>
  <label>E-mail
    <input type="email" name="email" required value="<?=htmlspecialchars($email ?? '')?>">
  </label>
  <label>Senha
    <input type="password" name="senha" required>
  </label>
  <button type="submit">Cadastrar</button>
</form>
</main></body></html>
