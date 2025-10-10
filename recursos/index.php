<?php
declare(strict_types=1);

function request(): void
{
    $method = $_SERVER['REQUEST_METHOD'] ?? 'GET';
}

request();
