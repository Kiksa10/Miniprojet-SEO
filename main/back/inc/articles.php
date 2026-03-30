<?php
/**
 * Fonctions CRUD pour les articles (BackOffice)
 */

require_once __DIR__ . '/db.php';

/**
 * Récupère tous les articles (triés par date décroissante)
 */
function getAllArticles(): array {
    $pdo = getDbConnection();
    $stmt = $pdo->query("SELECT * FROM articles ORDER BY created_at DESC");
    return $stmt->fetchAll();
}

/**
 * Récupère les articles publiés uniquement
 */
function getPublishedArticles(): array {
    $pdo = getDbConnection();
    $stmt = $pdo->query("SELECT * FROM articles WHERE status = 'PUBLISHED' ORDER BY created_at DESC");
    return $stmt->fetchAll();
}

/**
 * Récupère un article par son ID
 */
function getArticleById(int $id): ?array {
    $pdo = getDbConnection();
    $stmt = $pdo->prepare("SELECT * FROM articles WHERE id = :id");
    $stmt->execute(['id' => $id]);
    $article = $stmt->fetch();
    return $article ?: null;
}

/**
 * Crée un nouvel article
 */
function createArticle(array $data): int {
    $pdo = getDbConnection();
    $stmt = $pdo->prepare("
        INSERT INTO articles (title, content, meta_title, meta_description, status, image_url, created_at, updated_at)
        VALUES (:title, :content, :meta_title, :meta_description, :status, :image_url, NOW(), NOW())
    ");
    $stmt->execute([
        'title' => $data['title'],
        'content' => $data['content'],
        'meta_title' => $data['meta_title'] ?? null,
        'meta_description' => $data['meta_description'] ?? null,
        'status' => $data['status'] ?? 'DRAFT',
        'image_url' => $data['image_url'] ?? null,
    ]);
    return (int) $pdo->lastInsertId();
}

/**
 * Met à jour un article existant
 */
function updateArticle(int $id, array $data): void {
    $pdo = getDbConnection();
    $stmt = $pdo->prepare("
        UPDATE articles SET
            title = :title,
            content = :content,
            meta_title = :meta_title,
            meta_description = :meta_description,
            status = :status,
            image_url = :image_url,
            updated_at = NOW()
        WHERE id = :id
    ");
    $stmt->execute([
        'id' => $id,
        'title' => $data['title'],
        'content' => $data['content'],
        'meta_title' => $data['meta_title'] ?? null,
        'meta_description' => $data['meta_description'] ?? null,
        'status' => $data['status'] ?? 'DRAFT',
        'image_url' => $data['image_url'] ?? null,
    ]);
}

/**
 * Supprime un article
 */
function deleteArticle(int $id): void {
    $pdo = getDbConnection();
    $stmt = $pdo->prepare("DELETE FROM articles WHERE id = :id");
    $stmt->execute(['id' => $id]);
}

/**
 * Publie un article
 */
function publishArticle(int $id): void {
    $pdo = getDbConnection();
    $stmt = $pdo->prepare("UPDATE articles SET status = 'PUBLISHED', updated_at = NOW() WHERE id = :id");
    $stmt->execute(['id' => $id]);
}

/**
 * Dépublie un article
 */
function unpublishArticle(int $id): void {
    $pdo = getDbConnection();
    $stmt = $pdo->prepare("UPDATE articles SET status = 'DRAFT', updated_at = NOW() WHERE id = :id");
    $stmt->execute(['id' => $id]);
}

/**
 * Incrémente le compteur de vues
 */
function incrementViewCount(int $id): void {
    $pdo = getDbConnection();
    $stmt = $pdo->prepare("UPDATE articles SET view_count = view_count + 1 WHERE id = :id");
    $stmt->execute(['id' => $id]);
}

/**
 * Récupère les catégories d'un article
 */
function getArticleCategories(int $articleId): array {
    $pdo = getDbConnection();
    $stmt = $pdo->prepare("
        SELECT c.* FROM categories c
        INNER JOIN article_categories ac ON c.id = ac.category_id
        WHERE ac.article_id = :article_id
    ");
    $stmt->execute(['article_id' => $articleId]);
    return $stmt->fetchAll();
}

/**
 * Met à jour les catégories d'un article
 */
function updateArticleCategories(int $articleId, array $categoryIds): void {
    $pdo = getDbConnection();
    // Supprimer les anciennes liaisons
    $stmt = $pdo->prepare("DELETE FROM article_categories WHERE article_id = :article_id");
    $stmt->execute(['article_id' => $articleId]);
    // Ajouter les nouvelles
    $stmt = $pdo->prepare("INSERT INTO article_categories (article_id, category_id) VALUES (:article_id, :category_id)");
    foreach ($categoryIds as $catId) {
        $stmt->execute(['article_id' => $articleId, 'category_id' => (int)$catId]);
    }
}

/**
 * Compteurs pour le dashboard
 */
function countArticles(): int {
    $pdo = getDbConnection();
    return (int) $pdo->query("SELECT COUNT(*) FROM articles")->fetchColumn();
}

function countPublishedArticles(): int {
    $pdo = getDbConnection();
    return (int) $pdo->query("SELECT COUNT(*) FROM articles WHERE status = 'PUBLISHED'")->fetchColumn();
}

function countDraftArticles(): int {
    $pdo = getDbConnection();
    return (int) $pdo->query("SELECT COUNT(*) FROM articles WHERE status = 'DRAFT'")->fetchColumn();
}
