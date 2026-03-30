<?php
/**
 * BackOffice — Dashboard
 */
require_once __DIR__ . '/../inc/auth.php';
require_once __DIR__ . '/../inc/articles.php';
require_once __DIR__ . '/../inc/categories.php';

requireAuth();

// Action logout
if (isset($_GET['action']) && $_GET['action'] === 'logout') {
    logoutUser();
}

$totalArticles = countArticles();
$publishedArticles = countPublishedArticles();
$draftArticles = countDraftArticles();
$totalCategories = countCategories();

$pageTitle = "Dashboard - Administration";
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($pageTitle) ?></title>
    <link rel="stylesheet" href="/main/back/assets/css/admin.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
</head>
<body class="admin">

<?php include __DIR__ . '/../inc/navbar.php'; ?>

<main class="container admin-content">
    <h1>Dashboard</h1>

    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon">📝</div>
            <div class="stat-info">
                <h3><?= $totalArticles ?></h3>
                <p>Articles totaux</p>
            </div>
        </div>
        <div class="stat-card stat-published">
            <div class="stat-icon">✅</div>
            <div class="stat-info">
                <h3><?= $publishedArticles ?></h3>
                <p>Articles publiés</p>
            </div>
        </div>
        <div class="stat-card stat-draft">
            <div class="stat-icon">📋</div>
            <div class="stat-info">
                <h3><?= $draftArticles ?></h3>
                <p>Brouillons</p>
            </div>
        </div>
        <div class="stat-card stat-categories">
            <div class="stat-icon">🏷️</div>
            <div class="stat-info">
                <h3><?= $totalCategories ?></h3>
                <p>Catégories</p>
            </div>
        </div>
    </div>

    <div class="quick-actions">
        <h2>Actions rapides</h2>
        <div class="actions-grid">
            <a href="/main/back/pages/article-form.php" class="action-card">
                <span class="action-icon">✏️</span>
                <span>Nouvel article</span>
            </a>
            <a href="/main/back/pages/category-form.php" class="action-card">
                <span class="action-icon">➕</span>
                <span>Nouvelle catégorie</span>
            </a>
            <a href="/main/back/pages/articles.php" class="action-card">
                <span class="action-icon">📄</span>
                <span>Gérer les articles</span>
            </a>
            <a href="/main/front/pages/index.php" class="action-card" target="_blank">
                <span class="action-icon">🌐</span>
                <span>Voir le site</span>
            </a>
        </div>
    </div>
</main>

</body>
</html>
