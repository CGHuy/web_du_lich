<?php
if (session_status() === PHP_SESSION_NONE)
    session_start();
// destroy session and redirect to home
$_SESSION = [];
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(
        session_name(),
        '',
        time() - 42000,
        $params['path'],
        $params['domain'],
        $params['secure'],
        $params['httponly']
    );
}
session_destroy();
// After logout redirect user to the login form
header('Location: /web_du_lich/public/login.php');
exit;
?>