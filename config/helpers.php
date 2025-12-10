<?php
// Helper tạo URL dựa trên tên route (kiểu Laravel đơn giản)
function route(string $name, array $params = []): string
{
    static $routes = null;
    if ($routes === null) {
        $routes = include __DIR__ . '/routes.php';
    }
    if (!isset($routes[$name])) {
        return '#';
    }
    // Dựa vào tên route (vd: user.index) để sinh controller=user, action=index
    [$ctrl, $act] = explode('.', $name, 2);
    $query = array_merge(
        ['controller' => $ctrl, 'action' => $act],
        $params
    );
    return 'index.php?' . http_build_query($query);
}
?>