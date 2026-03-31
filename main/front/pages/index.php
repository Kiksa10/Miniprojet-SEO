<?php
/**
 * FrontOffice — Page d'accueil
 */
require_once __DIR__ . '/../../back/inc/db.php';
require_once __DIR__ . '/../inc/articles.php';

// Pagination setup
$articlesPerPage = 6;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
if ($page < 1) $page = 1;

$offset = ($page - 1) * $articlesPerPage;
$totalArticles = countFrontArticles();
$totalPages = ceil($totalArticles / $articlesPerPage);

$articles = getFrontArticles($articlesPerPage, $offset);

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
    
    <!-- Open Graph SEO -->
    <meta property="og:title" content="<?= htmlspecialchars($pageTitle) ?>">
    <meta property="og:description" content="<?= htmlspecialchars($metaDescription) ?>">
    <meta property="og:type" content="website">
    <meta property="og:url" content="http://localhost:8080/main/accueil">
    <meta name="twitter:card" content="summary_large_image">

    <!-- Preload critical resources -->
    <link rel="preload" href="/main/front/assets/css/style.css" as="style">
    <link rel="stylesheet" href="/main/front/assets/css/style.css">
    
    <!-- Defer Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet" media="print" onload="this.media='all'">
    <noscript><link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet"></noscript>
</head>
<body class="front">

<!-- Navigation -->
<nav class="navbar">
    <div class="container nav-content">
        <a href="/main/accueil" class="logo">
            <span class="logo-icon">📰</span>
            <span class="logo-text">Iran<span class="logo-accent">News</span></span>
        </a>
        <div class="nav-links">
            <a href="/main/accueil" class="nav-link active">Accueil</a>
            <a href="/main/admin" class="nav-link">Administration</a>
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
                            <a href="/main/article/<?= $article['id'] ?>"><?= htmlspecialchars($article['title']) ?></a>
                        </h3>
                        <p class="article-excerpt"><?= htmlspecialchars($article['meta_description'] ?? '') ?></p>
                        <div class="article-categories">
                            <?php foreach ($cats as $cat): ?>
                                <span class="category-badge"><?= htmlspecialchars($cat['name']) ?></span>
                            <?php endforeach; ?>
                        </div>
                        <a href="/main/article/<?= $article['id'] ?>" class="read-more">Lire la suite →</a>
                    </div>
                </article>
                <?php endforeach; ?>
            </div>

            <!-- Pagination -->
            <?php if ($totalPages > 1): ?>
                <div class="pagination">
                    <?php if ($page > 1): ?>
                        <a href="?page=<?= $page - 1 ?>" class="page-link">←</a>
                    <?php endif; ?>
                    
                    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                        <a href="?page=<?= $i ?>" class="page-link <?= $i === $page ? 'active' : '' ?>"><?= $i ?></a>
                    <?php endfor; ?>

                    <?php if ($page < $totalPages): ?>
                        <a href="?page=<?= $page + 1 ?>" class="page-link">→</a>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        <?php endif; ?>
    </section>
</main>

<!-- Footer -->
<footer class="footer">
    <div class="container">
        <p>&copy; 2026 IranNews — Projet Web Design | ETU003281 | ETU003360</p>
    </div>
</footer>

</body>
</html>
