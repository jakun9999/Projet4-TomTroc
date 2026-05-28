<?php

declare(strict_types=1);

namespace Ml\App\Services;

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
}
