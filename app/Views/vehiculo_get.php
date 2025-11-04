<?php

use App\Models\Coche;
use App\Models\Moto;
?><!doctype html>
<html lang="es">
    <head>
        <meta charset="utf-8" />
        <title>Vehículo <?= htmlspecialchars((string)$veh->getId(), ENT_QUOTES, 'UTF-8') ?></title>
    </head>
    <body>
        <h1>Vehículo <?= $veh->getId() ?></h1>
        <ul>
            <li><strong>Marca:</strong> <?= htmlspecialchars($veh->getMarca(), ENT_QUOTES, 'UTF-8') ?></li>
            <li><strong>Modelo:</strong> <?= htmlspecialchars($veh->getModelo(), ENT_QUOTES, 'UTF-8') ?></li>
            <li><strong>Año:</strong> <?= $veh->getAnio() ?></li>
            <li><strong>Tipo:</strong> <?= htmlspecialchars($veh->getTipo(), ENT_QUOTES, 'UTF-8') ?></li>
            <?php if ($veh instanceof Coche): ?>
                <li><strong>Puertas:</strong> <?= $veh->getPuertas() ?></li>
            <?php elseif ($veh instanceof Moto): ?>
                <li><strong>Sidecar:</strong> <?= $veh->hasSidecar() ? 'Sí' : 'No' ?></li>
            <?php endif; ?>    
        </ul>

        <p><a href="/index.html">Volver al inicio</a></p>
    </body>
</html>