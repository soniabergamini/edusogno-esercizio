<?php
class AuthController {
    public function login() {
       return file_get_contents('partials/main-login.php');
    }

    public function register() {
        return file_get_contents('partials/main-register.php');
    }
}
?>