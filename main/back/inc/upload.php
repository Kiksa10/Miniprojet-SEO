<?php
/**
 * BackOffice — Endpoint pour l'upload d'images (TinyMCE)
 */
require_once __DIR__ . '/auth.php';

// Vérifier l'authentification
if (!isLoggedIn()) {
    header('HTTP/1.1 403 Forbidden');
    echo json_encode(['error' => 'Non autorisé']);
    exit;
}

// Dossier de destination pour les uploads
$uploadDir = __DIR__ . '/../assets/uploads/';

// Extensions autorisées
$allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];

if (isset($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK) {
    $fileTmpPath = $_FILES['file']['tmp_name'];
    $fileName = $_FILES['file']['name'];
    
    // Obtenir l'extension
    $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
    
    // Vérifier l'extension
    if (!in_array($fileExtension, $allowedExtensions)) {
        header('HTTP/1.1 400 Bad Request');
        echo json_encode(['error' => 'Extension de fichier non autorisée.']);
        exit;
    }
    
    // Créer un nom de fichier unique
    $newFileName = md5(time() . $fileName) . '.' . $fileExtension;
    $destPath = $uploadDir . $newFileName;
    
    // S'assurer que le dossier existe
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }
    
    if (move_uploaded_file($fileTmpPath, $destPath)) {
        // Retourner l'URL de l'image (chemin relatif depuis la racine du serveur web)
        $url = '/main/back/assets/uploads/' . $newFileName;
        echo json_encode(['location' => $url]);
        exit;
    } else {
        header('HTTP/1.1 500 Internal Server Error');
        echo json_encode(['error' => 'Erreur lors de la sauvegarde du fichier.']);
        exit;
    }
} else {
    header('HTTP/1.1 400 Bad Request');
    $errorMessage = isset($_FILES['file']['error']) ? 'Erreur code: ' . $_FILES['file']['error'] : 'Aucun fichier reçu.';
    echo json_encode(['error' => $errorMessage]);
    exit;
}
