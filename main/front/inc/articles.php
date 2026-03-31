<?php
/**
 * Fonctions pour l'affichage des articles (FrontOffice)
 */

require_once __DIR__ . '/../../back/inc/db.php';

/**
 * Récupère les articles publiés avec pagination
 */
function getFrontArticles(int $limit = 6, int $offset = 0): array {
    $pdo = getDbConnection();
    // PostgreSQL utilise LIMIT et OFFSET
    $stmt = $pdo->prepare("SELECT * FROM articles WHERE status = 'PUBLISHED' ORDER BY created_at DESC LIMIT :limit OFFSET :offset");
    $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll();
}

/**
 * Compte le nombre total d'articles publiés pour la pagination
 */
function countFrontArticles(): int {
    $pdo = getDbConnection();
    $stmt = $pdo->query("SELECT COUNT(*) FROM articles WHERE status = 'PUBLISHED'");
    return (int) $stmt->fetchColumn();
}

/**
 * Récupère un article publié par son ID
 */
function getFrontArticleById(int $id): ?array {
    $pdo = getDbConnection();
    $stmt = $pdo->prepare("SELECT * FROM articles WHERE id = :id AND status = 'PUBLISHED'");
    $stmt->execute(['id' => $id]);
    $article = $stmt->fetch();
    return $article ?: null;
}

/**
 * Incrémente le compteur de vues d'un article
 */
function incrementFrontViewCount(int $id): void {
    $pdo = getDbConnection();
    $stmt = $pdo->prepare("UPDATE articles SET view_count = view_count + 1 WHERE id = :id");
    $stmt->execute(['id' => $id]);
}

/**
 * Récupère les catégories d'un article pour l'affichage
 */
function getFrontArticleCategories(int $articleId): array {
    $pdo = getDbConnection();
    $stmt = $pdo->prepare("
        SELECT c.* FROM categories c
        INNER JOIN article_categories ac ON c.id = ac.category_id
        WHERE ac.article_id = :article_id
    ");
    $stmt->execute(['article_id' => $articleId]);
    return $stmt->fetchAll();
}
