<?php
// controllers/Controller.php
class Controller {
    protected $viewPath;
    
    public function __construct() {
        $this->viewPath = __DIR__ . '/../views/';
    }
    
    protected function view($view, $data = []) {
        $viewFile = $this->viewPath . $view . '.php';
        if (file_exists($viewFile)) {
            // Sanitize data to prevent variable extraction vulnerabilities
            $safeData = [];
            foreach ($data as $key => $value) {
                if (is_string($key) && preg_match('/^[a-zA-Z_][a-zA-Z0-9_]*$/', $key)) {
                    $safeData[$key] = $value;
                }
            }
            extract($safeData);
            
            // Capture the view content
            ob_start();
            require_once $viewFile;
            $content = ob_get_clean();
            
            require_once $this->viewPath . 'layouts/main.php';
        } else {
            throw new Exception("Vista no encontrada: {$viewFile}");
        }
    }
    
    protected function redirect($url) {
        header('Location: ' . BASE_URL . '/' . $url);
        exit;
    }
    
    protected function isLoggedIn() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        return isset($_SESSION['user_logged_in']) && $_SESSION['user_logged_in'] === true;
    }
    
    protected function hasRole($roleName) {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        return isset($_SESSION['role']) && $_SESSION['role'] === $roleName;
    }
    
    protected function hasAnyRole($roleNames) {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        if (!isset($_SESSION['role'])) {
            return false;
        }
        return in_array($_SESSION['role'], $roleNames);
    }
    
    protected function requireRole($roleName, $redirect = 'auth/login') {
        if (!$this->hasRole($roleName)) {
            $this->redirect($redirect);
        }
    }
    
    protected function requireAnyRole($roleNames, $redirect = 'auth/login') {
        if (!$this->hasAnyRole($roleNames)) {
            $this->redirect($redirect);
        }
    }
}
?>