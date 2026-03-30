<?php
/**
 * Fonctions CRUD pour les catégories (BackOffice)
 */

require_once __DIR__ . '/db.php';

/**
 * Récupère toutes les catégories
 */
function getAllCategories(): array {
    $pdo = getDbConnection();
    $stmt = $pdo->query("SELECT * FROM categories ORDER BY name ASC");
    return $stmt->fetchAll();
}

/**
 * Récupère une catégorie par son ID
 */
function getCategoryById(int $id): ?array {
    $pdo = getDbConnection();
    $stmt = $pdo->prepare("SELECT * FROM categories WHERE id = :id");
    $stmt->execute(['id' => $id]);
    $cat = $stmt->fetch();
    return $cat ?: null;
}

/**
 * Crée une catégorie
 */
function createCategory(string $name, ?string $description = null): int {
    $pdo = getDbConnection();
    $stmt = $pdo->prepare("INSERT INTO categories (name, description) VALUES (:name, :description)");
    $stmt->execute(['name' => $name, 'description' => $description]);
    return (int) $pdo->lastInsertId();
}

/**
 * Met à jour une catégorie
 */
function updateCategory(int $id, string $name, ?string $description = null): void {
    $pdo = getDbConnection();
    $stmt = $pdo->prepare("UPDATE categories SET name = :name, description = :description WHERE id = :id");
    $stmt->execute(['id' => $id, 'name' => $name, 'description' => $description]);
}

/**
 * Supprime une catégorie
 */
function deleteCategory(int $id): void {
    $pdo = getDbConnection();
    $stmt = $pdo->prepare("DELETE FROM article_categories WHERE category_id = :id");
    $stmt->execute(['id' => $id]);
    $stmt = $pdo->prepare("DELETE FROM categories WHERE id = :id");
    $stmt->execute(['id' => $id]);
}

/**
 * Compte les catégories
 */
function countCategories(): int {
    $pdo = getDbConnection();
    return (int) $pdo->query("SELECT COUNT(*) FROM categories")->fetchColumn();
}
