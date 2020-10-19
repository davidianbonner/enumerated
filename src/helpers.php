<?php

declare(strict_types=1);

use DavidIanBonner\Enumerated\Enum;

if (!function_exists('enum_if')) {
    function enum_if($data, string $className, $default = null): ?Enum
    {
        return $data ? new $className($data) : $default;
    }
}
