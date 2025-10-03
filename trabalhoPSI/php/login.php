<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    $_SESSION['error'] = 'Requisição inválida.';
    header('Location: index.php');
    exit;
}

require_once __DIR__ . '/db.php';

$username = trim($_POST['username'] ?? '');
$password = $_POST['password'] ?? '';

if ($username === '' || $password === '') {
    $_SESSION['error'] = 'Preencha usuário e senha.';
    header('Location: index.php');
    exit;
}

try {
    $pdo = getPDO();
    $stmt = $pdo->prepare('SELECT id, username, password_hash, is_admin FROM users WHERE username = :u OR email = :e LIMIT 1');
    $stmt->execute([':u' => $username, ':e' => $username]);
    $user = $stmt->fetch();
    if ($user && password_verify($password, $user['password_hash'])) {
        // sucesso
        session_regenerate_id(true);
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['is_admin'] = !empty($user['is_admin']);
        $_SESSION['success'] = 'Login efetuado com sucesso.';
        header('Location: index.php');
        exit;
    } else {
        $_SESSION['error'] = 'Credenciais inválidas.';
        header('Location: index.php');
        exit;
    }
} catch (Exception $e) {
    // Cria pasta de logs se não existir
    $logsDir = __DIR__ . '/logs';
    if (!is_dir($logsDir)) {
        @mkdir($logsDir, 0755, true);
    }
    $logFile = $logsDir . '/error.log';
    $msg = '[' . date('Y-m-d H:i:s') . '] Login error: ' . $e->getMessage() . " in " . $e->getFile() . ':' . $e->getLine() . "\n";
    @file_put_contents($logFile, $msg, FILE_APPEND | LOCK_EX);

    // Para debug local, repassar a mensagem (remova em produção)
    $_SESSION['error'] = 'Erro interno: ' . $e->getMessage();
    header('Location: index.php');
    exit;
}
