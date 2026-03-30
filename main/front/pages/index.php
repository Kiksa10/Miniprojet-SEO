<?php
/**
 * FrontOffice — Page d'accueil
 */
require_once __DIR__ . '/../../back/inc/db.php';
require_once __DIR__ . '/../inc/articles.php';

$articles = getFrontArticles();

$pageTitle = "Accueil - Iran News";
$metaDescription = "Site d'informations sur la guerre en Iran. Suivez les dernières actualités, analyses et reportages.";
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?= htmlspecialchars($metaDescription) ?>">
    <title><?= htmlspecialchars($pageTitle) ?></title>
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
            <a href="/main/front/pages/index.php" class="nav-link active">Accueil</a>
            <a href="/main/back/connexion.php" class="nav-link">Administration</a>
        </div>
    </div>
</nav>

<!-- Hero -->
<header class="hero">
    <div class="container">
        <h1>Actualités sur la situation en Iran</h1>
        <p class="hero-subtitle">Suivez les dernières informations, analyses et reportages sur la situation géopolitique en Iran</p>
    </div>
</header>

<!-- Articles -->
<main class="container">
    <section class="articles-section">
        <h2 class="section-title">Derniers articles</h2>

        <?php if (empty($articles)): ?>
            <div class="empty-state">
                <p>Aucun article publié pour le moment.</p>
            </div>
        <?php else: ?>
            <div class="articles-grid">
                <?php foreach ($articles as $article): 
                    $cats = getFrontArticleCategories($article['id']);
                ?>
                <article class="article-card">
                    <div class="article-card-body">
                        <div class="article-meta">
                            <span class="article-date"><?= date('d M Y', strtotime($article['created_at'])) ?></span>
                            <span class="article-views">👁 <?= $article['view_count'] ?> vues</span>
                        </div>
                        <h3 class="article-card-title">
                            <a href="/main/front/pages/article.php?id=<?= $article['id'] ?>"><?= htmlspecialchars($article['title']) ?></a>
                        </h3>
                        <p class="article-excerpt"><?= htmlspecialchars($article['meta_description'] ?? '') ?></p>
                        <div class="article-categories">
                            <?php foreach ($cats as $cat): ?>
                                <span class="category-badge"><?= htmlspecialchars($cat['name']) ?></span>
                            <?php endforeach; ?>
                        </div>
                        <a href="/main/front/pages/article.php?id=<?= $article['id'] ?>" class="read-more">Lire la suite →</a>
                    </div>
                </article>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </section>
</main>

<!-- Footer -->
<footer class="footer">
    <div class="container">
        <p>&copy; 2025 IranNews — Projet Web Design | ETU003281</p>
    </div>
</footer>

</body>
</html>
