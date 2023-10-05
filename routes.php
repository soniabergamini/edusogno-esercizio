<?php 
$routes = [
    '/' => ['AuthController', 'login'],
    '/login' => ['AuthController', 'login'],
    '/register' => ['AuthController', 'register'],
    '/dashboard' => ['DashboardController', 'index'],
    '/404' => ['NotFoundController', 'index'],
    '/loginProcess' => ['AuthController', 'loginProcess']
];
?>