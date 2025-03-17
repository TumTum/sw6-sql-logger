<?php

declare(strict_types=1);

namespace tm\sw6\sql\logger\Ray\Payload;

use Spatie\Ray\Origin\DefaultOriginFactory;
use Spatie\Ray\Payloads\Payload;
use tm\sw6\sql\logger\Ray\Origin\ShopwareOriginFactory;

class DoctrinePayload extends Payload
{
    public static $originFactoryClass = ShopwareOriginFactory::class;

    public function __construct(
        private string $sql,
        private array $bindings,
        private float $time,
        private string $connection_name = 'mysql'
    ) {}

    public function getType(): string
    {
        return 'executed_query';
    }

    public function getContent(): array
    {
        return [
            'sql' => $this->sql,
            'bindings' => $this->bindings,
            'time' => $this->time,
            'connection_name' => $this->connection_name,
        ];
    }
}
