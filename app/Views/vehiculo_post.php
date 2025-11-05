<?php

use App\Models\Coche;
use App\Models\Moto;
?><!doctype html>
<html lang="es">
    <head>
        <meta charset="utf-8" />
        <title>Vehículos (POST)</title>
    </head>
    <body>
        <h1>Vehículos Guardados</h1>
        <ul>
            <?php foreach ($vehiculos as $v): ?>
                <li>
                    <?= $v->getId(); ?>
                    <?= htmlspecialchars($v->getMarca(), ENT_QUOTES, 'UTF-8'); ?>
                    <?= htmlspecialchars($v->getModelo(), ENT_QUOTES, 'UTF-8'); ?>
                    (<?= $v->getAnio(); ?>, <?= htmlspecialchars($v->getTipo(), ENT_QUOTES, 'UTF-8'); ?>)
                    <?php if ($v instanceof Coche): ?>
                        Puertas: <?= $v->getPuertas(); ?>
                    <?php elseif ($v instanceof Moto): ?>
                        Sidecar: <?= $v->hasSidecar() ? 'Sí':'No'; ?>
                    <?php endif; ?>
                </li>
            <?php endforeach; ?>
        </ul>
    </body>
</html>