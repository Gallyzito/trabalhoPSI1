<?php
// test_connection.php - Teste de conexão e estrutura da base de dados
require_once __DIR__ . '/db.php';

echo "<h2>Teste de Conexão - trabalhoPSI</h2>\n";

try {
    $pdo = getPDO();
    echo "✅ <strong>Conexão PDO: SUCESSO</strong><br>\n";
    echo "Base de dados: " . DB_NAME . "<br>\n";
    echo "Host: " . DB_HOST . "<br>\n";
    echo "Usuário: " . DB_USER . "<br><br>\n";
    
    // Verificar se as tabelas existem
    $tables = ['users', 'gaming_forms'];
    foreach ($tables as $table) {
        $stmt = $pdo->prepare("SHOW TABLES LIKE :table");
        $stmt->execute([':table' => $table]);
        if ($stmt->fetch()) {
            echo "✅ Tabela <code>$table</code>: EXISTE<br>\n";
        } else {
            echo "❌ Tabela <code>$table</code>: NÃO EXISTE<br>\n";
        }
    }
    
    echo "<br><strong>Status:</strong> ";
    if ($pdo) {
        echo "Sistema pronto para login/registro!";
    }
    
} catch (Exception $e) {
    echo "❌ <strong>Erro de Conexão:</strong> " . $e->getMessage() . "<br>\n";
    echo "<strong>Soluções:</strong><br>\n";
    echo "1. Verifique se o WAMP está rodando<br>\n";
    echo "2. Importe o arquivo SQL: <code>sql/create_database.sql</code><br>\n";
    echo "3. Ajuste credenciais em <code>db.php</code><br>\n";
}
?>