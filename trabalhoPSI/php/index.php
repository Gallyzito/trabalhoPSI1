<?php
session_start();
// Mensagens flash (error / success)
$error = $_SESSION['error'] ?? null;
$success = $_SESSION['success'] ?? null;
unset($_SESSION['error'], $_SESSION['success']);
?>
<!doctype html>
<html lang="pt-BR">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Login - trabalhoPSI</title>
	<link rel="stylesheet" href="../css/style.css">

</head>
<body>
	<div class="container">
		<h1>trabalhoPSI — Login</h1>
		<?php if ($error): ?>
			<div class="msg error"><?=htmlspecialchars($error)?></div>
		<?php endif; ?>
		<?php if ($success): ?>
			<div class="msg success"><?=htmlspecialchars($success)?></div>
		<?php endif; ?>

			<?php if (!empty($_SESSION['user_id'])): ?>
			<div class="card">
				<div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:16px">
					<h2>Bem-vindo, <?=htmlspecialchars($_SESSION['username'])?>!</h2>
										<div style="display:flex;gap:8px;align-items:center">
												<a href="formulario.php" class="btn">📝 Formulário</a>
												<?php if (!empty($_SESSION['is_admin'])): ?>
													<a href="admin.php" class="btn" style="background:transparent;border:1px solid rgba(255,255,255,0.06);color:var(--accent);">Admin</a>
												<?php endif; ?>
												<a href="logout.php" class="link-muted">Sair</a>
										</div>
				</div>
			</div>

			<div class="gaming-section">
				<div class="card">
					<h2>🎮 Mundo dos Videojogos</h2>
					<p>Explore o fascinante universo dos videojogos, desde clássicos atemporais até os lançamentos mais recentes de 2025.</p>
				</div>

				<div class="row">
					<div class="col card">
						<h3>🔥 Destaques de 2025</h3>
						<div class="game-highlight">
							<img src="https://images.unsplash.com/photo-1560472354-b33ff0c44a43?w=300&h=200&fit=crop&auto=format" alt="Gaming" style="width:100%;height:120px;object-fit:cover;border-radius:6px;margin-bottom:8px">
							<h4>Ghost of Yotei</h4>
							<p>A sequela épica de Ghost of Tsushima que nos leva numa jornada pela era Edo do Japão.</p>
						</div>
						<div class="game-highlight">
							<h4>Silent Hill f</h4>
							<p>O regresso da icónica série de horror psicológico com gráficos de nova geração.</p>
						</div>
					</div>

					<div class="col card">
						<h3>🎯 Tendências Gaming</h3>
						<ul class="trending-list">
							<li><strong>AI nos Jogos:</strong> Inteligência artificial revoluciona NPCs e narrativas dinâmicas</li>
							<li><strong>Ray Tracing Pro:</strong> PS5 Pro eleva os gráficos a um novo patamar</li>
							<li><strong>Game Pass Evolution:</strong> Serviços de subscrição moldam o futuro</li>
							<li><strong>Jogos Indie:</strong> Criatividade independente conquista corações</li>
						</ul>
					</div>
				</div>

				<div class="card">
					<h3>🏆 Géneros em Alta</h3>
					<div class="genre-grid">
						<div class="genre-item">
							<span class="genre-icon">⚔️</span>
							<div>
								<h4>Action RPG</h4>
								<p>Combinação perfeita de ação e progressão de personagem</p>
							</div>
						</div>
						<div class="genre-item">
							<span class="genre-icon">👻</span>
							<div>
								<h4>Horror Psicológico</h4>
								<p>Experiências imersivas que desafiam a mente</p>
							</div>
						</div>
						<div class="genre-item">
							<span class="genre-icon">🎲</span>
							<div>
								<h4>Roguelike</h4>
								<p>Aventuras procedurais com alta rejogabilidade</p>
							</div>
						</div>
						<div class="genre-item">
							<span class="genre-icon">🏁</span>
							<div>
								<h4>Racing Arcade</h4>
								<p>Velocidade e adrenalina em pista</p>
							</div>
						</div>
					</div>
				</div>

				<div class="row">
					<div class="col card">
						<h3>📈 Indústria em Números</h3>
						<div class="stat-item">
							<span class="stat-number">3.2B</span>
							<span class="stat-label">Jogadores no mundo</span>
						</div>
						<div class="stat-item">
							<span class="stat-number">$184B</span>
							<span class="stat-label">Receita global 2024</span>
						</div>
						<div class="stat-item">
							<span class="stat-number">57%</span>
							<span class="stat-label">Crescimento mobile gaming</span>
						</div>
					</div>

					<div class="col card">
						<h3>🎪 Eventos & Lançamentos</h3>
						<div class="event-item">
							<div class="event-date">Out 2025</div>
							<div class="event-info">
								<h4>DevGAMM Lisbon</h4>
								<p>Conferência de desenvolvimento de jogos em Portugal</p>
							</div>
						</div>
						<div class="event-item">
							<div class="event-date">Nov 2025</div>
							<div class="event-info">
								<h4>Moonlighter 2</h4>
								<p>Continuação do adorado RPG de gestão</p>
							</div>
						</div>
					</div>
				</div>
			</div>
		<?php else: ?>
				<div class="auth-wrap">
					<div class="card form-card">
						<h2>Entrar</h2>
						<form action="login.php" method="post">
							<label for="login_username">Usuário</label>
							<input id="login_username" name="username" type="text" required>
							<label for="login_password">Senha</label>
							<input id="login_password" name="password" type="password" required>
							<div class="actions">
								<button type="submit" class="btn">Entrar</button>
								<a class="link-muted" href="register.php">Criar conta</a>
							</div>
						</form>
					</div>
				</div>
		<?php endif; ?>

		<hr>    
	</div>
</body>
</html>
