<?php

declare(strict_types=1);

namespace Ml\App\Views;

use Exception;

/**
 * Class View to handle the rendering of templates 
 * and the main layout of the application.
 */
class View
{
    private string $title;

    public function __construct(string $title)
    {
        $this->title = $title;
    }

    /**
     * Renders the main layout with the specified template 
     * and parameters.
     * 
     * $template is the name of the template file (without .php extension)
     * but it is also used in main.php template to set the active menu item, 
     * so it should be consistent with the menu item names.
     *
     * @param string $template The template to render.
     * @param array $params The parameters to pass to the template.
     */
    public function render(string $template, array $params = [])
    {
        $title = $this->title;
        $content = $this->generateContent($template, $params);
        ob_start();
        require TEMPLATE_MAIN_PATH;
        echo ob_get_clean();
    }

    /**
     * Generate the content of the page to be included in main.php template.
     * 
     * @param string $template     
     * @param array $params Set of params which will be used in the template.
     * 
     * @return string Returns the content to be loaded between the header 
     * and footer provided by main.php.
     */
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
