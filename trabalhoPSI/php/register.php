<?php
session_start();
require_once __DIR__ . '/db.php';

// Mensagens flash
$error = $_SESSION['error'] ?? null;
$success = $_SESSION['success'] ?? null;
unset($_SESSION['error'], $_SESSION['success']);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $password2 = $_POST['password2'] ?? '';

    if ($username === '' || $email === '' || $password === '' || $password2 === '') {
        $_SESSION['error'] = 'Preencha todos os campos.';
        header('Location: register.php');
        exit;
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['error'] = 'Email inválido.';
        header('Location: register.php');
        exit;
    }
    if ($password !== $password2) {
        $_SESSION['error'] = 'Senhas não conferem.';
        header('Location: register.php');
        exit;
    }
    if (strlen($password) < 6) {
        $_SESSION['error'] = 'Senha muito curta (mínimo 6 caracteres).';
        header('Location: register.php');
        exit;
    }

    try {
        $pdo = getPDO();
        // Checar se usuário ou email já existem
        $stmt = $pdo->prepare('SELECT COUNT(*) FROM users WHERE username = :u OR email = :e');
        $stmt->execute([':u' => $username, ':e' => $email]);
        if ($stmt->fetchColumn() > 0) {
            $_SESSION['error'] = 'Usuário ou email já cadastrado.';
            header('Location: register.php');
            exit;
        }

        $hash = password_hash($password, PASSWORD_DEFAULT);
        $ins = $pdo->prepare('INSERT INTO users (username, email, password_hash, created_at) VALUES (:u,:e,:p,NOW())');
        $ins->execute([':u' => $username, ':e' => $email, ':p' => $hash]);
        $_SESSION['success'] = 'Cadastro efetuado. Você já pode entrar.';
        header('Location: index.php');
        exit;
    } catch (Exception $e) {
        $_SESSION['error'] = 'Erro ao cadastrar.';
        header('Location: register.php');
        exit;
    }

} else {
    // GET: mostrar formulário de registro
    ?>
    <!doctype html>
    <html lang="pt-BR">
    <head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <title>Cadastro — trabalhoPSI</title>
      <link rel="stylesheet" href="../css/style.css">
    </head>
    <body>
      <div class="container">
        <h1>Cadastro</h1>
        <?php if ($error): ?>
          <div class="msg error"><?=htmlspecialchars($error)?></div>
        <?php endif; ?>
        <?php if ($success): ?>
          <div class="msg success"><?=htmlspecialchars($success)?></div>
        <?php endif; ?>

        <div class="card form-card">
          <form action="register.php" method="post">
            <label for="reg_username">Usuário</label>
            <input id="reg_username" name="username" type="text" required>
            <label for="reg_email">Email</label>
            <input id="reg_email" name="email" type="email" required>
            <label for="reg_password">Senha</label>
            <input id="reg_password" name="password" type="password" required>
            <label for="reg_password2">Confirme a senha</label>
            <input id="reg_password2" name="password2" type="password" required>
            <div style="display:flex;gap:8px;margin-top:12px;align-items:center">
              <button type="submit" class="btn">Cadastrar</button>
              <a class="link-muted" href="index.php">Voltar ao login</a>
            </div>
          </form>
        </div>
      </div>
    </body>
    </html>
    <?php
}

