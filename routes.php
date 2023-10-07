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
    '/reset-password' => ['AuthController', 'resetPassword'],
    '/new-password' => ['AuthController', 'newPassword'],
    '/new-password-process' => ['AuthController', 'newPasswordProcess'],
    '/event-destroy' => ['EventController', 'destroyEvent'],
];
?>