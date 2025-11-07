<?php
declare(strict_types= 1);

namespace App\Controllers;

use App\Models\Vehiculo;
use App\Models\Coche;
use App\Models\Moto;

class VehicleController {
    
    private function dataPath(): string
    {
        if (getenv('RAILWAY_ENVIRONMENT') || getenv('RAILWAY_PROJECT_ID')) {
            return rtrim(sys_get_temp_dir(), '/') . '/vehiculos_bbdd.php';
        }

        return __DIR__ . '/../Data/vehiculos_bbdd.php';
    }
    public function store(array $vehiculoData): ?Vehiculo
    {
        static $rows = null;

        $tipo = strtolower((string)($vehiculoData['tipo'] ?? ''));
        $id = (int)($vehiculoData['id'] ?? 0);
        $marca = (string)($vehiculoData['marca'] ?? '');
        $modelo = (string)($vehiculoData['modelo'] ?? '');
        $anio = (int)($vehiculoData['anio'] ?? 0);

        if (!$id || !$tipo || !$marca || !$modelo || !$anio) {
            return null;
        }

        if ($tipo === 'coche') {
            if (!isset($vehiculoData['puertas'])) return null;
            $veh = new Coche($id, $marca, $modelo, $anio, 'coche', (int)$vehiculoData['puertas']);
            $row = [
                'id' => $id,
                'marca' => $marca,
                'modelo' => $modelo,
                'anio' => $anio,
                'tipo' => 'coche',
                'puertas' => (int)$vehiculoData['puertas'],
            ];
        } elseif ($tipo === 'moto') {
            if (!array_key_exists('sidecar', $vehiculoData)) return null;
            $veh = new Moto($id, $marca, $modelo, $anio, 'moto', (bool)$vehiculoData['sidecar']);
            $row = [
                'id' => $id,
                'marca' => $marca,
                'modelo' => $modelo,
                'anio' => $anio,
                'tipo' => 'moto',
                'sidecar' => (bool)$vehiculoData['sidecar'],
            ];
        } else {
            return null;
        }

        if ($rows === null) {
            $path = $this->dataPath();
            
            if (file_exists($path)) {
                include $path;
                $rows = defined('VEHICULOS') ? VEHICULOS : [];
            } else {
                include __DIR__ . '/../Data/vehiculos_bbdd.php';
                $rows = defined('VEHICULOS') ? VEHICULOS : [];
            }
            
        }

        foreach ($rows as $existing) {
            if ((int)($existing['id'] ?? 0) === $id) {
                return $veh;
            }
        }

        $rows[] = $row;

        $export = var_export($rows, true);
        $content = <<<PHP
        <?php
        define('VEHICULOS',
        $export
        );
        ?>
        PHP;

        $path = $this->dataPath();
        $bytes = file_put_contents($path, $content, LOCK_EX);
        if ($bytes === false) {
            throw new \RuntimeException("No se pudo escribir $path");
        }

        return $veh;
    }

    public function getById(int $id): ?Vehiculo
    {
        if ($id <= 0) return null;

        foreach ($this->leerVehiculos() as $vehiculo) {
            if ($vehiculo->getId() === $id) {
                return $vehiculo;
            }
        }

        return null;
    }
    
    public function leerVehiculos(): array 
    {

        $path = $this->dataPath();

        if(file_exists($path)) {
            include $path;
        } else {
            include __DIR__ . '/../Data/vehiculos_bbdd.php';
        }
        
        $rows = defined('VEHICULOS') ? VEHICULOS : [];

        $out = [];
        foreach ($rows as $r) {
            $id = (int)($r['id'] ?? 0);
            $marca = (string)($r['marca'] ?? '');
            $modelo = (string)($r['modelo'] ??'');
            $anio = (int)($r['anio'] ?? 0);
            $tipo = strtolower((string)($r['tipo'] ?? ''));

            if (!$id || !$marca || !$modelo || !$anio || !$tipo) {
                continue;
            }

            if ($tipo === 'coche' && isset($r['puertas'])) {
                $out[] = new Coche($id, $marca, $modelo, $anio, 'coche', (int)$r['puertas']);
            } elseif ($tipo === 'moto' && array_key_exists('sidecar', $r)) {
                $out[] = new Moto($id, $marca, $modelo, $anio, 'moto', (bool)$r['sidecar']);
            }
        }

        return $out;
    }
}