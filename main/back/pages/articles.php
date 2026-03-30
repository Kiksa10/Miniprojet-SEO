<?php
/**
 * BackOffice — Liste des articles
 */
require_once __DIR__ . '/../inc/auth.php';
require_once __DIR__ . '/../inc/articles.php';

requireAuth();

// Actions
if (isset($_GET['action']) && isset($_GET['id'])) {
    $id = (int) $_GET['id'];
    switch ($_GET['action']) {
        case 'delete':
            deleteArticle($id);
            header('Location: /main/back/pages/articles.php?msg=deleted');
            exit;
        case 'publish':
            publishArticle($id);
            header('Location: /main/back/pages/articles.php?msg=published');
            exit;
        case 'unpublish':
            unpublishArticle($id);
            header('Location: /main/back/pages/articles.php?msg=unpublished');
            exit;
    }
}

$articles = getAllArticles();
$pageTitle = "Gestion des articles";

$messages = [
    'deleted' => 'Article supprimé avec succès !',
    'published' => 'Article publié !',
    'unpublished' => 'Article dépublié !',
    'saved' => 'Article sauvegardé avec succès !',
];
$msg = $messages[$_GET['msg'] ?? ''] ?? null;
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
    <div class="page-header">
        <h1>Gestion des articles</h1>
        <a href="/main/back/pages/article-form.php" class="btn btn-primary">+ Nouvel article</a>
    </div>

    <?php if ($msg): ?>
        <div class="alert alert-success"><?= htmlspecialchars($msg) ?></div>
    <?php endif; ?>

    <?php if (empty($articles)): ?>
        <div class="empty-state">
            <p>Aucun article trouvé. Créez votre premier article !</p>
        </div>
    <?php else: ?>
        <div class="table-responsive">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Titre</th>
                        <th>Statut</th>
                        <th>Vues</th>
                        <th>Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($articles as $article): ?>
                    <tr>
                        <td><?= $article['id'] ?></td>
                        <td><?= htmlspecialchars($article['title']) ?></td>
                        <td>
                            <span class="status-badge <?= $article['status'] === 'PUBLISHED' ? 'status-published' : 'status-draft' ?>">
                                <?= $article['status'] ?>
                            </span>
                        </td>
                        <td><?= $article['view_count'] ?></td>
                        <td><?= date('d/m/Y', strtotime($article['created_at'])) ?></td>
                        <td class="actions-cell">
                            <a href="/main/back/pages/article-form.php?id=<?= $article['id'] ?>" class="btn btn-sm btn-edit" title="Modifier">✏️</a>
                            <?php if ($article['status'] === 'DRAFT'): ?>
                                <a href="?action=publish&id=<?= $article['id'] ?>" class="btn btn-sm btn-publish" title="Publier">✅</a>
                            <?php else: ?>
                                <a href="?action=unpublish&id=<?= $article['id'] ?>" class="btn btn-sm btn-unpublish" title="Dépublier">⏸️</a>
                            <?php endif; ?>
                            <a href="?action=delete&id=<?= $article['id'] ?>" class="btn btn-sm btn-delete" title="Supprimer" onclick="return confirm('Êtes-vous sûr ?')">🗑️</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</main>

</body>
</html>
