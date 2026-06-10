<?php
// usage example : serve_image.php?name=le_nom_genere.jpg
$name = $_GET['name'] ?? '';

// Security : To avoid navigation in other folders.
$name = basename($name);

$uploadDir = '/var/www/storage/uploads/';
$filePath = $uploadDir . $name;

if (!empty($name) && file_exists($filePath)) {
    $finfo = new finfo(FILEINFO_MIME_TYPE);
    $mimeType = $finfo->file($filePath);

    // Authorized file extensions
    $allowed = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];

    if (in_array($mimeType, $allowed)) {
        // Important security headers
        header("Content-Type: " . $mimeType);
        header("X-Content-Type-Options: nosniff"); // Avoid browser sniffing on types
        header("Content-Length: " . filesize($filePath));

        // Read and display the image.
        readfile($filePath);
        exit;
    }
}

// If file not found, returns a 404 error.
http_response_code(404);
echo "Image non trouvée.";
