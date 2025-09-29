<?php
// controllers/DashboardController.php
require_once __DIR__ . '/Controller.php';

class DashboardController extends Controller {
    public function index() {
        if (!$this->isLoggedIn()) {
            $this->redirect('auth/login');
            return;
        }
        
        $data = [
            'username' => $_SESSION['username'],
            'success' => $_GET['success'] ?? null
        ];
        
        $this->view('dashboard/index', $data);
    }
}
?>