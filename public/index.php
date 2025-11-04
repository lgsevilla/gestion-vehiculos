<?php
declare(strict_types=1);

require __DIR__ . "/../vendor/autoload.php";

use App\Controllers\VehicleController;


function request(): void
{
    $method = $_SERVER['REQUEST_METHOD'] ?? 'GET';
    $uri = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH);

    if ($uri === '/' || $uri === '') {
        header('Location: /index.html');
        exit;
    }

    if ($method === 'GET') {
        $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

        if ($id > 0) {
            $controller = new VehicleController();
            $veh = $controller->getById($id);

            if ($veh) {
                require __DIR__ . '/../app/Views/vehiculo_get.php';
                exit;
            } else {
                http_response_code(404);
                echo "<p>Vehículo con ID {$id} no encontrado. <a href='/index.html'>Volver al inicio</a></p>";
                exit;
            }
        }

        echo "<p>Introduce un ID y pulsa Buscar. <a href='/index.html'>Volver</a></p>";
        exit;
    }

    http_response_code(405);
    echo "Método no permitido";
}

request();