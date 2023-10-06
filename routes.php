<?php 
$routes = [
    '/' => ['AuthController', 'login'],
    '/login' => ['AuthController', 'login'],
    '/logout' => ['AuthController', 'logout'],
    '/register' => ['AuthController', 'register'],
    '/dashboard' => ['DashboardController', 'index'],
    '/404' => ['NotFoundController', 'index'],
    '/loginProcess' => ['AuthController', 'loginProcess'],
    '/registerProcess' => ['AuthController', 'registerProcess'],
    '/reset-password' => ['AuthController', 'resetPassword']
];
?>