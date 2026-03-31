<?php
/**
 * Fonctions d'authentification pour le BackOffice
 */

require_once __DIR__ . '/db.php';

/**
 * Démarre la session si pas déjà active
 */
function startSession(): void {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
}

/**
 * Vérifie les identifiants et connecte l'utilisateur
 */
function loginUser(string $username, string $password): bool {
    $pdo = getDbConnection();
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username");
    $stmt->execute(['username' => $username]);
    $user = $stmt->fetch();

    if ($user && $password == $user['password']) {
        startSession();
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'];
        $_SESSION['logged_in'] = true;
        return true;
    }
    return false;
}

/**
 * Vérifie si l'utilisateur est connecté
 */
function isLoggedIn(): bool {
    startSession();
    return isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true;
}

/**
 * Protège une page admin — redirige vers login si non connecté
 */
function requireAuth(): void {
    if (!isLoggedIn()) {
        header('Location: /main/admin');
        exit;
    }
}

/**
 * Déconnecte l'utilisateur
 */
function logoutUser(): void {
    startSession();
    session_unset();
    session_destroy();
    header('Location: /main/admin');
    exit;
}
