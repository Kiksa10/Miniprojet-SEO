<?php
/**
 * FrontOffice — Page détail article
 */
require_once __DIR__ . '/../../back/inc/db.php';
require_once __DIR__ . '/../inc/articles.php';

if (!isset($_GET['id'])) {
    header('Location: /main/front/pages/index.php');
    exit;
}

$id = (int) $_GET['id'];
$article = getFrontArticleById($id);

// Rediriger si article non trouvé
if (!$article) {
    header('Location: /main/front/pages/index.php');
    exit;
}

// Incrémenter le compteur de vues
incrementFrontViewCount($id);
$article['view_count']++; // Mettre à jour pour l'affichage courant

$cats = getFrontArticleCategories($id);

$pageTitle = $article['meta_title'] ?: $article['title'];
$metaDescription = $article['meta_description'] ?? '';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?= htmlspecialchars($metaDescription) ?>">
    <title><?= htmlspecialchars($pageTitle) ?> - Iran News</title>
    <link rel="stylesheet" href="/main/front/assets/css/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
</head>
<body class="front">

<!-- Navigation -->
<nav class="navbar">
    <div class="container nav-content">
        <a href="/main/front/pages/index.php" class="logo">
            <span class="logo-icon">📰</span>
            <span class="logo-text">Iran<span class="logo-accent">News</span></span>
        </a>
        <div class="nav-links">
            <a href="/main/front/pages/index.php" class="nav-link">Accueil</a>
            <a href="/main/back/connexion.php" class="nav-link">Administration</a>
        </div>
    </div>
</nav>

<!-- Article Detail -->
<main class="container">
    <article class="article-detail">
        <div class="article-detail-header">
            <a href="/main/front/pages/index.php" class="back-link">← Retour aux articles</a>
            <h1><?= htmlspecialchars($article['title']) ?></h1>
            <div class="article-detail-meta">
                <span class="article-date"><?= date('d F Y', strtotime($article['created_at'])) ?></span>
                <span class="article-views">👁 <?= $article['view_count'] ?> vues</span>
            </div>
            <div class="article-categories">
                <?php foreach ($cats as $cat): ?>
                    <span class="category-badge"><?= htmlspecialchars($cat['name']) ?></span>
                <?php endforeach; ?>
            </div>
        </div>

        <?php if (!empty($article['image_url'])): ?>
            <div class="article-image">
                <img src="<?= htmlspecialchars($article['image_url']) ?>" alt="<?= htmlspecialchars($article['title']) ?>">
            </div>
        <?php endif; ?>

        <div class="article-content">
            <?= $article['content'] // Attention : Contenu HTML direct, XSS possible si le back-office ne filtre pas ?>
        </div>
    </article>
</main>

<!-- Footer -->
<footer class="footer">
    <div class="container">
        <p>&copy; 2025 IranNews — Projet Web Design | ETU003281</p>
    </div>
</footer>

</body>
</html>
