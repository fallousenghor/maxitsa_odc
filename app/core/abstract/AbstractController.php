<?php
namespace Maxitsa\Abstract;
session_start();
abstract class AbstractController{

  
    protected function makeEntity(string $class, array $data): object {
        if (method_exists($class, 'toObject')) {
            return $class::toObject($data);
        }
        return new $class(...array_values($data));
    }
    
    protected string $layout = 'layout.php';

    protected function renderHtml(string $view, array $params = [], ?string $title = null) {
        extract($params);
        ob_start();
        require dirname(__DIR__, 3) . '/templates/' . $view;
        $content = ob_get_clean();
        if ($title !== null) {
            $GLOBALS['title'] = $title;
        }
        require dirname(__DIR__, 3) . '/templates/layout/' . $this->layout;
    }

    abstract public function create();

     public function checkAuth() {
        $user = $_SESSION['user'] ?? null;
        if (!$user) {
            redirect('login');
            return false;
        }
        return $user;
    }
}
