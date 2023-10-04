<?php
class NotFoundController {
    public function index() {
        return file_get_contents('partials/main-notfound.php');
    }
}
?>