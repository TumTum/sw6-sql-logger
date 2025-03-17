<?php

declare(strict_types=1);

namespace tm\sw6\sql\logger;

use Shopware\Core\Framework\Uuid\Uuid;

class ShopwareParams
{
    public static function encode(?array $params): array
    {
        return array_map([self::class, 'lockup'], $params ?? []);
    }

    private static function lockup(mixed $data): mixed
    {
        if (is_string($data) && self::isBinary($data)) {
            return self::fromBytesToHex($data);
        }

        if (is_array($data)) {
            return self::encode($data);
        }

        return $data;
    }

    private static function fromBytesToHex(string $data): mixed
    {
        try {
            return Uuid::fromBytesToHex($data);
        } catch (\Throwable $e) {
            return $data;
        }
    }

    private static function isBinary(string $data): bool
    {
        return ! mb_check_encoding($data, 'UTF-8');
    }
}
