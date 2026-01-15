<?php
// Router tối giản tách riêng để dễ bảo trì / giải thích

// Start session nếu chưa có
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function dispatch()
{
    $controller = $_GET['controller'] ?? null;
    if (!$controller) {
        return false; // Không có controller -> tiếp tục load trang chủ
    }

    $action = $_GET['action'] ?? 'index';
    $controllerClass = ucfirst($controller) . 'Controller';
    $controllerFile = __DIR__ . '/../src/controllers/' . $controllerClass . '.php';

    if (!is_file($controllerFile)) {
        http_response_code(404);
        echo 'Route not found';
        exit;
    }

    require_once $controllerFile;
    $ctrl = new $controllerClass();

    if (!method_exists($ctrl, $action)) {
        http_response_code(404);
        echo 'Route not found';
        exit;
    }

    $ctrl->$action();
    return true;
}
