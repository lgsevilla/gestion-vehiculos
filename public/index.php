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

    $controller = new VehicleController();

    // si el metodo es GET
    if ($method === 'GET') {
        // test to see if can add feat to show all and not just 1 entry
        if (isset($_GET['show']) && $_GET['show'] === 'all') {
            $vehiculos = $controller->leerVehiculos();
            require __DIR__ . '/../app/Views/vehiculo_post.php';
            exit;
        }

        $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

        if ($id > 0) {
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

    // si el metodo es POST
    if ($method === 'POST') {
        $raw = $_POST['jsonPost'] ?? '';
        if ($raw === '') {
            http_response_code(400);
            echo "<p>No se ha recibido ningún JSON. <a href='/index.html'>Volver al inicio</a></p>";
            exit;
        }

        $data = json_decode($raw, true);
        if (is_array($data) && isset($data['tipo'])) {
            $controller->store($data);

            header('Location: /index.php?show=all');
            exit;
        }

        $manyData = preg_split('/\R+/', $raw);
        $storedAny = false;

        foreach ($manyData as $data) {
            $data = trim($data);
            if ($data === '' || str_starts_with($data, '//')) continue;

            $obj = json_decode($data, true);
            if (is_array($obj) && isset($obj['tipo'])) {
                $controller->store($obj);
                $storedAny = true;
            }
        }

        if (!$storedAny) {
            http_response_code(400);
            echo "<p>JSON inválido. Pega un objeto JSON o varios. <a href='/index.html'>Volver al inicio</a></p>";
            exit;
        }

        header('Location: /index.php?show=all');
        exit;
    }

    http_response_code(405);
    echo "Método no permitido";
}

request();