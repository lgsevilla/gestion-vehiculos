<?php
declare(strict_types=1);

namespace App\Models;

class Moto extends Vehiculo
{
    public function __construct(
        int $id,
        string $marca,
        string $modelo,
        int $anio,
        string $tipo,
        protected bool $sidecar
    ) {
        parent::__construct($id, $marca, $modelo, $anio, $tipo);
    }

    public function hasSidecar(): bool
    {
        return $this->sidecar;
    }

    public function jsonSerialize(): mixed
    {
        return parent::jsonSerialize() + ['sidecar' => $this->sidecar];
    }
}