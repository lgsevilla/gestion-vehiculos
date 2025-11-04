<?php
declare(strict_types=1);

namespace App\Models;

abstract class Vehiculo implements \JsonSerializable
{
    public function __construct(
        protected int $id,
        protected string $marca,
        protected string $modelo,
        protected int $anio,
        protected string $tipo
    ) {}

    public function getId(): int { return $this->id; }
    public function getMarca(): string { return $this->marca; }
    public function getModelo(): string { return $this->modelo; }
    public function getAnio(): int { return $this->anio; }
    public function getTipo(): string { return $this->tipo; }

    public function jsonSerialize(): mixed
    {
        return [
            'id' => $this->id,
            'marca' => $this->marca,
            'modelo' => $this->modelo,
            'anio' => $this->anio,
            'tipo' => $this->tipo
        ];
    }
}