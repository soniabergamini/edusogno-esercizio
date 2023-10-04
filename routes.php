<?php 
$routes = [
    '/' => ['AuthController', 'login'],
    '/login' => ['AuthController', 'login'],
    '/register' => ['AuthController', 'register'],
    '/dashboard' => ['DashboardController', 'index']
];
?>