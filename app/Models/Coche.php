<?php
declare(strict_types=1);

namespace App\Models;

class Coche extends Vehiculo
{
    public function __construct(
        int $id,
        string $marca,
        string $modelo,
        int $anio,
        string $tipo,
        protected int $puertas
    ) {
        parent::__construct($id, $marca, $modelo,$anio, $tipo);
    }

    public function getPuertas(): int
    {
        return $this->puertas;
    }

    public function jsonSerialized(): mixed
    {
        return parent::jsonSerialize() + ['puertas' => $this->puertas];
    }
}