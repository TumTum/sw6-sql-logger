<?php

declare(strict_types=1);

namespace tm\sw6\sql\logger\Ray\Macro;

use tm\sw6\sql\logger\ShopwareConnectionConfiguration;

class Macro
{
    public function showQueries(callable|null $callback = null): mixed
    {
        ShopwareConnectionConfiguration::enableLogger(['useRayDumper' => true]);

        if (is_callable($callback)) {
            $result = $callback($this);
            ShopwareConnectionConfiguration::disableLogger();
            if ($result) {
                return $result;
            }
        }

        return null;
    }

    public function stopShowingQueries(): void
    {
        ShopwareConnectionConfiguration::disableLogger();
    }
}
