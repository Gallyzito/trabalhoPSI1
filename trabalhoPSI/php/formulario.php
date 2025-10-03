<?php
session_start();

// Verificar se está logado
if (empty($_SESSION['user_id'])) {
    $_SESSION['error'] = 'É necessário fazer login para acessar esta página.';
    header('Location: index.php');
    exit;
}

require_once __DIR__ . '/db.php';

// Mensagens flash
$error = $_SESSION['error'] ?? null;
$success = $_SESSION['success'] ?? null;
unset($_SESSION['error'], $_SESSION['success']);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = trim($_POST['nome'] ?? '');
    $jogo_favorito = trim($_POST['jogo_favorito'] ?? '');
    $genero = $_POST['genero'] ?? '';
    $plataforma = $_POST['plataforma'] ?? '';
    $tempo_jogo = $_POST['tempo_jogo'] ?? '';
    $comentarios = trim($_POST['comentarios'] ?? '');

    if ($nome === '' || $jogo_favorito === '' || $genero === '' || $plataforma === '') {
        $_SESSION['error'] = 'Preencha todos os campos obrigatórios.';
        header('Location: formulario.php');
        exit;
    }

    try {
        $pdo = getPDO();
        $stmt = $pdo->prepare('INSERT INTO gaming_forms (user_id, nome, jogo_favorito, genero, plataforma, tempo_jogo, comentarios, created_at) VALUES (:uid, :nome, :jogo, :gen, :plat, :tempo, :com, NOW())');
        $stmt->execute([
            ':uid' => $_SESSION['user_id'],
            ':nome' => $nome,
            ':jogo' => $jogo_favorito,
            ':gen' => $genero,
            ':plat' => $plataforma,
            ':tempo' => $tempo_jogo,
            ':com' => $comentarios
        ]);
        $_SESSION['success'] = 'Formulário enviado com sucesso!';
        header('Location: formulario.php');
        exit;
    } catch (Exception $e) {
        $_SESSION['error'] = 'Erro ao enviar formulário.';
        header('Location: formulario.php');
        exit;
    }
}
?>
<!doctype html>
<html lang="pt-BR">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Formulário Gaming — trabalhoPSI</title>
  <link rel="stylesheet" href="../css/style.css">
</head>
<body>
  <div class="container">
    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:20px">
      <h1>🎮 Formulário Gaming</h1>
      <a href="index.php" class="link-muted">← Voltar ao Dashboard</a>
    </div>
    
    <?php if ($error): ?>
      <div class="msg error"><?=htmlspecialchars($error)?></div>
    <?php endif; ?>
    <?php if ($success): ?>
      <div class="msg success"><?=htmlspecialchars($success)?></div>
    <?php endif; ?>

    <div class="card form-card">
      <h2>Partilhe a sua paixão pelos videojogos</h2>
      <p class="hint">Conte-nos sobre os seus gostos e experiências no mundo gaming!</p>
      
      <form action="formulario.php" method="post">
        <label for="nome">Nome *</label>
        <input id="nome" name="nome" type="text" required placeholder="O seu nome">
        
        <label for="jogo_favorito">Jogo Favorito *</label>
        <input id="jogo_favorito" name="jogo_favorito" type="text" required placeholder="Ex: The Witcher 3, Elden Ring, FIFA 24...">
        
        <label for="genero">Género Favorito *</label>
        <select id="genero" name="genero" required style="width:100%;padding:12px 14px;margin-top:8px;border-radius:8px;border:1px solid #e6eef8;background:#fbfdff">
          <option value="">Selecione um género</option>
          <option value="action">Action/Aventura</option>
          <option value="rpg">RPG</option>
          <option value="fps">FPS</option>
          <option value="strategy">Estratégia</option>
          <option value="sports">Desporto</option>
          <option value="racing">Corridas</option>
          <option value="puzzle">Puzzle</option>
          <option value="horror">Horror</option>
          <option value="indie">Indie</option>
          <option value="simulation">Simulação</option>
        </select>
        
        <label for="plataforma">Plataforma Principal *</label>
        <select id="plataforma" name="plataforma" required style="width:100%;padding:12px 14px;margin-top:8px;border-radius:8px;border:1px solid #e6eef8;background:#fbfdff">
          <option value="">Selecione uma plataforma</option>
          <option value="pc">PC</option>
          <option value="ps5">PlayStation 5</option>
          <option value="ps4">PlayStation 4</option>
          <option value="xbox-series">Xbox Series X/S</option>
          <option value="xbox-one">Xbox One</option>
          <option value="switch">Nintendo Switch</option>
          <option value="mobile">Mobile</option>
          <option value="multiple">Várias plataformas</option>
        </select>
        
        <label for="tempo_jogo">Tempo de Jogo Semanal</label>
        <select id="tempo_jogo" name="tempo_jogo" style="width:100%;padding:12px 14px;margin-top:8px;border-radius:8px;border:1px solid #e6eef8;background:#fbfdff">
          <option value="">Opcional</option>
          <option value="1-5h">1-5 horas</option>
          <option value="6-10h">6-10 horas</option>
          <option value="11-20h">11-20 horas</option>
          <option value="21h+">Mais de 21 horas</option>
        </select>
        
        <label for="comentarios">Comentários Adicionais</label>
        <textarea id="comentarios" name="comentarios" rows="4" placeholder="Conte-nos mais sobre os seus gostos gaming, jogos que espera, opiniões sobre a indústria..." style="width:100%;padding:12px 14px;margin-top:8px;border-radius:8px;border:1px solid #e6eef8;background:#fbfdff;resize:vertical;font-family:inherit"></textarea>
        
        <div class="actions">
          <button type="submit" class="btn">Enviar Formulário</button>
          <a href="index.php" class="link-muted">Cancelar</a>
        </div>
      </form>
    </div>
  </div>
</body>
</html>