<?php
require_once __DIR__ . '/../config/helpers.php';
include __DIR__ . '/../src/views/partials/header.php';
include __DIR__ . '/../src/views/partials/menu.php';

$routes = include __DIR__ . '/../config/routes.php';
$controller = $_GET['controller'] ?? null;
$action = $_GET['action'] ?? null;

$routeKey = $controller && $action ? "$controller.$action" : null;
if ($routeKey && isset($routes[$routeKey])) {
    $route = $routes[$routeKey];
    $controllerName = $route['controller'];
    $actionName = $route['action'];
    require_once __DIR__ . '/../src/controllers/' . $controllerName . '.php';
    $controllerObj = new $controllerName();
    echo '<div class="container mt-4">';
    if ($actionName === 'show' && isset($_GET['id'])) {
        $controllerObj->$actionName((int) $_GET['id']);
    } else {
        $controllerObj->$actionName();
    }
    echo '</div>';
} else {
    require_once __DIR__ . '/../src/service/DestinationService.php';
    $service = new DestinationService();
    $destinations = $service->getAllWithUser();
    ?>
    <div class="container mt-4">
        <h2 class="mb-4">Danh sách địa điểm du lịch</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Tên địa điểm</th>
                    <th>Mô tả</th>
                    <th>Người tạo</th>
                    <th>Email</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($destinations as $i => $row): ?>
                    <tr>
                        <td><?= $i + 1 ?></td>
                        <td><?= htmlspecialchars($row['destination_name']) ?></td>
                        <td><?= htmlspecialchars($row['description']) ?></td>
                        <td><?= htmlspecialchars($row['user_name']) ?></td>
                        <td><?= htmlspecialchars($row['email']) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?php
}
include __DIR__ . '/../src/views/partials/footer.php';
?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="js/TrangChu.js"></script>