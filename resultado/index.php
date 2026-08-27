<?php
$fixedPassword = 'senha123';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $password = isset($_POST['password']) ? trim($_POST['password']) : '';
    if ($password === $fixedPassword) {
        header('Location: consulta.php');
        exit;
    }
    $error = 'Senha incorreta. Tente novamente.';
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login de Consulta</title>
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #4b79a1 0%, #283e51 100%);
            color: #ffffff;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .login-card {
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 16px;
            box-shadow: 0 16px 40px rgba(0, 0, 0, 0.25);
            padding: 36px;
            width: 100%;
            max-width: 380px;
            text-align: center;
        }
        .login-card h1 {
            margin-bottom: 24px;
            font-size: 28px;
        }
        .login-card label {
            display: block;
            text-align: left;
            margin-bottom: 8px;
            font-size: 14px;
            color: #dce3f0;
        }
        .login-card input[type="password"] {
            width: 100%;
            padding: 12px 14px;
            border-radius: 10px;
            border: 1px solid rgba(255, 255, 255, 0.25);
            background: rgba(255, 255, 255, 0.08);
            color: #ffffff;
            font-size: 16px;
            margin-bottom: 18px;
            outline: none;
        }
        .login-card input[type="password"]:focus {
            border-color: #70a1ff;
            box-shadow: 0 0 0 3px rgba(112, 161, 255, 0.15);
        }
        .login-card button {
            width: 100%;
            padding: 12px;
            border: none;
            border-radius: 10px;
            background: #5a8dee;
            color: #ffffff;
            font-size: 16px;
            cursor: pointer;
            transition: background 0.25s ease;
        }
        .login-card button:hover {
            background: #4673cc;
        }
        .error {
            margin-bottom: 16px;
            color: #ffb3b3;
            font-size: 14px;
        }
        .note {
            margin-top: 16px;
            font-size: 13px;
            color: #c0cbd9;
        }
    </style>
</head>
<body>
    <div class="login-card">
        <h1>Acesso aos Resultados</h1>
        <?php if ($error): ?>
            <div class="error"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>
        <form method="post" action="">
            <label for="password">Senha fixa</label>
            <input type="password" id="password" name="password" placeholder="Digite a senha" required>
            <button type="submit">Entrar</button>
        </form>
        <div class="note">Use a senha fixa para acessar a página de resultados.</div>
    </div>
</body>
</html>

<?php
// checagem de senha e redirecionamento para consulta.php
$fixedPassword = 'Informatica@2026';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $password = isset($_POST['password']) ? trim($_POST['password']) : '';
    if ($password === $fixedPassword) {
        header('Location: resultado.php');
        exit;
    }
    $error = 'Senha incorreta. Tente novamente.';
}

?>