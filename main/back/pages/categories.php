<?php
/**
 * BackOffice — Liste des catégories
 */
require_once __DIR__ . '/../inc/auth.php';
require_once __DIR__ . '/../inc/categories.php';

requireAuth();

// Action suppression
if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id'])) {
    deleteCategory((int) $_GET['id']);
    header('Location: /main/back/pages/categories.php?msg=deleted');
    exit;
}

$categories = getAllCategories();
$pageTitle = "Gestion des catégories";

$messages = [
    'deleted' => 'Catégorie supprimée avec succès !',
    'saved' => 'Catégorie sauvegardée avec succès !',
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
        <h1>Gestion des catégories</h1>
        <a href="/main/back/pages/category-form.php" class="btn btn-primary">+ Nouvelle catégorie</a>
    </div>

    <?php if ($msg): ?>
        <div class="alert alert-success"><?= htmlspecialchars($msg) ?></div>
    <?php endif; ?>

    <?php if (empty($categories)): ?>
        <div class="empty-state"><p>Aucune catégorie trouvée.</p></div>
    <?php else: ?>
        <div class="table-responsive">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nom</th>
                        <th>Description</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($categories as $cat): ?>
                    <tr>
                        <td><?= $cat['id'] ?></td>
                        <td><?= htmlspecialchars($cat['name']) ?></td>
                        <td><?= htmlspecialchars($cat['description'] ?? '') ?></td>
                        <td class="actions-cell">
                            <a href="/main/back/pages/category-form.php?id=<?= $cat['id'] ?>" class="btn btn-sm btn-edit" title="Modifier">✏️</a>
                            <a href="?action=delete&id=<?= $cat['id'] ?>" class="btn btn-sm btn-delete" title="Supprimer" onclick="return confirm('Êtes-vous sûr ?')">🗑️</a>
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
