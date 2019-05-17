<?php
require($_SERVER['DOCUMENT_ROOT']."/m/Auth.php");
if (!Auth::isAuthenticated()) {
    $action = isset($_POST['action']) ? $_POST['action'] : 'login';
    if ($action == 'login') {
        Auth::logout();
        include($_SERVER['DOCUMENT_ROOT'].'/v/layout/out.php');
    } else {
        header('Location: /v/users');
        exit;
    }
} else {
    if (strpos($_SERVER['REQUEST_URI'], '/v/') === 0) {
        include($_SERVER['DOCUMENT_ROOT'].'/v/layout/in.php');
    } else {
        Auth::logout();
        header('Location: /v/users');
        exit;
    }
}