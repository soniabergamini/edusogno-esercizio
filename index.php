<?php
session_start();
$_SESSION['login'] = $_SESSION['login'] ?? false;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="./assets/img/favicon.ico">
    <!-- Google Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:opsz,wght@9..40,400;9..40,700&display=swap" rel="stylesheet">
    <!-- Style CSS -->
    <link rel="stylesheet" href="./assets/styles/helpers.css">
    <link rel="stylesheet" href="./assets/styles/style.css">
    <!-- Title -->
    <title>Edusogno</title>
</head>

<body>
    <?php require_once 'partials/header.php'; ?>
    <main>
        <div id="backgroundSec" class="w100 posAbsolute zIndex1 h100">
            <img src="./assets/img/Ellipse 13.png" alt="background-img1" class="mw100 posAbsolute zIndex5 ycenter">
            <img src="./assets/img/Ellipse 12.png" alt="background-img2" class="mw100 posAbsolute ycenter zIndex5 r5">
            <img src="./assets/img/Group 201.png" alt="background-img3" class="mw100 posAbsolute r15 zIndex4 shuttle">
            <img src="./assets/img/Vector 5.png" alt="background-img4" class="mw100 posAbsolute b10 zIndex1">
            <img src="./assets/img/Vector 4.png" alt="background-img5" class="mw100 posAbsolute b0 zIndex2">
            <img src="./assets/img/Vector 1.png" alt="background-img6" class="mw100 posAbsolute b0 zIndex3">
        </div>
        <div id="contentSec" class="dFlex flexJustyCtr w100 h100 posRelative zIndex10 yscroll">
            <?php $_SESSION['login'] ? include_once 'partials/main-dashboard.php' : include_once 'partials/main-login.php'; ?>
        </div>
    </main>
</body>

</html>