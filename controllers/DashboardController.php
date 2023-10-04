<?php
class DashboardController {
    public function index() {
        return file_get_contents('partials/main-dashboard.php');
    }
}
?>