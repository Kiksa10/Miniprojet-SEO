<?php
/**
 * BackOffice — Formulaire article (création/modification)
 */
require_once __DIR__ . '/../inc/auth.php';
require_once __DIR__ . '/../inc/articles.php';
require_once __DIR__ . '/../inc/categories.php';

requireAuth();

$article = null;
$editMode = false;
$selectedCategories = [];

if (isset($_GET['id'])) {
    $article = getArticleById((int) $_GET['id']);
    if ($article) {
        $editMode = true;
        $cats = getArticleCategories($article['id']);
        $selectedCategories = array_column($cats, 'id');
    }
}

// Traitement du formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = [
        'title' => trim($_POST['title'] ?? ''),
        'content' => $_POST['content'] ?? '',
        'meta_title' => trim($_POST['meta_title'] ?? ''),
        'meta_description' => trim($_POST['meta_description'] ?? ''),
        'status' => $_POST['status'] ?? 'DRAFT',
        'image_url' => trim($_POST['image_url'] ?? ''),
    ];
    $categoryIds = $_POST['category_ids'] ?? [];

    if (isset($_POST['id']) && $_POST['id']) {
        $id = (int) $_POST['id'];
        updateArticle($id, $data);
        updateArticleCategories($id, $categoryIds);
    } else {
        $id = createArticle($data);
        updateArticleCategories($id, $categoryIds);
    }

    header('Location: /main/back/pages/articles.php?msg=saved');
    exit;
}

$allCategories = getAllCategories();
$pageTitle = $editMode ? "Modifier l'article" : "Nouvel article";
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
        <a href="/main/back/pages/articles.php" class="btn btn-secondary">← Retour</a>
    </div>

    <form action="" method="post" class="admin-form">
        <?php if ($editMode): ?>
            <input type="hidden" name="id" value="<?= $article['id'] ?>">
        <?php endif; ?>

        <div class="form-grid">
            <div class="form-main">
                <div class="form-group">
                    <label for="title">Titre *</label>
                    <input type="text" id="title" name="title" placeholder="Titre de l'article"
                           value="<?= htmlspecialchars($article['title'] ?? '') ?>" required>
                </div>

                <div class="form-group">
                    <label for="content">Contenu *</label>
                    <textarea id="content" name="content" rows="15" placeholder="Contenu de l'article (HTML supporté)" required><?= htmlspecialchars($article['content'] ?? '') ?></textarea>
                </div>
            </div>

            <div class="form-sidebar">
                <div class="form-card">
                    <h3>Publication</h3>
                    <div class="form-group">
                        <label for="status">Statut</label>
                        <select id="status" name="status">
                            <option value="DRAFT" <?= ($article['status'] ?? 'DRAFT') === 'DRAFT' ? 'selected' : '' ?>>Brouillon</option>
                            <option value="PUBLISHED" <?= ($article['status'] ?? '') === 'PUBLISHED' ? 'selected' : '' ?>>Publié</option>
                        </select>
                    </div>
                </div>

                <div class="form-card">
                    <h3>SEO</h3>
                    <div class="form-group">
                        <label for="meta_title">Meta Title</label>
                        <input type="text" id="meta_title" name="meta_title" placeholder="Titre pour les moteurs de recherche"
                               value="<?= htmlspecialchars($article['meta_title'] ?? '') ?>">
                    </div>
                    <div class="form-group">
                        <label for="meta_description">Meta Description</label>
                        <textarea id="meta_description" name="meta_description" rows="3" placeholder="Description pour les moteurs de recherche"><?= htmlspecialchars($article['meta_description'] ?? '') ?></textarea>
                    </div>
                </div>

                <div class="form-card">
                    <h3>Image</h3>
                    <div class="form-group">
                        <label for="image_url">URL de l'image</label>
                        <input type="text" id="image_url" name="image_url" placeholder="https://..."
                               value="<?= htmlspecialchars($article['image_url'] ?? '') ?>">
                    </div>
                </div>

                <div class="form-card">
                    <h3>Catégories</h3>
                    <div class="checkbox-group">
                        <?php foreach ($allCategories as $cat): ?>
                            <label class="checkbox-label">
                                <input type="checkbox" name="category_ids[]" value="<?= $cat['id'] ?>"
                                       <?= in_array($cat['id'], $selectedCategories) ? 'checked' : '' ?>>
                                <span><?= htmlspecialchars($cat['name']) ?></span>
                            </label>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary">💾 Sauvegarder</button>
            <a href="/main/back/pages/articles.php" class="btn btn-secondary">Annuler</a>
        </div>
    </form>
</main>

</body>
</html>
