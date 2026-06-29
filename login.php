<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - Gestion Commerciale</title>
    <link rel="stylesheet" href="/css/styles.css">
</head>
<body class="login-body">
    <div class="login-card">
        <h1>Gestion Commerciale</h1>
        <p>Connectez-vous pour accéder au tableau de bord</p>
        <?php if (!empty($_SESSION['error'])): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($_SESSION['error']) ?></div>
        <?php endif; ?>
        <form method="post" action="/index.php?action=login">
            <label>Nom d'utilisateur</label>
            <input type="text" name="username" required>
            <label>Mot de passe</label>
            <input type="password" name="password" required>
            <button type="submit">Se connecter</button>
        </form>
        <small>Utilisateur par défaut : admin / admin123</small>
    </div>
</body>
</html>
