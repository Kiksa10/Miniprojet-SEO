<?php
/**
 * BackOffice — Formulaire catégorie (création/modification)
 */
require_once __DIR__ . '/../inc/auth.php';
require_once __DIR__ . '/../inc/categories.php';

requireAuth();

$category = null;
$editMode = false;

if (isset($_GET['id'])) {
    $category = getCategoryById((int) $_GET['id']);
    if ($category) {
        $editMode = true;
    }
}

// Traitement du formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $description = trim($_POST['description'] ?? '');

    if ($name) {
        if (isset($_POST['id']) && $_POST['id']) {
            updateCategory((int) $_POST['id'], $name, $description);
        } else {
            createCategory($name, $description);
        }
        header('Location: /main/back/pages/categories.php?msg=saved');
        exit;
    }
}

$pageTitle = $editMode ? "Modifier la catégorie" : "Nouvelle catégorie";
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
        <h1><?= htmlspecialchars($pageTitle) ?></h1>
        <a href="/main/back/pages/categories.php" class="btn btn-secondary">← Retour</a>
    </div>

    <form action="" method="post" class="admin-form">
        <?php if ($editMode): ?>
            <input type="hidden" name="id" value="<?= $category['id'] ?>">
        <?php endif; ?>

        <div class="form-group">
            <label for="name">Nom *</label>
            <input type="text" id="name" name="name" placeholder="Nom de la catégorie"
                   value="<?= htmlspecialchars($category['name'] ?? '') ?>" required>
        </div>

        <div class="form-group">
            <label for="description">Description</label>
            <textarea id="description" name="description" rows="4" placeholder="Description de la catégorie"><?= htmlspecialchars($category['description'] ?? '') ?></textarea>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary">💾 Sauvegarder</button>
            <a href="/main/back/pages/categories.php" class="btn btn-secondary">Annuler</a>
        </div>
    </form>
</main>

</body>
</html>
