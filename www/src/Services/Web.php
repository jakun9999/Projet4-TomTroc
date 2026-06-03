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
        return '<input hidden name="tok" value="' . $_SESSION['csrf_token'] . '">';
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
        $output = htmlspecialchars($output, ENT_QUOTES, 'UTF-8');

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
}
