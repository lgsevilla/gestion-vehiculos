<?php
declare(strict_types= 1);

namespace App\Controllers;

use App\Models\Vehiculo;
use App\Models\Coche;
use App\Models\Moto;

class VehicleController {
    
    public function store(array $vehiculoData): ?Vehiculo{
        
        return null;       
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
    
    private function leerVehiculos(): array 
    {
        require_once __DIR__ . '/../Data/vehiculos_bbdd.php';
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