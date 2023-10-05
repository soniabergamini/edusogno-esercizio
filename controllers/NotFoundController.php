<?php
class NotFoundController {
    public function index($session) {
        ob_start();
        include 'partials/main-notfound.php';
        $content = ob_get_clean();
        return $content;
    }
}
?>