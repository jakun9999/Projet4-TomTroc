<?php

declare(strict_types=1);

namespace Ml\App\Services;

use Ml\App\Models\User;

/**
 * Class in charge of web services like
 * request calls from router, image upload.
 */
class Web
{
    /**
     * Provide visitor request for the router script. 
     * 
     * Return the visitor requested action or null.
     * 
     * @return string|null A string with the action 
     * to be managed by the router or null.
     */
    public static function getAction(): ?string
    {
        return $_REQUEST['action'] ?? null;
    }

    /**
     * Generate a CSRF token to secure a client side form
     * and avoid Cross-Site Request Forgery
     * 
     * @return string hidden html input field
     */
    public static function generateCsrfToken(): string
    {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        return '<input hidden aria-hidden="true" aria-label="CSRF Token" name="tok" value="' .
            $_SESSION['csrf_token'] . '">';
    }

    /**
     * Utility function to verify that both $_SESSION csrf token
     * and the submited form user token are equal.
     * 
     * @return bool true if tokens are equals, false if not
     */
    public static function controlCsrfToken(): bool
    {
        $knownToken = $_SESSION['csrf_token'] ?? '';
        $userToken = $_POST['tok'] ?? '';

        unset($_SESSION['csrf_token']);

        if ($knownToken === '' || $userToken === '') {
            return false;
        }

        if (!hash_equals($knownToken, $userToken)) {
            return false;
        } else {
            return true;
        }
    }

    public static function getSubscribeUserInfo(): ?User
    {
        if (isset($_POST['sub']) && $_POST['sub'] === 'subscribe') {
            $pseudo = $_POST['pseudo'] ?? '';
            return new User('', '', '');
        } else {
            return null;
        }
    }

    /**
     * Clean short text (like username, authors, title)
     * when it comes from POST requests.
     */
    public static function sanitizeShortString(?string $input): string
    {
        if ($input === null) {
            return '';
        }

        $output = trim($input);
        $output = str_replace(["\r", "\n", "\t"], '', $output);
        $output = mb_convert_encoding($output, 'UTF-8', 'UTF-8');

        return $output;
    }

    /**
     * Tests password security level.
     * 
     * @param string $password.
     * 
     * @return bool true if password is secure, false if not.
     */
    public static function isPasswordSecure(?string $password): bool
    {
        // Regex to check if a password is 8 char lenght mini,
        // has uppercase, lowercase, number, special chars.
        $regex = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&#_\-])[\s\S]{8,}$/';
        return (bool) preg_match($regex, $password);
    }

    /**
     * Manage upload image from user (profil pictures and book cover images).
     * 
     * @param array $file
     * 
     * @return ?string Returns the new name of the file or null.
     */
    public static function uploadImage(array $file): ?string
    {
        if (!$file || $file['error'] !== UPLOAD_ERR_OK) {
            return null;
        }

        // 5MB limited size
        if ($file['size'] > 5 * 1024 * 1024) {
            return null;
        }

        $allowedMimeTypes = [
            'image/jpeg' => 'jpg',
            'image/png'  => 'png',
            'image/gif'  => 'gif',
            'image/webp' => 'webp'
        ];

        $finfo = new \finfo(FILEINFO_MIME_TYPE);
        $realMimeType = $finfo->file($file['tmp_name']);

        if (!array_key_exists($realMimeType, $allowedMimeTypes)) {
            return null;
        }

        $extension = $allowedMimeTypes[$realMimeType];

        $timeStamp = (new \DateTime())->format('Ymd_His_v');
        $secureName = $timeStamp . '_' . bin2hex(random_bytes(16)) . '.' . $extension;
        $uploadDir = '/var/www/storage/uploads/';
        $destination = $uploadDir . $secureName;

        // We rewrite the image from its temp location to new location with
        // a random name and rewritten completely the image with GD PHP
        // extension to remove any malicious code embbeded in the image.
        switch ($realMimeType) {
            case 'image/jpeg':
                $imageSrc = \imagecreatefromjpeg($file['tmp_name']);
                if ($imageSrc) {
                    imagejpeg($imageSrc, $destination, 85); // Quality at 85
                }
                break;

            case 'image/png':
                $imageSrc = \imagecreatefrompng($file['tmp_name']);
                if ($imageSrc) {

                    \imagealphablending($imageSrc, false);
                    \imagesavealpha($imageSrc, true);
                    \imagepng($imageSrc, $destination, 6); // Quality at 6
                }
                break;

            case 'image/gif':
                $imageSrc = \imagecreatefromgif($file['tmp_name']);
                if ($imageSrc) {
                    \imagegif($imageSrc, $destination);
                }
                break;

            case 'image/webp':
                $imageSrc = \imagecreatefromwebp($file['tmp_name']);
                if ($imageSrc) {
                    \imagewebp($imageSrc, $destination, 80); // Quality at 80
                }
                break;
        }

        // delete temp file if it still exists
        if (\file_exists($file['tmp_name'])) {
            @unlink($file['tmp_name']);
        }

        if (!\file_exists($destination)) {
            return null;
        }

        return $secureName;
    }
}
