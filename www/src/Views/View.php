<?php

declare(strict_types=1);

namespace Ml\App\Views;

use Exception;

class View
{
    private string $title;

    public function __construct(string $title)
    {
        $this->title = $title;
    }

    public function render(string $template, array $params = [])
    {
        $title = $this->title;

        $content = $this->generateContent($template, $params);

        ob_start();
        require TEMPLATE_MAIN_PATH;
        echo ob_get_clean();
    }

    public function generateContent(string $template, array $params = []): string
    {
        $templateFile = TEMPLATE_PATH . $template . '.php';

        if (file_exists($templateFile)) {
            ob_start();
            require $templateFile;
            return ob_get_clean();
        } else {
            throw new Exception("Page '$template' introuvable : '$templateFile'");
        }
    }
}
