<?php
session_start();
require_once __DIR__ . '/db.php';

// Verifica se é admin
if (empty($_SESSION['user_id']) || empty($_SESSION['is_admin'])) {
    $_SESSION['error'] = 'Acesso negado. Apenas administradores.';
    header('Location: index.php');
    exit;
}

$error = $_SESSION['error'] ?? null;
$success = $_SESSION['success'] ?? null;
unset($_SESSION['error'], $_SESSION['success']);

try {
    $pdo = getPDO();
    $stmt = $pdo->prepare('SELECT g.*, u.username FROM gaming_forms g JOIN users u ON g.user_id = u.id ORDER BY g.created_at DESC');
    $stmt->execute();
    $rows = $stmt->fetchAll();
} catch (Exception $e) {
    $rows = [];
    $error = 'Erro ao ler formulários.';
}
?>
<!doctype html>
<html lang="pt-BR">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Admin — trabalhoPSI</title>
  <link rel="stylesheet" href="../css/style.css">
</head>
<body>
  <div class="container">
    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:20px">
      <h1>Admin - Formulários</h1>
      <div>
        <a href="index.php" class="link-muted">Dashboard</a>
        <a href="logout.php" class="link-muted" style="margin-left:12px">Sair</a>
      </div>
    </div>

    <?php if ($error): ?>
      <div class="msg error"><?=htmlspecialchars($error)?></div>
    <?php endif; ?>
    <?php if ($success): ?>
      <div class="msg success"><?=htmlspecialchars($success)?></div>
    <?php endif; ?>

    <div class="card">
      <h2>Submissões</h2>
      <?php if (empty($rows)): ?>
        <p class="hint">Nenhuma submissão encontrada.</p>
      <?php else: ?>
        <table style="width:100%;border-collapse:collapse">
          <thead>
            <tr style="text-align:left;border-bottom:1px solid rgba(255,255,255,0.06)">
              <th>#</th>
              <th>Usuário</th>
              <th>Nome</th>
              <th>Jogo Favorito</th>
              <th>Género</th>
              <th>Plataforma</th>
              <th>Tempo</th>
              <th>Comentários</th>
              <th>Data</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($rows as $r): ?>
              <tr style="border-bottom:1px solid rgba(255,255,255,0.03)">
                <td><?=htmlspecialchars($r['id'])?></td>
                <td><?=htmlspecialchars($r['username'])?></td>
                <td><?=htmlspecialchars($r['nome'])?></td>
                <td><?=htmlspecialchars($r['jogo_favorito'])?></td>
                <td><?=htmlspecialchars($r['genero'])?></td>
                <td><?=htmlspecialchars($r['plataforma'])?></td>
                <td><?=htmlspecialchars($r['tempo_jogo'])?></td>
                <td><?=nl2br(htmlspecialchars($r['comentarios']))?></td>
                <td><?=htmlspecialchars($r['created_at'])?></td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      <?php endif; ?>
    </div>
  </div>
</body>
</html>
