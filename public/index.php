<?php
declare(strict_types=1);

require __DIR__ . "/../vendor/autoload.php";

use App\Controllers\VehicleController;
function request(): void
{
    $method = $_SERVER['REQUEST_METHOD'] ?? 'GET';
}

request();
