<?php
/**
 * BackOffice — Page de connexion administration
 */
require_once __DIR__ . '/inc/auth.php';

startSession();

// Si déjà connecté, rediriger vers le dashboard
if (isLoggedIn()) {
    header('Location: /main/admin/dashboard');
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($username && $password) {
        if (loginUser($username, $password)) {
            header('Location: /main/admin/dashboard');
            exit;
        } else {
            $error = "Nom d'utilisateur ou mot de passe incorrect.";
        }
    } else {
        $error = "Veuillez remplir tous les champs.";
    }
}

$pageTitle = "Connexion - Administration";
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Connexion à l'administration IranNews">
    <title><?= htmlspecialchars($pageTitle) ?></title>
    <link rel="stylesheet" href="/main/back/assets/css/admin.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
</head>
<body class="login-page">

<div class="login-container">
    <div class="login-card">
        <div class="login-header">
            <span class="login-icon">🔐</span>
            <h1>Administration</h1>
            <p>Connectez-vous pour accéder au panneau d'administration</p>
        </div>

        <?php if ($error): ?>
            <div class="alert alert-error"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <?php if (isset($_GET['logout'])): ?>
            <div class="alert alert-success">Vous avez été déconnecté avec succès.</div>
        <?php endif; ?>

        <form action="" method="post" class="login-form">
            <div class="form-group">
                <label for="username">Nom d'utilisateur</label>
                <input type="text" id="username" name="username" value="admin" placeholder="Entrez votre nom d'utilisateur" required autofocus >
            </div>
            <div class="form-group">
                <label for="password">Mot de passe</label>
                <input type="password" id="password" name="password" value="admin123" placeholder="Entrez votre mot de passe" required>
            </div>
            <button type="submit" class="btn btn-primary btn-block">Se connecter</button>
        </form>

        <div class="login-footer">
            <a href="/main/accueil">← Retour au site</a>
        </div>
    </div>
</div>

</body>
</html>
