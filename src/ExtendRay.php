<?php

declare(strict_types=1);

namespace tm\sw6\sql\logger;

use Spatie\Ray\Ray;

use tm\sw6\sql\logger\Ray\Macro\Macro;
use tm\sw6\sql\logger\Ray\Payload\DoctrinePayload;
use function Sodium\randombytes_uniform;

class ExtendRay
{
    private static bool $isExtent = false;

    public static function init(): void
    {
        if (self::$isExtent) {
            return;
        }

        if (!class_exists(Ray::class)) {
            self::$isExtent = true;
            return;
        }

        \Spatie\Ray\Ray::macro('showQueries', function (callable|null $callback = null) {
            return (new Macro())->showQueries($callback) ?? $this;
        });

        \Spatie\Ray\Ray::macro('stopShowingQueries', function () {
            (new Macro())->stopShowingQueries();
            return $this;
        });
    }
}
